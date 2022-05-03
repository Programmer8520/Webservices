<?php
include '../../conexiones/conexion_sipisa.php';


$numeroDocumento = $_GET["solicitud"];
$uuid = $_GET["uuid"];

$query = "SELECT * FROM tb_detalle_carga_tpt WHERE numero_documento = '$numeroDocumento' AND uuid_cabecero_carga_tpt = '$uuid'  order by numero_linea desc";

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

        $arr[$i]["numero_linea"] = $fila["numero_linea"];
        $arr[$i]["clave"] = $fila["clave"];
        $arr[$i]["fecha_carga"] = $fila["fecha_carga"];
        $arr[$i]["nombre_producto"] = $fila["nombre_producto"];
        //$arr[$i]["id_etiqueta"] = $fila["id_etiqueta"];

        $arr[$i]["no_lote"] = $fila["no_lote"];
        $arr[$i]["id_produccion"] = $fila["id_produccion"];
        $arr[$i]["no_tarima"] = $fila["no_tarima"];
    
        $i++;
    }
    $vResultado -> close();

    return $arr;
    
}





?>