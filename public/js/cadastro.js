/* cadastro.js — DomusFlow · Tela de cadastro
   Máscaras · Toggle olho · Validação */

(function () {
    'use strict';

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
    });

    form.addEventListener('submit', function (e) {
        let valido = true;
        if (email && !reEmail.test(email.value)) { showFieldError(email, 'Digite um e-mail válido.'); valido = false; }
        if (senha && confirma && senha.value !== confirma.value) { showFieldError(confirma, 'As senhas não coincidem.'); valido = false; }
        if (!valido) e.preventDefault();
    });

})();