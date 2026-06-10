(function () {
    const metaBaseUrl = document.querySelector('meta[name="app-base-url"]');
    window.BASE_URL = window.BASE_URL || metaBaseUrl?.content || '';
})();

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-hide-on-error]').forEach(function (img) {
        function ocultarImagemQuebrada() {
            img.style.display = 'none';
            if (img.nextElementSibling) {
                img.nextElementSibling.style.display = 'block';
            }
        }

        img.addEventListener('error', function () {
            ocultarImagemQuebrada();
        });

        if (img.complete && img.naturalWidth === 0) {
            ocultarImagemQuebrada();
        }
    });

    document.querySelectorAll('[data-stop-propagation]').forEach(function (el) {
        el.addEventListener('click', function (event) {
            event.stopPropagation();
        });
    });

    document.querySelectorAll('form[data-confirm-message]').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!confirm(form.dataset.confirmMessage || 'Confirma esta ação?')) {
                event.preventDefault();
            }
        });
    });

    document.addEventListener('click', function (event) {
        if (event.target.closest('[data-inatividade-continuar]')) {
            document.getElementById('df-inatividade-modal')?.remove();
            window.resetarInatividade?.();
        }
    });
    const temaBtn  = document.getElementById('toggleTema');
    const iconeLua = document.getElementById('iconeLua');
    const iconeSol = document.getElementById('iconeSol');

    function aplicarTema(tema) {
        document.documentElement.setAttribute('data-theme', tema);
        if (!iconeLua || !iconeSol) return;
        if (tema === 'dark') {
            iconeLua.style.display = 'none';
            iconeSol.style.display = 'block';
        } else {
            iconeLua.style.display = 'block';
            iconeSol.style.display = 'none';
        }
    }

    const temaSalvo = localStorage.getItem('domusflow-tema') || 'light';
    aplicarTema(temaSalvo);

    if (temaBtn) {
        temaBtn.addEventListener('click', function () {
            const atual = document.documentElement.getAttribute('data-theme');
            const novo  = atual === 'dark' ? 'light' : 'dark';
            localStorage.setItem('domusflow-tema', novo);
            aplicarTema(novo);
        });
    }

    if (document.querySelector('.df-topbar')) {   
        (function () {
        const TIMEOUT_MS = 15 * 60 * 1000; 
        const AVISO_MS   = 1 * 60 * 1000;  

        let timerLogout, timerAviso;

        function resetar() {
            clearTimeout(timerLogout);
            clearTimeout(timerAviso);

            timerAviso = setTimeout(() => {
                if (document.getElementById('df-inatividade-modal')) return;
                const modal = document.createElement('div');
                    modal.id = 'df-inatividade-modal';
                    modal.className = 'df-inatividade-overlay';
                    modal.innerHTML = `
                        <div class="df-inatividade-box">
                            <i class='bx bx-time-five'></i>
                            <h4>Sessão expirando</h4>
                            <p>Você será desconectado por inatividade em alguns segundos.</p>
                            <button type="button" data-inatividade-continuar>
                                Continuar sessão
                            </button>
                        </div>`;
                    document.body.appendChild(modal);
            }, TIMEOUT_MS - AVISO_MS);

            timerLogout = setTimeout(() => {
                window.location.href = window.BASE_URL + '/logout';
            }, TIMEOUT_MS);
        }

        window.resetarInatividade = resetar;

        ['mousemove', 'keydown', 'click', 'scroll', 'touchstart'].forEach(ev => {
            document.addEventListener(ev, resetar, { passive: true });
        });

        resetar();
        })();
    }


});
