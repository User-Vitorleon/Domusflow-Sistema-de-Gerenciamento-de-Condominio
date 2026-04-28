<?php
$paginaTitulo = 'Reservas';
$paginaAtiva  = 'reserva';
$jsExtra      = 'reserva.js';
require_once __DIR__ . '/../layout/header.php';
require_once __DIR__ . '/../layout/sidebar.php';
$prev = $usuario['previlegio'] ?? 1;
?>

<main class="main-content">
    <div class="page-header">
        <h2><?= $prev == 2 ? 'Cadastrar Local' : 'Nova Reserva' ?></h2>
    </div>

    <?php if (isset($_GET['sucesso'])): ?>
        <div class="df-alert df-alert-success">Operação realizada com sucesso!</div>
    <?php endif; ?>

    <?php if (isset($_SESSION['erro_reserva'])): ?>
        <div class="df-alert df-alert-error"><?= htmlspecialchars($_SESSION['erro_reserva']) ?></div>
        <?php unset($_SESSION['erro_reserva']); ?>
    <?php endif; ?>

    <div class="df-card">
        <?php if ($prev == 1): ?>
            <form action="<?= BASE_URL ?>/reserva/salvar" method="POST" id="formReserva">
                <div class="df-grid-2">
                    <div class="df-field">
                        <label>Local Desejado</label>
                        <select name="id_local" id="id_local" required>
                            <option value="">Selecione...</option>
                            <?php foreach ($locais as $local): ?>
                                <option value="<?= $local['id_local'] ?>" data-capacidade="<?= $local['capacidade'] ?>">
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

                <div class="df-field" style="margin-top: 15px; max-width: 200px;">
                    <label>Qtd. de Convidados</label>
                    <input type="number" name="qtd_convidados" min="1" placeholder="Ex: 10">
                </div>

                <div id="alertaFeriado" class="df-alert df-alert-warning d-none" style="margin-top: 20px;">
                    <i class='bx bxs-info-circle'></i>
                    Atenção: esta data é feriado — <strong id="nomeFeriado"></strong>
                </div>

                <div class="df-actions">
                    <button type="submit" class="btn-primary">Solicitar Reserva</button>
                </div>
            </form>

        <?php else: ?>
            <form action="<?= BASE_URL ?>/reserva/salvar" method="POST">
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
                <div class="df-field">
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
        <?php endif; ?>
    </div>
    <br>
    <hr>

    <?php if (($usuario['previlegio'] ?? 0) == 2): ?>
        <h3 class="section-title">Solicitações de Reserva Pendentes</h3>
        
        <?php if (empty($reservasParaAprovar)): ?>
            <div class="empty-state">
                <div class="empty-state-icon"><i class='bx bx-check-shield'></i></div>
                <h5>Tudo em dia!</h5>
                <p>Nenhuma reserva aguardando sua aprovação.</p>
            </div>
        <?php else: ?>
            <?php foreach ($reservasParaAprovar as $res): 
                // Corrigido para usar $res que vem do foreach
                $sexoMorador = $res['sexo'] ?? 'M';
                $avatar = 'https://static.vecteezy.com/ti/vetor-gratis/p1/21548095-padrao-perfil-cenario-avatar-do-utilizador-avatar-icone-pessoa-icone-cabeca-icone-perfil-cenario-icones-padrao-anonimo-do-utilizador-masculino-e-femea-homem-de-negocios-foto-espaco-reservado-social-rede-avatar-retrato-gratis-vetor.jpg';
            ?>
                <div class="morador-card">
                    <img src="<?= $avatar ?>" alt="avatar" class="morador-avatar">
                    <div class="morador-info">
                        <strong><?= htmlspecialchars($res['nome_morador']) ?></strong>
                        <span>
                            Local: <strong><?= htmlspecialchars($res['local']) ?></strong> 
                            <br>
                            
                            Dia: <?= date('d/m/Y', strtotime($res['data_reserva'])) ?> | 
                            Apartamento: <?= htmlspecialchars($res['apto'] ?? 'N/A') ?> Bloco: <?= htmlspecialchars($res['bloco'] ?? 'N/A') ?>
                        </span>
                    </div>

                    <form action="<?= BASE_URL ?>/reservas/decidir" method="POST" class="morador-actions">
                        <input type="hidden" name="id_reserva" value="<?= $res['id_reserva'] ?>">
                        <button type="submit" name="acao" value="aceitar" class="btn-success-sm">Aprovar</button>
                        <button type="submit" name="acao" value="negar" class="btn-danger-sm">Negar</button>
                    </form>
                </div>
                <br>
            <?php endforeach; ?>
            <?php if ($totalPaginas > 1): ?>
                <nav class="mt-3 d-flex justify-content-center">
                    <ul class="pagination">

                        <li class="page-item <?= $pagina <= 1 ? 'disabled' : '' ?>">
                            <a class="page-link" href="?pagina=<?= $pagina - 1 ?>">Anterior</a>
                        </li>
                        <?php
                        $range = 2; // quantas páginas ao redor da atual
                        for ($i = 1; $i <= $totalPaginas; $i++):
                            $mostrar = (
                                $i == 1 ||
                                $i == $totalPaginas ||
                                ($i >= $pagina - $range && $i <= $pagina + $range)
                            );
                            if (!$mostrar):
                                if ($i == 2 || $i == $totalPaginas - 1):
                            ?>
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        <?php
                            endif;
                            continue;
                            endif;
                        ?>
                            <li class="page-item <?= $i === $pagina ? 'active' : '' ?>">
                                <a class="page-link" href="?pagina=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item <?= $pagina >= $totalPaginas ? 'disabled' : '' ?>">
                            <a class="page-link" href="?pagina=<?= $pagina + 1 ?>">Próximo</a>
                        </li>

                    </ul>
                </nav>
            <?php endif; ?>
        <?php endif; ?>
    <?php endif; ?>
</main>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>