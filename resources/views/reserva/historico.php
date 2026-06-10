<?php
$paginaTitulo = 'Histórico de Reservas';
$paginaAtiva  = 'reserva';
$cssTela      = 'reserva.css';
require_once __DIR__ . '/../layout/header.php';

$statusReserva = [
    'A' => ['Aprovado', 'reserva-status-aprovado'],
    'P' => ['Pendente', 'reserva-status-pendente'],
    'N' => ['Recusado', 'reserva-status-recusado'],
];

$queryBase = array_filter([
    'local' => $filtrosHistorico['local'] ?? '',
    'data_solicitacao' => $filtrosHistorico['data_solicitacao'] ?? '',
    'data_reserva' => $filtrosHistorico['data_reserva'] ?? '',
], static fn($valor) => $valor !== '');
$queryString = http_build_query($queryBase);
$basePaginacao = BASE_URL . '/reserva/historico?' . ($queryString ? $queryString . '&' : '');
?>

<main class="main-content">
    <div class="df-page reserva-page">
        <div class="page-header">
            <h2>Histórico de Reservas</h2>
            <p class="text-muted">Acompanhe suas solicitações de reserva e o status de aprovação.</p>
        </div>

        <div class="df-card reserva-filtros-card">
            <form method="GET" action="<?= BASE_URL ?>/reserva/historico" class="reserva-historico-filtros">
                <div class="df-field">
                    <label>Local</label>
                    <input type="text" name="local" value="<?= htmlspecialchars($filtrosHistorico['local'] ?? '') ?>" placeholder="Ex: Salão">
                </div>
                <div class="df-field">
                    <label>Data solicitação</label>
                    <input type="date" name="data_solicitacao" value="<?= htmlspecialchars($filtrosHistorico['data_solicitacao'] ?? '') ?>">
                </div>
                <div class="df-field">
                    <label>Data reserva</label>
                    <input type="date" name="data_reserva" value="<?= htmlspecialchars($filtrosHistorico['data_reserva'] ?? '') ?>">
                </div>
                <div class="reserva-filter-actions">
                    <button type="submit" class="btn-primary">Filtrar</button>
                    <a href="<?= BASE_URL ?>/reserva/historico" class="btn-ghost">Limpar</a>
                </div>
            </form>
        </div>

        <div class="df-card reserva-historico-card">
            <div class="reserva-section-head">
                <h3>Resultado</h3>
                <span><?= (int)$totalHistorico ?> reserva(s)</span>
            </div>

            <?php if (empty($reservasHistorico)): ?>
                <div class="empty-state">
                    <div class="empty-state-icon"><i class='bx bx-calendar-x'></i></div>
                    <h5>Nenhuma reserva encontrada</h5>
                    <p>Você ainda não possui reservas para os filtros selecionados.</p>
                </div>
            <?php else: ?>
                <div class="reserva-table-wrap">
                    <table class="df-table reserva-historico-table">
                        <thead>
                            <tr>
                                <th>Local</th>
                                <th>Data reserva</th>
                                <th>Hora reserva</th>
                                <th>Status</th>
                                <th>Usuário Aprovação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reservasHistorico as $reserva): ?>
                                <?php
                                $status = $statusReserva[$reserva['status'] ?? 'P'] ?? ['Pendente', 'reserva-status-pendente'];
                                ?>
                                <tr>
                                    <td><strong><?= htmlspecialchars($reserva['local']) ?></strong></td>
                                    <td><?= date('d/m/Y', strtotime($reserva['data_reserva'])) ?></td>
                                    <td><?= substr($reserva['hora_ini'], 0, 5) ?> - <?= substr($reserva['hora_fim'], 0, 5) ?></td>
                                    <td><span class="reserva-status <?= $status[1] ?>"><?= $status[0] ?></span></td>
                                    <td><?= htmlspecialchars($reserva['nome_user_aprov'] ?? '-') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <?php if ($totalPaginas > 1): ?>
                    <nav class="mt-3 d-flex justify-content-center">
                        <ul class="pagination">
                            <li class="page-item <?= $pagina <= 1 ? 'disabled' : '' ?>">
                                <a class="page-link" href="<?= $pagina > 1 ? $basePaginacao . 'pagina=' . ($pagina - 1) : '#' ?>">Anterior</a>
                            </li>
                            <?php for ($i = 1; $i <= $totalPaginas; $i++):
                                $mostrar = ($i === 1 || $i === $totalPaginas || abs($i - $pagina) <= 2);
                                if (!$mostrar):
                                    if ($i === 2 || $i === $totalPaginas - 1): ?>
                                        <li class="page-item disabled"><span class="page-link">...</span></li>
                                    <?php endif;
                                    continue;
                                endif; ?>
                                <li class="page-item <?= $i === $pagina ? 'active' : '' ?>">
                                    <a class="page-link" href="<?= $basePaginacao ?>pagina=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                            <li class="page-item <?= $pagina >= $totalPaginas ? 'disabled' : '' ?>">
                                <a class="page-link" href="<?= $pagina < $totalPaginas ? $basePaginacao . 'pagina=' . ($pagina + 1) : '#' ?>">Próximo</a>
                            </li>
                        </ul>
                    </nav>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <div class="df-actions reserva-historico-actions">
            <a href="<?= BASE_URL ?>/painel" class="btn-ghost">Voltar</a>
            <a href="<?= BASE_URL ?>/reserva" class="btn-primary">Nova Reserva</a>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
