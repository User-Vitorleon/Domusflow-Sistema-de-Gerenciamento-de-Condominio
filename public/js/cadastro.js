/* cadastro.js — DomusFlow · Tela de cadastro
<<<<<<< HEAD
   Máscaras · Toggle olho · Validação */
=======
   Máscaras · Toggle de senha · Validação inline */
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)

(function () {
    'use strict';

<<<<<<< HEAD
    // Máscaras
    const cpf = document.getElementById('user_cpf');
    if (cpf) maskCpf(cpf);

    document.querySelectorAll('input[name="user_cell"], input[name="user_recado"]')
        .forEach(maskPhone);

    // Toggle olho (senha + confirmar senha)
    document.querySelectorAll('.cad-eye').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const input = this.closest('.df-field').querySelector('input');
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            this.setAttribute('aria-pressed', String(isHidden));
            this.querySelector('.icon-show').style.display = isHidden ? 'none' : 'block';
            this.querySelector('.icon-hide').style.display = isHidden ? 'block' : 'none';
        });
    });

    // Validação
    const form = document.querySelector('form[action*="cadastro/salvar"]');
    if (!form) return;

    const senha = form.querySelector('input[name="user_senha"]');
    const confirma = form.querySelector('input[name="user_confirm_senha"]');
    const email = form.querySelector('input[name="user_email"]');
    const reEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    email?.addEventListener('blur', function () {
        if (this.value && !reEmail.test(this.value)) showFieldError(this, 'Digite um e-mail válido.');
        else clearFieldError(this);
    });

    confirma?.addEventListener('input', function () {
        if (this.value && this.value !== senha.value) showFieldError(this, 'As senhas não coincidem.');
        else clearFieldError(this);
=======
    const RE_EMAIL = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    // ── Máscaras de entrada ──────────────────────────
    const inputCpf = document.getElementById('user_cpf');
    if (inputCpf) {
        maskCpf(inputCpf);
    }

    document
        .querySelectorAll('input[name="user_cell"], input[name="user_recado"]')
        .forEach(maskPhone);

    // ── Toggle de senha (utilitário compartilhado) ───
    document
        .querySelectorAll('.cad-eye')
        .forEach((btn) => togglePasswordVisibility(btn, '.df-field'));

    // ── Validação ────────────────────────────────────
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
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
    });

    form.addEventListener('submit', function (e) {
        let valido = true;
<<<<<<< HEAD
        if (email && !reEmail.test(email.value)) { showFieldError(email, 'Digite um e-mail válido.'); valido = false; }
        if (senha && confirma && senha.value !== confirma.value) { showFieldError(confirma, 'As senhas não coincidem.'); valido = false; }
        if (!valido) e.preventDefault();
    });

})();
=======

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
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
