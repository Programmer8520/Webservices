<?php
include '../../conexiones/conexion_sipisa.php';

$uuid = $_GET["uuid"];

$query = "SELECT DISTINCT nombre_producto FROM tb_detalle_carga_tpt WHERE uuid_cabecero_carga_tpt = '".$uuid."' AND numero_documento <> '-'";

$consulta = mysqli_query($conexion, $query);

if (mysqli_num_rows($consulta) > 0){
    $arr = array();
    $i = 0;
    while ($fila = mysqli_fetch_array($consulta)){
        $cantidades = "SELECT count(*) as cantidad FROM tb_detalle_carga_tpt WHERE nombre_producto LIKE '%".$fila[0]."%' AND uuid_cabecero_carga_tpt = '".$uuid. "'";
        $arr[$i]["nombre_producto"] = utf8_encode($fila[0]);
        $consultar = mysqli_query($conexion, $cantidades);
        if (mysqli_num_rows($consultar) > 0){
            $fila = mysqli_fetch_assoc($consultar);
            $arr[$i]["cantidad_esperada"] = $fila["cantidad"];
            $i++;
        }
    }
}else {

    echo "No se tienen registros sobre ese ID.";
}

echo json_encode($arr);

mysqli_close($conexion);

?>