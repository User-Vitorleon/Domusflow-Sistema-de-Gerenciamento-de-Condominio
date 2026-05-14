<?php
$paginaTitulo = 'Painel';
$paginaAtiva  = 'painel';
$cssExtra     = 'painel.css';
require_once __DIR__ . '/../layout/header.php';

$prev          = $usuario['previlegio'] ?? 1;
$primeiro_nome = explode(' ', $usuario['nome'])[0];

$modulos = [];

if (in_array($prev, [1, 2, 3, 4])) {
    $modulos[] = ['titulo' => 'Dashboard',       'sub' => 'Visão geral e gráficos do condomínio',            'href' => BASE_URL . '/dashboard',           'icon' => 'chart'];
}
if (in_array($prev, [1, 2, 4])) {
    $modulos[] = ['titulo' => 'Reservas',         'sub' => 'Solicite e gerencie reservas de espaços comuns',  'href' => BASE_URL . '/reserva',             'icon' => 'calendar'];
}
if (in_array($prev, [3, 4])) {
    $modulos[] = ['titulo' => 'Consultar Placa',  'sub' => 'Pesquisar veículos pela placa',                   'href' => BASE_URL . '/veiculo/consultar',   'icon' => 'search'];
}
if (in_array($prev, [2, 4])) {
    $modulos[] = ['titulo' => 'Novos Usuários',   'sub' => 'Controle de novos moradores',                    'href' => BASE_URL . '/moradores/pendentes', 'icon' => 'user-check'];
}
if (in_array($prev, [1, 2, 4])) {
    $modulos[] = ['titulo' => 'Veículos',          'sub' => 'Cadastre e gerencie seus veículos',               'href' => BASE_URL . '/veiculo',             'icon' => 'car'];
}

// ── Ocorrências ───────────────────────────────────────────────────────────
if (in_array($prev, [1, 2, 4])) {
    $modulos[] = ['titulo' => 'Ocorrências',       'sub' => 'Registre e acompanhe ocorrências no condomínio',  'href' => BASE_URL . '/ocorrencia',          'icon' => 'ocorrencia'];
}
// avisos ok

if (in_array($prev, [1, 2, 4])) {
    $modulos[] = ['titulo' => 'Avisos',       'sub' => 'Acompanhe os últimos avisos registrados',                'href' => BASE_URL . '/avisos',             'icon' => 'avisos'];
}

if (in_array($prev, [1, 2, 4])) {
    $modulos[] = ['titulo' => 'Assembleia',       'sub' => 'Proximas Assembleias agendadas',                    'href' => BASE_URL . '/assembleia',             'icon' => 'assembleia'];
}

if ($prev == 4) {
    $modulos[] = ['titulo' => 'Gestão de Moradores', 'sub' => 'Gerencie privilégios dos moradores',             'href' => BASE_URL . '/moradores/gestao', 'icon' => 'gestao'];
}

$modulos[] = ['titulo' => 'Atualizar Dados',   'sub' => 'Edite seu perfil e dados pessoais',               'href' => BASE_URL . '/cadastro/update',     'icon' => 'user'];
?>



