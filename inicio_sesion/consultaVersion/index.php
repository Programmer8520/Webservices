<?php
include '../../conexiones/conexion_sipisa.php';
$pry=$_GET["pry"];

$arr= array();
$i=0;

$sql="select proyecto, version, url from tb_android_update where proyecto='".$pry."'";
$resultado = $conexion->query($sql);

while ($fila = mysqli_fetch_assoc($resultado)) {

    $arr[$i]["proyecto"] = $fila["proyecto"];
	$arr[$i]["version"] = $fila["version"];
	$arr[$i]["url"] = $fila["url"];
    $i++;
}
echo array_to_json($arr);
$resultado -> close();
$conexion->close();


?>