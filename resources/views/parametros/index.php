<?php
$paginaTitulo = 'Parâmetros';
$paginaAtiva  = 'parametros';
$cssTela      = 'parametros.css';
$jsExtra      = 'parametros.js';
require_once __DIR__ . '/../layout/header.php';

$limiteMoradores    = (int)($parametros['limite_moradores_ativos'] ?? 1000);
$permitirUmaReserva = !empty($parametros['permitir_apenas_uma_reserva_pendente']);
$limiteVeiculos     = (int)($parametros['limite_veiculos_por_morador'] ?? 2);
$percentualUso      = $limiteMoradores > 0 ? min(100, round(($totalMoradoresAtivos / $limiteMoradores) * 100)) : 0;
?>

<main class="main-content">
    <div class="df-page parametros-page">
        <div class="page-header parametros-header">
            <div>
                <h2>Parâmetros do Sistema</h2>
                <p class="text-muted">Configure regras gerais usadas pelo DomusFlow.</p>
            </div>
            <span class="parametros-note">Apenas para novas requisições.</span>
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

        <div class="df-card parametros-lista">
            <div class="parametros-lista-head">
                <h3 class="section-title">Parâmetros cadastrados</h3>
                <span class="text-muted">Salve cada regra individualmente</span>
            </div>

            <div class="parametros-table-wrap">
                <table class="df-table parametros-table">
                    <thead>
                        <tr>
                            <th>Parâmetro</th>
                            <th>Atual</th>
                            <th>Editar valor</th>
                            <th>Observação</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <strong>Limite de moradores ativos</strong>
                                <small><?= $percentualUso ?>% do limite utilizado</small>
                            </td>
                            <td>
                                <span class="parametros-kpi"><?= (int)$totalMoradoresAtivos ?> / <?= $limiteMoradores ?></span>
                            </td>
                            <td>
                                <form id="param-limite-moradores" action="<?= BASE_URL ?>/parametros/salvar" method="POST"></form>
                                <input form="param-limite-moradores" type="hidden" name="parametro" value="limite_moradores_ativos">
                                <input form="param-limite-moradores" type="hidden" name="admin_senha" value="">
                                <input form="param-limite-moradores" type="number" name="valor" min="1" value="<?= $limiteMoradores ?>" class="parametros-input" required>
                            </td>
                            <td>Quantidade máxima de moradores com acesso liberado.</td>
                            <td>
                                <button form="param-limite-moradores" type="button" class="btn-primary parametros-save js-confirm-parametro"
                                    data-title="Salvar limite de moradores"
                                    data-message="Informe sua senha para alterar o limite de moradores ativos.">Salvar</button>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <strong>Limite de veículos por morador</strong>
                                <small>Sempre 1 veículo principal por morador</small>
                            </td>
                            <td>
                                <span class="parametros-kpi"><?= $limiteVeiculos ?></span>
                            </td>
                            <td>
                                <form id="param-limite-veiculos" action="<?= BASE_URL ?>/parametros/salvar" method="POST"></form>
                                <input form="param-limite-veiculos" type="hidden" name="parametro" value="limite_veiculos_por_morador">
                                <input form="param-limite-veiculos" type="hidden" name="admin_senha" value="">
                                <input form="param-limite-veiculos" type="number" name="valor" min="1" value="<?= $limiteVeiculos ?>" class="parametros-input" required>
                            </td>
                            <td>Controla o cadastro de veículos em /veiculo.</td>
                            <td>
                                <button form="param-limite-veiculos" type="button" class="btn-primary parametros-save js-confirm-parametro"
                                    data-title="Salvar limite de veículos"
                                    data-message="Informe sua senha para alterar o limite de veículos por morador.">Salvar</button>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <strong>Reserva pendente única</strong>
                                <small>Regra aplicada no backend</small>
                            </td>
                            <td>
                                <span class="parametros-kpi"><?= $permitirUmaReserva ? 'Ativo' : 'Inativo' ?></span>
                            </td>
                            <td>
                                <form id="param-reserva-pendente" action="<?= BASE_URL ?>/parametros/salvar" method="POST"></form>
                                <input form="param-reserva-pendente" type="hidden" name="parametro" value="permitir_apenas_uma_reserva_pendente">
                                <input form="param-reserva-pendente" type="hidden" name="admin_senha" value="">
                                <select form="param-reserva-pendente" name="valor" class="parametros-input">
                                    <option value="1" <?= $permitirUmaReserva ? 'selected' : '' ?>>Ativo</option>
                                    <option value="0" <?= !$permitirUmaReserva ? 'selected' : '' ?>>Inativo</option>
                                </select>
                            </td>
                            <td>Impede mais de uma reserva pendente por morador.</td>
                            <td>
                                <button form="param-reserva-pendente" type="button" class="btn-primary parametros-save js-confirm-parametro"
                                    data-title="Salvar regra de reservas"
                                    data-message="Informe sua senha para alterar a regra de reservas pendentes.">Salvar</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<div class="parametros-modal" id="confirmParametroModal" aria-hidden="true">
    <div class="parametros-modal-backdrop" data-param-modal-close></div>
    <div class="parametros-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="confirmParametroTitle">
        <button type="button" class="parametros-modal-close" data-param-modal-close aria-label="Fechar">&times;</button>
        <h3 id="confirmParametroTitle">Confirmar alteração</h3>
        <p id="confirmParametroMessage">Informe sua senha para continuar.</p>
        <div class="df-field">
            <label for="confirmParametroPassword">Senha do admin</label>
            <input type="password" id="confirmParametroPassword" autocomplete="current-password">
        </div>
        <div class="parametros-modal-actions">
            <button type="button" class="btn-ghost" data-param-modal-close>Cancelar</button>
            <button type="button" class="btn-primary" id="confirmParametroSubmit">Confirmar</button>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
