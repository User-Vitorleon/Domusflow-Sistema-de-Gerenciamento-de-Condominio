<?php
$paginaTitulo = 'Lançamentos';
$paginaAtiva  = 'financeiro';
require_once __DIR__ . '/../../layout/header.php';
$prev = $usuario['previlegio'] ?? 1;
?>

<main class="main-content">
    <div class="page-header">
        <h2>Lançamentos Financeiros</h2>
        <p class="text-muted">Gerencie taxas e multas dos moradores</p>
    </div>

    <?php if (isset($_SESSION['erro_lancamento'])): ?>
        <div class="df-alert df-alert-error">
            <?= htmlspecialchars($_SESSION['erro_lancamento']) ?>
            <?php unset($_SESSION['erro_lancamento']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['erro_fatura'])): ?>
        <div class="df-alert df-alert-error">
            <?= htmlspecialchars($_SESSION['erro_fatura']) ?>
            <?php unset($_SESSION['erro_fatura']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['sucesso_fatura'])): ?>
        <div class="df-alert df-alert-success">
            <?= htmlspecialchars($_SESSION['sucesso_fatura']) ?>
            <?php unset($_SESSION['sucesso_fatura']); ?>
        </div>
    <?php endif; ?>

    <?php if ($prev == 2): ?>
    <!-- Formulário de lançamento — só síndico -->
    <div class="df-card" style="margin-bottom: 24px;">
        <h3 class="section-title">Registrar Lançamento</h3>
        <form action="<?= BASE_URL ?>/financeiro/lancamento/salvar" method="POST">
    
    <div class="df-grid-2">
        <div class="df-field">
            <label>Tipo</label>
            <select name="modelo" id="tipo" required onchange="filtrarTaxas()">
                <option value="">Selecione...</option>
                <option value="taxa">Taxa</option>
                <option value="multa">Multa</option>
            </select>
        </div>
        <div class="df-field">
            <label>Valor (R$)</label>
            <input type="number" name="valor" id="valor" step="0.01" min="0" placeholder="0,00" readonly required>
        </div>
    </div>

    <div class="df-grid-2">
        <div class="df-field">
            <label>Descrição</label>
            <select name="descricao" id="descricao" required onchange="preencherValor()">
                <option value="">Selecione o tipo primeiro...</option>
            </select>
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
        <div class="df-field">
            <label>Data de Lançamento</label>
            <input type="date" name="data_lanc" value="<?= date('Y-m-d') ?>" required>
        </div>
    </div>
    <div class="df-field" style="margin-top: 10px;">
        <label>
            <input type="checkbox" name="todos_moradores" id="todos_moradores" value="1" onchange="toggleMorador()">
            Lançar para todos os moradores ativos
        </label>
    </div>

    <div class="df-actions">
        <button type="reset" class="btn-ghost" onclick="resetForm()">Limpar</button>
        <button type="submit" class="btn-primary">Registrar</button>
    </div>
</form>

<script>
    
    const todasTaxas = <?= json_encode($todasTaxas) ?>;
    console.log(todasTaxas);

    
function filtrarTaxas() {
    const tipo      = document.getElementById('tipo').value;
    const select    = document.getElementById('descricao');
    const valorInput = document.getElementById('valor');

    select.innerHTML = '<option value="">Selecione...</option>';
    valorInput.value = '';

    if (!tipo) return;

    const filtradas = todasTaxas.filter(t => t.modulo.toLowerCase() === tipo);

    if (filtradas.length === 0) {
        select.innerHTML = '<option value="">Nenhum cadastrado</option>';
        return;
    }

    filtradas.forEach(t => {
        const opt = document.createElement('option');
        opt.value       = t.descricao;
        opt.textContent = t.descricao;
        opt.dataset.valor = t.valor;
        select.appendChild(opt);
    });
}

function preencherValor() {
    const select = document.getElementById('descricao');
    const opt    = select.options[select.selectedIndex];
    document.getElementById('valor').value = opt.dataset.valor ?? '';
}

function resetForm() {
    document.getElementById('descricao').innerHTML = '<option value="">Selecione o tipo primeiro...</option>';
    document.getElementById('valor').value = '';
}


function toggleMorador() {
    const checkbox = document.getElementById('todos_moradores');
    const campo    = document.getElementById('campo_morador');
    campo.style.display = checkbox.checked ? 'none' : 'block';
    const select = campo.querySelector('select');
    select.required = !checkbox.checked;
}

document.querySelector('form[action*="lancamento/salvar"]').addEventListener('submit', function(e) {
    e.preventDefault();
    const form = this;

    const dados = new FormData(form);

    fetch('<?= BASE_URL ?>/financeiro/lancamento/verificar', {
        method: 'POST',
        body: dados
    })
    .then(r => r.json())
    .then(res => {
         console.log(res);
        if (res.duplicado) {
            let msg = 'Já existe um lançamento com esses parâmetros em aberto neste mês.';
            if (res.quantidade) {
                msg += ` (${res.quantidade} morador(es) afetado(s))`;
            }
            msg += '\n\nDeseja continuar mesmo assim?';

            if (confirm(msg)) {
                form.submit();
            }
        } else {
            form.submit();
        }
    })
    .catch(() => {
        // em caso de erro na verificação, envia mesmo assim
        form.submit();
    });
});

