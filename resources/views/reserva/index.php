<?php
$paginaTitulo = 'Reservas';
$paginaAtiva  = 'reserva';
$cssTela      = 'reserva.css';
$jsExtra      = 'reserva.js';
require_once __DIR__ . '/../layout/header.php';

$privilegio = (int)($usuario['privilegio'] ?? 1);
$podeGerenciarLocais = $podeGerenciarLocais ?? in_array($privilegio, [2, 4], true);
$visaoReservas = $visaoReservas ?? ($podeGerenciarLocais ? 'locais' : 'nova');
$filtrosReservas = $filtrosReservas ?? [];

$queryPaginacao = array_filter([
    'visao' => 'solicitacoes',
    'reserva_nome' => $filtrosReservas['nome'] ?? '',
    'reserva_bloco' => $filtrosReservas['bloco'] ?? '',
    'reserva_apto' => $filtrosReservas['apto'] ?? '',
    'reserva_data_solicitacao' => $filtrosReservas['data_solicitacao'] ?? '',
    'reserva_data_reserva' => $filtrosReservas['data_reserva'] ?? '',
], static fn($valor) => $valor !== '');
$basePaginacao = BASE_URL . '/reserva?' . http_build_query($queryPaginacao);
$basePaginacao .= '&';
?>

<main class="main-content">
<div class="df-page reserva-page">

    <div class="page-header">
        <h2><?= $podeGerenciarLocais ? 'Gestão de Reservas' : 'Nova Reserva' ?></h2>
        <p class="text-muted">
            <?= $podeGerenciarLocais ? 'Gerencie locais e solicitações pendentes' : 'Solicite a reserva de espaços comuns' ?>
        </p>
    </div>

    <?php if (isset($_GET['sucesso'])): ?>
        <div class="df-alert df-alert-success">Operação realizada com sucesso!</div>
    <?php elseif (isset($_GET['local_atualizado'])): ?>
        <div class="df-alert df-alert-success">Local atualizado com sucesso!</div>
    <?php endif; ?>

    <?php if (isset($_SESSION['erro_reserva'])): ?>
        <div class="df-alert df-alert-error"><?= htmlspecialchars($_SESSION['erro_reserva']) ?></div>
        <?php unset($_SESSION['erro_reserva']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['sucesso_reserva'])): ?>
        <div class="df-alert df-alert-success">
            <?= htmlspecialchars($_SESSION['sucesso_reserva']) ?>
            <?php unset($_SESSION['sucesso_reserva']); ?>
        </div>
    <?php endif; ?>

    <?php if ($podeGerenciarLocais): ?>
        <div class="reserva-tabs">
            <a class="reserva-tab <?= $visaoReservas === 'locais' ? 'active' : '' ?>" href="<?= BASE_URL ?>/reserva?visao=locais">Locais</a>
            <a class="reserva-tab <?= $visaoReservas === 'solicitacoes' ? 'active' : '' ?>" href="<?= BASE_URL ?>/reserva?visao=solicitacoes">Solicitações</a>
        </div>
    <?php endif; ?>

    <?php if (!$podeGerenciarLocais): ?>
        <div class="df-card reserva-form-card">
            <form action="<?= BASE_URL ?>/reserva/salvar" method="POST" id="formReserva">
                <div class="df-grid-2">
                    <div class="df-field">
                        <label>Local Desejado</label>
                        <select name="id_local" id="id_local" required>
                            <option value="">Selecione...</option>
                            <?php foreach ($locais as $local): ?>
                                <option value="<?= (int)$local['id_local'] ?>" data-capacidade="<?= (int)$local['capacidade'] ?>">
                                    <?= htmlspecialchars($local['local'] ?? $local['nome_local']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="df-field">
                        <label>Capacidade Máxima</label>
                        <input type="text" id="capacidade_display" readonly placeholder="Selecione um local">
                    </div>
                </div>

                <div class="df-grid-3">
                    <div class="df-field">
                        <label>Data do Evento</label>
                        <input type="date" name="data_reserva" id="data_reserva" required>
                    </div>
                    <div class="df-field">
                        <label>Horário de Início</label>
                        <input type="time" name="hora_ini" required>
                    </div>
                    <div class="df-field">
                        <label>Horário de Término</label>
                        <input type="time" name="hora_fim" required>
                    </div>
                </div>

                <div class="df-field reserva-convidados">
                    <label>Qtd. de Convidados</label>
                    <input type="number" name="qtd_convidados" min="1" placeholder="Ex: 10">
                </div>

                <div id="alertaFeriado" class="df-alert df-alert-warning d-none reserva-feriado-alert">
                    <i class='bx bxs-info-circle'></i>
                    Atenção: esta data é feriado — <strong id="nomeFeriado"></strong>
                </div>

                <div class="df-actions">
                    <button type="submit" class="btn-primary">Solicitar Reserva</button>
                </div>
            </form>
        </div>
    <?php endif; ?>

    <?php if ($podeGerenciarLocais && $visaoReservas === 'locais'): ?>
        <div class="df-card reserva-form-card">
            <form action="<?= BASE_URL ?>/reserva/salvar" method="POST">
                <div class="reserva-section-head">
                    <h3>Novo local</h3>
                </div>
                <div class="df-grid-2">
                    <div class="df-field">
                        <label>Nome do Local</label>
                        <input type="text" name="nome_local" placeholder="Ex: Salão de Festas" required>
                    </div>
                    <div class="df-field">
                        <label>Capacidade (pessoas)</label>
                        <input type="number" name="capacidade" placeholder="0" min="1" required>
                    </div>
                </div>
                <div class="df-field reserva-status-field">
                    <label>Status</label>
                    <select name="disponivel" required>
                        <option value="S">Disponível</option>
                        <option value="N">Indisponível / Manutenção</option>
                    </select>
                </div>
                <div class="df-actions">
                    <button type="reset" class="btn-ghost">Limpar</button>
                    <button type="submit" class="btn-primary">Salvar Local</button>
                </div>
            </form>
        </div>

        <div class="df-card reserva-locais-card">
            <div class="reserva-section-head">
                <h3>Locais cadastrados</h3>
                <span><?= count($locaisCadastrados ?? []) ?> local(is)</span>
            </div>

            <?php if (empty($locaisCadastrados)): ?>
                <div class="empty-state">
                    <i class='bx bx-building-house'></i>
                    <h5>Nenhum local cadastrado</h5>
                </div>
            <?php else: ?>
                <div class="reserva-table-wrap">
                    <table class="df-table reserva-locais-table">
                        <thead>
                            <tr>
                                <th>Local</th>
                                <th>Capacidade</th>
                                <th>Status</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($locaisCadastrados as $local): ?>
                                <?php $formId = 'local-form-' . (int)$local['id_local']; ?>
                                <tr>
                                    <td>
                                        <form id="<?= $formId ?>" action="<?= BASE_URL ?>/reserva/local/editar" method="POST"></form>
                                        <input form="<?= $formId ?>" type="hidden" name="id_local" value="<?= (int)$local['id_local'] ?>">
                                        <input form="<?= $formId ?>" class="reserva-inline-input" type="text" name="nome_local"
                                            value="<?= htmlspecialchars($local['local']) ?>" required>
                                    </td>
                                    <td>
                                        <input form="<?= $formId ?>" class="reserva-inline-input reserva-capacidade-input" type="number"
                                            name="capacidade" value="<?= (int)$local['capacidade'] ?>" min="1" required>
                                    </td>
                                    <td>
                                        <select form="<?= $formId ?>" class="reserva-inline-input" name="disponivel" required>
                                            <option value="S" <?= $local['disp_uso'] === 'S' ? 'selected' : '' ?>>Disponível</option>
                                            <option value="N" <?= $local['disp_uso'] === 'N' ? 'selected' : '' ?>>Indisponível</option>
                                        </select>
                                    </td>
                                    <td>
                                        <button form="<?= $formId ?>" type="submit" class="btn-primary reserva-table-btn">Salvar</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php if ($podeGerenciarLocais && $visaoReservas === 'solicitacoes'): ?>
        <div class="df-card reserva-filtros-card">
            <form method="GET" action="<?= BASE_URL ?>/reserva" class="reserva-filtros">
                <input type="hidden" name="visao" value="solicitacoes">
                <div class="df-field">
                    <label>Nome</label>
                    <input type="text" name="reserva_nome" value="<?= htmlspecialchars($filtrosReservas['nome'] ?? '') ?>" placeholder="Morador...">
                </div>
                <div class="df-field">
                    <label>Bloco</label>
                    <input type="text" name="reserva_bloco" value="<?= htmlspecialchars($filtrosReservas['bloco'] ?? '') ?>" placeholder="Ex: A">
                </div>
                <div class="df-field">
                    <label>Apto</label>
                    <input type="text" name="reserva_apto" value="<?= htmlspecialchars($filtrosReservas['apto'] ?? '') ?>" placeholder="Ex: 101">
                </div>
                <div class="df-field">
                    <label>Data solicitação</label>
                    <input type="date" name="reserva_data_solicitacao" value="<?= htmlspecialchars($filtrosReservas['data_solicitacao'] ?? '') ?>">
                </div>
                <div class="df-field">
                    <label>Data reserva</label>
                    <input type="date" name="reserva_data_reserva" value="<?= htmlspecialchars($filtrosReservas['data_reserva'] ?? '') ?>">
                </div>
                <div class="reserva-filter-actions">
                    <button type="submit" class="btn-primary">Filtrar</button>
                    <a href="<?= BASE_URL ?>/reserva?visao=solicitacoes" class="btn-ghost">Limpar</a>
                </div>
            </form>
        </div>

        <div class="df-card reserva-solicitacoes-card">
            <div class="reserva-section-head reserva-section-head-actions">
                <h3>Solicitações de Reserva Pendentes</h3>
                <span><?= count($reservasParaAprovar ?? []) ?> nesta página</span>
                <form action="<?= BASE_URL ?>/reservas/recusar-vencidas" method="POST" class="reserva-recusa-vencidas-form">
                    <button type="submit" class="btn-danger-sm"
                        onclick="return confirm('Recusar todas as reservas pendentes com data anterior a hoje?');">
                        Recusar pendentes vencidas
                    </button>
                </form>
            </div>

            <?php if (empty($reservasParaAprovar)): ?>
                <div class="empty-state">
                    <div class="empty-state-icon"><i class='bx bx-check-shield'></i></div>
                    <h5>Tudo em dia!</h5>
                    <p>Nenhuma reserva aguardando sua aprovação.</p>
                </div>
            <?php else: ?>
                <div class="reserva-table-wrap">
                    <table class="df-table reserva-solicitacoes-table">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Bloco</th>
                                <th>Apto</th>
                                <th>Local</th>
                                <th>Solicitado em</th>
                                <th>Data reserva</th>
                                <th>Hora reserva</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reservasParaAprovar as $res): ?>
                                <tr>
                                    <td><strong><?= htmlspecialchars($res['nome_morador']) ?></strong></td>
                                    <td><?= htmlspecialchars($res['bloco'] ?? '-') ?></td>
                                    <td><?= htmlspecialchars($res['apto'] ?? '-') ?></td>
                                    <td><?= htmlspecialchars($res['local']) ?></td>
                                    <td><?= !empty($res['created_at']) ? date('d/m/y H:i', strtotime($res['created_at'])) : '-' ?></td>
                                    <td><?= date('d/m/Y', strtotime($res['data_reserva'])) ?></td>
                                    <td><?= substr($res['hora_ini'], 0, 5) ?> - <?= substr($res['hora_fim'], 0, 5) ?></td>
                                    <td>
                                        <form action="<?= BASE_URL ?>/reservas/decidir" method="POST" class="reserva-row-actions">
                                            <input type="hidden" name="id_reserva" value="<?= (int)$res['id_reserva'] ?>">
                                            <button type="submit" name="acao" value="aceitar" class="btn-success-sm">Aprovar</button>
                                            <button type="submit" name="acao" value="negar" class="btn-danger-sm">Negar</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <?php if ($totalPaginas > 1): ?>
                    <nav class="mt-3 d-flex justify-content-center">
                        <ul class="pagination">
                            <li class="page-item <?= $pagina <= 1 ? 'disabled' : '' ?>">
                                <a class="page-link" href="<?= $pagina > 1 ? $basePaginacao . 'pagina=' . ($pagina - 1) : '#' ?>">Anterior</a>
                            </li>
                            <?php
                            $range = 2;
                            for ($i = 1; $i <= $totalPaginas; $i++):
                                $mostrar = (
                                    $i === 1 ||
                                    $i === $totalPaginas ||
                                    ($i >= $pagina - $range && $i <= $pagina + $range)
                                );
                                if (!$mostrar):
                                    if ($i === 2 || $i === $totalPaginas - 1):
                            ?>
                                        <li class="page-item disabled"><span class="page-link">...</span></li>
                                <?php
                                    endif;
                                    continue;
                                endif;
                                ?>
                                <li class="page-item <?= $i === $pagina ? 'active' : '' ?>">
                                    <a class="page-link" href="<?= $basePaginacao ?>pagina=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                            <li class="page-item <?= $pagina >= $totalPaginas ? 'disabled' : '' ?>">
                                <a class="page-link" href="<?= $pagina < $totalPaginas ? $basePaginacao . 'pagina=' . ($pagina + 1) : '#' ?>">Próximo</a>
                            </li>
                        </ul>
                    </nav>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
</main>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
