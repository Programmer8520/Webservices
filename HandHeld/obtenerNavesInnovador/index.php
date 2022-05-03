<?php
include '../../conexiones/conexion_sipisa.php';

$query = "SELECT * FROM tb_naves";

$consulta = mysqli_query($conexion, $query);

if (mysqli_num_rows($consulta) > 0){
    $arr = array();
    $i = 0;
    while ($fila = mysqli_fetch_array($consulta)){
        $arr[$i]["id_nave"] = $fila[0];
        $arr[$i]["clave_nave"] = $fila[1];
        $arr[$i]["nave"] = $fila[2];
        $i++;
    }

    echo json_encode($arr);

}


?>