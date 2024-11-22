<?php
// Configuración de la base de datos
include "../conexion.php";

// Obtener el ID del producto desde la 
require_once "../user/barra_nav.php";
$id_producto = isset($id_producto) ? (int) $id_producto : 0;
//$id_sucursal = isset($id_sucursal) ? (int) $id_sucursal : 0;


// Consulta a la base de datos para obtener los detalles del producto
$sql = "SELECT producto.id_producto, producto.nombre, producto.precio,
        producto.descripcion, producto.foto, inventario.stock, inventario.id_inventario,
        inventario.id_sucursal
        FROM inventario 
            INNER JOIN producto ON(producto.id_producto=inventario.id_producto)
            INNER JOIN sucursal ON(inventario.id_sucursal=sucursal.id_sucursal)
        WHERE inventario.id_producto = '$id_producto'";
$result = $conexion->query($sql);

// Obtener el producto
$producto = $result->fetch_assoc();

$sql_sucursales = "SELECT inventario.id_sucursal, sucursal.descripcion_direccion, sucursal.nombre,
                    inventario.id_inventario, inventario.stock
    FROM inventario 
        inner join producto on(producto.id_producto=inventario.id_producto) 
        inner join sucursal on(inventario.id_sucursal=sucursal.id_sucursal)
    WHERE inventario.id_producto = '$id_producto' AND inventario.stock >=1";

$result_sucursales = $conexion->query($sql_sucursales);


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
</head>
</head>
<body style="background-color: #0275ce; display: flex; flex-direction: column; min-height: 100vh;">
    <!-- Barra de navegación -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <div class="container mt-5">
    <?php if ($producto): ?>
        <div class="row">
            <div class="col-md-6">
                <img src="<?php echo htmlspecialchars($producto['foto']); ?>" class="card-img-top custom-img-size" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
            </div>
            <div class="col-md-6">
                <h1><?php echo htmlspecialchars($producto['nombre']); ?></h1>
                <h3><strong>Precio: $<?php echo htmlspecialchars($producto['precio']); ?></strong></h3>
                <p style="text-align: justify;"><?php echo htmlspecialchars($producto['descripcion']); ?></p>

                <form action="../user/carrito_compras.php?token=<?= htmlspecialchars($_SESSION['token'])?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu'])?>" method="post">

                    <div class="form-group">
                        <label for="sucursal">Sucursal Disponible:</label>
                        <select id="sucursal" name="id_inventario" class="form-control">
                            <?php while ($sucursal = $result_sucursales->fetch_assoc()):?>
                                <option value="<?php echo htmlspecialchars($sucursal['id_inventario']); ?>">
                                    Sucursal: <?php echo htmlspecialchars($sucursal['nombre']); ?>
                                    | Stock: <?php echo htmlspecialchars($sucursal['stock']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <!-- Botones de cantidad y añadir al carrito -->
                    <div class="botones-grupo">
                    <a href="../user/index.php?token=<?= htmlspecialchars($_SESSION['token']); ?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu']); ?>" class="boton" id="enlace-volver" name="enlace-volver" style="text-decoration: none; color: #333; border: 2px solid black;">Volver a Productos</a>
                        <div class="cantidad-butones">
                        <button type="submit" class="boton" id="añadir-carrito" name="añadir_carrito" value="añadir" style="text-decoration: none; color: #333;">Añadir al Carrito</button>

                        </div>
                    </div>


                </form>
            </div>
        </div>
    <?php else: ?>
        <p>Producto no encontrado.</p>
        <p>
            <?="ID del producto: $id_producto"?>
        </p>
    <?php endif; ?>
</div>

<style>
/* Estilos para la visualización del producto */
.container {
    background-color: #c0c0c2;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.product-img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
}

.product-details {
    padding-left: 20px;
}

.product-name {
    font-size: 2rem;
    font-weight: bold;
    margin-top: 20px;
}

.product-price {
    font-size: 1.5rem;
    color: #007bff;
    margin-top: 10px;
}

.product-description {
    margin-top: 20px;
    line-height: 1.6;
}

.form-group {
    margin-top: 20px;
}

.btn-primary {
    margin-top: 20px;
}
.botones-grupo {
    margin-top: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.boton {
    background-color: #FF7700;
    color: #fff;
    padding: 10px 20px;
    text-decoration: none;
    border-radius: 4px;
    transition: background-color 0.3s;
}

.boton:hover {
    background-color: #FF5500;
}

#cantidad {
    padding: 0 10px;
    font-weight: bold;
    font-size: 1.2em;
}

</style>
 <!-- SCIPT PARA LA UTILIZACION DEL BOTON-->
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <br>
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
</body>
</html>

