const status = document.getElementById('id_status');

status.addEventListener('change', function () {
    let motivo_reprovacao = document.getElementById('motivo_reprovacao');

    if (status.value === '3') {
        motivo_reprovacao.style.display = 'block'
    } else {
        motivo_reprovacao.style.display = 'none'
    }
})
