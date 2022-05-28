<?php
include '../../../conexion_sipisa.php';

$nEmpleado=$_POST["nEmpleado"];


if(is_numeric($nEmpleado)){

    $nEmpleado = str_pad((int) $nEmpleado,6,"0",STR_PAD_LEFT);
}

$sql="call `sri-360`.prcEmployeeGetByNumber('".$nEmpleado."')";
$resultado_empleado = mysqli_query($conexion, $sql);


if(mysqli_num_rows($resultado_empleado)> 0){
    $arr= array();
    while ($fila = mysqli_fetch_assoc($resultado_empleado)) {

        $arr["nombre"] = utf8_encode($fila["nombre"]);
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