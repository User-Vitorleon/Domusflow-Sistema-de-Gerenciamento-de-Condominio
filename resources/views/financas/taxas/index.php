<?php
$paginaTitulo = 'Cadastro de Taxas/Multas';
$paginaAtiva  = 'financeiro';
require_once __DIR__ . '/../../layout/header.php';
?>

<main class="main-content">
    <div style="max-width: 1100px; margin: 0 auto;">

        <div class="page-header">
            <h2>Cadastrar Taxas/Multas</h2>
            <p class="text-muted">Cadastre e edite taxas e multas padrão do condomínio</p>
        </div>

        <?php if (isset($_SESSION['erro_taxa'])): ?>
            <div class="df-alert df-alert-error">
                <?= htmlspecialchars($_SESSION['erro_taxa']) ?>
                <?php unset($_SESSION['erro_taxa']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['sucesso'])): ?>
            <div class="df-alert df-alert-success">Taxa cadastrada com sucesso!</div>
        <?php elseif (isset($_GET['atualizado'])): ?>
            <div class="df-alert df-alert-success">Taxa atualizada com sucesso!</div>
        <?php elseif (isset($_GET['excluido'])): ?>
            <div class="df-alert df-alert-success">Taxa inativada com sucesso!</div>
        <?php endif; ?>

        <div class="df-card" style="margin-bottom: 24px;">
            <form action="<?= BASE_URL ?>/financeiro/taxas/salvar" method="POST">
                <div class="df-grid-2">
                    <div class="df-field">
                        <label>Descrição</label>
                        <input type="text" name="descricao" placeholder="Ex: Taxa de condomínio" required>
                    </div>
                    <div class="df-field">
                        <label>Valor (R$)</label>
                        <input type="text" name="valor" class="js-money" inputmode="decimal" placeholder="0,00" required>
                    </div>
                </div>
                <div class="df-field" style="max-width: 260px;">
                    <label>Tipo de Cobrança</label>
                    <select name="modulo" required>
                        <option value="">Selecione...</option>
                        <option value="TAXA">Taxa</option>
                        <option value="MULTA">Multa</option>
                    </select>
                </div>
                <div class="df-actions">
                    <button type="reset" class="btn-ghost">Limpar</button>
                    <button type="submit" class="btn-primary">Cadastrar</button>
                </div>
            </form>
        </div>

        <div class="df-card">
            <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:14px;">
                <h3 class="section-title" style="margin:0;">Taxas/Multas Cadastradas</h3>
                <span class="text-muted" style="font-size:12px;font-weight:700;"><?= count($taxas ?? []) ?> item(ns)</span>
            </div>

            <?php if (empty($taxas)): ?>
                <div class="empty-state">
                    <i class='bx bx-receipt'></i>
                    <h5>Nenhuma taxa cadastrada</h5>
                    <p>Cadastre as taxas padrão do condomínio acima.</p>
                </div>
            <?php else: ?>
                <div style="overflow-x:auto;">
                    <table class="df-table" style="width:100%;border-collapse:collapse;font-size:13px;">
                        <thead>
                            <tr style="background:#F8FAFC;">
                                <th style="padding:10px 12px;text-align:left;border-bottom:1px solid var(--border);">Descrição</th>
                                <th style="padding:10px 12px;text-align:left;border-bottom:1px solid var(--border);">Tipo</th>
                                <th style="padding:10px 12px;text-align:left;border-bottom:1px solid var(--border);">Valor</th>
                                <th style="padding:10px 12px;text-align:left;border-bottom:1px solid var(--border);">Status</th>
                                <th style="padding:10px 12px;text-align:left;border-bottom:1px solid var(--border);">Cadastro</th>
                                <th style="padding:10px 12px;text-align:center;border-bottom:1px solid var(--border);">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($taxas as $taxa): ?>
                                <?php $formId = 'taxa-form-' . (int)$taxa['id_taxa']; ?>
                                <tr>
                                    <td style="padding:10px 12px;border-bottom:1px solid var(--border);min-width:220px;">
                                        <form id="<?= $formId ?>" action="<?= BASE_URL ?>/financeiro/taxas/editar" method="POST"></form>
                                        <input form="<?= $formId ?>" type="hidden" name="id_taxa" value="<?= (int)$taxa['id_taxa'] ?>">
                                        <input form="<?= $formId ?>" type="hidden" name="admin_senha" value="">
                                        <input form="<?= $formId ?>" type="text" name="descricao" value="<?= htmlspecialchars($taxa['descricao']) ?>" required style="width:100%;padding:7px 9px;border:1px solid var(--border);border-radius:7px;background:var(--white);color:var(--text);">
                                    </td>
                                    <td style="padding:10px 12px;border-bottom:1px solid var(--border);min-width:130px;">
                                        <select form="<?= $formId ?>" name="modulo" required style="width:100%;padding:7px 9px;border:1px solid var(--border);border-radius:7px;background:var(--white);color:var(--text);">
                                            <option value="TAXA" <?= strtoupper($taxa['modulo']) === 'TAXA' ? 'selected' : '' ?>>Taxa</option>
                                            <option value="MULTA" <?= strtoupper($taxa['modulo']) === 'MULTA' ? 'selected' : '' ?>>Multa</option>
                                        </select>
                                    </td>
                                    <td style="padding:10px 12px;border-bottom:1px solid var(--border);min-width:120px;">
                                        <input form="<?= $formId ?>" type="text" name="valor" class="js-money" inputmode="decimal" value="<?= number_format((float)$taxa['valor'], 2, ',', '.') ?>" required style="width:100%;padding:7px 9px;border:1px solid var(--border);border-radius:7px;background:var(--white);color:var(--text);">
                                    </td>
                                    <td style="padding:10px 12px;border-bottom:1px solid var(--border);min-width:120px;">
                                        <select form="<?= $formId ?>" name="status" required style="width:100%;padding:7px 9px;border:1px solid var(--border);border-radius:7px;background:var(--white);color:var(--text);">
                                            <option value="A" <?= $taxa['status'] === 'A' ? 'selected' : '' ?>>Ativa</option>
                                            <option value="I" <?= $taxa['status'] === 'I' ? 'selected' : '' ?>>Inativa</option>
                                        </select>
                                    </td>
                                    <td style="padding:10px 12px;border-bottom:1px solid var(--border);color:var(--text-muted);white-space:nowrap;">
                                        <?= htmlspecialchars($taxa['usuario_cad'] ?? '-') ?><br>
                                        <small><?= !empty($taxa['data_cad']) ? date('d/m/Y', strtotime($taxa['data_cad'])) : '-' ?></small>
                                    </td>
                                    <td style="padding:10px 12px;border-bottom:1px solid var(--border);text-align:center;">
                                        <div style="display:flex;gap:8px;justify-content:center;align-items:center;flex-wrap:wrap;">
                                            <button form="<?= $formId ?>" type="button" class="btn-primary js-confirm-financeiro" data-title="Salvar taxa/multa" data-message="Informe sua senha para salvar as alterações." style="min-height:32px;padding:6px 12px;font-size:12px;">Salvar</button>
                                            <?php if ($taxa['status'] === 'A'): ?>
                                                <form action="<?= BASE_URL ?>/financeiro/taxas/excluir" method="POST">
                                                    <input type="hidden" name="id_taxa" value="<?= (int)$taxa['id_taxa'] ?>">
                                                    <input type="hidden" name="admin_senha" value="">
                                                    <button type="button" class="btn-danger-sm js-confirm-financeiro" data-title="Inativar taxa/multa" data-message="Informe sua senha para inativar esta taxa/multa." style="min-height:32px;padding:6px 10px;">Inativar</button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
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

