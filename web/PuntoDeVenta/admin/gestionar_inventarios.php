<?php

    require_once "../helper.php";
    session_start();
    extract($_REQUEST);
    if(verificar_sesion($token,$usuario)){
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos</title>
    <!-- Bootstrap CSS -->
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Estilos adicionales personalizados -->
    <style>
        body {
            background-color: #0275ce;
            padding-top: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #c0c0c2;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 30px rgba(0,0,0,0.1);
            margin-top: 5%;
        }
        .logo {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 20px auto;
        }
        .btn-container {
            text-align: center;
            margin-top: 20px;
        }
        .btn-container a.btn {
            margin: 10px;
        }
    </style>
</head>
<body>
    
    <div class="container">
        <div class="text-center">
            <img src="../imagenes/barra-navegacion/electronics.png" alt="Electronics For All" class="logo">
        </div>
        
        <div class="btn-container">
            <a href="../admin/anadirProductosGI.php?token=<?= htmlspecialchars($_SESSION['token'])?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu'])?>" class="btn btn-primary mb-4">Asignar sucursal</a>
            <a href="../admin/consultarProductoGI.php?token=<?= htmlspecialchars($_SESSION['token'])?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu'])?>" class="btn btn-primary mb-4">Consultar Productos</a>
            <a href="../admin/modificarstockGI.php?token=<?= htmlspecialchars($_SESSION['token'])?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu'])?>" class="btn btn-primary mb-4">Modificar stock de sucursal</a>
            <a href="../admin/eliminar_productoGl.php?token=<?= htmlspecialchars($_SESSION['token'])?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu'])?>" class="btn btn-danger mb-4">Eliminar Producto</a>
            <a href="../admin/home_admin.php?token=<?= htmlspecialchars($_SESSION['token'])?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu'])?>" class="btn btn-secondary mb-4">Home</a>
        </div>
        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>
<?php
}else{
    header("location: ../creacion-inicioCuenta/mensaje_error.html?token=".$_SESSION['token']."&usuario=".$_SESSION['tipo_usu']."" );
}

?>