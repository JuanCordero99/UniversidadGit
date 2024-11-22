<?php
    require_once "../helper.php";
    session_start();
    extract($_REQUEST);

    extract($_REQUEST);
    if(verificar_sesion($token,$usuario)){
        include("../conexion.php");

//CONSULTA PARA FILTRAR TODOS LOS PRODUCTOS ACTIVOS DE TODAS LAS SUCURSALES
$sql = "SELECT *
        FROM producto_sucursal_inventario
        WHERE estatus LIKE 'activo'";
$result_act = $conexion->query($sql);



//CONSULTA PARA FILTRAR PRODUCTOS ACTIVOS POR SUCURSAL QUERETARO
$sql_qro = "SELECT *
            FROM producto_sucursal_inventario
            WHERE nom_sucursal LIKE 'Queretaro' AND estatus LIKE 'activo'";
$result_qro = $conexion->query($sql_qro);



//CONSULTA PARA FILTRAR PRODUCTOS ACTIVOS POR SUCURSAL GUANAJUATO
$sql_gto = "SELECT *
            FROM producto_sucursal_inventario
            WHERE nom_sucursal LIKE 'Guanajuato' AND estatus LIKE 'activo'";
$result_gto = $conexion->query($sql_gto);



//CONSULTA PARA FILTRAR PRODUCTOS ACTIVOS POR SUCURSAL CDMX
$sql_cdmx = "SELECT *
            FROM producto_sucursal_inventario
            WHERE nom_sucursal LIKE 'Ciudad de Mexico' AND estatus LIKE 'activo'";
$result_cdmx = $conexion->query($sql_cdmx);



//CONSULTA PARA FILTRAR TODOS LOS PRODUCTOS INACTIVOS
$sql_inact = "SELECT * 
            FROM producto 
            WHERE estatus LIKE 'inactivo'";
$result_inact = $conexion->query($sql_inact);



//CERRAR LA CONEXIÓN POR SEGURIDAD Y EVITAR FUGA DE DATOS 
$conexion->close();
?>
<?php
    }else{
        header("location: ../creacion-inicioCuenta/mensaje_error.html?token=".$_SESSION['token']."&usuario=".$_SESSION['tipo_usu']."" ); 
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="container_dinamico.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <meta http-equiv="Content-Type" content="image/png">
    <title>Agregar productos</title>
    <style>
        body {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">

    <a class="navbar-brand" href="gestionar_inventarios.php?token=<?= htmlspecialchars($_SESSION['token'])?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu'])?>" >Home</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav" style="background-color: #ccc;">
        <ul class="navbar-nav mr-auto">
        <li class="nav-item">
                <a class="nav-link" href="#productos_inactivos" style="font-weight: 500;" >Productos inactivos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#productos_activos_qro" style="font-weight: 500;" >Sucursal Querétaro</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#productos_activos_gto" style="font-weight: 500;">Sucursal Guanajuato</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#productos_activos_cdmx" style="font-weight: 500;">Sucursal Ciudad de México</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container-fluid mt-5">
    <!-- Productos activos de Querétaro -->
    <section id="productos_activos_qro">
        <br>
        <h2 class="text-center mb-4">PRODUCTOS ACTIVOS SUCURSAL QUERÉTARO</h2>
        <div class="container">
            <div class="table-responsive bg-white p-3 rounded">
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID producto</th>
                            <th>Nombre</th>
                            <th>Precio</th>
                            <th>Descripción</th>
                            <th>Foto</th>
                            <th>Estatus</th>
                            <th>Categoría</th>
                            <th>Sucursal</th>
                            <th>Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($productos_qro = $result_qro->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($productos_qro['id_producto']); ?></td>
                                <td><?php echo htmlspecialchars($productos_qro['nom_producto']); ?></td>
                                <td><?php echo htmlspecialchars($productos_qro['precio']); ?></td>
                                <td style="text-align: justify;"><?php echo htmlspecialchars($productos_qro['descripcion']); ?></td>
                                <td><img src="<?php echo htmlspecialchars($productos_qro['foto']); ?>" width='150px' height='auto'></td>
                                <td><?php echo htmlspecialchars($productos_qro['estatus']); ?></td>
                                <td><?php echo htmlspecialchars($productos_qro['catalogo']); ?></td>
                                <td><?php echo htmlspecialchars($productos_qro['nom_sucursal']); ?></td>
                                <td><?php echo htmlspecialchars($productos_qro['stock']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Productos activos de Guanajuato -->
    <section id="productos_activos_gto">
        <h2 class="text-center mb-4">PRODUCTOS ACTIVOS SUCURSAL GUANAJUATO</h2>
        <div class="container">
            <div class="table-responsive bg-white p-3 rounded">
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID producto</th>
                            <th>Nombre</th>
                            <th>Precio</th>
                            <th>Descripción</th>
                            <th>Foto</th>
                            <th>Estatus</th>
                            <th>Categoría</th>
                            <th>Sucursal</th>
                            <th>Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($productos_gto = $result_gto->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($productos_gto['id_producto']); ?></td>
                                <td><?php echo htmlspecialchars($productos_gto['nom_producto']); ?></td>
                                <td><?php echo htmlspecialchars($productos_gto['precio']); ?></td>
                                <td style="text-align: justify;"><?php echo htmlspecialchars($productos_gto['descripcion']); ?></td>
                                <td><img src="<?php echo htmlspecialchars($productos_gto['foto']); ?>" width='150px' height='auto'></td>
                                <td><?php echo htmlspecialchars($productos_gto['estatus']); ?></td>
                                <td><?php echo htmlspecialchars($productos_gto['catalogo']); ?></td>
                                <td><?php echo htmlspecialchars($productos_gto['nom_sucursal']); ?></td>
                                <td><?php echo htmlspecialchars($productos_gto['stock']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Productos activos de Ciudad de México -->
    <section id="productos_activos_cdmx">
        <h2 class="text-center mb-4">PRODUCTOS ACTIVOS SUCURSAL CIUDAD DE MÉXICO</h2>
        <div class="container">
            <div class="table-responsive bg-white p-3 rounded">
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID producto</th>
                            <th>Nombre</th>
                            <th>Precio</th>
                            <th>Descripción</th>
                            <th>Foto</th>
                            <th>Estatus</th>
                            <th>Categoría</th>
                            <th>Sucursal</th>
                            <th>Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($productos_cdmx = $result_cdmx->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($productos_cdmx['id_producto']); ?></td>
                                <td><?php echo htmlspecialchars($productos_cdmx['nom_producto']); ?></td>
                                <td><?php echo htmlspecialchars($productos_cdmx['precio']); ?></td>
                                <td style="text-align: justify;"><?php echo htmlspecialchars($productos_cdmx['descripcion']); ?></td>
                                <td><img src="<?php echo htmlspecialchars($productos_cdmx['foto']); ?>" width='150px' height='auto'></td>
                                <td><?php echo htmlspecialchars($productos_cdmx['estatus']); ?></td>
                                <td><?php echo htmlspecialchars($productos_cdmx['catalogo']); ?></td>
                                <td><?php echo htmlspecialchars($productos_cdmx['nom_sucursal']); ?></td>
                                <td><?php echo htmlspecialchars($productos_cdmx['stock']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Productos inactivos -->
    <section id="productos_inactivos">
        <h2 class="text-center mb-4">PRODUCTOS INACTIVOS</h2>
        <div class="container">
            <div class="table-responsive bg-white p-3 rounded">
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID producto</th>
                            <th>Nombre</th>
                            <th>Precio</th>
                            <th>Descripción</th>
                            <th>Foto</th>
                            <th>Estatus</th>
                            <th>Categoría</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($producto2 = $result_inact->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($producto2['id_producto']); ?></td>
                                <td><?php echo htmlspecialchars($producto2['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($producto2['precio']); ?></td>
                                <td><?php echo htmlspecialchars($producto2['descripcion']); ?></td>
                                <td><img src="<?php echo htmlspecialchars($producto2['foto']); ?>" width='150px' height='auto'></td>
                                <td><?php echo htmlspecialchars($producto2['estatus']); ?></td>
                                <td><?php echo htmlspecialchars($producto2['catalogo']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
<footer class="text-center py-3 mt-5">
    <p>&copy; 2024 Electronics For All. Todos los derechos reservados. Empresa 100% sustentable.</p>
</footer>

<style>
footer {
    background-color: #334 !important;
}
</style>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
