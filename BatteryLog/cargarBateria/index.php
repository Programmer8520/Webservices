<?php
include '../../conexiones/conexion_sipisa.php';

$arrResultado= array();

$fecha = date("Y-m-d");  
$hora = date("H:i:s");  

$serieBateria=$_POST["serieBateria"];
$serieCargador=$_POST["serieCargador"];

//$serieBateria="PL109182514";

$sql="select Id_registro from tb_bitacora_baterias where bateria_serie='".$serieBateria."' and id_estatus=173";
$resultado = $conexion->query($sql);

if($resultado->num_rows > 0){

    $arrResultado=obetnerDatos($resultado);

    $idRegistro = $arrResultado[0]["Id_registro"];

    $sqlBitacoraBaterias="UPDATE tb_bitacora_baterias SET cargador_serie=?, fecha_carga=?, hora_carga=?, id_estatus='174' WHERE Id_registro=?";
    $sentenciaBitacoraBaterias=$conexion->prepare($sqlBitacoraBaterias);
    $sentenciaBitacoraBaterias->bind_param('ssss',$serieCargador,$fecha,$hora,$idRegistro);
    //$sentenciaBitacoraBaterias->execute();

    if($sentenciaBitacoraBaterias->execute())
    {
        //echo "SI";

    }
    else{
        echo "ERROR DE WEB SERVICE";
    }

    

    $sqlBaterias="UPDATE tb_baterias SET id_estatus='166' WHERE Serie=?";
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

    $sqlCargadores="UPDATE tb_cargadores SET id_estatus='169' WHERE Serie=?";
    $sentenciaCargadores=$conexion->prepare($sqlCargadores);
    $sentenciaCargadores->bind_param('s',$serieCargador);
    //$sentenciaCargadores->execute();

    if($sentenciaCargadores->execute())
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

        $arr[$i]["Id_registro"] =$fila["Id_registro"];
    
        $i++;
    }
    $vResultado -> close();

    return $arr;
    
}

?>