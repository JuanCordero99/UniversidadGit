<?php
include "conexion.php";
require_once "helper.php";
session_start();
extract($_REQUEST);
if(verificar_sesion($token,$usuario)){
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST["cerrar_sesion"]) && $_POST["cerrar_sesion"] === 'cerrar'){
            session_unset();
            session_destroy();
            header("Location: ../integradora_diseno/public/index.php");
        }
    }
}
?>