<div class="fin-confirm-modal" id="confirmFinanceiroModal" aria-hidden="true">
    <div class="fin-confirm-backdrop" data-fin-modal-close></div>
    <div class="fin-confirm-dialog" role="dialog" aria-modal="true" aria-labelledby="confirmFinanceiroTitle">
        <button type="button" class="fin-confirm-close" data-fin-modal-close aria-label="Fechar">&times;</button>
        <h3 id="confirmFinanceiroTitle">Confirmar ação</h3>
        <p id="confirmFinanceiroMessage">Informe sua senha para continuar.</p>
        <div class="df-field">
            <label for="confirmFinanceiroPassword">Senha</label>
            <input type="password" id="confirmFinanceiroPassword" autocomplete="current-password">
        </div>
        <div class="fin-confirm-actions">
            <button type="button" class="btn-ghost" data-fin-modal-close>Cancelar</button>
            <button type="button" class="btn-primary" id="confirmFinanceiroSubmit">Confirmar</button>
        </div>
    </div>
</div>

<style>
.fin-confirm-modal{position:fixed;inset:0;z-index:1050;display:none;align-items:center;justify-content:center;padding:16px}
.fin-confirm-modal.is-open{display:flex}
.fin-confirm-backdrop{position:absolute;inset:0;background:rgba(15,23,42,.45)}
.fin-confirm-dialog{position:relative;width:min(420px,100%);background:var(--white);border:1px solid var(--border);border-radius:8px;box-shadow:var(--shadow-lg);padding:22px}
.fin-confirm-dialog h3{margin:0 0 8px;font-size:17px;font-weight:800;color:var(--text)}
.fin-confirm-dialog p{margin:0 0 16px;color:var(--text-muted);font-size:13px}
.fin-confirm-close{position:absolute;top:10px;right:12px;border:0;background:transparent;font-size:24px;line-height:1;color:var(--text-muted);cursor:pointer}
.fin-confirm-actions{display:flex;justify-content:flex-end;gap:10px;margin-top:16px}
[data-theme="dark"] .fin-confirm-dialog{background:#1f222c}
</style>

<script>
document.querySelectorAll('.js-money').forEach((input) => {
    const formatMoney = () => {
        const digits = input.value.replace(/\D/g, '');
        const cents = digits === '' ? 0 : parseInt(digits, 10);
        input.value = (cents / 100).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    };
    if (input.value) {
        const initial = Number(String(input.value).replace(',', '.'));
        if (!Number.isNaN(initial)) {
            input.value = initial.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        }
    }
    input.addEventListener('input', formatMoney);
});

function normalizeMoneyFields(form) {
    Array.from(form.elements).forEach((input) => {
        if (input.classList && input.classList.contains('js-money')) {
            input.value = input.value.replace(/\./g, '').replace(',', '.');
        }
    });
}

document.querySelectorAll('form').forEach((form) => {
    form.addEventListener('submit', () => normalizeMoneyFields(form));
});

const finModal = document.getElementById('confirmFinanceiroModal');
const finPassword = document.getElementById('confirmFinanceiroPassword');
const finTitle = document.getElementById('confirmFinanceiroTitle');
const finMessage = document.getElementById('confirmFinanceiroMessage');
const finSubmit = document.getElementById('confirmFinanceiroSubmit');
let pendingFinForm = null;

document.querySelectorAll('.js-confirm-financeiro').forEach((button) => {
    button.addEventListener('click', () => {
        pendingFinForm = button.form || button.closest('form');
        finTitle.textContent = button.dataset.title || 'Confirmar ação';
        finMessage.textContent = button.dataset.message || 'Informe sua senha para continuar.';
        finPassword.value = '';
        finModal.classList.add('is-open');
        finModal.setAttribute('aria-hidden', 'false');
        setTimeout(() => finPassword.focus(), 60);
    });
});

document.querySelectorAll('[data-fin-modal-close]').forEach((button) => {
    button.addEventListener('click', () => {
        finModal.classList.remove('is-open');
        finModal.setAttribute('aria-hidden', 'true');
        pendingFinForm = null;
    });
});

finSubmit.addEventListener('click', () => {
    if (!pendingFinForm || !finPassword.value.trim()) {
        finPassword.focus();
        return;
    }
    const passwordField = pendingFinForm.elements['admin_senha'];
    if (!passwordField) {
        return;
    }
    passwordField.value = finPassword.value;
    normalizeMoneyFields(pendingFinForm);
    pendingFinForm.submit();
});
</script>

<?php require_once __DIR__ . '/../../layout/footer.php'; ?>


