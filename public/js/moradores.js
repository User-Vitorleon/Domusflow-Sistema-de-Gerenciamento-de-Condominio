document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.btn-cpf-toggle').forEach((button) => {
        button.addEventListener('click', () => {
            const cell = button.closest('.cpf-cell');
            if (!cell) return;

            const mask = cell.querySelector('.cpf-mask');
            const real = cell.querySelector('.cpf-real');
            const icon = button.querySelector('i');

            if (!mask || !real || !icon) return;

            const mostrarCpf = mask.hidden === false || !mask.hidden;
            mask.hidden = mostrarCpf;
            real.hidden = !mostrarCpf;
            icon.className = mostrarCpf ? 'bx bx-hide' : 'bx bx-show';
            button.setAttribute('aria-label', mostrarCpf ? 'Ocultar CPF' : 'Mostrar CPF');
        });
    });

    const adminModal = document.getElementById('confirmAdminModal');
    if (!adminModal) return;

    const adminPassword = document.getElementById('confirmAdminPassword');
    const adminTitle = document.getElementById('confirmAdminTitle');
    const adminMessage = document.getElementById('confirmAdminMessage');
    const adminSubmit = document.getElementById('confirmAdminSubmit');
    let pendingAdminForm = null;

    const closeAdminModal = () => {
        adminModal.classList.remove('is-open');
        adminModal.setAttribute('aria-hidden', 'true');
        if (adminPassword) adminPassword.value = '';
        pendingAdminForm = null;
    };

    document.querySelectorAll('.js-confirm-admin').forEach((button) => {
        button.addEventListener('click', () => {
            if (button.disabled) return;

            pendingAdminForm = button.closest('form');
            adminTitle.textContent = button.dataset.title || 'Confirmar acao';
            adminMessage.textContent = button.dataset.message || 'Informe sua senha para continuar.';
            adminModal.classList.add('is-open');
            adminModal.setAttribute('aria-hidden', 'false');
            adminPassword.focus();
        });
    });

    document.querySelectorAll('[data-modal-close]').forEach((button) => {
        button.addEventListener('click', closeAdminModal);
    });

    adminPassword.addEventListener('keydown', (event) => {
        if (event.key === 'Enter') {
            adminSubmit.click();
        }
    });

    adminSubmit.addEventListener('click', () => {
        if (!pendingAdminForm || adminPassword.value.trim() === '') {
            adminPassword.focus();
            return;
        }

        pendingAdminForm.querySelector('input[name="admin_senha"]').value = adminPassword.value;
        pendingAdminForm.submit();
    });
});
