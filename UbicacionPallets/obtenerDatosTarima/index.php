<?php
include '../../conexiones/conexion_sipisa.php';
//https://www.innovador.com.mx/Innovador/webservice_dev/UbicacionPallets/obtenerDatosTarima/?idEtiqueta=0003516430
 
$idEtiqueta = $_GET["idEtiqueta"];

$query = "SELECT 
            DISTINCT
                ubi.clave_almacen, 
            
                hdr.nombre_producto,
                hdr.clave
            FROM 
                sipisa.tb_ubicaciones_pallets_2021 AS ubi,
                sipisa.tb_cabecero_producciones AS hdr,
                sipisa.tb_detalle_producciones AS dtl
            WHERE 
            dtl.clave_etiqueta = '".$idEtiqueta."'
            AND dtl.id_produccion = hdr.id_produccion 
            AND (clave_producto = hdr.clave
                OR clave_producto1 = hdr.clave
                    OR clave_producto2 = hdr.clave
                        OR clave_producto3 = hdr.clave)";

$consulta = $conexion->query($query);

if ($consulta -> num_rows>0){

    echo json_encode(obtenerDatos($consulta));
    //obtenerDatos($consulta);

}else{

    $arr = array();

    echo json_encode($arr);

}


function obtenerDatos($vResultado){
    
    $arr= array();
    $i=0;

    while ($fila = mysqli_fetch_assoc($vResultado)) {

        $arr[$i]["nombre_producto"] = utf8_encode($fila["nombre_producto"]);
        $arr[$i]["clave"] = $fila["clave"];
        $arr[$i]["clave_almacen"] = $fila["clave_almacen"];

        //echo $fila["nombre_producto"]. "<br>";
        //echo $fila["clave"]. "<br>";
        //echo $fila["clave_almacen"]. "<br>";
		
    
        $i++;
    }
    $vResultado -> close();

    return $arr;
    
}

?>