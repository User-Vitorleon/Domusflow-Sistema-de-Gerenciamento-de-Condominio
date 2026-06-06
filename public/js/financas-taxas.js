document.addEventListener('DOMContentLoaded', () => {
    const formatMoneyInput = (input) => {
        const digits = input.value.replace(/\D/g, '');
        const cents = digits === '' ? 0 : parseInt(digits, 10);
        input.value = (cents / 100).toLocaleString('pt-BR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
        });
    };

    document.querySelectorAll('.js-money').forEach((input) => {
        if (input.value) {
            const initial = Number(String(input.value).replace(',', '.'));
            if (!Number.isNaN(initial)) {
                input.value = initial.toLocaleString('pt-BR', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2,
                });
            }
        }
        input.addEventListener('input', () => formatMoneyInput(input));
    });

    const normalizeMoneyFields = (form) => {
        Array.from(form.elements).forEach((input) => {
            if (input.classList && input.classList.contains('js-money')) {
                input.value = input.value.replace(/\./g, '').replace(',', '.');
            }
        });
    };

    document.querySelectorAll('form').forEach((form) => {
        form.addEventListener('submit', () => normalizeMoneyFields(form));
    });

    const finModal = document.getElementById('confirmFinanceiroModal');
    if (!finModal) return;

    const finPassword = document.getElementById('confirmFinanceiroPassword');
    const finTitle = document.getElementById('confirmFinanceiroTitle');
    const finMessage = document.getElementById('confirmFinanceiroMessage');
    const finSubmit = document.getElementById('confirmFinanceiroSubmit');
    let pendingFinForm = null;

    document.querySelectorAll('.js-confirm-financeiro').forEach((button) => {
        button.addEventListener('click', () => {
            pendingFinForm = button.form || button.closest('form');
            finTitle.textContent = button.dataset.title || 'Confirmar acao';
            finMessage.textContent = button.dataset.message || 'Informe sua senha para continuar.';
            finPassword.value = '';
            finModal.classList.add('is-open');
            finModal.setAttribute('aria-hidden', 'false');
            setTimeout(() => finPassword.focus(), 60);
        });
    });

    document.querySelectorAll('[data-fin-modal-close]').forEach((button) => {
        button.addEventListener('click', () => {
            finModal.classList.remove('is-open');
            finModal.setAttribute('aria-hidden', 'true');
            pendingFinForm = null;
        });
    });

    finSubmit.addEventListener('click', () => {
        if (!pendingFinForm || !finPassword.value.trim()) {
            finPassword.focus();
            return;
        }

        const passwordField = pendingFinForm.elements.admin_senha;
        if (!passwordField) return;

        passwordField.value = finPassword.value;
        normalizeMoneyFields(pendingFinForm);
        pendingFinForm.submit();
    });
});
