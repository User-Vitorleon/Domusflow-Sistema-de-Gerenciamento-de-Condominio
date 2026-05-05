/* app.js — DomusFlow · Global
   Sidebar toggle · Nav ativo */

(function () {
    'use strict';

    // Sidebar toggle
    const sidebar = document.querySelector('.sidebar');
    const toggle = document.querySelector('.toggle');

    if (sidebar && toggle) {
        toggle.addEventListener('click', (e) => {
            e.stopPropagation();
            sidebar.classList.toggle('close');
        });
    }

    // Fecha sidebar ao clicar fora (mobile)
    document.addEventListener('click', (e) => {
        if (!sidebar) return;
        if (window.innerWidth < 768 && !sidebar.contains(e.target)) {
            sidebar.classList.add('close');
        }
    });

    // Marca nav-link ativo pela URL
    const currentPath = window.location.pathname;
    document.querySelectorAll('.nav-link a').forEach((link) => {
        const href = link.getAttribute('href');
        if (href && currentPath.endsWith(href.replace(/^.*\//, '/'))) {
            link.closest('.nav-link')?.classList.add('active');
        }
    });

})();