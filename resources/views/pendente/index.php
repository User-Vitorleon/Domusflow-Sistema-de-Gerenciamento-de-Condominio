<?php
$paginaTitulo = 'Aguardando Aprovação';
$cssExtra     = 'pendente.css';
$jsExtra      = 'pendente.js';
require_once __DIR__ . '/../layout/header.php';
$nome = htmlspecialchars($_SESSION['usuario_nome'] ?? 'Morador');
?>

<div class="page-centered">
    <div class="df-card df-card-pendente">

        <!-- Brand -->
        <div class="pendente-brand">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 9.5L12 3l9 6.5V20a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9.5z" />
                <path d="M9 21V12h6v9" />
            </svg>
            <span>DomusFlow</span>
        </div>

        <!-- Ícone animado -->
        <div class="pendente-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10" />
                <polyline points="12 6 12 12 16 14" />
            </svg>
        </div>

        <h2 class="pendente-title">Cadastro em análise</h2>
        <p class="pendente-sub">
            Olá, <strong><?= $nome ?></strong>!<br>
            Seu cadastro foi recebido com sucesso.<br>
            Aguarde a aprovação do síndico para acessar o sistema.
        </p>

        <!-- Alerta Bootstrap estilizado -->
        <div class="alert alert-warning d-flex align-items-start gap-3 text-start mb-4" role="alert">
            <i class='bx bxs-info-circle fs-5 mt-1 flex-shrink-0'></i>
            <div>
                <strong>Aprovação pendente</strong><br>
                <span class="small">
                    O síndico ainda não aprovou seu acesso. Assim que liberado,
                    você será redirecionado automaticamente.
                </span>
            </div>
        </div>

        <!-- Steps -->
        <div class="steps">
            <div class="step done">
                <div class="step-dot">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="3" width="12" height="12">
                        <polyline points="20 6 9 17 4 12" />
                    </svg>
                </div>
                <span>Dados recebidos</span>
            </div>
            <div class="step active" id="stepAprovacao">
                <div class="step-dot">2</div>
                <span>Aguardando aprovação do síndico</span>
            </div>
            <div class="step" id="stepLiberado">
                <div class="step-dot">3</div>
                <span>Acesso liberado</span>
            </div>
        </div>

        <hr class="df-divider">

        <a href="<?= BASE_URL ?>/logout" class="btn-ghost w-100 text-center mt-3">
            ← Voltar ao login
        </a>

    </div>
</div>

<script>
    window.APP_BASE_URL = '<?= BASE_URL ?>';
</script>

<<<<<<< HEAD
<?php require_once __DIR__ . '/../layout/footer.php'; ?>
=======
<?php require_once __DIR__ . '/../layout/footer.php'; ?>
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
