<?php
include '../../conexiones/conexion_sipisa.php';

//http://pimex/webservice_dev/UbicacionPallets/comprobarClaveProducto/?paramClaveProducto=109003-001001&paramClaveRack=G&paramClaveAlmacen=1

$clave_producto = $_GET["paramClaveProducto"];
$almacen = $_GET["paramClaveAlmacen"];
$posicion = $_GET["posicion"];
$arr = explode("-", $posicion);

$query = "  SELECT DISTINCT
                clave_almacen, clave_rack, clave_producto, clave_producto1, clave_producto2, clave_producto3 
            FROM
                tb_ubicaciones_pallets_2021
            WHERE
                clave_almacen = '".$almacen."' AND clave_rack = '".$arr[0]."' AND
                (clave_producto = '".$clave_producto."'
                    OR clave_producto1 = '".$clave_producto."'
                        OR clave_producto2 = '".$clave_producto."'
                            OR clave_producto3 = '".$clave_producto."')";

$consulta = mysqli_query($conexion, $query);

if (mysqli_num_rows($consulta)>0){

    //echo "Posicion correcta";

}else{

    echo "Ese rack no corresponde";

}

$conexion->close();

?>