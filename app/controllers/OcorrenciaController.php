<?php
<<<<<<< HEAD

=======
require_once __DIR__ . '/../middleware/AuthGuard.php';
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
require_once __DIR__ . '/../repositories/MoradorRepository.php';
require_once __DIR__ . '/../services/OcorrenciaService.php';

class OcorrenciaController
{
<<<<<<< HEAD
=======
    private const ITENS_POR_PAGINA = 15;

>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
    private OcorrenciaService $service;

    public function __construct()
    {
        $this->service = new OcorrenciaService();
    }

<<<<<<< HEAD
    // ── Morador: lista as próprias ocorrências + form de abertura ────────────
    public function index(): void
    {
        $this->requireAuth();
        $this->service->marcarNotificacoesLidas((int)$_SESSION['usuario_id']);

        $usuario     = $this->getMorador();
        $ocorrencias = $this->service->listarParaMorador((int)$_SESSION['usuario_id']);

        $detalhe = null;
        if (!empty($_GET['id'])) {
            $d = $this->service->buscarDetalhes((int)$_GET['id']);
            if ($d && (int)$d['id_user'] === (int)$_SESSION['usuario_id']) {
                $detalhe = $d;
            }
        }

        $flash = null;
        if (!empty($_GET['sucesso']))   $flash = ['tipo' => 'success', 'msg' => 'Ocorrência aberta com sucesso!'];
        if (!empty($_GET['cancelado'])) $flash = ['tipo' => 'warning', 'msg' => 'Ocorrência cancelada.'];
        if (!empty($_GET['tramitado'])) $flash = ['tipo' => 'success', 'msg' => 'Atualização registrada com sucesso!'];
        if (!empty($_SESSION['erro_ocorrencia'])) {
            $flash = ['tipo' => 'error', 'msg' => $_SESSION['erro_ocorrencia']];
            unset($_SESSION['erro_ocorrencia']);
        }
=======
public function index(): void
    {
        AuthGuard::requereLogin();

        $idUser = (int) $_SESSION['usuario_id'];
        $this->service->marcarNotificacoesLidas($idUser);

        $usuario     = $this->getMoradorLogado();
        $ocorrencias = $this->service->listarParaMorador($idUser);
        $detalhe     = $this->buscarDetalheDoMorador($idUser);
        $flash       = $this->montarFlashIndex();
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)

        require_once __DIR__ . '/../../resources/views/ocorrencia/index.php';
    }

<<<<<<< HEAD
    // ── Morador: detalhe de uma ocorrência própria ───────────────────────────
    public function detalhes(): void
    {
        $this->requireAuth();

        $id      = (int)($_GET['id'] ?? 0);
        $usuario = $this->getMorador();
        $detalhe = $this->service->buscarDetalhes($id);

        if (!$detalhe) {
            header('Location: ' . BASE_URL . '/ocorrencia');
            exit();
        }

        $priv = (int)($_SESSION['usuario_privilegio'] ?? 1);
        $isGestor = in_array($priv, [2, 4], true);

        if (!$isGestor && (int)$detalhe['id_user'] !== (int)$_SESSION['usuario_id']) {
            header('Location: ' . BASE_URL . '/ocorrencia');
            exit();
        }

        $flash = null;
        if (!empty($_GET['tramitado'])) $flash = ['tipo' => 'success', 'msg' => 'Atualização registrada com sucesso!'];

        if ($isGestor && !empty($_SESSION['erro_tramite'])) {
            $flash = ['tipo' => 'error', 'msg' => $_SESSION['erro_tramite']];
            unset($_SESSION['erro_tramite']);
        }

        if (!$isGestor && !empty($_SESSION['erro_ocorrencia'])) {
            $flash = ['tipo' => 'error', 'msg' => $_SESSION['erro_ocorrencia']];
            unset($_SESSION['erro_ocorrencia']);
        }
=======
    public function detalhes(): void
    {
        AuthGuard::requereLogin();

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
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)

        require_once __DIR__ . '/../../resources/views/ocorrencia/detalhes.php';
    }

<<<<<<< HEAD
    // ── Morador: abre uma nova ocorrência ────────────────────────────────────
    public function abrir(): void
    {
        $this->requireAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/ocorrencia');
            exit();
        }

        $resultado = $this->service->abrir($_POST, (int)$_SESSION['usuario_id']);

