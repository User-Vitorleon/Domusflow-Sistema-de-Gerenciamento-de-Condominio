/* ═══════════════════════════════════════════════════
   DomusFlow — dashboard.js
   Vue 3 · Chart.js · KPIs + Ocorrências Morador
═══════════════════════════════════════════════════ */

(function () {
    'use strict';

    const { createApp } = Vue;

    // ── Gráfico de Reservas (Síndico/Admin) ─────────────────
    function montarGraficoReservas() {
        const canvas = document.getElementById('chartReservas');
        if (!canvas) return;

        const labels = window.APP_DASHBOARD?.chartLabels
            ?? ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
        const dados = window.APP_DASHBOARD?.chartDados
            ?? [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

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

    // ── Gráfico de Ocorrências (Morador) ────────────────────
    function montarGraficoOcorrencias() {
        const canvas = document.getElementById('chartOcorrenciasMorador');
        if (!canvas) return;

        const config = window.APP_DASHBOARD?.chartOcorrenciasMorador;
        if (!config) return;

        new Chart(canvas, {
            type: 'doughnut',
            data: {
                labels: config.labels,
                datasets: [{
                    data: config.dados,
                    backgroundColor: ['#EF4444', '#F59E0B', '#22C55E', '#94A3B8'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' }
                },
                cutout: '68%'
            }
        });
    }

    // ── Vue App (KPIs — usado só se houver #app na view) ────
    const appEl = document.getElementById('app');

    if (appEl) {
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
                montarGraficoReservas();
                montarGraficoOcorrencias();
                montarGraficoOcorrenciasSindico();
                montarGraficoOcorrenciasAdmin();
            }
        }).mount('#app');
    } else {
        // Views sem Vue (morador, funcionario) — inicia gráficos diretamente
        document.addEventListener('DOMContentLoaded', function () {
            montarGraficoReservas();
            montarGraficoOcorrencias();
            montarGraficoOcorrenciasSindico();
            montarGraficoOcorrenciasAdmin();
        });
    }

    function montarGraficoOcorrenciasAdmin() {
        const canvas = document.getElementById('chartOcorrenciasAdmin');
        if (!canvas) return;
        const config = window.APP_DASHBOARD?.chartOcorrenciasAdmin;
        if (!config) return;
        new Chart(canvas, {
            type: 'doughnut',
            data: {
                labels: config.labels,
                datasets: [{
                    data: config.dados,
                    backgroundColor: ['#EF4444', '#F59E0B', '#22C55E', '#94A3B8'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: { legend: { display: false } },
                cutout: '65%'
            }
        });
    }
    function montarGraficoOcorrenciasSindico() {
        const canvas = document.getElementById('chartOcorrenciasSindico');
        if (!canvas) return;

        const config = window.APP_DASHBOARD?.chartOcorrenciasSindico;
        if (!config) return;

        new Chart(canvas, {
            type: 'doughnut',
            data: {
                labels: config.labels,
                datasets: [{
                    data: config.dados,
                    backgroundColor: ['#EF4444', '#F59E0B', '#22C55E', '#94A3B8'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { display: false }
                },
                cutout: '65%'
            }
        });
    }

})();