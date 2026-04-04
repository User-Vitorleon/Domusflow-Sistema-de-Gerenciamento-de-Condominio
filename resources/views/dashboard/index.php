<?php
$paginaTitulo = 'Dashboard';
$paginaAtiva  = 'dashboard';
$cssExtra = 'dashboard.css';
$jsExtra = 'dashboard.js';
require_once __DIR__ . '/../layout/header.php';
require_once __DIR__ . '/../layout/sidebar.php';
?>

<main class="main-content" id="app">
    <div class="page-header">
        <h2>Dashboard</h2>
        <p class="text-muted">Bem-vindo, <?= htmlspecialchars(explode(' ', $usuario['nome'])[0]) ?>!</p>
    </div>

    <div class="kpi-grid">
        <div class="kpi-card">
            <div class="kpi-icon" style="background:#EFF8FF; color:#0F80B6;">
                <i class='bx bx-calendar'></i>
            </div>
            <div>
                <p class="kpi-label">Reservas Pendentes</p>
                <h3 class="kpi-value">{{ resumo.reservasPendentes }}</h3>
            </div>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon" style="background:#F0FDF4; color:#22C55E;">
                <i class='bx bx-building-house'></i>
            </div>
            <div>
                <p class="kpi-label">Locais Disponíveis</p>
                <h3 class="kpi-value">{{ resumo.locaisDisponiveis }}</h3>
            </div>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon" style="background:#FFFBEB; color:#F59E0B;">
                <i class='bx bx-group'></i>
            </div>
            <div>
                <p class="kpi-label">Moradores Ativos</p>
                <h3 class="kpi-value">{{ resumo.moradoresAtivos }}</h3>
            </div>
        </div>

        <!-- Card próximo feriado -->
        <?php if ($proximoFeriado): ?>
            <div class="kpi-card kpi-card-feriado">
                <div class="kpi-icon" style="background:#FEF2F2; color:#EF4444;">
                    <i class='bx bx-party'></i>
                </div>
                <div>
                    <p class="kpi-label">Próximo Feriado</p>
                    <h3 class="kpi-value kpi-value-sm">
                        <?= htmlspecialchars($proximoFeriado['name']) ?>
                    </h3>
                    <span class="kpi-sub">
                        <?= $proximoFeriado['data_formatada'] ?>
                        · <?= $proximoFeriado['dias_restantes'] === 0
                                ? 'Hoje!'
                                : 'em ' . $proximoFeriado['dias_restantes'] . ' dia(s)' ?>
                    </span>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="chart-card">
        <h5 class="chart-title">Reservas por Mês</h5>
        <canvas id="chartReservas" height="80"></canvas>
    </div>
</main>

<script>
    window.APP_DASHBOARD = <?= json_encode($appDashboard) ?>;
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>