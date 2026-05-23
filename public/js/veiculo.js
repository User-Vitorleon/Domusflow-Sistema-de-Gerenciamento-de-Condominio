
(function () {
    'use strict';

    const LIMITE_VEICULOS_MORADOR = 2;
    const PRIVILEGIO_MORADOR      = 1;


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

    bloquearFormularioSeAtingiuLimite();

    function removerAvisoPrincipal() {
        document.getElementById('aviso-principal')?.remove();
    }

    function inserirAvisoPrincipal(checkbox) {
        const aviso = document.createElement('small');
        aviso.id          = 'aviso-principal';
        aviso.textContent = 'Este veículo substituirá o principal atual.';
        aviso.style.cssText =
            'color:#b45309; font-size:12px; margin-top:4px; display:block;';
        checkbox.closest('.df-field').appendChild(aviso);
    }

    function bloquearFormularioSeAtingiuLimite() {
        const form = document.querySelector('form[action*="veiculo/salvar"]');
        if (!form) {
            return;
        }

        const total      = parseInt(form.dataset.total ?? '0', 10);
        const privilegio = parseInt(form.dataset.prev  ?? '4', 10);

        if (privilegio !== PRIVILEGIO_MORADOR || total < LIMITE_VEICULOS_MORADOR) {
            return;
        }

        form.querySelectorAll('input, select, button[type="submit"]')
            .forEach((el) => { el.disabled = true; });

        const alerta = document.createElement('div');
        alerta.className   = 'df-alert df-alert-warning';
        alerta.textContent =
            'Você já atingiu o limite de 2 veículos cadastrados, apague ou acione o(a) Síndico(a)';
        form.prepend(alerta);
    }
})();
