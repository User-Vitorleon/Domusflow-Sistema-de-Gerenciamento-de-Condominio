<?php
$paginaTitulo = 'Login';
$cssExtra = 'login.css';
require_once __DIR__ . '/../layout/header.php';
$erro = $_SESSION['erro_login'] ?? null;
unset($_SESSION['erro_login']);
?>

<div class="login-wrapper">
    <div class="login-left">
        <div class="login-brand">
            <svg class="login-logo-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 9.5L12 3l9 6.5V20a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9.5z" />
                <path d="M9 21V12h6v9" />
            </svg>
            <span class="login-brand-name">DomusFlow</span>
        </div>

        <div class="login-form-wrap">
            <h1 class="login-title">Bem-vindo</h1>
            <p class="login-sub">Acesse sua conta para continuar</p>

            <?php if ($erro): ?>
                <div class="df-alert df-alert-error"><?= htmlspecialchars($erro) ?></div>
            <?php endif; ?>

            <form action="<?= BASE_URL ?>/login" method="POST" class="login-form">
                <div class="df-field">
                    <label for="user_cpf">CPF</label>
                    <input type="text" id="user_cpf" name="user_cpf"
                        placeholder="000.000.000-00" maxlength="14" required>
                </div>
                <div class="df-field">
                    <label for="user_senha">Senha</label>
                    <input type="password" id="user_senha" name="user_senha"
                        placeholder="••••••••" required>
                </div>
                <button type="submit" class="btn-primary w-100">Entrar</button>
            </form>

            <p class="login-footer-text">
                Primeiro acesso?
                <a href="<?= BASE_URL ?>/cadastro">Cadastre-se</a>
            </p>
        </div>
    </div>

    <div class="login-right">
        <img src="<?= BASE_URL ?>/public/assets/img/DomusFlow.png"
            alt="DomusFlow" class="login-hero-img">

        <div class="login-tagline-wrap">
            <p class="login-tagline-eyebrow">Condomínio inteligente</p>
            <h2 class="login-tagline">
                Gestão simples.<br>
                Condomínio <span class="login-tagline-accent">eficiente.</span>
            </h2>
            <p class="login-tagline-sub">
                Reservas, moradores e espaços — tudo em um só lugar,<br>
                organizado e acessível de qualquer dispositivo.
            </p>
            <div class="login-badges">
                <span class="login-badge"><i class='bx bx-check-circle'></i> Reservas online</span>
                <span class="login-badge"><i class='bx bx-group'></i> Gestão de moradores</span>
                <span class="login-badge"><i class='bx bx-calendar-check'></i> Aprovação rápida</span>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>