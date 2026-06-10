(function () {
    'use strict';

    function filtrarTabela(inputId, tabelaId) {
        const busca = (document.getElementById(inputId)?.value || '').toLowerCase();
        const dtVenc = inputId === 'buscaPendente'
            ? (document.getElementById('dtVencPendente')?.value || '')
            : (document.getElementById('dtVencGerada')?.value || '');

        document.querySelectorAll(`#${tabelaId} tr`).forEach((row) => {
            const desc = row.dataset.desc || '';
            const tipo = row.dataset.tipo || '';
            const dtRow = row.dataset.dtVenc || '';
            let ok = true;

            if (busca && !desc.includes(busca) && !tipo.includes(busca)) ok = false;
            if (dtVenc && dtRow !== dtVenc) ok = false;

            row.style.display = ok ? '' : 'none';
        });
    }

    function limparFiltro(inputId, dtId, tabelaId) {
        const input = document.getElementById(inputId);
        const data = document.getElementById(dtId);
        if (input) input.value = '';
        if (data) data.value = '';
        filtrarTabela(inputId, tabelaId);
    }

    document.querySelectorAll('[data-fin-historico-filter]').forEach((campo) => {
        const inputId = campo.dataset.input || '';
        const tabelaId = campo.dataset.tabela || '';
        const evento = campo.type === 'date' || campo.tagName === 'SELECT' ? 'change' : 'input';
        campo.addEventListener(evento, () => filtrarTabela(inputId, tabelaId));
    });

    document.querySelectorAll('[data-fin-historico-clear]').forEach((botao) => {
        botao.addEventListener('click', () => {
            limparFiltro(botao.dataset.input || '', botao.dataset.data || '', botao.dataset.tabela || '');
        });
    });
})();
