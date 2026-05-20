<?php
$paginaTitulo = 'Avisos';
$paginaAtiva  = 'avisos';
require_once __DIR__ . '/../layout/header.php';
$privilegio = $usuario['privilegio'] ?? 1;
?>

<main class="main-content">
<div class="df-container">

    <div class="page-header">
        <h2>Avisos do Condomínio</h2>
        <p class="text-muted">Comunicados e informações importantes</p>
    </div>

    <?php if (isset($_GET['sucesso'])): ?>
        <div class="df-alert df-alert-success">Aviso publicado com sucesso!</div>
    <?php endif; ?>
    <?php if (isset($_GET['excluido'])): ?>
        <div class="df-alert df-alert-error">Aviso removido com sucesso!</div>
    <?php endif; ?>
    <?php if (isset($_SESSION['erro_aviso'])): ?>
        <div class="df-alert df-alert-error"><?= htmlspecialchars($_SESSION['erro_aviso']) ?><?php unset($_SESSION['erro_aviso']); ?></div>
    <?php endif; ?>

    <?php if (in_array($privilegio, [2, 4])): ?>
    <div class="df-card" style="margin-bottom: 24px;">
        <h3 class="section-title">Publicar Aviso</h3>
        <form action="<?= BASE_URL ?>/avisos/salvar" method="POST">
            <div class="df-field">
                <label>Título</label>
                <input type="text" name="titulo" placeholder="Ex: Manutenção da piscina" required>
            </div>
            <div class="df-field">
                <label>Mensagem</label>
                <textarea name="mensagem" rows="4" placeholder="Digite o aviso aqui..." required></textarea>
            </div>
            <div class="df-actions">
                <button type="reset" class="btn-ghost">Limpar</button>
                <button type="submit" class="btn-primary">Publicar</button>
            </div>
        </form>
    </div>
    <?php endif; ?>

    <div class="df-card">
        <h3 class="section-title">Avisos Publicados</h3>
        <?php if (empty($avisos)): ?>
            <div class="empty-state">
                <i class='bx bx-bell-off'></i>
                <h5>Nenhum aviso publicado</h5>
                <p>Nenhum comunicado no momento.</p>
            </div>
        <?php else: ?>
            <?php foreach ($avisos as $aviso): ?>
                <div class="aviso-card">
                    <div>
                        <h4>
                            <i class='bx bx-bell aviso-card-icon'></i>
                            <?= htmlspecialchars($aviso['titulo']) ?>
                        </h4>
                        <p><?= nl2br(htmlspecialchars($aviso['mensagem'])) ?></p>
                        <small>
                            Publicado por <strong><?= htmlspecialchars($aviso['nome_autor']) ?></strong>
                            em <?= date('d/m/Y \à\s H:i', strtotime($aviso['created_at'])) ?>
                        </small>
                    </div>
                    <?php if (in_array($privilegio, [2, 4])): ?>
                        <form action="<?= BASE_URL ?>/avisos/excluir" method="POST"
                              onsubmit="return confirm('Deseja remover este aviso?')">
                            <input type="hidden" name="id_aviso" value="<?= $aviso['id_aviso'] ?>">
                            <button type="submit" class="btn-danger-sm">
                                <i class='bx bx-trash'> Remover.</i>
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</div>
</main>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
