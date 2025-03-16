document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('registroForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch('/backend/clientes.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                this.reset();
                alert(data.success);
            } else {
                alert(data.error);
            }
        })
        .catch(error => {
            alert('Ocurrió un error al procesar la solicitud');
        });
    });

});
