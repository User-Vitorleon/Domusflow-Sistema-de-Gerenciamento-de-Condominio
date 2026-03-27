// Incluindo nos campos Telefone e CPF, mascara
const handlePhone = (event) => {
    let input = event.target;
    input.value = phoneMask(input.value);
}

const phoneMask = (value) => {
    if (!value) return "";
    value = value.replace(/\D/g, "");
    value = value.replace(/(\d{2})(\d)/, "($1) $2");
    value = value.replace(/(\d{5})(\d)/, "$1-$2");
    return value;
}

const handleCPF = (event) => {
    let input = event.target;
    input.value = cpfMask(input.value);
}

const cpfMask = (value) => {
    if (!value) return "";
    value = value.replace(/\D/g, "");
    value = value.replace(/(\d{3})(\d)/, "$1.$2");
    value = value.replace(/(\d{3})(\d)/, "$1.$2");
    value = value.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
    return value;
}


window.onload = () => {
    const cpfInput = document.getElementById('user_cpf');
    const cellInput = document.getElementById('user_cell');
    const recadoInput = document.getElementById('user_recado');

    if(cpfInput) cpfInput.addEventListener('input', handleCPF); 
    if(cellInput) cellInput.addEventListener('input', handlePhone);
    if(recadoInput) recadoInput.addEventListener('input', handlePhone);
};

// FIM

// inicializacao do modal confirmando o cadastro bem sucedido

function mostrarSucessoERedirecionar() {

    const meuModal = new bootstrap.Modal(document.getElementById('modalSucesso'));
    meuModal.show();

    let tempo = 3;
    const campoTimer = document.getElementById('timer');


    const intervalo = setInterval(() => {
        tempo--;
        campoTimer.innerText = tempo;

        if (tempo <= 0) {
            clearInterval(intervalo);
            window.location.href = 'index.php'; 
        }
    }, 1000);
}

// fim