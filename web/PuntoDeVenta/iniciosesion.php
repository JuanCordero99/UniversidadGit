<?php

    include "conexion.php";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $correo = $_POST["correo"];
        $contrasena = $_POST["contrasena"];

        $sql = "SELECT contrasena, correo, tipo_usuario FROM usuario WHERE contrasena like '$contrasena' and correo like '$correo'";
        $resultado = $conexion->query($sql);

        if($resultado->num_rows > 0){
            $row = $resultado->fetch_assoc();
            $contra_bd = $row['contrasena'];
            $correo_bd = $row['correo'];
            $tipo_usu_bd = $row['tipo_usuario'];
            //VALIDACION SI ES UN ADMIN
            if($contra_bd==$contrasena && $correo_bd==$correo){
                session_start();
                session_regenerate_id();
                $_SESSION ['correo'] = $correo_bd;
                $_SESSION ['tipo_usu'] = $tipo_usu_bd;
                $_SESSION ['token'] = session_id();

                if($tipo_usu_bd=='administrador'){
                    echo "Bienvenido Admin";
                    header("Location: /integradora_diseno/admin/home_admin.php?token=".$_SESSION['token']."&usuario=".$_SESSION['tipo_usu']."&correo=".$_SESSION['correo']);    
                }else{
                    echo "Bienvenido";
                    header("Location: /integradora_diseno/user/index.php?token=".$_SESSION['token']."&usuario=".$_SESSION['tipo_usu']."&correo=".$_SESSION['correo']);    
                }
            }
        }else{
            header("Location: /integradora_diseno/creacion-inicioCuenta/mensaje_error.html");
        }
    }
