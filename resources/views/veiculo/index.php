<?php
$paginaTitulo = 'Veículos';
$paginaAtiva  = 'veiculo';
$cssExtra     = 'veiculo.css';
$jsExtra      = 'veiculo.js';
require_once __DIR__ . '/../layout/header.php';
$privilegio = $usuario['privilegio'] ?? 1;

$cores = [
    'Amarelo',
    'Azul',
    'Bege',
    'Bordô',
    'Branco',
    'Cinza',
    'Dourado',
    'Laranja',
    'Marrom',
    'Prata',
    'Preto',
    'Rosa',
    'Roxo',
    'Verde',
    'Vermelho'
];
?>

<main class="main-content">
    <div class="df-page">

        <div class="page-header">
            <h2>Controle de Veículos</h2>
        </div>

        <?php if (isset($_GET['sucesso'])): ?>
            <div class="df-alert df-alert-success">Operação realizada com sucesso!</div>
        <?php endif; ?>

        <?php if (isset($_SESSION['erro_veiculo'])): ?>
            <div class="df-alert df-alert-error"><?= htmlspecialchars($_SESSION['erro_veiculo']) ?></div>
            <?php unset($_SESSION['erro_veiculo']); ?>
        <?php endif; ?>

        <?php if (in_array($privilegio, [1, 2, 3, 4])): ?>
            <div class="df-card" style="margin-bottom: 24px;">
                <h3 class="section-title">Cadastrar Veículo</h3>


                <?php if ($privilegio == 1): ?>
                    <div class="veiculo-counter">
                        <div class="veiculo-counter-bar">
                            <?php for ($i = 1; $i <= $limiteVeiculosMorador; $i++): ?>
                                <div class="veiculo-counter-dot <?= $totalVeiculosMorador >= $i ? 'usado' : '' ?>"></div>
                            <?php endfor; ?>
                        </div>
                        <?= $totalVeiculosMorador ?>/<?= $limiteVeiculosMorador ?> veículos cadastrados
                    </div>
                <?php endif; ?>

                <form action="<?= BASE_URL ?>/veiculo/salvar" method="POST"
                    data-total="<?= $privilegio == 1 ? $totalVeiculosMorador : count($veiculos) ?>"
                    data-limite="<?= $limiteVeiculosMorador ?>"
                    data-prev="<?= $privilegio ?>"
                    data-catalogo-veiculos="<?= htmlspecialchars(json_encode($catalogoVeiculos ?? []), ENT_QUOTES, 'UTF-8') ?>">

                    <div class="df-grid-2">
                        <div class="df-field">
                            <label>Placa</label>
                            <input type="text" name="placa" id="inputPlaca"
                                placeholder="Ex: ABC1234"
                                maxlength="7" required>
                        </div>
                        <div class="df-field">
                            <label>Cor</label>
                            <select name="cor" required>
                                <option value="">Selecione...</option>
                                <?php foreach ($cores as $c): ?>
                                    <option value="<?= $c ?>"><?= $c ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="df-grid-2">
                        <div class="df-field">
                            <label>Marca</label>
                            <select name="marca" id="selectMarcaVeiculo" required>
                                <option value="">Selecione...</option>
                                <?php foreach (array_keys($catalogoVeiculos ?? []) as $marca): ?>
                                    <option value="<?= htmlspecialchars($marca) ?>"><?= htmlspecialchars($marca) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="df-field">
                            <label>Modelo</label>
                            <select name="modelo" id="selectModeloVeiculo" required disabled>
                                <option value="">Selecione a marca primeiro...</option>
                            </select>
                        </div>
                    </div>

                    <?php if (in_array($privilegio, [2, 3, 4])): ?>
                        <div class="df-field">
                            <label>Morador (dono do veículo)</label>
                            <select name="id_user" required>
                                <option value="">Selecione...</option>
                                <?php foreach ($moradores as $m): ?>
                                    <?php if (in_array($m['privilegio'], [1, 2])): ?>
                                        <option value="<?= $m['id_user'] ?>">
                                            <?= htmlspecialchars($m['nome']) ?> — Ap <?= $m['apto'] ?> · Bloco <?= $m['bloco'] ?>
                                        </option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php else: ?>

                        <input type="hidden" name="id_user" value="<?= $usuario['id_user'] ?>">
                    <?php endif; ?>

                    <div class="df-field df-field-check">
                        <input type="checkbox" name="principal" id="principal" value="1">
                        <label for="principal">Definir como veículo principal</label>
                    </div>

                    <div class="df-actions">
                        <button type="reset" class="btn-ghost">Limpar</button>
                        <button type="submit" class="btn-primary">Cadastrar</button>
                    </div>
                </form>
            </div>
        <?php endif; ?>

        <div class="df-card">
            <h3 class="section-title">
                <?= in_array($privilegio, [2, 3, 4]) ? 'Todos os Veículos' : 'Meus Veículos' ?>
            </h3>

            <?php if (in_array($privilegio, [2, 3, 4])): ?>
                <form method="GET" action="<?= BASE_URL ?>/veiculo" class="veiculo-filtros">
                    <div class="df-field">
                        <label>Nome</label>
                        <input type="text" name="nome" placeholder="Morador..."
                            value="<?= htmlspecialchars($filtrosVeiculos['nome'] ?? '') ?>">
                    </div>
                    <div class="df-field">
                        <label>Placa</label>
                        <input type="text" name="placa" placeholder="Ex: ABC1234" maxlength="7"
                            value="<?= htmlspecialchars($filtrosVeiculos['placa'] ?? '') ?>">
                    </div>
                    <div class="df-field">
                        <label>Bloco</label>
                        <input type="text" name="bloco" placeholder="Ex: A"
                            value="<?= htmlspecialchars($filtrosVeiculos['bloco'] ?? '') ?>">
                    </div>
                    <div class="df-field">
                        <label>Apto</label>
                        <input type="text" name="apto" placeholder="Ex: 101"
                            value="<?= htmlspecialchars($filtrosVeiculos['apto'] ?? '') ?>">
                    </div>
                    <div class="df-field">
                        <label>Data cadastro</label>
                        <input type="date" name="data_cadastro"
                            value="<?= htmlspecialchars($filtrosVeiculos['data_cadastro'] ?? '') ?>">
                    </div>
                    <div class="veiculo-filtros-actions">
                        <button type="submit" class="btn-primary">Filtrar</button>
                        <a href="<?= BASE_URL ?>/veiculo" class="btn-ghost">Limpar</a>
                    </div>
                </form>
            <?php endif; ?>

            <?php if (empty($veiculos)): ?>
                <div class="empty-state">
                    <i class="bx bx-car"></i>
                    <h5>Nenhum veículo cadastrado</h5>
                    <p>Os veículos cadastrados aparecerão aqui.</p>
                </div>
            <?php else: ?>
                <div class="table-wrap">
                    <table class="df-table veiculo-table">
                        <thead>
                            <tr>
                                <th>Placa</th>
                                <th>Veículo</th>
                                <th>Cor</th>
                                <?php if (in_array($privilegio, [2, 3, 4])): ?>
                                    <th>Morador</th>
                                    <th>Unidade</th>
                                    <th>Cadastro</th>
                                <?php else: ?>
                                    <th>Status</th>
                                    <th>Data cadastro</th>
                                <?php endif; ?>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($veiculos as $v): ?>
                                <tr>
                                    <td><strong><?= htmlspecialchars($v['placa']) ?></strong></td>
                                    <td>
                                        <strong><?= htmlspecialchars($v['marca']) ?></strong>
                                        <small class="veiculo-subinfo"><?= htmlspecialchars($v['modelo']) ?></small>
                                    </td>
                                    <td><?= htmlspecialchars($v['cor']) ?></td>
                                    <?php if (in_array($privilegio, [2, 3, 4])): ?>
                                        <td>
                                            <?= htmlspecialchars($v['nome_morador']) ?>
                                            <?php if ($v['principal']): ?>
                                                <small class="veiculo-subinfo veiculo-principal-label">Principal</small>
                                            <?php endif; ?>
                                        </td>
                                        <td>Bl <?= htmlspecialchars($v['bloco'] ?? '-') ?> &middot; Ap <?= htmlspecialchars($v['apto'] ?? '-') ?></td>
                                        <td>
                                            <?= !empty($v['created_at']) ? date('d/m/Y', strtotime($v['created_at'])) : '-' ?>
                                            <small class="veiculo-subinfo">por <?= htmlspecialchars($v['cadastrado_por']) ?></small>
                                        </td>
                                    <?php else: ?>
                                        <td>
                                            <?php if ($v['principal']): ?>
                                                <span class="perfil-badge-sindico">Principal</span>
                                            <?php else: ?>
                                                <span class="veiculo-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= !empty($v['created_at']) ? date('d/m/Y', strtotime($v['created_at'])) : '-' ?></td>
                                    <?php endif; ?>
                                    <td>
                                        <?php
                                            $podeExcluir = in_array($privilegio, [2, 4]) ||
                                                ($privilegio == 1 && $v['id_user'] == $usuario['id_user']);
                                            $podeAlterarPrincipal = $podeExcluir;
                                        ?>
                                        <div class="veiculo-row-actions">
                                            <?php if ($podeAlterarPrincipal && !$v['principal']): ?>
                                                <form action="<?= BASE_URL ?>/veiculo/principal" method="POST">
                                                    <input type="hidden" name="id_veiculo" value="<?= $v['id_veiculo'] ?>">
                                                    <button type="submit" class="btn-ghost veiculo-action-btn">Principal</button>
                                                </form>
                                            <?php endif; ?>
                                            <?php if ($podeExcluir): ?>
                                                <form action="<?= BASE_URL ?>/veiculo/excluir" method="POST"
                                                    data-confirm-message="Excluir o veículo <?= htmlspecialchars($v['placa']) ?>?">
                                                    <input type="hidden" name="id_veiculo" value="<?= $v['id_veiculo'] ?>">
                                                    <button type="submit" class="btn-danger-sm veiculo-action-btn">Excluir</button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

            <?php if (($totalPaginas ?? 1) > 1): ?>
                <nav class="df-pagination">
                    <a href="?<?= $queryVeiculos ?? '' ?>pagina=<?= $pagina - 1 ?>"
                        class="df-page-btn <?= $pagina <= 1 ? 'disabled' : '' ?>">Anterior</a>

                    <?php
                    $range = 2;
                    for ($i = 1; $i <= $totalPaginas; $i++):
                        $mostrar = ($i == 1 || $i == $totalPaginas ||
                            ($i >= $pagina - $range && $i <= $pagina + $range));
                        if (!$mostrar):
                            if ($i == 2 || $i == $totalPaginas - 1): ?>
                                <span class="df-page-ellipsis">…</span>
                            <?php endif; ?>
                            <?php continue; ?>
                        <?php endif; ?>
                        <a href="?<?= $queryVeiculos ?? '' ?>pagina=<?= $i ?>"
                            class="df-page-btn <?= $i === $pagina ? 'active' : '' ?>"><?= $i ?></a>
                    <?php endfor; ?>

                    <a href="?<?= $queryVeiculos ?? '' ?>pagina=<?= $pagina + 1 ?>"
                        class="df-page-btn <?= $pagina >= $totalPaginas ? 'disabled' : '' ?>">Próximo</a>
                </nav>
            <?php endif; ?>
        </div>

    </div>
</main>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>

