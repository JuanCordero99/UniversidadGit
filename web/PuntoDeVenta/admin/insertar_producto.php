<?php
include "../conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $id_producto = isset($_POST["id_producto"]) ? $_POST["id_producto"] : '';
    $nombre_producto = isset($_POST["nombre_producto"]) ? $_POST["nombre_producto"] : '';
    $precio_producto = isset($_POST["precio_producto"]) ? $_POST["precio_producto"] : '';
    $descripcion_producto = isset($_POST["descripcion_producto"]) ? $_POST["descripcion_producto"] : '';
    $estatus_producto = isset($_POST["estatus_producto"]) ? $_POST["estatus_producto"] : '';
    $catalogo_producto = isset($_POST["catalogo_producto"]) ? $_POST["catalogo_producto"] : '';

    // Obtener el nombre del archivo y configuraciones para subirlo
    $foto_producto = isset($_FILES["foto_producto"]["name"]) ? $_FILES["foto_producto"]["name"] : '';
    $target_dir = "imagenes/";
    $target_file = $target_dir . basename($foto_producto);

    // Debugging information
    echo "Temporary file: " . $_FILES["foto_producto"]["tmp_name"] . "<br>";
    echo "Target file: " . $target_file . "<br>";

    // Verificar si se seleccionó un archivo
    if (!empty($foto_producto)) {
        // Intentar mover el archivo al directorio de destino
        if (move_uploaded_file($_FILES["foto_producto"]["tmp_name"], $target_file)) {
            echo "El archivo " . basename($foto_producto) . " ha sido subido correctamente.<br>";
        } else {
            echo "Error al subir el archivo. Aquí hay más detalles sobre el error:<br>";
            echo "Error code: " . $_FILES["foto_producto"]["error"] . "<br>";
        }
    } else {
        echo "No se ha seleccionado ningún archivo para subir.<br>";
    }

    // Insertar datos en la base de datos (ejemplo básico)
    $sql_insert = "INSERT INTO producto (id_producto, nombre, precio, descripcion, foto, estatus, catalogo) 
                VALUES ('$id_producto', '$nombre_producto', '$precio_producto', '$descripcion_producto', '$target_file', '$estatus_producto', '$catalogo_producto')";

    if ($conexion->query($sql_insert) === TRUE) {
        echo "Los datos se han insertado correctamente.";
        header("Location: agregar_producto.php");
        exit();
    } else {
        echo "Ha ocurrido un error al insertar los datos: " . $conexion->error;
    }
}

$conexion->close();
?>
