<?php

include '../../conexiones/conexion_sipisa.php';

$fecha = substr(obtenerFecha($conexion), 0, 10);

$sql = "SELECT DISTINCT
            numero_analista_inventarios, nombre_analista_inventarios
        FROM
            tb_cabecero_carga_tpt
        WHERE
            llegada_transportista >= '".$fecha."'
        ORDER BY cabecero_carga_tpt_id DESC";

$consulta = mysqli_query($conexion, $sql);

if (mysqli_num_rows($consulta) > 0){
    $arr = array();
    $i=0;
    while ($fila = mysqli_fetch_assoc($consulta)){
        $arr[$i]["numero_analista"] = $fila["numero_analista_inventarios"];
        $arr[$i]["nombre_analista"] = $fila["nombre_analista_inventarios"];
        $i++;
    }

    echo json_encode($arr);
}


?>