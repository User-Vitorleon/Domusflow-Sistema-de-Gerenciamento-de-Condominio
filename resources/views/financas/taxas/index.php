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
            <div class="table-wrap">
                <table class="df-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Descrição</th>
                            <th>Valor</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($taxas as $taxa): ?>
                            <tr>
                                <td><?= $taxa['id_taxa'] ?></td>
                                <td><?= htmlspecialchars($taxa['descricao']) ?></td>
                                <td>R$ <?= number_format($taxa['valor'], 2, ',', '.') ?></td>
                                <td>
                                    <span style="color: <?= $taxa['status'] === 'A' ? '#16A34A' : '#EF4444' ?>">
                                        <?= $taxa['status'] === 'A' ? 'Ativa' : 'Inativa' ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php require_once __DIR__ . '/../../layout/footer.php'; ?>