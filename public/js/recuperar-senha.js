(function () {
    'use strict';

    const cpfInput = document.getElementById('user_cpf');
    const form = document.querySelector('.lp-form');

    if (cpfInput && typeof maskCpf === 'function') {
        maskCpf(cpfInput);
    }

    form?.addEventListener('submit', (event) => {
        const cpf = (cpfInput?.value || '').replace(/\D/g, '');
        if (cpf.length !== 11) {
            event.preventDefault();
            cpfInput?.focus();
        }
    });
})();
