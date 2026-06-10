document.addEventListener('DOMContentLoaded', () => {
    const page = document.querySelector('[data-fin-lancamento-page]');
    if (!page) return;

    let todasTaxas = [];
    try {
        todasTaxas = JSON.parse(page.dataset.taxas || '[]');
    } catch {
        todasTaxas = [];
    }

    const tipo = document.getElementById('tipo');
    const descricao = document.getElementById('descricao');
    const valor = document.getElementById('valor');
    const todosMoradores = document.getElementById('todos_moradores');
    const campoMorador = document.getElementById('campo_morador');
    const formLancamento = document.querySelector('form[action*="lancamento/salvar"]');

    const resetDescricao = () => {
        if (descricao) descricao.innerHTML = '<option value="">Selecione o tipo primeiro...</option>';
        if (valor) valor.value = '';
    };

    const filtrarTaxas = () => {
        if (!tipo || !descricao || !valor) return;

        descricao.innerHTML = '<option value="">Selecione...</option>';
        valor.value = '';

        if (!tipo.value) return;

        const filtradas = todasTaxas.filter((taxa) => String(taxa.modulo).toLowerCase() === tipo.value);
        if (filtradas.length === 0) {
            descricao.innerHTML = '<option value="">Nenhum cadastrado</option>';
            return;
        }

        filtradas.forEach((taxa) => {
            const option = document.createElement('option');
            option.value = taxa.descricao;
            option.textContent = taxa.descricao;
            option.dataset.valor = taxa.valor;
            descricao.appendChild(option);
        });
    };

    const preencherValor = () => {
        if (!descricao || !valor) return;
        const option = descricao.options[descricao.selectedIndex];
        valor.value = option?.dataset.valor ?? '';
    };

    const toggleMorador = () => {
        if (!todosMoradores || !campoMorador) return;
        campoMorador.hidden = todosMoradores.checked;
        const select = campoMorador.querySelector('select');
        if (select) select.required = !todosMoradores.checked;
    };

    tipo?.addEventListener('change', filtrarTaxas);
    descricao?.addEventListener('change', preencherValor);
    todosMoradores?.addEventListener('change', toggleMorador);

    formLancamento?.addEventListener('reset', () => {
        setTimeout(() => {
            resetDescricao();
            toggleMorador();
        }, 0);
    });

    formLancamento?.addEventListener('submit', (event) => {
        const verificarUrl = page.dataset.verificarUrl;
        if (!verificarUrl) return;

        event.preventDefault();
        fetch(verificarUrl, {
            method: 'POST',
            body: new FormData(formLancamento),
        })
            .then((response) => response.json())
            .then((resposta) => {
                if (resposta.duplicado) {
                    let mensagem = 'Ja existe um lancamento com esses parametros em aberto neste mes.';
                    if (resposta.quantidade) {
                        mensagem += ` (${resposta.quantidade} morador(es) afetado(s))`;
                    }
                    mensagem += '\n\nDeseja continuar mesmo assim?';
                    if (confirm(mensagem)) formLancamento.submit();
                    return;
                }
                formLancamento.submit();
            })
            .catch(() => formLancamento.submit());
    });

    document.querySelectorAll('.js-confirm-delete-lancamento').forEach((form) => {
        form.addEventListener('submit', (event) => {
            if (!confirm('Deseja cancelar este lancamento?')) {
                event.preventDefault();
            }
        });
    });
});
