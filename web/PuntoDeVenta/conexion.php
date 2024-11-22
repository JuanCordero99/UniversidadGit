<?php

    $servidor = "localhost";
    $usuario ="root";
    $contrasena = "";
    $db = "bdprueba017";

    $conexion = new mysqli($servidor, $usuario, $contrasena, $db);

    if($conexion){
        //echo "Conexión realizada<br>";
    }
    else{
        die("Problemas");
    }

    