<?php

include '../../conexiones/conexion_sipisa.php';

$idEtiqueta = $_GET["id"];

$sql = "UPDATE 
			tb_detalle_carga_tpt 
		SET 
			uuid_cabecero_carga_tpt='ELIMINADA' 
		WHERE 
			id=".$idEtiqueta." 
		AND numero_documento = '-1'";

if(mysqli_query($conexion, $sql))
{
	//echo "OK";
}
else{
	echo "error";
}
$conexion->close();


?>