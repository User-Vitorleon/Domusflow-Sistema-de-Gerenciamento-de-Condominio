<?php
$paginaTitulo = 'Meu Perfil';
$paginaAtiva  = 'perfil';
$cssExtra     = 'perfil.css';
require_once __DIR__ . '/../../layout/header.php';
require_once __DIR__ . '/../../layout/sidebar.php';
?>

<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">

<style>
  body { background: #f4f6fb; }

  .perfil-wrapper {
    margin-left: 260px;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
  }

  .perfil-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.07);
    width: 100%;
    max-width: 680px;
    padding: 2.5rem;
    font-family: 'DM Sans', sans-serif;
  }

  .perfil-avatar {
    width: 72px;
    height: 72px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #e8eaf0;
    margin-bottom: 0.5rem;
  }

  .perfil-nome {
    font-size: 1.25rem;
    font-weight: 600;
    color: #1a1d2e;
    margin: 0;
  }

  .perfil-badge {
    font-size: 0.75rem;
    font-weight: 500;
    padding: 3px 10px;
    border-radius: 20px;
    background: #e8f0fe;
    color: #3b5bdb;
    display: inline-block;
    margin-top: 4px;
  }

  .section-title {
    font-size: 0.7rem;
    font-weight: 600;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: #9399a6;
    margin: 1.75rem 0 0.75rem;
  }

  .form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
  }

  .form-grid.full { grid-template-columns: 1fr; }

  .field label {
    display: block;
    font-size: 0.78rem;
    font-weight: 500;
    color: #6b7280;
    margin-bottom: 5px;
  }

  .field input {
    width: 100%;
    padding: 10px 14px;
    border: 1.5px solid #e5e7eb;
    border-radius: 10px;
    font-size: 0.9rem;
    font-family: 'DM Sans', sans-serif;
    color: #1a1d2e;
    background: #fafafa;
    transition: border-color 0.2s, box-shadow 0.2s;
    outline: none;
  }

  .field input:focus {
    border-color: #3b5bdb;
    box-shadow: 0 0 0 3px rgba(59,91,219,0.08);
    background: #fff;
  }

  .divider {
    border: none;
    border-top: 1.5px solid #f0f1f5;
    margin: 2rem 0 1.5rem;
  }

  .btn-salvar {
    width: 100%;
    padding: 12px;
    background: #3b5bdb;
    color: #fff;
    border: none;
    border-radius: 10px;
    font-size: 0.95rem;
    font-weight: 600;
    font-family: 'DM Sans', sans-serif;
    cursor: pointer;
    transition: background 0.2s, transform 0.1s;
    margin-top: 1.25rem;
  }

  .btn-salvar:hover { background: #2f4ac5; }
  .btn-salvar:active { transform: scale(0.99); }

  .danger-zone {
    margin-top: 2rem;
    padding: 1.25rem;
    border-radius: 12px;
    background: #fff5f5;
    border: 1.5px solid #fde8e8;
  }

  .danger-zone h6 {
    font-size: 0.78rem;
    font-weight: 600;
    color: #c0392b;
    text-transform: uppercase;
    letter-spacing: 0.07em;
    margin-bottom: 0.75rem;
  }

  .danger-btns {
    display: flex;
    gap: 0.75rem;
  }

  .btn-inativar, .btn-deletar {
    flex: 1;
    padding: 10px;
    border-radius: 9px;
    font-size: 0.85rem;
    font-weight: 500;
    font-family: 'DM Sans', sans-serif;
    cursor: pointer;
    border: none;
    transition: opacity 0.2s;
  }

  .btn-inativar {
    background: #fff3cd;
    color: #856404;
    border: 1.5px solid #fde68a;
  }

  .btn-deletar {
    background: #fee2e2;
    color: #991b1b;
    border: 1.5px solid #fca5a5;
  }

  .btn-inativar:hover, .btn-deletar:hover { opacity: 0.8; }

  .alert-erro {
    background: #fee2e2;
    border: 1.5px solid #fca5a5;
    color: #991b1b;
    border-radius: 10px;
    padding: 10px 14px;
    font-size: 0.88rem;
    margin-bottom: 1.25rem;
    display: flex;
    align-items: center;
    gap: 8px;
  }
</style>

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