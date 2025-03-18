<?php
require 'db.php';
 
function registerEquipo($nombre, $categoria, $estado, $fecha_ingreso, $id_sede) {
    try {
        global $pdo;
 
        $sql = "INSERT INTO equipos (id_equipo, nombre, categoria, estado, fecha_ingreso, id_sede)
                VALUES (equipos_seq.NEXTVAL, :nombre, :categoria, :estado, TO_DATE(:fecha_ingreso, 'YYYY-MM-DD'), :id_sede)";
 
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'nombre' => $nombre,
            'categoria' => $categoria,
            'estado' => $estado,
            'fecha_ingreso' => $fecha_ingreso,
            'id_sede' => $id_sede
        ]);
 
        return true;
 
    } catch (Exception $e) {
        return false;
    }
}
 
function getEquipoById($id_equipo) {
    try {
        global $pdo;
 
        $sql = "SELECT * FROM equipos WHERE id_equipo = :id_equipo";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id_equipo' => $id_equipo]);
 
        return $stmt->fetch(PDO::FETCH_ASSOC);
 
    } catch (Exception $e) {
        return null;
    }
}
 
function updateEquipo($id_equipo, $nombre, $categoria, $estado, $fecha_ingreso, $id_sede) {
    try {
        global $pdo;
 
        $sql = "UPDATE equipos
                SET nombre = :nombre, categoria = :categoria, estado = :estado, fecha_ingreso = TO_DATE(:fecha_ingreso, 'YYYY-MM-DD'), id_sede = :id_sede
                WHERE id_equipo = :id_equipo";
 
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'id_equipo' => $id_equipo,
            'nombre' => $nombre,
            'categoria' => $categoria,
            'estado' => $estado,
            'fecha_ingreso' => $fecha_ingreso,
            'id_sede' => $id_sede
        ]);
 
        return true;
 
    } catch (Exception $e) {
        return false;
    }
}
 
function deleteEquipoById($id_equipo) {
    try {
        global $pdo;
 
        $sql = "DELETE FROM equipos WHERE id_equipo = :id_equipo";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id_equipo' => $id_equipo]);
 
        return $stmt->rowCount() > 0;
 
    } catch (Exception $e) {
        return false;
    }
}
 
$method = $_SERVER['REQUEST_METHOD'];
 
switch ($method) {
    case 'GET':
        if (isset($_GET['id_equipo'])) {
            $equipo = getEquipoById($_GET['id_equipo']);
 
            if ($equipo) {
                echo json_encode($equipo);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Equipo no encontrado']);
            }
        }
        break;
 
    case 'POST':
        if (isset($_POST['nombre'], $_POST['categoria'], $_POST['estado'], $_POST['fecha_ingreso'], $_POST['id_sede'])) {
            if (registerEquipo($_POST['nombre'], $_POST['categoria'], $_POST['estado'], $_POST['fecha_ingreso'], $_POST['id_sede'])) {
                echo json_encode(['success' => 'Equipo registrado exitosamente']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Error al registrar el equipo']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Todos los campos son requeridos']);
        }
        break;
 
    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
 
        if (isset($data['id_equipo'], $data['nombre'], $data['categoria'], $data['estado'], $data['fecha_ingreso'], $data['id_sede'])) {
            if (updateEquipo($data['id_equipo'], $data['nombre'], $data['categoria'], $data['estado'], $data['fecha_ingreso'], $data['id_sede'])) {
                echo json_encode(['success' => 'Equipo actualizado exitosamente']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Error al actualizar el equipo']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Todos los campos son requeridos']);
        }
        break;
 
    case 'DELETE':
        $data = json_decode(file_get_contents('php://input'), true);
 
        if (isset($data['id_equipo'])) {
            if (deleteEquipoById($data['id_equipo'])) {
                echo json_encode(['success' => 'Equipo eliminado exitosamente']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Error al eliminar el equipo']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'id_equipo no proporcionado']);
        }
        break;
 
    default:
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
        break;
}
?>
 