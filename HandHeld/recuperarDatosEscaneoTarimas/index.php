<?php
include '../../conexiones/conexion_sipisa.php';

$uuid = $_GET["uuid"];

$query = "SELECT * FROM tb_detalle_carga_tpt WHERE uuid_cabecero_carga_tpt = '".$uuid."'  order by numero_linea desc";

//$query = "SELECT * FROM tb_detalle_carga_tpt WHERE numero_documento = '-'";

$consulta = $conexion->query($query);

if ($consulta->num_rows>0){

    echo json_encode(obtenerDatos($consulta));

}else{

    $ar = array();
    echo json_encode($ar);
    $conexion->close();

}


function obtenerDatos($vResultado){
    
    $arr= array();
    $i=0;

    while ($fila = mysqli_fetch_assoc($vResultado)) {
        $arr[$i]["id"] = $fila["id"];
        $arr[$i]["numero_linea"] = $fila["numero_linea"];
        $arr[$i]["codigo_barras"] = $fila["codigo_ean_upc"];
        $arr[$i]["clave"] = $fila["clave"];
        $arr[$i]["fecha_carga"] = $fila["fecha_carga"];
        $arr[$i]["id_produccion"] = $fila["id_produccion"];
        $arr[$i]["no_tarima_detalle"] = $fila["no_tarima"];
        $arr[$i]["no_lote"] = $fila["no_lote"];
        $arr[$i]["nombre_producto"] = $fila["nombre_producto"];
        //$arr[$i]["id_etiqueta"] = $fila["id_etiqueta"];

        
        
        
    
        $i++;
    }
    $vResultado -> close();

    return $arr;
    
}





?>