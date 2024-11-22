<?php
//Mandamos a llamar a la libreria y todas sus funciones
include 'C:\wamp64\www\integradora_diseno\conexion.php';
require('C:\wamp64\www\integradora_diseno\fpdf\fpdf.php');
session_start();
date_default_timezone_set('America/Mexico_City');
$correo = $_SESSION['correo'];

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $nombre_usuario = $_POST['nombre_cliente'];
    $direccion_usuario = $_POST['direccion_cliente'];
    $rfc_usuario = $_POST['rfc_cliente'];
    $cfdi = $_POST['cfdi'];
}


//ACTUALIZAR DATOS DEL FORMULARIO EN LA TABLA DE VENTA 
$sql_venta = "SELECT venta.folio_venta FROM venta
                    INNER JOIN usuario ON (venta.id_usuario=usuario.id_usuario) WHERE usuario.correo LIKE '$correo'
                ORDER BY venta.folio_venta DESC
                LIMIT 1";
$id_venta = $conexion->query($sql_venta);

//Funcion para contar el número de la factura
function getNextInvoiceNumber()
{
    $filename = 'C:\wamp64\www\integradora_diseno\user\invoice_number.txt';

    if (!file_exists($filename)) {
        file_put_contents($filename, '0');
    }

    $invoice_number = (int)file_get_contents($filename);
    $invoice_number += 1;
    file_put_contents($filename, $invoice_number);

    return $invoice_number;
}

$invoice_number = getNextInvoiceNumber();



