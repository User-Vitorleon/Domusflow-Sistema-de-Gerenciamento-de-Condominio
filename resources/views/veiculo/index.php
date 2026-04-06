<?php
$paginaTitulo = 'Veículos';
$paginaAtiva  = 'veiculo';
$cssExtra     = 'veiculo.css';
$jsExtra      = 'veiculo.js';
require_once __DIR__ . '/../layout/header.php';
require_once __DIR__ . '/../layout/sidebar.php';
$prev = $usuario['previlegio'] ?? 1;
?>

<main class="main-content">
    <div class="page-header">
        <h2>Controle de Veículos</h2>
    </div>

    <?php if (isset($_GET['sucesso'])): ?>
        <div class="df-alert df-alert-success">Operação realizada com sucesso!</div>
    <?php endif; ?>

    <?php if (isset($_SESSION['erro_veiculo'])): ?>
        <div class="df-alert df-alert-error"><?= htmlspecialchars($_SESSION['erro_veiculo']) ?></div>
        <?php unset($_SESSION['erro_veiculo']); ?>
    <?php endif; ?>

    <!-- formulário só aparece para porteiro, síndico e admin -->
    <?php if (in_array($prev, [2, 3, 4])): ?>
        <div class="df-card" style="margin-bottom: 24px;">
            <h3 class="section-title">Cadastrar Veículo</h3>
            <form action="<?= BASE_URL ?>/veiculo/salvar" method="POST">
                <div class="df-grid-2">
                    <div class="df-field">
                        <label>Placa</label>
                        <input type="text" name="placa" placeholder="Ex: ABC-1234" required maxlength="10">
                    </div>
                    <div class="df-field">
                        <label>Cor</label>
                        <input type="text" name="cor" placeholder="Ex: Prata" required>
                    </div>
                </div>
                <div class="df-grid-2">
                    <div class="df-field">
                        <label>Marca</label>
                        <input type="text" name="marca" placeholder="Ex: Honda" required>
                    </div>
                    <div class="df-field">
                        <label>Modelo</label>
                        <input type="text" name="modelo" placeholder="Ex: Civic" required>
                    </div>
                </div>
                <div class="df-field">
                    <label>Morador (dono do veículo)</label>
                    <select name="id_user" required>
                        <option value="">Selecione...</option>
                        <?php foreach ($moradores as $m): ?>
                            <?php if (in_array($m['previlegio'], [1, 2])): ?>
                                <option value="<?= $m['id_user'] ?>">
                                    <?= htmlspecialchars($m['nome']) ?> — Ap <?= $m['apto'] ?> · Bloco <?= $m['bloco'] ?>
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="df-actions">
                    <button type="reset" class="btn-ghost">Limpar</button>
                    <button type="submit" class="btn-primary">Cadastrar</button>
                </div>
            </form>
        </div>
    <?php endif; ?>

    <!-- tabela de veículos -->
    <div class="df-card">
        <h3 class="section-title">
            <?= in_array($prev, [2, 3, 4]) ? 'Todos os Veículos' : 'Meus Veículos' ?>
        </h3>

        <?php if (empty($veiculos)): ?>
            <div class="empty-state">
                <i class="bx bx-car"></i>
                <h5>Nenhum veículo cadastrado</h5>
                <p>Os veículos cadastrados aparecerão aqui.</p>
            </div>
        <?php else: ?>
            <div class="table-wrap">
                <table class="df-table">
                    <thead>
                        <tr>
                            <th>Placa</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Cor</th>
                            <?php if (in_array($prev, [2, 3, 4])): ?>
                                <th>Morador</th>
                                <th>Cadastrado por</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($veiculos as $v): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($v['placa']) ?></strong></td>
                                <td><?= htmlspecialchars($v['marca']) ?></td>
                                <td><?= htmlspecialchars($v['modelo']) ?></td>
                                <td><?= htmlspecialchars($v['cor']) ?></td>
                                <?php if (in_array($prev, [2, 3, 4])): ?>
                                    <td><?= htmlspecialchars($v['nome_morador']) ?></td>
                                    <td><?= htmlspecialchars($v['cadastrado_por']) ?></td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>