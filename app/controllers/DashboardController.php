<?php
require_once __DIR__ . '/../middleware/AuthGuard.php';
require_once __DIR__ . '/../repositories/MoradorRepository.php';
require_once __DIR__ . '/../repositories/ReservaRepository.php';
require_once __DIR__ . '/../repositories/LocalRepository.php';
require_once __DIR__ . '/../repositories/OcorrenciaRepository.php';
require_once __DIR__ . '/../repositories/VeiculoRepository.php';
require_once __DIR__ . '/../repositories/FinancasRepository.php';
require_once __DIR__ . '/../services/FeriadoService.php';

class DashboardController
{
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

    public function __construct()
    {
        $this->moradorRepo    = new MoradorRepository();
        $this->reservaRepo    = new ReservaRepository();
        $this->localRepo      = new LocalRepository();
        $this->ocorrenciaRepo = new OcorrenciaRepository();
        $this->veiculoRepo    = new VeiculoRepository();
        $this->financasRepo   = new FinancasRepository();
        $this->feriadoService = new FeriadoService();
    }

    public function index(): void
    {
        $usuario  = AuthGuard::requereUsuarioAtivo();
        $idLogado = (int) $usuario['id_user'];

        $minhasReservas = $this->reservaRepo->buscarReservasDashboardPorUsuario($idLogado);

        extract($this->montarKpis(), EXTR_OVERWRITE);
        extract($this->montarVeiculosResumo(), EXTR_OVERWRITE);
        extract($this->montarOcorrenciasResumo($idLogado), EXTR_OVERWRITE);
        extract($this->montarFinanceiroResumo($idLogado), EXTR_OVERWRITE);
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
            'proximosFeriados'    => $this->feriadoService->getProximosFeriados(2),
        ];
    }

    private function montarVeiculosResumo(): array
    {
        return [
            'totalVeiculos'      => $this->veiculoRepo->countAll(),
            'veiculosRecentes'   => $this->veiculoRepo->recentes(6),
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

    private function montarFinanceiroResumo(int $idLogado): array{
        return [
            'totalPendenteGeral'  => $this->financasRepo->totalGeralPendente(),
            'totalPendenteMorador'=> $this->financasRepo->totalPendente($idLogado),
            'countLancPendentes'  => $this->financasRepo->countLancamentosPendentes(),
            'countInadimplentes'  => $this->financasRepo->countMoradoresInadimplentes(),
            'countFaturas'        => $this->financasRepo->countFaturasGeradas(),
            'ultimosMoradores'    => $this->financasRepo->ultimosMoradoresCadastrados(5),
            'boletosVencendo'     => $this->financasRepo->boletosVencendoEmBreve((int) $_SESSION['usuario_id'], 5),
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
}
