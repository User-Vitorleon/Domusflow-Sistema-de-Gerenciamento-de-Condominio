<?php
$paginaTitulo = 'Gestão de Moradores';
$paginaAtiva  = 'gestao-moradores';
require_once __DIR__ . '/../../layout/header.php';

$labelStatus = [
    'L' => ['texto' => 'Ativo',     'classe' => 'perfil-badge-sindico'],
    'P' => ['texto' => 'Pendente',  'classe' => 'perfil-badge-funcionario'],
    'B' => ['texto' => 'Bloqueado', 'classe' => 'perfil-badge-bloqueado'],
    'E' => ['texto' => 'Excluído',  'classe' => 'perfil-badge-bloqueado'],
];
$labelPrivilegio = [1 => 'Morador', 2 => 'Síndico', 3 => 'Porteiro', 4 => 'Admin'];
?>

<main class="main-content">
<div class="df-page">

    <div class="page-header">
        <h2>Gestão de Moradores</h2>
    </div>

    <?php if (isset($_GET['sucesso'])): ?>
        <div class="df-alert df-alert-success">Privilégio atualizado com sucesso!</div>
    <?php elseif (isset($_GET['reset'])): ?>
        <div class="df-alert df-alert-success">Senha resetada e enviada por e-mail!</div>
    <?php elseif (isset($_GET['erro'])): ?>
        <div class="df-alert df-alert-error">Ocorreu um erro. Tente novamente.</div>
    <?php endif; ?>
    
    <div class="df-card" style="margin-bottom: 20px;">
    <form method="GET" action="<?= BASE_URL ?>/moradores/gestao" class="row g-3 align-items-end">
        <div class="col-md-3">
            <div class="df-field" style="margin:0;">
                <label>Nome</label>
                <input type="text" name="nome"
                    value="<?= htmlspecialchars($_GET['nome'] ?? '') ?>" placeholder="Buscar por nome...">
            </div>
        </div>
        <div class="col-md-2">
            <div class="df-field" style="margin:0;">
                <label>Apto</label>
                <input type="text" name="apto"
                    value="<?= htmlspecialchars($_GET['apto'] ?? '') ?>" placeholder="Ex: 101">
            </div>
        </div>
        <div class="col-md-2">
            <div class="df-field" style="margin:0;">
                <label>Bloco</label>
                <input type="text" name="bloco"
                    value="<?= htmlspecialchars($_GET['bloco'] ?? '') ?>" placeholder="Ex: A">
            </div>
        </div>
        <div class="col-md-2">
            <div class="df-field" style="margin:0;">
                <label>Status</label>
                <select name="status">
                    <option value="">Todos</option>
                    <option value="L" <?= ($_GET['status'] ?? '') === 'L' ? 'selected' : '' ?>>Ativo</option>
                    <option value="P" <?= ($_GET['status'] ?? '') === 'P' ? 'selected' : '' ?>>Pendente</option>
                    <option value="B" <?= ($_GET['status'] ?? '') === 'B' ? 'selected' : '' ?>>Bloqueado</option>
                </select>
            </div>
        </div>
        <div class="col-md-3 d-flex gap-2 align-items-end" style="padding-bottom: 1px;">
            <button type="submit" class="btn-primary">Filtrar</button>
            <a href="<?= BASE_URL ?>/moradores/gestao" class="btn-ghost">Limpar</a>
        </div>
    </form>
</div>

