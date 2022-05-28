<?php

include '../../conexiones/conexion_sipisa.php';

$unidad = $_GET["unidad"];

$query = "SELECT placas_tractor, placas_remolque FROM tb_unidades_laroye WHERE nombre_unidad = '$unidad' AND estatus = 1";

if ($consulta = mysqli_query($conexion, $query)) {
    if (mysqli_num_rows($consulta) > 0) {
        $arr = array();
        $i = 0;
        while ($fila = mysqli_fetch_assoc($consulta)){
            $arr[$i]["tractor"] = $fila["placas_tractor"];
            $arr[$i]["remolque"] = $fila["placas_remolque"];
            
            $i++;
        }
    
        echo json_encode($arr);
    
    }else {
    
        echo "No hay datos para mostrar";
    
    }
}else {

    echo "La consulta no pudo ser ejecutada";

}

?>