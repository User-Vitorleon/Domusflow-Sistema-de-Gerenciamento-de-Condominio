<?php
$paginaTitulo = 'Cadastro';
$cssExtra     = 'cadastro.css';
$jsExtra      = 'cadastro.js';
require_once __DIR__ . '/../layout/header.php';
$erro = $_SESSION['erro_cadastro'] ?? null;
unset($_SESSION['erro_cadastro']);

?>
<?php $d = $_SESSION['dados_cadastro'] ?? []; unset($_SESSION['dados_cadastro']); ?>
<main class="cad-page">

    <figure class="cad-brand">
        <img src="<?= BASE_URL ?>/public/assets/img/DomusFlow.png"
            alt="DomusFlow" class="cad-brand-img" loading="eager">
    </figure>

    <section class="cad-card">

        <div class="cad-header">
            <h1 class="cad-title">Criar conta</h1>
            <p class="cad-sub">Após o cadastro, aguarde a aprovação.</p>
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
                        placeholder="João Silva"  value="<?= htmlspecialchars($d['user_name'] ?? '') ?>" required>
                </div>
                <div class="df-field">
                    <label for="user_cpf">CPF</label>
                    <input type="text" id="user_cpf" name="user_cpf"
                        placeholder="000.000.000-00" maxlength="14"
                        inputmode="numeric" autocomplete="off"  value="<?= htmlspecialchars($d['user_cpf'] ?? '') ?>"
                        required>
                </div>
            </div>

            <p class="cad-section-label">Unidade</p>
            <div class="cad-grid-2">
                <div class="df-field">
                    <label for="user_apto">Apartamento</label>
                    <input type="text" id="user_apto" name="user_apto"
                        placeholder="101" maxlength="4" inputmode="numeric" pattern="\d+"
                        value="<?= htmlspecialchars($d['user_apto'] ?? '') ?>" required>
                </div>
                <div class="df-field">
                    <label for="user_bloco">Bloco</label>
                    <input type="text" id="user_bloco" name="user_bloco"
                        placeholder="A" maxlength="1" pattern="[A-Za-z]"
                        value="<?= htmlspecialchars($d['user_bloco'] ?? '') ?>" required>
                </div>
            </div>
            <p class="cad-unidade-note" id="cadUnidadeNote" hidden>
                Unidade genérica aplicada para perfis administrativos.
            </p>

            <p class="cad-section-label">Perfil</p>
                <div class="df-field">
                    <label for="user_privilegio">Tipo de cadastro</label>
                    <select id="user_privilegio" name="user_privilegio"  value="<?= htmlspecialchars($d['user_privilegio'] ?? '') ?>" required>
                        <option value="1" <?= ($d['user_privilegio'] ?? '1') === '1' ? 'selected' : '' ?>>Morador</option>
                        <option value="3" <?= ($d['user_privilegio'] ?? '') === '3' ? 'selected' : '' ?>>Porteiro</option>
                        <option value="2" <?= ($d['user_privilegio'] ?? '') === '2' ? 'selected' : '' ?>>Síndico</option>
                        <option value="4" <?= ($d['user_privilegio'] ?? '') === '4' ? 'selected' : '' ?>>Administrador</option>
                    </select>
                </div>

            <p class="cad-section-label">Contato</p>
            <div class="cad-grid-2">
                <div class="df-field">
                    <label for="user_email">Email</label>
                    <input type="email" id="user_email" name="user_email"
                        placeholder="joao@email.com"  value="<?= htmlspecialchars($d['user_email'] ?? '') ?>" required>
                </div>
                <div class="df-field">
                    <label for="user_cell">Telefone</label>
                    <input type="tel" id="user_cell" name="user_cell"
                        placeholder="(00) 00000-0000" maxlength="15"  value="<?= htmlspecialchars($d['user_cell'] ?? '') ?>" required>
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

            <div class="df-field cad-termos-field">
                <label class="cad-termos-label">
                    <input type="checkbox" name="termos" id="termos" required
                        class="cad-termos-check">
                    <span>
                        Li e aceito os
                        <a href="#" class="cad-termos-link" data-termos-open>
                            Termos de Uso e Política de Privacidade
                        </a>
                        do DomusFlow.
                    </span>
                </label>
            </div>

            <p class="cad-section-label">Segurança</p>
            <div class="cad-grid-2">
                <div class="df-field cad-field-senha">
                    <label for="user_senha">Senha</label>
                    <div class="cad-input-eye">
                        <input type="password" id="user_senha" name="user_senha"
                            placeholder="••••••••"  value="<?= htmlspecialchars($d['user_senha'] ?? '') ?>" required>
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
                            placeholder="••••••••"  value="<?= htmlspecialchars($d['user_confirm_senha'] ?? '') ?>" required>
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

<div id="modalTermos" class="cad-termos-modal" aria-hidden="true">
    <div class="cad-termos-dialog">
        <button type="button" class="cad-termos-close" data-termos-close>✕</button>

        <h3>Termos de Uso — DomusFlow</h3>

        <div class="cad-termos-content">
            <p><strong>1. Aceitação dos Termos</strong><br>
            Ao se cadastrar no DomusFlow, você concorda com os presentes termos de uso e política de privacidade.</p>

            <p><strong>2. Uso do Sistema</strong><br>
            O sistema é de uso exclusivo dos moradores, funcionários e gestores do condomínio. É proibido o uso indevido das funcionalidades disponíveis.</p>

            <p><strong>3. Dados Pessoais</strong><br>
            Os dados cadastrados serão utilizados exclusivamente para a gestão condominial, em conformidade com a LGPD (Lei Geral de Proteção de Dados).</p>

            <p><strong>4. Responsabilidades</strong><br>
            O usuário é responsável pelas informações fornecidas e pela segurança de seu acesso. Não compartilhe sua senha com terceiros.</p>

            <p><strong>5. Aprovação de Cadastro</strong><br>
            O cadastro está sujeito à aprovação do síndico. O sistema se reserva o direito de recusar acessos que não atendam aos critérios do condomínio.</p>

            <p><strong>6. Alterações</strong><br>
            Estes termos podem ser atualizados a qualquer momento. O uso contínuo do sistema implica na aceitação das alterações.</p>
        </div>

        <div class="cad-termos-actions">
            <button type="button" class="btn-ghost" data-termos-close>Fechar</button>
            <button type="button" class="btn-primary" data-termos-accept>Aceitar e Fechar</button>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>

