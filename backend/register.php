<?php
require 'db.php';

function userRegistry($username, $password, $email)
{
    try {
        global $pdo;
        // Hashear la contraseña
        $passwordHashed = password_hash($password, PASSWORD_BCRYPT);

        
        $sql = "INSERT INTO usuarios (id, username, password, email) 
                VALUES (usuarios_seq.NEXTVAL, :username, :password, :email)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'username' => $username,
            'password' => $passwordHashed,
            'email' => $email
        ]);

        // Registrar el éxito de la operación
        logDebug("Usuario Registrado");

        return true;

    } catch (Exception $e) {
        logError("Ocurrio un error: " . $e->getMessage());
        return false;
    }
}

// Funciones de logging
function logDebug($message) {
    // Simple función para loguear mensajes de depuración
    echo "DEBUG: $message\n";
}

function logError($message) {
    // Simple función para loguear mensajes de error
    echo "ERROR: $message\n";
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST') {

    // Verificamos que se haya recibido el email y el password
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $username = $_POST['email'];  // Usamos el email como nombre de usuario
        $password = $_POST['password'];

        // Llamamos a la función para registrar el usuario
        if (userRegistry($username, $password, $username)) {
            // Respuesta exitosa
            header("Location: ../login.html");
            exit(); // Asegúrate de detener el script después de la redirección
            
            
        } else {
            // Respuesta con error 500
            http_response_code(500);
            echo json_encode(["error" => "Error registrando el usuario"]);
        }

    } else {
        // Respuesta con error 400
        http_response_code(400);
        echo json_encode(["error" => "Email y password son requeridos"]);
    }

} else {
    // Método no permitido
    http_response_code(405);
    echo json_encode(["error" => "Método no permitido"]);
}
?>
