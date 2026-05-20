/* login.js — DomusFlow · Tela de login
   Máscara CPF · Toggle de senha (reaproveita utils.js) */

(function () {
    'use strict';

    const inputCpf = document.getElementById('user_cpf');
    if (inputCpf) {
        maskCpf(inputCpf);
    }

    const btnOlho = document.querySelector('.lp-eye');
    if (btnOlho) {
        togglePasswordVisibility(btnOlho, '.lp-field');
    }
})();
