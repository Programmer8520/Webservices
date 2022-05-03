<?php
include '../../conexiones/conexion_sipisa.php';

//actualizarEstatusDeTraspaso
$estatus = $_GET["estatus"];
$id = $_GET["id"];

$sql = "UPDATE 
            tb_cabecero_carga_tpt
        SET
            id_estatus = $estatus
        WHERE 
            cabecero_carga_tpt_id = $id";

$update = mysqli_query($conexion, $sql);

if (mysqli_affected_rows($conexion) > 0){
    //echo "OK";
}else{
    echo "Error papi, echale mas ganas\n";
    echo mysqli_error($conexion)."[".mysqli_errno($conexion)."]";
}



?>