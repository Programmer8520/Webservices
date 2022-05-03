<?php
include '../../conexiones/conexion_sipisa.php';

//el objetivo de este web service es dar una respuesta firme y confiable de que los traspasos que se van a seleccionar pueden ser cerrados ya que ya se cuenta con stock suficiente para hacer el cierre.

$fecha = substr(obtenerFecha($conexion), 0, -9);

$query = "SELECT 
            cabecero_carga_tpt_id,
            uuid_cabecero_carga_tpt,
            bodega_origen_nombre,
            bodega_destino_nombre,
            nombre_transportista,
            numero_documento,
            conductor,
            nombre_transportista,
            salida_rampa,
            nombre_guardia_seguridad,
            nombre_analista_inventarios,
            nombre_montacarguista,
            observaciones
        FROM
            tb_cabecero_carga_tpt
        WHERE
            numero_documento <> '-' AND id_estatus = 212
            ORDER BY cabecero_carga_tpt_id DESC";

$consulta = mysqli_query($conexion, $query);

if(mysqli_num_rows($consulta) > 0){
    
    echo json_encode(obetnerDatos($consulta, $conexion));

    $conexion->close();

}
else{
    echo 'vacio';
    $arr= array();
    echo array_to_json($arr);
    $conexion->close();
}

function obetnerDatos($vResultado, $conexion){

    $arr= array();
    $i=0;

    while ($fila = mysqli_fetch_assoc($vResultado)) {

        $arr[$i]["idregistrado"] = $fila["cabecero_carga_tpt_id"];
        $arr[$i]["uuid"] = $fila["uuid_cabecero_carga_tpt"];
        $arr[$i]["bodega_origen_nombre"] = $fila["bodega_origen_nombre"];
        $arr[$i]["bodega_destino_nombre"] = $fila["bodega_destino_nombre"];
        $arr[$i]["nombre_transportista"] = utf8_encode($fila["nombre_transportista"]);
        $arr[$i]["numero_documento"] = $fila["numero_documento"];
        $arr[$i]["conductor"] = utf8_encode($fila["conductor"]);
        $arr[$i]["salida_rampa"] = $fila["salida_rampa"];
        $arr[$i]["nombre_guardia"] = $fila["nombre_guardia_seguridad"];
        $arr[$i]["nombre_analista"] = $fila["nombre_analista_inventarios"];
        $arr[$i]["nombre_montacarguista"] = $fila["nombre_montacarguista"];
        $arr[$i]["observaciones"] = $fila["observaciones"];
        $i++; 
    }
    return $arr;
}

?>