<?php 
    include "../../conexion.php";
    require_once "../../helper.php";
     session_start();
     extract($_REQUEST);
     if(verificar_sesion($token,$usuario)){
        ?>
                <?php 
// Consulta para obtener el folio de la venta, subtotal, IVA y total
$ventas_sql = "
    SELECT  
        venta.folio_venta,
        ROUND(SUM((producto.precio * carrito_compra.cantidad) / 1.16), 2) AS subtotal,
        ROUND(SUM((producto.precio * carrito_compra.cantidad) / 1.16) * 0.16, 2) AS iva,
        ROUND(SUM((producto.precio * carrito_compra.cantidad) / 1.16) + SUM((producto.precio * carrito_compra.cantidad) / 1.16) * 0.16, 2) AS total
    FROM venta
        INNER JOIN carrito_compra ON (venta.folio_venta = carrito_compra.folio_venta)
        INNER JOIN inventario ON (carrito_compra.id_inventario = inventario.id_inventario)
        INNER JOIN producto ON (inventario.id_producto = producto.id_producto)
    WHERE venta.folio_fatura > 0
    GROUP BY venta.folio_venta
    ORDER BY venta.folio_venta DESC
";

$ventas_result = mysqli_query($conexion, $ventas_sql) or die("Error al obtener la consulta: " . mysqli_error($conexion));

// Consulta para contar el número total de ventas facturadas
$count_sql = "
    SELECT COUNT(DISTINCT venta.folio_venta) AS total_facturados
    FROM venta
    WHERE venta.folio_fatura > 0
";

$count_result = mysqli_query($conexion, $count_sql) or die("Error al obtener la consulta: " . mysqli_error($conexion));

// Nueva consulta para calcular el total de dinero ingresado
$total_dinero_sql = "
    SELECT 
        ROUND(SUM((producto.precio * carrito_compra.cantidad) / 1.16) + SUM((producto.precio * carrito_compra.cantidad) / 1.16) * 0.16, 2) AS total_ingresado
    FROM venta
        INNER JOIN carrito_compra ON (venta.folio_venta = carrito_compra.folio_venta)
        INNER JOIN inventario ON (carrito_compra.id_inventario = inventario.id_inventario)
        INNER JOIN producto ON (inventario.id_producto = producto.id_producto)
    WHERE venta.folio_fatura > 0
";

$total_dinero_result = mysqli_query($conexion, $total_dinero_sql) or die("Error al obtener la consulta: " . mysqli_error($conexion));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Reporte de Ventas Facturadas</title>
    <style>
        body {
            background-color: #0275ce;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #e9ecef;
            padding: 10px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .btn-back {
            position: absolute;
            top: 10px;
            left: 10px; 
            background-color: #FF9800;
            border-color: #FF9800;
            color: white;
        }

        .btn-back:hover {
            background-color: #e68900;
            border-color: #e68900;
        }

        .titulo_reporte_ventas {
            text-align: center;
            margin: 40px 30px;
        }

        .table-container {
            margin: 20px auto;
            padding: 0 15px;
            max-width: 1200px;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid #000000;
        }

        .table th, .table td {
            border: 1px solid #000000;
            padding: 8px;
            border-radius: 5px;
        }

        .table thead th {
            background-color: #FF9800;
            color: #ffffff;
            border-bottom: 2px solid #003366;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .table tbody tr:hover {
            background-color: #e0e0e0;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        .custom-btn-width {
            width: 300px; /* Ajusta el valor según tus necesidades */
            text-align: center;
        }
    </style>
</head>
<body>
    <section>
        <!-- Sección de barra de navegación -->
        <header class="sesion" style="background-color: #002244;">
            <a href="../gestionar_reportes.php?token=<?= htmlspecialchars($_SESSION['token']) ?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu']) ?>" class="btn btn-primary btn-back">Volver a inicio</a>
            <img src="/integradora_diseno/imagenes/barra-navegacion/electronics.png" alt="Logo de Electronics For All" class="logo" style="width: 300px;">
        </header>
    </section>

    <section>
        <div class="titulo_reporte_ventas">
            <h1>Reporte de Ventas Facturadas</h1>
        </div>
        <!-- Sección de tabla de ventas facturadas -->
        <div style="margin-left: 15%; margin-right: 15%;">
            <div class="table-container">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr style="text-align: center;">
                                <th scope="col">Folio Venta</th>
                                <th scope="col">Subtotal</th>
                                <th scope="col">IVA</th>
                                <th scope="col">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_array($ventas_result)) { ?>
                                <tr style="text-align: center;">
                                    <td><?php echo htmlspecialchars($row['folio_venta']); ?></td>
                                    <td>$<?php echo htmlspecialchars($row['subtotal']); ?></td>
                                    <td>$<?php echo htmlspecialchars($row['iva']); ?></td>
                                    <td>$<?php echo htmlspecialchars($row['total']); ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="titulo_reporte_ventas">
            <h2>Información de Totales</h2>
        </div>
        <div class="table-container">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Total de Ventas Facturadas</th>
                            <th scope="col">Total Dinero Ingresado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="text-align: center;">
                            <?php 
                            $count_row = mysqli_fetch_array($count_result);
                            $total_dinero_row = mysqli_fetch_array($total_dinero_result);
                            ?>
                            <td><?php echo htmlspecialchars($count_row['total_facturados']); ?></td>
                            <td>$<?php echo htmlspecialchars($total_dinero_row['total_ingresado']); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</body>
</html>
<?php
}else{
    header("location: ../../creacion-inicioCuenta/mensaje_error.html?token=".$_SESSION['token']."&usuario=".$_SESSION['tipo_usu']."" );
}

?>