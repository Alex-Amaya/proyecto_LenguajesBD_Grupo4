<?php
require 'db.php';

function registrarVenta($ID_USUARIO, $ID_PRODUCTO, $CANTIDAD, $TOTAL, $FECHA_VENTA)
{
    try {
        global $pdo;

        $sql = "INSERT INTO ventas (ID_VENTA, ID_USUARIO, ID_PRODUCTO, CANTIDAD, TOTAL, FECHA_VENTA)
                VALUES (ventas_seq.NEXTVAL, :ID_USUARIO, :ID_PRODUCTO, :CANTIDAD, :TOTAL, TO_DATE(:FECHA_VENTA, 'YYYY-MM-DD'))";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'ID_USUARIO' => $ID_USUARIO,
            'ID_PRODUCTO' => $ID_PRODUCTO,
            'CANTIDAD' => $CANTIDAD,
            'TOTAL' => $TOTAL,
            'FECHA_VENTA' => $FECHA_VENTA
        ]);

        return true;

    } catch (Exception $e) {
        return false;
    }
}

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);

        if (isset($data['ID_USUARIO']) && isset($data['ID_PRODUCTO']) && isset($data['CANTIDAD']) && isset($data['TOTAL']) && isset($data['FECHA_VENTA'])) {
            $ID_USUARIO = $data['ID_USUARIO'];
            $ID_PRODUCTO = $data['ID_PRODUCTO'];
            $CANTIDAD = $data['CANTIDAD'];
            $TOTAL = $data['TOTAL'];
            $FECHA_VENTA = $data['FECHA_VENTA'];

            if (registrarVenta($ID_USUARIO, $ID_PRODUCTO, $CANTIDAD, $TOTAL, $FECHA_VENTA)) {
                echo json_encode(["success" => "Venta registrada exitosamente"]);
            } else {
                http_response_code(500);
                echo json_encode(["error" => "Error registrando la venta"]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Todos los campos son requeridos"]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(["error" => "Método no permitido"]);
        break;
}
?>