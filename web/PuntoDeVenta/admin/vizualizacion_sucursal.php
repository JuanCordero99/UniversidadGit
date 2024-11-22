<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de Sucursal</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #c0c0c2;">

<div class="container">
    <h1 class="mt-5 mb-4 text-center">Detalles de Sucursal</h1>

    <?php 
    require_once "../helper.php";
    session_start();
    extract($_REQUEST);

    if (verificar_sesion($token, $usuario)) {
        include("../conexion.php");

        // Variable para almacenar el mensaje de alerta
        $alerta = '';

        // Verificar si se ha pasado un ID válido por GET

        // Verificar si se ha enviado el formulario para cambiar el estatus
        if (isset($_POST['cambiar_estatus'])) {
            // Obtener el estatus actual de la sucursal
            $sql_estatus = "SELECT estatus FROM sucursal WHERE id_sucursal = $id_sucursal";
            $resultado_estatus = $conexion->query($sql_estatus);

            if ($resultado_estatus->num_rows > 0) {
                $row = $resultado_estatus->fetch_assoc();
                $nuevo_estatus = ($row['estatus'] == 'activo') ? 'inactivo' : 'activo';

                // Actualizar el estatus de la sucursal
                $sql_update = "UPDATE sucursal SET estatus = '$nuevo_estatus' WHERE id_sucursal = $id_sucursal";

                if ($conexion->query($sql_update) === TRUE) {
                    $alerta = '<div class="alert alert-success" role="alert">
                                    El estatus de la sucursal ha sido cambiado a ' . $nuevo_estatus . '.
                               </div>';
                } else {
                    $alerta = '<div class="alert alert-danger" role="alert">
                                    Error al cambiar el estatus de la sucursal: ' . $conexion->error . '
                               </div>';
                }
            } else {
                $alerta = '<div class="alert alert-warning" role="alert">
                                No se encontró la sucursal.
                           </div>';
            }
        }

        // Obtener detalles de la sucursal después de cualquier cambio de estatus
        $sql = "SELECT id_sucursal, nombre, estatus, descripcion_direccion FROM sucursal WHERE id_sucursal = $id_sucursal";
        $resultado = $conexion->query($sql);

        if ($resultado->num_rows > 0) {
            $row = $resultado->fetch_assoc();
            echo '
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">' . $row['nombre'] . '</h5>
                    <p class="card-text"><strong>Estatus:</strong> ' . $row['estatus'] . '</p>
                    <p class="card-text"><strong>Dirección:</strong> ' . $row['descripcion_direccion'] . '</p>
                </div>
            </div>
            ';

            // Mostrar la alerta (si hay alguna)
            echo $alerta;

            // Formulario para cambiar el estatus de la sucursal
            echo '
            <form method="POST" action="../admin/vizualizacion_sucursal.php?token=' . htmlspecialchars($_SESSION['token']) . '&usuario=' . htmlspecialchars($_SESSION['tipo_usu']) . '">
                <input type="hidden" name="id_sucursal" value="' . $row['id_sucursal'] . '">
                <button type="submit" name="cambiar_estatus" class="btn btn-danger" onclick="return confirm(\'¿Estás seguro de cambiar el estatus de activo a inactivo en esta sucursal?\')">Modificar estatus</button>
                <a href="sucursal.php?token=' . htmlspecialchars($_SESSION['token']) . '&usuario=' . htmlspecialchars($_SESSION['tipo_usu']) . '" class="btn btn-secondary ms-2">Volver</a>
            </form>
            ';
        } else {
            echo '<div class="alert alert-danger" role="alert">
                        No se encontró la sucursal.
                  </div>';
        }

        // Cerrar la conexión (opcional en este punto, PHP lo maneja automáticamente al finalizar el script)
        // $conexion->close();
    } else {
        header("location: ../creacion-inicioCuenta/mensaje_error.html?token=" . $_SESSION['token'] . "&usuario=" . $_SESSION['tipo_usu']);
        exit();
    }
    ?>

</div>

<!-- Bootstrap JS y dependencias opcionales (jQuery y Popper.js) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

</body>
</html>