        if ($resultado['sucesso']) {
            header('Location: ' . BASE_URL . '/ocorrencia?sucesso=1');
        } else {
            $_SESSION['erro_ocorrencia'] = $resultado['mensagem'];
            header('Location: ' . BASE_URL . '/ocorrencia');
        }
        exit();
    }

    // ── Morador: cancela ocorrência própria ──────────────────────────────────
    public function cancelar(): void
    {
        $this->requireAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/ocorrencia');
            exit();
        }

        $id        = (int)($_POST['id_ocorrencia'] ?? 0);
        $resultado = $this->service->cancelar($id, (int)$_SESSION['usuario_id']);

        if ($resultado['sucesso']) {
            header('Location: ' . BASE_URL . '/ocorrencia?cancelado=1');
        } else {
            $_SESSION['erro_ocorrencia'] = $resultado['mensagem'];
            header('Location: ' . BASE_URL . '/ocorrencia');
        }
        exit();
    }

    // ── Morador: adiciona tramitação/comentário na própria ocorrência ─────────
    public function tramitarMorador(): void
    {
        $this->requireAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/ocorrencia');
            exit();
        }

        $id          = (int)($_POST['id_ocorrencia'] ?? 0);
        $descricao   = trim($_POST['descricao'] ?? '');
        $acao        = trim($_POST['acao'] ?? 'comentar'); // 'comentar' ou 'cancelar'
        $id_user     = (int)$_SESSION['usuario_id'];

        if (!$id || !$descricao) {
            $_SESSION['erro_ocorrencia'] = 'Preencha a descrição antes de enviar.';
            header('Location: ' . BASE_URL . '/ocorrencia/detalhes?id=' . $id);
            exit();
        }

        $resultado = $this->service->tramitarMorador($id, $descricao, $acao, $id_user);

        if ($resultado['sucesso']) {
            if ($acao === 'cancelar') {
                header('Location: ' . BASE_URL . '/ocorrencia?cancelado=1');
            } else {
                header('Location: ' . BASE_URL . '/ocorrencia/detalhes?id=' . $id . '&tramitado=1');
            }
        } else {
            $_SESSION['erro_ocorrencia'] = $resultado['mensagem'];
            header('Location: ' . BASE_URL . '/ocorrencia/detalhes?id=' . $id);
        }
        exit();
    }

    // ── Síndico/Admin: painel de gerenciamento ───────────────────────────────
    public function painel(): void
    {
        $this->requireAuth();
        $this->requireSindico();

        $usuario   = $this->getMorador();
        $pagina    = max(1, (int)($_GET['pagina'] ?? 1));
        $porPagina = 15;
        $offset    = ($pagina - 1) * $porPagina;

        $filtros = [
=======
    public function abrir(): void
    {
        AuthGuard::requereLogin();
        AuthGuard::requerePost('/ocorrencia');

        $resultado = $this->service->abrir($_POST, (int) $_SESSION['usuario_id']);
        $this->responderListagem($resultado, 'sucesso=1');
    }

    public function cancelar(): void
    {
        AuthGuard::requereLogin();
        AuthGuard::requerePost('/ocorrencia');

        $id        = (int) ($_POST['id_ocorrencia'] ?? 0);
        $resultado = $this->service->cancelar($id, (int) $_SESSION['usuario_id']);
        $this->responderListagem($resultado, 'cancelado=1');
    }

    public function tramitarMorador(): void
    {
        AuthGuard::requereLogin();
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
        AuthGuard::requereLogin();
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
        AuthGuard::requereLogin();
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
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
            'id_ocorrencia' => $_GET['id_ocorrencia'] ?? null,
            'status'        => $_GET['status']        ?? null,
            'morador'       => $_GET['morador']       ?? null,
            'categoria'     => $_GET['categoria']     ?? null,
            'titulo'        => $_GET['titulo']        ?? null,
            'data_ini'      => $_GET['data_ini']      ?? null,
            'data_fim'      => $_GET['data_fim']      ?? null,
        ];
<<<<<<< HEAD

        $status_filtro = $filtros['status']; // para a view destacar o contador ativo

        $total        = $this->service->contarParaPainel($filtros);
        $totalPaginas = (int) ceil($total / $porPagina);
        $ocorrencias  = $this->service->listarParaPainel($filtros, $porPagina, $offset);
        $contadores   = $this->service->contadores();
        $moradoresFiltro = $this->service->listarMoradoresComOcorrencias();

        $detalhe = null;
        if (isset($_GET['id'])) {
            $detalhe = $this->service->buscarDetalhes((int)$_GET['id'], 100, 0);
        }

        $flash = null;
        if (!empty($_GET['tramitado'])) $flash = ['tipo' => 'success', 'msg' => 'Tramitação registrada com sucesso!'];
        if (!empty($_SESSION['erro_tramite'])) {
            $flash = ['tipo' => 'error', 'msg' => $_SESSION['erro_tramite']];
            unset($_SESSION['erro_tramite']);
        }

        require_once __DIR__ . '/../../resources/views/ocorrencia/painel.php';
    }

    // ── Síndico/Admin: adiciona tramitação ───────────────────────────────────
    public function tramitar(): void
    {
        $this->requireAuth();
        $this->requireSindico();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/ocorrencia/painel');
            exit();
        }

        $resultado = $this->service->tramitar($_POST, (int)$_SESSION['usuario_id']);
        $id        = (int)($_POST['id_ocorrencia'] ?? 0);

        if ($resultado['sucesso']) {
            header('Location: ' . BASE_URL . '/ocorrencia/painel?id=' . $id . '&tramitado=1');
        } else {
            $_SESSION['erro_tramite'] = $resultado['mensagem'];
            header('Location: ' . BASE_URL . '/ocorrencia/painel?id=' . $id);
        }
        exit();
    }

    // ── Helpers ──────────────────────────────────────────────────────────────

    private function getMorador(): array
    {
        $repo = new MoradorRepository();
        return $repo->findById((int)$_SESSION['usuario_id']) ?? [];
    }

    private function requireAuth(): void
    {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: ' . BASE_URL . '/');
            exit();
        }
=======
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
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
    }

    private function requireSindico(): void
    {
<<<<<<< HEAD
        $priv = (int)($_SESSION['usuario_privilegio'] ?? 1);
        if (!in_array($priv, [2, 4], true)) {
            header('Location: ' . BASE_URL . '/ocorrencia');
            exit();
        }
    }
=======
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
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
}
