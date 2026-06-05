<?php
$paginaTitulo = 'Meu Perfil';
$paginaAtiva  = 'perfil';
$cssTela      = 'morador.css';
require_once __DIR__ . '/../../layout/header.php';

$labels = [1 => 'Morador', 2 => 'Síndico', 3 => 'Porteiro', 4 => 'Admin'];
$perfil = $labels[$usuario['privilegio']] ?? 'Usuário';
?>

<main class="main-content">
  <div class="df-page perfil-page">
    <div class="page-header perfil-page-header">
      <h2>Meu Perfil</h2>
      <p class="text-muted">Atualize seus dados pessoais e senha de acesso</p>
    </div>

    <?php if (!empty($_SESSION['erro_update'])): ?>
      <div class="df-alert df-alert-error">
        <i class='bx bx-error-circle'></i>
        <?= htmlspecialchars($_SESSION['erro_update']) ?>
      </div>
      <?php unset($_SESSION['erro_update']); ?>
    <?php endif; ?>

    <div class="perfil-layout">
      <aside class="df-card perfil-resumo">
        <div class="perfil-avatar-wrap">
          <img
            src="https://static.vecteezy.com/ti/vetor-gratis/p1/21548095-padrao-perfil-cenario-avatar-do-utilizador-avatar-icone-pessoa-icone-cabeca-icone-perfil-cenario-icones-padrao-anonimo-do-utilizador-masculino-e-female-homem-de-negocios-foto-espaco-reservado-social-rede-avatar-retrato-gratis-vetor.jpg"
            class="perfil-avatar" alt="avatar">
        </div>
        <div class="perfil-resumo-info">
          <p class="perfil-nome"><?= htmlspecialchars($usuario['nome']) ?></p>
          <span class="perfil-badge"><?= htmlspecialchars($perfil) ?></span>
          <div class="perfil-unidade">
            <span>Ap <?= htmlspecialchars($usuario['apto']) ?></span>
            <span>Bl <?= htmlspecialchars($usuario['bloco']) ?></span>
          </div>
        </div>
      </aside>

      <section class="df-card perfil-form-card">
        <form action="<?= BASE_URL ?>/cadastro/update/salvar" method="POST" class="perfil-form">
          <div class="perfil-section-head">
            <h3>Informações pessoais</h3>
          </div>

          <div class="perfil-form-grid">
            <div class="perfil-field">
              <label for="user_nome">Nome completo</label>
              <input type="text" id="user_nome" name="user_nome" value="<?= htmlspecialchars($usuario['nome']) ?>" required>
            </div>

            <div class="perfil-field">
              <label for="user_email">E-mail</label>
              <input type="email" id="user_email" name="user_email" value="<?= htmlspecialchars($usuario['email']) ?>" required>
            </div>

            <div class="perfil-field">
              <label for="user_telefone">Telefone</label>
              <input type="text" id="user_telefone" name="user_telefone" value="<?= htmlspecialchars($usuario['telefone']) ?>" required>
            </div>

            <div class="perfil-field">
              <label for="user_tell_recado">Telefone recado</label>
              <input type="text" id="user_tell_recado" name="user_tell_recado" value="<?= htmlspecialchars($usuario['tell_recado'] ?? '') ?>">
            </div>

            <div class="perfil-field perfil-field-readonly">
              <label for="user_apto">Apartamento</label>
              <input type="text" id="user_apto" value="<?= htmlspecialchars($usuario['apto']) ?>" readonly aria-readonly="true">
            </div>

            <div class="perfil-field perfil-field-readonly">
              <label for="user_bloco">Bloco</label>
              <input type="text" id="user_bloco" value="<?= htmlspecialchars($usuario['bloco']) ?>" readonly aria-readonly="true">
            </div>
          </div>

          <div class="perfil-info-note">
            <i class='bx bx-info-circle'></i>
            <span>Alterações de apartamento e bloco devem ser feitas pela administração do condomínio para evitar duplicidade e inconsistências em multas, reservas e ocorrências.</span>
          </div>

          <div class="perfil-section-head perfil-section-password">
            <h3>Alterar senha</h3>
          </div>

          <div class="perfil-form-grid">
            <div class="perfil-field">
              <label for="user_senha">Nova senha</label>
              <input type="password" id="user_senha" name="user_senha" placeholder="Deixe vazio para manter">
            </div>

            <div class="perfil-field">
              <label for="user_conf_senha">Confirmar nova senha</label>
              <input type="password" id="user_conf_senha" name="user_conf_senha" placeholder="Repita a nova senha">
            </div>
          </div>

          <button type="submit" class="btn-primary perfil-save-btn">
            <i class='bx bx-save'></i> Salvar alterações
          </button>
        </form>
      </section>
    </div>

    <?php if (($usuario['privilegio'] ?? 1) != 4): ?>
      <section class="df-card danger-zone">
        <div>
          <h3><i class='bx bx-shield-x'></i> Área de risco</h3>
          <p>Use estas ações apenas se desejar suspender ou apagar logicamente sua conta.</p>
        </div>
        <div class="danger-btns">
          <form action="<?= BASE_URL ?>/moradores/inativar" method="POST" class="perfil-danger-form"
              onsubmit="return confirm('Deseja inativar sua conta? Você não conseguirá mais acessar o sistema.')">
              <button type="submit" class="btn-inativar">
                  <i class='bx bx-pause-circle'></i> Inativar conta
              </button>
          </form>
          <form action="<?= BASE_URL ?>/moradores/deletar" method="POST" class="perfil-danger-form"
              onsubmit="return confirm('Atenção! Esta ação é irreversível. Seus dados pessoais serão anonimizados.')">
              <button type="submit" class="btn-deletar">
                  <i class='bx bx-trash'></i> Apagar conta
              </button>
          </form>
        </div>
      </section>
    <?php endif; ?>
  </div>
</main>

<?php require_once __DIR__ . '/../../layout/footer.php'; ?>
