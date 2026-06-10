document.addEventListener('DOMContentLoaded', function () {
    document.querySelector('[data-print-boleto]')?.addEventListener('click', function () {
        window.print();
    });

    document.querySelectorAll('form[data-confirm-message]').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!confirm(form.dataset.confirmMessage || 'Confirma esta ação?')) {
                event.preventDefault();
            }
        });
    });
});
