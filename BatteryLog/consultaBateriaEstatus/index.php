<?php
include '../../conexiones/conexion_sipisa.php';
$est=$_GET["est"];

$sql="SELECT distinct a.bateria as bateria, c.marca as marca, a.serie as serie, b.descripcion as estatus
FROM tb_baterias as a, tb_estatus as b, tb_marca_bitacora_baterias as c
where a.id_estatus = b.id_estatus
and a.id_estatus='".$est."'
and c.Id_marca = a.id_marca
order by Bateria asc";
$bateriaEstatus = $conexion->query($sql);



if($bateriaEstatus->num_rows > 0){

    echo array_to_json(obetnerDatos($bateriaEstatus));
  
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

        $arr[$i]["bateria"] =$fila["bateria"];
		$arr[$i]["marca"] = $fila["marca"];
		$arr[$i]["serie"] = $fila["serie"];
		$arr[$i]["estatus"] = $fila["estatus"];
    
        $i++;
    }
    $vResultado -> close();

    return $arr;
    
}


?>