<?php
$paginaTitulo = 'Painel de Ocorrências';
$cssExtra     = 'ocorrencia.css';
$jsExtra      = 'ocorrencia.js';
require_once __DIR__ . '/../layout/header.php';

function statusBadgeP(string $s): string
{
    return match ($s) {
        'A' => '<span class="oc-badge oc-badge--aberto">Aberto</span>',
        'E' => '<span class="oc-badge oc-badge--andamento">Em Andamento</span>',
        'R' => '<span class="oc-badge oc-badge--resolvido">Resolvido</span>',
        'C' => '<span class="oc-badge oc-badge--cancelado">Cancelado</span>',
        default => '<span class="oc-badge">—</span>'
    };
}
?>

<main class="main-content">
    <div class="df-page">

        <div class="page-header">
            <h2>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"
                    stroke-linecap="round" stroke-linejoin="round"
                    style="width:22px;height:22px;vertical-align:middle;margin-right:6px">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                    <line x1="12" y1="9" x2="12" y2="13" />
                    <line x1="12" y1="17" x2="12.01" y2="17" />
                </svg>
                Painel de Ocorrências
            </h2>
            <p>Gerencie e responda os chamados dos moradores.</p>
        </div>

        <?php
        $statusMap = [
            'total'     => ['label' => 'Total',       'key' => null, 'mod' => 'total'],
            'aberto'    => ['label' => 'Abertas',      'key' => 'A',  'mod' => 'aberto'],
            'andamento' => ['label' => 'Em Andamento', 'key' => 'E',  'mod' => 'andamento'],
            'resolvido' => ['label' => 'Resolvidas',   'key' => 'R',  'mod' => 'resolvido'],
            'cancelado' => ['label' => 'Canceladas',   'key' => 'C',  'mod' => 'cancelado'],
        ];
        ?>
        <div class="oc-contadores">
            <?php foreach ($statusMap as $chave => $info):
                $ativo = ($status_filtro ?? null) === $info['key'] && $info['key'] !== null;
                $href  = $info['key']
                    ? BASE_URL . '/ocorrencia/painel?status=' . $info['key']
                    : BASE_URL . '/ocorrencia/painel';
            ?>
                <a href="<?= $href ?>"
                    class="oc-contador oc-contador--<?= $info['mod'] ?> <?= $ativo ? 'oc-contador--ativo' : '' ?>"
                    style="text-decoration:none">
                    <span class="oc-contador-num"><?= $contadores[$chave] ?? 0 ?></span>
                    <span class="oc-contador-label"><?= $info['label'] ?></span>
                </a>
            <?php endforeach; ?>
        </div>

        <div class="oc-filtros-card">
            <div class="oc-filtros-header" data-toggle-filtros>
                <div style="display:flex;align-items:center;gap:8px">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" width="15" height="15">
                        <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3" />
                    </svg>
                    <strong>Filtros</strong>
                    <?php
                    $filtros_ativos = array_filter([
                        $_GET['id_ocorrencia'] ?? '',
                        $_GET['morador']       ?? '',
                        $_GET['categoria']     ?? '',
                        $_GET['status']        ?? '',
                        $_GET['titulo']        ?? '',
                        $_GET['data_ini']      ?? '',
                        $_GET['data_fim']      ?? '',
                    ]);
                    if (count($filtros_ativos)): ?>
                        <span class="oc-filtro-badge"><?= count($filtros_ativos) ?> ativo(s)</span>
                    <?php endif; ?>
                </div>
                <svg class="oc-filtros-chevron" id="filtrosChevron"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    width="16" height="16">
                    <polyline points="6 9 12 15 18 9" />
                </svg>
            </div>

            <form method="GET" action="<?= BASE_URL ?>/ocorrencia/painel"
                id="formFiltros" class="oc-filtros-body" style="display:<?= count(array_filter([
                                                                            $_GET['morador']   ?? '',
                                                                            $_GET['categoria'] ?? '',
                                                                            $_GET['status']    ?? '',
                                                                            $_GET['titulo']    ?? '',
                                                                            $_GET['data_ini']  ?? '',
                                                                            $_GET['data_fim']  ?? '',
                                                                        ])) > 0 ? 'block' : 'none' ?>">
                <div class="oc-filtros-grid">
                    <div class="df-field">
                        <label>ID</label>
                        <input type="number"
                            name="id_ocorrencia"
                            min="1"
                            placeholder="Ex.: 15"
                            value="<?= htmlspecialchars($_GET['id_ocorrencia'] ?? '') ?>">
                    </div>

                    <div class="df-field">
                        <label>Morador</label>
                        <input type="text" name="morador" list="listaMoradores"
                            placeholder="Nome do morador..."
                            value="<?= htmlspecialchars($_GET['morador'] ?? '') ?>"
                            autocomplete="off">
                        <datalist id="listaMoradores">
                            <?php foreach ($moradoresFiltro as $m): ?>
                                <option value="<?= htmlspecialchars($m['nome']) ?>">
                                    <?= htmlspecialchars($m['nome']) ?> — Bl.<?= htmlspecialchars($m['bloco']) ?> Ap.<?= htmlspecialchars($m['apto']) ?>
                                </option>
                            <?php endforeach; ?>
                        </datalist>
                    </div>
                    <div class="df-field">
                        <label>Categoria</label>
                        <select name="categoria">
                            <option value="">Todas</option>
                            <?php foreach (['MANUTENÇÃO', 'BARULHO / PERTURBAÇÃO', 'SEGURANÇA', 'LIMPEZA', 'ÁREA COMUM', 'OUTROS'] as $cat): ?>
                                <option value="<?= $cat ?>" <?= (($_GET['categoria'] ?? '') === $cat) ? 'selected' : '' ?>><?= $cat ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="df-field">
                        <label>Status</label>
                        <select name="status">
                            <option value="">Todos</option>
                            <option value="A" <?= (($_GET['status'] ?? '') === 'A') ? 'selected' : '' ?>>Aberto</option>
                            <option value="E" <?= (($_GET['status'] ?? '') === 'E') ? 'selected' : '' ?>>Em Andamento</option>
                            <option value="R" <?= (($_GET['status'] ?? '') === 'R') ? 'selected' : '' ?>>Resolvido</option>
                            <option value="C" <?= (($_GET['status'] ?? '') === 'C') ? 'selected' : '' ?>>Cancelado</option>
                        </select>
                    </div>
                    <div class="df-field">
                        <label>Título</label>
                        <input type="text" name="titulo" placeholder="Buscar no título..."
                            value="<?= htmlspecialchars($_GET['titulo'] ?? '') ?>">
                    </div>
                    <div class="df-field">
                        <label>Data de</label>
                        <input type="date" name="data_ini" value="<?= htmlspecialchars($_GET['data_ini'] ?? '') ?>">
                    </div>
                    <div class="df-field">
                        <label>Data até</label>
                        <input type="date" name="data_fim" value="<?= htmlspecialchars($_GET['data_fim'] ?? '') ?>">
                    </div>
                </div>
                <div class="oc-filtros-actions">
                    <a href="<?= BASE_URL ?>/ocorrencia/painel" class="btn-ghost">Limpar filtros</a>
                    <button type="submit" class="btn-primary">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" width="13" height="13"
                            style="margin-right:5px">
                            <circle cx="11" cy="11" r="7" />
                            <line x1="21" y1="21" x2="16.65" y2="16.65" />
                        </svg>
                        Filtrar
                    </button>
                </div>
            </form>
        </div>

        <div class="df-card" style="padding:0;overflow:hidden">

            <?php if (empty($ocorrencias)): ?>
                <div class="empty-state">
                    <h5>Nenhuma ocorrência encontrada</h5>
                    <p>Tente ajustar os filtros aplicados.</p>
                </div>
            <?php else: ?>

                <div style="padding:10px 16px;border-bottom:1px solid #eee;font-size:12px;color:#888">
                    <?= $total ?> ocorrência(s) encontrada(s)
                </div>

                <div class="oc-table-wrap">
                    <table class="oc-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Morador</th>
                                <th>Categoria</th>
                                <th>Título</th>
                                <th>Status</th>
                                <th>Data</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ocorrencias as $oc): ?>
                                <tr class="oc-table-row">
                                    <td class="oc-td-id">#<?= str_pad($oc['id_ocorrencia'], 4, '0', STR_PAD_LEFT) ?></td>
                                    <td>
                                        <div class="oc-td-morador">
                                            <strong><?= htmlspecialchars($oc['nome_morador']) ?></strong>
                                            <small>Bl.<?= htmlspecialchars($oc['bloco']) ?> Ap.<?= htmlspecialchars($oc['apto']) ?></small>
                                        </div>
                                    </td>
                                    <td><span class="oc-cat-pill oc-cat-pill--sm"><?= htmlspecialchars($oc['categoria']) ?></span></td>
                                    <td class="oc-td-titulo"><?= htmlspecialchars(mb_strimwidth($oc['titulo'], 0, 48, '…')) ?></td>
                                    <td><?= statusBadgeP($oc['status']) ?></td>
                                    <td class="oc-td-data"><?= date('d/m/Y', strtotime($oc['created_at'])) ?></td>
                                    <td data-stop-propagation>
                                        <a href="<?= BASE_URL ?>/ocorrencia/detalhes?id=<?= (int)$oc['id_ocorrencia'] ?>"
                                            class="btn-ghost"
                                            style="padding:4px 10px;font-size:12px;text-decoration:none;display:inline-block">
                                            Ver
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="oc-mobile-cards">
                    <?php foreach ($ocorrencias as $oc): ?>
                        <div class="oc-mobile-card">
                            <div class="oc-mobile-card-header">
                                <span class="oc-td-id">#<?= str_pad($oc['id_ocorrencia'], 4, '0', STR_PAD_LEFT) ?></span>
                                <?= statusBadgeP($oc['status']) ?>
                                <span class="oc-td-data" style="margin-left:auto"><?= date('d/m/Y', strtotime($oc['created_at'])) ?></span>
                            </div>
                            <div class="oc-mobile-card-nome">
                                <strong><?= htmlspecialchars($oc['nome_morador']) ?></strong>
                                <small>Bl.<?= htmlspecialchars($oc['bloco']) ?> · Ap.<?= htmlspecialchars($oc['apto']) ?></small>
                            </div>
                            <div style="margin:4px 0">
                                <span class="oc-cat-pill oc-cat-pill--sm"><?= htmlspecialchars($oc['categoria']) ?></span>
                            </div>
                            <div class="oc-mobile-card-titulo"><?= htmlspecialchars($oc['titulo']) ?></div>
                            <div style="margin-top:8px;text-align:right">
                                <a href="<?= BASE_URL ?>/ocorrencia/detalhes?id=<?= (int)$oc['id_ocorrencia'] ?>"
                                    class="btn-ghost"
                                    style="padding:4px 12px;font-size:12px;text-decoration:none;display:inline-block">
                                    Ver detalhes
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <?php if ($totalPaginas > 1):
                    $range     = 2;
                    $queryBase = http_build_query(array_filter([
                        'id_ocorrencia' => $_GET['id_ocorrencia'] ?? '',
                        'status'        => $_GET['status']        ?? '',
                        'morador'       => $_GET['morador']       ?? '',
                        'categoria'     => $_GET['categoria']     ?? '',
                        'titulo'        => $_GET['titulo']        ?? '',
                        'data_ini'      => $_GET['data_ini']      ?? '',
                        'data_fim'      => $_GET['data_fim']      ?? '',
                    ]));
                    $base = BASE_URL . '/ocorrencia/painel?' . ($queryBase ? $queryBase . '&' : '');
                ?>
                    <nav class="mt-3 d-flex justify-content-center pb-3">
                        <ul class="pagination">
                            <li class="page-item <?= $pagina <= 1 ? 'disabled' : '' ?>">
                                <a class="page-link" href="<?= $pagina > 1 ? $base . 'pagina=' . ($pagina - 1) : '#' ?>">Anterior</a>
                            </li>
                            <?php for ($i = 1; $i <= $totalPaginas; $i++):
                                $mostrar = ($i === 1 || $i === $totalPaginas || abs($i - $pagina) <= $range);
                                if (!$mostrar):
                                    if ($i === 2 || $i === $totalPaginas - 1): ?>
                                        <li class="page-item disabled"><span class="page-link">...</span></li>
                                <?php endif;
                                    continue;
                                endif; ?>
                                <li class="page-item <?= $i === $pagina ? 'active' : '' ?>">
                                    <a class="page-link" href="<?= $base ?>pagina=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                            <li class="page-item <?= $pagina >= $totalPaginas ? 'disabled' : '' ?>">
                                <a class="page-link" href="<?= $pagina < $totalPaginas ? $base . 'pagina=' . ($pagina + 1) : '#' ?>">Próximo</a>
                            </li>
                        </ul>
                    </nav>
                <?php endif; ?>

            <?php endif; ?>
        </div>

    </div>
</main>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
