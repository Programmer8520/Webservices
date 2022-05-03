<?php
include '../../conexiones/conexion_sipisa.php';

$sql="call `sri-360`.prcCarrierGetAll()";
$resultadoTransportista = $conexion->query($sql);


if($resultadoTransportista->num_rows > 0){

    echo array_to_json(obetnerDatos($resultadoTransportista));
  
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

        $arr[$i]["clave"] = $fila["clave"];
        $arr[$i]["nombre"] = utf8_encode($fila["nombre"]);
        
        $i++; 
    }
    $vResultado -> close();

    return $arr;
    
}


?>