<main class="pn-page">

    <!-- Logo centralizado, sem texto -->
    <div class="pn-brand">
        <img src="<?= BASE_URL ?>/public/assets/img/logo_icon.png"
            alt="DomusFlow" class="pn-brand-icon">
    </div>

    <!-- Cards -->
    <div class="pn-grid">
        <?php if (in_array($prev, [2, 4])): ?>
            <!-- Síndico/Admin — dropdown -->
            <div class="dropdown pn-card" style="cursor:pointer;">
                <button type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside"
                    aria-expanded="false"
                    style="position:absolute;inset:0;width:100%;height:100%;opacity:0;cursor:pointer;border:none;background:none;">
                </button>
                <div class="pn-card-icon"><?= pn_icon('financeiro') ?></div>
                <div class="pn-card-body">
                    <span class="pn-card-title">Financeiro</span>
                    <span class="pn-card-sub">Taxas, multas e faturas</span>
                </div>
                <svg class="pn-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6" />
                </svg>
                <ul class="dropdown-menu" onclick="event.stopPropagation()">
                    <li><a class="dropdown-item" href="<?= BASE_URL ?>/financeiro/taxas"
                        onclick="window.location='<?= BASE_URL ?>/financeiro/taxas'">Cadastrar Taxas</a></li>
                    <li><a class="dropdown-item" href="<?= BASE_URL ?>/financeiro/lancamento"
                        onclick="window.location='<?= BASE_URL ?>/financeiro/lancamento'">Lançamentos</a></li>
                </ul>
            </div>

        <?php elseif ($prev == 1): ?>
            <!-- Morador — vai direto para o histórico -->
            <a href="<?= BASE_URL ?>/financeiro/historico" class="pn-card">
                <div class="pn-card-icon"><?= pn_icon('financeiro') ?></div>
                <div class="pn-card-body">
                    <span class="pn-card-title">Financeiro</span>
                    <span class="pn-card-sub">Suas pendências e faturas</span>
                </div>
                <svg class="pn-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6" />
                </svg>
            </a>
        <?php endif; ?>

        <?php if (in_array($prev, [2, 4])): ?>
            <div class="dropdown pn-card" style="cursor:pointer;">
                <button type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside"
                    aria-expanded="false"
                    style="position:absolute;inset:0;width:100%;height:100%;opacity:0;cursor:pointer;border:none;background:none;">
                </button>
                <div class="pn-card-icon"><?= pn_icon('ocorrencia') ?></div>
                <div class="pn-card-body">
                    <span class="pn-card-title">Ocorrências</span>
                    <span class="pn-card-sub">Gerencie chamados dos moradores</span>
                </div>
                <svg class="pn-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6" />
                </svg>
                <ul class="dropdown-menu" onclick="event.stopPropagation()">
                    <li>
                        <h6 class="dropdown-header">Minhas Ocorrências</h6>
                    </li>
                    <li><a class="dropdown-item" href="<?= BASE_URL ?>/ocorrencia">Abrir / Acompanhar</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <h6 class="dropdown-header">Gestão</h6>
                    </li>
                    <li><a class="dropdown-item" href="<?= BASE_URL ?>/ocorrencia/painel">Painel de Gerenciamento</a></li>
                    <li><a class="dropdown-item" href="<?= BASE_URL ?>/ocorrencia/painel?status=A">Abertas</a></li>
                    <li><a class="dropdown-item" href="<?= BASE_URL ?>/ocorrencia/painel?status=E">Em Andamento</a></li>
                    <li><a class="dropdown-item" href="<?= BASE_URL ?>/ocorrencia/painel?status=R">Resolvidas</a></li>
                </ul>
            </div>
        <?php endif; ?>

        <?php foreach ($modulos as $m):
            // Ocorrências do morador (previlegio 1) vem pelo $modulos;
            // para síndico/admin já aparece como dropdown acima — pula
            if ($m['icon'] === 'ocorrencia' && in_array($prev, [2, 4])) continue;
        ?>
            <a href="<?= $m['href'] ?>" class="pn-card">
                <div class="pn-card-icon"><?= pn_icon($m['icon']) ?></div>
                <div class="pn-card-body">
                    <span class="pn-card-title"><?= htmlspecialchars($m['titulo']) ?></span>
                    <span class="pn-card-sub"><?= htmlspecialchars($m['sub']) ?></span>
                </div>
                <svg class="pn-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6" />
                </svg>
            </a>
        <?php endforeach; ?>

    </div>

    <!-- Ajuda -->
    <div class="pn-help">
        <p class="pn-help-title">Precisa de ajuda?</p>
        <ul class="pn-help-list">
            <li><a href="#">Como realizar uma <strong>reserva de espaço</strong>?</a></li>
            <li><a href="#">Como <strong>cadastrar ou editar</strong> um veículo?</a></li>
            <li><a href="#">Como <strong>atualizar</strong> meus dados cadastrais?</a></li>
            <li><a href="#">Dúvidas sobre <strong>aprovação de moradores</strong>.</a></li>
            <li><a href="#">Como <strong>abrir ou acompanhar</strong> uma ocorrência?</a></li>
            <li><a href="#">Relatos de <strong>erros no sistema</strong>.</a></li>
        </ul>
    </div>

</main>

<?php
function pn_icon(string $k): string
{
    $i = [
        'calendar'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>',
        'user-check' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><polyline points="16 11 18 13 22 9"/></svg>',
        'car'        => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M5 17H3v-5l2-5h14l2 5v5h-2"/><circle cx="7.5" cy="17.5" r="1.5"/><circle cx="16.5" cy="17.5" r="1.5"/><path d="M5 12h14"/></svg>',
        'user'       => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="7" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>',
        'search'     => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>',
        'chart'      => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/><line x1="2" y1="20" x2="22" y2="20"/></svg>',
        'financeiro' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>',
        'avisos'     => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>',
        'assembleia' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
        'gestao' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>',
        'ocorrencia' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>',
    ];
    return $i[$k] ?? '';
}
?>
<?php require_once __DIR__ . '/../layout/footer.php'; ?>