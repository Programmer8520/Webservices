<?php
include '../../conexiones/conexion_sipisa.php';
$id=$_GET["id"];

$empleado= array();
$i=0;

$sql="SELECT login,pswd,name FROM sipisa.sec_users where convert(name using utf8)=(SELECT nombre FROM sipisa.tb_empleados_rh where numero_empleado=".$id.")";

$resultado = $conexion->query($sql);

while ($fila = mysqli_fetch_assoc($resultado)) {

    $empleado[$i]["usr"] =  $fila["login"];
    $empleado[$i]["pas"] =  $fila["pswd"];

    $i++;
}
echo array_to_json($empleado);
$resultado -> close();
$conexion->close();

?>