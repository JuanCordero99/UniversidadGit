<?php
require_once "../helper.php";
require_once "../admin/barra_nav_admin.php";

extract($_REQUEST);
if (verificar_sesion($token, $usuario)) {
    // Incluir archivo de conexión
    include("../conexion.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre_producto = isset($_POST["nombre_producto"]) ? $_POST["nombre_producto"] : "";
        $precio_producto = isset($_POST["precio_producto"]) ? $_POST["precio_producto"] : "";
        $descripcion_producto = isset($_POST["descripcion_producto"]) ? $_POST["descripcion_producto"] : "";

        // Verifica si se ha cargado una nueva imagen
        $foto_producto = null;
        if (isset($_FILES["foto_producto"]) && $_FILES["foto_producto"]["size"] > 0) {
            $foto_producto = $_FILES["foto_producto"]["name"];
            $target_dir = "../imagenes/";
            $target_file = $target_dir . basename($foto_producto);
            
            // Cambiar permisos del directorio si no son escribibles
            if (!is_writable($target_dir)) {
                chmod($target_dir, 0777);
            }

            // Mueve el archivo cargado a la carpeta destino
            if (move_uploaded_file($_FILES["foto_producto"]["tmp_name"], $target_file)) {
                $foto_producto = $target_file; // Actualiza la ruta completa si el archivo se movió correctamente
            } else {
                echo "Error al subir el archivo. Aquí hay más detalles sobre el error:<br>";
                print_r($_FILES["foto_producto"]["error"]);
                $foto_producto = null;
            }
        }
    
        // Prepara la consulta SQL para actualizar datos
        $sql_update = "UPDATE producto SET ";

        // Verifica y agrega el precio solo si se proporciona
        if (!empty($precio_producto)) {
            $sql_update .= "precio='$precio_producto', ";
        }
    
        // Verifica y agrega la descripción solo si se proporciona
        if (!empty($descripcion_producto)) {
            $sql_update .= "descripcion='$descripcion_producto', ";
        }

        // Incluye la foto solo si se ha cargado una nueva
        if ($foto_producto !== null) {
            $sql_update .= "foto='$foto_producto', ";
        }

        // Elimina la última coma y espacio en blanco del SQL generado
        $sql_update = rtrim($sql_update, ", ");
    
        // Agrega la condición WHERE
        $sql_update .= " WHERE nombre='$nombre_producto'";

        // Ejecuta la consulta SQL
        if ($conexion->query($sql_update) === TRUE) {
            echo "Los datos se han actualizado correctamente.";
            header("Location: actualizar_producto.php?token=".$_SESSION['token']."&usuario=".$_SESSION['tipo_usu']);
            exit();
        } else {
            echo "Ha ocurrido un error al actualizar los datos: " . $conexion->error;
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <title>Actualizar Producto</title>
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
            <h2 class="text-center">Formulario de Actualización de Producto</h2>
            <form action="../admin/actualizar_producto.php?token=<?= htmlspecialchars($_SESSION['token']);?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu']);?>" method="POST" enctype="multipart/form-data" class="product-form">
                <div class="form-group">
                    <label for="nombre_producto">Nombre Producto *</label>
                    <input type="text" id="nombre_producto" name="nombre_producto" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="precio_producto">Precio</label>
                    <input type="number" id="precio_producto" name="precio_producto" class="form-control">
                </div>
                <div class="form-group">
                    <label for="descripcion_producto">Descripción</label>
                    <input type="text" id="descripcion_producto" name="descripcion_producto" class="form-control">
                </div>
                <div class="form-group">
                    <label for="foto_producto">Foto (Opcional)</label>
                    <input type="file" id="foto_producto" name="foto_producto" class="form-control">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-warning btn-block" name="actualizar-producto">Actualizar Producto</button>
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
