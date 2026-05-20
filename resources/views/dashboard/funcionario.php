<?php
$paginaTitulo = 'Dashboard - Funcionário';
$cssExtra     = 'dashboard.css';
?>

<?php require_once __DIR__ . '/../layout/header.php'; ?>

<main class="main-content">
    <div class="page-header">
        <h2>Dashboard Operacional</h2>
        <p class="text-muted">Pendências do dia</p>
    </div>

    <!-- OCORRÊNCIAS SEM ATALHO (só números) -->
    <div class="row g-3 mb-5">
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body">
                    <i class="bx bx-error-circle fs-1 text-danger mb-2"></i>
                    <h3 class="text-danger"><?= (int) ($ocorrenciasFuncionario['aberto'] ?? 0) ?></h3>
                    <p class="text-muted mb-0">Ocorrências Abertas</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body">
                    <i class="bx bx-time-five fs-1 text-warning mb-2"></i>
                    <h3 class="text-warning"><?= (int) ($ocorrenciasFuncionario['andamento'] ?? 0) ?></h3>
                    <p class="text-muted mb-0">Em Espera</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body">
                    <i class="bx bx-user-check fs-1 text-info mb-2"></i>
                    <h3 class="text-info"><?= (int) ($moradoresPendentes ?? 0) ?></h3>
                    <p class="text-muted mb-0">Moradores Pendentes</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body">
                    <i class="bx bx-calendar-check fs-1 text-success mb-2"></i>
                    <h3 class="text-success"><?= $reservasPendentes ?></h3>
                    <p class="text-muted mb-0">Reservas Pendentes</p>
                </div>
            </div>
        </div>
    </div>

    <section class="dashboard-section">
        <h3 class="section-title">Veículos</h3>

        <div class="row g-3 mb-4">
            <div class="col-12 col-md-4">
                <div class="chart-card h-100">
                    <h5 class="chart-title">Total Cadastrado</h5>
                    <div class="kpi-value"><?= (int) ($totalVeiculos ?? 0) ?></div>
                    <span class="kpi-sub">Veículos no sistema</span>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="chart-card h-100">
                    <h5 class="chart-title">Top Marcas</h5>
                    <?php if (!empty($topMarcasVeiculos)): ?>
                        <div class="dashboard-list">
                            <?php foreach ($topMarcasVeiculos as $marca): ?>
                                <div class="reserva-semana-item">
                                    <div class="reserva-semana-info">
                                        <div class="reserva-semana-local"><?= htmlspecialchars($marca['marca']) ?></div>
                                    </div>
                                    <strong><?= (int) $marca['total'] ?></strong>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="dashboard-placeholder">Sem dados de marcas.</div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="chart-card h-100">
                    <h5 class="chart-title">Top Cores</h5>
                    <?php if (!empty($topCoresVeiculos)): ?>
                        <div class="dashboard-list">
                            <?php foreach ($topCoresVeiculos as $cor): ?>
                                <div class="reserva-semana-item">
                                    <div class="reserva-semana-info">
                                        <div class="reserva-semana-local"><?= htmlspecialchars($cor['cor']) ?></div>
                                    </div>
                                    <strong><?= (int) $cor['total'] ?></strong>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="dashboard-placeholder">Sem dados de cores.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-5">
            <div class="col-12 col-md-6">
                <div class="chart-card h-100">
                    <h5 class="chart-title">Top Modelos</h5>
                    <?php if (!empty($topModelosVeiculos)): ?>
                        <div class="dashboard-list">
                            <?php foreach ($topModelosVeiculos as $modelo): ?>
                                <div class="reserva-semana-item">
                                    <div class="reserva-semana-info">
                                        <div class="reserva-semana-local"><?= htmlspecialchars($modelo['modelo']) ?></div>
                                    </div>
                                    <strong><?= (int) $modelo['total'] ?></strong>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="dashboard-placeholder">Sem dados de modelos.</div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="dashboard-placeholder h-100">
                    <!-- Avisos recentes: módulo ainda não desenvolvido -->
                    Avisos recentes em desenvolvimento
                </div>
            </div>
        </div>

</main>

<<<<<<< HEAD
<?php require_once __DIR__ . '/../layout/footer.php'; ?>
=======
<?php require_once __DIR__ . '/../layout/footer.php'; ?>
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
