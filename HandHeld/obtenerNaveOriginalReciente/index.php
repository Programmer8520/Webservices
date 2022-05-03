<?php
include '../../conexiones/conexion_sipisa.php';

$query = "SELECT clave_carga_original ,nave_carga_original FROM tb_cabecero_carga_tpt ORDER BY cabecero_carga_tpt_id DESC LIMIT 1";

$consulta = mysqli_query($conexion, $query);

if(mysqli_num_rows($consulta) > 0){
    $arr = array();
    $i = 0;
    while ($fila = mysqli_fetch_array($consulta)){
        $arr[0]["clave_carga_original"] = $fila[0];
        $arr[0]["nave_carga_original"] = $fila[1];
    }
    echo json_encode($arr);
}

?>