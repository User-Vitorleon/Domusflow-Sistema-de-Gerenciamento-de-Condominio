/**
 * DomusFlow - Gestão de Reservas
 * Controla a exibição da capacidade e validação de feriados
 */
document.addEventListener('DOMContentLoaded', function() {
    
    // 1. Elementos da Capacidade
    const selectLocal = document.getElementById('id_local');
    const displayCapacidade = document.getElementById('capacidade_display');
    const inputConvidados = document.querySelector('input[name="qtd_convidados"]');

    // 2. Elementos de Feriado
    const inputData = document.getElementById('data_reserva');
    const alertaFeriado = document.getElementById('alertaFeriado');
    const nomeFeriado = document.getElementById('nomeFeriado');

    // --- LÓGICA DE CAPACIDADE ---
    if (selectLocal && displayCapacidade) {
        selectLocal.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            
            // Puxa o atributo data-capacidade do <option>
            const capacidade = selectedOption.getAttribute('data-capacidade');

            if (capacidade && capacidade !== "") {
                displayCapacidade.value = `Limite: ${capacidade} pessoas`;
                
                if (inputConvidados) {
                    inputConvidados.setAttribute('max', capacidade);
                    if (parseInt(inputConvidados.value) > parseInt(capacidade)) {
                        inputConvidados.value = capacidade;
                    }
                }
            } else {
                // Se selecionar "Selecione...", limpa o campo
                displayCapacidade.value = "";
            }
        });
    }

    // --- LÓGICA DE FERIADOS (BrasilAPI) ---
    if (inputData) {
        inputData.addEventListener('change', async function() {
            const dataSelecionada = this.value; 
            if(!dataSelecionada) return;

            const ano = dataSelecionada.split('-')[0];

            try {
                const response = await fetch(`https://brasilapi.com.br/api/feriados/v1/${ano}`);
                if (!response.ok) throw new Error("Erro na API");
                
                const feriados = await response.json();
                const feriadoEncontrado = feriados.find(f => f.date === dataSelecionada);

                if (feriadoEncontrado) {
                    if(nomeFeriado) nomeFeriado.textContent = feriadoEncontrado.name;
                    if(alertaFeriado) alertaFeriado.classList.remove('d-none');
                } else {
                    if(alertaFeriado) alertaFeriado.classList.add('d-none');
                }
            } catch (error) {
                console.error("Erro ao consultar feriados:", error);
            }
        });
    }
});