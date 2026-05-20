<?php
$paginaTitulo = 'Novos Usuários';
$paginaAtiva  = 'moradores';
$cssTela      = 'moradores.css';
require_once __DIR__ . '/../layout/header.php';
?>

<main class="main-content">
    <div class="container py-4 pagina-pendentes">
        <div class="page-header mb-4">
            <h2>Solicitações de Acesso</h2>
            <p class="text-muted">Aprove ou negue os cadastros pendentes</p>
        </div>

        <?php
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

        <?php if (isset($_GET['status'])): ?>
            <div class="df-alert df-alert-<?= $_GET['status'] === 'liberado' ? 'success' : 'warning' ?>">
                Morador <?= $_GET['status'] === 'liberado' ? 'liberado' : 'negado' ?> com sucesso.
            </div>
        <?php endif; ?>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <form method="GET" action="<?= BASE_URL ?>/moradores/pendentes" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" name="nome" id="nome" class="form-control"
                            value="<?= htmlspecialchars($filtros['nome'] ?? '') ?>">
                    </div>
                    <div class="col-md-2">
                        <label for="bloco" class="form-label">Bloco</label>
                        <input type="text" name="bloco" id="bloco" class="form-control"
                            value="<?= htmlspecialchars($filtros['bloco'] ?? '') ?>">
                    </div>
                    <div class="col-md-2">
                        <label for="apto" class="form-label">Apto</label>
                        <input type="text" name="apto" id="apto" class="form-control"
                            value="<?= htmlspecialchars($filtros['apto'] ?? '') ?>">
                    </div>
                    <div class="col-md-2">
                        <label for="cpf" class="form-label">CPF</label>
                        <input type="text" name="cpf" id="cpf" class="form-control"
                            value="<?= htmlspecialchars($filtros['cpf'] ?? '') ?>">
                    </div>
                    <div class="col-md-2">
                        <label for="data_solicitacao" class="form-label">Data</label>
                        <input type="date" name="data_solicitacao" id="data_solicitacao" class="form-control"
                            value="<?= htmlspecialchars($filtros['data_solicitacao'] ?? '') ?>">
                    </div>
                    <div class="col-12 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Filtrar</button>
                        <a href="<?= BASE_URL ?>/moradores/pendentes" class="btn btn-outline-secondary">Limpar</a>
                    </div>
                </form>
            </div>
        </div>

        <?php if (empty($moradores)): ?>
            <div class="empty-state">
                <i class='bx bx-check-shield'></i>
                <h5>Tudo em dia!</h5>
                <p>Nenhuma solicitação pendente no momento.</p>
            </div>
        <?php else: ?>
            <div class="card shadow-sm border-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
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
                                <th>Solicitação</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($moradores as $m): ?>
                                <tr>
                                    <td><?= (int)$m['id_user'] ?></td>
                                    <td><?= htmlspecialchars($m['nome']) ?></td>
                                    <td><?= htmlspecialchars($m['cpf']) ?></td>
                                    <td><?= htmlspecialchars($m['bloco']) ?></td>
                                    <td><?= htmlspecialchars($m['apto']) ?></td>
                                    <td><?= !empty($m['created_at']) ? date('d/m/Y', strtotime($m['created_at'])) : '-' ?></td>
                                    <td class="text-center">
                                        <form action="<?= BASE_URL ?>/moradores/liberar" method="POST"
                                            class="d-inline-flex gap-2">
                                            <input type="hidden" name="id_morador" value="<?= $m['id_user'] ?>">
                                            <button type="submit" name="acao" value="aceitar"
                                                class="btn btn-success btn-sm">Aceitar</button>
                                            <button type="submit" name="acao" value="negar"
                                                class="btn btn-danger btn-sm">Negar</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php if ($totalPaginas > 1): ?>
                <nav class="mt-4 d-flex justify-content-center">
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
</main>

<<<<<<< HEAD
<?php require_once __DIR__ . '/../layout/footer.php'; ?>
=======
<?php require_once __DIR__ . '/../layout/footer.php'; ?>
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
