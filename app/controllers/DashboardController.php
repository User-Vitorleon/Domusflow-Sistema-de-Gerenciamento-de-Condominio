<?php
<<<<<<< HEAD
=======
require_once __DIR__ . '/../middleware/AuthGuard.php';
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
require_once __DIR__ . '/../repositories/MoradorRepository.php';
require_once __DIR__ . '/../repositories/ReservaRepository.php';
require_once __DIR__ . '/../repositories/LocalRepository.php';
require_once __DIR__ . '/../repositories/OcorrenciaRepository.php';
require_once __DIR__ . '/../repositories/VeiculoRepository.php';
require_once __DIR__ . '/../repositories/FinancasRepository.php';
require_once __DIR__ . '/../services/FeriadoService.php';

class DashboardController
{
<<<<<<< HEAD
    private $moradorRepo;
    private $reservaRepo;
    private $localRepo;
    private $ocorrenciaRepo;
    private $veiculoRepo;
    private $financasRepo;
    private $feriadoService;
=======
    private const VIEW_POR_PRIVILEGIO = [
        1 => 'dashboard/morador.php',
        2 => 'dashboard/sindico.php',
        3 => 'dashboard/funcionario.php',
        4 => 'dashboard/admin.php',
    ];

    private const VIEW_PADRAO = 'dashboard/index.php';

    private MoradorRepository    $moradorRepo;
    private ReservaRepository    $reservaRepo;
    private LocalRepository      $localRepo;
    private OcorrenciaRepository $ocorrenciaRepo;
    private VeiculoRepository    $veiculoRepo;
    private FinancasRepository   $financasRepo;
    private FeriadoService       $feriadoService;
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)

    public function __construct()
    {
        $this->moradorRepo    = new MoradorRepository();
        $this->reservaRepo    = new ReservaRepository();
<<<<<<< HEAD
        $this->localRepo       = new LocalRepository();
        $this->ocorrenciaRepo  = new OcorrenciaRepository();
        $this->veiculoRepo     = new VeiculoRepository();
        $this->financasRepo    = new FinancasRepository();
        $this->feriadoService  = new FeriadoService();
=======
        $this->localRepo      = new LocalRepository();
        $this->ocorrenciaRepo = new OcorrenciaRepository();
        $this->veiculoRepo    = new VeiculoRepository();
        $this->financasRepo   = new FinancasRepository();
        $this->feriadoService = new FeriadoService();
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
    }

    public function index(): void
    {
<<<<<<< HEAD
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
=======
        $usuario  = AuthGuard::requereUsuarioAtivo();
        $idLogado = (int) $usuario['id_user'];

        $minhasReservas = $this->reservaRepo->buscarReservasDashboardPorUsuario($idLogado);

        extract($this->montarKpis(), EXTR_OVERWRITE);
        extract($this->montarVeiculosResumo(), EXTR_OVERWRITE);
        extract($this->montarOcorrenciasResumo($idLogado), EXTR_OVERWRITE);
        extract($this->montarFinanceiroResumo(), EXTR_OVERWRITE);
        extract($this->montarReservasResumo(), EXTR_OVERWRITE);

        $reservasParaAprovar = $this->ehSindicoOuAdmin($usuario)
            ? $this->reservaRepo->buscarReservasPendentesGeral()
            : [];

        $viewFile = $this->resolverView((int) $usuario['privilegio']);
        require_once __DIR__ . '/../../resources/views/' . $viewFile;
    }

    private function montarKpis(): array
    {
        return [
            'reservasPendentes'   => $this->reservaRepo->countByStatus('P'),
            'locaisDisponiveis'   => $this->localRepo->countDisponiveis(),
            'locaisTotal'         => $this->localRepo->countDisponiveis(),
            'moradoresAtivos'     => $this->moradorRepo->countByStatus('L'),
            'moradoresPendentes'  => $this->moradorRepo->countByStatus('P'),
            'moradoresStatus'     => $this->moradorRepo->contarPorStatus(),
            'proximoFeriado'      => $this->feriadoService->getProximoFeriado(),
            'proximosFeriados'    => $this->feriadoService->getProximosFeriados(3),
        ];
    }

    private function montarVeiculosResumo(): array
    {
        return [
            'totalVeiculos'      => $this->veiculoRepo->countAll(),
            'topMarcasVeiculos'  => $this->veiculoRepo->topMarcas(3),
            'topCoresVeiculos'   => $this->veiculoRepo->topCores(3),
            'topModelosVeiculos' => $this->veiculoRepo->topModelos(3),
        ];
    }

    private function montarOcorrenciasResumo(int $idLogado): array
    {
        return [
            'ocorrenciasFuncionario' => $this->ocorrenciaRepo->contarPorStatus(),
            'ocorrenciasMorador'     => $this->ocorrenciaRepo->contarPorStatusUsuario($idLogado),
            'ocorrenciasGeral'       => $this->ocorrenciaRepo->contarPorStatus(),
        ];
    }

    private function montarFinanceiroResumo(): array
    {
        return [
            'totalPendenteGeral'  => $this->financasRepo->totalGeralPendente(),
            'countLancPendentes'  => $this->financasRepo->countLancamentosPendentes(),
            'countInadimplentes'  => $this->financasRepo->countMoradoresInadimplentes(),
            'countFaturas'        => $this->financasRepo->countFaturasGeradas(),
            'ultimosMoradores'    => $this->financasRepo->ultimosMoradoresCadastrados(5),
        ];
    }

    private function montarReservasResumo(): array
    {
        return [
            'reservasSemana' => $this->reservaRepo->buscarReservasSemana(5),
            'chartDados'     => $this->reservaRepo->countPorMes((int) date('Y')),
            'chartLabels'    => ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun',
                                 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
        ];
    }

    private function ehSindicoOuAdmin(array $usuario): bool
    {
        return in_array((int) ($usuario['privilegio'] ?? 0), [2, 4], true);
    }

    private function resolverView(int $privilegio): string
    {
        return self::VIEW_POR_PRIVILEGIO[$privilegio] ?? self::VIEW_PADRAO;
    }
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
}
