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
    <!-- Incluye Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="../boostrap/bootstrap.css">
    <title>Inicio Admin</title>
    <style>
        /* Estilos adicionales para centrar el logo */
        .centered-content {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 80vh; /* Ajusta la altura según tu necesidad */
        }
    </style>
</head>
<body style="background-color: #0275ce;">

    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <span class="navbar-text">¡Bienvenido administrador!</span>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                            <a class="nav-link" href="../admin/gestionar_reportes.php?token=<?= htmlspecialchars($_SESSION['token'])?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu'])?>">Generar reporte de ventas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../admin/sucursal.php?token=<?= htmlspecialchars($_SESSION['token'])?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu'])?>">Gestión de sucursales</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../admin/gestionar_inventarios.php?token=<?= htmlspecialchars($_SESSION['token'])?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu'])?>">Gestión de inventarios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../admin/gestionar_productos.php?token=<?= htmlspecialchars($_SESSION['token'])?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu'])?>">Gestión de productos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../creacion-inicioCuenta/iniciarSesion.html">Cerrar Sesión</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="centered-content">
        <img src="../imagenes/barra-navegacion/electronics.png" alt="Imagen Difuminada" class="img-fluid" style="width: 50%;">
    </div>

    <footer class="footer mt-auto bg-dark text-white py-4" style="text-align: center;"
    <div class="container">
        <p>&copy; 2024 Electronics For All. Todos los derechos reservados.</p>
    </div>
</footer>
<style>
    footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            font-size: 14px;
            position:relative;
            bottom: 0;
            width: 100%;
        }
        body {
            background-color: #0275ce;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
</style>

    <!-- Incluye Bootstrap 5 JS al final del documento -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="../boostrap/bootstrap.js"></script>
</body>
</html>
<?php
    } else {
        header("location: ../creacion-inicioCuenta/mensaje_error.html?token=" . $_SESSION['token'] . "&usuario=" . $_SESSION['tipo_usu']);
    }
?>
