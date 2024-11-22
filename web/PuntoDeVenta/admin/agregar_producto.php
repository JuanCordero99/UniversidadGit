<?php
    require_once "../helper.php";
    require_once "../admin/barra_nav_admin.php";

    extract($_REQUEST);
    if (verificar_sesion($token, $usuario)) {
        // Incluir archivo de conexión
        include("../conexion.php");
        
        // Variable para el mensaje de error
        $error_message = "";

        // Verificar si se ha enviado el formulario
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id_producto = $_POST["id_producto"];
            $nombre_producto = $_POST["nombre_producto"];
            $precio_producto = $_POST["precio_producto"];
            $descripcion_producto = $_POST["descripcion_producto"];
            $estatus_producto = $_POST["estatus_producto"];
            $catalago_producto = $_POST["catalago_producto"];
        
            $foto_producto = $_FILES["foto_producto"]["name"];
            $target_dir = "../imagenes/";
            $target_file = $target_dir . basename($foto_producto);
        
            // Verificar si el ID del producto ya existe
            $sql_check = "SELECT id_producto FROM producto WHERE id_producto = '$id_producto'";
            $result = $conexion->query($sql_check);
            
            if ($result->num_rows > 0) {
                $error_message = "El ID del producto ya está en uso. Por favor, elige otro ID.";
            } else {
                // Cambiar permisos del directorio si no son escribibles
                if (!is_writable($target_dir)) {
                    if (chmod($target_dir, 0777)) {
                        echo "Permisos del directorio cambiados a 0777.";
                    } else {
                        $error_message = "No se pudieron cambiar los permisos del directorio.";
                    }
                }

                // Verificar si el directorio es writable
                if (is_writable($target_dir)) {
                    if (move_uploaded_file($_FILES["foto_producto"]["tmp_name"], $target_file)) {
                        $sql_insert = "INSERT INTO producto (id_producto, nombre, precio, descripcion, foto, estatus, catalogo) 
                                       VALUES ('$id_producto', '$nombre_producto', '$precio_producto', '$descripcion_producto', '$target_file', '$estatus_producto', '$catalago_producto')";
        
                        if ($conexion->query($sql_insert) === TRUE) {
                            echo "Los datos se han insertado correctamente";
                            header("Location: agregar_producto.php?token=".$_SESSION['token']."&usuario=".$_SESSION['tipo_usu']."");
                        } else {
                            echo "Ha ocurrido un error: " . $conexion->error;
                        }
                    } else {
                        echo "Error al subir el archivo. Aquí hay más detalles sobre el error:<br>";
                        print_r($_FILES["foto_producto"]["error"]);
                    }
                } else {
                    echo "El directorio no es escribible.<br>";
                    echo "Permisos del directorio: " . substr(sprintf('%o', fileperms($target_dir)), -4) . "<br>";
                }
            }
        }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <meta http-equiv="Content-Type" content="image/png">
    <title>Agregar productos</title>
</head>
<body class="bg-primary text-light">
    <div class="container my-5">
        <div class="card p-4 bg-light text-dark">
            <h2 class="text-center">Formulario de Producto</h2>
            <form action="../admin/agregar_producto.php?token=<?= htmlspecialchars($_SESSION['token']);?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu']);?>" method="POST" enctype="multipart/form-data" class="product-form">
                <?php if ($error_message): ?>
                <div class="alert alert-danger" role="alert">
                    <?= htmlspecialchars($error_message); ?>
                </div>
                <?php endif; ?>
                <div class="form-group">
                    <label for="id-producto">ID Producto *</label>
                    <input type="text" id="id_producto" name="id_producto" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="nombre-producto">Nombre *</label>
                    <input type="text" id="nombre_producto" name="nombre_producto" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="precio-producto">Precio</label>
                    <input type="number" id="precio_producto" name="precio_producto" class="form-control" required step="0.01">
                </div>
                <div class="form-group">
                    <label for="descripcion-producto">Descripción</label>
                    <textarea id="descripcion_producto" name="descripcion_producto" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label for="foto-producto">Foto (Opcional)</label>
                    <input type="file" id="foto_producto" name="foto_producto" class="form-control">
                </div>
                <div class="form-group">
                    <label for="estatus-producto">Estatus</label>
                    <select id="estatus_producto" name="estatus_producto" class="form-control" required>
                        <option value="activo">Activo</option>
                        <option value="inactivo">Inactivo</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="catalago-producto">Categoría</label>
                    <select id="catalago_producto" name="catalago_producto" class="form-control" required>
                        <option value="telefonos">Telefonos</option>
                        <option value="Laptops">Laptops</option>
                        <option value="Bocinas">Bocinas</option>
                        <option value="Audifonos">Audifonos</option>
                        <option value="Smartwatch">Smartwatch</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-warning btn-block" name="agregar-producto">Agregar Producto</button>
                </div>
            </form>
        </div>
    </div>
    <footer class="bg-secondary text-center py-3">
        <p>&copy; 2024 Electronics For All. Todos los derechos reservados.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php
    } else {
        header("location: ../creacion-inicioCuenta/mensaje_error.html?token=".$_SESSION['token']."&usuario=".$_SESSION['tipo_usu']."");
    }   
?>
