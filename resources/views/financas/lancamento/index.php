<?php
$paginaTitulo = 'Lançamentos';
$paginaAtiva  = 'financeiro';
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
<div style="max-width: 1100px; margin: 0 auto;">

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

    <div class="df-card" style="margin-bottom: 24px;">
        <h3 class="section-title">Registrar Lançamento</h3>
        <form action="<?= BASE_URL ?>/financeiro/lancamento/salvar" method="POST">

            <div class="df-grid-2">
                <div class="df-field">
                    <label>Tipo de Cobrança</label>
                    <select name="modelo" id="tipo" required onchange="filtrarTaxas()">
                        <option value="">Selecione...</option>
                        <option value="taxa">Taxa</option>
                        <option value="multa">Multa</option>
                    </select>
                </div>
                <div class="df-field">
                    <label>Descrição</label>
                    <select name="descricao" id="descricao" required onchange="preencherValor()">
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

            <div style="margin-top: 12px; padding: 12px 16px; background: #F8FAFC; border-radius: var(--radius); border: 1px solid var(--border);">
                <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; font-size: 14px; font-weight: 500;">
                    <input type="checkbox" name="todos_moradores" id="todos_moradores" value="1"
                           onchange="toggleMorador()"
                           style="width: 18px; height: 18px; accent-color: var(--primary); cursor: pointer;">
                    <span>
                        <i class='bx bx-group' style="color: var(--primary);"></i>
                        Lançar para <strong>todos os moradores ativos</strong>
                    </span>
                </label>
            </div>

            <div class="df-actions">
                <button type="reset" class="btn-ghost" onclick="resetForm()">Limpar</button>
                <button type="submit" class="btn-primary">Registrar</button>
            </div>
        </form>
    </div>
    <?php endif; ?>

    <div class="df-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 12px;">
            <h3 class="section-title" style="margin: 0;">Todos os Lançamentos</h3>
        </div>

        <form method="GET" action="<?= BASE_URL ?>/financeiro/lancamento" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 10px; margin-bottom: 16px; padding: 14px; background: #F8FAFC; border-radius: var(--radius); border: 1px solid var(--border); align-items: end;">
            <div class="df-field" style="margin: 0;">
                <label style="font-size: 11px;">Nome</label>
                <input type="text" id="pesquisa" name="nome" value="<?= htmlspecialchars($_GET['nome'] ?? ($_GET['busca'] ?? '')) ?>"
                       placeholder="Nome do morador...">
            </div>
            <div class="df-field" style="margin: 0;">
                <label style="font-size: 11px;">Tipo</label>
                <select name="tipo">
                    <option value="">Todos</option>
                    <?php foreach (($tiposTaxas ?? []) as $tipoTaxa): ?>
                        <option value="<?= htmlspecialchars($tipoTaxa) ?>" <?= ($_GET['tipo'] ?? '') === $tipoTaxa ? 'selected' : '' ?>>
                            <?= ucfirst(strtolower($tipoTaxa)) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="df-field" style="margin: 0;">
                <label style="font-size: 11px;">Descrição</label>
                <select name="descricao">
                    <option value="">Todas</option>
                    <?php foreach (($descricoesTaxas ?? []) as $descTaxa): ?>
                        <option value="<?= htmlspecialchars($descTaxa) ?>" <?= ($_GET['descricao'] ?? '') === $descTaxa ? 'selected' : '' ?>>
                            <?= htmlspecialchars($descTaxa) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="df-field" style="margin: 0;">
                <label style="font-size: 11px;">Status</label>
                <select id="filtroStatus" name="status">
                    <option value="">Todos</option>
                    <option value="P" <?= ($_GET['status'] ?? '') === 'P' ? 'selected' : '' ?>>Pendente</option>
                    <option value="F" <?= ($_GET['status'] ?? '') === 'F' ? 'selected' : '' ?>>Fatura Gerada</option>
                    <option value="G" <?= ($_GET['status'] ?? '') === 'G' ? 'selected' : '' ?>>Pago</option>
                    <option value="atraso" <?= ($_GET['status'] ?? '') === 'atraso' ? 'selected' : '' ?>>Em Atraso</option>
                </select>
            </div>
            <div class="df-field" style="margin: 0;">
                <label style="font-size: 11px;">Dt. Lançamento</label>
                <input type="date" id="filtroDtLanc" name="dt_lanc" value="<?= htmlspecialchars($_GET['dt_lanc'] ?? '') ?>">
            </div>
            <div class="df-field" style="margin: 0;">
                <label style="font-size: 11px;">Dt. Vencimento</label>
                <input type="date" id="filtroDtVenc" name="dt_venc" value="<?= htmlspecialchars($_GET['dt_venc'] ?? '') ?>">
            </div>
            <div class="df-field" style="margin: 0; justify-content: flex-end;">
                <label style="font-size: 11px;">&nbsp;</label>
                <button type="submit" class="btn-primary" style="height: 38px;">Filtrar</button>
            </div>
            <div class="df-field" style="margin: 0; justify-content: flex-end;">
                <label style="font-size: 11px;">&nbsp;</label>
                <a class="btn-ghost" href="<?= BASE_URL ?>/financeiro/lancamento" style="height: 38px;">Limpar filtros</a>
            </div>
        </form>

        <?php if (empty($lancamentos)): ?>
            <div class="empty-state">
                <i class='bx bx-receipt'></i>
                <h5>Nenhum lançamento encontrado</h5>
                <p>Os lançamentos aparecerão aqui.</p>
            </div>
        <?php else: ?>
            <div style="overflow-x: auto;">
                <table class="df-table" style="width: 100%; border-collapse: collapse; font-size: 13px;">
                    <thead>
                        <tr style="background: #F8FAFC;">
                            <th style="padding: 10px 12px; text-align: left; border-bottom: 1px solid var(--border); white-space: nowrap;">#</th>
                            <?php if (in_array($privilegio, [2, 4])): ?>
                            <th style="padding: 10px 12px; text-align: left; border-bottom: 1px solid var(--border);">Nome</th>
                            <th style="padding: 10px 12px; text-align: left; border-bottom: 1px solid var(--border);">Bloco</th>
                            <th style="padding: 10px 12px; text-align: left; border-bottom: 1px solid var(--border);">Apto</th>
                            <?php endif; ?>
                            <th style="padding: 10px 12px; text-align: left; border-bottom: 1px solid var(--border);">Tipo</th>
                            <th style="padding: 10px 12px; text-align: left; border-bottom: 1px solid var(--border);">Descrição</th>
                            <th style="padding: 10px 12px; text-align: right; border-bottom: 1px solid var(--border);">Valor</th>
                            <th style="padding: 10px 12px; text-align: left; border-bottom: 1px solid var(--border); white-space: nowrap;">Dt. Lançamento</th>
                            <th style="padding: 10px 12px; text-align: left; border-bottom: 1px solid var(--border); white-space: nowrap;">Vencimento</th>
                            <th style="padding: 10px 12px; text-align: left; border-bottom: 1px solid var(--border);">Status</th>
                            <?php if (in_array($privilegio, [2, 4])): ?>
                            <th style="padding: 10px 12px; text-align: center; border-bottom: 1px solid var(--border);">Ação</th>
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
                            <tr style="border-bottom: 1px solid #F1F5F9; transition: background 0.15s;"
                                onmouseover="this.style.background='#F8FAFC'" onmouseout="this.style.background=''"
                                data-nome="<?= strtolower($l['nome_morador'] ?? '') ?>"
                                data-tipo="<?= strtolower($l['modelo']) ?>"
                                data-desc="<?= strtolower($l['descricao']) ?>"
                                data-status="<?= $l['status'] ?>"
                                data-vencido="<?= $vencido ? '1' : '0' ?>"
                                data-dt-lanc="<?= $dtLanc ?? '' ?>"
                                data-dt-venc="<?= $l['data_vencimento'] ?>">
                                <td style="padding: 10px 12px; color: var(--text-muted);">#<?= $l['id_lancamento'] ?></td>
                                <?php if (in_array($privilegio, [2, 4])): ?>
                                <td style="padding: 10px 12px; font-weight: 500;"><?= htmlspecialchars($l['nome_morador'] ?? 'N/A') ?></td>
                                <td style="padding: 10px 12px;"><?= htmlspecialchars($l['bloco'] ?? '-') ?></td>
                                <td style="padding: 10px 12px;"><?= htmlspecialchars($l['apto'] ?? '-') ?></td>
                                <?php endif; ?>
                                <td style="padding: 10px 12px;">
                                    <span style="color: <?= $corModelo ?>; font-weight: 600; font-size: 12px;">
                                        <?= ucfirst(strtolower($l['modelo'])) ?>
                                    </span>
                                </td>
                                <td style="padding: 10px 12px;"><?= htmlspecialchars($l['descricao']) ?></td>
                                <td style="padding: 10px 12px; text-align: right; font-weight: 600;">
                                    R$ <?= number_format($l['valor'], 2, ',', '.') ?>
                                </td>
                                <td style="padding: 10px 12px; white-space: nowrap; color: var(--text-muted);">
                                    <?= $dtLanc ? date('d/m/Y', strtotime($dtLanc)) : '-' ?>
                                </td>
                                <td style="padding: 10px 12px; white-space: nowrap;">
                                    <span style="color: <?= $vencido ? '#EF4444' : 'inherit' ?>; font-weight: <?= $vencido ? '600' : '400' ?>;">
                                        <?= date('d/m/Y', strtotime($l['data_vencimento'])) ?>
                                        <?= $vencido ? ' ⚠' : '' ?>
                                    </span>
                                </td>
                                <td style="padding: 10px 12px;">
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
                                <td style="padding: 10px 12px; text-align: center;">
                                    <?php if ($l['status'] !== 'G'): ?>
                                    <form action="<?= BASE_URL ?>/financeiro/lancamento/excluir" method="POST"
                                          onsubmit="return confirm('Deseja excluir este lançamento?')" style="display:inline">
                                        <input type="hidden" name="id_lancamento" value="<?= $l['id_lancamento'] ?>">
                                        <button type="submit" class="btn-danger-sm" style="padding: 3px 8px;">
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

