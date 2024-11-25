<?php 
  include "../conexion.php";
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
      <a class="navbar-brand" href="../creacion-inicioCuenta/iniciarSesion.html">Ingresar</a>
      <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel" style="background-color: #c2c2c0;">
        <div class="offcanvas-header">
          <div class="offcanvas-title" id="offcanvasNavbarLabel" class="logo"><img src="../imagenes/barra-navegacion/electronics.png" alt="ElectronicsForAll Logo" style="width: 20vw;"></div>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="../public/index.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#" style="font-weight: 700; font-size: 1.3em;">Categorías</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href=" ../public/producto_telefonia.php">Teléfonos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="../public/producto_laptop.php">Laptops</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="../public/producto_audifonos.php">Audífonos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="../public/producto_bocina.php">Bocinas</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="../public/producto_smartwatch.php">Smartwatches</a>
            </li>
          </ul>
          <hr> <!-- Línea separadora -->
          <form action="../public/buscar.php" method="POST" class="d-flex mt-3" role="search" >
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="buscar">
            <button class="btn btn-outline-success" type="submit" name="palabra">Buscar</button>
          </form>
          <!-- Sección de perfil y carrito -->
        </div>
      </div>
    </div>
</nav>
<script src="../boostrap/bootstrap.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>