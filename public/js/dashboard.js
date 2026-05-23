(function () {
    'use strict';

    const { createApp } = Vue;

    const CORES_OCORRENCIAS = ['#EF4444', '#F59E0B', '#22C55E', '#94A3B8'];
    const LABELS_PADRAO = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
    const DADOS_PADRAO  = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

    function montarGraficoReservas() {
        const canvas = document.getElementById('chartReservas');
        if (!canvas) {
            return;
        }

        const labels = window.APP_DASHBOARD?.chartLabels ?? LABELS_PADRAO;
        const dados  = window.APP_DASHBOARD?.chartDados  ?? DADOS_PADRAO;

        new Chart(canvas, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Reservas',
                    data: dados,
                    backgroundColor: '#0d6efd',
                    borderRadius: 8,
                    maxBarThickness: 36
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        suggestedMax: 10,
                        ticks: {
                            precision: 0,
                            stepSize: 1
                        }
                    }
                }
            }
        });
    }

    function montarDoughnutOcorrencias(canvasId, configKey, opcoes = {}) {
        const canvas = document.getElementById(canvasId);
        if (!canvas) {
            return;
        }
        const config = window.APP_DASHBOARD?.[configKey];
        if (!config) {
            return;
        }

        new Chart(canvas, {
            type: 'doughnut',
            data: {
                labels: config.labels,
                datasets: [{
                    data: config.dados,
                    backgroundColor: CORES_OCORRENCIAS,
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: opcoes.maintainAspectRatio ?? false,
                plugins: {
                    legend: opcoes.legend ?? { position: 'bottom' }
                },
                cutout: opcoes.cutout ?? '68%'
            }
        });
    }

    function montarGraficoOcorrencias() {
        montarDoughnutOcorrencias('chartOcorrenciasMorador', 'chartOcorrenciasMorador');
    }

    function montarGraficoOcorrenciasSindico() {
        montarDoughnutOcorrencias('chartOcorrenciasSindico', 'chartOcorrenciasSindico', {
            maintainAspectRatio: true,
            legend: { display: false },
            cutout: '65%'
        });
    }

    function montarGraficoOcorrenciasAdmin() {
        montarDoughnutOcorrencias('chartOcorrenciasAdmin', 'chartOcorrenciasAdmin', {
            maintainAspectRatio: true,
            legend: { display: false },
            cutout: '65%'
        });
    }

    function montarTodosGraficos() {
        montarGraficoReservas();
        montarGraficoOcorrencias();
        montarGraficoOcorrenciasSindico();
        montarGraficoOcorrenciasAdmin();
    }

    const appEl = document.getElementById('app');

    if (appEl) {
        createApp({
            data() {
                return {
                    resumo: {
                        reservasPendentes: window.APP_DASHBOARD?.reservasPendentes ?? 0,
                        locaisDisponiveis: window.APP_DASHBOARD?.locaisDisponiveis ?? 0,
                        moradoresAtivos:   window.APP_DASHBOARD?.moradoresAtivos   ?? 0
                    }
                };
            },
            mounted() {
                montarTodosGraficos();
            }
        }).mount('#app');
    } else {
        document.addEventListener('DOMContentLoaded', montarTodosGraficos);
    }
})();
