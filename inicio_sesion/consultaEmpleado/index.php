<?php
include '../../conexiones/conexion_sipisa.php';
$usr=$_GET["usr"];
$pass=$_GET["pass"];

$empleado= array();
$i=0;

$sql="SELECT a.login, a.pswd, a.name, b.foto, c.descripcion, a.email
        FROM sec_users as a, tb_empleados_rh as b, tb_departamentos as c
        where a.login ='".$usr."' 
        and a.pswd ='".$pass."'
        and convert(b.nombre using utf8) = convert(a.name using utf8) 
        and c.id_departamento = b.id_departamento
        ;";

$resultado = $conexion->query($sql);

while ($fila = mysqli_fetch_assoc($resultado)) {

    $empleado[$i]["empleado"] =  $fila["name"];
    $empleado[$i]["foto"] =  $fila["foto"];
    $empleado[$i]["dep"] =  $fila["descripcion"];
    $empleado[$i]["email"] =  $fila["email"];

    $i++;
}
echo array_to_json($empleado);
$resultado -> close();
$conexion->close();



?>