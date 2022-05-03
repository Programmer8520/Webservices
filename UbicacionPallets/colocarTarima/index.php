<?php
include '../../conexiones/conexion_sipisa.php';

//https://www.innovador.com.mx/Innovador/webservice_dev/UbicacionPallets/colocarTarima/?paramClaveAlmacen=1&paramClaveRack=A&paramPosicion=1&paramNivel=1&paramLogin=yisus&paramClaveEtiqueta=0003516430

$clave_almacen = $_POST["paramClaveAlmacen"];
$clave_rack = $_POST["paramClaveRack"];
$posicion  = $_POST["paramPosicion"];
$nivel = $_POST["paramNivel"];
$clave_producto = $_POST["paramClaveProducto"];
$login  = $_POST["paramLogin"];
$etiqueta = $_POST["paramClaveEtiqueta"];

/*
$query  = "SELECT * FROM tb_ubicaciones_pallets_2021 WHERE clave_etiqueta = '".$etiqueta."'";
$consulta =  $conexion->query($query);

if ($consulta->num_rows!=0){

    echo "La tarima ya se encuentra en otra posicion";

}else {
    
    $query = "  UPDATE 
                    tb_ubicaciones_pallets_2021 
                SET 
                    clave_etiqueta = '".$etiqueta."',
                    id_estatus = 93, 
                    login = '".$login."' 
                WHERE  
                    clave_rack = '".$clave_rack."' 
                AND posicion = ".$posicion. " 
                AND nivel = ". $nivel. "
                AND clave_almacen='".$clave_almacen."'";

    $conexion->query($query);
    
    if($conexion->affected_rows==1){
        //echo "Tarima colocada";
    
    }else {

        echo "No se coloco la tarima intentelo de nuevo";
    }

}*/


$query = "  UPDATE 
                    tb_ubicaciones_pallets_2021 
                SET 
                    clave_etiqueta = '".$etiqueta."',
                    id_estatus = 93, 
                    login = '".$login."' 
                WHERE  
                    clave_rack = '".$clave_rack."' 
                AND posicion = ".$posicion. " 
                AND nivel = ". $nivel. "
                AND clave_almacen='".$clave_almacen."'";

    
    //$conexion->affected_rows==1
    if($conexion->query($query)){
        //echo "Tarima colocada";
    
    }else {

        echo "No se coloco la tarima intentelo de nuevo";
    }

$conexion->close();
?>