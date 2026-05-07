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
    $modulos[] = ['titulo' => 'Reservas',       'sub' => 'Solicite e gerencie reservas de espaços comuns',   'href' => BASE_URL . '/reserva',             'icon' => 'calendar'];
}
if (in_array($prev, [3, 4])) {
    $modulos[] = ['titulo' => 'Consultar Placa', 'sub' => 'Pesquise qualquer veículo pela placa',            'href' => BASE_URL . '/veiculo/consultar',   'icon' => 'search'];
}
if (in_array($prev, [2, 4])) {
    $modulos[] = ['titulo' => 'Novos Usuários', 'sub' => 'Aprove ou recuse solicitações de novos moradores', 'href' => BASE_URL . '/moradores/pendentes', 'icon' => 'user-check'];
}

if (in_array($prev, [1, 2, 4])) {
    $modulos[] = ['titulo' => 'Veículos', 'sub' => 'Cadastre e gerencie seus veículos',                      'href' => BASE_URL . '/veiculo', 'icon' => 'car'];
}

/*if (in_array($prev, [2, 4])) {
    $modulos[] = ['titulo' => 'Financeiro', 'sub' => 'Taxas, multas e geração de faturas',                   'href' => BASE_URL . '/financeiro/taxas', 'icon' => 'financeiro'];
}*/

$modulos[] = ['titulo' => 'Atualizar Dados', 'sub' => 'Edite seu perfil e dados pessoais',                   'href' => BASE_URL . '/cadastro/update', 'icon' => 'user'];
?>

<main class="pn-page">

    <!-- Logo centralizado, sem texto -->
    <div class="pn-brand">
        <img src="<?= BASE_URL ?>/public/assets/img/logo_icon.png"
            alt="DomusFlow" class="pn-brand-icon">
    </div>

    <!-- Cards -->
    <div class="pn-grid">
        <?php if (in_array($prev, [1, 2, 4])): ?>
           <div class="dropdown pn-card" style="cursor:pointer;" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                <div class="pn-card-icon"><?= pn_icon('financeiro') ?></div>
                <div class="pn-card-body">
                    <span class="pn-card-title">Financeiro</span>
                    <span class="pn-card-sub">Confira: Taxas, multas e faturas</span>
                </div>
                <svg class="pn-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6" />
                </svg>
                <ul class="dropdown-menu" onclick="event.stopPropagation()">
                    <?php if (in_array($prev, [2, 4])): ?>
                        <li><a class="dropdown-item" href="<?= BASE_URL ?>/financeiro/taxas" 
                            onclick="window.location='<?= BASE_URL ?>/financeiro/taxas'">Taxas Condominiais</a></li>
                        <li><a class="dropdown-item" href="<?= BASE_URL ?>/financeiro/lancamento"
                            onclick="window.location='<?= BASE_URL ?>/financeiro/lancamento'">Lançamentos</a></li>
                    <?php endif; ?>
                    <li><a class="dropdown-item" href="<?= BASE_URL ?>/financeiro/historico"
                        onclick="window.location='<?= BASE_URL ?>/financeiro/historico'">Meu Histórico</a></li>
                </ul>
            </div>
        <?php endif; ?>
        <?php foreach ($modulos as $m): ?>
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
        ];
    return $i[$k] ?? '';
}
?>
<?php require_once __DIR__ . '/../layout/footer.php'; ?>