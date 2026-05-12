<?php
$paginaTitulo = 'Avisos';
$paginaAtiva  = 'avisos';
require_once __DIR__ . '/../layout/header.php';
$prev = $usuario['previlegio'] ?? 1;
?>

<main class="main-content">
    <div class="page-header">
        <h2>Avisos do Condomínio</h2>
        <p class="text-muted">Comunicados e informações importantes</p>
    </div>

    <?php if (isset($_GET['sucesso'])): ?>
        <div class="df-alert df-alert-success">Aviso publicado com sucesso!</div>
    <?php endif; ?>

    <?php if (isset($_GET['excluido'])): ?>
        <div class="df-alert df-alert-success">Aviso removido com sucesso!</div>
    <?php endif; ?>

    <?php if (isset($_SESSION['erro_aviso'])): ?>
        <div class="df-alert df-alert-error">
            <?= htmlspecialchars($_SESSION['erro_aviso']) ?>
            <?php unset($_SESSION['erro_aviso']); ?>
        </div>
    <?php endif; ?>

    <?php if (in_array($prev, [2, 4])): ?>
    <!-- Formulário — só síndico/admin -->
    <div class="df-card" style="margin-bottom: 24px;">
        <h3 class="section-title">Publicar Aviso</h3>
        <form action="<?= BASE_URL ?>/avisos/salvar" method="POST">
            <div class="df-field">
                <label>Título</label>
                <input type="text" name="titulo" placeholder="Ex: Manutenção da piscina" required>
            </div>
            <div class="df-field">
                <label>Mensagem</label>
                <textarea name="mensagem" rows="4" placeholder="Digite o aviso aqui..." required style="width:100%; padding: 10px; border-radius: 8px; border: 1px solid #ddd;"></textarea>
            </div>
            <div class="df-actions">
                <button type="reset" class="btn-ghost">Limpar</button>
                <button type="submit" class="btn-primary">Publicar</button>
            </div>
        </form>
    </div>
    <?php endif; ?>

    <!-- Lista de avisos -->
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
                <div class="df-card" style="margin-bottom: 16px; border-left: 4px solid #2563EB;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                        <div>
                            <h4 style="margin: 0 0 8px 0; color: #1e293b;">
                                <i class='bx bx-bell' style="color: #2563EB;"></i>
                                <?= htmlspecialchars($aviso['titulo']) ?>
                            </h4>
                            <p style="margin: 0 0 12px 0; color: #475569; line-height: 1.6;">
                                <?= nl2br(htmlspecialchars($aviso['mensagem'])) ?>
                            </p>
                            <small style="color: #94a3b8;">
                                Publicado por <strong><?= htmlspecialchars($aviso['nome_autor']) ?></strong>
                                em <?= date('d/m/Y \à\s H:i', strtotime($aviso['created_at'])) ?>
                            </small>
                        </div>
                        <?php if (in_array($prev, [2, 4])): ?>
                            <form action="<?= BASE_URL ?>/avisos/excluir" method="POST" 
                                  onsubmit="return confirm('Deseja remover este aviso?')">
                                <input type="hidden" name="id_aviso" value="<?= $aviso['id_aviso'] ?>">
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
</main>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>