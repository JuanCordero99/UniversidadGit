<?php
    include ('../conexion.php');
    require_once "../helper.php";

    session_start();
    extract($_REQUEST);
    if(verificar_sesion($token, $usuario)){
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="estilo_factura.css">
    <title>Cargar datos de factura</title>
    <style>
    .titulo_facturacion {
        margin-bottom: 2rem;
    }
    .contenedor_factura {
        padding: 2rem;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #f9f9f9;
    }
    .contenedor_datos_empresa, .contenedor_datos_cliente {
        margin-bottom: 2rem;
    }
    .table-bordered th, .table-bordered td {
        text-align: center;
    }
    .logo {
        width: 200px;
        max-width: 100%;
    }
    .btn-primary {
        margin-top: 1rem;
    }
    .form-label {
        font-weight: bold;
    }
    .bg {
        background-color: #fff;
    }
    .table-responsive {
        overflow-x: auto;
    }

    footer {
        margin-top: 100px;
        background-color: #333;
        color: #fff;
        text-align: center;
        padding: 1rem;
        width: 100%;
        position: relative;
        bottom: 0;
        left: 0;
    }

    .table {
        width: 100%;
        margin-bottom: 1rem;
        border-collapse: collapse;
    }
    .table th, .table td {
        padding: 0.75rem;
        border: 1px solid #0275ce; 
    }
    .table th {
        background-color: #0275ce; 
        color: #fff;
        text-align: center; 
    }
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f8f9fa; 
    }
    .table-bordered {
        border: 1px solid #0275ce; 
    }
</style>


