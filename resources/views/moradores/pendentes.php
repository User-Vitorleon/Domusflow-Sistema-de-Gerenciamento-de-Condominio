<?php
$paginaTitulo = 'Novos Usuários';
$paginaAtiva  = 'moradores';
require_once __DIR__ . '/../layout/header.php';
require_once __DIR__ . '/../layout/sidebar.php';
?>

<main class="main-content">
    <div class="page-header">
        <h2>Solicitações de Acesso</h2>
        <p class="text-muted">Aprove ou negue os cadastros pendentes</p>
    </div>

    <?php if (isset($_GET['status'])): ?>
        <div class="df-alert df-alert-<?= $_GET['status'] === 'liberado' ? 'success' : 'warning' ?>">
            Morador <?= $_GET['status'] === 'liberado' ? 'liberado' : 'negado' ?> com sucesso.
        </div>
    <?php endif; ?>

    <?php if (empty($moradores)): ?>
        <div class="empty-state">
            <i class='bx bx-check-shield'></i>
            <h5>Tudo em dia!</h5>
            <p>Nenhuma solicitação pendente no momento.</p>
        </div>
    <?php else: ?>
        <div class="morador-list">
            <?php foreach ($moradores as $m):
                $avatar = ($m['sexo'] === 'M')
                    ? 'https://png.pngtree.com/png-vector/20231019/ourmid/pngtree-user-profile-avatar-png-image_10211467.png'
                    : 'https://images.icon-icons.com/3708/PNG/512/girl_female_woman_person_people_avatar_icon_230018.png';
            ?>
                <div class="morador-card">
                    <img src="<?= $avatar ?>" alt="avatar" class="morador-avatar">
                    <div class="morador-info">
                        <strong><?= htmlspecialchars($m['nome']) ?></strong>
                        <span>CPF: <?= htmlspecialchars($m['cpf']) ?> · Ap <?= htmlspecialchars($m['apto']) ?> · Bloco <?= htmlspecialchars($m['bloco']) ?></span>
                    </div>
                    <form action="<?= BASE_URL ?>/moradores/liberar" method="POST" class="morador-actions">
                        <input type="hidden" name="id_morador" value="<?= $m['id_user'] ?>">
                        <button type="submit" name="acao" value="aceitar" class="btn-success-sm">Aceitar</button>
                        <button type="submit" name="acao" value="negar" class="btn-danger-sm">Negar</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>