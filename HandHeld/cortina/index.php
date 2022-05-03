<?php
include '../../conexiones/conexion_sipisa.php';

$ubicacion=$_GET["ubicacion"];
$estatus=46;
$sql="call `sri-360`.prcLocationGetCurtainByLocation(".$ubicacion.", ".$estatus.")";
$resultadoCortina = $conexion->query($sql);


if($resultadoCortina->num_rows > 0){

    echo json_encode(obetnerDatos($resultadoCortina));
  
    $conexion->close();

}
elseif($resultadoCortina->num_rows == 0){

    $arr= array();
    $arr[0]["numero_cortina"] ="SELECCIONAR";
    echo json_encode( $arr);
  
    $conexion->close();

}
else{
   // echo 'vacio';
   $arr= array();
   echo json_encode($arr);
   $conexion->close();
}




function obetnerDatos($vResultado){
    
    $arr= array();
    $arr[0]["numero_cortina"] ="SELECCIONAR";
    $i=1;

    while ($fila = mysqli_fetch_assoc($vResultado)) {

        $arr[$i]["numero_cortina"] = $fila["numero_cortina"];
		
    
        $i++;
    }
    $vResultado -> close();

    return $arr;
    
}


?>