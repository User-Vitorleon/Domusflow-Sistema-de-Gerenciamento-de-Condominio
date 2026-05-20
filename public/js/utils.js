
function maskCpf(input) {
    input.addEventListener('input', function () {
        let valor = this.value.replace(/\D/g, '').slice(0, 11);
        valor = valor.replace(/(\d{3})(\d)/, '$1.$2');
        valor = valor.replace(/(\d{3})(\d)/, '$1.$2');
        valor = valor.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
        this.value = valor;
    });
}

function maskPhone(input) {
    input.addEventListener('input', function () {
        let valor = this.value.replace(/\D/g, '').slice(0, 11);
        valor = valor.replace(/^(\d{2})(\d)/, '($1) $2');
        valor = valor.replace(/(\d{5})(\d{1,4})$/, '$1-$2');
        this.value = valor;
    });
}

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


function showFieldError(input, msg) {
    clearFieldError(input);
    input.style.borderColor = 'var(--error)';
    input.style.boxShadow   = '0 0 0 3px rgba(239,68,68,.12)';
    const span = document.createElement('span');
    span.className   = 'field-error-msg';
    span.textContent = msg;
    const field = input.closest('.df-field') || input.parentNode;
    field.appendChild(span);
}

function clearFieldError(input) {
    input.style.borderColor = '';
    input.style.boxShadow   = '';
    const field = input.closest('.df-field') || input.parentNode;
    field.querySelector('.field-error-msg')?.remove();
}

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
