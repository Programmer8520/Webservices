<?php
include '../../conexiones/conexion_sipisa.php';
$serie=$_GET["serie"];

$sql="select Serie,Bateria as Equipo , id_estatus from tb_baterias where Serie='".$serie."'";
$resultadoBateria = $conexion->query($sql);

$sql="select Serie,Montacargas as Equipo, id_estatus from tb_montacargas where Serie='".$serie."'";
$resultadoMontacargas = $conexion->query($sql);

$sql="select Serie,Cargador as Equipo,id_estatus from tb_cargadores where Serie='".$serie."'";
$resultadoCargador= $conexion->query($sql);


if($resultadoBateria->num_rows > 0){

    echo array_to_json(obetnerDatos($resultadoBateria));
  
    $conexion->close();

}
elseif ($resultadoMontacargas->num_rows > 0){
    echo array_to_json(obetnerDatos($resultadoMontacargas));
  
    $conexion->close();

}
elseif ($resultadoCargador->num_rows > 0)
{
    echo array_to_json(obetnerDatos($resultadoCargador));
   
    $conexion->close();

}
else{
   // echo 'vacio';
   $arr= array();
   echo array_to_json($arr);
   $conexion->close();
}




function obetnerDatos($vResultado){
    
    $arr= array();
    $i=0;

    while ($fila = mysqli_fetch_assoc($vResultado)) {

        $arr[$i]["serie"] = $fila["Serie"];
        $arr[$i]["equipo"] = $fila["Equipo"];
        $arr[$i]["estatus"] = $fila["id_estatus"];
    
        $i++;
    }
    $vResultado -> close();

    return $arr;
    
}


?>