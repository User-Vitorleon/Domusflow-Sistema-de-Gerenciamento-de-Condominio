/* ocorrencia.js — DomusFlow */

function escHtml(str) {
    if (!str) return '';
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;');
}

function formatDate(str) {
    if (!str) return '';
    const parts = str.split(' ');
    const d = parts[0].split('-');
    const t = parts[1] ? parts[1].substring(0, 5) : '';
    return d[2] + '/' + d[1] + '/' + d[0] + (t ? ' às ' + t : '');
}

function fecharDetalhe() {
    const modal = document.getElementById('modalDetalhe');
    if (modal) modal.style.display = 'none';
    document.body.style.overflow = '';
}

function fecharModalFotos() {
    const modal = document.getElementById('modalFotos');
    if (modal) modal.style.display = 'none';
    document.body.style.overflow = '';
}

function abrirModalFotos() {
    const modal = document.getElementById('modalFotos');
    if (modal) {
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
}

function validarTramite(form) {
    const status = form.querySelector('[name="status_novo"]')?.value || '';
    const desc = form.querySelector('[name="descricao"]')?.value.trim() || '';
    if (!status || !desc) {
        alert('Preencha o status e a descrição.');
        return false;
    }
    return true;
}

function toggleFiltros() {
    const body = document.getElementById('formFiltros');
    const chevron = document.getElementById('filtrosChevron');
    if (!body) return;
    const open = body.style.display !== 'none';
    body.style.display = open ? 'none' : 'block';
    if (chevron) chevron.classList.toggle('open', !open);
}

(function () {
    const params = new URLSearchParams(window.location.search);
    const campos = ['id_ocorrencia', 'morador', 'categoria', 'status', 'titulo', 'data_ini', 'data_fim'];
    const ativo = campos.some(c => params.get(c));
    if (!ativo) return;
    const body = document.getElementById('formFiltros');
    const chevron = document.getElementById('filtrosChevron');
    if (body) body.style.display = 'block';
    if (chevron) chevron.classList.add('open');
})();

document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
        fecharDetalhe();
        fecharModalFotos();
    }
});

function confirmarCancelamento(id, titulo) {
    const input = document.getElementById('inputIdCancelar');
    const label = document.getElementById('tituloParaCancelar');
    const modal = document.getElementById('modalCancelar');
    if (!input || !label || !modal) return;
    input.value = id;
    label.textContent = titulo;
    modal.style.display = 'flex';
}

window.abrirModalFotos = abrirModalFotos;
window.fecharModalFotos = fecharModalFotos;
window.abrirModalFotos = abrirModalFotos;
window.fecharModalFotos = fecharModalFotos;
window.fecharDetalhe = fecharDetalhe;
window.toggleFiltros = toggleFiltros;
window.confirmarCancelamento = confirmarCancelamento;
window.validarTramite = validarTramite;
window.toggleFiltros = toggleFiltros;
window.confirmarCancelamento = confirmarCancelamento;