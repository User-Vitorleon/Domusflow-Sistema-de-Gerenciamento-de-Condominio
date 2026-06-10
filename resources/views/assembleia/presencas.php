<?php
$paginaTitulo = 'Presenças nas Assembleias';
$paginaAtiva  = 'assembleia';
$cssTela = 'assembleia.css';
$jsExtra = 'assembleia-presencas.js';
require_once __DIR__ . '/../layout/header.php';
?>

<main class="main-content">
<div class="df-container">

    <div class="page-header">
        <h2>Presenças nas Assembleias</h2>
        <p class="text-muted">Confirme quem irá participar das reuniões</p>
    </div>

    <div class="df-card" style="margin-bottom: 24px;">
        <h3 class="section-title">Filtros</h3>
        <div class="df-grid-3">
            <div class="df-field">
                <label>Buscar assembleia ou local</label>
                <input type="text" id="filtroNome" placeholder="Titulos">
            </div>
            <div class="df-field">
                <label>Assembleia</label>
                <select id="filtroAssembleia">
                    <option value="">Todas</option>
                    <?php foreach ($assembleias as $a): ?>
                        <option value="<?= htmlspecialchars($a['titulo']) ?>">
                            <?= htmlspecialchars($a['titulo']) ?> — <?= date('d/m/Y', strtotime($a['data'])) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="df-field">
                <label>Data</label>
                <input type="date" id="filtroData">
            </div>

        </div>
        <div class="df-actions" style="padding-top: 8px; margin-top: 0; border-top: none;">
            <button class="btn-ghost" type="button" data-presencas-limpar>Limpar filtros</button>
        </div>
    </div>


    <div class="df-card">
        <h3 class="section-title">Registros de Presença</h3>

        <?php if (empty($presencasAgrupadas)): ?>
            <div class="empty-state">
                <i class='bx bx-group'></i>
                <h5>Nenhuma presença registrada</h5>
                <p>Os moradores ainda não confirmaram presença em nenhuma assembleia.</p>
            </div>
        <?php else: ?>
            <div style="overflow-x: auto;">
                <table class="presenca-table">
                    <thead>
                        <tr>
                            <th>Assembleia</th>
                            <th>Data</th>
                            <th>Local</th>
                            <th style="text-align:center;">Confirmados</th>
                            <th style="text-align:center;">Pendentes</th>
                            <th style="text-align:center;">Recusados</th>
                            <th style="text-align:center;">Total</th>
                            <th style="text-align:center;">Detalhes</th>
                        </tr>
                    </thead>
                    <tbody id="tabelaPresencas">
                        <?php foreach ($presencasAgrupadas as $a): ?>
                            <tr
                                data-assembleia="<?= htmlspecialchars($a['titulo']) ?>"
                                data-local="<?= htmlspecialchars($a['local']) ?>"
                                data-data="<?= htmlspecialchars($a['data']) ?>">
                                <td><strong><?= htmlspecialchars($a['titulo']) ?></strong></td>
                                <td><?= date('d/m/Y', strtotime($a['data'])) ?></td>
                                <td><?= htmlspecialchars($a['local']) ?></td>
                                <td style="text-align:center;">
                                    <span class="presenca-badge presenca-badge-confirmada"><?= $a['confirmados'] ?></span>
                                </td>
                                <td style="text-align:center;">
                                    <span class="presenca-badge presenca-badge-pendente"><?= $a['pendentes'] ?></span>
                                </td>
                                <td style="text-align:center;">
                                    <span class="presenca-badge presenca-badge-negada"><?= $a['negados'] ?></span>
                                </td>
                                <td style="text-align:center;"><strong><?= $a['total'] ?></strong></td>
                                <td style="text-align:center;">
                                    <a href="<?= BASE_URL ?>/assembleia/presencas/detalhe?id=<?= $a['id_assembleia'] ?>"
                                    class="btn-primary" style="font-size:12px;padding:5px 12px;">
                                        Ver
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

</div>
</main>


<?php require_once __DIR__ . '/../layout/footer.php'; ?>
