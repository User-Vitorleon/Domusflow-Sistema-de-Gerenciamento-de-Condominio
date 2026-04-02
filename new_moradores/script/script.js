const body = document.querySelector('body'),
      sidebar = body.querySelector('nav'),
      toggle = body.querySelector(".toggle");

toggle.addEventListener("click" , () =>{
    sidebar.classList.toggle("close");
});

 //Verificação da URL apos a liberacao ou neg usuario
    document.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');

    if (status === 'liberado') {
        alert('O acesso do morador foi LIBERADO!');
        window.history.replaceState({}, document.title, window.location.pathname);
    } else if (status === 'negado') {
        alert('O acesso do morador foi NEGADO!');
        window.history.replaceState({}, document.title, window.location.pathname);
    }
});