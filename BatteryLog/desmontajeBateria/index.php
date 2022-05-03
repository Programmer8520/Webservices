<?php
include '../../conexiones/conexion_sipisa.php';

$arrResultado= array();

$fecha = date("Y-m-d");  
$hora = date("H:i:s");  

$serie=$_POST["serie"];
$horometro=$_POST["horometro"];
$porcentaje=$_POST["porcentaje"];

//$serie="GFU2981";
//$horometro="100";
//$porcentaje="100";


$sql="select bateria_serie, montacargas_serie from tb_bitacora_baterias where (bateria_serie='".$serie."' or montacargas_serie='".$serie."') and id_estatus='172'";
$resultado = $conexion->query($sql);

if($resultado->num_rows > 0){

    $arrResultado=obetnerDatos($resultado);

    $serieBateria = $arrResultado[0]["bateria_serie"];
    $serieMontacargas=$arrResultado[0]["montacargas_serie"];

        /*
          SE CALCULA HORAS TRABJADAS (FECHA Y HORA FINAL MENOS(-) FECHA Y HORA PLAY
          SE SUMAN EL HOROMETRO PLAY MAS LAS HORAS TRABAJADAS Y SE ACTUALIZA EN HOROMETRO PLAY Y TODO LO DEMAS (HOROMETRO, FECHA, PORCENTAJE FINAL )
        
        */ 


    $sqlBitacoraBaterias="UPDATE tb_bitacora_baterias SET fecha_descarga=?, hora_descarga=?, porcentaje_fin=?, horometro_fin=?,  id_estatus='173' where bateria_serie=? and id_estatus='172'";
    $sentenciaBitacoraBaterias=$conexion->prepare($sqlBitacoraBaterias);
    $sentenciaBitacoraBaterias->bind_param('sssss',$fecha,$hora,$porcentaje,$horometro,$serieBateria);
    //$sentenciaBitacoraBaterias->execute();

    if($sentenciaBitacoraBaterias->execute())
    {
        //echo "SI";

    }
    else{
        echo "ERROR DE WEB SERVICE";
    }


    $sqlBaterias="UPDATE tb_baterias SET id_estatus='165' WHERE Serie=?";
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

    $sqlMontacargas="UPDATE tb_montacargas SET id_estatus='170' WHERE Serie=?";
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
    //echo json_encode($arrResultado);
    

}
else{
   // echo 'vacio';
   $conexion->close();
}


function obetnerDatos($vResultado){
    
    $arr= array();
    $i=0;

    while ($fila = mysqli_fetch_assoc($vResultado)) {

        $arr[$i]["bateria_serie"] =$fila["bateria_serie"];
		$arr[$i]["montacargas_serie"] = $fila["montacargas_serie"];
    
        $i++;
    }
    $vResultado -> close();

    return $arr;
    
}

?>