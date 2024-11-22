<?php
    include "../conexion.php";
    require_once "../user/barra_nav.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda de Equipos Electrónicos</title>
    <link rel="stylesheet" href="../home1.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
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

        main {
            padding-top: 40px; /* Ajuste para dejar espacio arriba del contenido principal */
        }

        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 20px 0;
            font-size: 14px;
            position: absolute;
            bottom: 0;
            width: 100%;
        }

        footer p {
            margin: 0;
        }
    </style>
</head>
<body>
    <a href="../user/carrito_compras.php?token=<?= htmlspecialchars($_SESSION['token']);?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu']);?>">
        <img src="../imagenes/barra-navegacion/carritocompras.png" alt="Carrito de Compras" class="carrito2">
    </a>
    
    <main>
        <section id="laptops" class="product-section" style="margin: 0% 10%;">
            <br>
            <h2><a href="../user/producto_laptop.php?token=<?= htmlspecialchars($_SESSION['token']);?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu']);?>" style="text-decoration: none; color:#DDD">Laptops</a></h2>
            <div class="product-grid">
                <div class="product laptop1">
                    <a href="../user/visualizacion_completa.php?id_producto=7&token=<?= htmlspecialchars($_SESSION['token']);?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu']);?>">
                        <img src="../imagenes/7.png" alt="Imagen de la Acer Nitro 5">
                    </a>
                </div>
                <div class="product laptop2">
                    <a href="../user/visualizacion_completa.php?id_producto=11&token=<?= htmlspecialchars($_SESSION['token']);?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu']);?>"">
                        <img src="../imagenes/11.png">
                    </a>
                </div>
                <div class="product laptop2">
                    <a href="../user/visualizacion_completa.php?id_producto=9&token=<?= htmlspecialchars($_SESSION['token']);?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu']);?>"">
                        <img src="../imagenes/9.png">
                    </a>
                </div>
            </div>
        </section>
        <section id="celulares" class="product-section" style="margin: 0% 10%;">
            <h2><a href="../user/producto_telefonia.php?token=<?= htmlspecialchars($_SESSION['token']);?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu']);?>" style="text-decoration: none; color:#DDD">Telefonos</a></h2>
            <div class="product-grid">
                <div class="product celular3">
                    <a href="../user/visualizacion_completa.php?id_producto=1&token=<?= htmlspecialchars($_SESSION['token']);?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu']);?>">
                        <img src="../imagenes/1.png" class="modificar_telefonos" alt="iPhone">
                    </a>
                </div>
                <div class="product celular3">
                    <a href="../user/visualizacion_completa.php?id_producto=2&token=<?= htmlspecialchars($_SESSION['token']);?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu']);?>"">
                        <img src="../imagenes/2.png" class="modificar_telefonos" alt="Samsung">
                    </a>
                </div>
                <div class="product celular3">
                    <a href="../user/visualizacion_completa.php?id_producto=6&token=<?= htmlspecialchars($_SESSION['token']);?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu']);?>"">
                        <img src="../imagenes/6.png" class="modificar_telefonos" alt="Teléfono 3">
                    </a>
                </div>
            </div>
        </section>
        <section id="Audifonos" class="product-section" style="margin: 0% 10%;">
            <h2><a href="../user/producto_audifonos.php?token=<?= htmlspecialchars($_SESSION['token']);?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu']);?>" style="text-decoration: none; color:#DDD">Audifonos</a></h2>
            <div class="product-grid">
                <div class="product celular3">
                    <a href="../user/visualizacion_completa.php?id_producto=27&token=<?= htmlspecialchars($_SESSION['token']);?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu']);?>">
                        <img src="../imagenes/27.png" class="modificar_telefonos" alt="iPhone">
                    </a>
                </div>
                <div class="product celular2">
                    <a href="../user/visualizacion_completa.php?id_producto=28&token=<?= htmlspecialchars($_SESSION['token']);?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu']);?>"">
                        <img src="../imagenes/28.png" class="modificar_telefonos" alt="Samsung">
                    </a>
                </div>
                <div class="product celular3">
                    <a href="../user/visualizacion_completa.php?id_producto=29&token=<?= htmlspecialchars($_SESSION['token']);?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu']);?>"">
                        <img src="../imagenes/29.png" class="modificar_telefonos" alt="Teléfono 3">
                    </a>
                </div>
            </div>
        </section>
        <section id="Bocinas" class="product-section" style="margin: 0% 10%;">
            <h2><a href="../user/producto_audifonos.php?token=<?= htmlspecialchars($_SESSION['token']);?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu']);?>" style="text-decoration: none; color:#DDD">Bocinas</a></h2>
            <div class="product-grid">
                <div class="product celular3">
                    <a href="../user/visualizacion_completa.php?id_producto=14&token=<?= htmlspecialchars($_SESSION['token']);?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu']);?>">
                        <img src="../imagenes/14.png" class="modificar_telefonos" alt="iPhone">
                    </a>
                </div>
                <div class="product celular2">
                    <a href="../user/visualizacion_completa.php?id_producto=15&token=<?= htmlspecialchars($_SESSION['token']);?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu']);?>"">
                        <img src="../imagenes/15.png" class="modificar_telefonos" alt="Samsung">
                    </a>
                </div>
                <div class="product celular3">
                    <a href="../user/visualizacion_completa.php?id_producto=17&token=<?= htmlspecialchars($_SESSION['token']);?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu']);?>"">
                        <img src="../imagenes/17.png" class="modificar_telefonos" alt="Teléfono 3">
                    </a>
                </div>
            </div>
        </section>
        <section id="Smartwatches" class="product-section" style="margin: 0% 10%;">
            <h2><a href="../user/producto_smartwatch.php?token=<?= htmlspecialchars($_SESSION['token']);?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu']);?>" style="text-decoration: none; color:#DDD">Smartwatches</a></h2>
            <div class="product-grid">
                <div class="product celular3">
                    <a href="../user/visualizacion_completa.php?id_producto=22&token=<?= htmlspecialchars($_SESSION['token']);?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu']);?>">
                        <img src="../imagenes/22.png" class="modificar_telefonos" alt="iPhone">
                    </a>
                </div>
                <div class="product celular3">
                    <a href="../user/visualizacion_completa.php?id_producto=23&token=<?= htmlspecialchars($_SESSION['token']);?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu']);?>"">
                        <img src="../imagenes/23.png" class="modificar_telefonos" alt="Samsung">
                    </a>
                </div>
                <div class="product celular3">
                    <a href="../user/visualizacion_completa.php?id_producto=24&token=<?= htmlspecialchars($_SESSION['token']);?>&usuario=<?= htmlspecialchars($_SESSION['tipo_usu']);?>"">
                        <img src="../imagenes/24.png" class="modificar_telefonos" alt="Teléfono 3">
                    </a>
                </div>
            </div>
        </section>
    </main>
    <br>
    <br>
    <br>
    <br>
    <footer id="pie-pagina">
        <p>&copy; 2024 Electronics For All. Todos los derechos reservados. Empresa 100% sustentable.</p>
    </footer>
    <style>

</style>
</body>
</html>