<?php
include '../../conexiones/conexion_sipisa.php';

$nEmpleado=$_GET["nEmpleado"];

if(is_numeric($nEmpleado)){

    $nEmpleado = str_pad((int) $nEmpleado,6,"0",STR_PAD_LEFT);
}

$sql="call `sri-360`.prcEmployeeGetByNumber('".$nEmpleado."')";
$resultadoEmpleado = $conexion->query($sql);


if($resultadoEmpleado->num_rows > 0){

    echo array_to_json(obetnerDatos($resultadoEmpleado));
  
    $conexion->close();
}
else{
   // echo 'vacio';
   $arr= array();
   echo array_to_json($arr);
   $conexion->close();
}

function obetnerDatos($vResultado){
    
    $arr= array();
    $i=0;

    while ($fila = mysqli_fetch_assoc($vResultado)) {

        $arr[$i]["nombre"] = utf8_encode($fila["nombre_empleado"])." ".utf8_encode($fila["apellido_paterno"])." ".utf8_encode($fila["apellido_materno"]);

        $i++;
    }
    $vResultado -> close();

    return $arr;
    
}



?>