<?php
include '../../conexiones/conexion_sipisa.php';

$paramNumeroLinea=$_POST["paramNumeroLinea"];
$paramCodigoEANUPC=$_POST["paramCodigoEANUPC"];
$paramClave=$_POST["paramClave"];
$paramCantidad=$_POST["paramCantidad"];
$paramFechaCarga=$_POST["paramFechaCarga"];
$paramIdProduccion=$_POST["paramIdProduccion"];
$paramNoTarima=$_POST["paramNoTarima"];
$paramFechaProduccion=$_POST["paramFechaProduccion"];
$paramNoLote=$_POST["paramNoLote"];
$paramNombre_Producto=$_POST["paramNombre_Producto"];
$paramNumeroDocumento=$_POST["paramNumeroDocumento"];
$paramUUID=$_POST["paramUUID"];

    $query = "insert into
            sipisa.tb_detalle_carga_tpt
            (
                numero_linea,
                codigo_ean_upc,
                clave,
                cantidad,
                fecha_carga,
                id_produccion,
                no_tarima,
                fecha_produccion,
                no_lote,
                nombre_producto,
                numero_documento,
                uuid_cabecero_carga_tpt
            )
            values
            (
            $paramNumeroLinea,
            '$paramCodigoEANUPC',
            '$paramClave',
            $paramCantidad,
            '$paramFechaCarga',
            $paramIdProduccion,
            '$paramNoTarima',
            '$paramFechaProduccion',
            '$paramNoLote',
            '$paramNombre_Producto',
            '$paramNumeroDocumento',
            '$paramUUID'
             )";

    if(mysqli_query($conexion, $query)){
        //echo "OK";
    }
    else{
        echo "ERROR DE WEB SERVICE";
    }

    $conexion->close();  

?>