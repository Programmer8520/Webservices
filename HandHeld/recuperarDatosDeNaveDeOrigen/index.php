<?php
include '../../conexiones/conexion_sipisa.php';


$query = "SELECT clave_carga_original, nave_carga_original from tb_cabecero_carga_tpt order by cabecero_carga_tpt_id desc limit 1";

$consulta = mysqli_query($conexion, $query);

if (mysqli_num_rows($consulta) > 0){
    $arr = array();
    while($fila = mysqli_fetch_array($consulta)){
        $arr[0]["clave"] = $fila[0];
        $arr[0]["nave"] = $fila[1];
    }

    echo json_encode($arr);

}else{

    echo "No se encuentran datos en el registro solicitado";
}



?>