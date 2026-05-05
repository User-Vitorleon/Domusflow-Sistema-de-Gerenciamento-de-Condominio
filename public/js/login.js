/* login.js — DomusFlow · Tela de login
   Toggle olho · Máscara CPF */

(function () {
    'use strict';

    // Máscara CPF
    const cpf = document.getElementById('user_cpf');
    if (cpf) maskCpf(cpf);

    // Toggle olho
    const btnOlho = document.querySelector('.lp-eye');
    if (!btnOlho) return;

    btnOlho.addEventListener('click', function () {
        const input = this.closest('.lp-field').querySelector('input');
        const isHidden = input.type === 'password';
        input.type = isHidden ? 'text' : 'password';
        this.setAttribute('aria-pressed', String(isHidden));
        this.querySelector('.icon-show').style.display = isHidden ? 'none' : 'block';
        this.querySelector('.icon-hide').style.display = isHidden ? 'block' : 'none';
    });

})();