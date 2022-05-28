<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumen Solicitud</title>
    <link rel="stylesheet" href="../../../estilos/documento_sap.css">
    <link rel="stylesheet" href="../../../estilos/botones_pro.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
</head>
<body>
    <div class="container">
<img class='float-right bg-transparent' src='../../../resources/logo.png' alt='logo_innovador' width='100' height='100'>
<script>
    function getParameterByName() {
        const valores = window.location.search.substr(6);
        console.log(valores)
        return valores;
    }

    function actualizarEstatus(){

        var parametros = 
        {
            "uuid" : getParameterByName()
        };

        $.ajax({
            data : parametros,
            dataType : 'TEXT',
            url : 'actualizar_estatus.php',
            type : 'POST',
            beforeSend : function() {},
            error : function() { alert("Error Para actualizar Estatus"); },
            complete : function() { /*alert("Peticion Completada");*/ },
            success : function(resultado) {

                if (resultado == "Actualizado"){

                    alert("El estatus ha sido actualizado, ya se le ha notificado a la Nave de Destino que se encamina un Traspaso");
                    //Ahora nos tiene que redireccionar con el numero de documento

                    //var direccion = "";
                    //location.href = direccion;
                }else {

                    alert(resultado);

                }

            }
        });

    }
</script>


<?php

include '../../../../conexion_sipisa.php';

$uuid = $_GET["uuid"];

$arr = array();
$i = 0;

$cadena_productos = "<table border='1'>";
$cadena_datos = "<table border='1'>";

$query="SELECT 
            dtl.nombre_producto,
            dtl.no_lote AS no_lote,
            CONCAT(dtl.no_lote, 'P') AS no_lote_sap,
            dtl.clave AS clave,
            SUM(dtl.cantidad) AS tarimas,
            (SELECT cantidad_por_paquete FROM tb_productos WHERE clave = CONVERT( dtl.clave USING UTF8)) AS piezas,
            (SELECT cantidad_por_paquete FROM tb_productos WHERE clave = CONVERT( dtl.clave USING UTF8)) * SUM(dtl.cantidad) AS cantidad
        FROM
            tb_detalle_carga_tpt AS dtl
        WHERE
            dtl.uuid_cabecero_carga_tpt = '".$uuid."'
        GROUP BY clave";

$consulta = mysqli_query($conexion, $query);

$cadena_productos.= "<thead>";
$cadena_productos.= "<tr id='datos'>";
$cadena_productos.= "<td>Clave</td>";
$cadena_productos.= "<td>Nombre de Producto</td>";
$cadena_productos.= "<td>Tarimas Escaneadas</td>";
$cadena_productos.= "<td>Piezas por Tarima</td>";
$cadena_productos.= "<td>Producto Total</td>";
$cadena_productos.= "<td>Medicion</td>";
$cadena_productos.= "</tr>";
$cadena_productos.= "</thead>";

if (mysqli_num_rows($consulta) > 0) {
    $cadena_productos.= "<tbody>";
    while ($fila = mysqli_fetch_assoc($consulta)) {

        //$arr[$i]["clave"] = $fila["clave"];
        //$arr[$i]["nombre_producto"] = $fila["nombre_producto"];
        //$arr[$i]["tarimas"] = $fila["tarimas"];
        //$arr[$i]["piezas"] = $fila["piezas"];
        //$arr[$i]["cantidad"] = $fila["cantidad"];
        //$arr[$i]["medida"] = "PZA";

        $cadena_productos.= "<tr>";
        $cadena_productos.= "<td>".$fila["clave"]."</td>";
        $cadena_productos.= "<td>".$fila["nombre_producto"]."</td>";
        $cadena_productos.= "<td>".$fila["tarimas"]."</td>";
        $cadena_productos.= "<td>".$fila["piezas"]."</td>";
        $cadena_productos.= "<td>".$fila["cantidad"]."</td>";
        $cadena_productos.= "<td>PZA</td>";
        $cadena_productos.= "</tr>";
        //$i++;
    }
    $cadena_productos.= "</tbody>";
    $cadena_productos.= "</table>";

    //echo json_encode($arr);

}else { echo "La consulta no dio datos <br>"; }

$sql = "SELECT bodega_origen_nombre, bodega_destino_nombre, numero_documento FROM tb_cabecero_carga_tpt WHERE uuid_cabecero_carga_tpt = '$uuid'";

$resultado = mysqli_query($conexion, $sql);

$cadena_datos.= "<thead>";
$cadena_datos.= "<tr id='datos'>";
$cadena_datos.= "<td>Bodega Origen</td>";
$cadena_datos.= "<td>Bodega Destino</td>";
$cadena_datos.= "<td>Numero Documento</td>";
$cadena_datos.= "</tr>";
$cadena_datos.= "</thead>";

if (mysqli_num_rows($resultado) > 0){
    $cadena_datos.= "<tbody>";
    while ($fila = mysqli_fetch_assoc($resultado)) {

        //$arr[$i]["bodega_origen"] = $fila["bodega_origen_nombre"];
        //$arr[$i]["bodega_destino"] = $fila["bodega_destino_nombre"];
        //$arr[$i]["solicitud"] = $fila["numero_documento"];
        $cadena_datos.= "<tr>";
        $cadena_datos.= "<td>".$fila["bodega_origen_nombre"]."</td>";
        $cadena_datos.= "<td>".$fila["bodega_destino_nombre"]."</td>";
        $cadena_datos.= "<td>".$fila["numero_documento"]."</td>";
        $cadena_datos.= "</tr>";
        //$i++;   
    }
    $cadena_datos.= "</tbody>";
    $cadena_datos.= "</table>";
    //echo json_encode($arr);

}else { echo "La consulta no dio datos <br>"; }

echo $cadena_datos;
echo $cadena_productos;

?>
<button class='btn fifth' onclick="actualizarEstatus();" type="button">  GUARDIA CONFIRMANDO TRASPASO </button>
</div>
</body>
</html>