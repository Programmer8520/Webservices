<?php
include '../../conexiones/conexion_sipisa.php';

$fecha = date("Y-m-d");  
$hora = date("H:i:s");  

$serieBateria=$_POST["serieBateria"];
$serieMontacargas=$_POST["serieMontacargas"];
$horometro=$_POST["horometro"];
$porcentaje=$_POST["porcentaje"];

//$serieBateria="GFU2981";
//$serieMontacargas="1A199618";
//$horometro="100";
//$porcentaje="100";

$sql="select distinct a.serie as serieBateria, b.serie as serieMontacargas
from tb_baterias as a, tb_montacargas as b
where a.serie = '".$serieBateria."'
and b.serie = '".$serieMontacargas."'
and a.id_estatus = '163'
and b.id_estatus = '170'
and a.id_nave = b.id_nave";
$resultado = $conexion->query($sql);

if($resultado->num_rows > 0){

    $sqlBitacoraBaterias="INSERT INTO tb_bitacora_baterias (bateria_serie, montacargas_serie, fecha_montaje, hora_montaje, porcentaje_ini, horometro_ini, id_estatus) VALUES (?, ?, ?, ?, ?, ?, '172')";
    $sentenciaBitacoraBaterias=$conexion->prepare($sqlBitacoraBaterias);
    $sentenciaBitacoraBaterias->bind_param('ssssss',$serieBateria,$serieMontacargas,$fecha,$hora,$porcentaje,$horometro);
    //$sentenciaBitacoraBaterias->execute();

    if($sentenciaBitacoraBaterias->execute())
    {
        //echo "SI";

    }
    else{
        echo "ERROR DE WEB SERVICE";
    }

    $sqlBaterias="UPDATE tb_baterias SET id_estatus='164' WHERE Serie=?";
    $sentenciaBaterias=$conexion->prepare($sqlBaterias);
    $sentenciaBaterias->bind_param('s',$serieBateria);
    //$sentenciaBaterias->execute();

    if($sentenciaBaterias->execute())
    {
        //echo "SI";

    }
    else{
        echo "ERROR DE WEB SERVICE";
    }

    $sqlMontacargas="UPDATE tb_montacargas SET id_estatus='171' WHERE Serie=?";
    $sentenciaMontacargas=$conexion->prepare($sqlMontacargas);
    $sentenciaMontacargas->bind_param('s',$serieMontacargas);
    //$sentenciaMontacargas->execute();

    if($sentenciaMontacargas->execute())
    {
        //echo "SI";

    }
    else{
        echo "ERROR DE WEB SERVICE";
    }

    $conexion->close();
    /*for ($arrDatos = array (); $row = $resultado->fetch_assoc(); $arrDatos[] = $row);
    echo json_encode($arrDatos);*/
    

}
else{
   // echo 'vacio';
   $conexion->close();
}




?>