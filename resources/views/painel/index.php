<?php
$paginaTitulo = 'Painel';
$paginaAtiva  = 'painel';
$cssExtra     = 'painel.css';
require_once __DIR__ . '/../layout/header.php';

$privilegio = (int) ($usuario['privilegio'] ?? 1);

$catalogoModulos = [
    ['titulo' => 'Dashboard',           'sub' => 'Visão geral e gráficos do condomínio',          'href' => '/dashboard',           'icon' => 'chart',      'privilegios' => [1, 2, 3, 4]],
    ['titulo' => 'Reservas',            'sub' => 'Solicite e gerencie reservas de espaços comuns','href' => '/reserva',             'icon' => 'calendar',   'privilegios' => [1, 2, 4]],
    ['titulo' => 'Consultar Placa',     'sub' => 'Pesquisar veículos pela placa',                 'href' => '/veiculo/consultar',   'icon' => 'search',     'privilegios' => [3, 4]],
    ['titulo' => 'Novos Usuários',      'sub' => 'Controle de novos moradores',                   'href' => '/moradores/pendentes', 'icon' => 'user-check', 'privilegios' => [2, 4]],
    ['titulo' => 'Veículos',            'sub' => 'Cadastre e gerencie seus veículos',             'href' => '/veiculo',             'icon' => 'car',        'privilegios' => [1, 2, 3, 4]],
    ['titulo' => 'Ocorrências',         'sub' => 'Registre e acompanhe ocorrências no condomínio','href' => '/ocorrencia',          'icon' => 'ocorrencia', 'privilegios' => [1, 2, 4]],
    ['titulo' => 'Avisos',              'sub' => 'Acompanhe os últimos avisos registrados',       'href' => '/avisos',              'icon' => 'avisos',     'privilegios' => [1, 2, 4]],
    ['titulo' => 'Assembleia',          'sub' => 'Próximas Assembleias agendadas',                'href' => '/assembleia',          'icon' => 'assembleia', 'privilegios' => [1]],
    ['titulo' => 'Gestão de Moradores', 'sub' => 'Gerencie privilégios dos moradores',            'href' => '/moradores/gestao',    'icon' => 'gestao',     'privilegios' => [4]],
    ['titulo' => 'Parâmetros',          'sub' => 'Configure regras do sistema',                    'href' => '/parametros',          'icon' => 'parametros', 'privilegios' => [4]],
    ['titulo' => 'Atualizar Dados',     'sub' => 'Edite seu perfil e dados pessoais',             'href' => '/cadastro/update',     'icon' => 'user',       'privilegios' => [1, 2, 3, 4]],
];

$modulos = array_values(array_filter($catalogoModulos, static function ($modulo) use ($privilegio) {
    return in_array($privilegio, $modulo['privilegios'], true);
}));

function pn_icon(string $nome): string
{
    static $icones = [
        'calendar'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>',
        'user-check' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><polyline points="16 11 18 13 22 9"/></svg>',
        'car'        => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M5 17H3v-5l2-5h14l2 5v5h-2"/><circle cx="7.5" cy="17.5" r="1.5"/><circle cx="16.5" cy="17.5" r="1.5"/><path d="M5 12h14"/></svg>',
        'user'       => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="7" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>',
        'search'     => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>',
        'chart'      => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/><line x1="2" y1="20" x2="22" y2="20"/></svg>',
        'financeiro' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>',
        'avisos'     => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>',
        'assembleia' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
        'gestao'     => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>',
        'parametros' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06A1.65 1.65 0 0 0 15 19.4a1.65 1.65 0 0 0-1 .6V20a2 2 0 1 1-4 0v-.09a1.65 1.65 0 0 0-1-.6 1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.6 15a1.65 1.65 0 0 0-.6-1H4a2 2 0 1 1 0-4h.09a1.65 1.65 0 0 0 .6-1 1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.6a1.65 1.65 0 0 0 1-.6V4a2 2 0 1 1 4 0v.09a1.65 1.65 0 0 0 1 .6 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9c.14.34.35.65.6 1H20a2 2 0 1 1 0 4h-.09c-.25.35-.46.66-.6 1z"/></svg>',
        'ocorrencia' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>',
    ];
    return $icones[$nome] ?? '';
}
?>

