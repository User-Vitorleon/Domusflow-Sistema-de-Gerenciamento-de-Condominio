<?php
$paginaTitulo = 'Cadastro de Taxas/Multas';
$paginaAtiva  = 'financeiro';
$cssTela      = 'financas.css';
$jsExtra      = 'financas-taxas.js';
require_once __DIR__ . '/../../layout/header.php';
?>

<main class="main-content">
    <div class="fin-page">

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

        <div class="df-card fin-card-spaced">
            <form action="<?= BASE_URL ?>/financeiro/taxas/salvar" method="POST">
                <div class="df-grid-2">
                    <div class="df-field">
                        <label>Descrição</label>
                        <input type="text" name="descricao" placeholder="Ex: Taxa de condomínio" required>
                    </div>
                    <div class="df-field">
                        <label>Valor (R$)</label>
                        <input type="text" name="valor" class="js-money fin-edit-control" inputmode="decimal" placeholder="0,00" required>
                    </div>
                </div>
                <div class="df-field fin-field-small">
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
            <div class="fin-card-header">
                <h3 class="section-title">Taxas/Multas Cadastradas</h3>
                <span class="text-muted fin-count"><?= count($taxas ?? []) ?> item(ns)</span>
            </div>

            <?php if (empty($taxas)): ?>
                <div class="empty-state">
                    <i class='bx bx-receipt'></i>
                    <h5>Nenhuma taxa cadastrada</h5>
                    <p>Cadastre as taxas padrão do condomínio acima.</p>
                </div>
            <?php else: ?>
                <div class="fin-table-wrap">
                    <table class="df-table fin-taxas-table">
                        <thead>
                            <tr>
                                <th>Descrição</th>
                                <th>Tipo</th>
                                <th>Valor</th>
                                <th>Status</th>
                                <th>Cadastro</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($taxas as $taxa): ?>
                                <?php $formId = 'taxa-form-' . (int)$taxa['id_taxa']; ?>
                                <tr>
                                    <td class="fin-cell-description">
                                        <form id="<?= $formId ?>" action="<?= BASE_URL ?>/financeiro/taxas/editar" method="POST"></form>
                                        <input form="<?= $formId ?>" type="hidden" name="id_taxa" value="<?= (int)$taxa['id_taxa'] ?>">
                                        <input form="<?= $formId ?>" type="hidden" name="admin_senha" value="">
                                        <input form="<?= $formId ?>" type="text" name="descricao" value="<?= htmlspecialchars($taxa['descricao']) ?>" required class="fin-edit-control">
                                    </td>
                                    <td class="fin-cell-type">
                                        <select form="<?= $formId ?>" name="modulo" required class="fin-edit-control">
                                            <option value="TAXA" <?= strtoupper($taxa['modulo']) === 'TAXA' ? 'selected' : '' ?>>Taxa</option>
                                            <option value="MULTA" <?= strtoupper($taxa['modulo']) === 'MULTA' ? 'selected' : '' ?>>Multa</option>
                                        </select>
                                    </td>
                                    <td class="fin-cell-value">
                                        <input form="<?= $formId ?>" type="text" name="valor" class="js-money fin-edit-control" inputmode="decimal" value="<?= number_format((float)$taxa['valor'], 2, ',', '.') ?>" required>
                                    </td>
                                    <td class="fin-cell-status">
                                        <select form="<?= $formId ?>" name="status" required class="fin-edit-control">
                                            <option value="A" <?= $taxa['status'] === 'A' ? 'selected' : '' ?>>Ativa</option>
                                            <option value="I" <?= $taxa['status'] === 'I' ? 'selected' : '' ?>>Inativa</option>
                                        </select>
                                    </td>
                                    <td class="fin-cell-muted">
                                        <?= htmlspecialchars($taxa['usuario_cad'] ?? '-') ?><br>
                                        <small><?= !empty($taxa['data_cad']) ? date('d/m/Y', strtotime($taxa['data_cad'])) : '-' ?></small>
                                    </td>
                                    <td>
                                        <div class="fin-row-actions">
                                            <button form="<?= $formId ?>" type="button" class="btn-primary js-confirm-financeiro" data-title="Salvar taxa/multa" data-message="Informe sua senha para salvar as alterações.">Salvar</button>
                                            <?php if ($taxa['status'] === 'A'): ?>
                                                <form action="<?= BASE_URL ?>/financeiro/taxas/excluir" method="POST">
                                                    <input type="hidden" name="id_taxa" value="<?= (int)$taxa['id_taxa'] ?>">
                                                    <input type="hidden" name="admin_senha" value="">
                                                    <button type="button" class="btn-danger-sm js-confirm-financeiro" data-title="Inativar taxa/multa" data-message="Informe sua senha para inativar esta taxa/multa.">Inativar</button>
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

<?php require_once __DIR__ . '/../../layout/footer.php'; ?>

