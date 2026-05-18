<?php
$paginaTitulo = 'Dashboard - Síndico';
$cssExtra     = 'dashboard.css';
$jsExtra      = 'dashboard.js';
?>
<?php require_once __DIR__ . '/../layout/header.php'; ?>

<main class="main-content" id="app">
    <div class="page-header">
        <h2>Dashboard</h2>
        <p class="text-muted">Bem-vindo, <?= htmlspecialchars(explode(' ', $usuario['nome'])[0]) ?>!</p>
    </div>

    <!-- 1. KPIs -->
    <section class="dashboard-section">
        <div class="kpi-grid">
            <a href="<?= BASE_URL ?>/moradores/pendentes" class="kpi-card kpi-card-link">
                <div class="kpi-icon" style="background:#eff8ff;color:#0f80b6">
                    <i class="bx bx-group"></i>
                </div>
                <div>
                    <p class="kpi-label">Moradores Ativos</p>
                    <h3 class="kpi-value"><?= (int) ($moradoresAtivos ?? 0) ?></h3>
                </div>
            </a>
            <a href="<?= BASE_URL ?>/reserva" class="kpi-card kpi-card-link">
                <div class="kpi-icon" style="background:#fef9c3;color:#ca8a04">
                    <i class="bx bx-calendar-check"></i>
                </div>
                <div>
                    <p class="kpi-label">Reservas Pendentes</p>
                    <h3 class="kpi-value"><?= (int) ($reservasPendentes ?? 0) ?></h3>
                </div>
            </a>
            <a href="<?= BASE_URL ?>/ocorrencia/painel" class="kpi-card kpi-card-link">
                <div class="kpi-icon" style="background:#fee2e2;color:#dc2626">
                    <i class="bx bx-error-circle"></i>
                </div>
                <div>
                    <p class="kpi-label">Ocorrências Abertas</p>
                    <h3 class="kpi-value"><?= (int) ($ocorrenciasGeral['aberto'] ?? 0) ?></h3>
                </div>
            </a>
            <a href="<?= BASE_URL ?>/reserva" class="kpi-card kpi-card-link">
                <div class="kpi-icon" style="background:#f0fdf4;color:#16a34a">
                    <i class="bx bx-building-house"></i>
                </div>
                <div>
                    <p class="kpi-label">Locais Disponíveis</p>
                    <h3 class="kpi-value"><?= (int) ($locaisTotal ?? 0) ?></h3>
                </div>
            </a>
        </div>
    </section>

    <!-- 2. Gráfico Reservas + Ocorrências -->
    <section class="dashboard-section">
        <div class="row g-3">
            <div class="col-12 col-lg-7">
                <div class="chart-card h-100 d-flex flex-column">
                    <h5 class="chart-title">Reservas por Mês — <?= date('Y') ?></h5>
                    <div class="dashboard-chart-box">
                        <canvas id="chartReservas"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-5">
                <div class="chart-card h-100 d-flex flex-column">
                    <h5 class="chart-title">Ocorrências por Status</h5>
                    <div class="ocorrencia-chart-wrap">
                        <canvas id="chartOcorrenciasSindico"></canvas>
                    </div>
                    <div class="ocorrencia-legenda mt-3">
                        <div class="ocorrencia-legenda-item">
                            <span class="ocorrencia-dot" style="background:#EF4444"></span>
                            <span>Abertas</span>
                            <strong><?= (int) ($ocorrenciasGeral['aberto'] ?? 0) ?></strong>
                        </div>
                        <div class="ocorrencia-legenda-item">
                            <span class="ocorrencia-dot" style="background:#F59E0B"></span>
                            <span>Em andamento</span>
                            <strong><?= (int) ($ocorrenciasGeral['andamento'] ?? 0) ?></strong>
                        </div>
                        <div class="ocorrencia-legenda-item">
                            <span class="ocorrencia-dot" style="background:#22C55E"></span>
                            <span>Resolvidas</span>
                            <strong><?= (int) ($ocorrenciasGeral['resolvido'] ?? 0) ?></strong>
                        </div>
                        <div class="ocorrencia-legenda-item">
                            <span class="ocorrencia-dot" style="background:#94A3B8"></span>
                            <span>Canceladas</span>
                            <strong><?= (int) ($ocorrenciasGeral['cancelado'] ?? 0) ?></strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. Reservas da semana -->
    <section class="dashboard-section">
        <h3 class="section-title">Reservas dos Próximos 7 Dias</h3>
        <?php if (empty($reservasSemana)): ?>
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="bx bx-calendar"></i>
                </div>
                <h5>Nenhuma reserva na semana</h5>
                <p>Sem reservas agendadas para os próximos 7 dias.</p>
            </div>
        <?php else: ?>
            <div class="row g-3">
                <?php foreach ($reservasSemana as $r): ?>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="reserva-card">
                            <div class="reserva-header">
                                <h4 class="reserva-local mb-0 flex-grow-1">
                                    <?= htmlspecialchars($r['local']) ?>
                                </h4>
                                <span class="reserva-badge <?= $r['status'] ?>">
                                    <?= match ($r['status']) {
                                        'A' => 'Aprovada',
                                        'P' => 'Pendente',
                                        'N' => 'Negada',
                                        default => $r['status']
                                    } ?>
                                </span>
                            </div>
                            <div class="reserva-body">
                                <div class="reserva-datetime">
                                    <i class="bx bx-calendar"></i>
                                    <span><?= date('d/m/Y', strtotime($r['data_reserva'])) ?></span>
                                    <span>•</span>
                                    <span><?= substr($r['hora_ini'], 0, 5) ?> - <?= substr($r['hora_fim'], 0, 5) ?></span>
                                </div>
                                <div class="reserva-aprovador">
                                    <i class="bx bx-user"></i>
                                    <span><?= htmlspecialchars($r['nome_morador']) ?> — Bl. <?= htmlspecialchars($r['bloco']) ?> Ap. <?= htmlspecialchars($r['apto']) ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>

    <!-- 4. Feriados -->
    <section class="dashboard-section">
        <h3 class="section-title">Próximos Feriados</h3>
        <?php if (!empty($proximosFeriados)): ?>
            <div class="row g-3">
                <?php foreach ($proximosFeriados as $feriado): ?>
                    <div class="col-12 col-md-4">
                        <article class="feriado-card">
                            <div class="feriado-card-top">
                                <div class="feriado-card-icon">
                                    <i class="bx bx-party"></i>
                                </div>
                                <div>
                                    <h4 class="feriado-nome"><?= htmlspecialchars($feriado['name']) ?></h4>
                                    <p class="feriado-data"><?= htmlspecialchars($feriado['data_formatada']) ?></p>
                                </div>
                            </div>
                            <span class="feriado-restante">
                                <?= (int) $feriado['dias_restantes'] === 0 ? 'Hoje' : 'Em ' . (int) $feriado['dias_restantes'] . ' dia(s)' ?>
                            </span>
                        </article>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="dashboard-placeholder">Nenhum feriado próximo disponível.</div>
        <?php endif; ?>
    </section>
</main>

<script>
    window.APP_DASHBOARD = <?= json_encode([
                                'chartLabels' => $chartLabels,
                                'chartDados'  => $chartDados,
                                'chartOcorrenciasSindico' => [
                                    'labels' => ['Abertas', 'Em andamento', 'Resolvidas', 'Canceladas'],
                                    'dados'  => [
                                        (int) ($ocorrenciasGeral['aberto']    ?? 0),
                                        (int) ($ocorrenciasGeral['andamento'] ?? 0),
                                        (int) ($ocorrenciasGeral['resolvido'] ?? 0),
                                        (int) ($ocorrenciasGeral['cancelado'] ?? 0),
                                    ]
                                ]
                            ]) ?>;
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>