<div class="df-card">
    <?php if (empty($moradores)): ?>
        <div class="empty-state">
            <i class='bx bx-user-x'></i>
            <h5>Nenhum morador encontrado</h5>
        </div>
    <?php else: ?>
    <div style="overflow-x: auto;">
        <table class="df-table" style="width:100%; border-collapse:collapse; font-size:13px;">
            <thead>
                <tr>
                    <th style="padding:10px 14px; text-align:left; border-bottom:1px solid var(--border); white-space:nowrap;">Nome</th>
                    <th style="padding:10px 14px; text-align:left; border-bottom:1px solid var(--border); white-space:nowrap;">CPF</th>
                    <th style="padding:10px 14px; text-align:left; border-bottom:1px solid var(--border); white-space:nowrap;">Apto / Bloco</th>
                    <th style="padding:10px 14px; text-align:left; border-bottom:1px solid var(--border); white-space:nowrap;">Status</th>
                    <th style="padding:10px 14px; text-align:left; border-bottom:1px solid var(--border); white-space:nowrap;">Perfil</th>
                    <th style="padding:10px 14px; text-align:left; border-bottom:1px solid var(--border); white-space:nowrap;">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($moradores as $m):
                    $cpf     = $m['cpf'];
                    $cpfMask = substr($cpf,0,3) . '.***.***-' . substr($cpf,-2);
                    $st      = $labelStatus[$m['status']] ?? ['texto' => $m['status'], 'classe' => ''];
                ?>
                <tr style="border-bottom:1px solid var(--border);">
                    <td style="padding:10px 14px; white-space:nowrap;">
                        <strong><?= htmlspecialchars($m['nome']) ?></strong>
                    </td>
                    <td style="padding:10px 14px; white-space:nowrap;">
                        <span class="cpf-mask"><?= $cpfMask ?></span>
                        <span class="cpf-real" style="display:none;"><?= htmlspecialchars($cpf) ?></span>
                        <button type="button" class="btn-ghost" style="padding:2px 6px;font-size:11px;" onclick="toggleCpf(this)">
                            <i class='bx bx-show'></i>
                        </button>
                    </td>
                    <td style="padding:10px 14px; white-space:nowrap;">
                        Ap <?= htmlspecialchars($m['apto']) ?> · Bl <?= htmlspecialchars($m['bloco']) ?>
                    </td>
                    <td style="padding:10px 14px;">
                        <span class="<?= $st['classe'] ?>"><?= $st['texto'] ?></span>
                    </td>
                    <td style="padding:10px 14px;">
                        <form action="<?= BASE_URL ?>/moradores/gestao/salvar" method="POST"
                            style="display:flex;gap:6px;align-items:center;">
                            <input type="hidden" name="id_morador" value="<?= $m['id_user'] ?>">
                            <select name="privilegio" style="font-size:12px;padding:4px 8px;border-radius:var(--radius);border:1px solid var(--border);background:var(--bg-secondary);color:var(--text-primary);">
                                <?php foreach ($labelPrivilegio as $val => $label): ?>
                                    <option value="<?= $val ?>" <?= (int)$m['privilegio'] === $val ? 'selected' : '' ?>>
                                        <?= $label ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <button type="submit" class="btn-primary" style="padding:4px 12px;font-size:12px;white-space:nowrap;">
                                Salvar
                            </button>
                        </form>
                    </td>
                    <td style="padding:10px 14px;">
                        <form action="<?= BASE_URL ?>/moradores/gestao/resetar-senha" method="POST"
                            onsubmit="return confirm('Resetar senha de <?= htmlspecialchars(addslashes($m['nome'])) ?>?\nUma nova senha será enviada por e-mail.')">
                            <input type="hidden" name="id_morador" value="<?= $m['id_user'] ?>">
                            <button type="submit" class="btn-ghost" style="font-size:12px;white-space:nowrap;">
                                <i class='bx bx-reset'></i> Resetar Senha
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
function toggleCpf(btn) {
    const td   = btn.parentElement;
    const mask = td.querySelector('.cpf-mask');
    const real = td.querySelector('.cpf-real');
    const icon = btn.querySelector('i');
    if (mask.style.display === 'none') {
        mask.style.display = '';
        real.style.display = 'none';
        icon.className = 'bx bx-show';
    } else {
        mask.style.display = 'none';
        real.style.display = '';
        icon.className = 'bx bx-hide';
    }
}
</script>

<?php require_once __DIR__ . '/../../layout/footer.php'; ?>