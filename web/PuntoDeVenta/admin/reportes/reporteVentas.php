<?php 
    include "../../conexion.php";
    require_once "../../helper.php";
     session_start();
     extract($_REQUEST);
     if(verificar_sesion($token,$usuario)){
        ?>
        <?php 
    $productos_vendidos = mysqli_query($conexion,"  SELECT *
                                                    FROM reporte_ventas
                                                    ORDER BY fecha_venta DESC")
                                                    or 
                                                    die("Error al obtener la consulta: ".mysqli_error($conexion));


    $contar_productos = mysqli_query($conexion,"SELECT SUM(cantidad) AS total_productos
                                                FROM carrito_compra
                                                    INNER JOIN inventario ON (carrito_compra.id_inventario = inventario.id_inventario)
                                                    INNER JOIN producto ON (inventario.id_producto = producto.id_producto);")
                                                or
                                                die("Error al obtener la consulta: ".mysqli_error($conexion));


    $sumar_precio_total = mysqli_query($conexion,"  SELECT 
                                                    SUM((carrito_compra.cantidad * carrito_compra.subtotal)) / 1.21 AS suma_total
                                                    FROM venta
                                                        INNER JOIN carrito_compra ON (venta.folio_venta = carrito_compra.folio_venta)
                                                        INNER JOIN inventario ON (carrito_compra.id_inventario = inventario.id_inventario)
                                                        INNER JOIN producto ON (inventario.id_producto = producto.id_producto);")
                                                    or
                                                    die("Error al obtener la consulta: ".mysqli_error($conexion));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Reporte de ventas</title>
</head>
<body>
    <section>
        <!-- Sección de barra de nvegación-->
        <header class="sesion" style="background-color: #002244;">
        <a href="../gestionar_reportes.php?token=<?= htmlspecialchars($_SESSION['token']) ?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu']) ?>" class="btn btn-primary btn-back">Volver a inicio</a>
        <style>
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
</style>
<br>
<br>
            <img src="/integradora_diseno/imagenes/barra-navegacion/electronics.png" alt="Logo de Electronics For All" class="logo" style="width: 300px;">
        </header>
    </section>
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

.navbar-brand {
    color: #FF9800;
    font-weight: bold;
}

.titulo_reporte_ventas {
    text-align: center;
    margin: 40px 30px;
}

.table-container {
    margin: 20px auto;
    padding: 0 15px;
    max-width: 1200px; /* Define a maximum width for better control */
}

.table-responsive {
    overflow-x: auto;
}

.table {
    width: 100%; /* Ensures the table takes up the full width of its container */
}

.table thead {
    background-color: #FF9800;
    color: #ffffff;
}

.table th {
    text-align: center;
    vertical-align: middle;
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

@media (max-width: 576px) {
    .navbar-brand {
        font-size: 1rem;
    }

    .logo {
        width: 120px;
    }

    .table-container {
        padding: 0 5px;
    }
}

@media (min-width: 577px) and (max-width: 768px) {
    .logo {
        width: 130px;
    }

    .navbar-brand {
        font-size: 1.1rem;
    }
}

@media (min-width: 769px) {
    .logo {
        width: 150px;
    }

    .navbar-brand {
        font-size: 1.2rem;
    }
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
    border-collapse: separate;
    border-spacing: 0;
    width: 100%;
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

.table tbody tr {
    border-bottom: 1px solid #dddddd;
}

.table tbody tr:nth-child(even) {
    background-color: #f2f2f2;
}

.table tbody tr:hover {
    background-color: #e0e0e0;
}
.custom-btn-width {
    width: 300px; /* Ajusta el valor según tus necesidades */
    text-align: center;
}


    </style>
    <section >
        <div class="titulo_reporte_ventas"><h1>Reporte de ventas</h1></div>
        <!-- Sección de tabla de reporte de ventas -->
        <div style="margin-left: 15%; margin-right: 15%;">
        <div class="table-container">
                <div class="table-responsive">
                    <table class="table" >
                        <thead>
                            <tr>
                                <th scope="col">Nombre del producto</th>
                                <th scope="col">Precio unitario</th>
                                <th scope="col">Cantidad</th>
                                <th scope="col">Fecha y hora de venta</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($result_prod_vendidos = mysqli_fetch_array($productos_vendidos)) { ?>
                                <tr style="text-align: center;">
                                    <td><?php echo htmlspecialchars($result_prod_vendidos['nombre']); ?></td>
                                    <td>$<?php echo htmlspecialchars($result_prod_vendidos['precio']); ?></td>
                                    <td><?php echo htmlspecialchars($result_prod_vendidos['cantidad_prod']); ?></td>
                                    <td><?php echo htmlspecialchars($result_prod_vendidos['fecha_venta']); ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <section>
            <div class="titulo_reporte_ventas">
                <h2>Información de totales</h2>
            </div>
            <div class="table-container">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Total de productos</th>
                                <th scope="col">Suma total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr style="text-align: center;">
                                <?php while ($result_contar_produc = mysqli_fetch_array($contar_productos)) { ?>
                                    <td><?php echo htmlspecialchars($result_contar_produc['total_productos']); ?></td>
                                <?php } ?>
                                <?php while ($result_sumar_total = mysqli_fetch_array($sumar_precio_total)) { ?>
                                    <td>$<?php echo round(htmlspecialchars($result_sumar_total['suma_total']), 2); ?></td>
                                <?php } ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        <div class="text-center" style="margin-bottom: 5%; margin-top: 5%">
        <a href="reporte_pdf.php" class="btn btn-success custom-btn-width">
    <i class="fa-solid fa-file-pdf"></i> Generar reporte
        </a>

        </div>
    </section>
</body>
</html>
<?php
}else{
    header("location: ../../creacion-inicioCuenta/mensaje_error.html?token=".$_SESSION['token']."&usuario=".$_SESSION['tipo_usu']."" );
}

?>