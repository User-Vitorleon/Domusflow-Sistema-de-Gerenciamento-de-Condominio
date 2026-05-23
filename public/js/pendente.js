

(function () {
    'use strict';

    const BASE       = window.APP_BASE_URL || '';
    const INTERVALO  = 10;
    const CHECK_URL  = BASE + '/pendente/checar';
    const REDIRECT   = BASE + '/dashboard';
    const ICONE_CHECK = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" '
                      + 'width="12" height="12"><polyline points="20 6 9 17 4 12"/></svg>';

    const contadorEl = document.getElementById('contador');
    let segundos = INTERVALO;

    function atualizarContador() {
        if (contadorEl) {
            contadorEl.textContent = segundos;
        }
    }

    function ativarAprovado() {
        const steps = document.querySelectorAll('.step');

        if (steps[1]) {
            steps[1].classList.remove('active');
            steps[1].classList.add('done');
            steps[1].querySelector('.step-dot').innerHTML = ICONE_CHECK;
        }
        if (steps[2]) {
            steps[2].classList.add('active');
            steps[2].querySelector('.step-dot').innerHTML = ICONE_CHECK;
            steps[2].querySelector('span').textContent = 'Acesso liberado! Redirecionando…';
        }
    }

    function checarAprovacao() {
        fetch(CHECK_URL, { credentials: 'same-origin' })
            .then(function (res) {
                if (!res.ok) {
                    throw new Error('Resposta inválida');
                }
                return res.json();
            })
            .then(function (data) {
                if (data.aprovado) {
                    ativarAprovado();
                    setTimeout(function () {
                        window.location.href = REDIRECT;
                    }, 1200);
                }
            })
            .catch(function (err) {
                console.warn('Erro ao checar aprovação:', err);
            });
    }


    setInterval(function () {
        segundos -= 1;
        atualizarContador();

        if (segundos <= 0) {
            segundos = INTERVALO;
            atualizarContador();
            checarAprovacao();
        }
    }, 1000);

r
    checarAprovacao();
})();
