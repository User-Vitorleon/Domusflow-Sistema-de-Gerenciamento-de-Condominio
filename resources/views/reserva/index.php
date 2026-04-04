<?php
$paginaTitulo = 'Reservas';
$paginaAtiva  = 'reserva';
$jsExtra      = 'reserva.js';
require_once __DIR__ . '/../layout/header.php';
require_once __DIR__ . '/../layout/sidebar.php';
$prev = $usuario['previlegio'] ?? 1;
?>

<main class="main-content">
    <div class="page-header">
        <h2><?= $prev == 2 ? 'Cadastrar Local' : 'Nova Reserva' ?></h2>
    </div>

    <?php if (isset($_GET['sucesso'])): ?>
        <div class="df-alert df-alert-success">Operação realizada com sucesso!</div>
    <?php endif; ?>
    <?php if (isset($_SESSION['erro_reserva'])): ?>
        <div class="df-alert df-alert-error"><?= htmlspecialchars($_SESSION['erro_reserva']) ?></div>
        <?php unset($_SESSION['erro_reserva']); ?>
    <?php endif; ?>

    <div class="df-card">
        <?php if ($prev == 1): ?>
            <form action="<?= BASE_URL ?>/reserva/salvar" method="POST" id="formReserva">
                <div class="df-grid-2">
                    <div class="df-field">
                        <label>Local Desejado</label>
                        <select name="id_local" id="id_local" required>
                            <option value="">Selecione...</option>
                            <?php foreach ($locais as $local): ?>
                                <option value="<?= $local['id_local'] ?>" data-cap="<?= $local['capacidade'] ?>">
                                    <?= htmlspecialchars($local['local']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="df-field">
                        <label>Capacidade Máxima</label>
                        <input type="text" id="capacidade" readonly placeholder="Selecione um local">
                    </div>
                </div>

                <div class="df-grid-3">
                    <div class="df-field">
                        <label>Data do Evento</label>
                        <input type="date" name="data_reserva" id="data_reserva" required>
                    </div>
                    <div class="df-field">
                        <label>Horário de Início</label>
                        <input type="time" name="hora_ini" required>
                    </div>
                    <div class="df-field">
                        <label>Horário de Término</label>
                        <input type="time" name="hora_fim" required>
                    </div>
                </div>

                <div id="alertaFeriado" class="df-alert df-alert-warning d-none">
                    <i class='bx bxs-info-circle'></i>
                    Atenção: esta data é feriado — <strong id="nomeFeriado"></strong>
                </div>

                <div class="df-actions">
                    <button type="submit" class="btn-primary">Solicitar Reserva</button>
                </div>
            </form>

        <?php else: ?>

            <form action="<?= BASE_URL ?>/reserva/salvar" method="POST">
                <div class="df-grid-2">
                    <div class="df-field">
                        <label>Nome do Local</label>
                        <input type="text" name="nome_local" placeholder="Ex: Salão de Festas" required>
                    </div>
                    <div class="df-field">
                        <label>Capacidade (pessoas)</label>
                        <input type="number" name="capacidade" placeholder="0" min="1" required>
                    </div>
                </div>
                <div class="df-field">
                    <label>Status</label>
                    <select name="disponivel" required>
                        <option value="S">Disponível</option>
                        <option value="N">Indisponível / Manutenção</option>
                    </select>
                </div>
                <div class="df-actions">
                    <button type="reset" class="btn-ghost">Limpar</button>
                    <button type="submit" class="btn-primary">Salvar Local</button>
                </div>
            </form>
        <?php endif; ?>
    </div>
</main>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>