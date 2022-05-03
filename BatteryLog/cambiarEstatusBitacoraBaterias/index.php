<?php
include '../../conexiones/conexion_sipisa.php';

$arrResultado= array();

$serie=$_POST["serie"];

$sql="SELECT Id_registro,id_estatus FROM tb_bitacora_baterias where (bateria_serie = '".$serie."' or montacargas_serie='".$serie."') and id_estatus in('172','177')";
$resultado = $conexion->query($sql);

if($resultado->num_rows > 0){

    $arrResultado=obetnerDatos($resultado);

    $idRegistro=$arrResultado[0]["Id_registro"];
	$idEstatus=$arrResultado[0]["id_estatus"];

    if($idEstatus=="172")
    {
        /*
          SE CALCULA HORAS TRABJADAS (FECHA Y HORA FINAL MENOS(-) FECHA Y HORA PLAY
          SE SUMAN EL HOROMETRO PLAY MAS LAS HORAS TRABAJADAS Y SE ACTUALIZA EN HOROMETRO PLAY
        

        */ 

        $sqlBitacoraBaterias="UPDATE tb_bitacora_baterias SET id_estatus='177' WHERE Id_registro=?";
        $sentenciaBitacoraBaterias=$conexion->prepare($sqlBitacoraBaterias);
        $sentenciaBitacoraBaterias->bind_param('s',$idRegistro);
        //$sentenciaBitacoraBaterias->execute();

        if($sentenciaBitacoraBaterias->execute())
        {
            //echo "SI";

        }
        else{
            echo "ERROR DE WEB SERVICE";
        }
    
    }
    else
    {
        /*AQUI SE ACTUALIZA LA FECHA Y HORA PLAY*/ 
        $sqlBitacoraBaterias="UPDATE tb_bitacora_baterias SET id_estatus='172' WHERE Id_registro=?";
        $sentenciaBitacoraBaterias=$conexion->prepare($sqlBitacoraBaterias);
        $sentenciaBitacoraBaterias->bind_param('s',$idRegistro);
        //$sentenciaBitacoraBaterias->execute();

        if($sentenciaBitacoraBaterias->execute())
        {
            //echo "SI";

        }
        else{
            echo "ERROR DE WEB SERVICE";
        }
    

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
        $arr[$i]["id_estatus"] =$fila["id_estatus"];
    
        $i++;
    }
    $vResultado -> close();

    return $arr;
    
}

?>