<?php
$paginaTitulo = 'Meu Histórico';
$paginaAtiva  = 'financeiro';
require_once __DIR__ . '/../../layout/header.php';

$pendentes = array_filter($historico, fn($h) => $h['status'] === 'P');
$geradas   = array_filter($historico, fn($h) => $h['status'] === 'F');
$totalPendente = array_sum(array_column(iterator_to_array($pendentes ?? new ArrayIterator([])), 'valor'));
?>

<main class="main-content">
<div style="max-width: 960px; margin: 0 auto;">

    <div class="page-header">
        <h2>Pendências e Histórico</h2>
        <p class="text-muted">Seus lançamentos e faturas</p>
    </div>

    <?php if (isset($_SESSION['sucesso_fatura'])): ?>
        <div class="df-alert df-alert-success"><?= htmlspecialchars($_SESSION['sucesso_fatura']) ?><?php unset($_SESSION['sucesso_fatura']); ?></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['erro_fatura'])): ?>
        <div class="df-alert df-alert-error"><?= htmlspecialchars($_SESSION['erro_fatura']) ?><?php unset($_SESSION['erro_fatura']); ?></div>
    <?php endif; ?>

    <div class="df-card" style="margin-bottom: 24px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 10px;">
            <h3 class="section-title" style="margin: 0;">Pendências</h3>
            <?php if (!empty($pendentes)): ?>
                <form action="<?= BASE_URL ?>/financeiro/fatura/gerar" method="POST"
                      onsubmit="return confirm('Confirma a geração da fatura com todas as suas pendências?')">
                    <input type="hidden" name="id_user" value="<?= $_SESSION['usuario_id'] ?>">
                    <button type="submit" class="btn-primary" style="font-size: 13px; padding: 7px 14px;">
                        <i class='bx bx-file'></i> Gerar Fatura
                    </button>
                </form>
            <?php endif; ?>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr auto; gap: 10px; margin-bottom: 14px; padding: 12px; background: #F8FAFC; border-radius: var(--radius); border: 1px solid var(--border);">
            <div class="df-field" style="margin: 0;">
                <label style="font-size: 11px;">Buscar</label>
                <input type="text" id="buscaPendente" placeholder="Tipo, descrição..." oninput="filtrarTabela('buscaPendente', 'tabelaPendentes')">
            </div>
            <div class="df-field" style="margin: 0;">
                <label style="font-size: 11px;">Dt. Vencimento</label>
                <input type="date" id="dtVencPendente" onchange="filtrarTabela('buscaPendente', 'tabelaPendentes')">
            </div>
            <div class="df-field" style="margin: 0; justify-content: flex-end;">
                <label style="font-size: 11px;">&nbsp;</label>
                <button class="btn-ghost" onclick="limparFiltro('buscaPendente','dtVencPendente','tabelaPendentes')" style="height: 38px;">Limpar</button>
            </div>
        </div>

        <?php if (empty($pendentes)): ?>
            <div class="empty-state">
                <i class='bx bx-check-circle'></i>
                <h5>Tudo em dia!</h5>
                <p>Você não possui pendências no momento.</p>
            </div>
        <?php else: ?>
            <div style="overflow-x: auto;">
                <table class="df-table" style="width: 100%; border-collapse: collapse; font-size: 13px;">
                    <thead>
                        <tr style="background: #F8FAFC;">
                            <th style="padding: 10px 12px; text-align: left; border-bottom: 1px solid var(--border);">#</th>
                            <th style="padding: 10px 12px; text-align: left; border-bottom: 1px solid var(--border);">Tipo</th>
                            <th style="padding: 10px 12px; text-align: left; border-bottom: 1px solid var(--border);">Descrição</th>
                            <th style="padding: 10px 12px; text-align: right; border-bottom: 1px solid var(--border);">Valor</th>
                            <th style="padding: 10px 12px; text-align: left; border-bottom: 1px solid var(--border); white-space: nowrap;">Dt. Lançamento</th>
                            <th style="padding: 10px 12px; text-align: left; border-bottom: 1px solid var(--border); white-space: nowrap;">Vencimento</th>
                            <th style="padding: 10px 12px; text-align: left; border-bottom: 1px solid var(--border);">Status</th>
                        </tr>
                    </thead>
                    <tbody id="tabelaPendentes">
                        <?php foreach ($pendentes as $h):
                            $vencido  = strtotime($h['data_vencimento']) < strtotime('today');
                            $corModelo = strtoupper($h['modelo']) === 'TAXA' ? '#2563EB' : '#DC2626';
                        ?>
                            <tr style="border-bottom: 1px solid #F1F5F9;"
                                data-desc="<?= strtolower($h['descricao']) ?>"
                                data-tipo="<?= strtolower($h['modelo']) ?>"
                                data-dt-venc="<?= $h['data_vencimento'] ?>">
                                <td style="padding: 10px 12px; color: var(--text-muted);">#<?= $h['id_lancamento'] ?></td>
                                <td style="padding: 10px 12px;">
                                    <span style="color: <?= $corModelo ?>; font-weight: 600; font-size: 12px;">
                                        <?= ucfirst(strtolower($h['modelo'])) ?>
                                    </span>
                                </td>
                                <td style="padding: 10px 12px;"><?= htmlspecialchars($h['descricao']) ?></td>
                                <td style="padding: 10px 12px; text-align: right; font-weight: 600;">
                                    R$ <?= number_format($h['valor'], 2, ',', '.') ?>
                                </td>
                                <td style="padding: 10px 12px; color: var(--text-muted); white-space: nowrap;">
                                    <?= isset($h['data_lancamento']) ? date('d/m/Y', strtotime($h['data_lancamento'])) : '-' ?>
                                </td>
                                <td style="padding: 10px 12px; white-space: nowrap;">
                                    <span style="color: <?= $vencido ? '#EF4444' : 'inherit' ?>; font-weight: <?= $vencido ? '600' : '400' ?>;">
                                        <?= date('d/m/Y', strtotime($h['data_vencimento'])) ?>
                                        <?= $vencido ? ' ⚠' : '' ?>
                                    </span>
                                </td>
                                <td style="padding: 10px 12px;">
                                    <span style="padding: 3px 8px; border-radius: 20px; font-size: 11px; font-weight: 600; color: #CA8A04; background: #FFFBEB; border: 1px solid #FDE68A;">
                                        Pendente
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div style="margin-top: 14px; padding: 12px 16px; background: #FFFBEB; border-radius: var(--radius); border: 1px solid #FDE68A; display: flex; justify-content: space-between; align-items: center;">
                <strong>Total Pendente</strong>
                <strong style="color: #CA8A04; font-size: 16px;">
                    R$ <?= number_format(array_sum(array_column(iterator_to_array(new ArrayIterator(array_values($pendentes))), 'valor')), 2, ',', '.') ?>
                </strong>
            </div>
        <?php endif; ?>
    </div>

    <div class="df-card">
        <h3 class="section-title" style="margin-bottom: 16px;">Faturas Geradas</h3>

        <div style="display: grid; grid-template-columns: 1fr 1fr auto; gap: 10px; margin-bottom: 14px; padding: 12px; background: #F8FAFC; border-radius: var(--radius); border: 1px solid var(--border);">
            <div class="df-field" style="margin: 0;">
                <label style="font-size: 11px;">Buscar</label>
                <input type="text" id="buscaGerada" placeholder="Tipo, descrição..." oninput="filtrarTabela('buscaGerada', 'tabelaGeradas')">
            </div>
            <div class="df-field" style="margin: 0;">
                <label style="font-size: 11px;">Dt. Vencimento</label>
                <input type="date" id="dtVencGerada" onchange="filtrarTabela('buscaGerada', 'tabelaGeradas')">
            </div>
            <div class="df-field" style="margin: 0; justify-content: flex-end;">
                <label style="font-size: 11px;">&nbsp;</label>
                <button class="btn-ghost" onclick="limparFiltro('buscaGerada','dtVencGerada','tabelaGeradas')" style="height: 38px;">Limpar</button>
            </div>
        </div>

        <?php if (empty($geradas)): ?>
            <div class="empty-state">
                <i class='bx bx-file'></i>
                <h5>Nenhuma fatura gerada</h5>
                <p>As faturas geradas aparecerão aqui.</p>
            </div>
        <?php else: ?>
            <div style="overflow-x: auto;">
                <table class="df-table" style="width: 100%; border-collapse: collapse; font-size: 13px;">
                    <thead>
                        <tr style="background: #F8FAFC;">
                            <th style="padding: 10px 12px; text-align: left; border-bottom: 1px solid var(--border);">#</th>
                            <th style="padding: 10px 12px; text-align: left; border-bottom: 1px solid var(--border);">Tipo</th>
                            <th style="padding: 10px 12px; text-align: left; border-bottom: 1px solid var(--border);">Descrição</th>
                            <th style="padding: 10px 12px; text-align: right; border-bottom: 1px solid var(--border);">Valor</th>
                            <th style="padding: 10px 12px; text-align: left; border-bottom: 1px solid var(--border); white-space: nowrap;">Dt. Lançamento</th>
                            <th style="padding: 10px 12px; text-align: left; border-bottom: 1px solid var(--border); white-space: nowrap;">Vencimento</th>
                            <th style="padding: 10px 12px; text-align: left; border-bottom: 1px solid var(--border);">Status</th>
                        </tr>
                    </thead>
                    <tbody id="tabelaGeradas">
                        <?php foreach ($geradas as $h):
                            $corModelo = strtoupper($h['modelo']) === 'TAXA' ? '#2563EB' : '#DC2626';
                        ?>
                            <tr style="border-bottom: 1px solid #F1F5F9;"
                                data-desc="<?= strtolower($h['descricao']) ?>"
                                data-tipo="<?= strtolower($h['modelo']) ?>"
                                data-dt-venc="<?= $h['data_vencimento'] ?>">
                                <td style="padding: 10px 12px; color: var(--text-muted);">#<?= $h['id_lancamento'] ?></td>
                                <td style="padding: 10px 12px;">
                                    <span style="color: <?= $corModelo ?>; font-weight: 600; font-size: 12px;">
                                        <?= ucfirst(strtolower($h['modelo'])) ?>
                                    </span>
                                </td>
                                <td style="padding: 10px 12px;"><?= htmlspecialchars($h['descricao']) ?></td>
                                <td style="padding: 10px 12px; text-align: right; font-weight: 600;">
                                    R$ <?= number_format($h['valor'], 2, ',', '.') ?>
                                </td>
                                <td style="padding: 10px 12px; color: var(--text-muted); white-space: nowrap;">
                                    <?= isset($h['data_lancamento']) ? date('d/m/Y', strtotime($h['data_lancamento'])) : '-' ?>
                                </td>
                                <td style="padding: 10px 12px; white-space: nowrap;">
                                    <?= date('d/m/Y', strtotime($h['data_vencimento'])) ?>
                                </td>
                                <td style="padding: 10px 12px;">
                                    <span style="padding: 3px 8px; border-radius: 20px; font-size: 11px; font-weight: 600; color: #16A34A; background: #F0FDF4; border: 1px solid #BBF7D0;">
                                        Fatura Gerada
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

</div>
</main>

<script>
function filtrarTabela(inputId, tabelaId) {
    const busca  = document.getElementById(inputId)?.value.toLowerCase() ?? '';
    const dtVenc = inputId === 'buscaPendente'
        ? document.getElementById('dtVencPendente')?.value ?? ''
        : document.getElementById('dtVencGerada')?.value ?? '';

    document.querySelectorAll(`#${tabelaId} tr`).forEach(row => {
        const desc   = row.dataset.desc ?? '';
        const tipo   = row.dataset.tipo ?? '';
        const dtRow  = row.dataset.dtVenc ?? '';
        let ok = true;
        if (busca && !desc.includes(busca) && !tipo.includes(busca)) ok = false;
        if (dtVenc && dtRow !== dtVenc) ok = false;
        row.style.display = ok ? '' : 'none';
    });
}

function limparFiltro(inputId, dtId, tabelaId) {
    document.getElementById(inputId).value = '';
    document.getElementById(dtId).value = '';
    filtrarTabela(inputId, tabelaId);
}
</script>

<?php require_once __DIR__ . '/../../layout/footer.php'; ?>
