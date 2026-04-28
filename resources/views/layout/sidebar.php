<?php
$paginaAtiva   = $paginaAtiva ?? '';
$prev          = $usuario['previlegio'] ?? 1;
$primeiro_nome = explode(' ', $usuario['nome'])[0];
$avatar        = 'https://static.vecteezy.com/ti/vetor-gratis/p1/21548095-padrao-perfil-cenario-avatar-do-utilizador-avatar-icone-pessoa-icone-cabeca-icone-perfil-cenario-icones-padrao-anonimo-do-utilizador-masculino-e-femea-homem-de-negocios-foto-espaco-reservado-social-rede-avatar-retrato-gratis-vetor.jpg';
?>
<nav class="sidebar">
    <header class="sidebar-header">
        <div class="brand">
            <div class="brand-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 9.5L12 3l9 6.5V20a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9.5z" />
                    <path d="M9 21V12h6v9" />
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
            <?php if (in_array($prev, [1, 2, 4])): ?>
                <li class="nav-link <?= $paginaAtiva === 'reserva' ? 'active' : '' ?>">
                    <a href="<?= BASE_URL ?>/reserva">
                        <i class='bx bx-calendar-check'></i>
                        <span class="nav-text">Reservas</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if (in_array($prev, [2, 4])): ?>
                <li class="nav-link <?= $paginaAtiva === 'moradores' ? 'active' : '' ?>">
                    <a href="<?= BASE_URL ?>/moradores/pendentes">
                        <i class='bx bx-user-check'></i>
                        <span class="nav-text">Novos Usuários</span>
                    </a>
                </li>
            <?php endif; ?>

            <li class="nav-link <?= $paginaAtiva === 'veiculo' ? 'active' : '' ?>">
                <a href="<?= BASE_URL ?>/veiculo">
                    <i class='bx bx-car'></i>
                    <span class="nav-text">Veículos</span>
                </a>
            </li>
            <li class="nav-link <?= $paginaAtiva === 'perfil' ? 'active' : '' ?>">
                <a href="<?= BASE_URL ?>/cadastro/update">
                    <i class='bx bx-user-circle'></i>
                    <span class="nav-text">Atualizar Dados</span>
                </a>
            </li>
            <?php if (in_array($prev, [3, 4])): ?>
                <li class="nav-link <?= $paginaAtiva === 'consulta-veiculo' ? 'active' : '' ?>">
                    <a href="<?= BASE_URL ?>/veiculo/consultar">
                        <i class='bx bx-search-alt'></i>
                        <span class="nav-text">Consultar Placa</span>
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