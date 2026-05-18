<?php
require_once __DIR__ . '/../repositories/MoradorRepository.php';
require_once __DIR__ . '/../repositories/ReservaRepository.php';
require_once __DIR__ . '/../repositories/LocalRepository.php';
require_once __DIR__ . '/../repositories/OcorrenciaRepository.php';
require_once __DIR__ . '/../repositories/VeiculoRepository.php';
require_once __DIR__ . '/../repositories/FinancasRepository.php';
require_once __DIR__ . '/../services/FeriadoService.php';

class DashboardController
{
    private $moradorRepo;
    private $reservaRepo;
    private $localRepo;
    private $ocorrenciaRepo;
    private $veiculoRepo;
    private $financasRepo;
    private $feriadoService;

    public function __construct()
    {
        $this->moradorRepo    = new MoradorRepository();
        $this->reservaRepo    = new ReservaRepository();
        $this->localRepo       = new LocalRepository();
        $this->ocorrenciaRepo  = new OcorrenciaRepository();
        $this->veiculoRepo     = new VeiculoRepository();
        $this->financasRepo    = new FinancasRepository();
        $this->feriadoService  = new FeriadoService();
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

        if ($usuario['status'] === 'B') {
            $_SESSION['erro_login'] = 'Esta conta está inativa. Entre em contato com o síndico.';
            session_unset();
            session_destroy();
            header('Location: ' . BASE_URL . '/');
            exit();
        }

        if ($usuario['status'] === 'B') {
            exit();
        }

        // --- A partir daqui, só entra quem é status 'L' (Liberado) ---

        $idLogado = $_SESSION['usuario_id'];

        // Reservas específicas do morador logado
        $minhasReservas = $this->reservaRepo->buscarReservasDashboardPorUsuario($idLogado);

        // KPIs para os cards
        $reservasPendentes   = $this->reservaRepo->countByStatus('P');
        $locaisDisponiveis   = $this->localRepo->countDisponiveis();
        $moradoresAtivos     = $this->moradorRepo->countByStatus('L');
        $moradoresPendentes  = $this->moradorRepo->countByStatus('P');
        $moradoresStatus     = $this->moradorRepo->contarPorStatus();
        $proximoFeriado      = $this->feriadoService->getProximoFeriado();
        $ocorrenciasFuncionario = $this->ocorrenciaRepo->contarPorStatus();
        $totalVeiculos          = $this->veiculoRepo->countAll();
        $topMarcasVeiculos      = $this->veiculoRepo->topMarcas(3);
        $topCoresVeiculos       = $this->veiculoRepo->topCores(3);
        $topModelosVeiculos     = $this->veiculoRepo->topModelos(3);
        $proximosFeriados = $this->feriadoService->getProximosFeriados(3);
        $ocorrenciasMorador = $this->ocorrenciaRepo->contarPorStatusUsuario($idLogado);
        $ocorrenciasGeral = $this->ocorrenciaRepo->contarPorStatus();
        $reservasSemana   = $this->reservaRepo->buscarReservasSemana(5);
        $locaisTotal      = $this->localRepo->countDisponiveis();
        $totalPendenteGeral      = $this->financasRepo->totalGeralPendente();
        $countLancPendentes      = $this->financasRepo->countLancamentosPendentes();
        $countInadimplentes      = $this->financasRepo->countMoradoresInadimplentes();
        $countFaturas            = $this->financasRepo->countFaturasGeradas();
        $ultimosMoradores        = $this->financasRepo->ultimosMoradoresCadastrados(5);


        // Dados do Gráfico
        $anoAtual    = (int)date('Y');
        $chartDados  = $this->reservaRepo->countPorMes($anoAtual);
        $chartLabels = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];

        // Variável opcional para o Síndico (Privilégio 2)
        $reservasParaAprovar = [];
        if (!in_array($usuario['privilegio'] ?? 0, [2, 4])) {
            $reservasParaAprovar = $this->reservaRepo->buscarReservasPendentesGeral();
        }

        // Determina a view baseada no privilégio
        $privilegio = (int) $usuario['privilegio'];

        switch ($privilegio) {
            case 1:
                $viewFile = 'dashboard/morador.php';
                break;
            case 3:
                $viewFile = 'dashboard/funcionario.php';
                break;
            case 2:
                $viewFile = 'dashboard/sindico.php';
                break;
            case 4:
                $viewFile = 'dashboard/admin.php';
                break;
            default:
                $viewFile = 'dashboard/index.php';
                break;
        }

        // Chama a View
        require_once __DIR__ . '/../../resources/views/' . $viewFile;
    }
}
