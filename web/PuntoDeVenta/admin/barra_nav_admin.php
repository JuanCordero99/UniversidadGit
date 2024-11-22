<?php
require_once "../helper.php";
session_start();
extract($_REQUEST);
if (verificar_sesion($token, $usuario)) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Actualizar Producto</title>
    <style>
        .navbar-custom {
            background-color: #002244; /* Color de fondo de la barra de navegación */
        }
        .navbar-custom .navbar-brand,
        .navbar-custom .navbar-nav .nav-link,
        .navbar-custom .btn-custom {
            color: #ffffff; /* Color de texto en la barra de navegación */
        }
        .btn-custom {
            background-color: #ffa500; /* Color de fondo naranja para el botón */
            border-color: #ffa500; /* Color del borde del botón */
        }
        .btn-custom:hover {
            background-color: #ff8c00; /* Color de fondo naranja oscuro al pasar el mouse sobre el botón */
            border-color: #ff8c00; /* Color del borde del botón al pasar el mouse */
        }
    </style>
</head>
<body class="bg-primary text-light">
<nav class="navbar navbar-expand-lg navbar-light navbar-custom">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="../imagenes/barra-navegacion/electronics.png" alt="ElectronicsForAll Logo" class="img-fluid" style="width: 40%;">
        </a>
        <div class="ml-auto">
            <a href="../admin/gestionar_productos.php?token=<?= htmlspecialchars($_SESSION['token'])?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu'])?>" class="btn btn-warning">Volver a inicio</a>
        </div>
    </div>
</nav>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php
} else {
    header("location: ../creacion-inicioCuenta/mensaje_error.html?token=".$_SESSION['token']."&usuario=".$_SESSION['tipo_usu']);
    exit();
}
?>
