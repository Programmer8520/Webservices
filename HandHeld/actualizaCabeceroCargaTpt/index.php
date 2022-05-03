<?php
include '../../conexiones/conexion_sipisa.php';

$paramUUID=$_POST["paramUUID"];

$sqlInsertMasterLoadTFP="call `sri-360`.prcUpdateCarrierExitRamp(?)";
$sentenciaInsertMasterLoadTFP=$conexion->prepare($sqlInsertMasterLoadTFP);
$sentenciaInsertMasterLoadTFP->bind_param('s',$paramUUID);
if($sentenciaInsertMasterLoadTFP->execute())
{
    //echo "SI";

}
else{
    echo "ERROR DE WEB SERVICE";
}

$conexion->close();
    

?>