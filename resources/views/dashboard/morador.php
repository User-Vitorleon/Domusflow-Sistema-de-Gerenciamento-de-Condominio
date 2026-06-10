<?php
$paginaTitulo = 'Dashboard - Morador';
$cssExtra = 'dashboard.css';

$reservasVisiveis = array_slice($minhasReservas ?? [], 0, 6);
$totalOcorrencias = (int) (($ocorrenciasMorador['aberto'] ?? 0) +
    ($ocorrenciasMorador['andamento'] ?? 0) +
    ($ocorrenciasMorador['resolvido'] ?? 0) +
    ($ocorrenciasMorador['cancelado'] ?? 0));
?>

<?php require_once __DIR__ . '/../layout/header.php'; ?>

<main class="main-content" id="app">
    <div class="page-header">
        <h2>Dashboard Morador</h2>
        <p class="text-muted">Resumo das suas reservas, ocorrências e pendências financeiras.</p>
    </div>

    <section class="dashboard-section">
        <div class="kpi-grid">
            <a href="<?= BASE_URL ?>/financeiro/historico" class="kpi-card kpi-card-link">
                <div class="kpi-icon" style="background:#fff7ed;color:#ea580c"><i class="bx bx-receipt"></i></div>
                <div>
                    <p class="kpi-label">Em aberto</p>
                    <h3 class="kpi-value">R$ <?= number_format((float) ($totalPendenteMorador ?? 0), 2, ',', '.') ?></h3>
                </div>
            </a>
            <a href="<?= BASE_URL ?>/reserva/historico" class="kpi-card kpi-card-link">
                <div class="kpi-icon" style="background:#eff8ff;color:#0f80b6"><i class="bx bx-calendar-check"></i></div>
                <div>
                    <p class="kpi-label">Reservas exibidas</p>
                    <h3 class="kpi-value"><?= count($reservasVisiveis) ?></h3>
                </div>
            </a>
        </div>
    </section>

    <?php if (!empty($boletosVencendo)): ?>
        <section class="dashboard-section">
            <div class="df-alert df-alert-warning">
                <i class="bx bx-error-circle"></i>
                <div>
                    <strong>Atenção.</strong> Você tem <?= count($boletosVencendo) ?> boleto(s) vencendo nos próximos 5 dias.
                </div>
            </div>
        </section>
    <?php endif; ?>

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
        <h3 class="section-title">Minhas reservas</h3>
        <?php if (empty($reservasVisiveis)): ?>
            <div class="empty-state">
                <div class="empty-state-icon"><i class="bx bx-calendar-x"></i></div>
                <h5>Nenhuma reserva encontrada</h5>
                <p>Suas próximas solicitações aparecerão aqui.</p>
            </div>
        <?php else: ?>
            <div class="dashboard-card-grid">
                <?php foreach ($reservasVisiveis as $reserva): ?>
                    <?php
                    $statusTexto = match ($reserva['status']) {
                        'A' => 'Aprovada',
                        'N' => 'Recusada',
                        default => 'Pendente'
                    };
                    ?>
                    <article class="reserva-card">
                        <div class="reserva-header">
                            <h4 class="reserva-local"><?= htmlspecialchars($reserva['local']) ?></h4>
                            <span class="reserva-badge <?= htmlspecialchars($reserva['status']) ?>"><?= $statusTexto ?></span>
                        </div>
                        <div class="reserva-body">
                            <div class="reserva-datetime">
                                <i class="bx bx-calendar"></i>
                                <span><?= date('d/m/Y', strtotime($reserva['data_reserva'])) ?></span>
                                <span><?= substr($reserva['hora_ini'], 0, 5) ?> - <?= substr($reserva['hora_fim'], 0, 5) ?></span>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>

    <section class="dashboard-section">
        <h3 class="section-title">Minhas ocorrências</h3>
        <div class="dashboard-card-grid dashboard-card-grid--four">
            <div class="chart-card"><span class="kpi-sub">Abertas</span><strong class="kpi-value"><?= (int) ($ocorrenciasMorador['aberto'] ?? 0) ?></strong></div>
            <div class="chart-card"><span class="kpi-sub">Em andamento</span><strong class="kpi-value"><?= (int) ($ocorrenciasMorador['andamento'] ?? 0) ?></strong></div>
            <div class="chart-card"><span class="kpi-sub">Resolvidas</span><strong class="kpi-value"><?= (int) ($ocorrenciasMorador['resolvido'] ?? 0) ?></strong></div>
            <div class="chart-card"><span class="kpi-sub">Canceladas</span><strong class="kpi-value"><?= (int) ($ocorrenciasMorador['cancelado'] ?? 0) ?></strong></div>
        </div>
    </section>
</main>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
