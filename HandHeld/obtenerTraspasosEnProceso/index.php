<?php
include '../../conexiones/conexion_sipisa.php';

//$sql="SELECT uuid_cabecero_carga_tpt, bodega_origen_nombre, bodega_destino_nombre, nombre_transportista, numero_documentofrom tb_cabecero_carga_tpt where entrada_rampa LIKE '%".$fecha."%' order by cabecero_carga_tpt_id desc";

$fecha = substr(obtenerFecha($conexion), 0, -9);

$sql="SELECT 
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
salida_rampa LIKE '%".$fecha."%' AND numero_documento <> '-' AND id_estatus in (202, 203)
ORDER BY cabecero_carga_tpt_id DESC";

$resultado = mysqli_query($conexion, $sql);

if(mysqli_num_rows($resultado)> 0){
    
    echo json_encode(obetnerDatos($resultado, $conexion));

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

        $sql="select count(*) from tb_detalle_carga_tpt where numero_documento = '". $fila["numero_documento"]. "'";
        $resultado = $conexion->query($sql);
        if($resultado = $conexion->query($sql)){
            while ($fila = $resultado->fetch_row()) {
                //echo $fila[0];
                $arr[$i]["cantidad_tarimas"] = $fila[0];
                
            }
            //$resultado -> free_result();
        }

        $i++; 
    }
    return $arr;
}

?>