<?php
require_once __DIR__ . '/../repositories/MoradorRepository.php';
require_once __DIR__ . '/../repositories/ReservaRepository.php';
require_once __DIR__ . '/../repositories/LocalRepository.php';
require_once __DIR__ . '/../services/FeriadoService.php';

class DashboardController
{
    private $moradorRepo;
    private $reservaRepo;
    private $localRepo;
    private $feriadoService;

    public function __construct()
    {
        $this->moradorRepo    = new MoradorRepository();
        $this->reservaRepo    = new ReservaRepository();
        $this->localRepo      = new LocalRepository();
        $this->feriadoService = new FeriadoService();
    }

    public function index(): void
    {
        // 1. Verificação primária: Está logado?
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: ' . BASE_URL . '/');
            exit();
        }

        // 2. Busca os dados do usuário usando a propriedade já inicializada
        $usuario = $this->moradorRepo->findById((int)$_SESSION['usuario_id']);

        // 3. Se o usuário sumiu do banco ou a sessão deu erro
        if (!$usuario) {
            session_destroy();
            header('Location: ' . BASE_URL . '/');
            exit();
        }

        // 4. TRAVA DE SEGURANÇA: Se o status for Pendente, não vê a Dashboard
        if ($usuario['status'] === 'P') {
            header('Location: ' . BASE_URL . '/pendente');
            exit();
        }

        // --- A partir daqui, só entra quem é status 'L' (Liberado) ---

        $idLogado = $_SESSION['usuario_id'];
        
        // Reservas específicas do morador logado
        $minhasReservas = $this->reservaRepo->buscarReservasPorUsuario($idLogado);

        // KPIs para os cards
        $reservasPendentes = $this->reservaRepo->countByStatus('P');
        $locaisDisponiveis = $this->localRepo->countDisponiveis();
        $moradoresAtivos   = $this->moradorRepo->countByStatus('L');
        $proximoFeriado    = $this->feriadoService->getProximoFeriado();

        // Dados do Gráfico
        $anoAtual    = (int)date('Y');
        $chartDados  = $this->reservaRepo->countPorMes($anoAtual);
        $chartLabels = ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'];

        // Variável opcional para o Síndico (Privilégio 2)
        $reservasParaAprovar = [];
        if (($usuario['previlegio'] ?? 0) == 2) {
            $reservasParaAprovar = $this->reservaRepo->buscarReservasPendentesGeral();
        }

        // Chama a View
        require_once __DIR__ . '/../../resources/views/dashboard/index.php';
    }
}