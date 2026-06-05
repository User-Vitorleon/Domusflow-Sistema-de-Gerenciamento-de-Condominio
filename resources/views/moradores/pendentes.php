<?php
$paginaTitulo = 'Novos Usuários';
$paginaAtiva  = 'moradores';
$cssTela      = 'moradores.css';
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
                Morador <?= $_GET['status'] === 'liberado' ? 'liberado' : 'negado' ?> com sucesso.
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
                <div style="overflow-x: auto;">
                    <table class="df-table pendentes-table" style="width:100%; border-collapse:collapse; font-size:13px;">
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
                                            <span class="cpf-real" style="display:none;"><?= htmlspecialchars($m['cpf']) ?></span>
                                            <button type="button" class="btn-ghost btn-cpf-toggle" onclick="toggleCpf(this)" aria-label="Mostrar CPF">
                                                <i class='bx bx-show'></i>
                                            </button>
                                        </div>
                                    </td>
                                    <td><?= htmlspecialchars($m['bloco']) ?></td>
                                    <td><?= htmlspecialchars($m['apto']) ?></td>
                                    <td>
                                        <span class="<?= $perfis[$p][1] ?? 'perfil-badge-morador' ?>">
                                            <?= $perfis[$p][0] ?? 'Morador' ?>
                                        </span>
                                    </td>
                                    <td><?= !empty($m['created_at']) ? date('d/m/Y', strtotime($m['created_at'])) : '-' ?></td>
                                    <td class="pendentes-acoes-cell">
                                        <form action="<?= BASE_URL ?>/moradores/liberar" method="POST"
                                            class="pendentes-acoes">
                                            <input type="hidden" name="id_morador" value="<?= $m['id_user'] ?>">
                                            <button type="submit" name="acao" value="aceitar"
                                                class="btn-success-sm">Aceitar</button>
                                            <button type="submit" name="acao" value="negar"
                                                class="btn-danger-sm">Negar</button>
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

<script>
function toggleCpf(btn) {
    const td = btn.closest('.cpf-cell');
    const mask = td.querySelector('.cpf-mask');
    const real = td.querySelector('.cpf-real');
    const icon = btn.querySelector('i');

    if (mask.style.display === 'none') {
        mask.style.display = '';
        real.style.display = 'none';
        icon.className = 'bx bx-show';
        btn.setAttribute('aria-label', 'Mostrar CPF');
    } else {
        mask.style.display = 'none';
        real.style.display = '';
        icon.className = 'bx bx-hide';
        btn.setAttribute('aria-label', 'Ocultar CPF');
    }
}
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
