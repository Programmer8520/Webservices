<?php
include '../../conexiones/conexion_sipisa.php';
$serie=$_GET["serie"];

$sql="select distinct a.bateria_serie as serieBateria, b.Bateria as bateria, a.montacargas_serie as serieMontacargas, c.Montacargas as montacargas, a.hora_montaje as hora, a.porcentaje_ini as porcentaje, a.horometro_ini as horometro, a.id_estatus as estatus 
	from tb_bitacora_baterias as a, tb_baterias as b, tb_montacargas as c
	where a.bateria_serie='".$serie."'
	and  a.bateria_serie=b.Serie
	and  a.montacargas_serie=c.Serie
	and b.id_nave = c.id_nave
	and a.id_estatus in (172,177)";
$resultadoBateria = $conexion->query($sql);

$sql="select distinct a.bateria_serie as serieBateria, b.Bateria as bateria, a.montacargas_serie as serieMontacargas, c.Montacargas as montacargas, a.hora_montaje as hora, a.porcentaje_ini as porcentaje, a.horometro_ini as horometro, a.id_estatus as estatus 
from tb_bitacora_baterias as a, tb_baterias as b, tb_montacargas as c
where a.montacargas_serie='".$serie."'
and  a.montacargas_serie=c.Serie
and  a.bateria_serie=b.Serie
and b.id_nave = c.id_nave
and a.id_estatus in (172,177)";
$resultadoMontacargas = $conexion->query($sql);


if($resultadoBateria->num_rows > 0){

    echo array_to_json(obetnerDatos($resultadoBateria));
  
    $conexion->close();

}
elseif ($resultadoMontacargas->num_rows > 0){
    echo array_to_json(obetnerDatos($resultadoMontacargas));
  
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

        $arr[$i]["serieBateria"] = $fila["serieBateria"];
		$arr[$i]["bateria"] = $fila["bateria"];
		$arr[$i]["serieMontacargas"] = $fila["serieMontacargas"];
		$arr[$i]["montacargas"] = $fila["montacargas"];
		$arr[$i]["hora"] = $fila["hora"];
		$arr[$i]["porcentaje"] = $fila["porcentaje"];
		$arr[$i]["horometro"] = $fila["horometro"];
		$arr[$i]["estatus"] =$fila["estatus"];
    
        $i++;
    }
    $vResultado -> close();

    return $arr;
    
}


?>