<?php
$paginaTitulo = 'Recuperar Senha';
$cssExtra     = 'login.css';
$jsExtra      = 'recuperar-senha.js';
require_once __DIR__ . '/../layout/header.php';
$sucesso = $_SESSION['sucesso_recuperacao'] ?? null;
unset($_SESSION['sucesso_recuperacao']);
$erro = $_SESSION['erro_recuperacao'] ?? null;
unset($_SESSION['erro_recuperacao']);
?>

<main class="lp-page">

    <figure class="lp-brand">
        <img src="<?= BASE_URL ?>/public/assets/img/logo_icon.png"
            alt="DomusFlow" class="lp-brand-img" loading="eager">
    </figure>

    <section class="lp-card">

        <div class="lp-left">
            <p class="lp-label">RECUPERAR SENHA</p>

            <?php if ($sucesso): ?>
                <div class="df-alert df-alert-success" role="alert">
                    <?= htmlspecialchars($sucesso) ?>
                </div>
            <?php else: ?>

                <?php if ($erro): ?>
                    <div class="df-alert lp-alert-error" role="alert">
                        <?= htmlspecialchars($erro) ?>
                    </div>
                <?php endif; ?>

                <p class="lp-recover-desc">
                    Informe seu CPF cadastrado e enviaremos uma nova senha para o seu e-mail.
                </p>

                <form action="<?= BASE_URL ?>/recuperar-senha/enviar" method="POST" class="lp-form" novalidate>
                    <div class="lp-field">
                        <span class="lp-field-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="7" r="4"/>
                                <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                            </svg>
                        </span>
                        <input type="text" id="user_cpf" name="user_cpf"
                            placeholder="CPF" maxlength="14"
                            inputmode="numeric" autocomplete="off"
                            aria-label="CPF" required>
                    </div>

                    <button type="submit" class="lp-btn-entrar">
                        ENVIAR NOVA SENHA
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="22" y1="2" x2="11" y2="13"/>
                            <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                        </svg>
                    </button>
                </form>

            <?php endif; ?>
        </div>

        <div class="lp-divider" role="separator" aria-hidden="true"></div>

        <div class="lp-right lp-right--centered">
            <a href="<?= BASE_URL ?>/" class="lp-btn-primeiro">
                VOLTAR AO LOGIN
            </a>
        </div>

    </section>

</main>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>

