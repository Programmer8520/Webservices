<?php

include '../../conexiones/conexion_sipisa.php';

$fecha = substr(obtenerFecha($conexion), 0, -9);

$sql = "SELECT 
cabecero_carga_tpt_id, uuid_cabecero_carga_tpt
FROM
tb_cabecero_carga_tpt
WHERE
llegada_transportista LIKE '%".$fecha."%'
    AND numero_documento = '-'
    AND id_estatus = 201
ORDER BY cabecero_carga_tpt_id DESC";

        if ($consulta = mysqli_query($conexion, $sql)) {
            if (mysqli_num_rows($consulta) > 0) {
                $i = 0; 
                $arr = array();
                while($fila = mysqli_fetch_assoc($consulta)) {
                    $arr[$i]["id"] = $fila["cabecero_carga_tpt_id"];
                    $arr[$i]["uuid"] = $fila["uuid_cabecero_carga_tpt"];
                    $i++;
                }
            }else {
            
                echo "No hay datos en la consulta";
            
            }
        
            echo json_encode($arr);
        }else {
        
            echo "La consulta no se pudo ejecutar";
        
        }
?>