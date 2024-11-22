<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Agregar productos</title>
</head>
<body class="bg-primary text-light">
    <nav class="navbar navbar-expand-lg navbar-light bg-secondary">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="/integradora_ve1/imagenes/electronics.png" alt="ElectronicsForAll Logo" class="img-fluid" style="width: 40%;">
            </a>
            <div class="ml-auto">
                <a href="agregar_producto.php" class="btn btn-primary">Volver a inicio</a>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <div class="card p-4 bg-light text-dark">
            <h2 class="text-center">Formulario de Asignacion de Inventario</h2>
            <form action="asignar_inventario.php" method="POST" class="product-form"> <!-- COLOCAR ARCHIVO PHP en action-->
                <div class="form-group">
                    <label for="estatus-producto"></label>
                    <select id="estatus-producto" name="sucursal" class="form-control" required>
                        <option value="1">1,Sucursal Bajio, Guanajuato</option>
                        <option value="2">2,Sucursal Bajio 2, Queretaro</option>
                        <option value="3">3,Sucursal Centro, CDMX</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="nombre-producto">N.Piezas</label>
                    <input type="number" id="nombre_producto" name="cantidad_producto" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="nombre-producto">id_producto</label>
                    <input type="number" id="nombre_producto" name="producto_asignado" class="form-control" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-warning btn-block" name="agregar-producto">Agregar producto</button>
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
    include "../conexion.php";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $stock=$_POST["cantidad_producto"];
        $id_sucursal=$_POST["sucursal"];
        $id_producto=$_POST["producto_asignado"];

        $sql="INSERT INTO inventario (stock,id_sucursal,id_producto) VALUES('$stock','$id_sucursal','$id_producto')";
        if ($conexion->query($sql) === TRUE) {
            echo "Los datos se han insertado correctamente";
            header("Location: asignar_inventario.php");
        } else {
            echo "Ha ocurrido un error: " . $conexion->error;
        }

    }

    $conexion->close();
?>
