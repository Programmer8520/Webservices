<?php
include '../../conexiones/conexion_sipisa.php';

$uuid = $_GET["uuid"];

$query = "SELECT 
        dtl.nombre_producto AS nombre_producto,
        dtl.no_lote AS no_lote,
        CONCAT(dtl.no_lote, 'P') AS no_lote_sap,
        dtl.clave AS clave,
        SUM(dtl.cantidad) AS tarimas,
        (SELECT 
                cantidad_por_paquete
            FROM
                tb_productos
            WHERE
                clave = CONVERT( dtl.clave USING UTF8)) AS piezas,
        (SELECT 
                cantidad_por_paquete
            FROM
                tb_productos
            WHERE
                clave = CONVERT( dtl.clave USING UTF8)) * SUM(dtl.cantidad) AS cantidad
        FROM
        tb_detalle_carga_tpt AS dtl
        WHERE
        dtl.uuid_cabecero_carga_tpt = '".$uuid."'
        GROUP BY dtl.no_lote, clave order by dtl.nombre_producto";

$consulta = mysqli_query($conexion, $query);

if  (mysqli_num_rows($consulta) > 0)
    {
        $arr = array();
        $i = 0;
        while ($fila = mysqli_fetch_assoc($consulta))
        {
            $arr[$i]["lote"] = $fila["no_lote"];
            $arr[$i]["loteSAP"] = $fila["no_lote_sap"];
            $arr[$i]["nombre_producto"] = $fila["nombre_producto"];
            $arr[$i]["clave"] = $fila["clave"];
            $arr[$i]["tarimas"] = $fila["tarimas"];
            $arr[$i]["piezas"] = $fila["piezas"];
            $arr[$i]["cantidad"] = $fila["cantidad"];
            $i++;        
        }
        echo json_encode($arr);
    }
    else
    {
        echo "no hay datos";
    }

?>