<?php

include '../../conexiones/conexion_sipisa.php';

/*$query = "SELECT NOW() as fecha";

$consulta = mysqli_query($conexion, $query);

if(mysqli_num_rows($consulta))
{
    
    while ($fila = mysqli_fetch_assoc($consulta))
    {
        echo strval($fila["fecha"]);
    }
}*/

date_default_timezone_set('UTC');

if (mysqli_query($conexion, "SET time_zone='America/Mexico_City'")){
    $query = "SELECT NOW() as fecha";

    $consulta = mysqli_query($conexion, $query);

    if(mysqli_num_rows($consulta))
    {
    
        while ($fila = mysqli_fetch_assoc($consulta))
        {
            echo strval($fila["fecha"]);
        }
    }
}


?>