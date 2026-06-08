(function () {
    'use strict';

    const filtroNome = document.getElementById('filtroNome');
    const filtroAssembleia = document.getElementById('filtroAssembleia');
    const filtroData = document.getElementById('filtroData');
    const btnLimpar = document.querySelector('[data-presencas-limpar]');

    function filtrarPresencas() {
        const nome = (filtroNome?.value || '').toLowerCase();
        const assembleia = filtroAssembleia?.value || '';
        const data = filtroData?.value || '';

        document.querySelectorAll('#tabelaPresencas tr').forEach((row) => {
            const rowAssembleia = row.dataset.assembleia || '';
            const rowLocal = row.dataset.local || '';
            const rowData = row.dataset.data || '';
            const textoBusca = `${rowAssembleia} ${rowLocal}`.toLowerCase();

            let ok = true;
            if (nome && !textoBusca.includes(nome)) ok = false;
            if (assembleia && rowAssembleia !== assembleia) ok = false;
            if (data && rowData !== data) ok = false;

            row.style.display = ok ? '' : 'none';
        });
    }

    function limparFiltros() {
        if (filtroNome) filtroNome.value = '';
        if (filtroAssembleia) filtroAssembleia.value = '';
        if (filtroData) filtroData.value = '';
        filtrarPresencas();
    }

    filtroNome?.addEventListener('input', filtrarPresencas);
    filtroAssembleia?.addEventListener('change', filtrarPresencas);
    filtroData?.addEventListener('change', filtrarPresencas);
    btnLimpar?.addEventListener('click', limparFiltros);
})();
