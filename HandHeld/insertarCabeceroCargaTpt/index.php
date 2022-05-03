<?php
include '../../conexiones/conexion_sipisa.php';


$paramUUID=$_POST["paramUUID"];
$paramBodegaOrigen=$_POST["paramBodegaOrigen"];
$paramBodegaOrigenNombre=$_POST["paramBodegaOrigenNombre"];
$paramCortina=$_POST["paramCortina"];
$paramBodegaDestino=$_POST["paramBodegaDestino"];
$paramBodegaDestinoNombre=$_POST["paramBodegaDestinoNombre"];
$paramNumeroMontacarguista=$_POST["paramNumeroMontacarguista"];
$paramNombreMontacarguista=$_POST["paramNombreMontacarguista"];
$paramNumeroAnalistaInventarios=$_POST["paramNumeroAnalistaInventarios"];
$paramNombreAnalistaInventarios=$_POST["paramNombreAnalistaInventarios"];
$paramNumeroGuardiaSeguridad=$_POST["paramNumeroGuardiaSeguridad"];
$paramNombreGuardiaSeguridad=$_POST["paramNombreGuardiaSeguridad"];
$paramClaveTransportista=$_POST["paramClaveTransportista"];
$paramNombreTransportista=$_POST["paramNombreTransportista"];
$paramConductor=$_POST["paramConductor"];
$paramPlacasTractor=$_POST["paramPlacasTractor"];
$paramPlacasRemolque=$_POST["paramPlacasRemolque"];
$paramSellos=$_POST["paramSellos"];
$paramLlegadaTransportista=$_POST["paramLlegadaTransportista"];
$paramEntradaRampa=$_POST["paramEntradaRampa"];
$paramSalidaRampa=$_POST["paramSalidaRampa"];
$paramNumeroDocumento=$_POST["paramNumeroDocumento"];
$paramCorreoUsuarioAplicacion=$_POST["paramCorreoUsuarioAplicacion"];
$paramIdStatus = $_POST["paramIdStatus"];
$paramObservaciones = $_POST["paramObservaciones"];
$paramClaveCargaOriginal = intval($_POST["paramClaveCargaOriginal"]);
$paramNaveCargaOriginal = $_POST["paramNaveCargaOriginal"];

$paramNumeroMontacarguista=verificarNumero($paramNumeroMontacarguista,$conexion);
$paramNumeroAnalistaInventarios=verificarNumero($paramNumeroAnalistaInventarios,$conexion);
$paramNumeroGuardiaSeguridad=verificarNumero($paramNumeroGuardiaSeguridad,$conexion);


$query = "insert into 
		sipisa.tb_cabecero_carga_tpt
        (
			uuid_cabecero_carga_tpt,
            bodega_origen,
            bodega_origen_nombre,
			cortina,
            bodega_destino,
            bodega_destino_nombre,
            numero_montacarguista,
            nombre_montacarguista,
            numero_analista_inventarios,
            nombre_analista_inventarios,
            numero_guardia_seguridad,
            nombre_guardia_seguridad,
            clave_transportista,
            nombre_transportista,
            conductor,
            placas_tractor,
            placas_remolque,
            sellos,
            llegada_transportista,
            entrada_rampa,
            salida_rampa,
            numero_documento,
            correo_usuario_aplicacion,
            id_estatus,
            clave_carga_original,
            nave_carga_original,
            observaciones
            )
	values
    (
			'$paramUUID',
			$paramBodegaOrigen,
			'$paramBodegaOrigenNombre',
			$paramCortina,
			$paramBodegaDestino,
			'$paramBodegaDestinoNombre',
			$paramNumeroMontacarguista,    
			'$paramNombreMontacarguista',    
			$paramNumeroAnalistaInventarios,    
			'$paramNombreAnalistaInventarios',    
			$paramNumeroGuardiaSeguridad,    
			'$paramNombreGuardiaSeguridad',    
			'$paramClaveTransportista',
			'$paramNombreTransportista',
			'$paramConductor',
			'$paramPlacasTractor',
			'$paramPlacasRemolque',
			'$paramSellos',
			'$paramLlegadaTransportista',
			'$paramEntradaRampa',
			'$paramSalidaRampa',
			'$paramNumeroDocumento',		
			'$paramCorreoUsuarioAplicacion',
            $paramIdStatus,
            $paramClaveCargaOriginal,
            '$paramNaveCargaOriginal',
            '$paramObservaciones'
    )";

if(mysqli_query($conexion, $query))
{
    
    $query = "select last_insert_id() as id";
    $consulta = $conexion->query($query);

    if($consulta->num_rows>0){

        $fila = $consulta->fetch_assoc();
        echo $fila["id"];

    }


}
else{
    //echo "ERROR DE WEB SERVICE";
}

$conexion->close();
    
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