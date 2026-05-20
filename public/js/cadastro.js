

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
