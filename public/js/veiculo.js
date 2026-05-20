<<<<<<< HEAD
(function () {
    'use strict';

    // ── Placa: maiúsculo, só letras e números, máx 7 ──
    const placa = document.querySelector('input[name="placa"], #inputPlaca');
    if (placa) {
        placa.addEventListener('input', function () {
            this.value = this.value
                .toUpperCase()
                .replace(/[^A-Z0-9]/g, '')
                .slice(0, 7);
        });

        // bloqueia colar texto fora do padrão
        placa.addEventListener('paste', function (e) {
            e.preventDefault();
            const texto = (e.clipboardData || window.clipboardData)
                .getData('text')
                .toUpperCase()
                .replace(/[^A-Z0-9]/g, '')
                .slice(0, 7);
            this.value = texto;
        });
    }

    // ── Principal: só permite marcar se já houver 1 veículo cadastrado ──
    // (o backend bloqueia mesmo, mas dá feedback visual imediato)
    const checkPrincipal = document.getElementById('principal');
    if (checkPrincipal) {
        checkPrincipal.addEventListener('change', function () {
            const aviso = document.getElementById('aviso-principal');
            if (aviso) aviso.remove();

            if (this.checked) {
                const msg = document.createElement('small');
                msg.id = 'aviso-principal';
                msg.textContent = 'Este veículo substituirá o principal atual.';
                msg.style.cssText = 'color:#b45309; font-size:12px; margin-top:4px; display:block;';
                this.closest('.df-field').appendChild(msg);
=======
/* veiculo.js — DomusFlow · Cadastro/edição de veículos
   Máscara de placa · Aviso de "principal" · Limite de veículos */

(function () {
    'use strict';

    const LIMITE_VEICULOS_MORADOR = 2;
    const PRIVILEGIO_MORADOR      = 1;

    // ── Máscara de placa (utilitário compartilhado) ──
    const inputPlaca = document.querySelector('input[name="placa"], #inputPlaca');
    if (inputPlaca) {
        maskPlaca(inputPlaca);
    }

    // ── Aviso ao marcar veículo como principal ───────
    // (o backend impede de fato, isso é só feedback visual)
    const checkPrincipal = document.getElementById('principal');
    if (checkPrincipal) {
        checkPrincipal.addEventListener('change', function () {
            removerAvisoPrincipal();
            if (this.checked) {
                inserirAvisoPrincipal(this);
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
            }
        });
    }

<<<<<<< HEAD
    // ── Feedback visual do limite de veículos ──
    // O atributo data-total é preenchido pela view PHP
    const form = document.querySelector('form[action*="veiculo/salvar"]');
    if (form) {
        const total = parseInt(form.dataset.total ?? '0', 10);
        const privilegio = parseInt(form.dataset.prev ?? '4', 10);

        if (privilegio === 1 && total >= 2) {
            // desabilita o formulário visualmente
            form.querySelectorAll('input, select, button[type="submit"]')
                .forEach(el => el.disabled = true);

            const alerta = document.createElement('div');
            alerta.className = 'df-alert df-alert-warning';
            alerta.textContent = 'Você já atingiu o limite de 2 veículos cadastrados, apague ou acione o(a) Síndico(a)';
            form.prepend(alerta);
        }
    }

})();
=======
    // ── Bloqueio visual quando morador atinge o limite ─
    bloquearFormularioSeAtingiuLimite();

    // -----------------------------------------------------------------
    // Helpers
    // -----------------------------------------------------------------

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
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
