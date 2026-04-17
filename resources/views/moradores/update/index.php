<?php
$paginaTitulo = 'Atualizar Dados';
require_once __DIR__ . '/../../layout/header.php';
require_once __DIR__ . '/../../layout/sidebar.php';
?>

<?php if (isset($_SESSION['erro_update'])): ?>
    <p style="color:red"><?= $_SESSION['erro_update'] ?></p>
    <?php unset($_SESSION['erro_update']); ?>
<?php endif; ?>

<form action="<?= BASE_URL ?>/cadastro/update/salvar" method="POST">

    <input type="text"  name="user_nome"      value="<?= htmlspecialchars($usuario['nome']) ?>">
    <input type="email" name="user_email"     value="<?= htmlspecialchars($usuario['email']) ?>">
    <input type="text"  name="user_apto"      value="<?= htmlspecialchars($usuario['apto']) ?>">
    <input type="text"  name="user_bloco"     value="<?= htmlspecialchars($usuario['bloco']) ?>">
    <input type="text"  name="user_telefone"  value="<?= htmlspecialchars($usuario['telefone']) ?>">
    <input type="text"  name="user_tell_recado" value="<?= htmlspecialchars($usuario['tell_recado'] ?? '') ?>">
    <input type="password" name="user_senha"     placeholder="Nova senha (deixe vazio para manter)">
    <input type="password" name="user_conf_senha" placeholder="Confirme a nova senha">

    <button type="submit">Salvar</button>
</form>

<?php require_once __DIR__ . '/../../layout/footer.php'; ?>