<?php
include "../conexion.php";
require_once "../user/barra_nav.php";


$cliente = $_SESSION['correo'];

$sql = "SELECT usuario.nombre, usuario.apellido, usuario.telefono 
        FROM usuario WHERE usuario.correo LIKE '$cliente' ";
$result = $conexion->query($sql);

if ($result === false) {
    echo "Error en la consulta: " . $conexion->error;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../boostrap/bootstrap.min.css">
    <link rel="stylesheet" href="../user/perfil.css">
    <title>Perfil del Usuario</title>
    <style>
        body {
            background-color: #0275ce;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            font-family: 'Arial', sans-serif;
        }

        main {
            flex: 1;
            padding: 20px;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            margin-bottom: 20px;
            background-color: #ffffff;
        }

        .card-header {
            background-color: #333;
            color: white;
            font-size: 1.25rem;
            border-bottom: none;
            border-radius: 10px 10px 0 0;
            padding: 15px;
        }

        .card-body {
            padding: 20px;
        }

        .card-body h2 {
            color: #0275ce;
            margin-bottom: 10px;
        }

        .card-body p {
            font-size: 16px;
            margin: 0;
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }

        .card-body p:last-child {
            border-bottom: none;
        }

        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 20px 0;
            font-size: 14px;
            width: 100%;
        }

        footer p {
            margin: 0;
        }

        @media (max-width: 768px) {
            .card-header {
                font-size: 1.1rem;
            }

            .card-body h2 {
                font-size: 1.2rem;
            }
        }

    </style>
</head>
<body style="margin-top: 5%;">
    <br>
    <main class="container my-4">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card">
                    <div class="card-header text-center">
                        Perfil del Usuario
                    </div>
                    <div class="card-body">
                        <?php if ($result && $result->num_rows > 0): ?>
                            <?php while ($usuario = $result->fetch_assoc()): ?>
                                <div class="mb-3">
                                    <h2>Nombre</h2>
                                    <p><?= htmlspecialchars($usuario['nombre']) ?></p>
                                </div>

                                <div class="mb-3">
                                    <h2>Apellidos</h2>
                                    <p><?= htmlspecialchars($usuario['apellido']) ?></p>
                                </div>

                                <div class="mb-3">
                                    <h2>Correo Electrónico</h2>
                                    <p><?= htmlspecialchars($cliente) ?></p>
                                </div>

                                <div class="mb-3">
                                    <h2>Teléfono</h2>
                                    <p><?= htmlspecialchars($usuario['telefono']) ?></p>
                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <p>No se encontraron datos de usuario.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="../boostrap/bootstrap.bundle.min.js"></script>
    <footer>
        <p>&copy; 2024 Electronics For All. Todos los derechos reservados. Empresa 100% sustentable.</p>
    </footer>
</body>
</html>
