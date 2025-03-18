<?php
require 'db.php';

function registrarPago($ID_CLIENTE, $ID_MIEMBRO, $FECHA_PAGO, $MONTO, $METODO_PAGO)
{
    try {
        global $pdo;

        $sql = "INSERT INTO pagos (ID_PAGO, ID_CLIENTE, ID_MIEMBRO, FECHA_PAGO, MONTO, METODO_PAGO)
                VALUES (pagos_seq.NEXTVAL, :ID_CLIENTE, :ID_MIEMBRO, TO_DATE(:FECHA_PAGO, 'YYYY-MM-DD'), :MONTO, :METODO_PAGO)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'ID_CLIENTE' => $ID_CLIENTE,
            'ID_MIEMBRO' => $ID_MIEMBRO,
            'FECHA_PAGO' => $FECHA_PAGO,
            'MONTO' => $MONTO,
            'METODO_PAGO' => $METODO_PAGO
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

        if (isset($data['ID_CLIENTE']) && isset($data['ID_MIEMBRO']) && isset($data['FECHA_PAGO']) && isset($data['MONTO']) && isset($data['METODO_PAGO'])) {
            $ID_CLIENTE = $data['ID_CLIENTE'];
            $ID_MIEMBRO = $data['ID_MIEMBRO'];
            $FECHA_PAGO = $data['FECHA_PAGO'];
            $MONTO = $data['MONTO'];
            $METODO_PAGO = $data['METODO_PAGO'];

            if (registrarPago($ID_CLIENTE, $ID_MIEMBRO, $FECHA_PAGO, $MONTO, $METODO_PAGO)) {
                echo json_encode(["success" => "Pago registrado exitosamente"]);
            } else {
                http_response_code(500);
                echo json_encode(["error" => "Error registrando el pago"]);
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