<?php

require_once __DIR__ . '/../repositories/MoradorRepository.php';
require_once __DIR__ . '/../services/OcorrenciaService.php';

class OcorrenciaController
{
    private OcorrenciaService $service;

    public function __construct()
    {
        $this->service = new OcorrenciaService();
    }

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

        require_once __DIR__ . '/../../resources/views/ocorrencia/index.php';
    }

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

        $priv = (int)($_SESSION['usuario_previlegio'] ?? 1);
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

        require_once __DIR__ . '/../../resources/views/ocorrencia/detalhes.php';
    }

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
            'id_ocorrencia' => $_GET['id_ocorrencia'] ?? null,
            'status'        => $_GET['status']        ?? null,
            'morador'       => $_GET['morador']       ?? null,
            'categoria'     => $_GET['categoria']     ?? null,
            'titulo'        => $_GET['titulo']        ?? null,
            'data_ini'      => $_GET['data_ini']      ?? null,
            'data_fim'      => $_GET['data_fim']      ?? null,
        ];

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
    }

    private function requireSindico(): void
    {
        $priv = (int)($_SESSION['usuario_previlegio'] ?? 1);
        if (!in_array($priv, [2, 4], true)) {
            header('Location: ' . BASE_URL . '/ocorrencia');
            exit();
        }
    }
}
