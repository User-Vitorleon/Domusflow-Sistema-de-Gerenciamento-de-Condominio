<?php
$paginaTitulo = 'Minhas Ocorrências';
$cssExtra     = 'ocorrencia.css';
require_once __DIR__ . '/../layout/header.php';

function statusBadge(string $s): string
{
    return match ($s) {
        'A' => '<span class="oc-badge oc-badge--aberto">Aberto</span>',
        'E' => '<span class="oc-badge oc-badge--andamento">Em Andamento</span>',
        'R' => '<span class="oc-badge oc-badge--resolvido">Resolvido</span>',
        'C' => '<span class="oc-badge oc-badge--cancelado">Cancelado</span>',
        default => '<span class="oc-badge">—</span>'
    };
}
?>

<main class="main-content">
    <div class="df-page">

        <div class="page-header">
            <h2>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"
                    stroke-linecap="round" stroke-linejoin="round"
                    style="width:22px;height:22px;vertical-align:middle;margin-right:6px">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                    <line x1="12" y1="9" x2="12" y2="13" />
                    <line x1="12" y1="17" x2="12.01" y2="17" />
                </svg>
                Minhas Ocorrências
            </h2>
            <p>Registre e acompanhe seus chamados.</p>
        </div>

        <div class="oc-layout-grid">

            <div class="oc-col-form">
                <div class="df-card">
                    <h4 style="font-size:15px;font-weight:700;margin-bottom:4px">Nova Ocorrência</h4>
                    <p style="font-size:13px;color:#888;margin-bottom:16px">Preencha os campos abaixo para abrir um chamado.</p>

                    <?php if (!empty($erro)): ?>
                        <div class="oc-alert oc-alert--erro"><?= htmlspecialchars($erro) ?></div>
                    <?php endif; ?>
                    <?php if (!empty($sucesso)): ?>
                        <div class="oc-alert oc-alert--sucesso"><?= htmlspecialchars($sucesso) ?></div>
                    <?php endif; ?>

                    <form method="POST" action="<?= BASE_URL ?>/ocorrencia/abrir">

                        <div class="df-field">
                            <label>Categoria <span style="color:#dc3545">*</span></label>
                            <select name="categoria" required>
                                <option value="">Selecione...</option>
                                <?php foreach (['MANUTENÇÃO', 'BARULHO / PERTURBAÇÃO', 'SEGURANÇA', 'LIMPEZA', 'ÁREA COMUM', 'OUTROS'] as $cat): ?>
                                    <option value="<?= $cat ?>" <?= (($_POST['categoria'] ?? '') === $cat) ? 'selected' : '' ?>>
                                        <?= $cat ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="df-field">
                            <label>Título <span style="color:#dc3545">*</span></label>
                            <input type="text" name="titulo" required
                                placeholder="DESCREVA BREVEMENTE O PROBLEMA..."
                                oninput="this.value = this.value.toUpperCase()"
                                value="<?= htmlspecialchars($_POST['titulo'] ?? '') ?>">
                        </div>

                        <div class="df-field">
                            <label>Descrição <span style="color:#dc3545">*</span></label>
                            <textarea name="descricao" rows="4" required
                                placeholder="DETALHE A OCORRÊNCIA: LOCAL, HORÁRIO, ETC."
                                oninput="this.value = this.value.toUpperCase()"
                                style="resize:vertical"><?= htmlspecialchars($_POST['descricao'] ?? '') ?></textarea>
                        </div>

                        <div class="df-field">
                            <label>Fotos <span style="font-size:11px;color:#aaa;font-weight:400">(opcional)</span></label>
                            <div class="oc-foto-area" onclick="abrirModalFotos()" title="Adicionar fotos">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" width="28" height="28"
                                    style="color:#aaa">
                                    <rect x="3" y="3" width="18" height="18" rx="2" />
                                    <circle cx="8.5" cy="8.5" r="1.5" />
                                    <polyline points="21 15 16 10 5 21" />
                                </svg>
                                <span style="font-size:13px;color:#888;margin-top:4px">Adicionar fotos</span>
                                <span style="font-size:11px;color:#bbb">Até 3 fotos</span>
                            </div>
                        </div>

                        <div class="df-actions" style="margin-top:8px">
                            <button type="submit" class="btn-primary" style="width:100%">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" width="14" height="14"
                                    style="margin-right:6px;vertical-align:middle">
                                    <line x1="22" y1="2" x2="11" y2="13" />
                                    <polygon points="22 2 15 22 11 13 2 9 22 2" />
                                </svg>
                                Abrir Ocorrência
                            </button>
                        </div>

                    </form>
                </div>
            </div>

            <div class="oc-col-lista">
                <div class="df-card" style="padding:0;overflow:hidden">
                    <div style="padding:14px 16px;border-bottom:1px solid #eee">
                        <h4 style="font-size:15px;font-weight:700;margin:0">Minhas Ocorrências</h4>
                    </div>

                    <?php if (empty($ocorrencias)): ?>
                        <div class="empty-state">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                width="40" height="40" style="color:#ccc;margin-bottom:8px">
                                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                                <line x1="12" y1="9" x2="12" y2="13" />
                                <line x1="12" y1="17" x2="12.01" y2="17" />
                            </svg>
                            <p style="color:#aaa;font-size:13px">Nenhuma ocorrência registrada.</p>
                        </div>
                    <?php else: ?>
                        <div style="padding:8px 12px;border-bottom:1px solid #f0f0f0;font-size:12px;color:#aaa">
                            <?= count($ocorrencias) ?> registro(s) encontrado(s).
                        </div>
                        <div class="oc-lista-cards">
                            <?php foreach ($ocorrencias as $oc): ?>
                                <div class="oc-lista-card">
                                    <div class="oc-lista-card-top">
                                        <span class="oc-td-id">#<?= str_pad($oc['id_ocorrencia'], 4, '0', STR_PAD_LEFT) ?></span>
                                        <?= statusBadge($oc['status']) ?>
                                        <span class="oc-cat-pill oc-cat-pill--sm" style="margin-left:4px"><?= htmlspecialchars($oc['categoria']) ?></span>
                                    </div>
                                    <div class="oc-lista-card-titulo"><?= htmlspecialchars($oc['titulo']) ?></div>
                                    <div class="oc-lista-card-bottom">
                                        <span class="oc-td-data"><?= date('d/m/Y', strtotime($oc['created_at'])) ?></span>
                                        <a href="<?= BASE_URL ?>/ocorrencia/detalhes?id=<?= (int)$oc['id_ocorrencia'] ?>"
                                            class="btn-ghost"
                                            style="padding:4px 12px;font-size:12px;text-decoration:none;display:inline-block">
                                            Ver detalhes
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>

    </div>
    <div class="oc-modal-overlay" id="modalFotos" style="display:none" onclick="fecharModalFotos()">
        <div class="oc-modal" onclick="event.stopPropagation()" style="max-width:420px;text-align:center">
            <div class="oc-modal-header">
                <div style="display:flex;align-items:center;gap:8px">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" width="18" height="18">
                        <rect x="3" y="3" width="18" height="18" rx="2" />
                        <circle cx="8.5" cy="8.5" r="1.5" />
                        <polyline points="21 15 16 10 5 21" />
                    </svg>
                    Adicionar Fotos
                </div>
                <button class="oc-modal-close" onclick="fecharModalFotos()">✕</button>
            </div>
            <hr style="border:none;border-top:1px solid #eee;margin:0">
            <div style="padding:40px 24px 32px">
                <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg"
                    width="64" height="64" style="margin:0 auto 16px">
                    <path d="M54 10L44 20l-4-4 10-10a14 14 0 0 0-18 18l-22 22a4 4 0 0 0 0 6l4 4a4 4 0 0 0 6 0l22-22a14 14 0 0 0 18-18l-10 10-4-4z"
                        fill="#f59e0b" opacity=".9" />
                    <path d="M20 44l-6 6" stroke="#f59e0b" stroke-width="3" stroke-linecap="round" />
                </svg>
                <h5 style="font-size:16px;font-weight:700;margin-bottom:8px">Em Desenvolvimento</h5>
                <p style="font-size:13px;color:#888;margin-bottom:0">O envio de fotos estará disponível em breve.</p>
            </div>
            <div style="padding:0 24px 24px">
                <button class="btn-primary" style="width:100%" onclick="fecharModalFotos()">Fechar</button>
            </div>
        </div>
    </div>

</main>

<script src="<?= BASE_URL ?>/public/js/ocorrencia.js"></script>
<?php require_once __DIR__ . '/../layout/footer.php'; ?>
