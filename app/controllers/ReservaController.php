<?php
require_once __DIR__ . '/../middleware/AuthGuard.php';
require_once __DIR__ . '/../services/ReservaService.php';
require_once __DIR__ . '/../services/LocalService.php';
require_once __DIR__ . '/../services/EmailService.php';
require_once __DIR__ . '/../repositories/MoradorRepository.php';
require_once __DIR__ . '/../repositories/ReservaRepository.php';
require_once __DIR__ . '/../repositories/LocalRepository.php';

class ReservaController
{
    private const ITENS_POR_PAGINA = 10;
    private const ITENS_POR_PAGINA_HISTORICO = 10;

    private ReservaService $reservaService;
    private LocalService   $localService;

    public function __construct()
    {
        $this->reservaService = new ReservaService();
        $this->localService   = new LocalService();
    }

    public function index(): void
    {
        $usuario = $this->requireAcessoReservas();

        $locais      = $this->reservaService->listarLocaisDisponiveis();
        $podeGerenciarLocais = $this->ehSindicoOuAdmin($usuario);
        $locaisCadastrados   = $podeGerenciarLocais ? (new LocalRepository())->findTodos() : [];
        $visaoReservas       = $this->resolverVisao($podeGerenciarLocais);

        $reservasParaAprovar = [];
        $totalPaginas        = 0;
        $pagina              = 1;
        $filtrosReservas     = $this->extrairFiltrosReservas();
        if ($podeGerenciarLocais) {
            extract($this->montarPaginacaoPendentes($filtrosReservas), EXTR_OVERWRITE);
        }

        require_once __DIR__ . '/../../resources/views/reserva/index.php';
    }

    public function salvar(): void
    {
        $usuario = $this->requireAcessoReservas();
        AuthGuard::requerePost('/reserva');

        $podeGerenciarLocais = $this->ehSindicoOuAdmin($usuario);
        $resultado = $podeGerenciarLocais
            ? $this->localService->cadastrar($_POST, (int) $_SESSION['usuario_id'])
            : $this->reservaService->salvar($_POST, (int) $_SESSION['usuario_id']);

        if ($resultado['sucesso']) {
            $destino = $podeGerenciarLocais ? '/reserva?visao=locais&sucesso=1' : '/reserva?sucesso=1';
            $this->redirecionar($destino);
        }

        $_SESSION['erro_reserva'] = $resultado['mensagem'];
        $this->redirecionar('/reserva');
    }

    public function historico(): void
    {
        $usuario = $this->requireAcessoReservas();

        if ((int)($usuario['privilegio'] ?? 1) !== 1) {
            $this->redirecionar('/painel');
        }

        $filtrosHistorico = $this->extrairFiltrosHistorico();
        $pagina = max(1, (int)($_GET['pagina'] ?? 1));
        $porPagina = self::ITENS_POR_PAGINA_HISTORICO;
        $offset = ($pagina - 1) * $porPagina;
        $repo = new ReservaRepository();

        $totalHistorico = $repo->countHistoricoPorUsuario((int)$_SESSION['usuario_id'], $filtrosHistorico);
        $totalPaginas = (int)ceil($totalHistorico / $porPagina);
        $reservasHistorico = $repo->buscarHistoricoPorUsuario((int)$_SESSION['usuario_id'], $filtrosHistorico, $offset, $porPagina);

        require_once __DIR__ . '/../../resources/views/reserva/historico.php';
    }

    public function editarLocal(): void
    {
        AuthGuard::requerePost('/reserva');
        $this->requireSindicoOuAdmin();

        $resultado = $this->localService->atualizar($_POST, (int) $_SESSION['usuario_id']);

        if ($resultado['sucesso']) {
            $this->redirecionar('/reserva?visao=locais&local_atualizado=1');
        }

        $_SESSION['erro_reserva'] = $resultado['mensagem'];
        $this->redirecionar('/reserva');
    }

    public function decidir(): void{

        AuthGuard::requerePost('/reserva?visao=solicitacoes');
        $this->requireSindicoOuAdmin(); 

        $idReserva = (int)($_POST['id_reserva'] ?? 0);
        $acao      = $_POST['acao'] ?? null;

        if (!$idReserva || !$acao) {
            $this->redirecionar('/reserva');
        }

        $reservaRepo = new ReservaRepository();

        if ($acao === 'aceitar') {
            $reservaRepo->aprovar(
                $idReserva,
                (int)$_SESSION['usuario_id'],
                $_SESSION['usuario_nome']
            );
        } else {
            $reservaRepo->atualizarStatus($idReserva, 'N');
        }

        $totalConflitos = 0;
        $reserva = $reservaRepo->findById($idReserva);
        if ($reserva) {
            $totalConflitos = $this->notificarDecisao($reserva, $acao, $reservaRepo, $idReserva);
        }

        if ($acao === 'aceitar') {
            $msg = 'Reserva aprovada com sucesso!';
            if ($totalConflitos > 0) {
                $msg .= " {$totalConflitos} reserva(s) conflitante(s) foram canceladas automaticamente.";
            }
            $_SESSION['sucesso_reserva'] = $msg;
        } else {
            $_SESSION['sucesso_reserva'] = 'Reserva negada com sucesso!';
        }

        $this->redirecionar('/reserva?visao=solicitacoes');
    }    

