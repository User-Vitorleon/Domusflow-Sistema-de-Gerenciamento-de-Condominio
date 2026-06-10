<?php
require_once __DIR__ . '/../middleware/AuthGuard.php';
require_once __DIR__ . '/../repositories/MoradorRepository.php';
require_once __DIR__ . '/../services/OcorrenciaService.php';

class OcorrenciaController
{
    private const ITENS_POR_PAGINA = 15;
    private const ITENS_MORADOR_POR_PAGINA = 4;

    private OcorrenciaService $service;

    public function __construct()
    {
        $this->service = new OcorrenciaService();
    }

public function index(): void
    {
        AuthGuard::requereUsuarioAtivo();

        $idUser = (int) $_SESSION['usuario_id'];
        $this->service->marcarNotificacoesLidas($idUser);

        $usuario        = $this->getMoradorLogado();
        $statusFiltro   = $this->normalizarStatus($_GET['status'] ?? null);
        $pagina         = max(1, (int) ($_GET['pagina'] ?? 1));
        $porPagina      = self::ITENS_MORADOR_POR_PAGINA;
        $totalOcorrencias = $this->service->contarParaMorador($idUser, $statusFiltro);
        $totalOcorrencias = min($totalOcorrencias, 10);
        $totalPaginas   = (int) ceil($totalOcorrencias / $porPagina);
        if ($totalPaginas > 0 && $pagina > $totalPaginas) {
            $pagina = $totalPaginas;
        }
        $offset         = ($pagina - 1) * $porPagina;
        $porPagina      = min($porPagina, max(0, 10 - $offset));
        $ocorrencias    = $this->service->listarParaMorador($idUser, $statusFiltro, $porPagina, $offset);
        $detalhe        = $this->buscarDetalheDoMorador($idUser);
        $flash          = $this->montarFlashIndex();

        require_once __DIR__ . '/../../resources/views/ocorrencia/index.php';
    }

    public function detalhes(): void
    {
        AuthGuard::requereUsuarioAtivo();

        $id      = (int) ($_GET['id'] ?? 0);
        $usuario = $this->getMoradorLogado();
        $detalhe = $this->service->buscarDetalhes($id);

        if (!$detalhe) {
            $this->redirecionar('/ocorrencia');
        }

        $ehGestor = $this->ehGestor();
        if (!$ehGestor && (int) $detalhe['id_user'] !== (int) $_SESSION['usuario_id']) {
            $this->redirecionar('/ocorrencia');
        }

        $flash = $this->montarFlashDetalhes($ehGestor);

        require_once __DIR__ . '/../../resources/views/ocorrencia/detalhes.php';
    }

    public function abrir(): void
    {
        AuthGuard::requereUsuarioAtivo();
        AuthGuard::requerePost('/ocorrencia');

        $resultado = $this->service->abrir($_POST, (int) $_SESSION['usuario_id']);
        $this->responderListagem($resultado, 'sucesso=1');
    }

    public function cancelar(): void
    {
        AuthGuard::requereUsuarioAtivo();
        AuthGuard::requerePost('/ocorrencia');

        $id        = (int) ($_POST['id_ocorrencia'] ?? 0);
        $resultado = $this->service->cancelar($id, (int) $_SESSION['usuario_id']);
        $this->responderListagem($resultado, 'cancelado=1');
    }

    public function tramitarMorador(): void
    {
        AuthGuard::requereUsuarioAtivo();
        AuthGuard::requerePost('/ocorrencia');

        $id        = (int) ($_POST['id_ocorrencia'] ?? 0);
        $descricao = trim($_POST['descricao'] ?? '');
        $acao      = trim($_POST['acao'] ?? 'comentar');

        if (!$id || !$descricao) {
            $_SESSION['erro_ocorrencia'] = 'Preencha a descrição antes de enviar.';
            $this->redirecionar('/ocorrencia/detalhes?id=' . $id);
        }

        $resultado = $this->service->tramitarMorador($id, $descricao, $acao, (int) $_SESSION['usuario_id']);

        if (!$resultado['sucesso']) {
            $_SESSION['erro_ocorrencia'] = $resultado['mensagem'];
            $this->redirecionar('/ocorrencia/detalhes?id=' . $id);
        }

        if ($acao === 'cancelar') {
            $this->redirecionar('/ocorrencia?cancelado=1');
        }
        $this->redirecionar('/ocorrencia/detalhes?id=' . $id . '&tramitado=1');
    }

public function painel(): void
    {
        AuthGuard::requereUsuarioAtivo();
        $this->requireSindico();

        $usuario   = $this->getMoradorLogado();
        $pagina    = max(1, (int) ($_GET['pagina'] ?? 1));
        $porPagina = self::ITENS_POR_PAGINA;
        $offset    = ($pagina - 1) * $porPagina;

        $filtros         = $this->extrairFiltrosPainel();
        $statusFiltro    = $filtros['status'];
        $total           = $this->service->contarParaPainel($filtros);
        $totalPaginas    = (int) ceil($total / $porPagina);
        $ocorrencias     = $this->service->listarParaPainel($filtros, $porPagina, $offset);
        $contadores      = $this->service->contadores();
        $moradoresFiltro = $this->service->listarMoradoresComOcorrencias();

        $detalhe = isset($_GET['id'])
            ? $this->service->buscarDetalhes((int) $_GET['id'], 100, 0)
            : null;

        $flash = $this->montarFlashPainel();

        require_once __DIR__ . '/../../resources/views/ocorrencia/painel.php';
    }

