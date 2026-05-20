/* utils.js — DomusFlow · Utilitários reutilizáveis
<<<<<<< HEAD
   Máscaras · Helpers de erro inline
=======
   Máscaras · Helpers de erro inline · Toggle senha
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
   Inclua nas views que precisam via $jsExtra ou
   adicione ao footer.php se uso for global. */

// ── Máscara CPF ──────────────────────────────────
function maskCpf(input) {
    input.addEventListener('input', function () {
<<<<<<< HEAD
        let v = this.value.replace(/\D/g, '').slice(0, 11);
        v = v.replace(/(\d{3})(\d)/, '$1.$2');
        v = v.replace(/(\d{3})(\d)/, '$1.$2');
        v = v.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
        this.value = v;
=======
        let valor = this.value.replace(/\D/g, '').slice(0, 11);
        valor = valor.replace(/(\d{3})(\d)/, '$1.$2');
        valor = valor.replace(/(\d{3})(\d)/, '$1.$2');
        valor = valor.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
        this.value = valor;
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
    });
}

// ── Máscara Telefone ─────────────────────────────
function maskPhone(input) {
    input.addEventListener('input', function () {
<<<<<<< HEAD
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
=======
        let valor = this.value.replace(/\D/g, '').slice(0, 11);
        valor = valor.replace(/^(\d{2})(\d)/, '($1) $2');
        valor = valor.replace(/(\d{5})(\d{1,4})$/, '$1-$2');
        this.value = valor;
    });
}

// ── Máscara Placa de veículo (Mercosul ou antiga) ─
// Aceita só letras/dígitos, maiúsculo, no máximo 7 chars.
function maskPlaca(input) {
    function normalizar(valor) {
        return valor.toUpperCase().replace(/[^A-Z0-9]/g, '').slice(0, 7);
    }
    input.addEventListener('input', function () {
        this.value = normalizar(this.value);
    });
    input.addEventListener('paste', function (e) {
        e.preventDefault();
        const colado = (e.clipboardData || window.clipboardData).getData('text');
        this.value = normalizar(colado);
    });
}

// ── Erro inline em campos de formulário ──────────
function showFieldError(input, msg) {
    clearFieldError(input);
    input.style.borderColor = 'var(--error)';
    input.style.boxShadow   = '0 0 0 3px rgba(239,68,68,.12)';
    const span = document.createElement('span');
    span.className   = 'field-error-msg';
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
    span.textContent = msg;
    const field = input.closest('.df-field') || input.parentNode;
    field.appendChild(span);
}

function clearFieldError(input) {
    input.style.borderColor = '';
<<<<<<< HEAD
    input.style.boxShadow = '';
    const field = input.closest('.df-field') || input.parentNode;
    field.querySelector('.field-error-msg')?.remove();
}
=======
    input.style.boxShadow   = '';
    const field = input.closest('.df-field') || input.parentNode;
    field.querySelector('.field-error-msg')?.remove();
}

// ── Toggle de visibilidade de senha ──────────────
// O botão deve estar dentro de um wrapper (.df-field ou .lp-field)
// e conter dois ícones com classes .icon-show e .icon-hide.
function togglePasswordVisibility(btn, wrapperSelector) {
    btn.addEventListener('click', function () {
        const wrapper  = this.closest(wrapperSelector);
        const input    = wrapper?.querySelector('input');
        if (!input) {
            return;
        }
        const ocultoAgora = input.type === 'password';

        input.type = ocultoAgora ? 'text' : 'password';
        this.setAttribute('aria-pressed', String(ocultoAgora));

        const iconShow = this.querySelector('.icon-show');
        const iconHide = this.querySelector('.icon-hide');
        if (iconShow) { iconShow.style.display = ocultoAgora ? 'none'  : 'block'; }
        if (iconHide) { iconHide.style.display = ocultoAgora ? 'block' : 'none';  }
    });
}
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
