<?php
include '../../conexiones/conexion_sipisa.php';
$usr=$_GET["usr"];
$modulo=$_GET["mod"];
$prj=$_GET["prj"];

$empleado= array();
$i=0;

$sql="SELECT project, module, active_directory_user_account FROM `sri-360`.tbl_application_module_user_permit where status=1 and module='".$modulo."' and active_directory_user_account='".$usr."' and project='".$prj."'";

$resultado = $conexion->query($sql);

while ($fila = mysqli_fetch_assoc($resultado)) {

    $empleado[$i]["pry"] =  $fila["project"];
    $empleado[$i]["mod"] =  $fila["module"];
    $empleado[$i]["usr"] =  $fila["active_directory_user_account"];

    $i++;
}
echo array_to_json($empleado);
$resultado -> close();
$conexion->close();


?>