<?php
include '../../conexiones/conexion_sipisa.php';


$query = "SELECT * FROM tb_nombres_operadores_laroye WHERE estatus = 1";

$arr = array();

if($consulta = mysqli_query($conexion, $query))
{
    if(mysqli_num_rows($consulta) > 0)
    {
        $i = 0;
        while ($fila = mysqli_fetch_assoc($consulta))
        {
            $arr[$i]["id_operador"] = $fila["id_operador"];
            $arr[$i]["nombre_operador"] = utf8_encode($fila["nombre_operador"]);
            $arr[$i]["placas_remolque"] = $fila["placas_remolque"];
            $arr[$i]["placas_tractor"] = $fila["placas_tractor"];

            $i++;
        }
        echo json_encode($arr);
    }
}






?>