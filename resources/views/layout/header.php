<?php
$paginaTitulo = $paginaTitulo ?? 'DomusFlow';
$cssExtra     = $cssExtra     ?? null;
$cssTela      = $cssTela      ?? null;

$semTopo = in_array($paginaTitulo, ['Login', 'Cadastro']);

$primeiro_nome = null;
$apto          = null;
$bloco         = null;

if (isset($usuario) && is_array($usuario)) {
    $primeiro_nome = explode(' ', $usuario['nome'] ?? '')[0] ?? null;
    $apto          = $usuario['apto']  ?? null;
    $bloco         = $usuario['bloco'] ?? null;
}

// ── Sino: conta notificações não lidas ──────────────────────────
$sino_count = 0;
if (!$semTopo && isset($_SESSION['usuario_id'])) {
    require_once __DIR__ . '/../../../app/repositories/AvisosRepository.php';
    $sinoRepo   = new AvisosRepository();
    $desde      = $_SESSION['avisos_visto_em'] ?? '2000-01-01 00:00:00';
    $sino_count = $sinoRepo->contarNovos($desde);
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($paginaTitulo) ?> — DomusFlow</title>
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>/public/assets/img/logo_icon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/app.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/header.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/ocorrencia.css">
    <?php if ($cssExtra): ?>
        <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/<?= $cssExtra ?>">
    <?php endif; ?>
    <?php if ($cssTela): ?>
        <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/<?= $cssTela ?>">
    <?php endif; ?>
</head>

<body>

    <?php if (!$semTopo && $primeiro_nome): ?>
        <header class="df-topbar">
            <div class="df-topbar-inner">

                <a href="<?= BASE_URL ?>/painel" class="df-topbar-home" aria-label="Ir para o Painel">
                    <img src="<?= BASE_URL ?>/public/assets/img/logo_icon.jpg"
                        alt="DomusFlow" class="df-topbar-home-logo"
                        onerror="this.style.display='none';this.nextElementSibling.style.display='block'">
                    <svg style="display:none" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 9.5L12 3l9 6.5V20a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9.5z" />
                        <path d="M9 21V12h6v9" />
                    </svg>
                    <span class="df-topbar-home-label">Painel</span>
                </a>

                <span class="df-topbar-title"><?= htmlspecialchars($paginaTitulo) ?></span>

                <div class="df-topbar-user">

                    <!-- ── Sino de Ocorrências ── -->
                    <a href="<?= BASE_URL ?>/avisos" class="oc-sino" title="Avisos" aria-label="Avisos">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="20" height="20">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                            <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                        </svg>
                        <?php if ($sino_count > 0): ?>
                            <span class="oc-sino-badge"><?= $sino_count > 9 ? '9+' : $sino_count ?></span>
                        <?php endif; ?>
                    </a>

                    <div class="df-topbar-userinfo">

                        <!-- Linha 1: badge + nome -->
                        <div class="df-topbar-name-row">
                            <?php
                            $perfis = [1 => 'Morador(a)', 2 => 'Síndico(a)', 3 => 'Funcionário(a)', 4 => 'Admin'];
                            $prev   = $usuario['privilegio'] ?? 1;
                            $label  = $perfis[$prev] ?? 'Morador';
                            ?>
                            <span class="df-topbar-role df-topbar-role--<?= $prev ?>"><?= $label ?></span>
                            <span class="df-topbar-name"><?= htmlspecialchars($primeiro_nome) ?></span>
                        </div>

                        <!-- Linha 2: bloco + apto -->
                        <?php if ($apto || $bloco): ?>
                            <span class="df-topbar-apto">
                                <?php if ($bloco): ?>Bl. <?= htmlspecialchars($bloco) ?><?php endif; ?>
                                <?php if ($apto): ?>&nbsp;Ap. <?= htmlspecialchars($apto) ?><?php endif; ?>
                            </span>
                        <?php endif; ?>

                    </div>

                    <a href="<?= BASE_URL ?>/logout" class="df-topbar-logout" aria-label="Sair">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                            <polyline points="16 17 21 12 16 7" />
                            <line x1="21" y1="12" x2="9" y2="12" />
                        </svg>
                        <span class="df-topbar-logout-label">Sair</span>
                    </a>
                </div>

            </div>
        </header>
    <?php endif; ?>