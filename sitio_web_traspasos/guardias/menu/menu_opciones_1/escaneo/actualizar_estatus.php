<?php
include '../../../conexion_sipisa.php';

//actualizarEstatusDeTraspaso
$uuid = $_POST["uuid"];

$sql = "UPDATE 
            tb_cabecero_carga_tpt
        SET
            id_estatus = 203
        WHERE 
            uuid_cabecero_carga_tpt = '$uuid'";

$update = mysqli_query($conexion, $sql);

if (mysqli_affected_rows($conexion) > 0){
    echo "Actualizado";
}else{
    echo "Error, El estatus ya ha sido actualizado\n";
    //echo mysqli_error($conexion)."[".mysqli_errno($conexion)."]";
}



?>