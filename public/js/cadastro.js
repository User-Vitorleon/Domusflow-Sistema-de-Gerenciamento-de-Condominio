

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
    const inputApto      = form.querySelector('input[name="user_apto"]');
    const inputBloco     = form.querySelector('input[name="user_bloco"]');
    const inputPerfil    = form.querySelector('select[name="user_privilegio"]');
    const unidadeNote    = document.getElementById('cadUnidadeNote');

    inputApto?.addEventListener('input', function () {
        this.value = this.value.replace(/\D/g, '').slice(0, 4);
        if (/^\d+$/.test(this.value)) clearFieldError(this);
    });

    inputBloco?.addEventListener('input', function () {
        this.value = this.value.replace(/[^a-zA-Z]/g, '').slice(0, 1).toUpperCase();
        if (/^[A-Z]$/.test(this.value)) clearFieldError(this);
    });

    const aplicarUnidadePorPerfil = () => {
        const perfil = inputPerfil?.value;
        const administrativo = perfil === '3' || perfil === '4';

        if (administrativo) {
            if (inputApto) inputApto.value = '0';
            if (inputBloco) inputBloco.value = 'G';
            if (inputApto) clearFieldError(inputApto);
            if (inputBloco) clearFieldError(inputBloco);
        }

        [inputApto, inputBloco].forEach((input) => {
            if (!input) return;
            input.readOnly = administrativo;
            input.classList.toggle('is-readonly', administrativo);
        });

        if (unidadeNote) unidadeNote.hidden = !administrativo;
    };

    inputPerfil?.addEventListener('change', aplicarUnidadePorPerfil);
    aplicarUnidadePorPerfil();

    inputCpf?.addEventListener('blur', function () {
        const cpf = this.value.replace(/\D/g, '');
        if (cpf && !cpfValido(cpf)) {
            showFieldError(this, 'CPF inválido.');
        } else {
            clearFieldError(this);
        }
    });

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
        if (inputCpf && !cpfValido(inputCpf.value.replace(/\D/g, ''))) {
            showFieldError(inputCpf, 'CPF inválido.');
            valido = false;
        }
        if (inputApto && !/^\d+$/.test(inputApto.value)) {
            showFieldError(inputApto, 'Use apenas números.');
            valido = false;
        }
        if (inputBloco && !/^[A-Z]$/.test(inputBloco.value)) {
            showFieldError(inputBloco, 'Use apenas uma letra.');
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

    function cpfValido(cpf) {
        if (!/^\d{11}$/.test(cpf) || /^(\d)\1{10}$/.test(cpf)) return false;
        for (let t = 9; t < 11; t++) {
            let soma = 0;
            for (let i = 0; i < t; i++) {
                soma += Number(cpf[i]) * ((t + 1) - i);
            }
            const digito = ((10 * soma) % 11) % 10;
            if (Number(cpf[t]) !== digito) return false;
        }
        return true;
    }
})();
