<?php

include '../../conexiones/conexion_sipisa.php';

$id = $_POST["paramID"];
$uuid = $_POST["paramUUID"];
$claveOrigen = intval($_POST["paramBodegaOrigen"]);
$nombreOrigen = $_POST["paramBodegaOrigenNombre"];
$claveDestino = intval($_POST["paramBodegaDestino"]);
$nombreDestino = $_POST["paramBodegaDestinoNombre"];
$numeroAnalista = intval($_POST["paramNumeroAnalistaInventarios"]);
$nombreAnalista = $_POST["paramNombreAnalistaInventarios"];

$query = "  UPDATE
                tb_cabecero_carga_tpt
            SET
                bodega_origen = ".$claveOrigen.",
                bodega_origen_nombre = '".$nombreOrigen."',
                bodega_destino = ".$claveDestino.",
                bodega_destino_nombre = '".$nombreDestino."',
                numero_analista_inventarios = ".$numeroAnalista.", 
                nombre_analista_inventarios = '".$nombreAnalista."'
            WHERE
                uuid_cabecero_carga_tpt = '".$uuid."'";

$update = mysqli_query($conexion, $query);

if(mysqli_affected_rows($conexion) > 0){

    //echo "Tabla Actualizada";

}else{

    echo "Error para actualizar los datos en la tabla".mysqli_error($conexion);

}
?>