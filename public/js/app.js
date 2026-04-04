/* ═══════════════════════════════════════════════════
   DomusFlow — app.js (Global)
   Sidebar toggle · Máscaras CPF/Tel · Utilitários
═══════════════════════════════════════════════════ */

(function () {
    'use strict';

    // ── Sidebar Toggle ─────────────────────────────
    const sidebar = document.querySelector('.sidebar');
    const toggle = document.querySelector('.toggle');

    if (sidebar && toggle) {
        toggle.addEventListener('click', (e) => {
            e.stopPropagation(); // evita conflito com links internos
            sidebar.classList.toggle('close');
        });
    }

    // ── Fecha sidebar ao clicar fora (mobile) ──────
    document.addEventListener('click', (e) => {
        if (!sidebar) return;
        const isMobile = window.innerWidth < 768;
        if (isMobile && !sidebar.contains(e.target)) {
            sidebar.classList.add('close');
        }
    });

    // ── Marca nav-link ativo pela URL atual ────────
    const currentPath = window.location.pathname;
    document.querySelectorAll('.nav-link a').forEach((link) => {
        if (link.getAttribute('href') && currentPath.endsWith(link.getAttribute('href').replace(/^.*\//, '/'))) {
            link.closest('.nav-link')?.classList.add('active');
        }
    });

    // ── Máscara CPF ────────────────────────────────
    const cpfInput = document.getElementById('user_cpf');
    if (cpfInput) {
        cpfInput.addEventListener('input', function () {
            let v = this.value.replace(/\D/g, '').slice(0, 11);
            v = v.replace(/(\d{3})(\d)/, '$1.$2');
            v = v.replace(/(\d{3})(\d)/, '$1.$2');
            v = v.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
            this.value = v;
        });
    }

    // ── Máscara Telefone ───────────────────────────
    document.querySelectorAll('input[name="user_cell"], input[name="user_recado"]')
        .forEach((el) => {
            el.addEventListener('input', function () {
                let v = this.value.replace(/\D/g, '').slice(0, 11);
                v = v.replace(/^(\d{2})(\d)/, '($1) $2');
                v = v.replace(/(\d{5})(\d{1,4})$/, '$1-$2');
                this.value = v;
            });
        });

    // ── Validação do formulário de cadastro ────────────
    const formCadastro = document.querySelector('form[action*="cadastro/salvar"]');

    if (formCadastro) {
        const senha = formCadastro.querySelector('input[name="user_senha"]');
        const confirma = formCadastro.querySelector('input[name="user_confirm_senha"]');
        const email = formCadastro.querySelector('input[name="user_email"]');

        // Valida email em tempo real
        email?.addEventListener('blur', function () {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (this.value && !re.test(this.value)) {
                showFieldError(this, 'Digite um e-mail válido.');
            } else {
                clearFieldError(this);
            }
        });

        // Valida confirmação de senha em tempo real
        confirma?.addEventListener('input', function () {
            if (this.value && this.value !== senha.value) {
                showFieldError(this, 'As senhas não coincidem.');
            } else {
                clearFieldError(this);
            }
        });

        // Bloqueia submit se houver erro
        formCadastro.addEventListener('submit', function (e) {
            let valido = true;

            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (email && !re.test(email.value)) {
                showFieldError(email, 'Digite um e-mail válido.');
                valido = false;
            }

            if (senha && confirma && senha.value !== confirma.value) {
                showFieldError(confirma, 'As senhas não coincidem.');
                valido = false;
            }

            if (!valido) e.preventDefault();
        });
    }

    // ── Helpers de erro inline ─────────────────────────
    function showFieldError(input, msg) {
        clearFieldError(input);
        input.style.borderColor = 'var(--error)';
        input.style.boxShadow = '0 0 0 3px rgba(239,68,68,.12)';
        const span = document.createElement('span');
        span.className = 'field-error-msg';
        span.textContent = msg;
        input.parentNode.appendChild(span);
    }

    function clearFieldError(input) {
        input.style.borderColor = '';
        input.style.boxShadow = '';
        input.parentNode.querySelector('.field-error-msg')?.remove();
    }

})();