<script>
const todasTaxas = <?= json_encode($todasTaxas) ?>;

function filtrarTaxas() {
    const tipo = document.getElementById('tipo').value;
    const select = document.getElementById('descricao');
    const valorInput = document.getElementById('valor');
    select.innerHTML = '<option value="">Selecione...</option>';
    valorInput.value = '';
    if (!tipo) return;
    const filtradas = todasTaxas.filter(t => t.modulo.toLowerCase() === tipo);
    if (filtradas.length === 0) { select.innerHTML = '<option value="">Nenhum cadastrado</option>'; return; }
    filtradas.forEach(t => {
        const opt = document.createElement('option');
        opt.value = t.descricao; opt.textContent = t.descricao; opt.dataset.valor = t.valor;
        select.appendChild(opt);
    });
}

function preencherValor() {
    const select = document.getElementById('descricao');
    const opt = select.options[select.selectedIndex];
    document.getElementById('valor').value = opt.dataset.valor ?? '';
}

function resetForm() {
    document.getElementById('descricao').innerHTML = '<option value="">Selecione o tipo primeiro...</option>';
    document.getElementById('valor').value = '';
}

function toggleMorador() {
    const checkbox = document.getElementById('todos_moradores');
    const campo = document.getElementById('campo_morador');
    campo.style.display = checkbox.checked ? 'none' : 'block';
    campo.querySelector('select').required = !checkbox.checked;
}

function filtrarLancamentos() {}

<?php if (in_array($privilegio, [2, 4])): ?>
document.querySelector('form[action*="lancamento/salvar"]').addEventListener('submit', function(e) {
    e.preventDefault();
    const form = this;
    fetch('<?= BASE_URL ?>/financeiro/lancamento/verificar', { method: 'POST', body: new FormData(form) })
    .then(r => r.json())
    .then(res => {
        if (res.duplicado) {
            let msg = 'Já existe um lançamento com esses parâmetros em aberto neste mês.';
            if (res.quantidade) msg += ` (${res.quantidade} morador(es) afetado(s))`;
            msg += '\n\nDeseja continuar mesmo assim?';
            if (confirm(msg)) form.submit();
        } else { form.submit(); }
    })
    .catch(() => form.submit());
});
<?php endif; ?>
</script>

<?php require_once __DIR__ . '/../../layout/footer.php'; ?>

