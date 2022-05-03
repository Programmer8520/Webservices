<?php
include '../../conexiones/conexion_sipisa.php';

//en esta parte del web service es donde programamos la actiualizacion de la fecha de salida y por tanto aqui mismo se actualizara el ID de estatus

$paramUUID=$_POST["paramUUID"];
$paramSalidaRampa=$_POST["paramSalidaRampa"];

$sqlInsertMasterLoadTFP="UPDATE tb_cabecero_carga_tpt SET id_estatus = 2, salida_rampa = '".$paramSalidaRampa."' WHERE uuid_cabecero_carga_tpt = '".$paramUUID."'";

if ($conexion->query($sqlInsertMasterLoadTFP) === TRUE) {   
    
}
else{
    echo "ERROR DE WEB SERVICE";
}

$conexion->close();

?>