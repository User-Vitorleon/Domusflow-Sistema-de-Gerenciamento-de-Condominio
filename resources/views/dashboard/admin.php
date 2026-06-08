<?php
$paginaTitulo = 'Dashboard - Admin';
$cssExtra     = 'dashboard.css';
$jsExtra      = 'dashboard.js';

$statusConfig = [
    'L' => ['Ativos',     '#22C55E', 'bx-check-circle'],
    'P' => ['Pendentes',  '#F59E0B', 'bx-time'],
    'I' => ['Inativos',   '#94A3B8', 'bx-pause-circle'],
    'B' => ['Bloqueados', '#EF4444', 'bx-block'],
    'E' => ['Exclu&iacute;dos',  '#374151', 'bx-user-x'],
];

$totalMoradores = array_sum(array_map(
    fn($k) => (int) ($moradoresStatus[$k] ?? 0),
    array_keys($statusConfig)
));
$totalOcorrencias = (int) ($ocorrenciasGeral['total'] ?? 0);
$totalCriticas = (int) ($moradoresPendentes ?? 0)
    + (int) ($reservasPendentes ?? 0)
    + (int) ($countInadimplentes ?? 0)
    + (int) ($moradoresStatus['B'] ?? 0);
?>
<?php require_once __DIR__ . '/../layout/header.php'; ?>

