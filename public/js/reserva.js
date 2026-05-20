<<<<<<< HEAD
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
=======
/* reserva.js — DomusFlow · Tela de reservas
   Exibe capacidade do local · Avisa quando a data é feriado */

(function () {
    'use strict';

    const URL_FERIADOS  = 'https://brasilapi.com.br/api/feriados/v1/';
    const CACHE_FERIADOS = {}; // memoiza chamadas por ano para evitar refetch

    document.addEventListener('DOMContentLoaded', function () {
        configurarCapacidade();
        configurarAlertaFeriado();
    });

    // -----------------------------------------------------------------
    // Capacidade do local selecionado
    // -----------------------------------------------------------------

    function configurarCapacidade() {
        const selectLocal       = document.getElementById('id_local');
        const displayCapacidade = document.getElementById('capacidade_display');
        const inputConvidados   = document.querySelector('input[name="qtd_convidados"]');

        if (!selectLocal || !displayCapacidade) {
            return;
        }

        selectLocal.addEventListener('change', function () {
            const option     = this.options[this.selectedIndex];
            const capacidade = option.getAttribute('data-capacidade');

            if (!capacidade) {
                displayCapacidade.value = '';
                return;
            }

            displayCapacidade.value = `Limite: ${capacidade} pessoas`;
            if (inputConvidados) {
                inputConvidados.setAttribute('max', capacidade);
                if (parseInt(inputConvidados.value, 10) > parseInt(capacidade, 10)) {
                    inputConvidados.value = capacidade;
                }
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
            }
        });
    }

<<<<<<< HEAD
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
=======
    // -----------------------------------------------------------------
    // Alerta de feriado nacional (BrasilAPI)
    // -----------------------------------------------------------------

    function configurarAlertaFeriado() {
        const inputData     = document.getElementById('data_reserva');
        const alertaFeriado = document.getElementById('alertaFeriado');
        const nomeFeriado   = document.getElementById('nomeFeriado');

        if (!inputData) {
            return;
        }

        inputData.addEventListener('change', async function () {
            const data = this.value;
            if (!data) {
                return;
            }

            try {
                const feriados = await carregarFeriados(data.split('-')[0]);
                const encontrado = feriados.find((f) => f.date === data);
                aplicarAlertaFeriado(encontrado, alertaFeriado, nomeFeriado);
            } catch (error) {
                console.error('Erro ao consultar feriados:', error);
            }
        });
    }

    async function carregarFeriados(ano) {
        if (CACHE_FERIADOS[ano]) {
            return CACHE_FERIADOS[ano];
        }
        const response = await fetch(URL_FERIADOS + ano);
        if (!response.ok) {
            throw new Error('Erro na API de feriados');
        }
        CACHE_FERIADOS[ano] = await response.json();
        return CACHE_FERIADOS[ano];
    }

    function aplicarAlertaFeriado(feriado, alerta, nome) {
        if (feriado) {
            if (nome)   { nome.textContent = feriado.name; }
            if (alerta) { alerta.classList.remove('d-none'); }
            return;
        }
        if (alerta) {
            alerta.classList.add('d-none');
        }
    }
})();
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
