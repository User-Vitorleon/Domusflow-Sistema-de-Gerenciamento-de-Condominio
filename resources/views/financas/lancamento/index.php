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

        <?php if (empty($lancamentos)): ?>
            <div class="empty-state">
                <i class='bx bx-receipt'></i>
                <h5>Nenhum lançamento encontrado</h5>
                <p>Os lançamentos aparecerão aqui.</p>
            </div>
        <?php else: ?>
            <div class="table-wrap">
                <table class="df-table">
                    <thead>
                        <tr>
                            <th>Tipo</th>
                            <th>Descrição</th>
                            <th>Valor</th>
                            <th>Vencimento</th>
                            <th>Status</th>
                            <?php if ($prev == 2): ?>
                                <th>Morador</th>
                                <th>Ação</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($lancamentos as $l): ?>
                            <tr>
                                <td><?= ucfirst(htmlspecialchars($l['modelo'])) ?></td>
                                <td><?= htmlspecialchars($l['descricao']) ?></td>
                                <td>R$ <?= number_format($l['valor'], 2, ',', '.') ?></td>
                                <td><?= date('d/m/Y', strtotime($l['data_vencimento'])) ?></td>
                                <td>
                                    <span style="color: <?= $l['status'] === 'P' ? '#CA8A04' : '#16A34A' ?>">
                                        <?= $l['status'] === 'P' ? 'Pendente' : 'Pago' ?>
                                    </span>
                                </td>
                                <?php if ($prev == 2): ?>
                                    <td><?= htmlspecialchars($l['nome'] ?? 'N/A') ?></td>
                                    <td>
                                        <!-- Gerar fatura -->
                                        <form action="<?= BASE_URL ?>/financeiro/fatura/gerar" method="POST" style="display:inline"
                                            onsubmit="return confirm('Gerar fatura para este morador?')">
                                            <input type="hidden" name="id_user" value="<?= $l['id_user'] ?>">
                                            <button type="submit" class="btn-primary" style="padding: 4px 10px; font-size: 0.8rem;">
                                                Gerar Fatura
                                            </button>
                                        </form>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php require_once __DIR__ . '/../../layout/footer.php'; ?>