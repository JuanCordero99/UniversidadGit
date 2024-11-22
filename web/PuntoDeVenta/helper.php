<?php
function verificar_sesion($token,$tipo_usu){
    return isset($_SESSION) &&
            isset ($_SESSION["tipo_usu"]) &&
            isset ($_SESSION["token"]) &&
            ($_SESSION["tipo_usu"] == $tipo_usu) &&
            ($_SESSION["token"] == $token);
}
