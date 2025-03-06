document.addEventListener('DOMContentLoaded', function () {
    const registerForm = document.getElementById('register-form');
    const registerError = document.getElementById('register-error');

    registerForm.addEventListener('submit', async function (e) {
        e.preventDefault();

        const username = document.getElementById('username').value.trim();
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value.trim();
        const confirmPassword = document.getElementById('confirm-password').value.trim();

        if (!username || !email || !password || !confirmPassword) {
            registerError.innerHTML = `<div class="alert alert-danger" role="alert">
                <strong>Error:</strong> Todos los campos son obligatorios.
            </div>`;
            return;
        }

        if (password !== confirmPassword) {
            registerError.innerHTML = `<div class="alert alert-danger" role="alert">
                <strong>Error:</strong> Las contraseñas no coinciden.
            </div>`;
            return;
        }

        const formData = new URLSearchParams();
        formData.append('username', username);
        formData.append('email', email);
        formData.append('password', password);

        try {
            const response = await fetch('backend/register.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: formData.toString()
            });

            if (response.ok) {
                registerError.innerHTML = `<div class="alert alert-success" role="alert">
                    <strong>Éxito:</strong> Usuario ${email} registrado correctamente.
                </div>`;
                
                setTimeout(function(){
                    registerError.innerHTML = "";
                    window.location.href = "login.html"; 
                }, 3000);
            } else {
                registerError.innerHTML = `<div class="alert alert-danger" role="alert">
                    <strong>Error:</strong> No se pudo registrar el usuario.
                </div>`;
            }
        } catch (error) {
            console.error(error);
            registerError.innerHTML = `<div class="alert alert-danger" role="alert">
                <strong>Error:</strong> Error al conectar con el servidor.
            </div>`;
        }
    });
});
