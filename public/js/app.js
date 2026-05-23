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
});