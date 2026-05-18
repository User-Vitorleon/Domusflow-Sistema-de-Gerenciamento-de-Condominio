<?php
$paginaTitulo = 'Dashboard - Admin';
$cssExtra     = 'dashboard.css';
$jsExtra      = 'dashboard.js';
?>
<?php require_once __DIR__ . '/../layout/header.php'; ?>


<main class="main-content" id="app">
    <div class="page-header">
        <h2>Dashboard</h2>
        <p class="text-muted">Visão sistêmica do condomínio</p>
    </div>

    <!-- 1. KPIs -->
    <section class="dashboard-section">
        <div class="kpi-grid">
            <a href="<?= BASE_URL ?>/moradores/pendentes" class="kpi-card kpi-card-link">
                <div class="kpi-icon" style="background:#eff8ff;color:#0f80b6">
                    <i class="bx bx-group"></i>
                </div>
                <div>
                    <p class="kpi-label">Total Moradores</p>
                    <h3 class="kpi-value"><?= (int) (($moradoresStatus['P'] ?? 0) + ($moradoresStatus['L'] ?? 0) + ($moradoresStatus['I'] ?? 0) + ($moradoresStatus['B'] ?? 0)) ?></h3>
                </div>
            </a>
            <a href="<?= BASE_URL ?>/moradores/pendentes" class="kpi-card kpi-card-link">
                <div class="kpi-icon" style="background:#fef9c3;color:#ca8a04">
                    <i class="bx bx-time"></i>
                </div>
                <div>
                    <p class="kpi-label">Pendentes Aprovação</p>
                    <h3 class="kpi-value"><?= (int) ($moradoresPendentes ?? 0) ?></h3>
                </div>
            </a>
            <a href="<?= BASE_URL ?>/financeiro/lancamento" class="kpi-card kpi-card-link">
                <div class="kpi-icon" style="background:#fdf4ff;color:#9333ea">
                    <i class="bx bx-money"></i>
                </div>
                <div>
                    <p class="kpi-label">Inadimplentes</p>
                    <h3 class="kpi-value"><?= (int) ($countInadimplentes ?? 0) ?></h3>
                </div>
            </a>
            <a href="<?= BASE_URL ?>/veiculo" class="kpi-card kpi-card-link">
                <div class="kpi-icon" style="background:#f0fdf4;color:#16a34a">
                    <i class="bx bx-car"></i>
                </div>
                <div>
                    <p class="kpi-label">Veículos</p>
                    <h3 class="kpi-value"><?= (int) ($totalVeiculos ?? 0) ?></h3>
                </div>
            </a>
        </div>
    </section>

    <!-- 2. Moradores por status + Ocorrências -->
    <section class="dashboard-section">
        <div class="row g-3">
            <div class="col-12 col-lg-7">
                <div class="chart-card h-100">
                    <h5 class="chart-title">Moradores por Status</h5>
                    <?php
                    $statusConfig = [
                        'L' => ['Liberados',  '#22C55E'],
                        'P' => ['Pendentes',  '#F59E0B'],
                        'I' => ['Inativos',   '#94A3B8'],
                        'B' => ['Bloqueados', '#EF4444'],
                        'E' => ['Excluídos',  '#374151'],
                    ];
                    $totalMoradores = array_sum(array_map(
                        fn($k) => (int) ($moradoresStatus[$k] ?? 0),
                        array_keys($statusConfig)
                    ));
                    ?>
                    <div class="dashboard-list mt-2">
                        <?php foreach ($statusConfig as $key => [$label, $cor]): ?>
                            <?php
                            $qtd = (int) ($moradoresStatus[$key] ?? 0);
                            $pct = $totalMoradores > 0 ? round(($qtd / $totalMoradores) * 100) : 0;
                            ?>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span style="font-size:13px;font-weight:600"><?= $label ?></span>
                                    <span style="font-size:13px;color:var(--text-muted)"><?= $qtd ?> <small>(<?= $pct ?>%)</small></span>
                                </div>
                                <div class="progress" style="height:6px;border-radius:99px;background:var(--border)">
                                    <div class="progress-bar" style="width:<?= $pct ?>%;background:<?= $cor ?>;border-radius:99px"></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-5">
                <div class="chart-card h-100">
                    <h5 class="chart-title">Ocorrências por Status</h5>
                    <div class="ocorrencia-chart-wrap">
                        <canvas id="chartOcorrenciasAdmin"></canvas>
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

    <!-- 3. Financeiro -->
    <section class="dashboard-section">
        <h3 class="section-title">Financeiro</h3>
        <div class="kpi-grid">
            <div class="kpi-card">
                <div class="kpi-icon" style="background:#fee2e2;color:#dc2626">
                    <i class="bx bx-wallet"></i>
                </div>
                <div>
                    <p class="kpi-label">Total em Aberto</p>
                    <h3 class="kpi-value" style="font-size:20px">
                        R$ <?= number_format((float) ($totalPendenteGeral ?? 0), 2, ',', '.') ?>
                    </h3>
                </div>
            </div>
            <div class="kpi-card">
                <div class="kpi-icon" style="background:#fef9c3;color:#ca8a04">
                    <i class="bx bx-receipt"></i>
                </div>
                <div>
                    <p class="kpi-label">Lançamentos Pendentes</p>
                    <h3 class="kpi-value"><?= (int) ($countLancPendentes ?? 0) ?></h3>
                </div>
            </div>
            <div class="kpi-card">
                <div class="kpi-icon" style="background:#f0fdf4;color:#16a34a">
                    <i class="bx bx-file"></i>
                </div>
                <div>
                    <p class="kpi-label">Faturas Geradas</p>
                    <h3 class="kpi-value"><?= (int) ($countFaturas ?? 0) ?></h3>
                </div>
            </div>
            <div class="kpi-card">
                <div class="kpi-icon" style="background:#fdf4ff;color:#9333ea">
                    <i class="bx bx-user-minus"></i>
                </div>
                <div>
                    <p class="kpi-label">Inadimplentes</p>
                    <h3 class="kpi-value"><?= (int) ($countInadimplentes ?? 0) ?></h3>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. Top Marcas Veículos -->
    <section class="dashboard-section">
        <div class="row g-3">
            <div class="col-12 col-md-6">
                <div class="chart-card h-100">
                    <h5 class="chart-title">Top Marcas de Veículos</h5>
                    <?php if (empty($topMarcasVeiculos)): ?>
                        <div class="dashboard-placeholder">Sem dados de veículos.</div>
                    <?php else: ?>
                        <?php $maxMarca = max(array_column($topMarcasVeiculos, 'total')); ?>
                        <div class="dashboard-list mt-2">
                            <?php foreach ($topMarcasVeiculos as $i => $marca): ?>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span style="font-size:13px;font-weight:600"><?= htmlspecialchars($marca['marca']) ?></span>
                                        <span style="font-size:13px;color:var(--text-muted)"><?= (int) $marca['total'] ?></span>
                                    </div>
                                    <div class="progress" style="height:6px;border-radius:99px;background:var(--border)">
                                        <div class="progress-bar"
                                            style="width:<?= round(($marca['total'] / $maxMarca) * 100) ?>%;
                                                    background:<?= ['#0f80b6', '#22c55e', '#f59e0b'][$i] ?? '#94a3b8' ?>;
                                                    border-radius:99px">
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- 5. Últimos moradores cadastrados -->
            <div class="col-12 col-md-6">
                <div class="chart-card h-100">
                    <h5 class="chart-title">Últimos Moradores Cadastrados</h5>
                    <?php if (empty($ultimosMoradores)): ?>
                        <div class="dashboard-placeholder">Nenhum morador cadastrado.</div>
                    <?php else: ?>
                        <div class="dashboard-list mt-2">
                            <?php foreach ($ultimosMoradores as $m): ?>
                                <?php
                                $stConfig = [
                                    'L' => ['Liberado',  '#16a34a', '#f0fdf4'],
                                    'P' => ['Pendente',  '#ca8a04', '#fef9c3'],
                                    'I' => ['Inativo',   '#64748b', '#f1f5f9'],
                                    'B' => ['Bloqueado', '#dc2626', '#fee2e2'],
                                    'E' => ['Excluído',  '#374151', '#f1f5f9'],
                                ];
                                [$stLabel, $stCor, $stFundo] = $stConfig[$m['status']] ?? ['?', '#94a3b8', '#f1f5f9'];
                                ?>
                                <div class="reserva-semana-item">
                                    <div class="reserva-semana-info">
                                        <div class="reserva-semana-local"><?= htmlspecialchars($m['nome']) ?></div>
                                        <div class="reserva-semana-morador">
                                            Bl. <?= htmlspecialchars($m['bloco']) ?> Ap. <?= htmlspecialchars($m['apto']) ?>
                                            — <?= date('d/m/Y', strtotime($m['created_at'])) ?>
                                        </div>
                                    </div>
                                    <span style="font-size:11px;font-weight:700;padding:3px 10px;border-radius:999px;
                                                 background:<?= $stFundo ?>;color:<?= $stCor ?>">
                                        <?= $stLabel ?>
                                    </span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
    window.APP_DASHBOARD = <?= json_encode([
                                'chartLabels' => $chartLabels,
                                'chartDados'  => $chartDados,
                                'chartOcorrenciasAdmin' => [
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