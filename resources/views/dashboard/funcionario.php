<?php
$paginaTitulo = 'Dashboard - Porteiro';
$cssExtra = 'dashboard.css';
?>

<?php require_once __DIR__ . '/../layout/header.php'; ?>

<main class="main-content" id="app">
    <div class="page-header">
        <h2>Dashboard Porteiro</h2>
        <p class="text-muted">Consulta rápida para apoio à portaria e controle de veículos.</p>
    </div>

    <section class="dashboard-section">
        <div class="kpi-grid">
            <a href="<?= BASE_URL ?>/veiculo" class="kpi-card kpi-card-link">
                <div class="kpi-icon" style="background:#eff8ff;color:#0f80b6"><i class="bx bx-car"></i></div>
                <div>
                    <p class="kpi-label">Veículos cadastrados</p>
                    <h3 class="kpi-value"><?= (int) ($totalVeiculos ?? 0) ?></h3>
                </div>
            </a>
            <a href="<?= BASE_URL ?>/veiculo/consultar" class="kpi-card kpi-card-link">
                <div class="kpi-icon" style="background:#f0fdf4;color:#16a34a"><i class="bx bx-search"></i></div>
                <div>
                    <p class="kpi-label">Busca rápida</p>
                    <h3 class="kpi-value-sm">Consultar placa</h3>
                    <span class="kpi-sub">Identifique morador, bloco e apto</span>
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
        <h3 class="section-title">Veículos recentes</h3>
        <?php if (empty($veiculosRecentes)): ?>
            <div class="dashboard-placeholder">Nenhum veículo cadastrado.</div>
        <?php else: ?>
            <div class="dashboard-table-card">
                <table class="dashboard-table">
                    <thead>
                        <tr>
                            <th>Placa</th>
                            <th>Veículo</th>
                            <th>Morador</th>
                            <th>Unidade</th>
                            <th>Cadastro</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($veiculosRecentes as $veiculo): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($veiculo['placa']) ?></strong></td>
                                <td><?= htmlspecialchars($veiculo['marca'] . ' ' . $veiculo['modelo']) ?></td>
                                <td><?= htmlspecialchars($veiculo['nome_morador']) ?></td>
                                <td>Bl. <?= htmlspecialchars($veiculo['bloco']) ?> Ap. <?= htmlspecialchars($veiculo['apto']) ?></td>
                                <td><?= !empty($veiculo['created_at']) ? date('d/m/Y', strtotime($veiculo['created_at'])) : '-' ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </section>

    <section class="dashboard-section">
        <h3 class="section-title">Resumo da frota</h3>
        <div class="dashboard-card-grid">
            <div class="chart-card">
                <h5 class="chart-title">Top marcas</h5>
                <?php foreach (($topMarcasVeiculos ?? []) as $marca): ?>
                    <div class="dashboard-list-row"><span><?= htmlspecialchars($marca['marca']) ?></span><strong><?= (int) $marca['total'] ?></strong></div>
                <?php endforeach; ?>
            </div>
            <div class="chart-card">
                <h5 class="chart-title">Top cores</h5>
                <?php foreach (($topCoresVeiculos ?? []) as $cor): ?>
                    <div class="dashboard-list-row"><span><?= htmlspecialchars($cor['cor']) ?></span><strong><?= (int) $cor['total'] ?></strong></div>
                <?php endforeach; ?>
            </div>
            <div class="chart-card">
                <h5 class="chart-title">Top modelos</h5>
                <?php foreach (($topModelosVeiculos ?? []) as $modelo): ?>
                    <div class="dashboard-list-row"><span><?= htmlspecialchars($modelo['modelo']) ?></span><strong><?= (int) $modelo['total'] ?></strong></div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</main>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
