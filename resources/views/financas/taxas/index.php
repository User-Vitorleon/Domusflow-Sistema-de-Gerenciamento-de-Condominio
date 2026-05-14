<?php
$paginaTitulo = 'Cadastro de Taxas';
$paginaAtiva  = 'financeiro';
require_once __DIR__ . '/../../layout/header.php';
?>

<main class="main-content">
    <div style="max-width: 720px; margin: 0 auto;">
        
        <div class="page-header">
            <h2>Cadastro de Taxas</h2>
            <p class="text-muted">Gerencie as taxas padrão do condomínio</p>
        </div>

    <?php if (isset($_SESSION['erro_taxa'])): ?>
        <div class="df-alert df-alert-error">
            <?= htmlspecialchars($_SESSION['erro_taxa']) ?>
            <?php unset($_SESSION['erro_taxa']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['sucesso'])): ?>
        <div class="df-alert df-alert-success">Taxa cadastrada com sucesso!</div>
    <?php endif; ?>

    <?php if (isset($_GET['excluido'])): ?>
        <div class="df-alert df-alert-success">Taxa excluída com sucesso!</div>
    <?php endif; ?>

    <div class="df-card" style="margin-bottom: 24px; max-width: 720px; margin-left: auto; margin-right: auto;">
        <form action="<?= BASE_URL ?>/financeiro/taxas/salvar" method="POST">
            <div class="df-grid-2">
                <div class="df-field">
                    <label>Descrição</label>
                    <input type="text" name="descricao" id="descricao"
                           placeholder="Ex: TAXA DE CONDOMÍNIO" required
                           oninput="this.value = this.value.toUpperCase()">
                </div>
                <div class="df-field">
                    <label>Valor (R$)</label>
                    <input type="number" name="valor" step="0.01" min="0" placeholder="0,00" required>
                </div>
            </div>
            <div class="df-field">
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

    <div class="df-card" style="max-width: 720px; margin-left: auto; margin-right: auto;">
        <h3 class="section-title">Taxas Cadastradas</h3>

        <?php if (empty($taxas)): ?>
            <div class="empty-state">
                <i class='bx bx-receipt'></i>
                <h5>Nenhuma taxa cadastrada</h5>
                <p>Cadastre as taxas padrão do condomínio acima.</p>
            </div>
        <?php else: ?>
            <div class="morador-list">
                <?php foreach ($taxas as $taxa): ?>
                    <div class="morador-card">
                        <!-- Ícone -->
                        <div style="
                            width: 42px; height: 42px; border-radius: 50%; flex-shrink: 0;
                            background: <?= $taxa['modulo'] === 'TAXA' ? '#EFF6FF' : '#FEF2F2' ?>;
                            display: flex; align-items: center; justify-content: center;">
                            <i class='bx <?= $taxa['modulo'] === 'TAXA' ? 'bx-coin' : 'bx-error' ?>'
                               style="font-size: 20px; color: <?= $taxa['modulo'] === 'TAXA' ? '#2563EB' : '#DC2626' ?>"></i>
                        </div>

                        <!-- Info -->
                        <div class="morador-info">
                            <strong><?= htmlspecialchars($taxa['descricao']) ?></strong>
                            <span>
                                <span style="color: <?= $taxa['modulo'] === 'TAXA' ? '#2563EB' : '#DC2626' ?>; font-weight: 600;">
                                    <?= ucfirst(strtolower($taxa['modulo'])) ?>
                                </span>
                                · R$ <?= number_format($taxa['valor'], 2, ',', '.') ?>
                                · <?= htmlspecialchars($taxa['usuario_cad']) ?>
                                · <?= date('d/m/Y', strtotime($taxa['data_cad'])) ?>
                            </span>
                        </div>

                        <!-- Status + Excluir -->
                        <div style="display: flex; align-items: center; gap: 12px; flex-shrink: 0;">
                            <span style="
                                padding: 3px 10px; border-radius: 20px; font-size: 12px; font-weight: 600;
                                background: <?= $taxa['status'] === 'A' ? '#F0FDF4' : '#FEF2F2' ?>;
                                color: <?= $taxa['status'] === 'A' ? '#16A34A' : '#EF4444' ?>;
                                border: 1px solid <?= $taxa['status'] === 'A' ? '#BBF7D0' : '#FECACA' ?>;">
                                <?= $taxa['status'] === 'A' ? 'Ativa' : 'Inativa' ?>
                            </span>
                            <form action="<?= BASE_URL ?>/financeiro/taxas/excluir" method="POST"
                                  onsubmit="return confirm('Deseja excluir esta taxa?')">
                                <input type="hidden" name="id_taxa" value="<?= $taxa['id_taxa'] ?>">
                                <button type="submit" class="btn-danger-sm">
                                    <i class='bx bx-trash'></i>
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php require_once __DIR__ . '/../../layout/footer.php'; ?>