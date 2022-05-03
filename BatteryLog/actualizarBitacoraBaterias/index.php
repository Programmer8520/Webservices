<?php
include '../../conexiones/conexion_sipisa.php';

$sql="select Id_registro, bateria_serie, cargador_serie, fecha_carga, hora_carga, fecha_reposo, hora_reposo, id_estatus
from tb_bitacora_baterias
where id_estatus in(174)";
$resultado = $conexion->query($sql);

if($resultado->num_rows > 0){

    while ($fila = mysqli_fetch_assoc($resultado)) {

        $idRegistro = $fila["Id_registro"];
		$bateriaSerie = $fila["bateria_serie"];
		$cargadorSerie = $fila["cargador_serie"];
		$fechaCarga = $fila["fecha_carga"];
		$horaCarga = $fila["hora_carga"];
    
		$today =date("Y-m-d H:i:s");

		$start = $fechaCarga." ".$horaCarga; 
		$end = date('Y-m-d H:i',strtotime('+8 hour',strtotime($start)));
        
        if ($end>$today)
		{
	   		//echo "SIGUE CARGANDO";
		}
		else
		{
            $fecha = date('Y-m-d',strtotime($end));
			$hora = date('H:i:s',strtotime($end));

            $sqlBitacoraBaterias="UPDATE tb_bitacora_baterias SET fecha_reposo=?, hora_reposo=?, id_estatus='175' WHERE Id_registro=?";
            $sentenciaBitacoraBaterias=$conexion->prepare($sqlBitacoraBaterias);
            $sentenciaBitacoraBaterias->bind_param('sss',$fecha,$hora,$idRegistro);
            //$sentenciaBitacoraBaterias->execute();

            if($sentenciaBitacoraBaterias->execute())
            {
                //echo "SI";
    
            }
            else{
                echo "ERROR DE WEB SERVICE";
            }
        

            $sqlBaterias="UPDATE tb_baterias SET id_estatus='167' WHERE Serie=?";
            $sentenciaBaterias=$conexion->prepare($sqlBaterias);
            $sentenciaBaterias->bind_param('s',$bateriaSerie);
            //$sentenciaBaterias->execute();

            if($sentenciaBaterias->execute())
            {
                //echo "SI";
    
            }
            else{
                echo "ERROR DE WEB SERVICE";
            }
        

            $sqlCargadores="UPDATE tb_cargadores SET id_estatus='168' WHERE Serie=?";
            $sentenciaCargadores=$conexion->prepare($sqlCargadores);
            $sentenciaCargadores->bind_param('s',$cargadorSerie);
            //$sentenciaCargadores->execute();


            if($sentenciaCargadores->execute())
            {
                //echo "SI";
    
            }
            else{
                echo "ERROR DE WEB SERVICE";
            }


        }


    }

}


$sql="select Id_registro, bateria_serie, cargador_serie, fecha_carga, hora_carga, fecha_reposo, hora_reposo, id_estatus
from tb_bitacora_baterias
where id_estatus in(175)";
$resultado = $conexion->query($sql);
if($resultado->num_rows > 0){


    while ($fila = mysqli_fetch_assoc($resultado)) {
        $idRegistro = $fila["Id_registro"];
        $bateriaSerie = $fila["bateria_serie"];
        
        $fechaReposo = $fila["fecha_reposo"];
        $horaReposo = $fila["hora_reposo"];
    
        $today =date("Y-m-d H:i:s");
            
        $start = $fechaReposo." ".$horaReposo; 
        $end = date('Y-m-d H:i',strtotime('+8 hour',strtotime($start)));
            if ($end>$today)
            {
                //echo "SIGUE REPOSO";
            }
            else
            {
                $sqlBitacoraBaterias="UPDATE tb_bitacora_baterias SET id_estatus='176' WHERE Id_registro=?";
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
                
    
                $sqlBaterias="UPDATE tb_baterias SET id_estatus='163' WHERE Serie=?";
                $sentenciaBaterias=$conexion->prepare($sqlBaterias);
                $sentenciaBaterias->bind_param('s',$bateriaSerie);
                //$sentenciaBaterias->execute();

                if($sentenciaBaterias->execute())
                {
                    //echo "SI";
        
                }
                else{
                    echo "ERROR DE WEB SERVICE";
                }
            }
    }

}
/*$arr= array();
$arr[0]["mensaje"]="ok";
echo array_to_json($arr);*/

$conexion->close();

?>