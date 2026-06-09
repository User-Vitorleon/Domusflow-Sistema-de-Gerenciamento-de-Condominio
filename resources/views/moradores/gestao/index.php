<?php
$paginaTitulo = 'Gestão de Moradores';
$paginaAtiva  = 'gestao-moradores';
$cssTela      = 'moradores.css';
$jsExtra      = 'moradores.js';
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

        <div class="df-card gestao-filtros-card">
            <form method="GET" action="<?= BASE_URL ?>/moradores/gestao" class="row g-3 align-items-end">
                <div class="col-md-2">
                    <div class="df-field gestao-filtro-field">
                        <label>Nome</label>
                        <input type="text" name="nome"
                            value="<?= htmlspecialchars($_GET['nome'] ?? '') ?>" placeholder="Buscar por nome...">
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="df-field gestao-filtro-field">
                        <label>Apto</label>
                        <input type="text" name="apto"
                            value="<?= htmlspecialchars($_GET['apto'] ?? '') ?>" placeholder="Ex: 101">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="df-field gestao-filtro-field">
                        <label>Bloco</label>
                        <input type="text" name="bloco"
                            value="<?= htmlspecialchars($_GET['bloco'] ?? '') ?>" placeholder="Ex: A">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="df-field gestao-filtro-field">
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
                    <div class="df-field gestao-filtro-field">
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
                <div class="col-md-3 d-flex gap-2 align-items-end gestao-filtros-actions">
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
                <div class="gestao-table-wrap">
                    <table class="df-table gestao-table">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Apto / Bloco</th>
                                <th>Status</th>
                                <th>Perfil</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($moradores as $m):
                                $st              = $labelStatus[$m['status']] ?? ['texto' => $m['status'], 'classe' => ''];
                                $ehUsuarioLogado = (int)$m['id_user'] === (int)($_SESSION['usuario_id'] ?? 0);
                                $ehAdmin         = (int)($m['privilegio'] ?? 0) === 4;
                                $formPerfilId    = 'gestao-perfil-form-' . (int) $m['id_user'];
                            ?>
                                <tr>
                                    <td class="gestao-nowrap">
                                        <strong><?= htmlspecialchars($m['nome']) ?></strong>
                                    </td>
                                    <td class="gestao-nowrap">
                                        <?php if ($ehAdmin): ?>
                                            Ap <?= htmlspecialchars($m['apto']) ?> · Bl <?= htmlspecialchars($m['bloco']) ?>
                                        <?php else: ?>
                                            <div class="gestao-unidade-edit">
                                                <label>Ap
                                                    <input class="morador-unidade-input js-apto-input" form="<?= $formPerfilId ?>"
                                                        type="text" name="apto" maxlength="4" inputmode="numeric" pattern="\d+"
                                                        value="<?= htmlspecialchars($m['apto']) ?>" required>
                                                </label>
                                                <label>Bl
                                                    <input class="morador-unidade-input js-bloco-input" form="<?= $formPerfilId ?>"
                                                        type="text" name="bloco" maxlength="1" pattern="[A-Za-z]"
                                                        value="<?= htmlspecialchars($m['bloco']) ?>" required>
                                                </label>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="<?= $st['classe'] ?>"><?= $st['texto'] ?></span>
                                    </td>
                                    <td>
                                        <?php if ($ehAdmin): ?>
                                            <span class="perfil-badge-admin"><?= $labelPrivilegio[(int)$m['privilegio']] ?? 'Admin' ?></span>
                                        <?php else: ?>
                                            <form id="<?= $formPerfilId ?>" action="<?= BASE_URL ?>/moradores/gestao/salvar" method="POST"
                                                class="gestao-perfil-form">
                                                <input type="hidden" name="uuid_morador" value="<?= htmlspecialchars($m['uuid']) ?>">
                                                <input type="hidden" name="admin_senha" value="">
                                                <select name="privilegio" class="gestao-perfil-select">
                                                    <?php foreach ($labelPrivilegio as $val => $label): ?>
                                                        <option value="<?= $val ?>" <?= (int)$m['privilegio'] === $val ? 'selected' : '' ?>>
                                                            <?= $label ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <button type="button" class="btn-primary js-confirm-admin gestao-perfil-save"
                                                    data-title="Alterar perfil"
                                                    data-message="Alterar o perfil de <?= htmlspecialchars($m['nome']) ?>? Informe sua senha para confirmar.">
                                                    Salvar
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </td>
                                    <td class="gestao-acoes-cell">
                                        <div class="gestao-acoes">
                                            <?php if ($ehAdmin): ?>
                                                <span class="gestao-protected-admin">Conta administrativa protegida</span>
                                            <?php elseif ($m['status'] !== 'E'): ?>
                                                <form action="<?= BASE_URL ?>/moradores/gestao/resetar-senha" method="POST" class="gestao-action-form">
                                                    <input type="hidden" name="uuid_morador" value="<?= htmlspecialchars($m['uuid']) ?>">
                                                    <input type="hidden" name="admin_senha" value="">
                                                    <button type="button" class="btn-ghost gestao-btn js-confirm-admin"
                                                        data-title="Resetar senha"
                                                        data-message="Resetar a senha de <?= htmlspecialchars($m['nome']) ?>? Uma nova senha será enviada por e-mail.">
                                                        <i class='bx bx-reset'></i> Resetar Senha
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                            <?php if (!$ehAdmin && !$ehUsuarioLogado && $m['status'] !== 'E'): ?>
                                                <form action="<?= BASE_URL ?>/moradores/gestao/status" method="POST" class="gestao-action-form">
                                                    <input type="hidden" name="uuid_morador" value="<?= htmlspecialchars($m['uuid']) ?>">
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
                                                    <input type="hidden" name="uuid_morador" value="<?= htmlspecialchars($m['uuid']) ?>">
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
                                                        <input type="hidden" name="uuid_morador" value="<?= htmlspecialchars($m['uuid']) ?>">
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
                                                    <input type="hidden" name="uuid_morador" value="<?= htmlspecialchars($m['uuid']) ?>">
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

<?php require_once __DIR__ . '/../../layout/footer.php'; ?>