</script>
    </div>
    <?php endif; ?>

    <!-- Listagem de lançamentos -->
    <div class="df-card">
        <h3 class="section-title">
            <?= $prev == 2 ? 'Todos os Lançamentos' : 'Meus Lançamentos' ?>
        </h3>

                   <div class="df-field" style="margin-bottom: 16px;">
                <input type="text" id="pesquisa" 
                value="<?= htmlspecialchars($_GET['busca'] ?? '') ?>"
                placeholder="Pesquisar por morador, descrição ou tipo..." 
                oninput="filtrarLancamentos()" >
            </div>
            <div class="morador-list">

        <?php if (empty($lancamentos)): ?>
            <div class="empty-state">
                <i class='bx bx-receipt'></i>
                <h5>Nenhum lançamento encontrado</h5>
                <p>Os lançamentos aparecerão aqui.</p>
            </div>
        <?php else: ?>
                <?php foreach ($lancamentos as $l): 
                    $corStatus = match($l['status']) {
                        'P' => '#CA8A04',
                        'F' => '#16A34A',
                        'G' => '#2563EB',
                        default => '#6B7280'
                    };
                    $textoStatus = match($l['status']) {
                        'P' => 'Pendente',
                        'F' => 'Fatura Gerada',
                        'G' => 'Pago',
                        default => $l['status']
                    };
                    $corModelo = strtoupper($l['modelo']) === 'TAXA' ? '#2563EB' : '#DC2626';
                    $bgModelo  = strtoupper($l['modelo']) === 'TAXA' ? '#EFF6FF' : '#FEF2F2';
                    $iconeModelo = strtoupper($l['modelo']) === 'TAXA' ? 'bx-coin' : 'bx-error';
                    $vencido = strtotime($l['data_vencimento']) < strtotime('today') && $l['status'] === 'P';
                ?>
                    <div class="morador-card" data-pesquisa="<?= strtolower($l['descricao'] . ' ' . $l['modelo'] . ' ' . ($l['nome_morador'] ?? '')) ?>">
                        <!-- Ícone do tipo -->
                        <div style="width:42px; height:42px; border-radius:50%; background:<?= $bgModelo ?>; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                            <i class='bx <?= $iconeModelo ?>' style="font-size:20px; color:<?= $corModelo ?>"></i>
                        </div>

                        <!-- Informações -->
                        <div class="morador-info">
                            <strong><?= htmlspecialchars($l['descricao']) ?></strong>
                            <span>
                                <span style="color:<?= $corModelo ?>; font-weight:600;">
                                    <?= ucfirst(strtolower($l['modelo'])) ?>
                                </span>
                                · R$ <?= number_format($l['valor'], 2, ',', '.') ?>
                                · Venc: <span style="color:<?= $vencido ? '#EF4444' : 'inherit' ?>; font-weight: <?= $vencido ? '600' : '400' ?>">
                                    <?= date('d/m/Y', strtotime($l['data_vencimento'])) ?>
                                    <?= $vencido ? '(Vencido)' : '' ?>
                                </span>
                                <?php if ($prev == 2): ?>
                                    · <?= htmlspecialchars($l['nome_morador'] ?? 'N/A') ?>
                                <?php endif; ?>
                            </span>
                        </div>

                        <!-- Status e Ação -->
                        <div class="morador-actions" style="flex-direction: column; align-items: flex-end; gap: 6px;">
                            <span style="color:<?= $corStatus ?>; font-size:13px; font-weight:600;">
                                <?= $textoStatus ?>
                            </span>
                            <?php if ($prev == 2 && $l['status'] === 'P'): ?>
                            <form action="<?= BASE_URL ?>/financeiro/fatura/gerar" method="POST"
                                onsubmit="return confirm('Gerar fatura para este morador?')">
                                <input type="hidden" name="id_user" value="<?= $l['id_user'] ?>">
                                <button type="submit" class="btn-primary" style="padding:4px 10px; font-size:0.8rem;">
                                    Gerar Fatura
                                </button>
                            </form>
                        <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php if (($totalPaginas ?? 1) > 1): ?>
                <nav class="mt-3 d-flex justify-content-center">
                    <ul class="pagination">
                        <li class="page-item <?= $pagina <= 1 ? 'disabled' : '' ?>">
                            <a class="page-link" href="?pagina=<?= $pagina - 1 ?>">Anterior</a>
                        </li>
                        <?php
                        $range = 2;
                        for ($i = 1; $i <= $totalPaginas; $i++):
                            $mostrar = ($i == 1 || $i == $totalPaginas || ($i >= $pagina - $range && $i <= $pagina + $range));
                            if (!$mostrar):
                                if ($i == 2 || $i == $totalPaginas - 1): ?>
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                <?php endif;
                                continue;
                            endif; ?>
                            <li class="page-item <?= $i === $pagina ? 'active' : '' ?>">
                                <a class="page-link" href="?pagina=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item <?= $pagina >= $totalPaginas ? 'disabled' : '' ?>">
                            <a class="page-link" href="?pagina=<?= $pagina + 1 ?>">Próximo</a>
                        </li>
                    </ul>
                </nav>
            <?php endif; ?>
        <?php endif; ?>
    </div>

</main>

    <script>
        let timer;
        function filtrarLancamentos() {
            clearTimeout(timer);
            timer = setTimeout(() => {
                const termo = document.getElementById('pesquisa').value;
                window.location.href = '<?= BASE_URL ?>/financeiro/lancamento?busca=' + encodeURIComponent(termo);
            }, 500); // aguarda 500ms após parar de digitar
        }
</script>

<?php require_once __DIR__ . '/../../layout/footer.php'; ?>                        
