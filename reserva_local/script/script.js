const body = document.querySelector('body'),
      sidebar = body.querySelector('nav'),
      toggle = body.querySelector(".toggle");

toggle.addEventListener("click" , () =>{
    sidebar.classList.toggle("close");
});

document.addEventListener('DOMContentLoaded', function() {
    const selectLocal = document.getElementById('id_local');
    const inputCapacidade = document.getElementById('capacidade');
    const inputData = document.getElementById('data_reserva');
    const alertaFeriado = document.getElementById('alertaFeriado');
    const nomeFeriado = document.getElementById('nomeFeriado');

   // validar a capacidade do local escolhido
    selectLocal.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const cap = selectedOption.getAttribute('data-cap');
        inputCapacidade.value = cap ? cap + " pessoas" : "";
    });

    // consulta da api
    inputData.addEventListener('change', async function() {
        const dataSelecionada = this.value; 
        if (!dataSelecionada) return;

        const ano = dataSelecionada.split('-')[0];
        
        try {
            const response = await fetch(`https://brasilapi.com.br/api/feriados/v1/${ano}`);
            const feriados = await response.json();

           
            const feriadoEncontrado = feriados.find(f => f.date === dataSelecionada); // validar se a data escolhida pode ser um feriado ou proximo

            if (feriadoEncontrado) {
                nomeFeriado.innerText = feriadoEncontrado.name;
                alertaFeriado.classList.remove('d-none');
            } else {
                alertaFeriado.classList.add('d-none');
            }
        } catch (error) {
            console.error("Erro ao buscar feriados:", error);
        }
    });
});