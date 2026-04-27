<?php
$paginaTitulo = 'Cadastro';
$cssExtra     = 'cadastro.css';
require_once __DIR__ . '/../layout/header.php';
$erro = $_SESSION['erro_cadastro'] ?? null;
unset($_SESSION['erro_cadastro']);
?>

<div class="cadastro-wrapper">
    <div class="cadastro-left">
        <div class="cadastro-brand">
            <svg class="cadastro-logo-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 9.5L12 3l9 6.5V20a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9.5z" />
                <path d="M9 21V12h6v9" />
            </svg>
            <span class="cadastro-brand-name">DomusFlow</span>
        </div>

        <div class="cadastro-info">
            <h2 class="cadastro-info-title">Bem-vindo ao<br>seu condomínio</h2>
            <p class="cadastro-info-sub">
                Crie sua conta em menos de 2 minutos e aguarde<br>
                a aprovação do síndico para acessar o sistema.
            </p>
            <ul class="cadastro-steps">
                <li class="cadastro-step">
                    <span class="step-num">1</span>
                    <div>
                        <strong>Preencha seus dados</strong>
                        <span>Nome, CPF, apartamento e contato</span>
                    </div>
                </li>
                <li class="cadastro-step">
                    <span class="step-num">2</span>
                    <div>
                        <strong>Aguarde a aprovação</strong>
                        <span>O síndico receberá sua solicitação</span>
                    </div>
                </li>
                <li class="cadastro-step">
                    <span class="step-num">3</span>
                    <div>
                        <strong>Acesse o sistema</strong>
                        <span>Faça reservas e gerencie sua conta</span>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="cadastro-right">
        <div class="cadastro-form-wrap">
            <div class="cadastro-form-header">
                <h4>Criar conta</h4>
                <p>Após o cadastro, aguarde a aprovação do síndico.</p>
            </div>
            <?php if ($erro): ?>
                <div class="df-alert df-alert-error">
                    <i class='bx bx-error-circle'></i>
                    <?= htmlspecialchars($erro) ?>
                </div>
            <?php endif; ?>

            <form action="<?= BASE_URL ?>/cadastro/salvar" method="POST">
                <p class="form-section-label">Identificação</p>
                <div class="df-grid-2">
                    <div class="df-field">
                        <label>Nome Completo</label>
                        <input type="text" name="user_name"
                            placeholder="João Silva" required>
                    </div>
                    <div class="df-field">
                        <label>CPF</label>
                        <input type="text" name="user_cpf" id="user_cpf"
                            placeholder="000.000.000-00" maxlength="14" required>
                    </div>
                </div>               
                <p class="form-section-label">Unidade</p>
                <div class="df-grid-3">
                    <div class="df-field">
                        <label>Apartamento</label>
                        <input type="text" name="user_apto"
                            placeholder="23A" maxlength="4" required>
                    </div>
                    <div class="df-field">
                        <label>Bloco</label>
                        <input type="text" name="user_bloco"
                            placeholder="A" maxlength="3" required>
                    </div>
                    <div class="df-field">
                        <label>Sexo</label>
                        <select name="user_sexo" required>
                            <option value="" disabled selected>Selecione</option>
                            <option value="M">Masculino</option>
                            <option value="F">Feminino</option>
                        </select>
                    </div>
                </div>
                <p class="form-section-label">Contato</p>
                <div class="df-grid-2">
                    <div class="df-field">
                        <label>Email</label>
                        <input type="email" name="user_email"
                            placeholder="joao@email.com" required>
                    </div>
                    <div class="df-field">
                        <label>Telefone</label>
                        <input type="tel" name="user_cell"
                            placeholder="(00) 00000-0000" maxlength="15" required>
                    </div>
                </div>
                <div class="df-grid-2">
                    <div class="df-field">
                        <label>Telefone de Recado
                            <span class="optional">(opcional)</span>
                        </label>
                        <input type="tel" name="user_recado"
                            placeholder="(00) 00000-0000" maxlength="15">
                    </div>
                </div>
                <p class="form-section-label">Segurança</p>
                <div class="df-grid-2">
                    <div class="df-field">
                        <label>Senha</label>
                        <input type="password" name="user_senha"
                            placeholder="••••••••" required>
                    </div>
                    <div class="df-field">
                        <label>Confirmar Senha</label>
                        <input type="password" name="user_confirm_senha"
                            placeholder="••••••••" required>
                    </div>
                </div>
                <div class="df-actions">
                    <a href="<?= BASE_URL ?>/" class="btn-ghost">
                        <i class='bx bx-arrow-back'></i> Voltar ao login
                    </a>
                    <button type="submit" class="btn-primary">
                        Criar conta <i class='bx bx-right-arrow-alt'></i>
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>