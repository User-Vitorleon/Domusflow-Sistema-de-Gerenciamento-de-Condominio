<?php
$paginaTitulo = 'Dashboard - Síndico';
$cssExtra = 'dashboard.css';

$reservasPendentesLista = array_slice($reservasParaAprovar ?? [], 0, 6);
?>
<?php require_once __DIR__ . '/../layout/header.php'; ?>

<main class="main-content" id="app">
    <div class="page-header">
        <h2>Dashboard Síndico</h2>
        <p class="text-muted">Pendências operacionais e indicadores principais do condomínio.</p>
    </div>

    <section class="dashboard-section">
        <div class="kpi-grid">
            <a href="<?= BASE_URL ?>/moradores/pendentes" class="kpi-card kpi-card-link">
                <div class="kpi-icon" style="background:#eff8ff;color:#0f80b6"><i class="bx bx-user-plus"></i></div>
                <div>
                    <p class="kpi-label">Cadastros pendentes</p>
                    <h3 class="kpi-value"><?= (int) ($moradoresPendentes ?? 0) ?></h3>
                </div>
            </a>
            <a href="<?= BASE_URL ?>/reserva" class="kpi-card kpi-card-link">
                <div class="kpi-icon" style="background:#fef9c3;color:#ca8a04"><i class="bx bx-calendar-check"></i></div>
                <div>
                    <p class="kpi-label">Reservas pendentes</p>
                    <h3 class="kpi-value"><?= (int) ($reservasPendentes ?? 0) ?></h3>
                </div>
            </a>
            <a href="<?= BASE_URL ?>/ocorrencia/painel?status=A" class="kpi-card kpi-card-link">
                <div class="kpi-icon" style="background:#fee2e2;color:#dc2626"><i class="bx bx-error-circle"></i></div>
                <div>
                    <p class="kpi-label">Ocorrências abertas</p>
                    <h3 class="kpi-value"><?= (int) ($ocorrenciasGeral['aberto'] ?? 0) ?></h3>
                </div>
            </a>
            <a href="<?= BASE_URL ?>/financeiro/lancamento?status=atraso" class="kpi-card kpi-card-link">
                <div class="kpi-icon" style="background:#fff7ed;color:#ea580c"><i class="bx bx-money-withdraw"></i></div>
                <div>
                    <p class="kpi-label">Lançamentos em aberto</p>
                    <h3 class="kpi-value"><?= (int) ($countLancPendentes ?? 0) ?></h3>
                </div>
            </a>
        </div>
    </section>

    <section class="dashboard-section">
        <h3 class="section-title">Próximos 2 feriados</h3>
        <?php if (!empty($proximosFeriados)): ?>
            <div class="feriado-grid feriado-grid--compact">
                <?php foreach ($proximosFeriados as $feriado): ?>
                    <article class="feriado-card">
                        <div class="feriado-card-top">
                            <div class="feriado-card-icon"><i class="bx bx-calendar-star"></i></div>
                            <div>
                                <h4 class="feriado-nome"><?= htmlspecialchars($feriado['name']) ?></h4>
                                <p class="feriado-data"><?= htmlspecialchars($feriado['data_formatada']) ?></p>
                            </div>
                        </div>
                        <span class="feriado-restante">
                            <?= (int) $feriado['dias_restantes'] === 0 ? 'Hoje' : 'Em ' . (int) $feriado['dias_restantes'] . ' dia(s)' ?>
                        </span>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="dashboard-placeholder">Nenhum feriado próximo disponível.</div>
        <?php endif; ?>
    </section>

    <section class="dashboard-section">
        <div class="dashboard-card-grid dashboard-card-grid--two">
            <div class="chart-card">
                <h5 class="chart-title">Ocorrências por status</h5>
                <div class="dashboard-list-row"><span>Abertas</span><strong><?= (int) ($ocorrenciasGeral['aberto'] ?? 0) ?></strong></div>
                <div class="dashboard-list-row"><span>Em andamento</span><strong><?= (int) ($ocorrenciasGeral['andamento'] ?? 0) ?></strong></div>
                <div class="dashboard-list-row"><span>Resolvidas</span><strong><?= (int) ($ocorrenciasGeral['resolvido'] ?? 0) ?></strong></div>
                <div class="dashboard-list-row"><span>Canceladas</span><strong><?= (int) ($ocorrenciasGeral['cancelado'] ?? 0) ?></strong></div>
            </div>
            <div class="chart-card">
                <h5 class="chart-title">Situação dos moradores</h5>
                <div class="dashboard-list-row"><span>Ativos</span><strong><?= (int) ($moradoresAtivos ?? 0) ?></strong></div>
                <div class="dashboard-list-row"><span>Pendentes</span><strong><?= (int) ($moradoresPendentes ?? 0) ?></strong></div>
                <div class="dashboard-list-row"><span>Inativos</span><strong><?= (int) ($moradoresStatus['I'] ?? 0) ?></strong></div>
                <div class="dashboard-list-row"><span>Bloqueados</span><strong><?= (int) ($moradoresStatus['B'] ?? 0) ?></strong></div>
            </div>
        </div>
    </section>

    <section class="dashboard-section">
        <h3 class="section-title">Reservas aguardando decisão</h3>
        <?php if (empty($reservasPendentesLista)): ?>
            <div class="dashboard-placeholder">Nenhuma reserva pendente no momento.</div>
        <?php else: ?>
            <div class="dashboard-card-grid">
                <?php foreach ($reservasPendentesLista as $r): ?>
                    <article class="reserva-card">
                        <div class="reserva-header">
                            <h4 class="reserva-local"><?= htmlspecialchars($r['local']) ?></h4>
                            <span class="reserva-badge P">Pendente</span>
                        </div>
                        <div class="reserva-body">
                            <div class="reserva-datetime">
                                <i class="bx bx-calendar"></i>
                                <span><?= date('d/m/Y', strtotime($r['data_reserva'])) ?></span>
                                <span><?= substr($r['hora_ini'], 0, 5) ?> - <?= substr($r['hora_fim'], 0, 5) ?></span>
                            </div>
                            <div class="reserva-aprovador">
                                <i class="bx bx-user"></i>
                                <span><?= htmlspecialchars($r['nome_morador']) ?> - Bl. <?= htmlspecialchars($r['bloco']) ?> Ap. <?= htmlspecialchars($r['apto']) ?></span>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>
</main>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
