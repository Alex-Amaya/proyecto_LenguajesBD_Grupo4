document.addEventListener('DOMContentLoaded', function () {
    const ventaForm = document.getElementById('ventaForm');

    if (ventaForm) {
        ventaForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const ID_USUARIO = document.getElementById('ID_USUARIO').value;
            const ID_PRODUCTO = document.getElementById('ID_PRODUCTO').value;
            const CANTIDAD = document.getElementById('CANTIDAD').value;
            const TOTAL = document.getElementById('TOTAL').value;
            const FECHA_VENTA = document.getElementById('FECHA_VENTA').value;

            const ventaData = {
                ID_USUARIO: ID_USUARIO,
                ID_PRODUCTO: ID_PRODUCTO,
                CANTIDAD: CANTIDAD,
                TOTAL: TOTAL,
                FECHA_VENTA: FECHA_VENTA
            };

            fetch('/backend/ventas.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(ventaData)
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.success);
                        ventaForm.reset();
                    } else {
                        alert(data.error);
                    }
                })
                .catch(error => {
                    console.error('Error al registrar la venta:', error);
                    alert('Ocurrió un error al registrar la venta.');
                });
        });
    } else {
        console.error('No se encontró el formulario de ventas.');
    }
});