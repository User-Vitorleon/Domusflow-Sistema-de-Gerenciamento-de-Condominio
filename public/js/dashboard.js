<<<<<<< HEAD
/* ═══════════════════════════════════════════════════
   DomusFlow — dashboard.js
   Vue 3 · Chart.js · KPIs + Ocorrências Morador
═══════════════════════════════════════════════════ */

=======
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
(function () {
    'use strict';

    const { createApp } = Vue;

<<<<<<< HEAD
    // ── Gráfico de Reservas (Síndico/Admin) ─────────────────
    function montarGraficoReservas() {
        const canvas = document.getElementById('chartReservas');
        if (!canvas) return;

        const labels = window.APP_DASHBOARD?.chartLabels
            ?? ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
        const dados = window.APP_DASHBOARD?.chartDados
            ?? [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
=======
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
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)

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

<<<<<<< HEAD
    // ── Gráfico de Ocorrências (Morador) ────────────────────
    function montarGraficoOcorrencias() {
        const canvas = document.getElementById('chartOcorrenciasMorador');
        if (!canvas) return;

        const config = window.APP_DASHBOARD?.chartOcorrenciasMorador;
        if (!config) return;
=======
    function montarDoughnutOcorrencias(canvasId, configKey, opcoes = {}) {
        const canvas = document.getElementById(canvasId);
        if (!canvas) {
            return;
        }
        const config = window.APP_DASHBOARD?.[configKey];
        if (!config) {
            return;
        }
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)

        new Chart(canvas, {
            type: 'doughnut',
            data: {
                labels: config.labels,
                datasets: [{
                    data: config.dados,
<<<<<<< HEAD
                    backgroundColor: ['#EF4444', '#F59E0B', '#22C55E', '#94A3B8'],
=======
                    backgroundColor: CORES_OCORRENCIAS,
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
<<<<<<< HEAD
                plugins: {
                    legend: { position: 'bottom' }
                },
                cutout: '68%'
=======
                maintainAspectRatio: opcoes.maintainAspectRatio ?? false,
                plugins: {
                    legend: opcoes.legend ?? { position: 'bottom' }
                },
                cutout: opcoes.cutout ?? '68%'
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
            }
        });
    }

<<<<<<< HEAD
    // ── Vue App (KPIs — usado só se houver #app na view) ────
=======
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

>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
    const appEl = document.getElementById('app');

    if (appEl) {
        createApp({
            data() {
                return {
                    resumo: {
                        reservasPendentes: window.APP_DASHBOARD?.reservasPendentes ?? 0,
                        locaisDisponiveis: window.APP_DASHBOARD?.locaisDisponiveis ?? 0,
<<<<<<< HEAD
                        moradoresAtivos: window.APP_DASHBOARD?.moradoresAtivos ?? 0,
=======
                        moradoresAtivos:   window.APP_DASHBOARD?.moradoresAtivos   ?? 0
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
                    }
                };
            },
            mounted() {
<<<<<<< HEAD
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
=======
                montarTodosGraficos();
            }
        }).mount('#app');
    } else {
        document.addEventListener('DOMContentLoaded', montarTodosGraficos);
    }
})();
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
