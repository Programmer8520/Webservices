<?php
include '../../conexiones/conexion_sipisa.php';

//http://pimex/webservice_dev/UbicacionPallets/comprobarClaveProducto/?paramClaveProducto=109003-001001&paramClaveRack=G&paramClaveAlmacen=1

$clave_producto = $_GET["paramClaveProducto"];
$almacen = $_GET["paramClaveAlmacen"];
$rack = $_GET["paramClaveRack"];


$query = "  SELECT DISTINCT
                clave_almacen, clave_rack, clave_producto, clave_producto1, clave_producto2, clave_producto3 
            FROM
                tb_ubicaciones_pallets_2021
            WHERE
                clave_almacen = ".$almacen." AND clave_rack = '".$rack."' AND
                (clave_producto = '".$clave_producto."'
                    OR clave_producto1 = '".$clave_producto."'
                        OR clave_producto2 = '".$clave_producto."'
                            OR clave_producto3 = '".$clave_producto."')";

$consulta = $conexion->query($query);

if ($consulta->num_rows>0){

    //echo "Posicion correcta";

}else{

    echo "Ese rack no corresponde";;

}

$conexion->close();

?>