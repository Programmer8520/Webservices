<?php
require '../../conexiones/conexion_sipisa.php';

$op=$_GET["op"]; //opcion

$fIni=$_GET["fIni"];
$fEnd=$_GET["fEnd"];

$fIni=$fIni." 00:00:00";
$fEnd=$fEnd." 23:59:59";

switch ($op) {
    case 0:
        obetnerSeguimientoOperacion($fIni,$fEnd,$conexion);
        break;
    case 1:
        obetnerSeguimientoDestino($fIni,$fEnd,$conexion);
        break;
    case 2:
        obetnerSeguimientoProducto($fIni,$fEnd,$conexion);
        break;
    case 3:
        obetnerSeguimientoTarima($fIni,$fEnd,$conexion);
        break;
    default:
        $arr= array();
    
        echo array_to_json($arr);
        $conexion->close();
 

}


function obetnerSeguimientoOperacion($vfIni,$vfEnd,$vConexion){
    
    $sql="call `sri-360`.prcTracingTimeSpentManeuverTFP('".$vfIni."', '".$vfEnd."')";

    /*$query = "SELECT 
                numero_documento AS Documento_SAP, 
                nombre_montacarguista, 
                nombre_analista_inventarios, 
                nombre_guardia_seguridad, 
                conductor,
                placas_tractor,
                placas_remolque,
                entrada_rampa, 
                salida_rampa,
                TIMEDIFF(salida_rampa, entrada_rampa) AS tiempo_de_operacion
            FROM 
                sipisa.tb_cabecero_carga_tpt 
            WHERE 
                llegada_transportista BETWEEN '$vfIni' AND '$vfEnd'
            ORDER BY
                numero_documento DESC";*/
    
    $resultadoSeguimientoOperacion = mysqli_query($vConexion,$sql);

    if(mysqli_num_rows($resultadoSeguimientoOperacion) > 0){

        echo json_encode(obetnerDatosOperacion($resultadoSeguimientoOperacion));
      
        //$vConexion->close();
    
    }
    else{
       // echo 'vacio';
       $arr= array();
       echo json_encode($arr);
       $vConexion->close();
    }

}


function obetnerDatosOperacion($vResultado){
    
    $arr= array();
    $i=0;

    while ($fila = mysqli_fetch_assoc($vResultado)) {

        $arr[$i]["Documento_SAP"] = $fila["Documento_SAP"];
        $arr[$i]["nombre_montacarguista"] = $fila["nombre_montacarguista"];
        $arr[$i]["nombre_analista_inventarios"] = $fila["nombre_analista_inventarios"];
        $arr[$i]["nombre_guardia_seguridad"] = $fila["nombre_guardia_seguridad"];
        $arr[$i]["conductor"] = $fila["conductor"];
        $arr[$i]["placas_tractor"] = $fila["placas_tractor"];
        $arr[$i]["placas_remolque"] = $fila["placas_remolque"];
        $arr[$i]["entrada_rampa"] = $fila["entrada_rampa"];
        $arr[$i]["salida_rampa"] = $fila["salida_rampa"];
        $arr[$i]["tiempo_de_operacion"] = $fila["tiempo_de_operacion"];
      
        
        $i++;
    }

    return $arr;
    
}


function obetnerSeguimientoDestino($vfIni,$vfEnd,$vConexion){
    $sql="call `sri-360`.prcTracingTargetWarehouseTFP('".$vfIni."', '".$vfEnd."');";
    $resultadoSeguimientoDestino = $vConexion->query($sql);

    if($resultadoSeguimientoDestino->num_rows > 0){

        echo json_encode(obetnerDatosDestino($resultadoSeguimientoDestino));
      
        $vConexion->close();
    
    }
    else{
       // echo 'vacio';
       $arr= array();
       echo array_to_json($arr);
       $vConexion->close();
    }

}

function obetnerDatosDestino($vResultado){
    
    $arr= array();
    $i=0;

    while ($fila = mysqli_fetch_assoc($vResultado)) {

        $arr[$i]["cortina"] = $fila["cortina"];
        $arr[$i]["bodega_destino_nombre"] = $fila["bodega_destino_nombre"];
        $arr[$i]["Destino"] = $fila["Destino"];
        
        $i++;
    }
    $vResultado -> close();

    return $arr;
    
}

function obetnerSeguimientoProducto($vfIni,$vfEnd, $vConexion){
    $sql="call `sri-360`.prcTracingPalletProductTFP('".$vfIni."', '".$vfEnd."');";
    $resultadoSeguimientoProducto = $vConexion->query($sql);

    if($resultadoSeguimientoProducto->num_rows > 0){

        echo array_to_json(obetnerDatosProducto($resultadoSeguimientoProducto));
      
        $vConexion->close();
    
    }
    else{
       // echo 'vacio';
       $arr= array();
       echo array_to_json($arr);
       $vConexion->close();
    }

}

function obetnerDatosProducto($vResultado){
    
    $arr= array();
    $i=0;

    while ($fila = mysqli_fetch_assoc($vResultado)) {

        $arr[$i]["clave"] = $fila["clave"];
        $arr[$i]["nombre_producto"] = $fila["nombre_producto"];
        $arr[$i]["Tarimas"] = $fila["Tarimas"];
        
        $i++;
    }
    $vResultado -> close();

    return $arr;
    
}

function obetnerSeguimientoTarima($vfIni,$vfEnd,$vConexion){
    $sql="call `sri-360`.prcTracingPalletTransferTFP('".$vfIni."', '".$vfEnd."');";
    $resultadoSeguimientoTarima = $vConexion->query($sql);

    if($resultadoSeguimientoTarima->num_rows > 0){

        echo array_to_json(obetnerDatosTarima($resultadoSeguimientoTarima));
      
        $vConexion->close();
    
    }
    else{
       // echo 'vacio';
       $arr= array();
       echo array_to_json($arr);
       $vConexion->close();
    }

}

function obetnerDatosTarima($vResultado){
    
    $arr= array();
    $i=0;

    while ($fila = mysqli_fetch_assoc($vResultado)) {

        $arr[$i]["id"] = $fila["id"];
        $arr[$i]["numero_documento"] = $fila["numero_documento"];
        $arr[$i]["numero_linea"] = $fila["numero_linea"];
        $arr[$i]["codigo_ean_upc"] = $fila["codigo_ean_upc"];
        $arr[$i]["clave"] = $fila["clave"];
        $arr[$i]["cantidad"] = $fila["cantidad"];
        $arr[$i]["fecha_carga"] = $fila["fecha_carga"];
        $arr[$i]["id_produccion"] = $fila["id_produccion"];
        $arr[$i]["no_tarima"] = $fila["no_tarima"];
        $arr[$i]["fecha_produccion"] = $fila["fecha_produccion"];
        $arr[$i]["no_lote"] = $fila["no_lote"];
        $arr[$i]["nombre_producto"] = $fila["nombre_producto"];
        
        $i++;
    }
    $vResultado -> close();

    return $arr;
    
}




?>