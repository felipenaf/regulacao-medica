const paciente = document.getElementById('paciente');

paciente.addEventListener('change', function () {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "http://127.0.0.1:8000/paciente/" + paciente.value, true);
    xhr.send();

    xhr.onreadystatechange = () => {
        if(xhr.readyState === 4) {
            if(xhr.status === 200) {
                let data = JSON.parse(xhr.response).paciente

                document.getElementsByName('cpf')[0].value = data.cpf
                document.getElementsByName('cidade')[0].value = data.cidade
                document.getElementsByName('estado')[0].value = data.estado
            }
        }
    };
})
