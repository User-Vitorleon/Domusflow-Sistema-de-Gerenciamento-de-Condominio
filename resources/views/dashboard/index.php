<?php
$paginaTitulo = 'Dashboard';
$paginaAtiva  = 'dashboard';
$cssExtra = 'dashboard.css';
$jsExtra = 'dashboard.js';
require_once __DIR__ . '/../layout/header.php';
?>

<main class="main-content" id="app">
    <div class="page-header">
        <h2>Dashboard</h2>
        <p class="text-muted">Bem-vindo, <?= htmlspecialchars(explode(' ', $usuario['nome'])[0]) ?>!</p>
    </div>

    <h3 class="section-title">Minhas Reservas</h3>
    <?php if (empty($minhasReservas)): ?>
        <p class="text-muted">Você ainda não possui reservas efetuadas.</p>
    <?php else: ?>
        <?php foreach ($minhasReservas as $reserva):
            switch ($reserva['status']) {
                case 'A':
                    $corFundo   = '#DCFCE7';
                    $corTexto   = '#16A34A';
                    $textoStatus = 'Aprovada';
                    $icone      = 'bx-check-circle';
                    break;
                case 'N':
                    $corFundo   = '#FEF2F2';
                    $corTexto   = '#EF4444';
                    $textoStatus = 'Negada';
                    $icone      = 'bx-x-circle';
                    break;
                default: // 'P'
                    $corFundo   = '#FEF9C3';
                    $corTexto   = '#CA8A04';
                    $textoStatus = 'Pendente';
                    $icone      = 'bx-time';
                    break;
            }
        ?>
            <div class="kpi-card kpi-card-feriado" style="margin-bottom: 15px;">
                <div class="kpi-icon" style="background: <?= $corFundo ?>; color: <?= $corTexto ?>;">
                    <i class='bx <?= $icone ?>'></i>
                </div>
                <div>
                    <p class="kpi-label">Local Reservado</p>
                    <h3 class="kpi-value kpi-value-sm">
                        <?= htmlspecialchars($reserva['local']) ?>
                    </h3>
                    <span class="kpi-sub">
                        Data: <?= date('d/m/Y', strtotime($reserva['data_reserva'])) ?> |
                        <strong>Status: <?= $textoStatus ?></strong>
                    </span>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <br>

    <?php if (($usuario['privilegio'] ?? 0) == 2): ?>
        <h3 class="section-title">Visão Geral do Condomínio</h3>
        <div class="kpi-grid">
            <div class="kpi-card">
                <div class="kpi-icon" style="background:#EFF8FF; color:#0F80B6;">
                    <i class="bx bx-calendar"></i>
                </div>
                <div>
                    <p class="kpi-label">Reservas Pendentes</p>
                    <h3 class="kpi-value"><?= $reservasPendentes ?></h3>
                </div>
            </div>

            <div class="kpi-card">
                <div class="kpi-icon" style="background:#F0FDF4; color:#22C55E;">
                    <i class="bx bx-building-house"></i>
                </div>
                <div>
                    <p class="kpi-label">Locais Disponíveis</p>
                    <h3 class="kpi-value"><?= $locaisDisponiveis ?></h3>
                </div>
            </div>

            <div class="kpi-card">
                <div class="kpi-icon" style="background:#FFFBEB; color:#F59E0B;">
                    <i class="bx bx-group"></i>
                </div>
                <div>
                    <p class="kpi-label">Moradores Ativos</p>
                    <h3 class="kpi-value"><?= $moradoresAtivos ?></h3>
                </div>

            </div>
        </div>

        <div class="chart-card" style="margin-top: 20px;">
            <h5 class="chart-title">Fluxo de Reservas por Mês</h5>
            <canvas id="chartReservas" height="80"></canvas>
        </div>
    <?php endif; ?>

    <br>

    <h3 class="section-title">Próximos Feriados</h3>
    <?php if ($proximoFeriado): ?>
        <div class="kpi-card kpi-card-feriado">
            <div class="kpi-icon" style="background:#FEF2F2; color:#EF4444;">
                <i class='bx bx-party'></i>
            </div>
            <div>
                <p class="kpi-label">Fique atento:</p>
                <h3 class="kpi-value kpi-value-sm">
                    <?= htmlspecialchars($proximoFeriado['name']) ?>
                </h3>
                <span class="kpi-sub">
                    <?= $proximoFeriado['data_formatada'] ?>
                    · <?= $proximoFeriado['dias_restantes'] === 0 ? 'Hoje!' : 'em ' . $proximoFeriado['dias_restantes'] . ' dia(s)' ?>
                </span>
            </div>
        </div>
    <?php else: ?>
        <p class="text-muted">Nenhum feriado próximo mapeado.</p>
    <?php endif; ?>

    <br>
</main>

<script>
    // Passa os dados para o dashboard.js (Gráficos)
    window.APP_DASHBOARD = <?= json_encode([
                                'chartLabels' => $chartLabels,
                                'chartDados'  => $chartDados
                            ]) ?>;
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>