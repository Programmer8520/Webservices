<?php
include '../../conexiones/conexion_sipisa.php';

$uuid = $_GET["uuid"];

//Primero que todo obtenermos todas las tarimas que sean del mismo traspaso

$TarimasdeTraspaso = "SELECT id, id_produccion, no_tarima FROM tb_detalle_carga_tpt WHERE uuid_cabecero_carga_tpt = '".$uuid."'";

$consultarTarimasDeTraspaso = mysqli_query($conexion, $TarimasdeTraspaso);

if (mysqli_num_rows($consultarTarimasDeTraspaso) > 0 ){
//si entra dentro de esta condicion es porque hay posibles tarimas que necesiten ser borradas del registro de TRASPASO
    $arrIDsDeProduccion = array();
    $arrNoTarima = array();
    $i = 0;
    while ($fila = mysqli_fetch_array($consultarTarimasDeTraspaso)){
        $consultarVecesQueSeRepite = "SELECT 
                                        id, clave, COUNT(*) AS cantidad
                                      FROM
                                          tb_detalle_carga_tpt
                                      WHERE
                                          id_produccion = ".$fila[1]."
                                      AND no_tarima = ".$fila[2]."
                                      AND uuid_cabecero_carga_tpt = '".$uuid."'";
        $resultado = mysqli_query($conexion, $consultarVecesQueSeRepite);

        if(mysqli_num_rows($resultado)>0){
            while($fil = mysqli_fetch_array($resultado)){
                if($fil[2] > 1){
                    //debemos eliminar eliminar el registro con el ID que obtvimos en esa consulta
                    mysqli_query($conexion, "DELETE FROM tb_detalle_carga_tpt WHERE id =".$fil[0]);
                    echo "Tarima Eliminada, con el ID:".$fil[0]." Clave de producto:".$fil[1]."\n";
                }
            }
        }
    }
}

?>