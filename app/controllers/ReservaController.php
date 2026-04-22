<?php
require_once __DIR__ . '/../services/ReservaService.php';
require_once __DIR__ . '/../services/LocalService.php';
require_once __DIR__ . '/../repositories/MoradorRepository.php';

class ReservaController {
    private ReservaService $reservaService;
    private LocalService   $localService;

    public function __construct() {
        $this->reservaService = new ReservaService();
        $this->localService   = new LocalService();
    }

    public function index(): void {
        $this->requireAuth();

        $repo    = new MoradorRepository();
        $usuario = $repo->findById((int)$_SESSION['usuario_id']);
        $locais  = $this->reservaService->listarLocaisDisponiveis();

        $reservasParaAprovar = [];
        if (($usuario['previlegio'] ?? 0) == 2) {
            $reservasParaAprovar = $this->reservaService->listarPendentesGeral();
        }

        $reservasParaAprovar = [];
            if (($usuario['previlegio'] ?? 0) == 2) {
                $pagina = (int)($_GET['pagina'] ?? 1);
                $reservasParaAprovar = $this->reservaService->listarPendentesGeral();
                $totalPendentes = count($reservasParaAprovar);
                $porPagina = 10;
                $totalPaginas = (int)ceil($totalPendentes / $porPagina);
                $offset = ($pagina - 1) * $porPagina;
                $reservasParaAprovar = array_slice($reservasParaAprovar, $offset, $porPagina);
            }

        require_once __DIR__ . '/../../resources/views/reserva/index.php';

        require_once __DIR__ . '/../../resources/views/reserva/index.php';
    }

    public function salvar(): void {
        $this->requireAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/reserva');
            exit();
        }

        if (($_SESSION['usuario_previlegio'] ?? 1) == 2) {
            $resultado = $this->localService->cadastrar($_POST, (int)$_SESSION['usuario_id']);
        } else {
            $resultado = $this->reservaService->salvar($_POST, (int)$_SESSION['usuario_id']);
        }

        if ($resultado['sucesso']) {
            header('Location: ' . BASE_URL . '/reserva?sucesso=1');
        } else {
            $_SESSION['erro_reserva'] = $resultado['mensagem'];
            header('Location: ' . BASE_URL . '/reserva');
        }
        exit();
    }

    private function requireAuth(): void {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: ' . BASE_URL . '/');
            exit();
        }
    }

    public function decidir(): void
    {
        $idReserva = $_POST['id_reserva'] ?? null;
        $acao      = $_POST['acao'] ?? null;

        if ($idReserva && $acao) {
            $reservaRepo = new ReservaRepository();
            $novoStatus = ($acao === 'aceitar') ? 'L' : 'R';
            $reservaRepo->atualizarStatus((int)$idReserva, $novoStatus);
        }

        header('Location: ' . BASE_URL . '/reserva');
        exit();
    }

        
}