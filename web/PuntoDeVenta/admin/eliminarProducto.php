<?php
require_once "../helper.php";
require_once "../admin/barra_nav_admin.php"; 

extract($_REQUEST);
if (verificar_sesion($token, $usuario)) {
    include "../conexion.php";
    $mensaje_alerta = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre_producto = $_POST["nombre_producto"];
        $estatus = $_POST["estatus_producto"];

        $sql_verificar = "SELECT estatus FROM producto WHERE nombre = '$nombre_producto'";
        $resultado = $conexion->query($sql_verificar);

        if ($resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();
            if ($fila["estatus"] == 'inactivo') {
                $mensaje_alerta = "El producto '$nombre_producto' no está activo.";
            } else {
                $sql_actualizar = "UPDATE producto SET estatus = '$estatus' WHERE nombre = '$nombre_producto'";

                if ($conexion->query($sql_actualizar) === TRUE) {
                    echo "El producto '$nombre_producto' ha sido marcado como inactivo correctamente.";
                    header("Location: eliminarProducto.php?token=".$_SESSION['token']."&usuario=".$_SESSION['tipo_usu']);
                    exit();
                } else {
                    echo "Error al intentar marcar el producto como inactivo: " . $conexion->error;
                }
            }
        } else {
            $mensaje_alerta = "No se encontró ningún producto con el nombre '$nombre_producto'.";
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <title>Eliminar Producto</title>
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }
        body {
            display: flex;
            flex-direction: column;
        }
        .content {
            flex: 1;
        }
        .footer {
            background-color: #343a40; /* Color de fondo oscuro */
            color: white; /* Texto blanco */
            text-align: center;
            padding: 20px 0; /* Espaciado interior arriba y abajo aumentado */
        }
    </style>
</head>
<body class="bg-primary text-light">
    <?php require_once "../admin/barra_nav_admin.php"; ?>

    <div class="container my-5 content">
        <div class="card p-4 bg-light text-dark">
            <h2 class="text-center">Formulario de Eliminación de Producto</h2>
            
            <?php if (!empty($mensaje_alerta)): ?>
            <div class="alert alert-danger"><?php echo $mensaje_alerta; ?></div>
            <?php endif; ?>

            <form action="../admin/eliminarProducto.php?token=<?= htmlspecialchars($_SESSION['token']);?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu']);?>" method="POST" class="product-form">
                <div class="form-group">
                    <label for="nombre-producto">Nombre del Producto</label>
                    <input type="text" id="nombre_producto" name="nombre_producto" class="form-control" required>
                </div>
                <div class="form-group">
                    <input type="hidden" name="estatus_producto" value="inactivo">
                    <button type="submit" class="btn btn-danger btn-block" name="eliminar-producto">Eliminar Producto</button>
                </div>
            </form>
        </div>
    </div>

    <footer class="footer">
        <div class="container text-white">
            <p>&copy; 2024 Electronics For All. Todos los derechos reservados. Empresa 100% sustentable.</p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>
</body>
</html>

<?php
} else {
    // Si la sesión no está verificada, redirige a una página de error o inicio de sesión
    header("Location: ../creacion-inicioCuenta/mensaje_error.html?token=".$_SESSION['token']."&usuario=".$_SESSION['tipo_usu']);
    exit();
}
?>
