<?php
include "../conexion.php";
//require_once "../helper.php";
session_start();
ob_start();
header('Content-Type: application/json'); // Añadir encabezado para JSON

$response = [];
$correo = $_SESSION['correo'];

$sql_correo = "SELECT usuario.id_usuario FROM usuario WHERE usuario.correo LIKE '$correo'";
$id_usuario_result = $conexion->query($sql_correo);

//if (verificar_sesion($token, $usuario)) {
    // Leer el cuerpo de la solicitud
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($data['transactionId'])) {
        $transaction_id = $data['transactionId'];
        
        // Recibir carrito y cantidad
        $carrito = isset($data['carrito']) ? $data['carrito'] : array();
        $cantidad = isset($data['cantidad']) ? $data['cantidad'] : array();
        
        // Obtención de productos
        $productos = array();
        $ids = implode(',', array_map('intval', $carrito));
        $sql = "SELECT producto.id_producto, producto.nombre, producto.precio, producto.foto, inventario.stock, 
                sucursal.nombre as nom_suc, inventario.id_inventario
                FROM inventario 
                INNER JOIN producto ON (inventario.id_producto = producto.id_producto)
                INNER JOIN sucursal ON (inventario.id_sucursal = sucursal.id_sucursal)
                WHERE inventario.id_inventario IN ($ids)";
        $result = $conexion->query($sql);
        if ($result === false) {
            http_response_code(500);
            $response['error'] = "Error en la consulta: " . $conexion->error;
            echo json_encode($response);
            exit;
        } else {
            while ($row = $result->fetch_assoc()) {
                $productos[] = $row;
            }
        }

        $total = 0;
        $conexion->begin_transaction(); // Iniciar transacción
        try {

            if ($id_usuario_result->num_rows > 0) {
                $row = $id_usuario_result->fetch_assoc();
                $id_usuario = $row['id_usuario'];

                date_default_timezone_set('America/Mexico_City');
                $fecha_actual = date('Y-m-d H:i:s'); 
                
                $sql_venta = "INSERT INTO venta (fecha_venta, monto, id_usuario) VALUES ('$fecha_actual', 0.0, '$id_usuario');";
                
                if ($conexion->query($sql_venta) === TRUE) {
                    $last_id = $conexion->insert_id;
                    echo "LOS DATOS SE INSERTARON CORRECTAMENTE";
                } else {
                    throw new Exception("Error en la inserción: " . $conexion->error . " para el producto ID: $id_inventario");
                }
                
                
            }            
            foreach ($productos as $producto) {
                $index = array_search($producto['id_inventario'], $carrito);
                $id_inventario = $producto['id_inventario'];
                $subtotal = $producto['precio'] * $cantidad[$index];
                $total += $subtotal;
            
                $sql_insert = "INSERT INTO carrito_compra (subtotal, folio_venta, id_inventario, cantidad) VALUES ('$subtotal', '$last_id', '$id_inventario', '{$cantidad[$index]}')";
                $sql_up_stock = "UPDATE inventario SET stock = stock - '{$cantidad[$index]}' WHERE id_inventario = '$id_inventario'";
            
                if ($conexion->query($sql_insert) !== TRUE) {
                    throw new Exception("Error en la inserción: " . $conexion->error . " para el producto ID: $id_inventario");
                }
                if ($conexion->query($sql_up_stock) !== TRUE) {
                    throw new Exception("Error en la actualización de stock: " . $conexion->error . " para el producto ID: $id_inventario");
                }
            }
            
            



            $sql_venta_up = "UPDATE venta SET monto='$total' WHERE folio_venta = '$last_id'";
            if ($conexion->query($sql_venta_up) === TRUE) {
                echo "LOS DATOS SE ACTUALIZARON CORRECTAMENTE";
            }else{
                throw new Exception("Error en la inserción: " . $conexion->error . " para el producto ID: $id_inventario");
            }

            $conexion->commit(); // Confirmar transacción
            $response['success'] = "Transacción completada";
            $response['total'] = number_format($total);

            unset($_SESSION['carrito']);
            unset($_SESSION['cantidad']);
            
        } catch (Exception $e) {
            $conexion->rollback(); // Revertir transacción en caso de error
            http_response_code(500);
            $response['error'] = "Transacción fallida: " . $e->getMessage();
            echo json_encode($response);
            exit;
        }
    } else {
        $response['error'] = "Solicitud inválida.";
        http_response_code(400);

    }
/*} else {
    http_response_code(401);
    $response['error'] = "Sesión no válida.";
}*/

echo json_encode($response);
?>
