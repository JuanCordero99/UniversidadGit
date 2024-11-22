<?php
    require_once "../helper.php";
    require_once "../admin/barra_nav_adminGI.php";
    extract($_REQUEST);
    if(verificar_sesion($token,$usuario)){
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <meta http-equiv="Content-Type" content="image/png">
    <title>Añadir productos a sucursal</title>
</head>
<body class="bg-primary text-light">
    <div class="container my-5">
        <div class="card p-4 bg-light text-dark">
            <h2 class="text-center">Añadir productos a otra sucursal</h2>
            <form action="../admin/anadirProductosGI.php?token=<?= htmlspecialchars($_SESSION['token']);?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu']);?>" method="POST" class="product-form"> <!-- PON AQUI TU RUTA DE ESTE MISMO ARCHIVO -->
                <div class="form-group">
                    <label for="nombre-producto">Nombre del Producto</label>
                    <input type="text" id="nombre_producto" name="nombre_producto" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="stock-anadir">Cantidad de Stock a Añadir</label>
                    <input type="number" id="stock_anadir" name="stock_anadir" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="estatus-producto">Sucursal</label>
                    <select id="asignar_sucursal" name="asignar_sucursal" class="form-control" required>
                        <option value="1">Sucursal Queretaro</option>
                        <option value="2">Sucursal Guanajuato</option>
                        <option value="3">Sucursal Ciudad de México</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block" name="actualizar-stock">Añadir</button>
                </div>
            </form>
        </div>
    </div>


        <style>
        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: #343a40; /* Color de fondo oscuro */
            color: white; /* Texto blanco */
            text-align: center;
            padding: 20px 0; /* Espaciado interior arriba y abajo aumentado */
       
        }
    </style>
    <br>
    <br>
    <br>
    <footer class="footer">
        <div class="container text-white">
        <p>&copy; 2024 Electronics For All. Todos los derechos reservados. Empresa 100% sustentable.</p>
        </div>
    </footer>
    <style>
        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: #343a40; /* Color de fondo oscuro */
            color: white; /* Texto blanco */
            text-align: center;
            padding: 20px 0; /* Espaciado interior arriba y abajo aumentado */
       
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php
    include "../conexion.php"; // Incluir archivo de conexión a la base de datos

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre_producto = $_POST["nombre_producto"];
        $stock = $_POST["stock_anadir"];
        $sucursal = $_POST["asignar_sucursal"];

        // Obtener id_producto
        $sql_producto = "SELECT id_producto FROM producto WHERE nombre = '$nombre_producto'";
        $result_producto = $conexion->query($sql_producto);

        if ($result_producto ->num_rows > 0) {
            $row_producto = $result_producto->fetch_assoc();
            $id_producto = $row_producto["id_producto"];

            // Obtener id_sucursal
            $sql_sucursal = "SELECT id_sucursal FROM sucursal WHERE id_sucursal = '$sucursal'";
            $result_sucursal = $conexion->query($sql_sucursal);

            if ($result_sucursal->num_rows > 0) {
                $row_sucursal = $result_sucursal->fetch_assoc();
                $id_sucursal = $row_sucursal["id_sucursal"];

                // Verificar existencia en inventario
                $sql_existencia = "SELECT id_inventario FROM inventario WHERE id_producto = $id_producto AND id_sucursal = $id_sucursal";
                $result_existencia = $conexion->query($sql_existencia);

                if ($result_existencia->num_rows > 0) {
                    // Actualizar stock
                    $sql_update = "UPDATE inventario SET stock = stock + $stock WHERE id_producto = $id_producto AND id_sucursal = $id_sucursal";
                    if ($conexion->query($sql_update)===TRUE) {
                        $mensaje = "Se actualizó el stock del producto '$nombre_producto' en la sucursal '$sucursal'."; // Confirmar cambios
                    }
                } else {
                    // Insertar nuevo registro
                    $sql_insert = "INSERT INTO inventario (id_producto, id_sucursal, stock) VALUES ('$id_producto','$id_sucursal','$stock')";
                    if ($conexion->query($sql_insert)===TRUE) {
                        $mensaje = "Se añadió el producto '$nombre_producto' al inventario de la sucursal '$sucursal'.";//Confirmar cambios
                    }
                }
            }
        }
    }
}else{
    header("location: ../creacion-inicioCuenta/mensaje_error.html?token=".$_SESSION['token']."&usuario=".$_SESSION['tipo_usu']."" );
}

?>
