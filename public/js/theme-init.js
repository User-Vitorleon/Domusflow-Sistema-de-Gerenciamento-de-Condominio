(function () {
    const tema = localStorage.getItem('domusflow-tema');
    if (tema) {
        document.documentElement.setAttribute('data-theme', tema);
    }
})();
