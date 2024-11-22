<?php
// Configuración de la base de datos
include "../conexion.php";
require_once "../user/barra_nav.php";
// Consulta a la base de datos para obtener los productos
$sql = "SELECT distinct producto.id_producto, producto.nombre,producto.foto,producto.descripcion, producto.precio
FROM producto
inner join inventario on (inventario.id_producto = producto.id_producto)
WHERE producto.catalogo LIKE 'telefonos' AND producto.estatus LIKE 'activo' AND inventario.stock>=1";
$result = $conexion->query($sql);
            // Cerrar la conexión a la base de datos
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
    <link href="../home/home1.css">
    <link rel="stylesheet" href="PiePagina.css">
</head>
</head>
<body style="background-color: #0275ce;">
    <style>
                body {
            background-color: #0275ce;
            position: relative;
        }
        .carrito2 {
            position: fixed;
            top: 8%;
            right: 20px;
            z-index: 100;
            max-width: 5%; /* Ancho máximo como un porcentaje del ancho de la ventana */
            max-height: auto; /* Altura ajustada automáticamente según el ancho */
        }

        @media (max-width: 768px) {
            .carrito2 {
                max-width: 8%; /* Ajustar tamaño máximo para pantallas medianas */
            }
        }

        @media (max-width: 480px) {
            .carrito2 {
                max-width: 10%; /* Ajustar tamaño máximo para pantallas pequeñas */
            }
        }
    </style>
<a href="../user/carrito_compras.php?token=<?= htmlspecialchars($_SESSION['token']);?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu']);?>">
        <img src="../imagenes/barra-navegacion/carritocompras.png" alt="Carrito de Compras" class="carrito2">
    </a>
    <!-- Barra de navegación -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <div class="container mt-5" style="background-color: #FF9800;">
    <div class="row row-cols-1 row-cols-md-3 g-3" style="background-color: #FF9800;">
        <?php while($producto = $result->fetch_assoc()): ?>
            <div class="col">
                <div class="card h-100 shadow" style="background-color: #c0c0c2;">
                    <img src="<?php echo htmlspecialchars($producto['foto']); ?>" class="card-img-top custom-img-size" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($producto['nombre']); ?></h5>
                        <p class="card-text"><strong>Precio: <?php echo htmlspecialchars($producto['precio']); ?></strong></p>
                        <?php 

                            $id_prod = $producto['id_producto'];
                            
                            $sql_stock = "SELECT inventario.stock,sucursal.nombre
                                FROM inventario
                                    INNER JOIN producto ON(inventario.id_producto=producto.id_producto)
                                    INNER JOIN sucursal ON (sucursal.id_sucursal=inventario.id_sucursal)
                                WHERE producto.catalogo LIKE 'Telefonos' AND  producto.estatus LIKE 'activo' AND producto.id_producto = '$id_prod' AND inventario.stock >=1";
                    
                
                            $result_stock = $conexion->query($sql_stock);

                            while($stock = $result_stock->fetch_assoc()):

                        ?>
                            <p class="card-text">
                                <strong>
                                    Sucursal disponible: <?= htmlspecialchars($stock['nombre']); ?> 
                                    | Stock: <?= htmlspecialchars($stock['stock']); ?> 
                                </strong>
                            </p>
                        <?php endwhile;?>
                        <a href="/integradora_diseno/user/visualizacion_completa.php?id_producto=<?php echo htmlspecialchars($producto['id_producto']);?>&token=<?= htmlspecialchars($_SESSION['token'])?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu'])?>" class="btn btn-primary">Ver más detalles</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<style>
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
.body {
    margin: 0;  /* Asegura que no haya margen en el cuerpo */
    padding-bottom: 60px;  /* Ajusta el padding inferior para dejar espacio al pie de página */
}


</style>


<br>
<footer id="pie-pagina">
        <p>&copy; 2024 Electronics For All. Todos los derechos reservados. Empresa 100% sustentable.</p>
    </footer>
<style>
    footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 20px 0;
            font-size: 14px;
            position:relative;
            bottom: 0;
            width: 100%;
        }

        footer p {
            margin: 0;
        }
        main {
            padding-top: 40px; /* Ajuste para dejar espacio arriba del contenido principal */
        }
        </style>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
