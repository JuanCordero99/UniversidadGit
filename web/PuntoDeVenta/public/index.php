<?php
    include "C:\wamp64\www\integradora_diseno\conexion.php";
    require_once "../public/barra_nav_public.php";
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
            background-color: #999;
            position: relative;
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
    <main>
        <section id="laptops" class="product-section" style="margin: 0% 10%;">
            <br>
            <h2><a href="/integradora_diseno/public/producto_laptop.php" style="text-decoration: none; color:#222">Laptops</a></h2>
            <div class="product-grid">
                <div class="product laptop1">
                    <a href="/integradora_diseno/public/visualizacion_completa.php?id_producto=7">
                        <img src="/integradora_diseno/imagenes/7.png" alt="Imagen de la Acer Nitro 5">
                    </a>
                </div>
                <div class="product">
                    <a href="/integradora_diseno/public/visualizacion_completa.php?id_producto=10">
                        <img src="/integradora_diseno/imagenes/10.png">
                    </a>
                </div>
                <div class="product">
                    <a href="/integradora_diseno/public/visualizacion_completa.php?id_producto=9">
                        <img src="/integradora_diseno/imagenes/9.png">
                    </a>
                </div>
            </div>
        </section>
        <section id="celulares" class="product-section" style="margin: 0% 10%;">
            <h2><a href="/integradora_diseno/public/producto_telefonia.php" style="text-decoration: none; color:#222">Telefonos</a></h2>
            <div class="product-grid">
                <div class="product">
                    <a href="/integradora_diseno/public/visualizacion_completa.php?id_producto=5">
                        <img src="/integradora_diseno/imagenes/5.png" class="modificar_telefonos" alt="iPhone">
                    </a>
                </div>
                <div class="product celular3">
                    <a href="/integradora_diseno/public/visualizacion_completa.php?id_producto=2">
                        <img src="/integradora_diseno/imagenes/2.png" class="modificar_telefonos" alt="Samsung">
                    </a>
                </div>
                <div class="product celular3">
                    <a href="/integradora_diseno/public/visualizacion_completa.php?id_producto=3">
                        <img src="/integradora_diseno/imagenes/3.png" class="modificar_telefonos" alt="Teléfono 3">
                    </a>
                </div>
            </div>
        </section>
        <section id="Audifonos" class="product-section" style="margin: 0% 10%;">
            <h2><a href="/integradora_diseno/public/producto_audifonos.php" style="text-decoration: none; color:#222">Audifonos</a></h2>
            <div class="product-grid">
                <div class="product">
                    <a href="/integradora_diseno/public/visualizacion_completa.php?id_producto=32">
                        <img src="/integradora_diseno/imagenes/32.png" class="modificar_telefonos" alt="iPhone">
                    </a>
                </div>
                <div class="product celular3">
                    <a href="/integradora_diseno/public/visualizacion_completa.php?id_producto=28">
                        <img src="/integradora_diseno/imagenes/28.png" class="modificar_telefonos" alt="Samsung">
                    </a>
                </div>
                <div class="product celular3">
                    <a href="/integradora_diseno/public/visualizacion_completa.php?id_producto=31">
                        <img src="/integradora_diseno/imagenes/31.png" class="modificar_telefonos" alt="Teléfono 3">
                    </a>
                </div>
            </div>
        </section>
        <section id="Bocinas" class="product-section" style="margin: 0% 10%;">
            <h2><a href="/integradora_diseno/public/producto_bocina.php" style="text-decoration: none; color:#222">Bocinas</a></h2>
            <div class="product-grid">
                <div class="product">
                    <a href="/integradora_diseno/public/visualizacion_completa.php?id_producto=14">
                        <img src="/integradora_diseno/imagenes/14.png" class="modificar_telefonos" alt="iPhone">
                    </a>
                </div>
                <div class="product celular3">
                    <a href="/integradora_diseno/public/visualizacion_completa.php?id_producto=15">
                        <img src="/integradora_diseno/imagenes/15.png" class="modificar_telefonos" alt="Samsung">
                    </a>
                </div>
                <div class="product celular3">
                    <a href="/integradora_diseno/public/visualizacion_completa.php?id_producto=13">
                        <img src="/integradora_diseno/imagenes/13.png" class="modificar_telefonos" alt="Teléfono 3">
                    </a>
                </div>
            </div>
        </section>
        <section id="Bocinas" class="product-section" style="margin: 0% 10%;">
            <h2><a href="/integradora_diseno/public/producto_smartwatch.php" style="text-decoration: none; color:#222">Smartwatches</a></h2>
            <div class="product-grid">
                <div class="product">
                    <a href="/integradora_diseno/public/visualizacion_completa.php?id_producto=22">
                        <img src="/integradora_diseno/imagenes/22.png" class="modificar_telefonos" alt="iPhone">
                    </a>
                </div>
                <div class="product celular3">
                    <a href="/integradora_diseno/public/visualizacion_completa.php?id_producto=23">
                        <img src="/integradora_diseno/imagenes/23.png" class="modificar_telefonos" alt="Samsung">
                    </a>
                </div>
                <div class="product celular3">
                    <a href="/integradora_diseno/public/visualizacion_completa.php?id_producto=24">
                        <img src="/integradora_diseno/imagenes/24.png" class="modificar_telefonos" alt="Teléfono 3">
                    </a>
                </div>
            </div>
        </section>
    </main>
     <br>
     <br>
     <br>
     <br>
    <footer id="pie-pagina" >
        <p>&copy; 2024 Electronics For All. Todos los derechos reservados. Empresa 100% sustentable.</p>
    </footer>
</body>
</html>
