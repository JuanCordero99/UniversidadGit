<?php
include "../conexion.php";
require_once "../user/barra_nav.php";
require_once "../helper.php";

$correo = $_SESSION['correo'];
if (verificar_sesion($token, $usuario)) {
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda de Equipos Electrónicos - Gracias por su compra</title>
    <link rel="stylesheet" href="../home1.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #0275ce;
            font-family: Arial, sans-serif;
        }

        .thank-you-section {
            margin: 100px 0;
        }

        .thank-you-section h1 {
            color: #333;
            font-size: 2.5rem;
            margin-bottom: 20px;
        }

        .button-group {
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }

        .btn {
            font-size: 1.2rem;
            padding: 10px 30px;
            margin: 0 10px;
            border-radius: 5px;
        }

        .btn-primary {
            background-color: #f0ad4e; /* Naranja */
            border-color: #f0ad4e; /* Borde Naranja */
            color: #343a40;
        }

        .btn-primary:hover {
            background-color: #cc7a00;
            border-color: #eea236;
            color: #343a40;
        }

        .btn-success {
            background-color: #f0ad4e; /* Naranja */
            border-color: #f0ad4e; /* Borde Naranja */
            color: #343a40;
        }

        .btn-success:hover {
            background-color: #cc7a00;
            border-color: #eea236;
            color: #343a40;
        }

        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #343a40;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <main class="text-center">
        <section class="thank-you-section">
            <h1>¡Gracias por su compra, <?= htmlspecialchars($correo); ?>!</h1>
        </section>
        <div class="button-group">
            <a href="../user/index.php?token=<?= htmlspecialchars($_SESSION['token']) ?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu']); ?>" class="btn btn-primary btn-home">Volver al Home</a>
            <a href="../user/datos_factura.php?token=<?= htmlspecialchars($_SESSION['token']) ?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu']); ?>" class="btn btn-success btn-invoice">Generar Factura</a>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 ElectronicsForAll. Todos los derechos reservados. Empresa 100% sustentable.</p>
    </footer>
</body>

</html>
<?php
} else {
    header("location: ../creacion-inicioCuenta/mensaje_error.html?token=" . $_SESSION['token'] . "&usuario=" . $_SESSION['tipo_usu']);
}
?>
