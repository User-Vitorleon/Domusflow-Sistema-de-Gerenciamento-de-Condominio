<?php
<<<<<<< HEAD
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


=======
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

>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
    public function __construct()
    {
        $this->reservaService = new ReservaService();
        $this->localService   = new LocalService();
    }

    public function index(): void
    {
<<<<<<< HEAD
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
=======
        AuthGuard::requereLogin();

        $moradorRepo = new MoradorRepository();
        $usuario     = $moradorRepo->findById((int) $_SESSION['usuario_id']);
        $locais      = $this->reservaService->listarLocaisDisponiveis();

        $reservasParaAprovar = [];
        $totalPaginas        = 0;
        if ($this->ehSindicoOuAdmin($usuario)) {
            extract($this->montarPaginacaoPendentes(), EXTR_OVERWRITE);
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
        }

        require_once __DIR__ . '/../../resources/views/reserva/index.php';
    }

<<<<<<< HEAD
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
=======
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
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
    }

    public function decidir(): void
    {
<<<<<<< HEAD
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
=======
        $idReserva = (int) ($_POST['id_reserva'] ?? 0);
        $acao      = $_POST['acao'] ?? null;

        if (!$idReserva || !$acao) {
            $this->redirecionar('/reserva');
        }

        $reservaRepo = new ReservaRepository();

        if ($acao === 'aceitar') {
            $reservaRepo->aprovar(
                $idReserva,
                (int) $_SESSION['usuario_id'],
                $_SESSION['usuario_nome']
            );
        } else {
            $reservaRepo->atualizarStatus($idReserva, 'N');
        }

        $reserva = $reservaRepo->findById($idReserva);
        if ($reserva) {
            $this->notificarDecisao($reserva, $acao, $reservaRepo, $idReserva);
        }

        $this->redirecionar('/reserva');
    }

    private function montarPaginacaoPendentes(): array
    {
        $pagina       = max(1, (int) ($_GET['pagina'] ?? 1));
        $porPagina    = self::ITENS_POR_PAGINA;
        $total        = $this->reservaService->contarPendentesGeral();
        $totalPaginas = (int) ceil($total / $porPagina);
        $offset       = ($pagina - 1) * $porPagina;

        return [
            'totalPaginas'        => $totalPaginas,
            'reservasParaAprovar' => $this->reservaService->listarPendentesGeral($offset, $porPagina),
        ];
    }

    private function notificarDecisao(
        array $reserva,
        string $acao,
        ReservaRepository $reservaRepo,
        int $idReserva
    ): void {
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
            return;
        }

        $emailService->reservaNegada(
            $morador['email'],
            $morador['nome'],
            $local['local'],
            $reserva['data_reserva']
        );
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
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
        exit();
    }
}
