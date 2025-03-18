<?php
require 'db.php';
 
function registerSucursal($nombre, $direccion, $telefono, $ciudad) {
    try {
        global $pdo;
 
        $sql = "INSERT INTO sucursales (id_sede, nombre, direccion, telefono, ciudad)
                VALUES (sucursales_seq.NEXTVAL, :nombre, :direccion, :telefono, :ciudad)";
 
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'nombre' => $nombre,
            'direccion' => $direccion,
            'telefono' => $telefono,
            'ciudad' => $ciudad
        ]);
 
        return true;
 
    } catch (Exception $e) {
        return false;
    }
}
 
function getSucursalById($id_sede) {
    try {
        global $pdo;
 
        $sql = "SELECT * FROM sucursales WHERE id_sede = :id_sede";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id_sede' => $id_sede]);
 
        return $stmt->fetch(PDO::FETCH_ASSOC);
 
    } catch (Exception $e) {
        return null;
    }
}
 
function updateSucursal($id_sede, $nombre, $direccion, $telefono, $ciudad) {
    try {
        global $pdo;
 
        $sql = "UPDATE sucursales
                SET nombre = :nombre, direccion = :direccion, telefono = :telefono, ciudad = :ciudad
                WHERE id_sede = :id_sede";
 
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'id_sede' => $id_sede,
            'nombre' => $nombre,
            'direccion' => $direccion,
            'telefono' => $telefono,
            'ciudad' => $ciudad
        ]);
 
        return true;
 
    } catch (Exception $e) {
        return false;
    }
}
 
function deleteSucursalById($id_sede) {
    try {
        global $pdo;
 
        $sql = "DELETE FROM sucursales WHERE id_sede = :id_sede";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id_sede' => $id_sede]);
 
        return $stmt->rowCount() > 0;
 
    } catch (Exception $e) {
        return false;
    }
}
 
$method = $_SERVER['REQUEST_METHOD'];
 
switch ($method) {
    case 'GET':
        if (isset($_GET['id_sede'])) {
            $sucursal = getSucursalById($_GET['id_sede']);
 
            if ($sucursal) {
                echo json_encode($sucursal);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Sucursal no encontrada']);
            }
        }
        break;
 
    case 'POST':
        if (isset($_POST['nombre'], $_POST['direccion'], $_POST['telefono'], $_POST['ciudad'])) {
            if (registerSucursal($_POST['nombre'], $_POST['direccion'], $_POST['telefono'], $_POST['ciudad'])) {
                echo json_encode(['success' => 'Sucursal registrada exitosamente']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Error al registrar la sucursal']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Todos los campos son requeridos']);
        }
        break;
 
    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
 
        if (isset($data['id_sede'], $data['nombre'], $data['direccion'], $data['telefono'], $data['ciudad'])) {
            if (updateSucursal($data['id_sede'], $data['nombre'], $data['direccion'], $data['telefono'], $data['ciudad'])) {
                echo json_encode(['success' => 'Sucursal actualizada exitosamente']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Error al actualizar la sucursal']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Todos los campos son requeridos']);
        }
        break;
 
    case 'DELETE':
        $data = json_decode(file_get_contents('php://input'), true);
 
        if (isset($data['id_sede'])) {
            if (deleteSucursalById($data['id_sede'])) {
                echo json_encode(['success' => 'Sucursal eliminada exitosamente']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Error al eliminar la sucursal']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'id_sede no proporcionado']);
        }
        break;
 
    default:
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
        break;
}
?>
 