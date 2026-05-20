<?php
$paginaTitulo = 'Assembleias';
$paginaAtiva  = 'assembleia';
require_once __DIR__ . '/../layout/header.php';
<<<<<<< HEAD
$prev = $usuario['privilegio'] ?? 1;
=======
$privilegio = $usuario['privilegio'] ?? 1;
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
?>

<main class="main-content">
<div class="df-container">

    <div class="page-header">
        <h2>Assembleias</h2>
        <p class="text-muted">Convocações e reuniões do condomínio</p>
    </div>

    <?php if (isset($_GET['sucesso'])): ?>
        <div class="df-alert df-alert-success">Assembleia publicada com sucesso!</div>
    <?php endif; ?>
    <?php if (isset($_GET['excluido'])): ?>
        <div class="df-alert df-alert-success">Assembleia removida com sucesso!</div>
    <?php endif; ?>
    <?php if (isset($_GET['presenca'])): ?>
        <?php if ($_GET['presenca'] === 'S'): ?>
            <div class="df-alert df-alert-success">Presença confirmada com sucesso!</div>
        <?php else: ?>
            <div class="df-alert df-alert-warning">Presença cancelada!</div>
        <?php endif; ?>
    <?php endif; ?>
    <?php if (isset($_SESSION['erro_assembleia'])): ?>
        <div class="df-alert df-alert-error">
            <?= htmlspecialchars($_SESSION['erro_assembleia']) ?>
            <?php unset($_SESSION['erro_assembleia']); ?>
        </div>
    <?php endif; ?>

<<<<<<< HEAD
    <?php if (in_array($prev, [2, 4])): ?>
=======
    <?php if (in_array($privilegio, [2, 4])): ?>
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
    <div class="df-card" style="margin-bottom: 24px;">
        <h3 class="section-title">Convocar Assembleia</h3>
        <form action="<?= BASE_URL ?>/assembleia/salvar" method="POST">
            <div class="df-field">
                <label>Título</label>
                <input type="text" name="titulo" placeholder="Ex: Assembleia Ordinária 2026" required>
            </div>
            <div class="df-grid-2">
                <div class="df-field">
                    <label>Data</label>
                    <input type="date" name="data" required>
                </div>
                <div class="df-field">
                    <label>Hora</label>
                    <input type="time" name="hora" required>
                </div>
            </div>
            <div class="df-field">
                <label>Local</label>
                <input type="text" name="local" placeholder="Ex: Salão de Festas" required>
            </div>
            <div class="df-field">
                <label>Pauta</label>
                <textarea name="pauta" rows="4" placeholder="Descreva os assuntos a serem discutidos..." required></textarea>
            </div>
            <div class="df-actions">
                <button type="reset" class="btn-ghost">Limpar</button>
                <button type="submit" class="btn-primary">Convocar</button>
            </div>
        </form>
    </div>
    <?php endif; ?>

    <div class="df-card">
        <h3 class="section-title">Assembleias Convocadas</h3>

        <?php if (empty($avisos)): ?>
            <div class="empty-state">
                <i class='bx bx-group'></i>
                <h5>Nenhuma assembleia convocada</h5>
                <p>Nenhuma reunião agendada no momento.</p>
            </div>
        <?php else: ?>
            <?php foreach ($avisos as $a):
                $presenca = null;
<<<<<<< HEAD
                if ($prev == 1) {
=======
                if ($privilegio == 1) {
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
                    $presenca = $assembleiaRepo->verificarPresenca($a['id_assembleia'], (int)$_SESSION['usuario_id']);
                }
            ?>
                <div class="assembleia-card">
                    <div class="assembleia-card-body">
                        <h4>
                            <i class='bx bx-group' style="color: #7C3AED;"></i>
                            <?= htmlspecialchars($a['titulo']) ?>
                        </h4>

                        <div class="assembleia-card-meta">
                            <span>
                                <i class='bx bx-calendar'></i>
                                <strong><?= date('d/m/Y', strtotime($a['data'])) ?></strong>
                                às <strong><?= date('H:i', strtotime($a['hora'])) ?></strong>
                            </span>
                            <span>
                                <i class='bx bx-map'></i>
                                <?= htmlspecialchars($a['local']) ?>
                            </span>
                        </div>

                        <p class="assembleia-card-pauta">
                            <strong>Pauta:</strong> <?= nl2br(htmlspecialchars($a['pauta'])) ?>
                        </p>

                        <small class="assembleia-card-autor">
                            Convocada por <strong><?= htmlspecialchars($a['nome_autor']) ?></strong>
                            em <?= date('d/m/Y \à\s H:i', strtotime($a['created_at'])) ?>
                        </small>
                    </div>

                    <div class="assembleia-card-actions">
<<<<<<< HEAD
                        <?php if ($prev == 1): ?>
=======
                        <?php if ($privilegio == 1): ?>
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
                            <?php if ($presenca === 'S'): ?>
                                <span class="assembleia-presenca-confirmada">
                                    <i class='bx bx-check-circle'></i> Presença Confirmada
                                </span>
                                <form action="<?= BASE_URL ?>/assembleia/presenca" method="POST">
                                    <input type="hidden" name="id_assembleia" value="<?= $a['id_assembleia'] ?>">
                                    <button type="submit" name="presenca" value="N" class="btn-danger-sm">
                                        <i class='bx bx-x'></i> Cancelar Presença
                                    </button>
                                </form>
                            <?php elseif ($presenca === 'N'): ?>
                                <span class="assembleia-presenca-negada">
                                    <i class='bx bx-x-circle'></i> Presença Negada
                                </span>
                                <form action="<?= BASE_URL ?>/assembleia/presenca" method="POST">
                                    <input type="hidden" name="id_assembleia" value="<?= $a['id_assembleia'] ?>">
                                    <button type="submit" name="presenca" value="S" class="btn-success-sm">
                                        <i class='bx bx-check'></i> Confirmar Presença
                                    </button>
                                </form>
                            <?php else: ?>
                                <form action="<?= BASE_URL ?>/assembleia/presenca" method="POST" class="morador-actions">
                                    <input type="hidden" name="id_assembleia" value="<?= $a['id_assembleia'] ?>">
                                    <button type="submit" name="presenca" value="S" class="btn-success-sm">
                                        <i class='bx bx-check'></i> Confirmar
                                    </button>
                                    <button type="submit" name="presenca" value="N" class="btn-danger-sm">
                                        <i class='bx bx-x'></i> Não irei
                                    </button>
                                </form>
                            <?php endif; ?>
                        <?php endif; ?>

<<<<<<< HEAD
                        <?php if (in_array($prev, [2, 4])): ?>
=======
                        <?php if (in_array($privilegio, [2, 4])): ?>
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
                            <form action="<?= BASE_URL ?>/assembleia/excluir" method="POST"
                                  onsubmit="return confirm('Deseja remover esta assembleia?')">
                                <input type="hidden" name="id_assembleia" value="<?= $a['id_assembleia'] ?>">
                                <button type="submit" class="btn-danger-sm">
                                    <i class='bx bx-trash'></i> Remover
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</div>
</main>

<<<<<<< HEAD
<?php require_once __DIR__ . '/../layout/footer.php'; ?>
=======
<?php require_once __DIR__ . '/../layout/footer.php'; ?>
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
