<<<<<<< HEAD
/* app.js — DomusFlow · Global
   Sidebar toggle · Nav ativo */

(function () {
    'use strict';

    // Sidebar toggle
=======
(function () {
    'use strict';

>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
    const sidebar = document.querySelector('.sidebar');
    const toggle = document.querySelector('.toggle');

    if (sidebar && toggle) {
        toggle.addEventListener('click', (e) => {
            e.stopPropagation();
            sidebar.classList.toggle('close');
        });
    }

<<<<<<< HEAD
    // Fecha sidebar ao clicar fora (mobile)
    document.addEventListener('click', (e) => {
        if (!sidebar) return;
=======
    document.addEventListener('click', (e) => {
        if (!sidebar) {
            return;
        }
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
        if (window.innerWidth < 768 && !sidebar.contains(e.target)) {
            sidebar.classList.add('close');
        }
    });

<<<<<<< HEAD
    // Marca nav-link ativo pela URL
=======
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
    const currentPath = window.location.pathname;
    document.querySelectorAll('.nav-link a').forEach((link) => {
        const href = link.getAttribute('href');
        if (href && currentPath.endsWith(href.replace(/^.*\//, '/'))) {
            link.closest('.nav-link')?.classList.add('active');
        }
    });
<<<<<<< HEAD

})();
=======
})();
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
