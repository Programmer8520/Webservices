<?php
include '../../conexiones/conexion_sipisa.php';

$id = $_GET["id"];
$uuid = $_GET["uuid"];

$id = str_pad((int) $id,10,"0",STR_PAD_LEFT);

//smysqli_begin_transaction($conexion, MYSQLI_TRANS_START_READ_WRITE);

$query = "SELECT 
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

$obtenerProducto = mysqli_query($conexion, $query);
if($obtenerProducto)
{

    if (mysqli_num_rows($obtenerProducto) > 0)
    {
        $arr = array();
        $i = 0;
        while($row = mysqli_fetch_assoc($obtenerProducto))
        {

            //DATOS QUE MANDAREMOS PARA EL USO DE LA APLICACION
            $arr[$i]["clave_etiqueta"] = $row["clave_etiqueta"];
            $arr[$i]["nombre_producto"] = utf8_encode($row["nombre_producto"]);
            $arr[$i]["fecha_produccion"] = $row["fecha_produccion"];
            $arr[$i]["codigo_barras"] = $row["codigo_barras"];
            $arr[$i]["clave"] = $row["clave"];
            $arr[$i]["no_lote"] = $row["no_lote"];
            $arr[$i]["no_tarima_detalle"] = $row["no_tarima"];

            //Datos que usaremos para insertar en el detalle de CARGA TPT
            $etiqueta = $row["clave_etiqueta"];
            $id_produccion = substr($etiqueta, 3, 5);
            $fecha_carga = obtenerFecha($conexion);
            $nombre_producto = utf8_encode($row["nombre_producto"]);
            $fecha_produccion = $row["fecha_produccion"];
            $codigo_barras = $row["codigo_barras"];
            $clave = $row["clave"];
            $lote = $row["no_lote"];
            $no_tarima = $row["no_tarima"];

            $query2 = "INSERT INTO
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
                            0,
                            '$codigo_barras',
                            '$clave',
                            1,
                            '$fecha_carga',
                            $id_produccion,
                            '$no_tarima',
                            '$fecha_produccion',
                            '$lote',
                            '$nombre_producto',
                            '-1',
                            '$uuid'
                        )";
            
            if(mysqli_query($conexion, $query2))
            {
                //mysqli_commit($conexion);
                $query3 = "select last_insert_id() as id";
                $obtenerIdInsertado = mysqli_query($conexion, $query3);

                if(mysqli_num_rows($obtenerIdInsertado)>0)
                {
                    $fila = mysqli_fetch_assoc($obtenerIdInsertado);

                    $arr[$i]["id_insertado"] = $fila["id"];
                }
            }
            else
            {
                //mysqli_rollback($conexion);
                echo "No se Inserto la Tarima en Detalle<br>";
            }

            $i++;
        }

        echo json_encode($arr);
    }
    else
    {
        echo "No hay registros en la consulta ejecutada<br>";
    }

}
else
{
    echo "La consulta no se ejecuto<br>";
}


?>