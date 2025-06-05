document.getElementById('msform').addEventListener('submit', function(e) {
    e.preventDefault();

    const nombre = document.getElementById("nombre").value;
    const pass = document.getElementById("pass").value;

    fetch('login.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ nombre, pass })
    })
    .then(res => res.json())
    .then(data => {
        const divRespuesta = document.getElementById('respuesta');
        if (data.success) {
            divRespuesta.innerHTML = `<span style="color:green">${data.message}</span>`;
            setTimeout(() => {
                window.location.href = "dashboard.php";
            }, 5000);
        } else {
            divRespuesta.innerHTML = `<span style="color:red">${data.message}</span>`;
        }
    })
    .catch(error => {
        console.error('Error al procesar la solicitud:', error);
        document.getElementById('respuesta').innerHTML = "Error de conexi n con el servidor.";
    });
});