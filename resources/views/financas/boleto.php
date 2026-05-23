<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boleto — DomusFlow</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/boleto.css">
</head>
<body>

<div class="boleto-actions">
    <a href="<?= BASE_URL ?>/financeiro/historico" class="btn-voltar">← Voltar</a>
    <button class="btn-imprimir" onclick="window.print()">🖨️ Imprimir / Salvar PDF</button>
    <?php if ($lancamento['status'] === 'F'): ?>
        <form action="<?= BASE_URL ?>/financeiro/pagar" method="POST"
              onsubmit="return confirm('Confirma o pagamento deste boleto?')">
            <input type="hidden" name="id_lancamento" value="<?= $lancamento['id_lancamento'] ?>">
            <button type="submit" class="btn-imprimir">✅ Confirmar Pagamento</button>
        </form>
    <?php endif; ?>
</div>

<div class="boleto-wrapper">

    <div class="aviso-experimental">
        ⚠️ FUNCIONALIDADE EXPERIMENTAL — Este boleto é meramente ilustrativo e não possui validade bancária.
        O sistema de pagamento integrado estará disponível em versão futura do DomusFlow.
    </div>

    <!-- Cabeçalho -->
    <div class="boleto-header">
        <div class="logo">DomusFlow</div>
        <div class="banco">001-9</div>
        <div class="linha-digitavel">
            <?= substr(md5($lancamento['id_lancamento']), 0, 5) ?>.
            <?= substr(md5($lancamento['id_lancamento']), 5, 5) ?>
            <?= substr(md5($lancamento['id_lancamento']), 10, 6) ?>.
            <?= substr(md5($lancamento['id_lancamento']), 16, 6) ?>
            <?= substr(md5($lancamento['id_lancamento']), 22, 6) ?>.
            <?= substr(md5($lancamento['id_lancamento']), 28, 1) ?>
            <?= date('Ymd', strtotime($lancamento['data_vencimento'])) ?>
            <?= str_pad((int)($lancamento['valor'] * 100), 10, '0', STR_PAD_LEFT) ?>
        </div>
    </div>

    <!-- Corpo -->
    <div class="boleto-section">
        <div class="boleto-row">
            <div class="boleto-field">
                <label>Beneficiário</label>
                <span>Condomínio DomusFlow — CNPJ: 00.000.000/0001-00</span>
            </div>
            <div class="boleto-field w-auto">
                <label>Agência / Código do Beneficiário</label>
                <span>0001 / 000001-0</span>
            </div>
        </div>

        <div class="boleto-row">
            <div class="boleto-field">
                <label>Pagador</label>
                <span>
                    <?= htmlspecialchars($lancamento['nome']) ?> —
                    Ap. <?= htmlspecialchars($lancamento['apto']) ?>
                    Bl. <?= htmlspecialchars($lancamento['bloco']) ?>
                </span>
            </div>
            <div class="boleto-field w-auto">
                <label>CPF</label>
                <span>
                    <?= preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $lancamento['cpf']) ?>
                </span>
            </div>
        </div>

        <div class="boleto-row">
            <div class="boleto-field">
                <label>Descrição</label>
                <span><?= htmlspecialchars(strtoupper($lancamento['descricao'])) ?></span>
            </div>
            <div class="boleto-field w-auto">
                <label>Nosso Número</label>
                <span>
                    <?= str_pad($lancamento['id_lancamento'], 10, '0', STR_PAD_LEFT) ?>-<?= ($lancamento['id_lancamento'] % 9) + 1 ?>
                </span>
            </div>
        </div>

        <div class="boleto-row">
            <div class="boleto-field">
                <label>Local de Pagamento</label>
                <span>Pagável em qualquer banco ou internet banking até o vencimento</span>
            </div>
            <div class="boleto-field w-auto">
                <label>Vencimento</label>
                <span><?= date('d/m/Y', strtotime($lancamento['data_vencimento'])) ?></span>
            </div>
        </div>

        <div class="boleto-row">
            <div class="boleto-field">
                <label>Instrução</label>
                <span>Não receber após o vencimento. Após vencimento cobrar multa de 2% + juros de 0,033% ao dia.</span>
            </div>
            <div class="boleto-field w-auto valor-destaque">
                <label>Valor do Documento</label>
                <span>R$ <?= number_format($lancamento['valor'], 2, ',', '.') ?></span>
            </div>
        </div>

        <div class="boleto-row">
            <div class="boleto-field">
                <label>Data do Documento</label>
                <span><?= date('d/m/Y', strtotime($lancamento['data_lancamento'])) ?></span>
            </div>
            <div class="boleto-field">
                <label>Tipo</label>
                <span><?= ucfirst(strtolower($lancamento['modelo'])) ?></span>
            </div>
            <div class="boleto-field">
                <label>Aceite</label>
                <span>N</span>
            </div>
            <div class="boleto-field w-auto">
                <label>(-) Desconto</label>
                <span>R$ 0,00</span>
            </div>
        </div>

        <div class="boleto-row">
            <div class="boleto-field">
                <label>Autenticação Mecânica</label>
                <span></span>
            </div>
            <div class="boleto-field w-auto valor-destaque">
                <label>(=) Valor Cobrado</label>
                <span>R$ <?= number_format($lancamento['valor'], 2, ',', '.') ?></span>
            </div>
        </div>
    </div>

    <!-- Código de barras -->
    <div class="codigo-barras-wrap">
        <p class="instrucoes">Corte aqui e pague em qualquer banco ou internet banking</p>

        <div class="barras">
            <?php
            $seed = $lancamento['id_lancamento'] * 7 + (int)($lancamento['valor'] * 100);
            srand($seed);
            $tipos = ['fina', 'fina', 'media', 'larga'];
            for ($i = 0; $i < 80; $i++) {
                $tipo = $tipos[rand(0, 3)];
                echo "<div class='barra {$tipo}'></div>";
                if ($i % 5 === 4) {
                    echo "<div class='espaco'></div>";
                }
            }
            ?>
        </div>

        <div class="codigo-numero">
            <?= substr(md5($lancamento['id_lancamento']), 0, 5) ?>.<?= substr(md5($lancamento['id_lancamento']), 5, 5) ?>
            <?= substr(md5($lancamento['id_lancamento']), 10, 6) ?>.<?= substr(md5($lancamento['id_lancamento']), 16, 6) ?>
            <?= substr(md5($lancamento['id_lancamento']), 22, 6) ?>.<?= substr(md5($lancamento['id_lancamento']), 28, 1) ?>
            <?= date('Ymd', strtotime($lancamento['data_vencimento'])) ?>
            <?= str_pad((int)($lancamento['valor'] * 100), 10, '0', STR_PAD_LEFT) ?>
        </div>
    </div>

    <div class="boleto-footer">
        DomusFlow — Sistema de Gerenciamento de Condomínio &nbsp;|&nbsp;
        Gerado em <?= date('d/m/Y \à\s H:i') ?> &nbsp;|&nbsp;
        <strong>⚠️ Documento meramente ilustrativo — sem validade bancária</strong>
    </div>

</div>

</body>
</html>