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

    private ReservaService $reservaService;
    private LocalService   $localService;

    public function __construct()
    {
        $this->reservaService = new ReservaService();
        $this->localService   = new LocalService();
    }

    public function index(): void
    {
        AuthGuard::requereLogin();

        $moradorRepo = new MoradorRepository();
        $usuario     = $moradorRepo->findById((int) $_SESSION['usuario_id']);
        $locais      = $this->reservaService->listarLocaisDisponiveis();

        $reservasParaAprovar = [];
        $totalPaginas        = 0;
        if ($this->ehSindicoOuAdmin($usuario)) {
            extract($this->montarPaginacaoPendentes(), EXTR_OVERWRITE);
        }

        require_once __DIR__ . '/../../resources/views/reserva/index.php';
    }

    

    public function salvar(): void
    {
        AuthGuard::requereLogin();
        AuthGuard::requerePost('/reserva');

        $resultado = $this->ehSindicoOuAdminSessao()
            ? $this->localService->cadastrar($_POST, (int) $_SESSION['usuario_id'])
            : $this->reservaService->salvar($_POST, (int) $_SESSION['usuario_id']);

        if ($resultado['sucesso']) {
            $this->redirecionar('/reserva?sucesso=1');
        }

        $_SESSION['erro_reserva'] = $resultado['mensagem'];
        $this->redirecionar('/reserva');
    }

    public function decidir(): void{

        AuthGuard::requereLogin();
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

        $this->redirecionar('/reserva');
    }    


    private function montarPaginacaoPendentes(): array{
        $pagina       = max(1, (int)($_GET['pagina'] ?? 1));
        $porPagina    = self::ITENS_POR_PAGINA;
        $total        = $this->reservaService->contarPendentesGeral();
        $totalPaginas = (int)ceil($total / $porPagina);
        $offset       = ($pagina - 1) * $porPagina;

        return [
            'pagina'              => $pagina,        
            'totalPaginas'        => $totalPaginas,
            'reservasParaAprovar' => $this->reservaService->listarPendentesGeral($offset, $porPagina),
        ];
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

    private function ehSindicoOuAdminSessao(): bool
    {
        return in_array((int) ($_SESSION['usuario_privilegio'] ?? 1), [2, 4], true);
    }

    private function redirecionar(string $caminho): void
    {
        header('Location: ' . BASE_URL . $caminho);
        exit();
    }

    private function requireSindicoOuAdmin(): void{
        if (!in_array((int) ($_SESSION['usuario_privilegio'] ?? 0), [2, 4], true)) {
            $this->redirecionar('/reserva');
        }
    }
}
