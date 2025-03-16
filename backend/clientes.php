<?php
require 'db.php';

function userRegistry($cedula, $nombre, $apellido, $correo, $telefono, $direccion, $fecha_registro)
{
    try {
        global $pdo;

        $sql = "INSERT INTO usuarios (id_usuario, cedula, nombre, apellido, correo, telefono, direccion, fecha_registro)
                VALUES (usuarios_seq.NEXTVAL, :cedula, :nombre, :apellido, :correo, :telefono, :direccion, TO_DATE(:fecha_registro, 'YYYY-MM-DD'))";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'nombre' => $nombre,
            'cedula' => $cedula,
            'apellido' => $apellido,
            'correo' => $correo,
            'telefono' => $telefono,
            'direccion' => $direccion,
            'fecha_registro' => $fecha_registro
        ]);

        return true;

    } catch (Exception $e) {
        return false;
    }
}

function getClientByCedula($cedula)
{
    try {
        global $pdo;

        $sql = "SELECT * FROM usuarios WHERE cedula = :cedula";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['cedula' => $cedula]);
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($cliente) {
            return $cliente;
        } else {
            return false; 
        }
    } catch (Exception $e) {
        return false;
    }
}

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    case 'GET':

        if (isset($_GET['cedula'])) {
            $cedula = $_GET['cedula'];

            $cliente = getClientByCedula($cedula);

            if ($cliente) {
                echo json_encode(['success' => true, 'cliente' => $cliente]);
            } else {
                echo json_encode(['error' => 'Cliente no encontrado']);
            }
        } else {
            echo json_encode(['error' => 'Cédula requerida']);
        }
        break;


    case 'POST':

        if (isset($_POST['cedula']) && isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['correo']) && isset($_POST['telefono']) && isset($_POST['direccion']) && isset($_POST['fecha_registro'])) {
        
            $cedula = $_POST['cedula'];
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $correo = $_POST['correo'];
            $telefono = $_POST['telefono'];
            $direccion = $_POST['direccion'];
            $fecha_registro = $_POST['fecha_registro'];
    
            if (userRegistry($cedula, $nombre, $apellido, $correo, $telefono, $direccion, $fecha_registro)) {
                echo json_encode(["success" => "Usuario registrado exitosamente"]);
            } else {
                http_response_code(500);
                echo json_encode(["error" => "Error registrando el usuario"]);
            }
    
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Todos los campos son requeridos"]);
        }

}


?>
