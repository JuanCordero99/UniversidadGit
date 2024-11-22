<?php
include "../conexion.php"; 
require_once "../helper.php";
session_start();
extract($_REQUEST);

if (verificar_sesion($token, $usuario)) {        
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['id_inventario'])) {
            $id_inventario = $_POST['id_inventario'];

            // Agregar producto al carrito
            if (isset($_POST['añadir_carrito']) && $_POST['añadir_carrito'] === 'añadir') {
                if (!isset($_SESSION['carrito'])) {
                    $_SESSION['carrito'] = array();
                    $_SESSION['cantidad'] = array();
                }
                $index = array_search($id_inventario, $_SESSION['carrito']);
                if ($index === false) {
                    $_SESSION['carrito'][] = $id_inventario;
                    $_SESSION['cantidad'][] = 1;  // Agregar cantidad inicial de 1
                } else {
                    $_SESSION['cantidad'][$index] += 1;  // Incrementar la cantidad
                }
            }

            // Eliminar producto del carrito
            if (isset($_POST['eliminar']) && $_POST['eliminar'] === 'eliminar') {
                if (isset($_SESSION['carrito'])) {
                    $index = array_search($id_inventario, $_SESSION['carrito']);
                    if ($index !== false) {
                        unset($_SESSION['carrito'][$index]);
                        unset($_SESSION['cantidad'][$index]);
                        // Reindexar los arrays para evitar huecos en los índices
                        $_SESSION['carrito'] = array_values($_SESSION['carrito']);
                        $_SESSION['cantidad'] = array_values($_SESSION['cantidad']);
                    }
                }
            }

            // Actualizar la cantidad de productos en el carrito
            if (isset($_POST['aumentar']) || isset($_POST['disminuir'])) {
                $index = array_search($id_inventario, $_SESSION['carrito']);
                if ($index !== false) {
                    if (isset($_POST['aumentar']) && $_SESSION['cantidad'][$index] < $_POST['stock']) {
                        $_SESSION['cantidad'][$index] += 1;
                    } elseif (isset($_POST['disminuir']) && $_SESSION['cantidad'][$index] > 1) {
                        $_SESSION['cantidad'][$index] -= 1;
                    }
                }
            }
        }
    }

    // Recuperar los productos del carrito
    $carrito = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : array();
    $productos = array();

    if (!empty($carrito)) {
        $ids = implode(',', array_map('intval', $carrito));
        $sql = "SELECT producto.id_producto, producto.nombre, producto.precio, producto.foto, inventario.stock, sucursal.nombre as nombre_suc, inventario.id_inventario
                FROM inventario 
                INNER JOIN producto ON inventario.id_producto = producto.id_producto
                INNER JOIN sucursal ON sucursal.id_sucursal = inventario.id_sucursal
                WHERE inventario.id_inventario IN ($ids)";
        $result = $conexion->query($sql);

        if ($result === false) {
            echo "Error en la consulta: " . $conexion->error . "<br>";
            echo "Consulta SQL: " . $sql . "<br>";
        } else {
            while ($row = $result->fetch_assoc()) {
                $productos[] = $row;
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="../user/carritoCompra.css">
    <link rel="stylesheet" href="../user/PiePagina.css">
    <link href="../home/home1.css">
    <style>
        body {
            background-color: #0275ce;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        #titulo-carrito {
            color: #fff;
            text-align: center;
        }
        .producto {
            background-color: #bbb;
            padding: 20px;
            margin: 10px;
            display: flex;
            align-items: center;
        }
        .producto img {
    width: 150px; /* Ancho fijo para la imagen */
    height: 150px; /* Altura fija para la imagen */
    object-fit: contain; /* Ajuste el tamaño de la imagen dentro del contenedor sin distorsión */
    margin-right: 20px;
}


        .detalles-producto {
            flex-grow: 1;
        }
        .cantidad-butones {
            display: flex;
            align-items: center;
        }
        .cantidad-butones .boton {
            margin: 0 5px;
        }
        .contenedor-boton-finalizar {
            margin-top: auto;
            display: flex;
            justify-content: space-between;
            padding: 20px;
            background-color: #0275ce;
        }

        #pie-pagina {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            margin-top: auto;
        }
    </style>
</head>
<body>
    <h1 id="titulo-carrito">Carrito de Compras</h1>
    <?php if (!empty($productos)): ?>
        <?php foreach ($productos as $producto): ?>
            <?php $index = array_search($producto['id_inventario'], $_SESSION['carrito']); ?>
            <div class="producto" id="producto<?= htmlspecialchars($producto['id_inventario']) ?>">
                <img src="<?= htmlspecialchars($producto['foto']) ?>" alt="<?= htmlspecialchars($producto['nombre']) ?>">
                <div class="detalles-producto">
                    <h2>Nombre: <?= htmlspecialchars($producto['nombre']) ?></h2>
                    <p>Precio: $<?= number_format($producto['precio'], 2) ?></p> 
                    <p>Stock: <?= htmlspecialchars($producto['stock']) ?></p> 
                    <p>Sucursal: <?= htmlspecialchars($producto['nombre_suc']) ?></p> 
                </div>
                <div class="cantidad-butones">
                    <form action="../user/carrito_compras.php?token=<?= htmlspecialchars($_SESSION['token']) ?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu']) ?>" method="post">
                        <button class="boton" name="disminuir">-</button>
                        <span><?= htmlspecialchars($_SESSION['cantidad'][$index]); ?></span>
                        <button class="boton" name="aumentar">+</button>
                        <input type="hidden" name="id_inventario" value="<?= htmlspecialchars($producto['id_inventario']); ?>">
                        <input type="hidden" name="stock" value="<?= htmlspecialchars($producto['stock']); ?>">
                    </form>
                    <form action="../user/carrito_compras.php?id_inventario=<?= htmlspecialchars($producto['id_inventario']); ?>&token=<?= htmlspecialchars($_SESSION['token']) ?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu']) ?>" method="post">
                        <input type="hidden" name="id_inventario" value="<?= htmlspecialchars($producto['id_inventario']); ?>">
                        <button class="boton" name="eliminar" value="eliminar">Eliminar del Carrito</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
        <div class="contenedor-boton-finalizar">
        <a href="../user/index.php?token=<?= htmlspecialchars($_SESSION['token']) ?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu'])?>" class="boton" id="volver-productos">Volver a Productos</a>
        <a href="../user/confirmacion_compra.php?token=<?= htmlspecialchars($_SESSION['token']) ?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu']) ?>&carrito=<?= urlencode(serialize($_SESSION['carrito'])) ?>&cantidad=<?= urlencode(serialize($_SESSION['cantidad'])) ?>" class="boton">Comprar Ahora</a>
    </div>
    <?php else: ?>
        <div class="conteiner">
            <h2 style="text-align: center;">No hay productos en el carrito.</h2>
            <div class="contenedor-boton-finalizar">
                <a href="../user/index.php?token=<?= htmlspecialchars($_SESSION['token']) ?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu'])?>" class="boton" id="volver-productos">Volver a Productos</a>
            </div>
        </div>
    <?php endif; ?>
    <footer id="pie-pagina">
        <p>&copy; 2024 Electronics For All. Todos los derechos reservados. Empresa 100% sustentable.</p>
    </footer>
</body>
</html>
<?php
} else {
    header("location: ../creacion-inicioCuenta/mensaje_error.html?token=" . $_SESSION['token'] . "&usuario=" . $_SESSION['tipo_usu']);
}
?>