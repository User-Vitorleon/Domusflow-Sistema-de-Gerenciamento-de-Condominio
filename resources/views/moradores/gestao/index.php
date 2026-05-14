<?php
$paginaTitulo = 'Gestão de Moradores';
$paginaAtiva  = 'moradores';
require_once __DIR__ . '/../../layout/header.php';
?>

<main class="main-content">
<div style="max-width: 960px; margin: 0 auto;">

    <div class="page-header">
        <h2>Gestão de Moradores</h2>
        <p class="text-muted">Gerencie os privilégios dos moradores do condomínio</p>
    </div>

    <?php if (isset($_GET['sucesso'])): ?>
        <div class="df-alert df-alert-success">Privilégio atualizado com sucesso!</div>
    <?php endif; ?>

    <?php if (isset($_GET['erro'])): ?>
        <div class="df-alert df-alert-error">Erro ao atualizar privilégio.</div>
    <?php endif; ?>

    <div class="df-card">
        <!-- Filtro de busca -->
        <div style="margin-bottom: 16px;">
            <div class="df-field" style="margin: 0;">
                <input type="text" id="busca" placeholder="Buscar por nome, apto ou bloco..."
                       oninput="filtrarMoradores()">
            </div>
        </div>

        <?php if (empty($moradores)): ?>
            <div class="empty-state">
                <i class='bx bx-user'></i>
                <h5>Nenhum morador encontrado</h5>
            </div>
        <?php else: ?>
            <div style="overflow-x: auto;">
                <table class="df-table" style="width: 100%; border-collapse: collapse; font-size: 13px;">
                    <thead>
                        <tr style="background: #F8FAFC;">
                            <th style="padding: 10px 12px; text-align: left; border-bottom: 1px solid var(--border);">Nome</th>
                            <th style="padding: 10px 12px; text-align: left; border-bottom: 1px solid var(--border);">Apto</th>
                            <th style="padding: 10px 12px; text-align: left; border-bottom: 1px solid var(--border);">Bloco</th>
                            <th style="padding: 10px 12px; text-align: left; border-bottom: 1px solid var(--border);">Status</th>
                            <th style="padding: 10px 12px; text-align: left; border-bottom: 1px solid var(--border);">Privilégio Atual</th>
                            <th style="padding: 10px 12px; text-align: center; border-bottom: 1px solid var(--border);">Alterar</th>
                        </tr>
                    </thead>
                    <tbody id="tabelaMoradores">
                        <?php 
                        $perfis = [1 => 'Morador', 2 => 'Síndico', 3 => 'Porteiro', 4 => 'Admin'];
                        $coresPerfil = [
                            1 => ['#2563EB', '#EFF6FF', '#BFDBFE'],
                            2 => ['#16A34A', '#F0FDF4', '#BBF7D0'],
                            3 => ['#D97706', '#FFFBEB', '#FDE68A'],
                            4 => ['#DC2626', '#FEF2F2', '#FECACA'],
                        ];
                        foreach ($moradores as $m): 
                            $prev = $m['previlegio'] ?? 1;
                            $cor = $coresPerfil[$prev] ?? $coresPerfil[1];
                            $statusCor = $m['status'] === 'L' ? '#16A34A' : '#CA8A04';
                            $statusTxt = match($m['status']) {
                                'L' => 'Liberado',
                                'P' => 'Pendente',
                                'B' => 'Bloqueado',
                                default => $m['status']
                            };
                        ?>
                            <tr style="border-bottom: 1px solid #F1F5F9;"
                                data-nome="<?= strtolower($m['nome']) ?>"
                                data-apto="<?= strtolower($m['apto']) ?>"
                                data-bloco="<?= strtolower($m['bloco']) ?>">
                                <td style="padding: 10px 12px; font-weight: 500;">
                                    <?= htmlspecialchars($m['nome']) ?>
                                </td>
                                <td style="padding: 10px 12px;"><?= htmlspecialchars($m['apto']) ?></td>
                                <td style="padding: 10px 12px;"><?= htmlspecialchars($m['bloco']) ?></td>
                                <td style="padding: 10px 12px;">
                                    <span style="color: <?= $statusCor ?>; font-weight: 600; font-size: 12px;">
                                        <?= $statusTxt ?>
                                    </span>
                                </td>
                                <td style="padding: 10px 12px;">
                                    <span style="
                                        padding: 3px 10px; border-radius: 20px; font-size: 12px; font-weight: 600;
                                        color: <?= $cor[0] ?>; background: <?= $cor[1] ?>; border: 1px solid <?= $cor[2] ?>;">
                                        <?= $perfis[$prev] ?? 'Morador' ?>
                                    </span>
                                </td>
                                <td style="padding: 10px 12px; text-align: center;">
                                    <form action="<?= BASE_URL ?>/moradores/gestao/salvar" method="POST"
                                          style="display: flex; gap: 6px; justify-content: center; align-items: center;"
                                          onsubmit="return confirm('Confirma a alteração do privilégio?')">
                                        <input type="hidden" name="id_morador" value="<?= $m['id_user'] ?>">
                                        <select name="previlegio" style="padding: 5px 8px; border-radius: 7px; border: 1px solid var(--border); font-size: 13px;">
                                            <option value="1" <?= $prev == 1 ? 'selected' : '' ?>>Morador</option>
                                            <option value="2" <?= $prev == 2 ? 'selected' : '' ?>>Síndico</option>
                                            <option value="3" <?= $prev == 3 ? 'selected' : '' ?>>Porteiro</option>
                                            <option value="4" <?= $prev == 4 ? 'selected' : '' ?>>Admin</option>
                                        </select>
                                        <button type="submit" class="btn-primary" style="padding: 5px 12px; font-size: 12px;">
                                            Salvar
                                        </button>
                                    </form>
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

<script>
function filtrarMoradores() {
    const termo = document.getElementById('busca').value.toLowerCase();
    document.querySelectorAll('#tabelaMoradores tr').forEach(row => {
        const nome  = row.dataset.nome  ?? '';
        const apto  = row.dataset.apto  ?? '';
        const bloco = row.dataset.bloco ?? '';
        row.style.display = (nome.includes(termo) || apto.includes(termo) || bloco.includes(termo)) ? '' : 'none';
    });
}
</script>

<?php require_once __DIR__ . '/../../layout/footer.php'; ?>