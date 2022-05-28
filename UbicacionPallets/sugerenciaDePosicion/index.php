<?php

include '../../conexiones/conexion_sipisa.php';

$clave_producto = $_GET["clave_producto"];

$query = "SELECT 
            clave_rack, posicion, nivel
            FROM
            tb_ubicaciones_pallets_2021
            WHERE
            (clave_producto = '$clave_producto'
                OR clave_producto1 = '$clave_producto'
                OR clave_producto2 = '$clave_producto'
                OR clave_producto3 = '$clave_producto')
            AND id_estatus = 192
            limit 1";

if ($resultado = mysqli_query($conexion, $query)) {
    if (mysqli_num_rows($resultado) > 0) {
        $arr = array();
        $i = 0;
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $arr[$i]["clave_rack"] = $fila["clave_rack"];
            $arr[$i]["posicion"] = $fila["posicion"];
            $arr[$i]["nivel"] = $fila["nivel"];
            $i++;
        }

        echo  json_encode($arr);
    }else {

        echo "LA CONSULTA NO TIENE DATOS";

    }

}else {

    echo "LA CONSULTA NO FUE EJECUTADA";

}


?>