    public function tramitar(): void
    {
        AuthGuard::requereUsuarioAtivo();
        $this->requireSindico();
        AuthGuard::requerePost('/ocorrencia/painel');

        $resultado = $this->service->tramitar($_POST, (int) $_SESSION['usuario_id']);
        $id        = (int) ($_POST['id_ocorrencia'] ?? 0);

        if ($resultado['sucesso']) {
            $this->redirecionar('/ocorrencia/painel?id=' . $id . '&tramitado=1');
        }

        $_SESSION['erro_tramite'] = $resultado['mensagem'];
        $this->redirecionar('/ocorrencia/painel?id=' . $id);
    }

private function buscarDetalheDoMorador(int $idUser): ?array
    {
        if (empty($_GET['id'])) {
            return null;
        }
        $detalhe = $this->service->buscarDetalhes((int) $_GET['id']);
        if (!$detalhe || (int) $detalhe['id_user'] !== $idUser) {
            return null;
        }
        return $detalhe;
    }

    private function extrairFiltrosPainel(): array
    {
        return [
            'id_ocorrencia' => $_GET['id_ocorrencia'] ?? null,
            'status'        => $_GET['status']        ?? null,
            'morador'       => $_GET['morador']       ?? null,
            'categoria'     => $_GET['categoria']     ?? null,
            'titulo'        => $_GET['titulo']        ?? null,
            'data_ini'      => $_GET['data_ini']      ?? null,
            'data_fim'      => $_GET['data_fim']      ?? null,
        ];
    }

    private function normalizarStatus(?string $status): ?string
    {
        return in_array($status, ['A', 'E', 'R', 'C'], true) ? $status : null;
    }

    private function montarFlashIndex(): ?array
    {
        if (!empty($_GET['sucesso'])) {
            return ['tipo' => 'success', 'msg' => 'Ocorrência aberta com sucesso!'];
        }
        if (!empty($_GET['cancelado'])) {
            return ['tipo' => 'warning', 'msg' => 'Ocorrência cancelada.'];
        }
        if (!empty($_GET['tramitado'])) {
            return ['tipo' => 'success', 'msg' => 'Atualização registrada com sucesso!'];
        }
        if (!empty($_SESSION['erro_ocorrencia'])) {
            $msg = $_SESSION['erro_ocorrencia'];
            unset($_SESSION['erro_ocorrencia']);
            return ['tipo' => 'error', 'msg' => $msg];
        }
        return null;
    }

    private function montarFlashDetalhes(bool $ehGestor): ?array
    {
        if (!empty($_GET['tramitado'])) {
            return ['tipo' => 'success', 'msg' => 'Atualização registrada com sucesso!'];
        }
        if ($ehGestor && !empty($_SESSION['erro_tramite'])) {
            $msg = $_SESSION['erro_tramite'];
            unset($_SESSION['erro_tramite']);
            return ['tipo' => 'error', 'msg' => $msg];
        }
        if (!$ehGestor && !empty($_SESSION['erro_ocorrencia'])) {
            $msg = $_SESSION['erro_ocorrencia'];
            unset($_SESSION['erro_ocorrencia']);
            return ['tipo' => 'error', 'msg' => $msg];
        }
        return null;
    }

    private function montarFlashPainel(): ?array
    {
        if (!empty($_GET['tramitado'])) {
            return ['tipo' => 'success', 'msg' => 'Tramitação registrada com sucesso!'];
        }
        if (!empty($_SESSION['erro_tramite'])) {
            $msg = $_SESSION['erro_tramite'];
            unset($_SESSION['erro_tramite']);
            return ['tipo' => 'error', 'msg' => $msg];
        }
        return null;
    }

    private function responderListagem(array $resultado, string $sucessoQuery): void
    {
        if ($resultado['sucesso']) {
            $this->redirecionar('/ocorrencia?' . $sucessoQuery);
        }
        $_SESSION['erro_ocorrencia'] = $resultado['mensagem'];
        $this->redirecionar('/ocorrencia');
    }

    private function ehGestor(): bool
    {
        return in_array((int) ($_SESSION['usuario_privilegio'] ?? 1), [2, 4], true);
    }

    private function requireSindico(): void
    {
        if (!$this->ehGestor()) {
            $this->redirecionar('/ocorrencia');
        }
    }

    private function getMoradorLogado(): array
    {
        $repo = new MoradorRepository();
        return $repo->findById((int) $_SESSION['usuario_id']) ?? [];
    }

    private function redirecionar(string $caminho): void
    {
        header('Location: ' . BASE_URL . $caminho);
        exit();
    }
}
