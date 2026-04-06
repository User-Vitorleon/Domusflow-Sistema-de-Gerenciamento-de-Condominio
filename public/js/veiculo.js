(function () {
    'use strict';

    // converte a placa para maiúsculo enquanto o usuário digita
    const placa = document.querySelector('input[name="placa"], #inputPlaca');
    if (placa) {
        placa.addEventListener('input', function () {
            this.value = this.value.toUpperCase();
        });
    }

})();