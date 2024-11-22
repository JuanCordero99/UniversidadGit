<?php
include "../conexion.php";
require_once "../config_paypal.php";
require_once "../helper.php";
session_start();
extract($_REQUEST);

if (verificar_sesion($token, $usuario)) {

    $carrito = isset($_GET['carrito']) ? unserialize(urldecode($_GET['carrito'])) : array();
$cantidad = isset($_GET['cantidad']) ? unserialize(urldecode($_GET['cantidad'])) : array();

    $productos = array();
    $ids = implode(',', array_map('intval', $carrito));
    $sql = "SELECT producto.id_producto, producto.nombre, producto.precio, producto.foto, inventario.stock, 
            sucursal.nombre as nom_suc, inventario.id_inventario, sucursal.id_sucursal
            FROM inventario 
            INNER JOIN producto ON (inventario.id_producto = producto.id_producto)
            INNER JOIN sucursal ON (inventario.id_sucursal = sucursal.id_sucursal)
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

    $total = 0;
    echo "<br>";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar productos</title>
    <script src="https://www.paypal.com/sdk/js?client-id=AY88D7HG7-05XgChjY_F5-d1taqPtUzXRS8RMxMF_UGsNZkK3NtUAVJcg8YWZTLdnqf28VCukse7owfT&currency=MXN"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../user/carritoCompra.css">
    <link rel="stylesheet" href="../styles.css">
    <style>
        body {
            background-color: #0275ce;
            color: #495057;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
/* Estilos generales */
.header {
    background-color: #333;
    color: white;
    margin-top: -2%;
    padding: 15px 0;
}

/* Media query para dispositivos con pantalla pequeña */
@media (max-width: 768px) {
    .header {
        padding-top: 10px; /* Ajuste del padding superior */
        padding-bottom: 10px; /* Ajuste del padding inferior */
        margin-top: -25px; /* Ajuste del margen superior para dispositivos pequeños */
    }
}


        .productos-a-confirmar {
            margin-bottom: 20px;
            text-align: center;
        }
        .table {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }
        .total {
            margin-top: 20px;
            background-color: #343a40;
            color: white;
            padding: 10px;
            text-align: center;
            border-radius: 5px;
        }
        #paypal-button-container {
    display: inline-block;
    margin: 10px auto; /* Margen automático en los lados para centrar horizontalmente */
    text-align: center; /* Alineación del contenido al centro */
    width: 20%;
    height: auto;
}
@media (max-width: 768px) {
    #paypal-button-container {
padding-right: 150px ;
    }
}



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
</head>
<body>
    <header class="header">
        <div class="container">
            <a href="../user/carrito_compras.php?token=<?= htmlspecialchars($_SESSION['token']) ?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu']) ?>" class="btn btn-secondary btn-sm">Volver a Carrito</a>
            <h1 class="text-center" style="margin-top: 10px;">Confirmar productos</h1>
        </div>
    </header>
<br>
    <div class="container">
        <div class="productos-a-confirmar">
            <h2 style="color: #fff;">Productos en el carrito</h2>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Foto</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Sucursal</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($productos)): ?>
                        <?php foreach ($productos as $producto): ?>
                            <?php $index = array_search($producto['id_inventario'], $_SESSION['carrito']); ?>
                            <tr>
                                <td><img src="<?= htmlspecialchars($producto['foto']); ?>" alt="<?= htmlspecialchars($producto['nombre']); ?>" style="max-width: 100px;"></td>
                                <td><?= htmlspecialchars($producto['nombre']); ?></td>
                                <td>$<?= number_format($producto['precio'], 2); ?></td>
                                <td><?= htmlspecialchars($producto['nom_suc']); ?></td>
                                <td><?= htmlspecialchars($cantidad[$index]); ?></td>
                                <td>$<?= number_format($cantidad[$index] * $producto['precio'], 2); ?></td>
                            </tr>
                            <?php $subtotal = $producto['precio'] * $cantidad[$index]; ?>
                            <?php $total += $subtotal; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">No hay productos en el carrito.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="total">
            <h3>Total: $<?= number_format($total, 2); ?></h3>
            <div id="paypal-button-container"></div>
        </div>

    </div>
<br>
    <footer id="pie-pagina">
        <div class="container">
            <p>&copy; 2024 Electronics For All. Todos los derechos reservados. Empresa 100% sustentable.</p>
        </div>
    </footer>

    <script>
                alert("Por favor, verifica la sucursal de la cual seleccionaste los productos y asegúrate de que pertenezcan a la misma sucursal para pick up.");

        paypal.Buttons({
            createOrder: (data, actions) => {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '<?= $total; ?>'
                        }
                    }]
                });
            },
            fundingSource: paypal.FUNDING.PAYPAL, // Solo mostrar la opción de pagar con PayPal
            onApprove: (data, actions) => {
                return actions.order.capture().then(function(orderData) {
                    const transaction = orderData.purchase_units[0].payments.captures[0];
                    alert(`Transaction ${transaction.status}: ${transaction.id}`);
                    window.location.href = "http://localhost/integradora_diseno/user/thanks.php?token=<?= htmlspecialchars($_SESSION['token'])?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu']);?>";

                    const carrito = <?= json_encode($carrito); ?>;
                    const cantidad = <?= json_encode($cantidad); ?>;

                    fetch('http://localhost/integradora_diseno/user/compra.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            transactionId: transaction.id,
                            carrito: carrito,
                            cantidad: cantidad
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.text().then(text => { throw new Error(`Network response was not ok: ${response.statusText}, Response body: ${text}`); });
                        }
                        return response.text().then(text => {
                            console.log('Raw response:', text);
                            return JSON.parse(text);
                        });
                    })
                    .then(data => {
                        if (data.error) {
                            console.error('Error:', data.error);
                        } else {
                            console.log('Success:', data);
                        }
                    })
                    .catch((error) => {
                        console.error('Error:', error.message);
                    });

                });
            }
        }).render('#paypal-button-container');
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-Tfk2uk9sY6Uu/6tu6UxsrNQsB6Jp8GZkr4fozDR+N0xZFLsjRc/RHJXp6I3zoHhx" crossorigin="anonymous"></script>
</body>
</html>
<?php
} else {
    header("location: ../creacion-inicioCuenta/mensaje_error.html?token=" . $_SESSION['token'] . "&usuario=" . $_SESSION['tipo_usu']);
}
?>
