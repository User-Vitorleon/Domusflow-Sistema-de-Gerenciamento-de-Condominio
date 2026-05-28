<?php
$paginaTitulo = 'Login';
$cssExtra     = 'login.css';
$jsExtra      = 'login.js';
require_once __DIR__ . '/../layout/header.php';
$erro = $_SESSION['erro_login'] ?? null;
unset($_SESSION['erro_login']);
?>

<main class="lp-page">

    <figure class="lp-brand">
        <img src="<?= BASE_URL ?>/public/assets/img/logo_icon.png"
            alt="DomusFlow" class="lp-brand-img" loading="eager">
    </figure>

    <section class="lp-card">

        <div class="lp-left">
            <p class="lp-label">FAZER LOGIN</p>

            <?php if ($erro): ?>
                <div class="df-alert lp-alert-error" role="alert">
                    <?= htmlspecialchars($erro) ?>
                </div>
            <?php endif; ?>

            <form action="<?= BASE_URL ?>/login" method="POST" class="lp-form" novalidate>

                <div class="lp-field">
                    <span class="lp-field-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" focusable="false">
                            <circle cx="12" cy="7" r="4" />
                            <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" />
                        </svg>
                    </span>
                    <input type="text" id="user_cpf" name="user_cpf"
                        placeholder="CPF" maxlength="14"
                        inputmode="numeric" autocomplete="off"
                        aria-label="CPF" required>
                </div>

                <div class="lp-field">
                    <span class="lp-field-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" focusable="false">
                            <rect x="5" y="11" width="14" height="10" rx="2" />
                            <path d="M8 11V7a4 4 0 0 1 8 0v4" />
                        </svg>
                    </span>
                    <input type="password" id="user_senha" name="user_senha"
                        placeholder="Senha" autocomplete="current-password"
                        aria-label="Senha" required>
                    <button type="button" class="lp-eye"
                        aria-label="Mostrar senha" aria-pressed="false">
                        <svg class="icon-show" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" focusable="false">
                            <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                        <svg class="icon-hide" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" focusable="false">
                            <path d="M17.94 17.94A10.94 10.94 0 0 1 12 19C5 19 1 12 1 12a18.1 18.1 0 0 1 5.06-5.94" />
                            <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19" />
                            <line x1="1" y1="1" x2="23" y2="23" />
                        </svg>
                    </button>
                </div>

                <button type="submit" class="lp-btn-entrar">
                    ENTRAR
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" focusable="false">
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                        <polyline points="10 17 15 12 10 7" />
                        <line x1="15" y1="12" x2="3" y2="12" />
                    </svg>
                </button>
                <a href="<?= BASE_URL ?>/recuperar-senha" class="lp-forgot">
                    Esqueci minha senha
                </a>

            </form>
        </div>

        <div class="lp-divider" role="separator" aria-hidden="true"></div>

        <div class="lp-right">
            <a href="<?= BASE_URL ?>/cadastro" class="lp-btn-primeiro">
                PRIMEIRO ACESSO
            </a>
        </div>

    </section>
    

</main>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
