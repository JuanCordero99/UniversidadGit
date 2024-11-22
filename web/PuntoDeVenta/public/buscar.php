<?php
// Configuración de la base de datos
include "../conexion.php";
require_once "../public/barra_nav_public.php";

// Consulta a la base de datos para obtener los productos
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $palabra = $_POST['buscar'];

    $sql_palabra = "SELECT DISTINCT producto.id_producto, producto.nombre, producto.foto, producto.descripcion, producto.precio
                    FROM producto
                        INNER JOIN inventario ON(inventario.id_producto=producto.id_producto)
                    WHERE producto.nombre LIKE '%$palabra%' AND producto.estatus LIKE 'activo' AND inventario.stock>=1";
    $result = $conexion->query($sql_palabra);

    // Verificar si se encontraron resultados
    if ($result === false) {
        echo "Error en la consulta: " . $conexion->error;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link href="../home1.css">
    <style>
        /* Estilo para el contenedor del mensaje cuando no hay resultados */
        .no-results-container {
            position: fixed; 
            z-index: 9998; 
            top: 50%;
            left: 50%; 
            transform: translate(-50%, -50%); 
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: rgba(255, 152, 0, 0.9);
            font-size: 24px;
            text-align: center;
            padding: 20px;
            box-sizing: border-box; 
            max-width: 80%; 
        }
        .no-results-text {
            color: #333; /* Color del texto */
            border: 2px solid #ddd; /* Borde del contenedor */
            border-radius: 5px; /* Borde redondeado */
            background-color: #ccc; /* Fondo del contenedor de texto */
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); /* Sombra suave */
            width: 100%; /* Abarca todo el ancho del contenedor padre */
            max-width: 100%; /* Ancho máximo del contenedor */
        }

        .no-results-text p {
            margin-bottom: 0; /* Elimina el margen inferior del párrafo dentro del contenedor */
        }

        .custom-img-size {
            height: 300px;
            width: 300px;
            max-height: 100%; /* Ajusta la altura máxima si es necesario */
            width: 100%; /* Asegura que la imagen ocupe el 100% del contenedor */
            object-fit: contain; /* Ajusta la imagen para que quepa dentro del contenedor sin recortarla */
        }

        .pie {
            background-color: #c0c0c2;
            padding: 10px;
            text-align: center;
            width: 100%;
            box-sizing: border-box;
            position: fixed;
            bottom: 0;
            left: 0;
            z-index: 1000;
        }

        .pie p {
            margin: 0;
            font-size: 16px;
            color: #111;
        }

        @media (max-width: 600px) {
            .pie {
                padding: 8px;
                font-size: 0.7em;
            }
        }

        /* Añadir regla para el cuerpo de la página */
        body {
            margin: 0;  /* Asegura que no haya margen en el cuerpo */
            padding: 0; /* Asegura que no haya padding en el cuerpo */
        }
    </style>
</head>
<body style="background-color: #777; display: flex; flex-direction: column; min-height: 100vh;">
    <!-- Barra de navegación -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <div class="container mt-5">
        <div class="row row-cols-1 row-cols-md-3 g-3">
            <?php if (isset($result) && $result->num_rows > 0): ?>
                <?php while ($producto = $result->fetch_assoc()): ?>
                    <div class="col">
                        <div class="card h-100 shadow" style="background-color: #c0c0c2;">
                            <img src="<?php echo htmlspecialchars($producto['foto']); ?>" class="card-img-top custom-img-size" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($producto['nombre']); ?></h5>
                                <p class="card-text"><strong>Precio: <?php echo htmlspecialchars($producto['precio']); ?></strong></p>
                                <?php 
                                    $id_prod = $producto['id_producto'];

                                    $sql_stock = "SELECT inventario.stock, sucursal.nombre
                                        FROM inventario
                                            INNER JOIN producto ON(inventario.id_producto=producto.id_producto)
                                            INNER JOIN sucursal ON (sucursal.id_sucursal=inventario.id_sucursal)
                                        WHERE producto.nombre LIKE '%$palabra%' AND producto.estatus LIKE 'activo' AND producto.id_producto = '$id_prod' AND inventario.stock>=1";

                                    $result_stock = $conexion->query($sql_stock);

                                    while($stock = $result_stock->fetch_assoc()): 
                                ?>
                                <p class="card-text">
                                    <strong>
                                        Sucursal disponible: <?= htmlspecialchars($stock['nombre']); ?> 
                                        | Stock: <?= htmlspecialchars($stock['stock']); ?> 
                                    </strong>
                                </p>
                                <?php endwhile; ?>
                                
                                <a href="/integradora_diseno/public/visualizacion_completa.php?id_producto=<?php echo htmlspecialchars($producto['id_producto']);?>" class="btn btn-primary">Ver más detalles</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <!-- Cuando no hay resultados -->
                <div class="col-12">
                    <div class="no-results-container">
                        <div class="no-results-text">
                            <p>No se encontraron resultados.</p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Pie de página -->
    <footer id="pie-pagina">
        <p>&copy; 2024 Electronics For All. Todos los derechos reservados. Empresa 100% sustentable.</p>
    </footer>
    <style>
        #pie-pagina {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 20px 0;
            font-size: 14px;
            margin-top: auto; /* Mantener al pie de página abajo */
            width: 100%;
        }

        footer p {
            margin: 0;
        }
    </style>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