</head>
<body>

    <div class="container">
        <div class="titulo_facturacion text-center">
            <h1>Cargar datos de factura</h1>
        </div>

        <div class="contenedor_factura">
            <form class="row g-3" method="post" action="/integradora_diseno/user/factura_pdf.php?token=<?= htmlspecialchars($_SESSION['token'])?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu']);?>">
                <div class="text-center mb-3">
                    <img src="/integradora_diseno/imagenes/barra-navegacion/electronics.png" alt="Logo de Electronics For All" class="logo">
                </div>

                <div class="contenedor_datos_empresa">
                    <h2 class="titulo_datos_empresa mb-3">Datos de la empresa</h2>
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="nombre_empresa" class="form-label">Empresa</label>
                            <input type="text" class="form-control" id="nombre_empresa" placeholder="Electronics For All" disabled>
                        </div>
                        <div class="col-12">
                            <label for="nombre_sucursal" class="form-label">Sucursal Matriz</label>
                            <input type="text" class="form-control" id="nombre_sucursal" placeholder="Ciudad de México" disabled>
                        </div>
                        <div class="col-12">
                            <label for="direccion_sucursal" class="form-label">Dirección de la sucursal</label>
                            <input type="text" class="form-control" id="direccion_sucursal" placeholder="Col. San Andrés Tetepilco, 09440 Ciudad De México, CDMX" disabled>
                        </div>
                        <div class="col-12">
                            <label for="correo_sucursal" class="form-label">Correo electrónico</label>
                            <input type="text" class="form-control" id="correo_sucursal" placeholder="electronics4all@efa.com.mx" disabled>
                        </div>
                        <div class="col-12">
                            <label for="telefono_sucursal" class="form-label">Número telefónico</label>
                            <input type="text" class="form-control" id="telefono_sucursal" placeholder="4425972902" disabled>
                        </div>
                    </div>
                </div>

                <div class="contenedor_datos_cliente">
                    <h2 class="titulo_datos_cliente mb-3">Datos del cliente</h2>
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="nombre_cliente" class="form-label">Nombre o razón social</label>
                            <input type="text" class="form-control" id="nombre_cliente" placeholder="Coloca tu nombre completo aquí" name="nombre_cliente" required>
                        </div>
                        <div class="col-12">
                            <label for="direccion_cliente" class="form-label">Dirección de domicilio</label>
                            <input type="text" class="form-control" id="direccion_cliente" placeholder="Coloca tu dirección de domicilio aquí (Privada, Número exterior, Código postal, ciudad y estado.)" name="direccion_cliente" required>
                        </div>
                        <div class="col-12">
                            <label for="rfc_cliente" class="form-label">Registro Federal de Contribuyente (RFC)</label>
                            <input type="text" class="form-control" id="rfc_cliente" placeholder="Coloca tu RFC aquí (En caso de no tener RFC, coloca los primeros 10 digitos de tu CURP)" name="rfc_cliente" minlength="10" maxlength="13" required>
                        </div>
                        <div class="col-12">
                            <label for="cfdi" class="form-label">Comprobante Fiscal Digital por Internet (CFDI)</label>
                            <input type="text" class="form-control" id="cfdi" placeholder="Coloca aquí tu CFDI" name="cfdi" required>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <input class="btn btn-primary" type="submit" value="Generar factura">
                    </div>
                </div>
            </form>
        </div>

        <div class="productos_a_facturar mt-5">
            <h1>Productos a facturar</h1>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-bordered bg">
                <thead class="thead-dark">
                    <tr class="table-primary">
                        <th>Concepto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Importe</th>
                    </tr>
                </thead>
                <?php
                    $correo = $_SESSION['correo'];

                    $sql_venta = "SELECT venta.folio_venta FROM venta
                                    INNER JOIN usuario ON (venta.id_usuario = usuario.id_usuario) 
                                    WHERE usuario.correo LIKE '$correo'
                                    ORDER BY venta.folio_venta DESC
                                    LIMIT 1";

                    $id_venta = $conexion->query($sql_venta);

                    if ($id_venta->num_rows > 0) {
                        $row = $id_venta->fetch_assoc();
                        $ult_id_venta = $row['folio_venta'];

                        $productos_facturados = mysqli_query($conexion, "SELECT  
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
                                                                        ORDER BY venta.folio_venta DESC")
                                                                        or die("Problemas de conexión: ".mysqli_error($conexion));

                        while ($resultado_factura = mysqli_fetch_array($productos_facturados)) {
                ?>
                <tr class="table-secondary">
                    <td><?php echo htmlspecialchars($resultado_factura['concepto']) ?></td>
                    <td><?php echo htmlspecialchars($resultado_factura['cantidad']) ?></td>
                    <td>$<?php echo htmlspecialchars(round($resultado_factura['precio_original'], 2)) ?></td>
                    <td>$<?php echo htmlspecialchars(round($resultado_factura['importe'], 2)) ?></td>
                </tr>
                <?php
                        }
                    }
                ?>
            </table>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-bordered bg">
                <thead class="thead-dark">
                    <tr class="table-primary">
                        <th>Subtotal</th>
                        <th>IVA (16%)</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <?php
                    $subtotal_iva_total = mysqli_query($conexion, "SELECT  
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
                                                                    ORDER BY venta.folio_venta DESC")
                                                                    or die("Problemas de conexión: ".mysqli_error($conexion));

                    if ($subtotal_iva_total->num_rows > 0) {
                        $resultado_totales = mysqli_fetch_array($subtotal_iva_total);
                ?>
                <tr class="table-light">
                    <td>$<?php echo htmlspecialchars(round($resultado_totales['subtotal'], 2)) ?></td>
                    <td>$<?php echo htmlspecialchars(round($resultado_totales['iva'], 2)) ?></td>
                    <td>$<?php echo htmlspecialchars(round($resultado_totales['total'], 2)) ?></td>
                </tr>
                <?php
                    }
                ?>
            </table>
        <footer>
            <p style="color: #f9f9f9;">&copy; 2024 Electronics For All. Todos los derechos reservados. Empresa 100% sustentable.</p>
        </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"></script>
</body>
</html>

<?php
    } else {
        header("Location: /integradora_diseno/login.php");
    }
?>
