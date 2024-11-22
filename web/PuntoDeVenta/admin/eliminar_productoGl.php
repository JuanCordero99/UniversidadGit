<?php
require_once "../helper.php";
require_once "../admin/barra_nav_adminGI.php";
extract($_REQUEST);

if (verificar_sesion($token, $usuario)) {
    include "../conexion.php";

    // Variable para mensajes
    $mensaje = "";

    // Procesar formulario de búsqueda
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["buscar-producto"])) {
        // Obtener nombre del producto desde el formulario
        $nombre_producto = $_POST["nombre_producto"];

        // Validar y procesar búsqueda de producto
        $sql_producto = "SELECT id_producto FROM producto WHERE nombre = '$nombre_producto'";
        $result_producto = $conexion->query($sql_producto);

        if ($result_producto && $result_producto->num_rows > 0) {
            $row_producto = $result_producto->fetch_assoc();
            $id_producto = $row_producto["id_producto"];

            // Obtener sucursales disponibles para el producto
            $sql_sucursales = "SELECT s.id_sucursal, s.nombre
                               FROM sucursal s
                               INNER JOIN inventario i ON s.id_sucursal = i.id_sucursal
                               WHERE i.id_producto = $id_producto and stock > 0";
            $result_sucursales = $conexion->query($sql_sucursales);

            if ($result_sucursales && $result_sucursales->num_rows > 0) {
                $mensaje = "Sucursales disponibles para el producto '$nombre_producto':";
            } else {
                $mensaje = "No hay sucursales disponibles para el producto '$nombre_producto'.";
            }
        } else {
            $mensaje = "No se encontró el producto '$nombre_producto' en la base de datos.";
        }
    }

    // Procesar formulario de eliminación
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["eliminar-producto"])) {
        // Obtener id_producto y id_sucursal desde el formulario
        $id_producto = $_POST["id_producto"];
        $id_sucursal = $_POST["asignar_sucursal"];

        // Eliminar el producto de la sucursal en la base de datos y establecer stock a 0
        $sql_eliminar = "UPDATE inventario SET stock = 0 
                         WHERE id_producto = $id_producto 
                         AND id_sucursal = $id_sucursal";

        if ($conexion->query($sql_eliminar) === TRUE) {
            $mensaje = "Producto eliminado correctamente de la sucursal y stock actualizado a 0.";
            // Redirigir después de eliminar producto
            header("Location: eliminar_productoGl.php?token=" . $_SESSION['token'] . "&usuario=" . $_SESSION['tipo_usu']);
            exit();
        } else {
            $mensaje = "Error al eliminar el producto de la sucursal: " . $conexion->error;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Eliminar del inventario</title>
</head>
<body class="bg-primary text-light">
    <div class="container my-5">
        <div class="card p-4 bg-light text-dark">
            <h2 class="text-center">Eliminar del inventario</h2>
            <?php if (!empty($mensaje)): ?>
                <div class="alert alert-info" role="alert">
                    <?php echo $mensaje; ?>
                </div>
            <?php endif; ?>
            
            <?php if (empty($result_sucursales)): ?>
                <form action="../admin/eliminar_productoGl.php?token=<?= htmlspecialchars($_SESSION['token']);?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu']);?>" method="POST" class="product-form">
                    <div class="form-group">
                        <label for="nombre-producto">Nombre del Producto</label>
                        <input type="text" id="nombre_producto" name="nombre_producto" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block" name="buscar-producto">Buscar Producto</button>
                    </div>
                </form>
            <?php endif; ?>

            <?php if (isset($result_sucursales) && $result_sucursales && $result_sucursales->num_rows > 0): ?>
                <form action="../admin/eliminar_productoGl.php?token=<?= htmlspecialchars($_SESSION['token']);?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu']);?>" method="POST" class="product-form">
                    <input type="hidden" name="id_producto" value="<?php echo $id_producto; ?>">
                    <div class="form-group">
                        <label for="estatus-producto">Sucursal</label>
                        <select id="asignar_sucursal" name="asignar_sucursal" class="form-control" required>
                            <?php while ($row_sucursal = $result_sucursales->fetch_assoc()): ?>
                                <option value="<?php echo $row_sucursal['id_sucursal']; ?>">
                                    <?php echo $row_sucursal['nombre']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-danger btn-block" name="eliminar-producto">Eliminar Producto de Sucursal</button>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
</body>
</html>

<?php
} else {
    // Si la sesión no está verificada, redirige a una página de error o inicio de sesión
    header("location: ../creacion-inicioCuenta/mensaje_error.html?token=" . $_SESSION['token'] . "&usuario=" . $_SESSION['tipo_usu']);
    exit();
}
?>
