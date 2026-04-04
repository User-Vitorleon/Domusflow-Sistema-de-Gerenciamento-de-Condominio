/* ═══════════════════════════════════════════════════
   DomusFlow — dashboard.js
   Vue 3 · Chart.js · KPIs
═══════════════════════════════════════════════════ */

(function () {
    'use strict';

    const { createApp } = Vue;

    createApp({
        data() {
            return {
                resumo: {
                    reservasPendentes: window.APP_DASHBOARD?.reservasPendentes ?? 0,
                    locaisDisponiveis: window.APP_DASHBOARD?.locaisDisponiveis ?? 0,
                    moradoresAtivos: window.APP_DASHBOARD?.moradoresAtivos ?? 0,
                }
            };
        },
        mounted() {
            this.montarGrafico();
        },
        methods: {
            montarGrafico() {
                const canvas = document.getElementById('chartReservas');
                if (!canvas) return;

                const labels = window.APP_DASHBOARD?.chartLabels
                    ?? ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
                const dados = window.APP_DASHBOARD?.chartDados
                    ?? [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

                new Chart(canvas, {
                    type: 'bar',
                    data: {
                        labels,
                        datasets: [{
                            label: 'Reservas',
                            data: dados,
                            backgroundColor: 'rgba(15,128,182,.15)',
                            borderColor: '#0F80B6',
                            borderWidth: 2,
                            borderRadius: 6,
                            borderSkipped: false,
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#11446E',
                                titleFont: { family: '-apple-system, BlinkMacSystemFont, sans-serif', size: 12 },
                                bodyFont: { family: '-apple-system, BlinkMacSystemFont, sans-serif', size: 13 },
                                padding: 10,
                                cornerRadius: 8,
                            }
                        },
                        scales: {
                            x: {
                                grid: { display: false },
                                ticks: { font: { size: 12 }, color: '#374151' }
                            },
                            y: {
                                beginAtZero: true,
                                grid: { color: 'rgba(0,0,0,.06)' },
                                ticks: { font: { size: 12 }, color: '#374151', precision: 0 }
                            }
                        }
                    }
                });
            }
        }
    }).mount('#app');

})();