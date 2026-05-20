<?php
$paginaTitulo = 'Veículos';
$paginaAtiva  = 'veiculo';
$cssExtra     = 'veiculo.css';
$jsExtra      = 'veiculo.js';
require_once __DIR__ . '/../layout/header.php';
<<<<<<< HEAD
$prev = $usuario['privilegio'] ?? 1;
=======
$privilegio = $usuario['privilegio'] ?? 1;
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)

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

        <!-- Formulário: síndico/morador/admin cadastram por qualquer morador -->
        <!-- Morador cadastra o próprio veículo (máx 2) -->
<<<<<<< HEAD
        <?php if (in_array($prev, [1, 2, 4])): ?>
=======
        <?php if (in_array($privilegio, [1, 2, 4])): ?>
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
            <div class="df-card" style="margin-bottom: 24px;">
                <h3 class="section-title">Cadastrar Veículo</h3>

                <!-- Contador de vagas (só para morador) -->
<<<<<<< HEAD
                <?php if ($prev == 1): ?>
=======
                <?php if ($privilegio == 1): ?>
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
                    <div class="veiculo-counter">
                        <div class="veiculo-counter-bar">
                            <div class="veiculo-counter-dot <?= count($veiculos) >= 1 ? 'usado' : '' ?>"></div>
                            <div class="veiculo-counter-dot <?= count($veiculos) >= 2 ? 'usado' : '' ?>"></div>
                        </div>
                        <?= count($veiculos) ?>/2 veículos cadastrados
                    </div>
                <?php endif; ?>

                <form action="<?= BASE_URL ?>/veiculo/salvar" method="POST"
                    data-total="<?= count($veiculos) ?>"
<<<<<<< HEAD
                    data-prev="<?= $prev ?>">
=======
                    data-prev="<?= $privilegio ?>">
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)

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
                            <input type="text" name="marca" placeholder="Ex: Honda" required>
                        </div>
                        <div class="df-field">
                            <label>Modelo</label>
                            <input type="text" name="modelo" placeholder="Ex: Civic" required>
                        </div>
                    </div>

                    <!-- Síndico/admin escolhem o morador dono -->
<<<<<<< HEAD
                    <?php if (in_array($prev, [2, 3, 4])): ?>
=======
                    <?php if (in_array($privilegio, [2, 3, 4])): ?>
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
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
                        <!-- Morador: id_user é o próprio -->
                        <input type="hidden" name="id_user" value="<?= $usuario['id_user'] ?>">
                    <?php endif; ?>

                    <!-- Checkbox principal -->
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

        <!-- Tabela de veículos -->
        <div class="df-card">
            <h3 class="section-title">
<<<<<<< HEAD
                <?= in_array($prev, [2, 3, 4]) ? 'Todos os Veículos' : 'Meus Veículos' ?>
=======
                <?= in_array($privilegio, [2, 3, 4]) ? 'Todos os Veículos' : 'Meus Veículos' ?>
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
            </h3>

            <?php if (empty($veiculos)): ?>
                <div class="empty-state">
                    <i class="bx bx-car"></i>
                    <h5>Nenhum veículo cadastrado</h5>
                    <p>Os veículos cadastrados aparecerão aqui.</p>
                </div>
            <?php else: ?>
                <div class="table-wrap">
                    <table class="df-table">
                        <thead>
                            <tr>
                                <th>Placa</th>
                                <th>Marca</th>
                                <th>Modelo</th>
                                <th>Cor</th>
<<<<<<< HEAD
                                <?php if (in_array($prev, [2, 3, 4])): ?>
=======
                                <?php if (in_array($privilegio, [2, 3, 4])): ?>
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
                                    <th>Morador</th>
                                    <th>Cadastrado por</th>
                                <?php endif; ?>
                                <th></th> <!-- ações -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($veiculos as $v): ?>
                                <tr>
                                    <td>
                                        <strong><?= htmlspecialchars($v['placa']) ?></strong>
                                    </td>
                                    <td><?= htmlspecialchars($v['marca']) ?></td>
                                    <td><?= htmlspecialchars($v['modelo']) ?></td>
                                    <td><?= htmlspecialchars($v['cor']) ?></td>
<<<<<<< HEAD
                                    <?php if (in_array($prev, [2, 3, 4])): ?>
=======
                                    <?php if (in_array($privilegio, [2, 3, 4])): ?>
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
                                        <td><?= htmlspecialchars($v['nome_morador']) ?></td>
                                        <td><?= htmlspecialchars($v['cadastrado_por']) ?></td>
                                    <?php endif; ?>
                                    <td>
                                        <?php
                                        // Síndico/admin podem excluir qualquer um
                                        // Morador só pode excluir o próprio
<<<<<<< HEAD
                                        $podeExcluir = in_array($prev, [2, 4]) ||
                                            ($prev == 1 && $v['id_user'] == $usuario['id_user']);
=======
                                        $podeExcluir = in_array($privilegio, [2, 4]) ||
                                            ($privilegio == 1 && $v['id_user'] == $usuario['id_user']);
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
                                        ?>
                                        <?php if ($podeExcluir): ?>
                                            <form action="<?= BASE_URL ?>/veiculo/excluir" method="POST"
                                                onsubmit="return confirm('Excluir o veículo <?= htmlspecialchars($v['placa']) ?>?')">
                                                <input type="hidden" name="id_veiculo" value="<?= $v['id_veiculo'] ?>">
                                                <button type="submit" class="btn-danger-sm">Excluir</button>
                                            </form>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

            <?php if (($totalPaginas ?? 1) > 1): ?>
                <nav class="df-pagination">
                    <a href="?pagina=<?= $pagina - 1 ?>"
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
                        <a href="?pagina=<?= $i ?>"
                            class="df-page-btn <?= $i === $pagina ? 'active' : '' ?>"><?= $i ?></a>
                    <?php endfor; ?>

                    <a href="?pagina=<?= $pagina + 1 ?>"
                        class="df-page-btn <?= $pagina >= $totalPaginas ? 'disabled' : '' ?>">Próximo</a>
                </nav>
            <?php endif; ?>
        </div>

    </div>
</main>

<<<<<<< HEAD
<?php require_once __DIR__ . '/../layout/footer.php'; ?>
=======
<?php require_once __DIR__ . '/../layout/footer.php'; ?>
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
