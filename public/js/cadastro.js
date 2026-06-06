

(function () {
    'use strict';

    const RE_EMAIL = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;


    const inputCpf = document.getElementById('user_cpf');
    if (inputCpf) {
        maskCpf(inputCpf);
    }

    document
        .querySelectorAll('input[name="user_cell"], input[name="user_recado"]')
        .forEach(maskPhone);


    document
        .querySelectorAll('.cad-eye')
        .forEach((btn) => togglePasswordVisibility(btn, '.df-field'));

    const termosModal = document.getElementById('modalTermos');
    const termosCheck = document.getElementById('termos');
    const abrirTermos = () => {
        termosModal?.classList.add('is-open');
        termosModal?.setAttribute('aria-hidden', 'false');
    };
    const fecharTermos = () => {
        termosModal?.classList.remove('is-open');
        termosModal?.setAttribute('aria-hidden', 'true');
    };

    document.querySelectorAll('[data-termos-open]').forEach((link) => {
        link.addEventListener('click', (event) => {
            event.preventDefault();
            abrirTermos();
        });
    });
    document.querySelectorAll('[data-termos-close]').forEach((button) => {
        button.addEventListener('click', fecharTermos);
    });
    document.querySelectorAll('[data-termos-accept]').forEach((button) => {
        button.addEventListener('click', () => {
            if (termosCheck) termosCheck.checked = true;
            fecharTermos();
        });
    });
    termosModal?.addEventListener('click', (event) => {
        if (event.target === termosModal) fecharTermos();
    });

    const form = document.querySelector('form[action*="cadastro/salvar"]');
    if (!form) {
        return;
    }

    const inputSenha     = form.querySelector('input[name="user_senha"]');
    const inputConfirma  = form.querySelector('input[name="user_confirm_senha"]');
    const inputEmail     = form.querySelector('input[name="user_email"]');

    inputEmail?.addEventListener('blur', function () {
        if (this.value && !RE_EMAIL.test(this.value)) {
            showFieldError(this, 'Digite um e-mail válido.');
        } else {
            clearFieldError(this);
        }
    });

    inputConfirma?.addEventListener('input', function () {
        if (this.value && this.value !== inputSenha.value) {
            showFieldError(this, 'As senhas não coincidem.');
        } else {
            clearFieldError(this);
        }
    });

    form.addEventListener('submit', function (e) {
        let valido = true;

        if (inputEmail && !RE_EMAIL.test(inputEmail.value)) {
            showFieldError(inputEmail, 'Digite um e-mail válido.');
            valido = false;
        }
        if (inputSenha && inputConfirma && inputSenha.value !== inputConfirma.value) {
            showFieldError(inputConfirma, 'As senhas não coincidem.');
            valido = false;
        }
        if (!valido) {
            e.preventDefault();
        }
    });
})();
