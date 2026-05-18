<?php
$paginaTitulo = 'Meu Perfil';
$paginaAtiva  = 'perfil';
$cssTela      = 'morador.css';
require_once __DIR__ . '/../../layout/header.php';
?>

<div class="main-content">
  <div class="df-page">
    <div class="df-card perfil-card">

      <div class="perfil-topo">
        <img
          src="https://static.vecteezy.com/ti/vetor-gratis/p1/21548095-padrao-perfil-cenario-avatar-do-utilizador-avatar-icone-pessoa-icone-cabeca-icone-perfil-cenario-icones-padrao-anonimo-do-utilizador-masculino-e-female-homem-de-negocios-foto-espaco-reservado-social-rede-avatar-retrato-gratis-vetor.jpg"
          class="perfil-avatar" alt="avatar">
        <div>
          <p class="perfil-nome"><?= htmlspecialchars($usuario['nome']) ?></p>
          <span class="perfil-badge">
            <?php
            $labels = [1 => 'Morador', 2 => 'Síndico', 3 => 'Porteiro', 4 => 'Admin'];
            echo $labels[$usuario['privilegio']] ?? 'Usuário';
            ?>
          </span>
        </div>
      </div>
    </div>

    <?php if (!empty($_SESSION['erro_update'])): ?>
      <div class="df-alert df-alert-error">
        <i class='bx bx-error-circle'></i>
        <?= htmlspecialchars($_SESSION['erro_update']) ?>
      </div>
      <?php unset($_SESSION['erro_update']); ?>
    <?php endif; ?>

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
    <?php if (($usuario['privilegio'] ?? 1) != 4): ?>
      <hr class="divider">
      <div class="danger-zone">
          <h6><i class='bx bx-shield-x me-1'></i>Apagar Conta</h6>
          <div class="danger-btns">
              <form action="<?= BASE_URL ?>/moradores/inativar" method="POST" class="perfil-danger-form"
                  onsubmit="return confirm('Deseja inativar sua conta? Você não conseguirá mais acessar o sistema.')">
                  <button type="submit" class="btn-inativar w-100">
                      <i class='bx bx-pause-circle me-1'></i> Inativar conta
                  </button>
              </form>
              <form action="<?= BASE_URL ?>/moradores/deletar" method="POST" class="perfil-danger-form"
                  onsubmit="return confirm('Atenção! Esta ação é irreversível. Seus dados serão apagados permanentemente.')">
                  <button type="submit" class="btn-deletar w-100">
                      <i class='bx bx-trash me-1'></i> Apagar conta
                  </button>
              </form>
          </div>
      </div>
    <?php endif; ?>

  </div>
</div>

<?php require_once __DIR__ . '/../../layout/footer.php'; ?>