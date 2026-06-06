<?php
$paginaTitulo = 'Lançamentos';
$paginaAtiva  = 'financeiro';
$cssTela      = 'financas.css';
$jsExtra      = 'financas-lancamento.js';
require_once __DIR__ . '/../../layout/header.php';
$privilegio = $usuario['privilegio'] ?? 1;
$queryLancamentos = http_build_query(array_filter([
    'nome'      => $_GET['nome'] ?? ($_GET['busca'] ?? ''),
    'tipo'      => $_GET['tipo'] ?? '',
    'descricao' => $_GET['descricao'] ?? '',
    'status'    => $_GET['status'] ?? '',
    'dt_lanc'   => $_GET['dt_lanc'] ?? '',
    'dt_venc'   => $_GET['dt_venc'] ?? '',
], static fn($valor) => $valor !== ''));
$baseLancamentos = BASE_URL . '/financeiro/lancamento?' . ($queryLancamentos ? $queryLancamentos . '&' : '');
?>

<main class="main-content">
<div class="fin-page" data-fin-lancamento-page
    data-taxas="<?= htmlspecialchars(json_encode($todasTaxas), ENT_QUOTES, 'UTF-8') ?>"
    data-verificar-url="<?= in_array($privilegio, [2, 4]) ? BASE_URL . '/financeiro/lancamento/verificar' : '' ?>">

    <div class="page-header">
        <h2>Lançamentos Financeiros</h2>
        <p class="text-muted">Gerencie taxas e multas dos moradores</p>
    </div>

    <?php if (isset($_SESSION['erro_lancamento'])): ?>
        <div class="df-alert df-alert-error"><?= htmlspecialchars($_SESSION['erro_lancamento']) ?><?php unset($_SESSION['erro_lancamento']); ?></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['erro_fatura'])): ?>
        <div class="df-alert df-alert-error"><?= htmlspecialchars($_SESSION['erro_fatura']) ?><?php unset($_SESSION['erro_fatura']); ?></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['sucesso_fatura'])): ?>
        <div class="df-alert df-alert-success"><?= htmlspecialchars($_SESSION['sucesso_fatura']) ?><?php unset($_SESSION['sucesso_fatura']); ?></div>
    <?php endif; ?>
    <?php if (isset($_GET['excluido'])): ?>
        <div class="df-alert df-alert-success">Lançamento excluído com sucesso!</div>
    <?php endif; ?>
    <?php if (isset($_SESSION['sucesso_lancamento'])): ?>
        <div class="df-alert df-alert-success">
            <?= htmlspecialchars($_SESSION['sucesso_lancamento']) ?>
            <?php unset($_SESSION['sucesso_lancamento']); ?>
        </div>
    <?php endif; ?>

    <?php if (in_array($privilegio, [2, 4])): ?>

    <div class="df-card fin-card-spaced">
        <h3 class="section-title">Registrar Lançamento</h3>
        <form action="<?= BASE_URL ?>/financeiro/lancamento/salvar" method="POST">

            <div class="df-grid-2">
                <div class="df-field">
                    <label>Tipo de Cobrança</label>
                    <select name="modelo" id="tipo" required>
                        <option value="">Selecione...</option>
                        <option value="taxa">Taxa</option>
                        <option value="multa">Multa</option>
                    </select>
                </div>
                <div class="df-field">
                    <label>Descrição</label>
                    <select name="descricao" id="descricao" required>
                        <option value="">Selecione o tipo primeiro...</option>
                    </select>
                </div>
            </div>

            <div class="df-grid-2">
                <div class="df-field">
                    <label>Valor (R$)</label>
                    <input type="number" name="valor" id="valor" step="0.01" min="0" placeholder="0,00" readonly required>
                </div>
                <div class="df-field" id="campo_morador">
                    <label>Morador</label>
                    <select name="id_user" required>
                        <option value="">Selecione...</option>
                        <?php foreach ($moradores as $m): ?>
                            <option value="<?= $m['id_user'] ?>">
                                <?= htmlspecialchars($m['nome']) ?> — Ap <?= $m['apto'] ?> · Bloco <?= $m['bloco'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="df-grid-2">
                <div class="df-field">
                    <label>Data de Vencimento</label>
                    <input type="date" name="data_venc" id="data_venc" required>
                </div>
                <input type="hidden" name="data_lanc" value="<?= date('Y-m-d') ?>">
            </div>

            <div class="fin-bulk-option">
                <label>
                    <input type="checkbox" name="todos_moradores" id="todos_moradores" value="1">
                    <span>
                        <i class='bx bx-group'></i>
                        Lançar para <strong>todos os moradores ativos</strong>
                    </span>
                </label>
            </div>

            <div class="df-actions">
                <button type="reset" class="btn-ghost">Limpar</button>
                <button type="submit" class="btn-primary">Registrar</button>
            </div>
        </form>
    </div>
    <?php endif; ?>

    <div class="df-card">
        <div class="fin-section-header">
            <h3 class="section-title">Todos os Lançamentos</h3>
        </div>

        <form method="GET" action="<?= BASE_URL ?>/financeiro/lancamento" class="fin-filter-form">
            <div class="df-field">
                <label>Nome</label>
                <input type="text" id="pesquisa" name="nome" value="<?= htmlspecialchars($_GET['nome'] ?? ($_GET['busca'] ?? '')) ?>"
                       placeholder="Nome do morador...">
            </div>
            <div class="df-field">
                <label>Tipo</label>
                <select name="tipo">
                    <option value="">Todos</option>
                    <?php foreach (($tiposTaxas ?? []) as $tipoTaxa): ?>
                        <option value="<?= htmlspecialchars($tipoTaxa) ?>" <?= ($_GET['tipo'] ?? '') === $tipoTaxa ? 'selected' : '' ?>>
                            <?= ucfirst(strtolower($tipoTaxa)) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="df-field">
                <label>Descrição</label>
                <select name="descricao">
                    <option value="">Todas</option>
                    <?php foreach (($descricoesTaxas ?? []) as $descTaxa): ?>
                        <option value="<?= htmlspecialchars($descTaxa) ?>" <?= ($_GET['descricao'] ?? '') === $descTaxa ? 'selected' : '' ?>>
                            <?= htmlspecialchars($descTaxa) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="df-field">
                <label>Status</label>
                <select id="filtroStatus" name="status">
                    <option value="">Todos</option>
                    <option value="P" <?= ($_GET['status'] ?? '') === 'P' ? 'selected' : '' ?>>Pendente</option>
                    <option value="F" <?= ($_GET['status'] ?? '') === 'F' ? 'selected' : '' ?>>Fatura Gerada</option>
                    <option value="G" <?= ($_GET['status'] ?? '') === 'G' ? 'selected' : '' ?>>Pago</option>
                    <option value="atraso" <?= ($_GET['status'] ?? '') === 'atraso' ? 'selected' : '' ?>>Em Atraso</option>
                </select>
            </div>
            <div class="df-field">
                <label>Dt. Lançamento</label>
                <input type="date" id="filtroDtLanc" name="dt_lanc" value="<?= htmlspecialchars($_GET['dt_lanc'] ?? '') ?>">
            </div>
            <div class="df-field">
                <label>Dt. Vencimento</label>
                <input type="date" id="filtroDtVenc" name="dt_venc" value="<?= htmlspecialchars($_GET['dt_venc'] ?? '') ?>">
            </div>
            <div class="df-field">
                <label>&nbsp;</label>
                <button type="submit" class="btn-primary">Filtrar</button>
            </div>
            <div class="df-field">
                <label>&nbsp;</label>
                <a class="btn-ghost" href="<?= BASE_URL ?>/financeiro/lancamento">Limpar filtros</a>
            </div>
        </form>

        <?php if (empty($lancamentos)): ?>
            <div class="empty-state">
                <i class='bx bx-receipt'></i>
                <h5>Nenhum lançamento encontrado</h5>
                <p>Os lançamentos aparecerão aqui.</p>
            </div>
        <?php else: ?>
            <div class="fin-lanc-table-wrap">
                <table class="df-table fin-lanc-table">
                    <thead>
                        <tr>
                            <th class="nowrap">#</th>
                            <?php if (in_array($privilegio, [2, 4])): ?>
                            <th>Nome</th>
                            <th>Bloco</th>
                            <th>Apto</th>
                            <?php endif; ?>
                            <th>Tipo</th>
                            <th>Descrição</th>
                            <th class="text-right">Valor</th>
                            <th class="nowrap">Dt. Lançamento</th>
                            <th class="nowrap">Vencimento</th>
                            <th>Status</th>
                            <?php if (in_array($privilegio, [2, 4])): ?>
                            <th class="text-center">Ação</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody id="tabelaLancamentos">
                        <?php foreach ($lancamentos as $l):
                            $corStatus = match($l['status']) {
                                'P' => ['#CA8A04', '#FFFBEB', '#FDE68A'],
                                'F' => ['#16A34A', '#F0FDF4', '#BBF7D0'],
                                'G' => ['#2563EB', '#EFF6FF', '#BFDBFE'],
                                default => ['#6B7280', '#F9FAFB', '#E5E7EB']
                            };
                            $textoStatus = match($l['status']) {
                                'P' => 'Pendente',
                                'F' => 'Fatura Gerada',
                                'G' => 'Pago',
                                default => $l['status']
                            };
                            $vencido = strtotime($l['data_vencimento']) < strtotime('today') && $l['status'] === 'P';
                            $corModelo = strtoupper($l['modelo']) === 'TAXA' ? '#2563EB' : '#DC2626';
                            $dtLanc = $l['data_lancamento'] ?? null;
                        ?>
                            <tr
                                data-nome="<?= strtolower($l['nome_morador'] ?? '') ?>"
                                data-tipo="<?= strtolower($l['modelo']) ?>"
                                data-desc="<?= strtolower($l['descricao']) ?>"
                                data-status="<?= $l['status'] ?>"
                                data-vencido="<?= $vencido ? '1' : '0' ?>"
                                data-dt-lanc="<?= $dtLanc ?? '' ?>"
                                data-dt-venc="<?= $l['data_vencimento'] ?>">
                                <td class="muted">#<?= $l['id_lancamento'] ?></td>
                                <?php if (in_array($privilegio, [2, 4])): ?>
                                <td class="medium"><?= htmlspecialchars($l['nome_morador'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($l['bloco'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($l['apto'] ?? '-') ?></td>
                                <?php endif; ?>
                                <td>
                                    <span style="color: <?= $corModelo ?>; font-weight: 600; font-size: 12px;">
                                        <?= ucfirst(strtolower($l['modelo'])) ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($l['descricao']) ?></td>
                                <td class="text-right semibold">
                                    R$ <?= number_format($l['valor'], 2, ',', '.') ?>
                                </td>
                                <td class="nowrap muted">
                                    <?= $dtLanc ? date('d/m/Y', strtotime($dtLanc)) : '-' ?>
                                </td>
                                <td class="nowrap">
                                    <span style="color: <?= $vencido ? '#EF4444' : 'inherit' ?>; font-weight: <?= $vencido ? '600' : '400' ?>;">
                                        <?= date('d/m/Y', strtotime($l['data_vencimento'])) ?>
                                        <?= $vencido ? ' ⚠' : '' ?>
                                    </span>
                                </td>
                                <td>
                                    <span style="
                                        padding: 3px 8px; border-radius: 20px; font-size: 11px; font-weight: 600;
                                        color: <?= $corStatus[0] ?>;
                                        background: <?= $corStatus[1] ?>;
                                        border: 1px solid <?= $corStatus[2] ?>;
                                        white-space: nowrap;">
                                        <?= $textoStatus ?>
                                    </span>
                                </td>
                                <?php if (in_array($privilegio, [2, 4])): ?>
                                <td class="text-center">
                                    <?php if ($l['status'] !== 'G'): ?>
                                    <form action="<?= BASE_URL ?>/financeiro/lancamento/excluir" method="POST"
                                          class="fin-delete-form js-confirm-delete-lancamento">
                                        <input type="hidden" name="id_lancamento" value="<?= $l['id_lancamento'] ?>">
                                        <button type="submit" class="btn-danger-sm">
                                            <i class='bx bx-trash'></i>
                                        </button>
                                    </form>
                                    <?php endif; ?>
                                </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <?php if (($totalPaginas ?? 1) > 1): ?>
                <nav class="mt-3 d-flex justify-content-center">
                    <ul class="pagination">
                        <li class="page-item <?= $pagina <= 1 ? 'disabled' : '' ?>">
                            <a class="page-link" href="<?= $pagina > 1 ? $baseLancamentos . 'pagina=' . ($pagina - 1) : '#' ?>">Anterior</a>
                        </li>
                        <?php
                        $range = 2;
                        for ($i = 1; $i <= $totalPaginas; $i++):
                            $mostrar = ($i == 1 || $i == $totalPaginas || ($i >= $pagina - $range && $i <= $pagina + $range));
                            if (!$mostrar): if ($i == 2 || $i == $totalPaginas - 1): ?>
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            <?php endif; continue; endif; ?>
                            <li class="page-item <?= $i === $pagina ? 'active' : '' ?>">
                                <a class="page-link" href="<?= $baseLancamentos ?>pagina=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item <?= $pagina >= $totalPaginas ? 'disabled' : '' ?>">
                            <a class="page-link" href="<?= $pagina < $totalPaginas ? $baseLancamentos . 'pagina=' . ($pagina + 1) : '#' ?>">Próximo</a>
                        </li>
                    </ul>
                </nav>
            <?php endif; ?>
        <?php endif; ?>
    </div>

</div>
</main>

<?php require_once __DIR__ . '/../../layout/footer.php'; ?>