<main class="main-content admin-dashboard" id="app">
    <div class="admin-dashboard-shell">
        <div class="page-header admin-dashboard-header">
            <div>
                <h2>Dashboard Admin</h2>
                <p class="text-muted">Vis&atilde;o geral do condom&iacute;nio e dos principais pontos de aten&ccedil;&atilde;o.</p>
            </div>
        </div>

        <section class="admin-kpi-grid">
            <a href="<?= BASE_URL ?>/moradores/gestao" class="admin-kpi-card admin-kpi-card--primary">
                <span class="admin-kpi-icon"><i class='bx bx-group'></i></span>
                <span class="admin-kpi-label">Moradores cadastrados</span>
                <strong class="admin-kpi-value"><?= (int) $totalMoradores ?></strong>
                <small><?= (int) ($moradoresStatus['L'] ?? 0) ?> ativos</small>
            </a>
            <a href="<?= BASE_URL ?>/moradores/pendentes" class="admin-kpi-card">
                <span class="admin-kpi-icon admin-kpi-icon--warning"><i class='bx bx-user-plus'></i></span>
                <span class="admin-kpi-label">Cadastros pendentes</span>
                <strong class="admin-kpi-value"><?= (int) ($moradoresPendentes ?? 0) ?></strong>
                <small>Aguardando an&aacute;lise</small>
            </a>
            <a href="<?= BASE_URL ?>/reserva?visao=solicitacoes" class="admin-kpi-card">
                <span class="admin-kpi-icon admin-kpi-icon--info"><i class='bx bx-calendar-check'></i></span>
                <span class="admin-kpi-label">Reservas pendentes</span>
                <strong class="admin-kpi-value"><?= (int) ($reservasPendentes ?? 0) ?></strong>
                <small>Solicita&ccedil;&otilde;es abertas</small>
            </a>
            <a href="<?= BASE_URL ?>/financeiro/lancamento" class="admin-kpi-card">
                <span class="admin-kpi-icon admin-kpi-icon--danger"><i class='bx bx-wallet'></i></span>
                <span class="admin-kpi-label">Inadimplentes</span>
                <strong class="admin-kpi-value"><?= (int) ($countInadimplentes ?? 0) ?></strong>
                <small>Com cobran&ccedil;as em aberto</small>
            </a>
        </section>

        <section class="admin-dashboard-grid admin-dashboard-grid--main">
            <article class="chart-card admin-panel admin-panel--wide">
                <div class="admin-panel-head">
                    <div>
                        <h3>Moradores por status</h3>
                        <p>Distribui&ccedil;&atilde;o dos cadastros no sistema.</p>
                    </div>
                    <a href="<?= BASE_URL ?>/moradores/gestao" class="admin-panel-link">Gerenciar</a>
                </div>
                <div class="admin-status-list">
                    <?php foreach ($statusConfig as $key => [$label, $cor, $icone]): ?>
                        <?php
                        $qtd = (int) ($moradoresStatus[$key] ?? 0);
                        $pct = $totalMoradores > 0 ? round(($qtd / $totalMoradores) * 100) : 0;
                        ?>
                        <div class="admin-status-row">
                            <span class="admin-status-icon" style="color:<?= $cor ?>"><i class='bx <?= $icone ?>'></i></span>
                            <div class="admin-status-main">
                                <div class="admin-status-top">
                                    <strong><?= $label ?></strong>
                                    <span><?= $qtd ?> <small><?= $pct ?>%</small></span>
                                </div>
                                <div class="admin-progress"><span style="width:<?= $pct ?>%;background:<?= $cor ?>"></span></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </article>

            <article class="chart-card admin-panel">
                <div class="admin-panel-head">
                    <div>
                        <h3>Ocorr&ecirc;ncias</h3>
                        <p><?= $totalOcorrencias ?> registro(s) no total.</p>
                    </div>
                    <a href="<?= BASE_URL ?>/ocorrencia/painel" class="admin-panel-link">Ver painel</a>
                </div>
                <div class="admin-chart-wrap">
                    <canvas id="chartOcorrenciasAdmin"></canvas>
                </div>
                <div class="admin-mini-list">
                    <span><i style="background:#EF4444"></i>Abertas <strong><?= (int) ($ocorrenciasGeral['aberto'] ?? 0) ?></strong></span>
                    <span><i style="background:#F59E0B"></i>Em andamento <strong><?= (int) ($ocorrenciasGeral['andamento'] ?? 0) ?></strong></span>
                    <span><i style="background:#22C55E"></i>Resolvidas <strong><?= (int) ($ocorrenciasGeral['resolvido'] ?? 0) ?></strong></span>
                    <span><i style="background:#94A3B8"></i>Canceladas <strong><?= (int) ($ocorrenciasGeral['cancelado'] ?? 0) ?></strong></span>
                </div>
            </article>
        </section>

        <section class="admin-dashboard-grid admin-dashboard-grid--secondary">
            <article class="chart-card admin-panel">
                <div class="admin-panel-head">
                    <div>
                        <h3>Financeiro</h3>
                        <p>Resumo das cobran&ccedil;as do condom&iacute;nio.</p>
                    </div>
                    <a href="<?= BASE_URL ?>/financeiro/lancamento" class="admin-panel-link">Lan&ccedil;amentos</a>
                </div>
                <div class="admin-finance-grid">
                    <div><span>Total em aberto</span><strong>R$ <?= number_format((float) ($totalPendenteGeral ?? 0), 2, ',', '.') ?></strong></div>
                    <div><span>Faturas geradas</span><strong><?= (int) ($countFaturas ?? 0) ?></strong></div>
                    <div><span>Pendentes</span><strong><?= (int) ($countLancPendentes ?? 0) ?></strong></div>
                    <div><span>Inadimplentes</span><strong><?= (int) ($countInadimplentes ?? 0) ?></strong></div>
                </div>
            </article>

            <article class="chart-card admin-panel admin-alert-panel">
                <div class="admin-panel-head">
                    <div>
                        <h3>Pontos de aten&ccedil;&atilde;o</h3>
                        <p>Itens que pedem acompanhamento.</p>
                    </div>
                    <strong class="admin-alert-count"><?= $totalCriticas ?></strong>
                </div>
                <div class="admin-alert-list">
                    <a href="<?= BASE_URL ?>/moradores/pendentes"><i class='bx bx-user-check'></i><span>Cadastros pendentes</span><strong><?= (int) ($moradoresPendentes ?? 0) ?></strong></a>
                    <a href="<?= BASE_URL ?>/reserva?visao=solicitacoes"><i class='bx bx-calendar'></i><span>Reservas pendentes</span><strong><?= (int) ($reservasPendentes ?? 0) ?></strong></a>
                    <a href="<?= BASE_URL ?>/financeiro/lancamento"><i class='bx bx-error-circle'></i><span>Moradores inadimplentes</span><strong><?= (int) ($countInadimplentes ?? 0) ?></strong></a>
                    <a href="<?= BASE_URL ?>/moradores/gestao?status=B"><i class='bx bx-block'></i><span>Moradores bloqueados</span><strong><?= (int) ($moradoresStatus['B'] ?? 0) ?></strong></a>
                </div>
            </article>
        </section>

        <section class="admin-dashboard-grid admin-dashboard-grid--lists">
            <article class="chart-card admin-panel">
                <div class="admin-panel-head">
                    <div>
                        <h3>A&ccedil;&otilde;es administrativas</h3>
                        <p>Atalhos para os m&oacute;dulos de gest&atilde;o.</p>
                    </div>
                    <a href="<?= BASE_URL ?>/painel" class="admin-panel-link">Ver m&oacute;dulos</a>
                </div>
                <div class="admin-priority-list">
                    <a href="<?= BASE_URL ?>/moradores/gestao"><i class='bx bx-group'></i><div><strong>Gest&atilde;o de moradores</strong><span>Privil&eacute;gios, status e unidade</span></div><b>&rarr;</b></a>
                    <a href="<?= BASE_URL ?>/parametros"><i class='bx bx-cog'></i><div><strong>Par&acirc;metros</strong><span>Regras gerais do sistema</span></div><b>&rarr;</b></a>
                    <a href="<?= BASE_URL ?>/financeiro/lancamento"><i class='bx bx-money'></i><div><strong>Financeiro</strong><span>Lan&ccedil;amentos e cobran&ccedil;as</span></div><b>&rarr;</b></a>
                    <a href="<?= BASE_URL ?>/ocorrencia/painel"><i class='bx bx-error'></i><div><strong>Ocorr&ecirc;ncias</strong><span>Acompanhamento dos chamados</span></div><b>&rarr;</b></a>
                    <a href="<?= BASE_URL ?>/reserva?visao=solicitacoes"><i class='bx bx-calendar'></i><div><strong>Reservas</strong><span>Fila de solicita&ccedil;&otilde;es pendentes</span></div><b><?= (int) ($reservasPendentes ?? 0) ?></b></a>
                </div>
            </article>

            <article class="chart-card admin-panel">
                <div class="admin-panel-head">
                    <div>
                        <h3>&Uacute;ltimos moradores</h3>
                        <p>Cadastros mais recentes.</p>
                    </div>
                    <a href="<?= BASE_URL ?>/moradores/gestao" class="admin-panel-link">Ver todos</a>
                </div>
                <?php if (empty($ultimosMoradores)): ?>
                    <div class="dashboard-placeholder">Nenhum morador cadastrado.</div>
                <?php else: ?>
                    <div class="admin-user-list">
                        <?php foreach ($ultimosMoradores as $m): ?>
                            <?php
                            $stConfig = [
                                'L' => ['Ativo', '#16a34a', '#f0fdf4'],
                                'P' => ['Pendente', '#ca8a04', '#fef9c3'],
                                'I' => ['Inativo', '#64748b', '#f1f5f9'],
                                'B' => ['Bloqueado', '#dc2626', '#fee2e2'],
                                'E' => ['Exclu&iacute;do', '#374151', '#f1f5f9'],
                            ];
                            [$stLabel, $stCor, $stFundo] = $stConfig[$m['status']] ?? ['?', '#94a3b8', '#f1f5f9'];
                            ?>
                            <div class="admin-user-row">
                                <div>
                                    <strong><?= htmlspecialchars($m['nome']) ?></strong>
                                    <span>Bl. <?= htmlspecialchars($m['bloco']) ?> Ap. <?= htmlspecialchars($m['apto']) ?> - <?= date('d/m/Y', strtotime($m['created_at'])) ?></span>
                                </div>
                                <em style="background:<?= $stFundo ?>;color:<?= $stCor ?>"><?= $stLabel ?></em>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </article>
        </section>
    </div>
</main>

<script type="application/json" id="dashboard-data"><?= json_encode([
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
]) ?></script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
