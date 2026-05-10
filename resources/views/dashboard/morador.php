<?php
$paginaTitulo = 'Dashboard - Morador';
$cssExtra = 'dashboard.css';
$jsExtra = 'dashboard.js';
?>

<?php require_once __DIR__ . '/../layout/header.php'; ?>

<main class="main-content">
    <div class="page-header">
        <h2>Dashboard</h2>
        <p class="text-muted">Bem-vindo, <?= htmlspecialchars(explode(' ', $usuario['nome'])[0]) ?>!</p>
    </div>

    <!-- FERIADOS — 3 colunas alinhado à esquerda -->
    <section class="dashboard-section">
        <h3 class="section-title">Próximos Feriados</h3>
        <?php if (!empty($proximosFeriados)): ?>
            <div class="row g-3 mb-4">
                <?php foreach ($proximosFeriados as $feriado): ?>
                    <div class="col-12 col-md-4">
                        <article class="feriado-card">
                            <div class="feriado-card-top">
                                <div class="feriado-card-icon">
                                    <i class='bx bx-party'></i>
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
            <div class="dashboard-placeholder col-12 col-md-8">
                Nenhum feriado próximo disponível no momento.
            </div>
        <?php endif; ?>
    </section>

    <!-- RESERVAS -->
    <section class="dashboard-section">
        <h3 class="section-title">Minhas Reservas</h3>
        <?php if (empty($minhasReservas)): ?>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="bx bx-calendar-x"></i>
                        </div>
                        <h5>Você ainda não possui reservas</h5>
                        <p>Faça sua primeira reserva nas áreas comuns do condomínio.</p>
                        <a href="<?= BASE_URL ?>/reserva" class="btn btn-primary">Fazer Primeira Reserva</a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="row g-3">
                <?php foreach ($minhasReservas as $reserva): ?>
                    <?php
                    $statusLabel = match ($reserva['status']) {
                        'A' => ['Aprovada', 'A'],
                        'P' => ['Pendente', 'P'],
                        'N' => ['Negada',   'N'],
                        default => ['Pendente', 'P']
                    };
                    $statusTexto = $statusLabel[0];
                    $statusKey   = $statusLabel[1];
                    ?>
                    <div class="col-12 col-md-4">
                        <div class="reserva-card">
                            <div class="reserva-header">
                                <h4 class="reserva-local mb-0 flex-grow-1">
                                    <?= htmlspecialchars($reserva['local']) ?>
                                </h4>
                                <span class="reserva-badge <?= $statusKey ?>"><?= $statusTexto ?></span>
                            </div>
                            <div class="reserva-body">
                                <div class="reserva-datetime">
                                    <i class='bx bx-calendar'></i>
                                    <span><?= date('d/m/Y', strtotime($reserva['data_reserva'])) ?></span>
                                    <span>•</span>
                                    <span><?= substr($reserva['hora_ini'], 0, 5) ?> - <?= substr($reserva['hora_fim'], 0, 5) ?></span>
                                </div>
                                <div class="reserva-aprovador">
                                    <i class='bx bx-user-check'></i>
                                    <span><?= $statusKey === 'P' ? 'Aguardando aprovação' : 'Aprov. por: ' . htmlspecialchars($reserva['nome_user_aprov'] ?? '—') ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>

    <!-- OCORRÊNCIAS -->
    <section class="dashboard-section">
        <h3 class="section-title">Minhas Ocorrências</h3>
        <?php
        $totalOcorrencias = (int) (($ocorrenciasMorador['aberto'] ?? 0) +
            ($ocorrenciasMorador['andamento'] ?? 0) +
            ($ocorrenciasMorador['resolvido'] ?? 0) +
            ($ocorrenciasMorador['cancelado'] ?? 0));
        ?>
        <?php if ($totalOcorrencias === 0): ?>
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="bx bx-check-shield"></i>
                </div>
                <h5>Nenhuma ocorrência registrada</h5>
                <p>Tudo tranquilo por aqui!</p>
            </div>
        <?php else: ?>
            <div class="row g-3">
                <div class="col-12 col-md-5">
                    <div class="chart-card h-100">
                        <h5 class="chart-title">Situação geral</h5>
                        <div class="ocorrencia-chart-wrap">
                            <canvas id="chartOcorrenciasMorador"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="chart-card h-100">
                        <h5 class="chart-title">Detalhes</h5>
                        <div class="ocorrencia-legenda">
                            <div class="ocorrencia-legenda-item">
                                <span class="ocorrencia-dot" style="background:#EF4444"></span>
                                <span>Abertas</span>
                                <strong><?= $ocorrenciasMorador['aberto'] ?? 0 ?></strong>
                            </div>
                            <div class="ocorrencia-legenda-item">
                                <span class="ocorrencia-dot" style="background:#F59E0B"></span>
                                <span>Em andamento</span>
                                <strong><?= $ocorrenciasMorador['andamento'] ?? 0 ?></strong>
                            </div>
                            <div class="ocorrencia-legenda-item">
                                <span class="ocorrencia-dot" style="background:#22C55E"></span>
                                <span>Resolvidas</span>
                                <strong><?= $ocorrenciasMorador['resolvido'] ?? 0 ?></strong>
                            </div>
                            <div class="ocorrencia-legenda-item">
                                <span class="ocorrencia-dot" style="background:#94A3B8"></span>
                                <span>Canceladas</span>
                                <strong><?= $ocorrenciasMorador['cancelado'] ?? 0 ?></strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </section>

</main>

<script>
    window.APP_DASHBOARD = <?= json_encode([
                                'chartOcorrenciasMorador' => [
                                    'labels' => ['Abertas', 'Em andamento', 'Resolvidas', 'Canceladas'],
                                    'dados' => [
                                        (int) ($ocorrenciasMorador['aberto'] ?? 0),
                                        (int) ($ocorrenciasMorador['andamento'] ?? 0),
                                        (int) ($ocorrenciasMorador['resolvido'] ?? 0),
                                        (int) ($ocorrenciasMorador['cancelado'] ?? 0),
                                    ]
                                ]
                            ]) ?>;
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>