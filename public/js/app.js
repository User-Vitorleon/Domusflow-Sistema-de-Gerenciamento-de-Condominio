(function () {
    'use strict';

    const sidebar = document.querySelector('.sidebar');
    const toggle = document.querySelector('.toggle');

    if (sidebar && toggle) {
        toggle.addEventListener('click', (e) => {
            e.stopPropagation();
            sidebar.classList.toggle('close');
        });
    }

    document.addEventListener('click', (e) => {
        if (!sidebar) {
            return;
        }
        if (window.innerWidth < 768 && !sidebar.contains(e.target)) {
            sidebar.classList.add('close');
        }
    });

    const currentPath = window.location.pathname;
    document.querySelectorAll('.nav-link a').forEach((link) => {
        const href = link.getAttribute('href');
        if (href && currentPath.endsWith(href.replace(/^.*\//, '/'))) {
            link.closest('.nav-link')?.classList.add('active');
        }
    });
})();
