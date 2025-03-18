document.addEventListener('DOMContentLoaded', function () {
    const pagoForm = document.getElementById('pagoForm');

    if (pagoForm) {
        pagoForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const ID_CLIENTE = document.getElementById('ID_CLIENTE').value;
            const ID_MIEMBRO = document.getElementById('ID_MIEMBRO').value;
            const FECHA_PAGO = document.getElementById('FECHA_PAGO').value;
            const MONTO = document.getElementById('MONTO').value;
            const METODO_PAGO = document.getElementById('METODO_PAGO').value;

            const pagoData = {
                ID_CLIENTE: ID_CLIENTE,
                ID_MIEMBRO: ID_MIEMBRO,
                FECHA_PAGO: FECHA_PAGO,
                MONTO: MONTO,
                METODO_PAGO: METODO_PAGO
            };

            fetch('/backend/pagos.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(pagoData)
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.success);
                        pagoForm.reset();
                    } else {
                        alert(data.error);
                    }
                })
                .catch(error => {
                    console.error('Error al registrar el pago:', error);
                    alert('Ocurrió un error al registrar el pago.');
                });
        });
    } else {
        console.error('No se encontró el formulario de pagos.');
    }
});