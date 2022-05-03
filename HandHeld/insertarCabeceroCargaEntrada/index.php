<?php

include '../../conexiones/conexion_sipisa.php';

$uuid = $_POST["paramUUID"];
$numero_montacarguista = $_POST["paramNumeroMontacarguista"];
$nombre_montacarguista = $_POST["paramNombreMontacarguista"];
$numero_analista = $_POST["paramNumeroAnalistaInventarios"];
$nombre_analista = $_POST["paramNombreAnalistaInventarios"];
$numero_guardia = $_POST["paramNumeroGuardiaSeguridad"];
$nombre_guardia = $_POST["paramNombreGuardiaSeguridad"];
$llegada_transportista = $_POST["paramLlegadaTransportistaDestino"];
$entrada_rampa = obtenerFecha($conexion);
$salida_rampa =  obtenerFecha($conexion);
$numero_documento = $_POST["paramNumeroDocumento"];
$correo = $_POST["paramCorreoUsuarioAplicacion"];

$numero_montacarguista=verificarNumero($numero_montacarguista, $conexion);
$numero_analista=verificarNumero($numero_analista, $conexion);
$numero_guardia=verificarNumero($numero_guardia, $conexion);

$query = "  UPDATE
                tb_cabecero_carga_tpt
            SET
                
                numero_montacarguista_entrada = ".$numero_montacarguista.", 
                nombre_montacarguista_entrada = '".$nombre_montacarguista."', 
                numero_analista_inventarios_entrada = ".$numero_analista.", 
                nombre_analista_inventarios_entrada = '".$nombre_analista."', 
                numero_guardia_seguridad_entrada = ".$numero_guardia.", 
                nombre_guardia_seguridad_entrada = '".$nombre_guardia."', 
                llegada_transportista_destino = '".$llegada_transportista."', 
                entrada_rampa_destino = '".$entrada_rampa."', 
                salida_rampa_destino = '".$salida_rampa."', 
                numero_documento_entrada = '".$numero_documento."', 
                correo_usuario_aplicacion_entrada = '".$correo."',
                id_estatus = 210
            WHERE
                uuid_cabecero_carga_tpt = '".$uuid."'";

$conexion->query($query);

if($conexion->affected_rows==1){

    //echo "Tabla Actualizada";

}else{

    echo "Error para actualizar los datos en la tabla";

}

function verificarNumero($vNumero, $vConexion){

    if(is_numeric($vNumero)){

        $vNumero= str_pad((int) $vNumero,6,"0",STR_PAD_LEFT);
        return $vNumero;
    }
    else{
        
        $sql="select numero_empleado from tb_empleados_rh where codigo_barras='".$vNumero."'";
        $resultadoEmpleado = $vConexion->query($sql);

        if($resultadoEmpleado->num_rows > 0){

            while ($fila = mysqli_fetch_assoc($resultadoEmpleado)) {

                $vNumero= $fila["numero_empleado"];
             
            }
            $resultadoEmpleado -> close();
            return $vNumero;
        }
    }

    return 0;
}


?>