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
            <div class="morador-list">
                <?php 
                $total = 0;
                foreach ($historico as $h):
                    $total += $h['status'] === 'P' ? $h['valor'] : 0;
                    $vencido = strtotime($h['data_vencimento']) < strtotime('today') && $h['status'] === 'P';
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
                    $corModelo = strtoupper($h['modelo']) === 'TAXA' ? '#2563EB' : '#DC2626';
                    $bgModelo  = strtoupper($h['modelo']) === 'TAXA' ? '#EFF6FF' : '#FEF2F2';
                    $icone     = strtoupper($h['modelo']) === 'TAXA' ? 'bx-coin' : 'bx-error';
                ?>
                    <div class="morador-card">
                        <div style="width:42px; height:42px; border-radius:50%; background:<?= $bgModelo ?>; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                            <i class='bx <?= $icone ?>' style="font-size:20px; color:<?= $corModelo ?>"></i>
                        </div>

                        <div class="morador-info">
                            <strong><?= htmlspecialchars($h['descricao']) ?></strong>
                            <span>
                                <span style="color:<?= $corModelo ?>; font-weight:600;">
                                    <?= ucfirst(strtolower($h['modelo'])) ?>
                                </span>
                                · R$ <?= number_format($h['valor'], 2, ',', '.') ?>
                                · Venc: <span style="color:<?= $vencido ? '#EF4444' : 'inherit' ?>; font-weight:<?= $vencido ? '600' : '400' ?>">
                                    <?= date('d/m/Y', strtotime($h['data_vencimento'])) ?>
                                    <?= $vencido ? '(Vencido)' : '' ?>
                                </span>
                            </span>
                        </div>

                        <div style="display:flex; flex-direction:column; align-items:flex-end; gap:4px;">
                            <span style="color:<?= $corStatus ?>; font-size:13px; font-weight:600;">
                                <?= $textoStatus ?>
                            </span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Total pendente -->
            <div style="margin-top: 16px; padding: 14px 16px; background: #F8FAFC; border-radius: var(--radius); border: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
                <strong>Total Pendente</strong>
                <strong style="color: #CA8A04; font-size: 16px;">
                    R$ <?= number_format($total, 2, ',', '.') ?>
                </strong>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php require_once __DIR__ . '/../../layout/footer.php'; ?>