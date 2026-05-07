<?php
$paginaTitulo = 'Lançamentos';
$paginaAtiva  = 'financeiro';
require_once __DIR__ . '/../../layout/header.php';
$prev = $usuario['previlegio'] ?? 1;
?>

<main class="main-content">
    <div class="page-header">
        <h2>Lançamentos Financeiros</h2>
        <p class="text-muted">Gerencie taxas e multas dos moradores</p>
    </div>

    <?php if (isset($_SESSION['erro_lancamento'])): ?>
        <div class="df-alert df-alert-error">
            <?= htmlspecialchars($_SESSION['erro_lancamento']) ?>
            <?php unset($_SESSION['erro_lancamento']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['erro_fatura'])): ?>
        <div class="df-alert df-alert-error">
            <?= htmlspecialchars($_SESSION['erro_fatura']) ?>
            <?php unset($_SESSION['erro_fatura']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['sucesso_fatura'])): ?>
        <div class="df-alert df-alert-success">
            <?= htmlspecialchars($_SESSION['sucesso_fatura']) ?>
            <?php unset($_SESSION['sucesso_fatura']); ?>
        </div>
    <?php endif; ?>

    <?php if ($prev == 2): ?>
    <!-- Formulário de lançamento — só síndico -->
    <div class="df-card" style="margin-bottom: 24px;">
        <h3 class="section-title">Registrar Lançamento</h3>
        <form action="<?= BASE_URL ?>/financeiro/lancamento/salvar" method="POST">
            <div class="df-grid-2">
                <div class="df-field">
                    <label>Tipo</label>
                    <select name="modelo" required>
                        <option value="">Selecione...</option>
                        <option value="taxa">Taxa</option>
                        <option value="multa">Multa</option>
                    </select>
                </div>
                <div class="df-field">
                    <label>Valor (R$)</label>
                    <input type="number" name="valor" step="0.01" min="0" placeholder="0,00" required>
                </div>
            </div>
            <div class="df-grid-2">
                <div class="df-field">
                    <label>Descrição</label>
                    <input type="text" name="descricao" placeholder="Ex: Taxa de condomínio Jan/2026" required>
                </div>
                <div class="df-field">
                    <label>Morador</label>
                    <select name="id_user" required>
                        <option value="">Selecione...</option>
                        <?php foreach ($moradores as $m): ?>
                            <option value="<?= $m['id_user'] ?>">
                                <?= htmlspecialchars($m['nome']) ?> — Ap <?= $m['apto'] ?> · Bloco <?= $m['bloco'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="df-grid-2">
                <div class="df-field">
                    <label>Data de Vencimento</label>
                    <input type="date" name="data_venc" required>
                </div>
                <div class="df-field">
                    <label>Data de Lançamento</label>
                    <input type="date" name="data_lanc" value="<?= date('Y-m-d') ?>" required>
                </div>
            </div>
            <div class="df-actions">
                <button type="reset" class="btn-ghost">Limpar</button>
                <button type="submit" class="btn-primary">Registrar</button>
            </div>
        </form>
    </div>
    <?php endif; ?>

    <!-- Listagem de lançamentos -->
    <div class="df-card">
        <h3 class="section-title">
            <?= $prev == 2 ? 'Todos os Lançamentos' : 'Meus Lançamentos' ?>
        </h3>

        <?php if (empty($lancamentos)): ?>
            <div class="empty-state">
                <i class='bx bx-receipt'></i>
                <h5>Nenhum lançamento encontrado</h5>
                <p>Os lançamentos aparecerão aqui.</p>
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
                            <?php if ($prev == 2): ?>
                                <th>Morador</th>
                                <th>Ação</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($lancamentos as $l): ?>
                            <tr>
                                <td><?= ucfirst(htmlspecialchars($l['modelo'])) ?></td>
                                <td><?= htmlspecialchars($l['descricao']) ?></td>
                                <td>R$ <?= number_format($l['valor'], 2, ',', '.') ?></td>
                                <td><?= date('d/m/Y', strtotime($l['data_vencimento'])) ?></td>
                                <td>
                                    <span style="color: <?= $l['status'] === 'P' ? '#CA8A04' : '#16A34A' ?>">
                                        <?= $l['status'] === 'P' ? 'Pendente' : 'Pago' ?>
                                    </span>
                                </td>
                                <?php if ($prev == 2): ?>
                                    <td><?= htmlspecialchars($l['nome'] ?? 'N/A') ?></td>
                                    <td>
                                        <!-- Gerar fatura -->
                                        <form action="<?= BASE_URL ?>/financeiro/fatura/gerar" method="POST" style="display:inline"
                                            onsubmit="return confirm('Gerar fatura para este morador?')">
                                            <input type="hidden" name="id_user" value="<?= $l['id_user'] ?>">
                                            <button type="submit" class="btn-primary" style="padding: 4px 10px; font-size: 0.8rem;">
                                                Gerar Fatura
                                            </button>
                                        </form>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php require_once __DIR__ . '/../../layout/footer.php'; ?>