<?php
    include("conexion.php");

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $nombre = $_POST["nombre"];
        $apellidos = $_POST["apellidos"];
        $telefono = $_POST["telefono"];
        $fecha_nac= $_POST["fecha_nac"];
        $correo= $_POST["correo"];
        $contrasena= $_POST["contrasena"];
    }  
    
    $sql= "INSERT INTO usuario (tipo_usuario,nombre,apellido,telefono,correo,fecha_nacimiento,contrasena,estatus) 
            VALUES('cliente' ,'$nombre' ,'$apellidos' ,'$telefono','$correo', '$fecha_nac' ,'$contrasena' ,'activo' )";

    if($conexion->query($sql)===TRUE){
        echo"Los datos se han insertado correctamente";
        header("Location: /integradora_diseno/creacion-inicioCuenta/iniciarSesion.html");
    }else{
        echo "Ha ocurrido un problema";
    }

    $conexion->close();