<main class="pn-page">
    <div class="pn-brand">
        <img src="<?= BASE_URL ?>/public/assets/img/logo_icon.png" alt="DomusFlow" class="pn-brand-icon">
    </div>

    <div class="pn-grid">
        <?php if (in_array($privilegio, [2, 4], true)): ?>
            <div class="dropdown pn-card" style="cursor:pointer;">
                <button type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" class="pn-dropdown-trigger"></button>
                <div class="pn-card-icon"><?= pn_icon('financeiro') ?></div>
                <div class="pn-card-body">
                    <span class="pn-card-title">Financeiro</span>
                    <span class="pn-card-sub">Taxas, multas e faturas</span>
                </div>
                <svg class="pn-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6" /></svg>
                <ul class="dropdown-menu" onclick="event.stopPropagation()">
                    <li><a class="dropdown-item" href="<?= BASE_URL ?>/financeiro/taxas">Cadastrar Taxas/Multas</a></li>
                    <li><a class="dropdown-item" href="<?= BASE_URL ?>/financeiro/lancamento">Lançamentos</a></li>
                </ul>
            </div>
        <?php elseif ($privilegio === 1): ?>
            <a href="<?= BASE_URL ?>/financeiro/historico" class="pn-card">
                <div class="pn-card-icon"><?= pn_icon('financeiro') ?></div>
                <div class="pn-card-body">
                    <span class="pn-card-title">Financeiro</span>
                    <span class="pn-card-sub">Suas pendências e faturas</span>
                </div>
                <svg class="pn-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6" /></svg>
            </a>
        <?php endif; ?>

        <?php if (in_array($privilegio, [2, 4], true)): ?>
            <div class="dropdown pn-card" style="cursor:pointer;">
                <button type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" class="pn-dropdown-trigger"></button>
                <div class="pn-card-icon"><?= pn_icon('calendar') ?></div>
                <div class="pn-card-body">
                    <span class="pn-card-title">Reservas</span>
                    <span class="pn-card-sub">Locais e solicitações pendentes</span>
                </div>
                <svg class="pn-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6" /></svg>
                <ul class="dropdown-menu" onclick="event.stopPropagation()">
                    <li><a class="dropdown-item" href="<?= BASE_URL ?>/reserva?visao=locais">Locais</a></li>
                    <li><a class="dropdown-item" href="<?= BASE_URL ?>/reserva?visao=solicitacoes">Solicitações</a></li>
                </ul>
            </div>

            <div class="dropdown pn-card" style="cursor:pointer;">
                <button type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" class="pn-dropdown-trigger"></button>
                <div class="pn-card-icon"><?= pn_icon('ocorrencia') ?></div>
                <div class="pn-card-body">
                    <span class="pn-card-title">Ocorrências</span>
                    <span class="pn-card-sub">Gerencie chamados dos moradores</span>
                </div>
                <svg class="pn-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6" /></svg>
                <ul class="dropdown-menu" onclick="event.stopPropagation()">
                    <li><h6 class="dropdown-header">Minhas Ocorrências</h6></li>
                    <li><a class="dropdown-item" href="<?= BASE_URL ?>/ocorrencia">Abrir / Acompanhar</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><h6 class="dropdown-header">Gestão</h6></li>
                    <li><a class="dropdown-item" href="<?= BASE_URL ?>/ocorrencia/painel">Painel de Gerenciamento</a></li>
                    <li><a class="dropdown-item" href="<?= BASE_URL ?>/ocorrencia/painel?status=A">Abertas</a></li>
                    <li><a class="dropdown-item" href="<?= BASE_URL ?>/ocorrencia/painel?status=E">Em Andamento</a></li>
                    <li><a class="dropdown-item" href="<?= BASE_URL ?>/ocorrencia/painel?status=R">Resolvidas</a></li>
                </ul>
            </div>

            <div class="dropdown pn-card" style="cursor:pointer;">
                <button type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" class="pn-dropdown-trigger"></button>
                <div class="pn-card-icon"><?= pn_icon('assembleia') ?></div>
                <div class="pn-card-body">
                    <span class="pn-card-title">Assembleia</span>
                    <span class="pn-card-sub">Próximas assembleias agendadas</span>
                </div>
                <svg class="pn-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6" /></svg>
                <ul class="dropdown-menu" onclick="event.stopPropagation()">
                    <li><a class="dropdown-item" href="<?= BASE_URL ?>/assembleia">Assembleias</a></li>
                    <li><a class="dropdown-item" href="<?= BASE_URL ?>/assembleia/presencas">Ver Presenças</a></li>
                </ul>
            </div>
        <?php endif; ?>

        <?php foreach ($modulos as $modulo): ?>
            <?php
            if (in_array($modulo['icon'], ['calendar', 'ocorrencia'], true) && in_array($privilegio, [2, 4], true)) {
                continue;
            }
            if ($modulo['icon'] === 'calendar' && $privilegio === 1) { ?>
                <div class="dropdown pn-card" style="cursor:pointer;">
                    <button type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" class="pn-dropdown-trigger"></button>
                    <div class="pn-card-icon"><?= pn_icon('calendar') ?></div>
                    <div class="pn-card-body">
                        <span class="pn-card-title">Reservas</span>
                        <span class="pn-card-sub">Nova reserva e histórico</span>
                    </div>
                    <svg class="pn-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6" /></svg>
                    <ul class="dropdown-menu" onclick="event.stopPropagation()">
                        <li><a class="dropdown-item" href="<?= BASE_URL ?>/reserva">Nova Reserva</a></li>
                        <li><a class="dropdown-item" href="<?= BASE_URL ?>/reserva/historico">Histórico</a></li>
                    </ul>
                </div>
                <?php continue; }
            ?>
            <a href="<?= BASE_URL . $modulo['href'] ?>" class="pn-card">
                <div class="pn-card-icon"><?= pn_icon($modulo['icon']) ?></div>
                <div class="pn-card-body">
                    <span class="pn-card-title"><?= htmlspecialchars($modulo['titulo']) ?></span>
                    <span class="pn-card-sub"><?= htmlspecialchars($modulo['sub']) ?></span>
                </div>
                <svg class="pn-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6" /></svg>
            </a>
        <?php endforeach; ?>
    </div>

    <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">Precisa de Ajuda ?</button>

    <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
        <div class="offcanvas-header">
            <h2 class="offcanvas-title" id="offcanvasWithBothOptionsLabel">Help Flow</h2>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <p>Confira nossas funcionalidades para te auxiliar !</p>
            <hr>
            <div class="pn-help">
                <ul class="pn-help-list">
                    <li><a href="<?= BASE_URL ?>/reserva">Como realizar uma <strong>reserva de espaço</strong>?</a></li>
                    <li><a href="<?= BASE_URL ?>/veiculo">Como <strong>cadastrar ou editar</strong> um veículo?</a></li>
                    <li><a href="<?= BASE_URL ?>/cadastro/update">Como <strong>atualizar</strong> meus dados cadastrais?</a></li>
                    <li><a href="<?= BASE_URL ?>/ocorrencia">Como <strong>abrir ou acompanhar</strong> uma ocorrência?</a></li>
                    <li><a href="<?= BASE_URL ?>/dashboard">Como <strong>acompanhar</strong> uma reserva realizada?</a></li>
                    <li><a href="<?= BASE_URL ?>/avisos">Como visualizar novos <strong>Avisos</strong> realizados?</a></li>
                </ul>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
