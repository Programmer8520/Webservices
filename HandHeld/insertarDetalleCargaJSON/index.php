<?php
include '../../conexiones/conexion_sipisa.php';

$values = $_GET["values"];

$query = "insert into
            sipisa.tb_detalle_carga_tpt
            (
                numero_linea,
                codigo_ean_upc,
                clave,
                cantidad,
                fecha_carga,
                id_produccion,
                no_tarima,
                fecha_produccion,
                no_lote,
                nombre_producto,
                numero_documento,
                uuid_cabecero_carga_tpt
            )
            values
            $values";

if(mysqli_query($conexion, $query)){
  //echo "OK";
}
else{
    echo "ERROR DE WEB SERVICE";
}
$conexion->close();

?>