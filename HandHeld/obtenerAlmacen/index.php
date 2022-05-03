<?php
include '../../conexiones/conexion_sipisa.php';

$sql="call `sri-360`.prcLocationGetAll()";

/*$query = "SELECT
            tb_almacenes_sap.id_almacen
            ,tb_almacenes_sap.clave
            ,tb_almacenes_sap.nombre
        FROM 
            sipisa.tb_almacenes_sap
        WHERE
            sipisa.tb_almacenes_sap.id_estatus =  90
        ORDER BY
            tb_almacenes_sap.nombre;";*/
$resultadoAlmacenOrigen = $conexion->query($sql);

if($resultadoAlmacenOrigen->num_rows > 0){

    echo json_encode(obetnerDatos($resultadoAlmacenOrigen));
  
    $conexion->close();

}
else
{
   // echo 'vacio';
   $arr= array();
   echo array_to_json($arr);
   $conexion->close();
}

function obetnerDatos($vResultado){
    
    $arr= array();
    $i=0;

    while ($fila = mysqli_fetch_assoc($vResultado)) {

        $arr[$i]["nombre"] = $fila["nombre"];
        $arr[$i]["clave"] = $fila["clave"];
		
    
        $i++;
    }
    $vResultado -> close();

    return $arr;
    
}


?>