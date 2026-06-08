<?php

?>
<div class="oc-detalhe">

    <div class="oc-detalhe-meta">
        <div>
            <span class="oc-cat-pill"><?= htmlspecialchars($detalhe['categoria']) ?></span>
            <?= statusBadgePainel($detalhe['status']) ?>
        </div>
        <span style="font-size:13px;color:var(--text-muted)">
            <i class="fa-regular fa-clock"></i>
            Aberto em <?= date('d/m/Y \à\s H:i', strtotime($detalhe['created_at'])) ?>
        </span>
    </div>

    <h5 class="oc-detalhe-titulo"><?= htmlspecialchars($detalhe['titulo']) ?></h5>

    <div class="oc-detalhe-grid">
        <div>
            <label>Morador</label>
            <strong><?= htmlspecialchars($detalhe['nome_morador']) ?></strong>
        </div>
        <div>
            <label>Unidade</label>
            <strong>Apto <?= $detalhe['apto'] ?> — Bloco <?= $detalhe['bloco'] ?></strong>
        </div>
    </div>

    <div class="oc-detalhe-desc">
        <label>Descrição</label>
        <p><?= nl2br(htmlspecialchars($detalhe['descricao'])) ?></p>
    </div>

    <hr class="df-divider">

    <h6 class="oc-timeline-title">
        <i class="fa-solid fa-timeline" style="margin-right:6px"></i>Histórico de Tramitações
    </h6>

    <?php if (!empty($detalhe['tramites'])): ?>
    <div class="oc-timeline">
        <?php foreach ($detalhe['tramites'] as $t): ?>
        <div class="oc-timeline-item">
            <div class="oc-timeline-dot oc-dot--<?= strtolower($t['status_novo']) ?>"></div>
            <div class="oc-timeline-content">
                <div class="oc-timeline-header">
                    <strong><?= htmlspecialchars($t['nome_user_cad']) ?></strong>
                    <?= statusBadgePainel($t['status_novo']) ?>
                    <span class="oc-timeline-data"><?= date('d/m/Y H:i', strtotime($t['created_at'])) ?></span>
                </div>
                <p><?= nl2br(htmlspecialchars($t['descricao'])) ?></p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
    <p style="color:var(--text-muted);font-size:13px">Nenhuma tramitação registrada ainda.</p>
    <?php endif; ?>

    <?php if (!in_array($detalhe['status'], ['R', 'C'])): ?>
    <hr class="df-divider">
    <h6 class="oc-timeline-title">
        <i class="fa-solid fa-pen-to-square" style="margin-right:6px"></i>Adicionar Tramitação
    </h6>

    <form method="POST" action="<?= BASE_URL ?>/ocorrencia/tramitar">
        <input type="hidden" name="id_ocorrencia" value="<?= $detalhe['id_ocorrencia'] ?>">

        <div class="df-grid-2" style="margin-bottom:14px">
            <div class="df-field" style="margin:0">
                <label for="status_novo">Novo Status <span style="color:var(--error)">*</span></label>
                <select name="status_novo" id="status_novo" required>
                    <option value="">Selecione...</option>
                    <option value="A"  <?= $detalhe['status'] === 'A' ? 'selected' : '' ?>>Aberto</option>
                    <option value="E"  <?= $detalhe['status'] === 'E' ? 'selected' : '' ?>>Em Andamento</option>
                    <option value="R">Resolvido</option>
                </select>
            </div>
        </div>

        <div class="df-field">
            <label for="descricao_tramite">Anotação / Encaminhamento <span style="color:var(--error)">*</span></label>
            <textarea name="descricao" id="descricao_tramite" rows="3"
                      placeholder="EX: ENCAMINHADO AO JARDINEIRO PARA VERIFICAÇÃO..."
                      required data-uppercase
                      style="resize:vertical"></textarea>
        </div>

        <div class="df-actions" style="margin-top:0">
            <button type="button" class="btn-ghost" data-close-detalhe>Fechar</button>
            <button type="submit" class="btn-primary">
                <i class="fa-solid fa-arrow-right" style="margin-right:6px"></i>Registrar Tramitação
            </button>
        </div>
    </form>
    <?php else: ?>
    <div class="df-actions" style="margin-top:16px">
        <button type="button" class="btn-ghost" data-close-detalhe>Fechar</button>
    </div>
    <?php endif; ?>

</div>