    public function recusarVencidas(): void
    {
        AuthGuard::requerePost('/reserva?visao=solicitacoes');
        $this->requireSindicoOuAdmin();

        $total = (new ReservaRepository())->recusarPendentesAnteriores();
        $_SESSION['sucesso_reserva'] = $total > 0
            ? "{$total} reserva(s) pendente(s) vencida(s) foram recusadas."
            : 'Nenhuma reserva pendente vencida encontrada.';

        $this->redirecionar('/reserva?visao=solicitacoes');
    }


    private function montarPaginacaoPendentes(array $filtros): array{
        $pagina       = max(1, (int)($_GET['pagina'] ?? 1));
        $porPagina    = self::ITENS_POR_PAGINA;
        $repo         = new ReservaRepository();
        $total        = $repo->countPendentesComFiltros($filtros);
        $totalPaginas = (int)ceil($total / $porPagina);
        $offset       = ($pagina - 1) * $porPagina;

        return [
            'pagina'              => $pagina,        
            'totalPaginas'        => $totalPaginas,
            'reservasParaAprovar' => $repo->buscarPendentesComFiltros($filtros, $offset, $porPagina),
        ];
    }

    private function extrairFiltrosReservas(): array
    {
        return [
            'nome' => trim($_GET['reserva_nome'] ?? ''),
            'bloco' => trim($_GET['reserva_bloco'] ?? ''),
            'apto' => trim($_GET['reserva_apto'] ?? ''),
            'data_solicitacao' => trim($_GET['reserva_data_solicitacao'] ?? ''),
            'data_reserva' => trim($_GET['reserva_data_reserva'] ?? ''),
        ];
    }

    private function extrairFiltrosHistorico(): array
    {
        return [
            'local' => trim($_GET['local'] ?? ''),
            'data_solicitacao' => trim($_GET['data_solicitacao'] ?? ''),
            'data_reserva' => trim($_GET['data_reserva'] ?? ''),
        ];
    }

    private function resolverVisao(bool $podeGerenciarLocais): string
    {
        if (!$podeGerenciarLocais) {
            return 'nova';
        }

        $visao = $_GET['visao'] ?? 'locais';
        return in_array($visao, ['locais', 'solicitacoes'], true) ? $visao : 'locais';
    }
    private function notificarDecisao(
        array $reserva,
        string $acao,
        ReservaRepository $reservaRepo,
        int $idReserva
    ): int {
        $moradorRepo  = new MoradorRepository();
        $localRepo    = new LocalRepository();
        $morador      = $moradorRepo->findById($reserva['id_user']);
        $local        = $localRepo->findById($reserva['id_local']);
        $emailService = new EmailService();

        if ($acao === 'aceitar') {
            $emailService->reservaConfirmada(
                $morador['email'],
                $morador['nome'],
                $local['local'],
                $reserva['data_reserva']
            );

            $conflitantes = $reservaRepo->negarConflitantes(
                $reserva['id_local'],
                $reserva['data_reserva'],
                $reserva['hora_ini'],
                $reserva['hora_fim'],
                $idReserva
            );

            foreach ($conflitantes as $conflitante) {
                $emailService->reservaNegadaConflito(
                    $conflitante['email'],
                    $conflitante['nome_morador'],
                    $local['local'],
                    $reserva['data_reserva']
                );
            }

            return count($conflitantes);
        }

        $emailService->reservaNegada(
            $morador['email'],
            $morador['nome'],
            $local['local'],
            $reserva['data_reserva']
        );

        return 0;
    }

    private function ehSindicoOuAdmin(?array $usuario): bool
    {
        return $usuario && in_array((int) ($usuario['privilegio'] ?? 0), [2, 4], true);
    }

    private function redirecionar(string $caminho): void
    {
        header('Location: ' . BASE_URL . $caminho);
        exit();
    }

    private function requireAcessoReservas(): array
    {
        $usuario = AuthGuard::requereUsuarioAtivo();
        if (!in_array((int) ($usuario['privilegio'] ?? 0), [1, 2, 4], true)) {
            $this->redirecionar('/painel');
        }
        return $usuario;
    }

    private function requireSindicoOuAdmin(): void{
        AuthGuard::requereSindicoOuAdmin();
    }
}
