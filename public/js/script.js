document.addEventListener("DOMContentLoaded", function(event) {
    const status = document.getElementById('id_status');
    const motivo_reprovacao = document.getElementById('motivo_reprovacao');

    exibeOcultaByStatus(status, motivo_reprovacao)

    status.addEventListener('change', function () {
        exibeOcultaByStatus(status, motivo_reprovacao)
    })

    function exibeOcultaByStatus(status, motivo_reprovacao)
    {
        if (status.value === '3') {
            motivo_reprovacao.style.display = 'block'
        } else {
            motivo_reprovacao.style.display = 'none'
        }
    }
});

