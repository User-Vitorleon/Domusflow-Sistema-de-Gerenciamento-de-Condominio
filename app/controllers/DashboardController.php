<?php
require_once __DIR__ . '/../repositories/MoradorRepository.php';
require_once __DIR__ . '/../repositories/ReservaRepository.php';
require_once __DIR__ . '/../repositories/LocalRepository.php';
require_once __DIR__ . '/../services/FeriadoService.php';

class DashboardController
{
    public function index(): void
    {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: ' . BASE_URL . '/');
            exit();
        }

        $moradorRepo    = new MoradorRepository();
        $reservaRepo    = new ReservaRepository();
        $localRepo      = new LocalRepository();
        $feriadoService = new FeriadoService();

        $usuario = $moradorRepo->findById((int)$_SESSION['usuario_id']);

        if (!$usuario) {
            session_destroy();
            header('Location: ' . BASE_URL . '/');
            exit();
        }

        // ── KPIs ──────────────────────────────────────
        $reservasPendentes = $reservaRepo->countByStatus('P');
        $locaisDisponiveis = $localRepo->countDisponiveis();
        $moradoresAtivos   = $moradorRepo->countByStatus('L');
        $proximoFeriado    = $feriadoService->getProximoFeriado();

        // ── Gráfico — reservas por mês do ano atual ───
        $anoAtual    = (int)date('Y');
        $chartDados  = $reservaRepo->countPorMes($anoAtual);
        $chartLabels = [
            'Jan',
            'Fev',
            'Mar',
            'Abr',
            'Mai',
            'Jun',
            'Jul',
            'Ago',
            'Set',
            'Out',
            'Nov',
            'Dez'
        ];

        $appDashboard = [
            'reservasPendentes' => $reservasPendentes,
            'locaisDisponiveis' => $locaisDisponiveis,
            'moradoresAtivos'   => $moradoresAtivos,
            'chartLabels'       => $chartLabels,
            'chartDados'        => $chartDados,
        ];

        require_once __DIR__ . '/../../resources/views/dashboard/index.php';
    }
}
