<?php
$paginaTitulo = 'Novos Usuários';
$paginaAtiva  = 'moradores';
require_once __DIR__ . '/../layout/header.php';
require_once __DIR__ . '/../layout/sidebar.php';
?>

<main class="main-content">
    <div class="page-header">
        <h2>Solicitações de Acesso</h2>
        <p class="text-muted">Aprove ou negue os cadastros pendentes</p>
    </div>
    
    <?php if (isset($_GET['status'])): ?>
        <div class="df-alert df-alert-<?= $_GET['status'] === 'liberado' ? 'success' : 'warning' ?>">
            Morador <?= $_GET['status'] === 'liberado' ? 'liberado' : 'negado' ?> com sucesso.
        </div>
    <?php endif; ?>

    <?php if (empty($moradores)): ?>
        <div class="empty-state">
            <i class='bx bx-check-shield'></i>
            <h5>Tudo em dia!</h5>
            <p>Nenhuma solicitação pendente no momento.</p>
        </div>
    <?php else: ?>
    <div class="morador-list">
        <?php 
        $avatar = 'https://static.vecteezy.com/ti/vetor-gratis/p1/21548095-padrao-perfil-cenario-avatar-do-utilizador-avatar-icone-pessoa-icone-cabeca-icone-perfil-cenario-icones-padrao-anonimo-do-utilizador-masculino-e-femea-homem-de-negocios-foto-espaco-reservado-social-rede-avatar-retrato-gratis-vetor.jpg';
        foreach ($moradores as $m): 
        ?>
            <div class="morador-card">
                <img src="<?= $avatar ?>" alt="avatar" class="morador-avatar">
                <div class="morador-info">
                    <strong><?= htmlspecialchars($m['nome']) ?></strong>
                    <span>CPF: <?= htmlspecialchars($m['cpf']) ?> · Ap <?= htmlspecialchars($m['apto']) ?> · Bloco <?= htmlspecialchars($m['bloco']) ?></span>
                </div>
                <form action="<?= BASE_URL ?>/moradores/liberar" method="POST" class="morador-actions">
                    <input type="hidden" name="id_morador" value="<?= $m['id_user'] ?>">
                    <button type="submit" name="acao" value="aceitar" class="btn-success-sm">Aceitar</button>
                    <button type="submit" name="acao" value="negar" class="btn-danger-sm">Negar</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
        <?php if ($totalPaginas > 1): ?>
        <nav class="mt-3 d-flex justify-content-center">
            <ul class="pagination">

                <li class="page-item <?= $pagina <= 1 ? 'disabled' : '' ?>">
                    <a class="page-link" href="?pagina=<?= $pagina - 1 ?>">Anterior</a>
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
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                <?php   endif; continue; endif; ?>
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
</main>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>