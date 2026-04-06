<?php
$paginaTitulo = 'Consulta de Veículo';
$paginaAtiva  = 'consulta-veiculo';
$cssExtra     = 'veiculo.css';
require_once __DIR__ . '/../layout/header.php';
require_once __DIR__ . '/../layout/sidebar.php';
?>

<main class="main-content">
    <div class="page-header">
        <h2>Consulta Rápida por Placa</h2>
    </div>

    <div class="df-card">
        <form action="<?= BASE_URL ?>/veiculo/consultar" method="POST">
            <div class="df-grid-2">
                <div class="df-field">
                    <label>Placa do Veículo</label>
                    <input type="text" name="placa" id="inputPlaca"
                        placeholder="Ex: ABC-1234"
                        value="<?= htmlspecialchars($_POST['placa'] ?? '') ?>"
                        required maxlength="10" autofocus>
                </div>
            </div>
            <div class="df-actions">
                <button type="submit" class="btn-primary">Consultar</button>
            </div>
        </form>
    </div>

    <!-- resultado da consulta -->
    <?php if ($resultado !== null): ?>
        <div class="df-card resultado-card">
            <?php if ($resultado['sucesso']): ?>
                <?php $v = $resultado['veiculo']; ?>
                <div class="df-alert df-alert-success">Veículo encontrado!</div>
                <div class="df-grid-2">
                    <div class="df-field">
                        <label>Placa</label>
                        <p class="resultado-valor"><?= htmlspecialchars($v['placa']) ?></p>
                    </div>
                    <div class="df-field">
                        <label>Cor</label>
                        <p class="resultado-valor"><?= htmlspecialchars($v['cor']) ?></p>
                    </div>
                    <div class="df-field">
                        <label>Marca</label>
                        <p class="resultado-valor"><?= htmlspecialchars($v['marca']) ?></p>
                    </div>
                    <div class="df-field">
                        <label>Modelo</label>
                        <p class="resultado-valor"><?= htmlspecialchars($v['modelo']) ?></p>
                    </div>
                    <div class="df-field">
                        <label>Morador</label>
                        <p class="resultado-valor"><?= htmlspecialchars($v['nome_morador']) ?></p>
                    </div>
                    <div class="df-field">
                        <label>Unidade</label>
                        <p class="resultado-valor">Ap <?= htmlspecialchars($v['apto']) ?> · Bloco <?= htmlspecialchars($v['bloco']) ?></p>
                    </div>
                </div>
            <?php else: ?>
                <div class="df-alert df-alert-error"><?= htmlspecialchars($resultado['mensagem']) ?></div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

</main>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>