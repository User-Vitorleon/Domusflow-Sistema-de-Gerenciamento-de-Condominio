/* login.js — DomusFlow · Tela de login
<<<<<<< HEAD
   Toggle olho · Máscara CPF */
=======
   Máscara CPF · Toggle de senha (reaproveita utils.js) */
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)

(function () {
    'use strict';

<<<<<<< HEAD
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
=======
    const inputCpf = document.getElementById('user_cpf');
    if (inputCpf) {
        maskCpf(inputCpf);
    }

    const btnOlho = document.querySelector('.lp-eye');
    if (btnOlho) {
        togglePasswordVisibility(btnOlho, '.lp-field');
    }
})();
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
