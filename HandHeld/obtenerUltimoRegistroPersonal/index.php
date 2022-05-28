<?php
include '../../conexiones/conexion_sipisa.php';

$query = "SELECT 
            numero_analista_inventarios,
            numero_guardia_seguridad,
            numero_montacarguista
          FROM
            tb_cabecero_carga_tpt
          ORDER BY cabecero_carga_tpt_id DESC
          LIMIT 1";

$consulta = mysqli_query($conexion, $query);
if(mysqli_num_rows($consulta) > 0){
    $arr = array();
    $i = 0;
    while ($fila = mysqli_fetch_assoc($consulta)){
        $arr[$i]["analista"] = $fila["numero_analista_inventarios"];
        $arr[$i]["guardia"] = $fila["numero_guardia_seguridad"];
        $arr[$i]["montacarguista"] = $fila["numero_montacarguista"];
        
    }
    echo json_encode($arr);
}else{
    echo "no contiene datos<br>";
}



?>