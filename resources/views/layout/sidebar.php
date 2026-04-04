<?php
$paginaAtiva   = $paginaAtiva ?? '';
$prev          = $usuario['previlegio'] ?? 1;
$primeiro_nome = explode(' ', $usuario['nome'])[0];
$avatar        = ($usuario['sexo'] === 'M')
    ? 'https://png.pngtree.com/png-vector/20231019/ourmid/pngtree-user-profile-avatar-png-image_10211467.png'
    : 'https://images.icon-icons.com/3708/PNG/512/girl_female_woman_person_people_avatar_icon_230018.png';
?>
<nav class="sidebar">
    <header class="sidebar-header">
        <div class="brand">
            <div class="brand-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 9.5L12 3l9 6.5V20a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9.5z"/>
                    <path d="M9 21V12h6v9"/>
                </svg>
            </div>
            <span class="brand-name">DomusFlow</span>
        </div>
        <i class='bx bx-menu toggle'></i>
    </header>

    <div class="menu-bar">
        <ul class="menu-links">
            <li class="nav-link <?= $paginaAtiva === 'dashboard' ? 'active' : '' ?>">
                <a href="<?= BASE_URL ?>/dashboard">
                    <i class='bx bxs-dashboard'></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li class="nav-link <?= $paginaAtiva === 'reserva' ? 'active' : '' ?>">
                <a href="<?= BASE_URL ?>/reserva">
                    <i class='bx bx-calendar-check'></i>
                    <span class="nav-text">Reservas</span>
                </a>
            </li>
            <?php if ($prev == 2): ?>
            <li class="nav-link <?= $paginaAtiva === 'moradores' ? 'active' : '' ?>">
                <a href="<?= BASE_URL ?>/moradores/pendentes">
                    <i class='bx bx-user-check'></i>
                    <span class="nav-text">Novos Usuários</span>
                </a>
            </li>
            <?php endif; ?>
        </ul>

        <a href="<?= BASE_URL ?>/logout" class="sidebar-profile">
            <img src="<?= $avatar ?>" alt="avatar">
            <div class="profile-info">
                <span class="profile-name"><?= htmlspecialchars($primeiro_nome) ?></span>
                <span class="profile-sub">Ap <?= htmlspecialchars($usuario['apto']) ?> · Bloco <?= htmlspecialchars($usuario['bloco']) ?></span>
            </div>
            <i class='bx bx-log-out logout-icon'></i>
        </a>
    </div>
</nav>