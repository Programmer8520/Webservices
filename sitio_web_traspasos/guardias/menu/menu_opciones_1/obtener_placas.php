<?php
include '../../../conexion_sipisa.php';

$id_operador=$_POST["id_operador"];


if(is_numeric($nEmpleado)){

    $nEmpleado = str_pad((int) $nEmpleado,6,"0",STR_PAD_LEFT);
}

$sql="SELECT 
        tb_nombres_operadores_laroye.placas_remolque,
        tb_nombres_operadores_laroye.placas_tractor
    FROM
        sipisa.tb_nombres_operadores_laroye
    WHERE 
        tb_nombres_operadores_laroye.id_operador = $id_operador";
$resultado_empleado = mysqli_query($conexion, $sql);


if(mysqli_num_rows($resultado_empleado)> 0){
    $arr= array();
    while ($fila = mysqli_fetch_assoc($resultado_empleado)) {

        $arr["placas_remolque"] = utf8_encode($fila["placas_remolque"]);
        $arr["placas_tractor"] = utf8_encode($fila["placas_tractor"]);
    }
    
    $arr = json_encode($arr);
    echo $arr;
}else{
   // echo 'vacio';
   $arr= array();
   echo array_to_json($arr);
   $conexion->close();
}


?>