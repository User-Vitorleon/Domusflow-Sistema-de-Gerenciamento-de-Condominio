<?php
$paginaTitulo = $paginaTitulo ?? 'DomusFlow';
$cssExtra     = $cssExtra     ?? null;
$cssTela      = $cssTela      ?? null;

$telasSemTopo = ['Login', 'Cadastro'];
$semTopo      = in_array($paginaTitulo, $telasSemTopo, true);

$primeiroNome = null;
$apartamento  = null;
$bloco        = null;

if (isset($usuario) && is_array($usuario)) {
    $primeiroNome = explode(' ', $usuario['nome'] ?? '')[0] ?? null;
    $apartamento  = $usuario['apto']  ?? null;
    $bloco        = $usuario['bloco'] ?? null;
}

$sinoCount = 0;
if (!$semTopo && isset($_SESSION['usuario_id'])) {
    require_once __DIR__ . '/../../../app/repositories/AvisosRepository.php';
    $sinoRepo  = new AvisosRepository();
    $desde     = $_SESSION['avisos_visto_em'] ?? '2000-01-01 00:00:00';
    $sinoCount = $sinoRepo->contarNovos($desde);
}

$rotulosPerfil = [
    1 => 'Morador(a)',
    2 => 'Síndico(a)',
    3 => 'Funcionário(a)',
    4 => 'Admin',
];
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

    <?php if (!$semTopo && $primeiroNome): ?>
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

                    <a href="<?= BASE_URL ?>/avisos" class="oc-sino" title="Avisos" aria-label="Avisos">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="20" height="20">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                            <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                        </svg>
                        <?php if ($sinoCount > 0): ?>
                            <span class="oc-sino-badge"><?= $sinoCount > 9 ? '9+' : $sinoCount ?></span>
                        <?php endif; ?>
                    </a>

                    <div class="df-topbar-userinfo">

                        <div class="df-topbar-name-row">
                            <?php
                                $privilegio = (int) ($usuario['privilegio'] ?? 1);
                                $rotulo     = $rotulosPerfil[$privilegio] ?? 'Morador';
                            ?>
                            <span class="df-topbar-role df-topbar-role--<?= $privilegio ?>"><?= $rotulo ?></span>
                            <span class="df-topbar-name"><?= htmlspecialchars($primeiroNome) ?></span>
                        </div>

                        <?php if ($apartamento || $bloco): ?>
                            <span class="df-topbar-apto">
                                <?php if ($bloco): ?>Bl. <?= htmlspecialchars($bloco) ?><?php endif; ?>
                                <?php if ($apartamento): ?>&nbsp;Ap. <?= htmlspecialchars($apartamento) ?><?php endif; ?>
                            </span>
                        <?php endif; ?>

                    </div>

                                    <button id="toggleTema" class="df-topbar-tema" aria-label="Alternar tema" title="Alternar tema">
                    <svg id="iconeLua" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
                        <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
                    </svg>
                    <svg id="iconeSol" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18" style="display:none">
                        <circle cx="12" cy="12" r="5"/>
                        <line x1="12" y1="1" x2="12" y2="3"/>
                        <line x1="12" y1="21" x2="12" y2="23"/>
                        <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/>
                        <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
                        <line x1="1" y1="12" x2="3" y2="12"/>
                        <line x1="21" y1="12" x2="23" y2="12"/>
                        <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/>
                        <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
                    </svg>
                </button>

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

                <script>
    const t = localStorage.getItem('domusflow-tema');
    if (t) document.documentElement.setAttribute('data-theme', t);
</script>

            </div>
        </header>
    <?php endif; ?>
