<?php
$paginaTitulo = 'Taxas Condominiais';
$paginaAtiva  = 'financeiro';
require_once __DIR__ . '/../../layout/header.php';
?>

<main class="main-content">
    <div class="page-header">
        <h2>Taxas Condominiais</h2>
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
        <div class="df-alert df-alert-error">Taxa excluída com sucesso!</div>
    <?php endif; ?>

    <div class="df-card" style="margin-bottom: 24px;">
        <h3 class="section-title">Cadastrar Nova Taxa</h3>
        <form action="<?= BASE_URL ?>/financeiro/taxas/salvar" method="POST">
            <div class="df-grid-2">
                <div class="df-field">
                    <label>Descrição</label>
                    <input type="text" name="descricao" placeholder="Ex: Taxa de Condomínio" required>
                </div>
                <div class="df-field">
                    <label>Valor (R$)</label>
                    <input type="number" name="valor" step="0.01" min="0" placeholder="0,00" required>
                </div>
                <div class="df-field">
                    <div class="df-field">
                        <label>Módulo</label>
                        <select name="modulo" required>
                            <option value="">Selecione...</option>
                            <option value="TAXA">Taxa</option>
                            <option value="MULTA">Multa</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="df-actions">
                <button type="reset" class="btn-ghost">Limpar</button>
                <button type="submit" class="btn-primary">Cadastrar Taxa</button>
            </div>
        </form>
    </div>

    <div class="df-card">
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
                <div style="
                    width: 42px; height: 42px; border-radius: 50%;
                    background: <?= $taxa['modulo'] === 'TAXA' ? '#EFF6FF' : '#FEF2F2' ?>;
                    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
                ">
                    <i class='bx <?= $taxa['modulo'] === 'TAXA' ? 'bx-coin' : 'bx-error' ?>'
                       style="font-size: 20px; color: <?= $taxa['modulo'] === 'TAXA' ? '#2563EB' : '#DC2626' ?>"></i>
                </div>

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

                <div class="morador-actions">
                    <span style="color: <?= $taxa['status'] === 'A' ? '#16A34A' : '#EF4444' ?>; font-size: 13px; font-weight: 600;">
                        <?= $taxa['status'] === 'A' ? 'Ativa' : 'Inativa' ?>
                    </span>
                    <form action="<?= BASE_URL ?>/financeiro/taxas/excluir" method="POST"
                          onsubmit="return confirm('Deseja excluir esta taxa?')">
                        <input type="hidden" name="id_taxa" value="<?= $taxa['id_taxa'] ?>">
                        <button type="submit" class="btn-danger-sm">
                            <i class='bx bx-trash'></i> Excluir
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