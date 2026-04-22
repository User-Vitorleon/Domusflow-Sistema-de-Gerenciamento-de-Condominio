<?php
$paginaTitulo = 'Meu Perfil';
$paginaAtiva  = 'perfil';
$cssExtra     = 'perfil.css';
$cssTela      = 'morador.css';
require_once __DIR__ . '/../../layout/header.php';
require_once __DIR__ . '/../../layout/sidebar.php';
?>

<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
<div class="perfil-wrapper">
  <div class="perfil-card">

    <!-- Cabeçalho do perfil -->
    <div class="d-flex align-items-center gap-3 mb-1">
      <img
        src="<?= ($usuario['sexo'] === 'M')
          ? 'https://png.pngtree.com/png-vector/20231019/ourmid/pngtree-user-profile-avatar-png-image_10211467.png'
          : 'https://images.icon-icons.com/3708/PNG/512/girl_female_woman_person_people_avatar_icon_230018.png' ?>"
        class="perfil-avatar" alt="avatar">
      <div>
        <p class="perfil-nome"><?= htmlspecialchars($usuario['nome']) ?></p>
        <span class="perfil-badge">
          <?php
            $labels = [1 => 'Morador', 2 => 'Síndico', 3 => 'Porteiro', 4 => 'Admin'];
            echo $labels[$usuario['previlegio']] ?? 'Usuário';
          ?>
        </span>
      </div>
    </div>

    <!-- Alerta de erro -->
    <?php if (!empty($_SESSION['erro_update'])): ?>
      <div class="alert-erro">
        <i class='bx bx-error-circle'></i>
        <?= htmlspecialchars($_SESSION['erro_update']) ?>
      </div>
      <?php unset($_SESSION['erro_update']); ?>
    <?php endif; ?>

    <!-- Formulário de atualização -->
    <form action="<?= BASE_URL ?>/cadastro/update/salvar" method="POST">

      <p class="section-title">Informações pessoais</p>
      <div class="form-grid">
        <div class="field">
          <label>Nome completo</label>
          <input type="text" name="user_nome" value="<?= htmlspecialchars($usuario['nome']) ?>" required>
        </div>
        <div class="field">
          <label>E-mail</label>
          <input type="email" name="user_email" value="<?= htmlspecialchars($usuario['email']) ?>" required>
        </div>
        <div class="field">
          <label>Apartamento</label>
          <input type="text" name="user_apto" value="<?= htmlspecialchars($usuario['apto']) ?>" required>
        </div>
        <div class="field">
          <label>Bloco</label>
          <input type="text" name="user_bloco" value="<?= htmlspecialchars($usuario['bloco']) ?>" required>
        </div>
        <div class="field">
          <label>Telefone</label>
          <input type="text" name="user_telefone" value="<?= htmlspecialchars($usuario['telefone']) ?>" required>
        </div>
        <div class="field">
          <label>Telefone recado</label>
          <input type="text" name="user_tell_recado" value="<?= htmlspecialchars($usuario['tell_recado'] ?? '') ?>">
        </div>
      </div>

      <p class="section-title">Alterar senha</p>
      <div class="form-grid">
        <div class="field">
          <label>Nova senha</label>
          <input type="password" name="user_senha" placeholder="Deixe vazio para manter">
        </div>
        <div class="field">
          <label>Confirmar nova senha</label>
          <input type="password" name="user_conf_senha" placeholder="Repita a nova senha">
        </div>
      </div>

      <button type="submit" class="btn-salvar">
        <i class='bx bx-save me-1'></i> Salvar alterações
      </button>

    </form>

    <hr class="divider">

    <!-- Zona de perigo -->
    <div class="danger-zone">
      <h6><i class='bx bx-shield-x me-1'></i> Zona de perigo</h6>
      <div class="danger-btns">

        <form action="<?= BASE_URL ?>/moradores/inativar" method="POST" style="flex:1"
          onsubmit="return confirm('Deseja inativar sua conta? Você não conseguirá mais acessar o sistema.')">
          <button type="submit" class="btn-inativar w-100">
            <i class='bx bx-pause-circle me-1'></i> Inativar conta
          </button>
        </form>

        <form action="<?= BASE_URL ?>/moradores/deletar" method="POST" style="flex:1"
          onsubmit="return confirm('Atenção! Esta ação é irreversível. Seus dados serão apagados permanentemente.')">
          <button type="submit" class="btn-deletar w-100">
            <i class='bx bx-trash me-1'></i> Apagar conta
          </button>
        </form>

      </div>
    </div>

  </div>
</div>

<?php require_once __DIR__ . '/../../layout/footer.php'; ?>