if ($id_venta->num_rows > 0) {

    $row = $id_venta->fetch_assoc();
    $ult_id_venta = $row['folio_venta'];

    $sql_actu_datos_cliente = "UPDATE venta SET folio_fatura = '$invoice_number', rfc = '$rfc_usuario', fecha_facturacion = CURRENT_DATE(), cfdi = '$cfdi' WHERE venta.folio_venta = '$ult_id_venta'";

    if ($conexion->query($sql_actu_datos_cliente) === TRUE) {
        

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->AliasNbPages(); //Muestra la página y total de páginas
        $pdf->SetFont("Arial", 'b', 20);
        $pdf->Write(15, "Electronics For All", '');


        $pdf->SetFont("Arial", 'b', 12);
        $pdf->Ln(25);
        $pdf->Write(5, ("Col. San Andres Tetepilco"), '');
        $pdf->Ln();
        $pdf->Write(5, ("09440 Ciudad De Mexico, CDMX"), '');
        $pdf->Ln();
        $pdf->Write(5, ("electronics4all@efa.com.mx"), '');
        $pdf->Ln();
        $pdf->Write(5, ("4425972902"), '');
        $pdf->Ln(-5);
        $pdf->SetX(135);
        $pdf->Write(5, ("Fecha: ". date('D d M Y')), '');
            // $pdf->Cell(0, 10, 'Fecha: ' . date('Y-m-d H:i:s'), 0, 1, 'R');
        $pdf->Ln();
        $pdf->SetX(135);
        $pdf->SetFont("Arial", 'b', 12);
        $pdf->Write(5, ("No.Factura: ".$invoice_number), ''); //Se coloca el número de la factura



        $pdf->Ln(20);


        //COLOCAR LOS CAMPOS INGRESADOS EN EL FORMULARIO
        $pdf->SetFont("Arial", 'b', 12);
        $pdf->Write(5, ("Facturar a: "));
        $pdf->Ln();
        $pdf->SetFont("Arial", 'B', 12);
        $pdf->Write(5, ("RFC: ".$rfc_usuario), '');
        $pdf->Ln();
        $pdf->Write(5, ("Nombre: ".$nombre_usuario), '');
        $pdf->Ln();
        $pdf->Write(5, ("Direccion: ".$direccion_usuario), '');
        $pdf->Ln();
        $pdf->Write(5, ("CFDI: ".$cfdi), '');
        $pdf->Ln();

        $pdf->Line(13, 100, 13, 100);


        $pdf->SetFillColor(2, 117, 206);
        $pdf->SetTextColor(0,0,0);
        $pdf->Ln(15);
        $pdf->SetFont("Arial", 'b', 12);

        $pdf->Cell(80, 10,('Concepto'), 1, 0, 'C',1);
        $pdf->Cell(30, 10,('Cantidad'), 1, 0, 'C',1);
        $pdf->Cell(40, 10,('Precio'), 1, 0, 'C',1);
        $pdf->Cell(40, 10,('Importe'), 1, 1, 'C',1);

        $productos_facturar = mysqli_query($conexion, " SELECT  
                                                            producto.nombre AS concepto, 
                                                            (carrito_compra.cantidad) AS cantidad,
                                                            (producto.precio / 1.16) AS precio_original, 
                                                            (producto.precio * carrito_compra.cantidad) / 1.16 AS importe
                                                            FROM venta
                                                                INNER JOIN usuario ON (venta.id_usuario = usuario.id_usuario)
                                                                INNER JOIN carrito_compra ON (venta.folio_venta = carrito_compra.folio_venta)
                                                                INNER JOIN inventario ON (carrito_compra.id_inventario = inventario.id_inventario)
                                                                INNER JOIN producto ON (inventario.id_producto = producto.id_producto)
                                                            WHERE venta.folio_venta = '$ult_id_venta'
                                                            GROUP BY producto.id_producto
                                                            ORDER BY venta.folio_venta DESC;") 
                                                        or 
                                                        die ("Problemas al realizar la consulta: ".mysqli_error($conexion));

        $pdf->SetFillColor(192,192,194);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont("Arial", '', 10);

        while ($result_facturados = mysqli_fetch_array($productos_facturar)) {
            $pdf->Cell(80, 10,($result_facturados['concepto']), 1, 0, 'C',1);
            $pdf->Cell(30, 10,($result_facturados['cantidad']), 1, 0, 'C',1);
            $pdf->Cell(40, 10,('$'.round($result_facturados['precio_original'], 2)), 1, 0, 'C',1);
            $pdf->Cell(40, 10,('$'.round($result_facturados['importe'], 2)), 1, 1, 'C',1);
        }

        $pdf->SetFillColor(2, 117, 206);
        $pdf->SetTextColor(0,0,0);
        $pdf->Ln(15);
        $pdf->SetFont("Arial", 'b', 12);

        $pdf->Cell(63, 10,('Subtotal'), 1, 0, 'C',1);
        $pdf->Cell(64, 10,('IVA(16%)'), 1, 0, 'C',1);
        $pdf->Cell(63, 10,('Total'), 1, 1, 'C',1);

        $subt_iva_total = mysqli_query($conexion, "SELECT  
                                                        SUM((producto.precio * carrito_compra.cantidad) / 1.16) AS subtotal,
                                                        SUM((producto.precio * carrito_compra.cantidad) / 1.16) * 0.16 AS iva,
                                                        SUM((producto.precio * carrito_compra.cantidad) / 1.16) + SUM((producto.precio * carrito_compra.cantidad) / 1.16) * 0.16 AS total
                                                    FROM venta
                                                        INNER JOIN usuario ON (venta.id_usuario = usuario.id_usuario)
                                                        INNER JOIN carrito_compra ON (venta.folio_venta = carrito_compra.folio_venta)
                                                        INNER JOIN inventario ON (carrito_compra.id_inventario = inventario.id_inventario)
                                                        INNER JOIN producto ON (inventario.id_producto = producto.id_producto)
                                                    WHERE venta.folio_venta = '$ult_id_venta'
                                                    GROUP BY venta.folio_venta
                                                    ORDER BY venta.folio_venta DESC;")
                                                    or die ("Proeblemas con la conexión: ".mysqli_error($conexion));

        $pdf->SetFillColor(192,192,194);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont("Arial", '', 10);

        while ($result_subt_iva_total = mysqli_fetch_array($subt_iva_total)) {
            $pdf->Cell(63, 10,('$'.round($result_subt_iva_total['subtotal'],2 )), 1, 0, 'C',1);
            $pdf->Cell(64, 10,('$'.round($result_subt_iva_total['iva'], 2)), 1, 0, 'C',1);
            $pdf->Cell(63, 10,('$'.round($result_subt_iva_total['total'], 2)), 1, 1, 'C',1);
        }

        $pdf->Output('factura_integradora.pdf', 'i');
        
    }
}
else{
    echo"ERROR";
}
?>