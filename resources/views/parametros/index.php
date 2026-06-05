<?php
$paginaTitulo = 'Parâmetros';
$paginaAtiva  = 'parametros';
$cssTela      = 'parametros.css';
require_once __DIR__ . '/../layout/header.php';

$limiteMoradores = (int)($parametros['limite_moradores_ativos'] ?? 1000);
$permitirUmaReserva = !empty($parametros['permitir_apenas_uma_reserva_pendente']);
$percentualUso = $limiteMoradores > 0 ? min(100, round(($totalMoradoresAtivos / $limiteMoradores) * 100)) : 0;
?>

<main class="main-content">
    <div class="df-page parametros-page">
        <div class="page-header">
            <h2>Parâmetros do Sistema</h2>
            <p class="text-muted">Configure regras gerais usadas pelo DomusFlow.</p>
        </div>

        <?php if (isset($_SESSION['erro_parametros'])): ?>
            <div class="df-alert df-alert-error">
                <?= htmlspecialchars($_SESSION['erro_parametros']) ?>
                <?php unset($_SESSION['erro_parametros']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['sucesso_parametros'])): ?>
            <div class="df-alert df-alert-success">
                <?= htmlspecialchars($_SESSION['sucesso_parametros']) ?>
                <?php unset($_SESSION['sucesso_parametros']); ?>
            </div>
        <?php endif; ?>

        <form action="<?= BASE_URL ?>/parametros/salvar" method="POST" class="parametros-form">
            <div class="parametros-grid">
                <section class="df-card parametros-card">
                    <div class="parametros-card-head">
                        <div>
                            <h3>Moradores ativos</h3>
                            <p>Limite máximo de moradores liberados no condomínio.</p>
                        </div>
                    </div>

                    <div class="parametros-metricas">
                        <div class="parametros-metrica">
                            <span>Quantidade atual</span>
                            <strong><?= (int)$totalMoradoresAtivos ?></strong>
                        </div>
                        <div class="parametros-metrica">
                            <span>Quantidade limite</span>
                            <strong><?= $limiteMoradores ?></strong>
                        </div>
                    </div>

                    <div class="parametros-progress">
                        <span style="width: <?= $percentualUso ?>%;"></span>
                    </div>
                    <p class="parametros-progress-text"><?= $percentualUso ?>% do limite utilizado</p>

                    <div class="df-field parametros-limite-field">
                        <label>Editar limite de moradores ativos</label>
                        <input type="number" name="limite_moradores_ativos" min="1" value="<?= $limiteMoradores ?>" required>
                    </div>
                </section>

                <section class="df-card parametros-card">
                    <div class="parametros-card-head">
                        <div>
                            <h3>Reservas</h3>
                            <p>Regra para controle de solicitações pendentes por morador.</p>
                        </div>
                    </div>

                    <label class="parametros-switch-row">
                        <input type="checkbox" name="permitir_apenas_uma_reserva_pendente" value="1" <?= $permitirUmaReserva ? 'checked' : '' ?>>
                        <span class="parametros-switch"></span>
                        <span>
                            <strong>Permitir apenas 1 reserva pendente por morador</strong>
                            <small>Quando ativo, o morador precisa aguardar aprovação antes de abrir outra solicitação.</small>
                        </span>
                    </label>

                    <div class="parametros-futuro">
                        <strong>Melhoria futura</strong>
                        <p>Esta área pode receber novas regras, como prazo máximo de reserva, intervalo mínimo entre eventos e políticas de cancelamento.</p>
                    </div>
                </section>
            </div>

            <div class="df-actions parametros-actions">
                <a href="<?= BASE_URL ?>/painel" class="btn-ghost">Voltar</a>
                <button type="submit" class="btn-primary">Salvar parâmetros</button>
            </div>
        </form>
    </div>
</main>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
