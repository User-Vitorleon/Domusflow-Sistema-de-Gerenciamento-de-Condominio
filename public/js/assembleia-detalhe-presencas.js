(function () {
    'use strict';

    const filtroNome = document.getElementById('filtroNome');
    const filtroPresenca = document.getElementById('filtroPresenca');

    function filtrarPresencas() {
        const nome = (filtroNome?.value || '').toLowerCase();
        const presenca = filtroPresenca?.value || '';
        let confirmadas = 0;
        let negadas = 0;
        let pendentes = 0;
        let total = 0;

        document.querySelectorAll('#tabelaPresencas tr').forEach((row) => {
            const rowNome = row.dataset.nome || '';
            const rowApto = row.dataset.apto || '';
            const rowBloco = row.dataset.bloco || '';
            const rowPresenca = row.dataset.presenca || '';

            let ok = true;
            if (nome && !rowNome.includes(nome) && !rowApto.includes(nome) && !rowBloco.includes(nome)) ok = false;
            if (presenca && rowPresenca !== presenca) ok = false;

            row.style.display = ok ? '' : 'none';

            if (ok) {
                total++;
                if (rowPresenca === 'S') confirmadas++;
                if (rowPresenca === 'N') negadas++;
                if (rowPresenca === 'P') pendentes++;
            }
        });

        const totalConfirmadas = document.getElementById('totalConfirmadas');
        const totalNegadas = document.getElementById('totalNegadas');
        const totalPendentes = document.getElementById('totalPendentes');
        const totalGeral = document.getElementById('totalGeral');

        if (totalConfirmadas) totalConfirmadas.textContent = confirmadas;
        if (totalNegadas) totalNegadas.textContent = negadas;
        if (totalPendentes) totalPendentes.textContent = pendentes;
        if (totalGeral) totalGeral.textContent = total;
    }

    filtroNome?.addEventListener('input', filtrarPresencas);
    filtroPresenca?.addEventListener('change', filtrarPresencas);
})();
