<?php

include '../../conexiones/conexion_sipisa.php';

/**
 * Programar la obtencion de las etiquetas que tienen que estar dentro del traspaso seleccionado para poder validar las tarimas que se escanean de entrada en algunas de las naves de DESTINO
 */

$uuid = $_GET["uuid"];
$solicitud_traspaso = $_GET["solicitud"];

$parametros="SELECT 
                id_produccion, no_tarima 
              FROM 
                tb_detalle_carga_tpt 
              WHERE 
              numero_documento = ".$solicitud_traspaso." 
              AND uuid_cabecero_carga_tpt = '".$uuid."'";

$resultado = mysqli_query($conexion, $parametros);

if (mysqli_num_rows($resultado) > 0) {

    $arr = array();
    $i=0;
    while ($fila = mysqli_fetch_array($resultado)) {

        $queryDetalleProduccion = "SELECT 
            clave_etiqueta
        FROM 
            tb_detalle_producciones 
        WHERE 
            id_produccion = ".$fila[0]." AND no_tarima = ".$fila[1]."";

        $tarimas = mysqli_query($conexion, $queryDetalleProduccion);

        if (mysqli_num_rows($tarimas) > 0) {
            while ($row = mysqli_fetch_assoc($tarimas)) {
                $arr[$i]["etiqueta"] = $row["clave_etiqueta"];
            }
        }

        $i++;
    }

    echo json_encode($arr);

}


?>