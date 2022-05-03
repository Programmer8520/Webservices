<?php

include '../../conexiones/conexion_sipisa.php';

$id=$_GET["id"]; //este id es el de la etiqueta

$id= str_pad((int) $id,10,"0",STR_PAD_LEFT);

//$sql="call `sri-360`.prcGetProductByProductionOrderIdJAVO('".$id."');";
$query = "  SELECT 
            hdr.*,
            dtl.no_tarima,
            dtl.clave_etiqueta,
            dtl.fecha_etiquetado,
            dtl.hora_etiquetado
            FROM
            sipisa.tb_cabecero_producciones AS hdr
                LEFT JOIN
            sipisa.tb_detalle_producciones AS dtl ON dtl.id_produccion = hdr.id_produccion
            WHERE
            dtl.clave_etiqueta = '".$id."'
                AND fecha_produccion > '2021-01-01'";

$resultadoProducto = $conexion->query($query);

if($resultadoProducto->num_rows > 0){

    echo json_encode(obetnerDatos($resultadoProducto));
  
    $conexion->close();

}
else{
   // echo 'vacio';
   $arr= array();
   echo json_encode($arr);
   $conexion->close();
}

function obetnerDatos($vResultado){
    
    $arr= array();
    $i=0;

    while ($fila = mysqli_fetch_assoc($vResultado)) {

        $arr[$i]["fecha_produccion"] = $fila["fecha_produccion"];
        //$arr[$i]["fecha_etiquetado"] = $fila["fecha_etiquetado"];
        //$arr[$i]["hora_etiquetado"] = $fila["hora_etiquetado"];

        $arr[$i]["codigo_barras"] = $fila["codigo_barras"];
        $arr[$i]["clave"] = $fila["clave"];
        $arr[$i]["nombre_producto"] = utf8_encode($fila["nombre_producto"]);
        
        $arr[$i]["clave_etiqueta"] = $fila["clave_etiqueta"];
        $arr[$i]["no_lote"] = $fila["no_lote"];
        
        //$arr[$i]["no_tarimas"] = $fila["no_tarimas"];
        $arr[$i]["no_tarima_detalle"] = $fila["no_tarima"];
    
        $i++;
    }
    $vResultado -> close();

    return $arr;
    
}


?>