<?php
$paginaTitulo = 'Novos Usuários';
$paginaAtiva  = 'moradores';
$cssTela      = 'moradores.css';
$jsExtra      = 'moradores.js';
require_once __DIR__ . '/../layout/header.php';

$queryAtual   = $_GET;
$ordenarAtual = $filtros['ordenar'] ?? 'nome';
$direcaoAtual = $filtros['direcao'] ?? 'asc';

function montarOrdenacao(array $queryAtual, string $campo, string $ordenarAtual, string $direcaoAtual): string
{
    $queryAtual['ordenar'] = $campo;
    $queryAtual['direcao'] = ($ordenarAtual === $campo && $direcaoAtual === 'asc') ? 'desc' : 'asc';
    $queryAtual['pagina']  = 1;
    return '?' . http_build_query($queryAtual);
}
?>

<main class="main-content">
    <div class="df-page pendentes-page">
        <div class="page-header">
            <h2>Solicitações de Acesso</h2>
            <p class="text-muted">Aprove ou negue os cadastros pendentes</p>
        </div>

        <?php if (isset($_GET['status'])): ?>
            <div class="df-alert df-alert-<?= $_GET['status'] === 'liberado' ? 'success' : 'warning' ?>">
                Cadastro <?= $_GET['status'] === 'liberado' ? 'liberado' : 'recusado' ?> com sucesso.
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['erro_pendentes'])): ?>
            <div class="df-alert df-alert-error">
                <?= htmlspecialchars($_SESSION['erro_pendentes']) ?>
                <?php unset($_SESSION['erro_pendentes']); ?>
            </div>
        <?php endif; ?>

        <div class="df-card pendentes-filtros">
            <form method="GET" action="<?= BASE_URL ?>/moradores/pendentes" class="row g-3 align-items-end">
                <div class="col-md-2">
                    <div class="df-field">
                        <label for="nome">Nome</label>
                        <input type="text" name="nome" id="nome"
                            value="<?= htmlspecialchars($filtros['nome'] ?? '') ?>" placeholder="Buscar por nome...">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="df-field">
                        <label for="perfil">Perfil</label>
                        <select name="perfil" id="perfil">
                            <option value="">Todos</option>
                            <option value="1" <?= ($filtros['perfil'] ?? '') === '1' ? 'selected' : '' ?>>Morador</option>
                            <option value="3" <?= ($filtros['perfil'] ?? '') === '3' ? 'selected' : '' ?>>Porteiro</option>
                            <option value="2" <?= ($filtros['perfil'] ?? '') === '2' ? 'selected' : '' ?>>Síndico</option>
                            <option value="4" <?= ($filtros['perfil'] ?? '') === '4' ? 'selected' : '' ?>>Administrador</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="df-field">
                        <label for="bloco">Bloco</label>
                        <input type="text" name="bloco" id="bloco"
                            value="<?= htmlspecialchars($filtros['bloco'] ?? '') ?>" placeholder="Ex: A">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="df-field">
                        <label for="apto">Apto</label>
                        <input type="text" name="apto" id="apto"
                            value="<?= htmlspecialchars($filtros['apto'] ?? '') ?>" placeholder="Ex: 101">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="df-field">
                        <label for="cpf">CPF</label>
                        <input type="text" name="cpf" id="cpf"
                            value="<?= htmlspecialchars($filtros['cpf'] ?? '') ?>" placeholder="Buscar por CPF...">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="df-field">
                        <label for="data_solicitacao">Data</label>
                        <input type="date" name="data_solicitacao" id="data_solicitacao"
                            value="<?= htmlspecialchars($filtros['data_solicitacao'] ?? '') ?>">
                    </div>
                </div>
                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn-primary">Filtrar</button>
                    <a href="<?= BASE_URL ?>/moradores/pendentes" class="btn-ghost">Limpar</a>
                </div>
            </form>
        </div>

        <div class="df-card pendentes-lista">
            <?php if (empty($moradores)): ?>
                <div class="empty-state">
                    <i class='bx bx-check-shield'></i>
                    <h5>Tudo em dia!</h5>
                    <p>Nenhuma solicitação pendente no momento.</p>
                </div>
            <?php else: ?>
                <div class="pendentes-table-wrap">
                    <table class="df-table pendentes-table">
                        <thead>
                            <tr>
                                <th>
                                    <a href="<?= montarOrdenacao($queryAtual, 'nome', $ordenarAtual, $direcaoAtual) ?>"
                                        class="link-ordenacao">Nome</a>
                                </th>
                                <th>
                                    <a href="<?= montarOrdenacao($queryAtual, 'cpf', $ordenarAtual, $direcaoAtual) ?>"
                                        class="link-ordenacao">CPF</a>
                                </th>
                                <th>
                                    <a href="<?= montarOrdenacao($queryAtual, 'bloco', $ordenarAtual, $direcaoAtual) ?>"
                                        class="link-ordenacao">Bloco</a>
                                </th>
                                <th>Apto</th>
                                <th>Perfil</th>
                                <th>Solicitação</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($moradores as $m): ?>
                                <?php
                                    $formId = 'pendente-form-' . (int) $m['id_user'];
                                    $cpf = preg_replace('/\D/', '', (string)($m['cpf'] ?? ''));
                                    $cpfMask = strlen($cpf) >= 5
                                        ? substr($cpf, 0, 3) . '.***.***-' . substr($cpf, -2)
                                        : '***';
                                    $perfis = [
                                        1 => ['Morador', 'perfil-badge-morador'],
                                        2 => ['Síndico', 'perfil-badge-sindico'],
                                        3 => ['Porteiro', 'perfil-badge-porteiro'],
                                        4 => ['Admin', 'perfil-badge-admin'],
                                    ];
                                    $p = (int)($m['privilegio'] ?? 1);
                                ?>
                                <tr>
                                    <td>
                                        <strong><?= htmlspecialchars($m['nome']) ?></strong>
                                    </td>
                                    <td>
                                        <div class="cpf-cell">
                                            <span class="cpf-mask"><?= htmlspecialchars($cpfMask) ?></span>
                                            <span class="cpf-real" hidden></span>
                                            <button type="button" class="btn-ghost btn-cpf-toggle"
                                                data-uuid="<?= htmlspecialchars($m['uuid']) ?>"
                                                aria-label="Mostrar CPF">
                                                <i class='bx bx-show'></i>
                                            </button>
                                        </div>
                                    </td>
                                    <td>
                                        <input class="morador-unidade-input js-bloco-input" form="<?= $formId ?>"
                                            type="text" name="bloco" maxlength="1" pattern="[A-Za-z]"
                                            value="<?= htmlspecialchars($m['bloco']) ?>" required>
                                    </td>
                                    <td>
                                        <input class="morador-unidade-input js-apto-input" form="<?= $formId ?>"
                                            type="text" name="apto" maxlength="4" inputmode="numeric" pattern="\d+"
                                            value="<?= htmlspecialchars($m['apto']) ?>" required>
                                    </td>
                                    <td>
                                        <span class="<?= $perfis[$p][1] ?? 'perfil-badge-morador' ?>">
                                            <?= $perfis[$p][0] ?? 'Morador' ?>
                                        </span>
                                    </td>
                                    <td><?= !empty($m['created_at']) ? date('d/m/Y', strtotime($m['created_at'])) : '-' ?></td>
                                    <td class="pendentes-acoes-cell">
                                        <form id="<?= $formId ?>" action="<?= BASE_URL ?>/moradores/liberar" method="POST"
                                            class="pendentes-acoes">
                                            <input type="hidden" name="uuid_morador" value="<?= htmlspecialchars($m['uuid']) ?>">
                                            <input type="hidden" name="acao" value="">
                                            <input type="hidden" name="admin_senha" value="">
                                            <button type="button" data-action-value="aceitar"
                                                class="btn-success-sm js-confirm-admin"
                                                data-title="Aceitar cadastro"
                                                data-message="Aceitar <?= htmlspecialchars($m['nome']) ?>? Informe sua senha para confirmar.">Aceitar</button>
                                            <button type="button" data-action-value="recusar"
                                                class="btn-danger-sm js-confirm-admin"
                                                data-title="Recusar cadastro"
                                                data-message="Recusar o cadastro de <strong><?= htmlspecialchars($m['nome']) ?></strong> irá anonimizar os dados pessoais e liberar o CPF para uma nova solicitação. Informe sua senha para confirmar.">Recusar</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <?php if ($totalPaginas > 1): ?>
                    <nav class="mt-3 d-flex justify-content-center pb-3">
                        <ul class="pagination">
                            <li class="page-item <?= $pagina <= 1 ? 'disabled' : '' ?>">
                                <a class="page-link"
                                    href="?<?= http_build_query(array_merge($_GET, ['pagina' => $pagina - 1])) ?>">
                                    Anterior
                                </a>
                            </li>

                            <?php
                            $range = 2;
                            for ($i = 1; $i <= $totalPaginas; $i++):
                                $mostrar = (
                                    $i == 1 ||
                                    $i == $totalPaginas ||
                                    ($i >= $pagina - $range && $i <= $pagina + $range)
                                );
                                if (!$mostrar):
                                    if ($i == 2 || $i == $totalPaginas - 1):
                            ?>
                                        <li class="page-item disabled">
                                            <span class="page-link">...</span>
                                        </li>
                                <?php
                                    endif;
                                    continue;
                                endif;
                                ?>
                                <li class="page-item <?= $i === $pagina ? 'active' : '' ?>">
                                    <a class="page-link"
                                        href="?<?= http_build_query(array_merge($_GET, ['pagina' => $i])) ?>">
                                        <?= $i ?>
                                    </a>
                                </li>
                            <?php endfor; ?>

                            <li class="page-item <?= $pagina >= $totalPaginas ? 'disabled' : '' ?>">
                                <a class="page-link"
                                    href="?<?= http_build_query(array_merge($_GET, ['pagina' => $pagina + 1])) ?>">
                                    Próximo
                                </a>
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
            <label for="confirmAdminPassword">Senha</label>
            <input type="password" id="confirmAdminPassword" autocomplete="current-password">
        </div>
        <div class="gestao-modal-actions">
            <button type="button" class="btn-ghost" data-modal-close>Cancelar</button>
            <button type="button" class="btn-primary" id="confirmAdminSubmit">Confirmar</button>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
