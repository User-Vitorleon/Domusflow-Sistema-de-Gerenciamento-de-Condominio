/* utils.js — DomusFlow · Utilitários reutilizáveis
   Máscaras · Helpers de erro inline
   Inclua nas views que precisam via $jsExtra ou
   adicione ao footer.php se uso for global. */

// ── Máscara CPF ──────────────────────────────────
function maskCpf(input) {
    input.addEventListener('input', function () {
        let v = this.value.replace(/\D/g, '').slice(0, 11);
        v = v.replace(/(\d{3})(\d)/, '$1.$2');
        v = v.replace(/(\d{3})(\d)/, '$1.$2');
        v = v.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
        this.value = v;
    });
}

// ── Máscara Telefone ─────────────────────────────
function maskPhone(input) {
    input.addEventListener('input', function () {
        let v = this.value.replace(/\D/g, '').slice(0, 11);
        v = v.replace(/^(\d{2})(\d)/, '($1) $2');
        v = v.replace(/(\d{5})(\d{1,4})$/, '$1-$2');
        this.value = v;
    });
}

// ── Erro inline ──────────────────────────────────
function showFieldError(input, msg) {
    clearFieldError(input);
    input.style.borderColor = 'var(--error)';
    input.style.boxShadow = '0 0 0 3px rgba(239,68,68,.12)';
    const span = document.createElement('span');
    span.className = 'field-error-msg';
    span.textContent = msg;
    const field = input.closest('.df-field') || input.parentNode;
    field.appendChild(span);
}

function clearFieldError(input) {
    input.style.borderColor = '';
    input.style.boxShadow = '';
    const field = input.closest('.df-field') || input.parentNode;
    field.querySelector('.field-error-msg')?.remove();
}