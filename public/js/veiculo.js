(function () {
    'use strict';

    const PRIVILEGIO_MORADOR = 1;

    const inputPlaca = document.querySelector('input[name="placa"], #inputPlaca');
    if (inputPlaca) {
        maskPlaca(inputPlaca);
    }

    const checkPrincipal = document.getElementById('principal');
    if (checkPrincipal) {
        checkPrincipal.addEventListener('change', function () {
            removerAvisoPrincipal();
            if (this.checked) {
                inserirAvisoPrincipal(this);
            }
        });
    }

    configurarMarcaModelo();
    bloquearFormularioSeAtingiuLimite();

    function removerAvisoPrincipal() {
        document.getElementById('aviso-principal')?.remove();
    }

    function inserirAvisoPrincipal(checkbox) {
        const aviso = document.createElement('small');
        aviso.id = 'aviso-principal';
        aviso.className = 'veiculo-principal-aviso';
        aviso.textContent = 'Este veiculo substituira o principal atual.';
        checkbox.closest('.df-field').appendChild(aviso);
    }

    function bloquearFormularioSeAtingiuLimite() {
        const form = document.querySelector('form[action*="veiculo/salvar"]');
        if (!form) return;

        const total = parseInt(form.dataset.total ?? '0', 10);
        const limite = parseInt(form.dataset.limite ?? '2', 10);
        const privilegio = parseInt(form.dataset.prev ?? '4', 10);

        if (privilegio !== PRIVILEGIO_MORADOR || total < limite) return;

        form.querySelectorAll('input, select, button[type="submit"]')
            .forEach((el) => {
                el.disabled = true;
            });

        const alerta = document.createElement('div');
        alerta.className = 'df-alert df-alert-warning';
        alerta.textContent = `Voce ja atingiu o limite de ${limite} veiculos cadastrados, apague ou acione o(a) Sindico(a).`;
        form.prepend(alerta);
    }

    function configurarMarcaModelo() {
        const form = document.querySelector('form[action*="veiculo/salvar"]');
        const marca = document.getElementById('selectMarcaVeiculo');
        const modelo = document.getElementById('selectModeloVeiculo');
        if (!form || !marca || !modelo) return;

        let catalogo = {};
        try {
            catalogo = JSON.parse(form.dataset.catalogoVeiculos || '{}');
        } catch {
            catalogo = {};
        }

        const resetModelo = (texto = 'Selecione a marca primeiro...') => {
            modelo.innerHTML = `<option value="">${texto}</option>`;
            modelo.disabled = true;
        };

        marca.addEventListener('change', () => {
            const modelos = catalogo[marca.value] || [];
            resetModelo(modelos.length ? 'Selecione...' : 'Nenhum modelo cadastrado');
            if (!modelos.length) return;

            modelos.forEach((item) => {
                const option = document.createElement('option');
                option.value = item;
                option.textContent = item;
                modelo.appendChild(option);
            });
            modelo.disabled = false;
        });

        form.addEventListener('reset', () => {
            setTimeout(() => resetModelo(), 0);
        });
    }
})();
