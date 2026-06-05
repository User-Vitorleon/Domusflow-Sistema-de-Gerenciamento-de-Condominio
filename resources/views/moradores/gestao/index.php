<?php
$paginaTitulo = 'Gestão de Moradores';
$paginaAtiva  = 'gestao-moradores';
$cssTela      = 'moradores.css';
require_once __DIR__ . '/../../layout/header.php';

$labelStatus = [
    'L' => ['texto' => 'Ativo',     'classe' => 'perfil-badge-ativo'],
    'P' => ['texto' => 'Pendente',  'classe' => 'perfil-badge-pendente'],
    'I' => ['texto' => 'Inativo',   'classe' => 'perfil-badge-inativo'],
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
        <?php elseif (isset($_GET['status_ok'])): ?>
            <div class="df-alert df-alert-success">Status atualizado com sucesso!</div>
        <?php elseif (isset($_GET['excluido'])): ?>
            <div class="df-alert df-alert-success">Morador apagado logicamente e dados anonimizados.</div>
        <?php elseif (isset($_GET['senha'])): ?>
            <div class="df-alert df-alert-error">Senha do admin incorreta. A ação não foi executada.</div>
        <?php elseif (isset($_GET['erro'])): ?>
            <div class="df-alert df-alert-error">Ocorreu um erro. Tente novamente.</div>
        <?php endif; ?>

        <div class="df-card" style="margin-bottom: 20px;">
            <form method="GET" action="<?= BASE_URL ?>/moradores/gestao" class="row g-3 align-items-end">
                <div class="col-md-2">
                    <div class="df-field" style="margin:0;">
                        <label>Nome</label>
                        <input type="text" name="nome"
                            value="<?= htmlspecialchars($_GET['nome'] ?? '') ?>" placeholder="Buscar por nome...">
                    </div>
                </div>
                <div class="col-md-1">
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
                            <option value="I" <?= ($_GET['status'] ?? '') === 'I' ? 'selected' : '' ?>>Inativo</option>
                            <option value="B" <?= ($_GET['status'] ?? '') === 'B' ? 'selected' : '' ?>>Bloqueado</option>
                            <option value="E" <?= ($_GET['status'] ?? '') === 'E' ? 'selected' : '' ?>>Excluído</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="df-field" style="margin:0;">
                        <label>Tipo de usuário</label>
                        <select name="perfil">
                            <option value="">Todos</option>
                            <?php foreach ($labelPrivilegio as $valor => $label): ?>
                                <option value="<?= $valor ?>" <?= ($_GET['perfil'] ?? '') === (string) $valor ? 'selected' : '' ?>>
                                    <?= $label ?>
                                </option>
                            <?php endforeach; ?>
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
                                <th style="padding:10px 14px; text-align:left; border-bottom:1px solid var(--border); white-space:nowrap;">Apto / Bloco</th>
                                <th style="padding:10px 14px; text-align:left; border-bottom:1px solid var(--border); white-space:nowrap;">Status</th>
                                <th style="padding:10px 14px; text-align:left; border-bottom:1px solid var(--border); white-space:nowrap;">Perfil</th>
                                <th style="padding:10px 14px; text-align:left; border-bottom:1px solid var(--border); white-space:nowrap;">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($moradores as $m):
                                $st              = $labelStatus[$m['status']] ?? ['texto' => $m['status'], 'classe' => ''];
                                $ehUsuarioLogado = (int)$m['id_user'] === (int)($_SESSION['usuario_id'] ?? 0);
                                $ehAdmin         = (int)($m['privilegio'] ?? 0) === 4;
                            ?>
                                <tr style="border-bottom:1px solid var(--border);">
                                    <td style="padding:10px 14px; white-space:nowrap;">
                                        <strong><?= htmlspecialchars($m['nome']) ?></strong>
                                    </td>
                                    <td style="padding:10px 14px; white-space:nowrap;">
                                        Ap <?= htmlspecialchars($m['apto']) ?> · Bl <?= htmlspecialchars($m['bloco']) ?>
                                    </td>
                                    <td style="padding:10px 14px;">
                                        <span class="<?= $st['classe'] ?>"><?= $st['texto'] ?></span>
                                    </td>
                                    <td style="padding:10px 14px;">
                                        <?php if ($ehAdmin): ?>
                                            <span class="perfil-badge-admin"><?= $labelPrivilegio[(int)$m['privilegio']] ?? 'Admin' ?></span>
                                        <?php else: ?>
                                            <form action="<?= BASE_URL ?>/moradores/gestao/salvar" method="POST"
                                                style="display:flex;gap:6px;align-items:center;">
                                                <input type="hidden" name="id_morador" value="<?= $m['id_user'] ?>">
                                                <input type="hidden" name="admin_senha" value="">
                                                <select name="privilegio" style="font-size:12px;padding:4px 8px;border-radius:var(--radius);border:1px solid var(--border);background:var(--bg-secondary);color:var(--text-primary);">
                                                    <?php foreach ($labelPrivilegio as $val => $label): ?>
                                                        <option value="<?= $val ?>" <?= (int)$m['privilegio'] === $val ? 'selected' : '' ?>>
                                                            <?= $label ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <button type="button" class="btn-primary js-confirm-admin"
                                                    style="padding:4px 12px;font-size:12px;white-space:nowrap;"
                                                    data-title="Alterar perfil"
                                                    data-message="Alterar o perfil de <?= htmlspecialchars($m['nome']) ?>? Informe sua senha para confirmar.">
                                                    Salvar
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </td>
                                    <td class="gestao-acoes-cell" style="padding:10px 14px;">
                                        <div class="gestao-acoes">
                                            <?php if ($m['status'] !== 'E'): ?>
                                                <form action="<?= BASE_URL ?>/moradores/gestao/resetar-senha" method="POST" class="gestao-action-form">
                                                    <input type="hidden" name="id_morador" value="<?= $m['id_user'] ?>">
                                                    <input type="hidden" name="admin_senha" value="">
                                                    <button type="button" class="btn-ghost gestao-btn js-confirm-admin"
                                                        data-title="Resetar senha"
                                                        data-message="Resetar a senha de <?= htmlspecialchars($m['nome']) ?>? Uma nova senha será enviada por e-mail.">
                                                        <i class='bx bx-reset'></i> Resetar Senha
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                            <?php if (!$ehUsuarioLogado && $m['status'] !== 'E'): ?>
                                                <form action="<?= BASE_URL ?>/moradores/gestao/status" method="POST" class="gestao-action-form">
                                                    <input type="hidden" name="id_morador" value="<?= $m['id_user'] ?>">
                                                    <input type="hidden" name="status" value="I">
                                                    <input type="hidden" name="admin_senha" value="">
                                                    <button type="button" class="btn-ghost gestao-btn gestao-btn-warning js-confirm-admin"
                                                        data-title="Inativar morador"
                                                        data-message="Inativar <?= htmlspecialchars($m['nome']) ?>? O morador não conseguirá acessar o sistema."
                                                        <?= $m['status'] === 'I' ? 'disabled' : '' ?>>
                                                        <i class='bx bx-pause-circle'></i> Inativar
                                                    </button>
                                                </form>
                                                <form action="<?= BASE_URL ?>/moradores/gestao/status" method="POST" class="gestao-action-form">
                                                    <input type="hidden" name="id_morador" value="<?= $m['id_user'] ?>">
                                                    <input type="hidden" name="status" value="B">
                                                    <input type="hidden" name="admin_senha" value="">
                                                    <button type="button" class="btn-ghost gestao-btn js-confirm-admin"
                                                        data-title="Bloquear morador"
                                                        data-message="Bloquear <?= htmlspecialchars($m['nome']) ?>? O acesso será negado imediatamente."
                                                        <?= $m['status'] === 'B' ? 'disabled' : '' ?>>
                                                        <i class='bx bx-block'></i> Bloquear
                                                    </button>
                                                </form>
                                                <?php if (in_array($m['status'], ['I', 'B'], true)): ?>
                                                    <form action="<?= BASE_URL ?>/moradores/gestao/status" method="POST" class="gestao-action-form">
                                                        <input type="hidden" name="id_morador" value="<?= $m['id_user'] ?>">
                                                        <input type="hidden" name="status" value="L">
                                                        <input type="hidden" name="admin_senha" value="">
                                                        <button type="button" class="btn-success-sm gestao-btn js-confirm-admin"
                                                            data-title="Reativar morador"
                                                            data-message="Reativar <?= htmlspecialchars($m['nome']) ?>? O acesso ao sistema será liberado novamente.">
                                                            <i class='bx bx-check-circle'></i> Reativar
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                                <form action="<?= BASE_URL ?>/moradores/gestao/deletar" method="POST" class="gestao-action-form">
                                                    <input type="hidden" name="id_morador" value="<?= $m['id_user'] ?>">
                                                    <input type="hidden" name="admin_senha" value="">
                                                    <button type="button" class="btn-danger-sm gestao-btn js-confirm-admin"
                                                        data-title="Apagar morador"
                                                        data-message="Atenção: apagar <?= htmlspecialchars($m['nome']) ?> é irreversível. Os dados pessoais serão anonimizados.">
                                                        <i class='bx bx-trash'></i> Apagar
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if ($totalPaginas > 1):
                    $range     = 2;
                    $queryBase = http_build_query(array_filter([
                        'nome'   => $_GET['nome']   ?? '',
                        'apto'   => $_GET['apto']   ?? '',
                        'bloco'  => $_GET['bloco']  ?? '',
                        'status' => $filtros['status'] ?? '',
                        'perfil' => $filtros['perfil'] ?? '',
                    ]));
                    $base = BASE_URL . '/moradores/gestao?' . ($queryBase ? $queryBase . '&' : '');
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

<div class="gestao-modal" id="confirmAdminModal" aria-hidden="true">
    <div class="gestao-modal-backdrop" data-modal-close></div>
    <div class="gestao-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="confirmAdminTitle">
        <button type="button" class="gestao-modal-close" data-modal-close aria-label="Fechar">
            <i class='bx bx-x'></i>
        </button>
        <h3 id="confirmAdminTitle">Confirmar ação</h3>
        <p id="confirmAdminMessage">Informe sua senha para continuar.</p>
        <div class="df-field gestao-modal-field">
            <label for="confirmAdminPassword">Senha do admin</label>
            <input type="password" id="confirmAdminPassword" autocomplete="current-password">
        </div>
        <div class="gestao-modal-actions">
            <button type="button" class="btn-ghost" data-modal-close>Cancelar</button>
            <button type="button" class="btn-primary" id="confirmAdminSubmit">Confirmar</button>
        </div>
    </div>
</div>

<script>
    const adminModal = document.getElementById('confirmAdminModal');
    const adminPassword = document.getElementById('confirmAdminPassword');
    const adminTitle = document.getElementById('confirmAdminTitle');
    const adminMessage = document.getElementById('confirmAdminMessage');
    const adminSubmit = document.getElementById('confirmAdminSubmit');
    let pendingAdminForm = null;

    function closeAdminModal() {
        adminModal.classList.remove('is-open');
        adminModal.setAttribute('aria-hidden', 'true');
        adminPassword.value = '';
        pendingAdminForm = null;
    }

    document.querySelectorAll('.js-confirm-admin').forEach((button) => {
        button.addEventListener('click', () => {
            if (button.disabled) return;

            pendingAdminForm = button.closest('form');
            adminTitle.textContent = button.dataset.title || 'Confirmar ação';
            adminMessage.textContent = button.dataset.message || 'Informe sua senha para continuar.';
            adminModal.classList.add('is-open');
            adminModal.setAttribute('aria-hidden', 'false');
            adminPassword.focus();
        });
    });

    document.querySelectorAll('[data-modal-close]').forEach((button) => {
        button.addEventListener('click', closeAdminModal);
    });

    adminPassword.addEventListener('keydown', (event) => {
        if (event.key === 'Enter') {
            adminSubmit.click();
        }
    });

    adminSubmit.addEventListener('click', () => {
        if (!pendingAdminForm || adminPassword.value.trim() === '') {
            adminPassword.focus();
            return;
        }

        pendingAdminForm.querySelector('input[name="admin_senha"]').value = adminPassword.value;
        pendingAdminForm.submit();
    });
</script>

<?php require_once __DIR__ . '/../../layout/footer.php'; ?>
