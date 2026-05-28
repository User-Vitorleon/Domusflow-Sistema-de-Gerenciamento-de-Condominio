document.addEventListener('DOMContentLoaded', function () {
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


    // ── Timeout de inatividade ──────────────────────────────────────────
    if (document.querySelector('.df-topbar')) {    // if para validar se tem sessao ativa
        (function () {
        const TIMEOUT_MS = 10 * 1000; // 10 segundos (mudar para 10 * 60 * 1000 em produção)
        const AVISO_MS   = 5 * 1000;  // aviso 5 segundos antes

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
                            <button onclick="document.getElementById('df-inatividade-modal').remove(); resetarInatividade();">
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