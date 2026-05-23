<?php
$paginaTitulo = 'Detalhes da Assembleia';
$paginaAtiva  = 'assembleia';
$cssTela = 'assembleia.css';
require_once __DIR__ . '/../layout/header.php';

$totalConfirmadas = count(array_filter($presencas, fn($p) => $p['presenca'] === 'S'));
$totalNegadas     = count(array_filter($presencas, fn($p) => $p['presenca'] === 'N'));
$totalPendentes   = count(array_filter($presencas, fn($p) => $p['presenca'] === 'P'));
?>

<main class="main-content">
<div class="df-container-lg">

    <div class="page-header">
        <div style="display: flex; align-items: center; gap: 12px;">
            <a href="<?= BASE_URL ?>/assembleia/presencas" class="btn-ghost" style="padding: 6px 12px; font-size: 13px;">
                <i class='bx bx-arrow-back'></i> Voltar
            </a>
            <div>
                <h2><?= htmlspecialchars($assembleia['titulo'] ?? '') ?></h2>
                <p class="text-muted">
                    <?= date('d/m/Y', strtotime($assembleia['data'] ?? 'now')) ?>
                    às <?= date('H:i', strtotime($assembleia['hora'] ?? 'now')) ?>
                    — <?= htmlspecialchars($assembleia['local'] ?? '') ?>
                </p>
            </div>
        </div>
    </div>

    <div class="presenca-resumo d-flex" style="margin-bottom: 24px;">
        <div class="presenca-resumo-item presenca-resumo-confirmada">
            <strong>✓ <span id="totalConfirmadas"><?= $totalConfirmadas ?></span></strong> confirmadas
        </div>
        <div class="presenca-resumo-item presenca-resumo-negada">
            <strong>✗ <span id="totalNegadas"><?= $totalNegadas ?></span></strong> negadas
        </div>
        <div class="presenca-resumo-item presenca-resumo-total">
            <strong><span id="totalPendentes"><?= $totalPendentes ?></span></strong> pendentes
        </div>
        <div class="presenca-resumo-item presenca-resumo-total">
            <strong><span id="totalGeral"><?= count($presencas) ?></span></strong> total
        </div>
    </div>

    <div class="df-card">

        <div class="df-grid-2" style="margin-bottom: 16px;">
            <div class="df-field" style="margin: 0;">
                <label>Buscar morador</label>
                <input type="text" id="filtroNome" placeholder="Nome, apto ou bloco..."
                       oninput="filtrarPresencas()">
            </div>
            <div class="df-field" style="margin: 0;">
                <label>Presença</label>
                <select id="filtroPresenca" onchange="filtrarPresencas()">
                    <option value="">Todas</option>
                    <option value="S">Confirmadas</option>
                    <option value="N">Negadas</option>
                    <option value="P">Pendentes</option>
                </select>
            </div>
        </div>

        <?php if (empty($presencas)): ?>
            <div class="empty-state">
                <i class='bx bx-group'></i>
                <h5>Nenhuma presença registrada</h5>
                <p>Os moradores ainda não confirmaram presença nesta assembleia.</p>
            </div>
        <?php else: ?>
            <div style="overflow-x: auto;">
                <table class="presenca-table">
                    <thead>
                        <tr>
                            <th>Morador</th>
                            <th>Apto</th>
                            <th>Bloco</th>
                            <th>Presença</th>
                            <th>Atualizado em</th>
                        </tr>
                    </thead>
                    <tbody id="tabelaPresencas">
                        <?php foreach ($presencas as $p):
                            $badgeClass = match($p['presenca']) {
                                'S' => 'presenca-badge-confirmada',
                                'N' => 'presenca-badge-negada',
                                default => 'presenca-badge-pendente'
                            };
                            $badgeTexto = match($p['presenca']) {
                                'S' => '✓ Confirmada',
                                'N' => '✗ Negada',
                                default => '⏳ Pendente'
                            };
                        ?>
                            <tr data-nome="<?= strtolower($p['nome']) ?>"
                                data-apto="<?= strtolower($p['apto']) ?>"
                                data-bloco="<?= strtolower($p['bloco']) ?>"
                                data-presenca="<?= $p['presenca'] ?>">
                                <td><strong><?= htmlspecialchars($p['nome']) ?></strong></td>
                                <td><?= htmlspecialchars($p['apto']) ?></td>
                                <td><?= htmlspecialchars($p['bloco']) ?></td>
                                <td>
                                    <span class="presenca-badge <?= $badgeClass ?>">
                                        <?= $badgeTexto ?>
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
    const nome     = document.getElementById('filtroNome').value.toLowerCase();
    const presenca = document.getElementById('filtroPresenca').value;

    let confirmadas = 0, negadas = 0, pendentes = 0, total = 0;

    document.querySelectorAll('#tabelaPresencas tr').forEach(row => {
        const rowNome     = row.dataset.nome     ?? '';
        const rowApto     = row.dataset.apto     ?? '';
        const rowBloco    = row.dataset.bloco    ?? '';
        const rowPresenca = row.dataset.presenca ?? '';

        let ok = true;
        if (nome && !rowNome.includes(nome) && !rowApto.includes(nome) && !rowBloco.includes(nome)) ok = false;
        if (presenca && rowPresenca !== presenca) ok = false;

        row.style.display = ok ? '' : 'none';

        if (ok) {
            total++;
            if (rowPresenca === 'S') confirmadas++;
            if (rowPresenca === 'N') negadas++;
            if (rowPresenca === 'P') pendentes++;
        }
    });

    document.getElementById('totalConfirmadas').textContent = confirmadas;
    document.getElementById('totalNegadas').textContent     = negadas;
    document.getElementById('totalPendentes').textContent   = pendentes;
    document.getElementById('totalGeral').textContent       = total;
}
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>