<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sucursales</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #c0c0c2;">

<div class="container">
    <div class="row">
        <div class="col-6">
            <br>
            <h1 class="mt-5 mb-4">Sucursales ElectronicsForAll</h1>
        </div>
        <div class="col-6 text-end">

            <?php 
            session_start();
            require_once "../helper.php";
            extract($_REQUEST);

            if (verificar_sesion($token, $usuario)) {
                echo '<a class="btn btn-primary m-2" href="home_admin.php?token=' . htmlspecialchars($_SESSION['token']) . '&usuario=' . htmlspecialchars($_SESSION['tipo_usu']) . '">Home</a>';
                echo '<a class="btn btn-success m-2" href="AgregarSucursal.php?token=' . htmlspecialchars($_SESSION['token']) . '&usuario=' . htmlspecialchars($_SESSION['tipo_usu']) . '">Agregar Sucursal</a>';
            } else {
                header("location: ../creacion-inicioCuenta/mensaje_error.html?token=" . $_SESSION['token'] . "&usuario=" . $_SESSION['tipo_usu']);
                exit();
            }
            ?>
        </div>
    </div>

    <?php 
    include("../conexion.php");

    // Mostrar las sucursales existentes
    $sql = "SELECT id_sucursal, nombre, estatus, descripcion_direccion FROM sucursal";
    $resultado = $conexion->query($sql);

    if ($resultado->num_rows > 0) {
        echo '<div class="row mt-5">';
        while ($row = $resultado->fetch_assoc()) {
            // Mostrar cada sucursal como una tarjeta
            echo '
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">' . $row['nombre'] . '</h5>
                        <p class="card-text"><strong>Estatus:</strong> ' . $row['estatus'] . '</p>
                        <a class="btn btn-primary" href="vizualizacion_sucursal.php?token=' . htmlspecialchars($_SESSION['token']) . '&usuario=' . htmlspecialchars($_SESSION['tipo_usu']) . '&id_sucursal=' . $row['id_sucursal'] . '">Ver más</a>
                    </div>
                </div>
            </div>
            ';
        }
        echo '</div>';
    } else {
        echo '<div class="mt-3"><p>No se encontraron sucursales.</p></div>';
    }
    ?>

</div>

<!-- Bootstrap JS y dependencias opcionales (jQuery y Popper.js) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

</body>
</html>
