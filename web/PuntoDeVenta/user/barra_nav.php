<?php
    require_once "../helper.php";
    session_start();
    extract($_REQUEST);
    if(verificar_sesion($token,$usuario)){
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../boostrap/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar bg-body-tertiary fixed-top" style="  z-index: 9999; ">
    <div class="container-fluid" style="background-color: #c2c2c0;">
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <form action="../close_session.php?token=<?= htmlspecialchars($_SESSION['token'])?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu'])?>" method="POST">
        <button type="sumbit" class="btn btn-secondary" name="cerrar_sesion" value="cerrar" >Cerrar Sesion</button>
      </form>
      <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel" style="background-color: #c2c2c0;">
        <div class="offcanvas-header">
          <div class="offcanvas-title" id="offcanvasNavbarLabel" class="logo"><img src="../imagenes/barra-navegacion/electronics.png" alt="ElectronicsForAll Logo" style="width: 20vw;"></div>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="../user/index.php?token=<?= htmlspecialchars($_SESSION['token'])?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu'])?>">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#" style="font-weight: 700; font-size: 1.3em;">Categorías</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href=" /integradora_diseno/user/producto_telefonia.php?token=<?= htmlspecialchars($_SESSION['token'])?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu'])?>">Teléfonos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="/integradora_diseno/user/producto_laptop.php?token=<?= htmlspecialchars($_SESSION['token'])?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu'])?>">Laptops</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="/integradora_diseno/user/producto_audifonos.php?token=<?= htmlspecialchars($_SESSION['token'])?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu'])?>">Audífonos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="/integradora_diseno/user/producto_bocina.php?token=<?= htmlspecialchars($_SESSION['token'])?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu'])?>">Bocinas</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="/integradora_diseno/user/producto_smartwatch.php?token=<?= htmlspecialchars($_SESSION['token'])?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu'])?>">Smartwatches</a>
            </li>
          </ul>
          <hr>
           <!-- Línea separadora -->
          <form action="../user/buscar.php?token=<?= htmlspecialchars($_SESSION['token'])?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu'])?>" method="POST" class="d-flex mt-3" role="search" >
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="buscar">
            <button class="btn btn-outline-success" type="submit" name="palabra">Buscar</button>
          </form>

          <!-- Sección de perfil y carrito -->
          <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="profile">
                <a href="../user/perfil.php?token=<?= htmlspecialchars($_SESSION['token'])?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu'])?>">
                  <img src="../imagenes/barra-navegacion/perfil.png" alt="User Icon" class="icono-perfil" style="width:10vh;">
                </a>
            </div>
            <div class="cart-container">
              <a href="/integradora_diseno/user/carrito_compras.php?token=<?= htmlspecialchars($_SESSION['token'])?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu'])?>" class="d-flex align-items-center">
                <img src="../imagenes/barra-navegacion/carritocompras.png" alt="Cart Icon" class="icono-carrito" style="width: 10vh;">
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
</nav>
<script src="../boostrap/bootstrap.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
  }else{
    header("location: /integradora_diseno/creacion-inicioCuenta/mensaje_error.html?token=".$_SESSION['token']."&usuario=".$_SESSION['tipo_usu']."" );
  }
?>
