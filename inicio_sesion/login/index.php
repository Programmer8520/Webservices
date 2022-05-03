<?php

if(isset($_POST["usr"]))
{
    include '../../conexiones/conexion_sipisa.php';
    //$empleado= array();
    
    $usr=$_POST["usr"];
    $pass=$_POST["pass"];
    
    //$usr="lfaustinos";
    //$pass="Lf9ust1n0s";

    //$usr="jvilchis";
    //$pass="jv1lch1s852";
    
    
    $sql="CALL prc_app_obtener_empleado(?,?)";
    
    
    $sentencia=$conexion->prepare($sql);
    $sentencia->bind_param('ss',$usr,$pass);
    $sentencia->execute();
    
    $resultado = get_results($sentencia);
    
    if ($resultado) {
    
        echo json_encode($resultado); 
    }
    
    
    $sentencia->close();
    $conexion->close();

}

?>