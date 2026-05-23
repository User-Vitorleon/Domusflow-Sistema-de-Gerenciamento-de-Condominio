<?php
$paginaTitulo = 'Detalhes da Ocorrência';
$cssExtra     = 'ocorrencia.css';
require_once __DIR__ . '/../layout/header.php';

if (!function_exists('statusBadgeP')) {
    function statusBadgeP(string $s): string
    {
        return match ($s) {
            'A' => '<span class="oc-badge oc-badge--aberto">Aberto</span>',
            'E' => '<span class="oc-badge oc-badge--andamento">Em Andamento</span>',
            'R' => '<span class="oc-badge oc-badge--resolvido">Resolvido</span>',
            'C' => '<span class="oc-badge oc-badge--cancelado">Cancelado</span>',
            default => '<span class="oc-badge">—</span>'
        };
    }
}

$priv = (int)($_SESSION['usuario_privilegio'] ?? 1);
$isGestor = in_array($priv, [2, 4], true);
$encerrada = in_array($detalhe['status'] ?? '', ['R', 'C'], true);
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
                Ocorrência #<?= str_pad((int)$detalhe['id_ocorrencia'], 4, '0', STR_PAD_LEFT) ?>
            </h2>
            <p>Acompanhe os trâmites e registre atualizações.</p>
        </div>

        <?php if (!empty($flash)): ?>
            <div class="alert alert-<?= $flash['tipo'] === 'error' ? 'danger' : $flash['tipo'] ?>" role="alert">
                <?= htmlspecialchars($flash['msg']) ?>
            </div>
        <?php endif; ?>

        <div class="df-card" style="margin-bottom:16px">
            <div class="row g-3">
                <div class="col-lg-8">
                    <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;margin-bottom:10px">
                        <?= statusBadgeP($detalhe['status'] ?? '') ?>
                        <span class="oc-cat-pill"><?= htmlspecialchars($detalhe['categoria'] ?? '') ?></span>
                    </div>

                    <h4 style="margin-bottom:10px;font-size:20px;font-weight:700">
                        <?= htmlspecialchars($detalhe['titulo'] ?? '') ?>
                    </h4>

                    <div style="font-size:13px;color:#777;margin-bottom:14px">
                        <strong><?= htmlspecialchars($detalhe['nome_morador'] ?? '') ?></strong>
                        · Bl.<?= htmlspecialchars($detalhe['bloco'] ?? '') ?>
                        Ap.<?= htmlspecialchars($detalhe['apto'] ?? '') ?>
                        · Aberto em <?= !empty($detalhe['created_at']) ? date('d/m/Y H:i', strtotime($detalhe['created_at'])) : '-' ?>
                    </div>

                    <div class="oc-detalhe-desc">
                        <label>Descrição</label>
                        <p style="margin-top:6px;margin-bottom:0">
                            <?= nl2br(htmlspecialchars($detalhe['descricao'] ?? '')) ?>
                        </p>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="df-card" style="background:#fafafa;padding:16px">
                        <div style="font-size:12px;color:#888;margin-bottom:4px">Morador</div>
                        <div style="font-size:14px;font-weight:600;margin-bottom:12px">
                            <?= htmlspecialchars($detalhe['nome_morador'] ?? '') ?>
                        </div>

                        <div style="font-size:12px;color:#888;margin-bottom:4px">Unidade</div>
                        <div style="font-size:14px;font-weight:600;margin-bottom:12px">
                            Bl.<?= htmlspecialchars($detalhe['bloco'] ?? '') ?> · Ap.<?= htmlspecialchars($detalhe['apto'] ?? '') ?>
                        </div>

                        <div style="font-size:12px;color:#888;margin-bottom:4px">Status atual</div>
                        <div style="margin-bottom:12px">
                            <?= statusBadgeP($detalhe['status'] ?? '') ?>
                        </div>

                        <div style="font-size:12px;color:#888;margin-bottom:4px">Categoria</div>
                        <div>
                            <span class="oc-cat-pill"><?= htmlspecialchars($detalhe['categoria'] ?? '') ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="df-card" style="margin-bottom:16px">
            <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;margin-bottom:14px">
                <h5 style="margin:0;font-size:16px;font-weight:700">Histórico de tramitações</h5>
                <span style="font-size:12px;color:#888">
                    <?= !empty($detalhe['tramites']) ? count($detalhe['tramites']) : 0 ?> registro(s)
                </span>
            </div>

            <?php if (empty($detalhe['tramites'])): ?>
                <div class="empty-state" style="padding:24px 12px">
                    <h5>Nenhuma tramitação registrada</h5>
                    <p>As atualizações desta ocorrência aparecerão aqui.</p>
                </div>
            <?php else: ?>
                <div class="oc-timeline">
                    <?php foreach ($detalhe['tramites'] as $t): ?>
                        <div class="oc-timeline-item">
                            <div class="oc-timeline-dot oc-dot--<?= strtolower($t['status_novo'] ?? 'a') ?>"></div>
                            <div class="oc-timeline-content">
                                <div class="oc-timeline-header">
                                    <strong style="font-size:13px">
                                        <?= htmlspecialchars($t['nome_user_cad'] ?? '') ?>
                                    </strong>
                                    <?= statusBadgeP($t['status_novo'] ?? '') ?>
                                    <span class="oc-timeline-data">
                                        <?= !empty($t['created_at']) ? date('d/m/Y H:i', strtotime($t['created_at'])) : '-' ?>
                                    </span>
                                </div>
                                <p><?= nl2br(htmlspecialchars($t['descricao'] ?? '')) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <?php if ($isGestor): ?>
            <div class="df-card" style="margin-bottom:16px">
                <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;margin-bottom:14px">
                    <h5 style="margin:0;font-size:16px;font-weight:700">Registrar tramitação</h5>
                    <?php if ($encerrada): ?>
                        <span style="font-size:12px;color:#888">Ocorrência encerrada</span>
                    <?php endif; ?>
                </div>

                <form method="POST" action="<?= BASE_URL ?>/ocorrencia/tramitar">
                    <input type="hidden" name="id_ocorrencia" value="<?= (int)$detalhe['id_ocorrencia'] ?>">

                    <div class="row g-3">
                        <div class="col-md-4 df-field">
                            <label>Novo Status <span style="color:#dc3545">*</span></label>
                            <select name="status_novo" <?= $encerrada ? 'disabled' : 'required' ?>>
                                <option value="">Selecione...</option>

                                <?php if (($detalhe['status'] ?? '') === 'A'): ?>
                                    <option value="A">Manter em Aberto</option>
                                    <option value="E">Em Andamento</option>
                                    <option value="R">Resolvido</option>
                                    <option value="C">Cancelado</option>
                                <?php elseif (($detalhe['status'] ?? '') === 'E'): ?>
                                    <option value="E">Manter em Andamento</option>
                                    <option value="R">Resolvido</option>
                                    <option value="C">Cancelado</option>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="col-12 df-field">
                            <label>Descrição <span style="color:#dc3545">*</span></label>
                            <textarea name="descricao"
                                rows="4"
                                <?= $encerrada ? 'disabled' : 'required' ?>
                                oninput="this.value = this.value.toUpperCase()"
                                placeholder="<?= $encerrada ? 'OCORRÊNCIA ENCERRADA PARA NOVAS TRAMITAÇÕES.' : 'DESCREVA O QUE FOI FEITO OU ENCAMINHADO...' ?>"></textarea>
                        </div>
                    </div>

                    <?php if ($encerrada): ?>
                        <div style="padding:12px;background:#f5f7fa;border-radius:6px;font-size:13px;color:#888;text-align:center;margin-top:12px">
                            Ocorrência encerrada para novas tramitações.
                        </div>
                    <?php endif; ?>

                    <div class="df-actions" style="margin-top:16px">
                        <a href="<?= BASE_URL ?>/ocorrencia/painel" class="btn-ghost">Voltar</a>
                        <button type="submit" class="btn-primary" <?= $encerrada ? 'disabled' : '' ?>>
                            Registrar tramitação
                        </button>
                    </div>
                </form>
            </div>
        <?php else: ?>
            <div class="df-card" style="margin-bottom:16px">
                <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;margin-bottom:14px">
                    <h5 style="margin:0;font-size:16px;font-weight:700">Adicionar atualização</h5>
                    <?php if ($encerrada): ?>
                        <span style="font-size:12px;color:#888">Ocorrência encerrada</span>
                    <?php endif; ?>
                </div>

                <form method="POST" action="<?= BASE_URL ?>/ocorrencia/tramitar-morador">
                    <input type="hidden" name="id_ocorrencia" value="<?= (int)$detalhe['id_ocorrencia'] ?>">
                    <input type="hidden" name="acao" value="comentar">

                    <div class="df-field">
                        <label>Descrição <span style="color:#dc3545">*</span></label>
                        <textarea name="descricao"
                            rows="4"
                            <?= $encerrada ? 'disabled' : 'required' ?>
                            oninput="this.value = this.value.toUpperCase()"
                            placeholder="<?= $encerrada ? 'OCORRÊNCIA ENCERRADA PARA NOVAS ATUALIZAÇÕES.' : 'ESCREVA SUA ATUALIZAÇÃO...' ?>"></textarea>
                    </div>

                    <?php if ($encerrada): ?>
                        <div style="padding:12px;background:#f5f7fa;border-radius:6px;font-size:13px;color:#888;text-align:center;margin-top:12px">
                            Ocorrência encerrada para novas atualizações.
                        </div>
                    <?php endif; ?>

                    <div class="df-actions" style="margin-top:16px">
                        <a href="<?= BASE_URL ?>/ocorrencia" class="btn-ghost">Voltar</a>
                        <button type="submit" class="btn-primary" <?= $encerrada ? 'disabled' : '' ?>>
                            Enviar atualização
                        </button>
                    </div>
                </form>
            </div>
        <?php endif; ?>

    </div>
</main>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
