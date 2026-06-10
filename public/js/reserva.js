

(function () {
    'use strict';

    const URL_FERIADOS  = 'https://brasilapi.com.br/api/feriados/v1/';
    const CACHE_FERIADOS = {}; 
    document.addEventListener('DOMContentLoaded', function () {
        configurarCapacidade();
        configurarAlertaFeriado();
    });


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
            }
        });
    }


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
