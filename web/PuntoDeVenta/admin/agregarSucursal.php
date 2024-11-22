<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Sucursal</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #c0c0c2;">

<div class="container">
    <h1 class="mt-5 mb-4 text-center">Agregar Nueva Sucursal</h1>

    <div class="row">
        <div class="col-md-6 offset-md-3">
            <?php 
            require_once "../helper.php";
            session_start();
            extract($_REQUEST);
            if (verificar_sesion($token, $usuario)) {
                include("../conexion.php");

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    // Recuperar datos del formulario
                    $nombre = htmlspecialchars($_POST['nombre']);
                    $descripcion = htmlspecialchars($_POST['descripcion']);

                    // Preparar la consulta SQL para insertar la sucursal
                    $sql = "INSERT INTO sucursal (nombre, estatus, descripcion_direccion) VALUES ('$nombre', 'activo', '$descripcion')";

                    if ($conexion->query($sql) === TRUE) {
                        echo '<div class="alert alert-success" role="alert">
                                Sucursal agregada correctamente.
                              </div>';
                    } else {
                        echo '<div class="alert alert-danger" role="alert">
                                Error al agregar la sucursal: ' . $conexion->error . '
                              </div>';
                    }

                    // Cerrar la conexión a la base de datos
                    $conexion->close();
                }
            } else {
                header("location: ../creacion-inicioCuenta/mensaje_error.html?token=" . $_SESSION['token'] . "&usuario=" . $_SESSION['tipo_usu']);
                exit();
            }
            ?>

            <!-- Formulario para agregar sucursal -->
            <form action="../admin/agregarSucursal.php?token=<?= htmlspecialchars($_SESSION['token']); ?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu']); ?>" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Dirección</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Agregar Sucursal</button>
                <a href="sucursal.php?token=<?= htmlspecialchars($_SESSION['token']); ?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu']); ?>" class="btn btn-secondary">Volver</a>
            </form>
        </div>
    </div>

</div>

<!-- Bootstrap JS y dependencias opcionales (Popper.js) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

</body>
</html>
