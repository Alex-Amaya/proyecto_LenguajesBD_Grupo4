<?php
require 'db.php';
 
 
function registerMantenimiento($id_equipo, $fecha_mantenimiento, $descripcion, $estado) {
    try {
        global $pdo;
 
        $sql = "INSERT INTO mantenimientos (id_mantenimiento, id_equipo, fecha_mantenimiento, descripcion, estado)
                VALUES (mantenimientos_seq.NEXTVAL, :id_equipo, TO_DATE(:fecha_mantenimiento, 'YYYY-MM-DD'), :descripcion, :estado)";
 
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'id_equipo' => $id_equipo,
            'fecha_mantenimiento' => $fecha_mantenimiento,
            'descripcion' => $descripcion,
            'estado' => $estado
        ]);
 
        return true;
 
    } catch (Exception $e) {
        return false;
    }
}
 
function getMantenimientoById($id_mantenimiento) {
    try {
        global $pdo;
 
        $sql = "SELECT * FROM mantenimientos WHERE id_mantenimiento = :id_mantenimiento";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id_mantenimiento' => $id_mantenimiento]);
 
        return $stmt->fetch(PDO::FETCH_ASSOC);
 
    } catch (Exception $e) {
        return null;
    }
}
 
 
function updateMantenimiento($id_mantenimiento, $id_equipo, $fecha_mantenimiento, $descripcion, $estado) {
    try {
        global $pdo;
 
        $sql = "UPDATE mantenimientos
                SET id_equipo = :id_equipo, fecha_mantenimiento = TO_DATE(:fecha_mantenimiento, 'YYYY-MM-DD'), descripcion = :descripcion, estado = :estado
                WHERE id_mantenimiento = :id_mantenimiento";
 
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'id_mantenimiento' => $id_mantenimiento,
            'id_equipo' => $id_equipo,
            'fecha_mantenimiento' => $fecha_mantenimiento,
            'descripcion' => $descripcion,
            'estado' => $estado
        ]);
 
        return true;
 
    } catch (Exception $e) {
        return false;
    }
}
 
function deleteMantenimientoById($id_mantenimiento) {
    try {
        global $pdo;
 
        $sql = "DELETE FROM mantenimientos WHERE id_mantenimiento = :id_mantenimiento";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id_mantenimiento' => $id_mantenimiento]);
 
        return $stmt->rowCount() > 0;
 
    } catch (Exception $e) {
        return false;
    }
}
 
$method = $_SERVER['REQUEST_METHOD'];
 
switch ($method) {
    case 'GET':
        if (isset($_GET['id_mantenimiento'])) {
            $mantenimiento = getMantenimientoById($_GET['id_mantenimiento']);
 
            if ($mantenimiento) {
                echo json_encode($mantenimiento);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Mantenimiento no encontrado']);
            }
        }
        break;
 
    case 'POST':
        if (isset($_POST['id_equipo'], $_POST['fecha_mantenimiento'], $_POST['descripcion'], $_POST['estado'])) {
            if (registerMantenimiento($_POST['id_equipo'], $_POST['fecha_mantenimiento'], $_POST['descripcion'], $_POST['estado'])) {
                echo json_encode(['success' => 'Mantenimiento registrado exitosamente']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Error al registrar el mantenimiento']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Todos los campos son requeridos']);
        }
        break;
 
    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
 
        if (isset($data['id_mantenimiento'], $data['id_equipo'], $data['fecha_mantenimiento'], $data['descripcion'], $data['estado'])) {
            if (updateMantenimiento($data['id_mantenimiento'], $data['id_equipo'], $data['fecha_mantenimiento'], $data['descripcion'], $data['estado'])) {
                echo json_encode(['success' => 'Mantenimiento actualizado exitosamente']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Error al actualizar el mantenimiento']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Todos los campos son requeridos']);
        }
        break;
 
    case 'DELETE':
        $data = json_decode(file_get_contents('php://input'), true);
 
        if (isset($data['id_mantenimiento'])) {
            if (deleteMantenimientoById($data['id_mantenimiento'])) {
                echo json_encode(['success' => 'Mantenimiento eliminado exitosamente']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Error al eliminar el mantenimiento']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'id_mantenimiento no proporcionado']);
        }
        break;
 
    default:
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
        break;
}
?>
 