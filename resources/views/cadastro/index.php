<?php
$paginaTitulo = 'Cadastro';
$cssExtra     = 'cadastro.css';
$jsExtra      = 'cadastro.js';
require_once __DIR__ . '/../layout/header.php';
$erro = $_SESSION['erro_cadastro'] ?? null;
unset($_SESSION['erro_cadastro']);
?>

<main class="cad-page">

    <figure class="cad-brand">
        <img src="<?= BASE_URL ?>/public/assets/img/DomusFlow.png"
            alt="DomusFlow" class="cad-brand-img" loading="eager">
    </figure>

    <section class="cad-card">

        <div class="cad-header">
            <h1 class="cad-title">Criar conta</h1>
            <p class="cad-sub">Após o cadastro, aguarde a aprovação do síndico.</p>
        </div>

        <?php if ($erro): ?>
            <div class="df-alert cad-alert-error" role="alert">
                <i class='bx bx-error-circle'></i>
                <?= htmlspecialchars($erro) ?>
            </div>
        <?php endif; ?>

        <form action="<?= BASE_URL ?>/cadastro/salvar" method="POST" class="cad-form" novalidate>

            <p class="cad-section-label">Identificação</p>
            <div class="cad-grid-2">
                <div class="df-field">
                    <label for="user_name">Nome Completo</label>
                    <input type="text" id="user_name" name="user_name"
                        placeholder="João Silva" required>
                </div>
                <div class="df-field">
                    <label for="user_cpf">CPF</label>
                    <input type="text" id="user_cpf" name="user_cpf"
                        placeholder="000.000.000-00" maxlength="14"
                        inputmode="numeric" autocomplete="off" required>
                </div>
            </div>

            <p class="cad-section-label">Unidade</p>
            <div class="cad-grid-2">
                <div class="df-field">
                    <label for="user_apto">Apartamento</label>
                    <input type="text" id="user_apto" name="user_apto"
                        placeholder="23A" maxlength="4" required>
                </div>
                <div class="df-field">
                    <label for="user_bloco">Bloco</label>
                    <input type="text" id="user_bloco" name="user_bloco"
                        placeholder="A" maxlength="3" required>
                </div>
            </div>

            <p class="cad-section-label">Contato</p>
            <div class="cad-grid-2">
                <div class="df-field">
                    <label for="user_email">Email</label>
                    <input type="email" id="user_email" name="user_email"
                        placeholder="joao@email.com" required>
                </div>
                <div class="df-field">
                    <label for="user_cell">Telefone</label>
                    <input type="tel" id="user_cell" name="user_cell"
                        placeholder="(00) 00000-0000" maxlength="15" required>
                </div>
                <div class="df-field">
                    <label for="user_recado">
                        Telefone de Recado
                        <span class="optional">(opcional)</span>
                    </label>
                    <input type="tel" id="user_recado" name="user_recado"
                        placeholder="(00) 00000-0000" maxlength="15">
                </div>
            </div>

            <p class="cad-section-label">Segurança</p>
            <div class="cad-grid-2">
                <div class="df-field cad-field-senha">
                    <label for="user_senha">Senha</label>
                    <div class="cad-input-eye">
                        <input type="password" id="user_senha" name="user_senha"
                            placeholder="••••••••" required>
                        <button type="button" class="cad-eye"
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
                </div>
                <div class="df-field cad-field-senha">
                    <label for="user_confirm_senha">Confirmar Senha</label>
                    <div class="cad-input-eye">
                        <input type="password" id="user_confirm_senha" name="user_confirm_senha"
                            placeholder="••••••••" required>
                        <button type="button" class="cad-eye"
                            aria-label="Mostrar confirmação de senha" aria-pressed="false">
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
                </div>
            </div>

            <div class="cad-actions">
                <a href="<?= BASE_URL ?>/" class="cad-btn-voltar">
                    <i class='bx bx-arrow-back'></i> Voltar ao login
                </a>
                <button type="submit" class="cad-btn-criar">
                    Criar conta <i class='bx bx-right-arrow-alt'></i>
                </button>
            </div>

        </form>
    </section>

</main>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>