<?php
$paginaTitulo = 'Meu Histórico';
$paginaAtiva  = 'financeiro';
require_once __DIR__ . '/../../layout/header.php';
?>

<main class="main-content">
    <div class="page-header">
        <h2>Meu Histórico Financeiro</h2>
        <p class="text-muted">Seus lançamentos pendentes</p>
    </div>

    <div class="df-card">
        <h3 class="section-title">Pendências</h3>

        <?php if (empty($historico)): ?>
            <div class="empty-state">
                <i class='bx bx-check-circle'></i>
                <h5>Tudo em dia!</h5>
                <p>Você não possui lançamentos pendentes no momento.</p>
            </div>
        <?php else: ?>
            <div class="table-wrap">
                <table class="df-table">
                    <thead>
                        <tr>
                            <th>Tipo</th>
                            <th>Descrição</th>
                            <th>Valor</th>
                            <th>Vencimento</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $total = 0;
                        foreach ($historico as $h): 
                            $total += $h['valor'];
                            $vencido = strtotime($h['data_vencimento']) < strtotime('today');
                        ?>
                            <tr>
                                <td><?= ucfirst(htmlspecialchars($h['modelo'])) ?></td>
                                <td><?= htmlspecialchars($h['descricao']) ?></td>
                                <td>R$ <?= number_format($h['valor'], 2, ',', '.') ?></td>
                                <td><?php
                                    $corStatus = match($h['status']) {
                                        'P' => '#CA8A04',
                                        'F' => '#16A34A',
                                        'G' => '#2563EB',
                                        default => '#6B7280'
                                    };
                                    $textoStatus = match($h['status']) {
                                        'P' => 'Pendente',
                                        'F' => 'Fatura Gerada',
                                        'G' => 'Pago',
                                        default => $h['status']
                                    };
                                    ?>
                                    <span style="color: <?= $corStatus ?>">
                                        <?= $textoStatus ?>
                                    </span></td>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2"><strong>Total Pendente</strong></td>
                            <td colspan="3"><strong>R$ <?= number_format($total, 2, ',', '.') ?></strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php require_once __DIR__ . '/../../layout/footer.php'; ?>