<?php
$paginaTitulo = 'Presenças nas Assembleias';
$paginaAtiva  = 'assembleia';
require_once __DIR__ . '/../layout/header.php';

$totalConfirmadas = count(array_filter($presencas, fn($p) => $p['presenca'] === 'S'));
$totalNegadas     = count(array_filter($presencas, fn($p) => $p['presenca'] === 'N'));
?>

<main class="main-content">
<div class="df-container">

    <div class="page-header">
        <h2>Presenças nas Assembleias</h2>
        <p class="text-muted">Confirme quem irá participar das reuniões</p>
    </div>

    <!-- Filtros -->
    <div class="df-card" style="margin-bottom: 24px;">
        <h3 class="section-title">Filtros</h3>
        <div class="df-grid-3">
            <div class="df-field">
                <label>Buscar morador</label>
                <input type="text" id="filtroNome" placeholder="Nome, apto ou bloco..."
                       oninput="filtrarPresencas()">
            </div>
            <div class="df-field">
                <label>Assembleia</label>
                <select id="filtroAssembleia" onchange="filtrarPresencas()">
                    <option value="">Todas</option>
                    <?php foreach ($assembleias as $a): ?>
                        <option value="<?= htmlspecialchars($a['titulo']) ?>">
                            <?= htmlspecialchars($a['titulo']) ?> — <?= date('d/m/Y', strtotime($a['data'])) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="df-field">
                <label>Presença</label>
                <select id="filtroPresenca" onchange="filtrarPresencas()">
                    <option value="">Todas</option>
                    <option value="S">Confirmadas</option>
                    <option value="N">Negadas</option>
                </select>
            </div>
        </div>
        <div class="df-actions" style="padding-top: 8px; margin-top: 0; border-top: none;">
            <button class="btn-ghost" onclick="limparFiltros()">Limpar filtros</button>
        </div>
    </div>

    <!-- Grid -->
    <div class="df-card">
        <h3 class="section-title">Registros de Presença</h3>

        <?php if (empty($presencas)): ?>
            <div class="empty-state">
                <i class='bx bx-group'></i>
                <h5>Nenhuma presença registrada</h5>
                <p>Os moradores ainda não confirmaram presença em nenhuma assembleia.</p>
            </div>
        <?php else: ?>

            <!-- Resumo no topo -->
             <div class="presenca-resumo d-flex">
            <div class="presenca-resumo-item presenca-resumo-confirmada">
                <strong>✓ <span id="totalConfirmadas"><?= $totalConfirmadas ?></span></strong> confirmadas
            </div>
            <div class="presenca-resumo-item presenca-resumo-negada">
                <strong>✗ <span id="totalNegadas"><?= $totalNegadas ?></span></strong> negadas
            </div>
            <div class="presenca-resumo-item" style="background: #F8FAFC; border: 1px solid var(--border); color: var(--text);">
                <strong><span id="totalGeral"><?= count($presencas) ?></span></strong> total
            </div>
        </div>

            <div style="overflow-x: auto;">
                <table class="presenca-table">
                    <thead>
                        <tr>
                            <th>Morador</th>
                            <th>Apto</th>
                            <th>Bloco</th>
                            <th>Assembleia</th>
                            <th>Data</th>
                            <th>Presença</th>
                            <th>Confirmado em</th>
                        </tr>
                    </thead>
                    <tbody id="tabelaPresencas">
                        <?php foreach ($presencas as $p):
                            $confirmada = $p['presenca'] === 'S';
                        ?>
                            <tr data-nome="<?= strtolower($p['nome']) ?>"
                                data-apto="<?= strtolower($p['apto']) ?>"
                                data-bloco="<?= strtolower($p['bloco']) ?>"
                                data-assembleia="<?= htmlspecialchars($p['titulo']) ?>"
                                data-presenca="<?= $p['presenca'] ?>">
                                <td><strong><?= htmlspecialchars($p['nome']) ?></strong></td>
                                <td><?= htmlspecialchars($p['apto']) ?></td>
                                <td><?= htmlspecialchars($p['bloco']) ?></td>
                                <td><?= htmlspecialchars($p['titulo']) ?></td>
                                <td><?= date('d/m/Y', strtotime($p['data_assembleia'])) ?></td>
                                <td>
                                    <span class="presenca-badge <?= $confirmada ? 'presenca-badge-confirmada' : 'presenca-badge-negada' ?>">
                                        <?= $confirmada ? '✓ Confirmada' : '✗ Negada' ?>
                                    </span>
                                </td>
                                <td><?= date('d/m/Y H:i', strtotime($p['created_at'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

</div>
</main>

<script>
function filtrarPresencas() {
    const nome       = document.getElementById('filtroNome').value.toLowerCase();
    const assembleia = document.getElementById('filtroAssembleia').value;
    const presenca   = document.getElementById('filtroPresenca').value;

    let confirmadas = 0;
    let negadas     = 0;
    let total       = 0;

    document.querySelectorAll('#tabelaPresencas tr').forEach(row => {
        const rowNome       = row.dataset.nome       ?? '';
        const rowApto       = row.dataset.apto       ?? '';
        const rowBloco      = row.dataset.bloco      ?? '';
        const rowAssembleia = row.dataset.assembleia ?? '';
        const rowPresenca   = row.dataset.presenca   ?? '';

        let ok = true;
        if (nome && !rowNome.includes(nome) && !rowApto.includes(nome) && !rowBloco.includes(nome)) ok = false;
        if (assembleia && rowAssembleia !== assembleia) ok = false;
        if (presenca && rowPresenca !== presenca) ok = false;

        row.style.display = ok ? '' : 'none';

        if (ok) {
            total++;
            if (rowPresenca === 'S') confirmadas++;
            if (rowPresenca === 'N') negadas++;
        }
    });

    // atualiza os contadores
    document.getElementById('totalConfirmadas').textContent = confirmadas;
    document.getElementById('totalNegadas').textContent     = negadas;
    document.getElementById('totalGeral').textContent       = total;
}
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>