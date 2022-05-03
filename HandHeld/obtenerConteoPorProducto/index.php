<?php
include '../../conexiones/conexion_sipisa.php';

//$numero_documento = $_GET["docSAP"];
$uuid = $_GET["uuid"];
$cadenaDeProductos = $_GET["producto"];

$arreglo = array();
/*
$arreglo = explode("--", $cadenaDeProductos, -1);
$arr = array();

$a = array();
for($i = 0; $i < count($arreglo); $i++){

    $query = "  SELECT 
                    clave, count(*) as cantidad 
                FROM tb_detalle_carga_tpt 
                WHERE clave LIKE '%".$arreglo[$i]."%' 
                AND uuid_cabecero_carga_tpt = '".$uuid. "'";

    $consulta = $conexion->query($query);

    if($consulta->num_rows > 0){
        $a = obtenerDatos($consulta, $i);
    }
    $arr[$i] = $a;
}
echo json_encode($arr);
*/

$arreglo = explode("-", $cadenaDeProductos, -1);
$arr = array();

$a = array();
for($i = 0; $i < count($arreglo); $i++){

    $query = "  SELECT 
                    nombre_producto, count(*) as cantidad 
                FROM tb_detalle_carga_tpt 
                WHERE nombre_producto LIKE '%".$arreglo[$i]."%' 
                AND uuid_cabecero_carga_tpt = '".$uuid. "'";

    $consulta = $conexion->query($query);

    if($consulta->num_rows > 0){
        $a = obtenerDatos($consulta, $i);
    }
    $arr[$i] = $a;
}
echo json_encode($arr);



function obtenerDatos($vResultado, $posicion){
    
    $arr= array();
    $i=0;

    while ($fila = mysqli_fetch_assoc($vResultado)) {

        $arr["posicion"] = $posicion;
        $arr["nombre_producto"] = $fila["nombre_producto"];
        $arr["cantidad"] = $fila["cantidad"];
    
        $i++;
    }
    $vResultado -> close();

    return $arr;
    
}


?>