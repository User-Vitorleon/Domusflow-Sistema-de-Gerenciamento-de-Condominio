<?php
require_once __DIR__ . '/../services/ReservaService.php';
require_once __DIR__ . '/../services/LocalService.php';
require_once __DIR__ . '/../repositories/MoradorRepository.php';
require_once __DIR__ . '/../repositories/ReservaRepository.php';
require_once __DIR__ . '/../repositories/LocalRepository.php';
require_once __DIR__ . '/../services/EmailService.php';

class ReservaController
{
    private ReservaService $reservaService;
    private LocalService   $localService;


    public function __construct()
    {
        $this->reservaService = new ReservaService();
        $this->localService   = new LocalService();
    }

    public function index(): void
    {
        $this->requireAuth();

        $repo    = new MoradorRepository();
        $usuario = $repo->findById((int)$_SESSION['usuario_id']);
        $locais  = $this->reservaService->listarLocaisDisponiveis();

        $reservasParaAprovar = [];
        if (in_array($usuario['privilegio'] ?? 0, [2, 4])) {
            $pagina       = (int)($_GET['pagina'] ?? 1);
            $porPagina    = 10;
            $total        = $this->reservaService->contarPendentesGeral();
            $totalPaginas = (int)ceil($total / $porPagina);
            $offset       = ($pagina - 1) * $porPagina;
            $reservasParaAprovar = $this->reservaService->listarPendentesGeral($offset, $porPagina);
        }

        require_once __DIR__ . '/../../resources/views/reserva/index.php';
    }

    public function salvar(): void{
        $this->requireAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/reserva');
            exit();
        }

        if (in_array($_SESSION['usuario_privilegio'] ?? 1, [2, 4])) {
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

    private function requireAuth(): void
    {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: ' . BASE_URL . '/');
            exit();
        }
    }

    public function decidir(): void
    {
        $idReserva = (int)($_POST['id_reserva'] ?? 0);
        $acao      = $_POST['acao'] ?? null;

        if ($idReserva && $acao) {
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
        
            $reserva = $reservaRepo->findById($idReserva);
            if ($reserva) {
                $moradorRepo  = new MoradorRepository();
                $morador      = $moradorRepo->findById($reserva['id_user']);
                $localRepo    = new LocalRepository();
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

                    foreach ($conflitantes as $c) {
                        $emailService->reservaNegadaConflito(
                            $c['email'],
                            $c['nome_morador'],
                            $local['local'],
                            $reserva['data_reserva']
                        );
                    }
                } else {
                    $emailService->reservaNegada(
                        $morador['email'],
                        $morador['nome'],
                        $local['local'],
                        $reserva['data_reserva']
                    );
                }
            }
        }

        header('Location: ' . BASE_URL . '/reserva');
        exit();
    }
}
