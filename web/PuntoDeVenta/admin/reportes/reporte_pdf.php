<?php    
    //Mandamos a llamar a la libreria y todas sus funciones
    require ('../../fpdf/fpdf.php'); 
    // require_once "/xampp/htdocs/INTEGRADORA/integradora_diseno/helper.php";
    // session_start();
    
    //Creamos la clase de pdf que heredará todo de FPDF
    class pdf extends FPDF
    {

    public function Header()
    {

        $this->SetFont("Arial", 'b', 15);
        $this->Image("../../imagenes/barra-navegacion/electronics.png",60,2,90,0,'png');
        $this->Ln(5);

        $expedicion = 'Fecha de expedición: ';
        $expedicion_utf8 = mb_convert_encoding($expedicion, 'ISO-8859-1', 'UTF-8');

        $this->SetFont('arial', 'b', 12);
        $this->SetX(65);
        $this->Write(30, $expedicion_utf8. date('d M Y'));
        $this->Ln(15);

        $this->SetFont('arial', 'b', 20);
        $this->SetX(70);
        $this->Write(20,'Reporte de ventas');
        $this->Ln();

        $this->SetFillColor(192,192,194);
        $this->SetTextColor(0,0,0);
        $this->SetFont('arial','', 10);
        $this->SetX(13.5);

        $this->SetFillColor(252,152,0);
        $this->SetTextColor(0,0,0);
        $this->SetFont('arial','b', 11);
        $this->SetX(27);
        //Cell(CoordsX, CoordsY, texto, border (1 para colocarlo), salto_linea(1 para saltar, 0 para no), llenar_celda ('C' si se quiere llenar), alinear (1 para si))
        $this->Cell(60, 10,('Nombre de producto'), 1, 0, 'C',1);
        $this->Cell(30, 10,('Precio unitario'),1,0, 'C',1);
        $this->Cell(21, 10,('Cantidad'), 1, 0, 'C', 1);
        $this->Cell(45, 10,('Fecha y hora de venta'), 1, 1, 'C',1);
    }

    public function Footer()
    {
        $this->SetFont('arial', 'b', 10);
        $this->SetY(-15);
        $this->SetX(-30);
        $this->AliasNbPages('tpagina');
        $this->Write(5, $this->PageNo().'/tpagina');
    }
}
include ("../../conexion.php"); //Se incluye la conexión


$pdf = new pdf();
$pdf->AddPage();
$pdf->AliasNbPages(); //Muestra la págia y total de páginas


$pdf->SetFont('Arial','',10);
$pdf->SetFillColor(192,192,194);
$pdf->SetTextColor(0,0,0);

$consultar_productos = mysqli_query($conexion, "SELECT *
                                                FROM reporte_ventas")
                                                or 
                                                die("Error al obtener la consulta: ".mysqli_error($conexion));

$contar_productos = mysqli_query($conexion,"SELECT SUM(cantidad) AS total_productos
                                            FROM carrito_compra
                                                INNER JOIN inventario ON (carrito_compra.id_inventario = inventario.id_inventario)
                                                INNER JOIN producto ON (inventario.id_producto = producto.id_producto);")
                                            or
                                            die("Error al obtener la consulta: ".mysqli_error($conexion));


$sumar_precio_total = mysqli_query($conexion,"  SELECT SUM((carrito_compra.cantidad * carrito_compra.subtotal)) / 1.21 AS suma_total
                                                FROM venta
                                                    INNER JOIN carrito_compra ON (venta.folio_venta = carrito_compra.folio_venta)
                                                    INNER JOIN inventario ON (carrito_compra.id_inventario = inventario.id_inventario)
                                                    INNER JOIN producto ON (inventario.id_producto = producto.id_producto);")
                                                or
                                                die("Error al obtener la consulta: ".mysqli_error($conexion));


$pdf->SetX(27);
while ($result_prod_vendidos = mysqli_fetch_array($consultar_productos)) {
    /* TABLA DE REGISTROS DINÁMICA */
    $pdf->Cell(60, 10,($result_prod_vendidos['nombre']), 1, 0, 'C',1);
    $pdf->Cell(30, 10,('$'.$result_prod_vendidos['precio']),1,0, 'C',1);
    $pdf->Cell(21, 10,($result_prod_vendidos['cantidad_prod']), 1, 0, 'C', 1);
    $pdf->Cell(45, 10,($result_prod_vendidos['fecha_venta']), 1, 1, 'C',1);
    $pdf->SetX(27);
    //$nuevo->Cell(35, 10,utf8_decode($result_prod_vendidos['hora_venta']), 1, 1, 'C',1);
    }

$pdf->Ln(20);

$pdf->SetFillColor(252,152,0);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('arial','b', 11);
$pdf->SetX(30);
$pdf->Cell(73, 10,('Total de productos'), 1, 0, 'C',1);
$pdf->Cell(73, 10,('Suma total'), 1, 1, 'C',1);

$pdf->SetFont('Arial','',10);
$pdf->SetFillColor(192,192,194);
$pdf->SetTextColor(0,0,0);

$pdf->SetX(30);
while ($result_total_prod = mysqli_fetch_array($contar_productos)) {
    $pdf->Cell(73, 10,($result_total_prod['total_productos']), 1, 0, 'C',1);
}

while ($result_suma_precio = mysqli_fetch_array($sumar_precio_total)) {
    $pdf->Cell(73, 10,("$". round($result_suma_precio['suma_total'], 2)), 1, 1, 'C',1);
}

$pdf->Output('integradora_reporte_ventas.pdf', 'i');
?>