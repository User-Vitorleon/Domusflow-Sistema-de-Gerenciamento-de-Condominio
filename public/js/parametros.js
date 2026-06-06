document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('confirmParametroModal');
    if (!modal) return;

    const password = document.getElementById('confirmParametroPassword');
    const title = document.getElementById('confirmParametroTitle');
    const message = document.getElementById('confirmParametroMessage');
    const submit = document.getElementById('confirmParametroSubmit');
    let pendingForm = null;

    const closeModal = () => {
        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');
        password.value = '';
        pendingForm = null;
    };

    document.querySelectorAll('.js-confirm-parametro').forEach((button) => {
        button.addEventListener('click', () => {
            pendingForm = button.form;
            title.textContent = button.dataset.title || 'Confirmar alteracao';
            message.textContent = button.dataset.message || 'Informe sua senha para continuar.';
            modal.classList.add('is-open');
            modal.setAttribute('aria-hidden', 'false');
            password.focus();
        });
    });

    document.querySelectorAll('[data-param-modal-close]').forEach((button) => {
        button.addEventListener('click', closeModal);
    });

    password.addEventListener('keydown', (event) => {
        if (event.key === 'Enter') {
            submit.click();
        }
    });

    submit.addEventListener('click', () => {
        if (!pendingForm || password.value.trim() === '') {
            password.focus();
            return;
        }

        pendingForm.elements.admin_senha.value = password.value;
        pendingForm.submit();
    });
});
