<?php

include '../../conexiones/conexion_sipisa.php';

$uuid = $_GET["uuid"];

$queryAvance = "SELECT DISTINCT nombre_producto FROM tb_detalle_carga_tpt WHERE uuid_cabecero_carga_tpt = '$uuid' AND numero_documento <> '-'";

$consulta = mysqli_query($conexion, $queryAvance);

if (mysqli_num_rows($consulta) > 0) {

    $arr = array();
    $i = 0;

    while ($fila = mysqli_fetch_array($consulta)) {
        $queryCantidades = "SELECT 
                                count(*) as cantidad 
                            FROM 
                                tb_detalle_carga_tpt 
                            WHERE 
                            nombre_producto LIKE '%".$fila[0]."%' 
                            AND uuid_cabecero_carga_tpt = '".$uuid. "'";
        
        $arr[$i]["nombre_producto"] = utf8_encode($fila[0]);
        $consulta1 = mysqli_query($conexion, $queryCantidades);
        if (mysqli_num_rows($consulta1) > 0) {

            $fila = mysqli_fetch_assoc($consulta1);
            $arr[$i]["tarimas_escaneadas"] = $fila["cantidad"];
            $i++;
        }else{

            echo "No hay tarimas para ese producto";

        }
    }
    echo json_encode($arr);
}else{

    echo "No se tienen registros de TARIMAS escaneadas para este TRASPASO";

}


mysqli_close($conexion);


?>