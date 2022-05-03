<?php
include '../../conexiones/conexion_sipisa.php';

//http://www.innovador.com.mx/webservice_dev/UbicacionPallets/update/?etiqueta=0003516430&login=javier&mod=0
$mod = intval($_POST["mod"]);
$etiqueta = $_POST["paramClaveEtiqueta"];
$login  = $_POST["paramLogin"];

$clave_producto = $_POST["paramClaveProducto"];
$clave_almacen = $_POST["paramClaveAlmacen"];
$clave_rack = $_POST["paramClaveRack"];
$posicion  = intval($_POST["paramPosicion"]);
$nivel = intval($_POST["paramNivel"]);

$query = "";
$msg = "";
$datosUbicacionesPallets = array();

switch ($mod) {
    case 0:
        $datosUbicacionesPallets = verificarTarimaEnUbicaciones($etiqueta, $conexion);

        if(count($datosUbicacionesPallets) > 0){
            
            //echo "La tarima ya se encuentra, exactamente con el ID[$id]<br>";
            retirarTarima($etiqueta, "manager", $conexion);
            colocarTarima($etiqueta, $clave_almacen, $clave_rack, $posicion, $nivel, $login, 191, $conexion);
            mysqli_close($conexion);

        }else{

            colocarTarima($etiqueta, $clave_almacen, $clave_rack, $posicion, $nivel, $login, 191, $conexion);
            mysqli_close($conexion);

            $msg = "Tarima colocada correctamente";

        }
    break;
    case 1:
        $datosUbicacionesPallets = verificarTarimaEnUbicaciones($etiqueta, $conexion);

        if(count($datosUbicacionesPallets)>0){
            $id = $datosUbicacionesPallets[0]["id"];
            //echo "La tarima ya se encuentra, exactamente con el ID[$id]<br>";
            retirarTarima($etiqueta, $login, $conexion);
            mysqli_close($conexion);

        }else{

            colocarTarima($etiqueta, $clave_almacen, $clave_rack, $posicion, $nivel, "manager", 191, $conexion); 
            retirarTarima($etiqueta, $login, $conexion);

            mysqli_close($conexion);

        }
    break;
    case 2:
        $datosUbicacionesPallets = verificarTarimaEnUbicaciones($etiqueta, $conexion);

        if(count($datosUbicacionesPallets)>0){
            $id = $datosUbicacionesPallets[0]["id"];
            //echo "La tarima ya se encuentra, exactamente con el ID[$id]<br>";
            surtirTarima($etiqueta, $login, $conexion);
            mysqli_close($conexion);

        }else{

            colocarTarima($etiqueta, $clave_almacen, $clave_rack, $posicion, $nivel, "manager", 191, $conexion);
            surtirTarima($etiqueta, $login, $conexion);
            mysqli_close($conexion);

        }
    break;
    case 3:
        $datosUbicacionesPallets = verificarTarimaEnUbicaciones($etiqueta, $conexion);

        if(count($datosUbicacionesPallets)>0){
            $id = $datosUbicacionesPallets[0]["id"];
            //echo "La tarima ya se encuentra, exactamente con el ID[$id]<br>";
            reacondicionarTarima($etiqueta, $login, $conexion);
            mysqli_close($conexion);

        }else{

            colocarTarima($etiqueta, $clave_almacen, $clave_rack, $posicion, $nivel, "manager", 191, $conexion);
            reacondicionarTarima($etiqueta, $login, $conexion);
            mysqli_close($conexion);

        }
    break;
    default:
        $msg =  "Error";
        echo $msg;
    break;
}

function obtenerDatos($vResultado){
    
    $arr= array();
    $i=0;

    while ($fila = mysqli_fetch_assoc($vResultado)) {

        $arr[$i]["id"] = $fila["id"];
        $arr[$i]["clave_almacen"] = $fila["clave_almacen"];
        $arr[$i]["clave_rack"] = $fila["clave_rack"];
        $arr[$i]["posicion"] = $fila["posicion"];
        $arr[$i]["nivel"] = $fila["nivel"];
        $arr[$i]["clave_etiqueta"] = $fila["clave_etiqueta"];
        $arr[$i]["id_estatus"] = $fila["id_estatus"];
        $arr[$i]["clave_producto"] = $fila["clave_producto"];
        $arr[$i]["clave_producto1"] = $fila["clave_producto1"];
        $arr[$i]["clave_producto2"] = $fila["clave_producto2"];
        $arr[$i]["clave_producto3"] = $fila["clave_producto3"];

        $i++;
    }
    //$vResultado -> close();

    return $arr;
    
}

function verificarTarimaEnUbicaciones($idEtiqueta, $conexion){

    $query = "SELECT id, clave_almacen, clave_rack, posicion, nivel, clave_etiqueta, id_estatus, clave_producto, clave_producto1, clave_producto2, clave_producto3 FROM tb_ubicaciones_pallets_2021 WHERE clave_etiqueta = '".$idEtiqueta."'";

    $consulta  = mysqli_query($conexion, $query);

    if(mysqli_num_rows($consulta) > 0){
        //echo "regresando datos<br>";
        
        return obtenerDatos($consulta);

    }else{
        //echo "regresando datos vacios<br>";
        $arr = array();

        return $arr;

    }

}

function mExisteTarimaEnPosicion($claveAl, $claveRa, $posicion, $nivel, $conexion){

    $query = "SELECT clave_etiqueta FROM tb_ubicaciones_pallest_2021 
                WHERE clave_almacen = '$claveAl'
                AND clave_rack = '$claveRa'
                AND posicion = $posicion
                AND nivel = $nivel";
    $consulta = mysqli_query($conexion, $query);

    $etiqueta = "";

    if(mysqli_num_rows($consulta) > 0){
        while($fila = mysqli_fetch_array($consulta)){
            $etiqueta = $fila[0];
        }
    }

    return $etiqueta;
    
}

function colocarTarima($idEtiqueta, $almacen, $rack, $posicion, $nivel, $login, $estatus, $conexion){
    if($e = mExisteTarimaEnPosicion($almacen, $rack, $posicion, $nivel, $conexion) != ""){
        retirarTarima($e, "manager", $conexion);
    }
    
    $query = " UPDATE 
                    tb_ubicaciones_pallets_2021 
                SET 
                    clave_etiqueta = '".$idEtiqueta."',
                    id_estatus = $estatus, 
                    login = '".$login."' 
                WHERE  
                    clave_rack = '".$rack."' 
                    AND posicion='".$posicion."'
                    AND nivel='".$nivel."'
                    AND clave_almacen='".$almacen."'";

    
    
    if (mysqli_query($conexion, $query)){
        
        //echo "tarima colocada<br>";
        
    
    }else{
    
        echo "error para colocar la tarima:\n".mysqli_errno($conexion)."descripcion:\n".mysqli_error($conexion);
        
    
    }
}

function retirarTarima($idEtiqueta, $login, $conexion){
    $query = "UPDATE 
                    tb_ubicaciones_pallets_2021 
                SET
                    clave_etiqueta = null,
                    id_estatus = 192,
                    login = '".$login."'
                WHERE
                    clave_etiqueta = '". $idEtiqueta. "'";

    if (mysqli_query($conexion, $query)){
        
        //echo "tarima retirada correctamente<br>";
        
    }else{
    
        echo "error para retirar la tarima:\n".mysqli_errno($conexion)."descripcion:\n".mysqli_error($conexion);
        
    }

}

function surtirTarima($idEtiqueta, $login, $conexion){
    $query = " UPDATE 
                    tb_ubicaciones_pallets_2021 
                SET
                    id_estatus = 194,
                    login = '".$login."'
                WHERE
                    clave_etiqueta = '". $idEtiqueta. "'";

    if (mysqli_query($conexion, $query)){
        
        //echo "Tarima es estatus de surtido<br>";
        
    
    }else{
    
        echo "error para surtir la tarima:\n".mysqli_errno($conexion)."descripcion:\n".mysqli_error($conexion);
             
    }
}

function reacondicionarTarima($idEtiqueta, $login, $conexion){
    $query = "  UPDATE 
                    tb_ubicaciones_pallets_2021 
                SET
                    id_estatus = 193,
                    login = '".$login."'
                WHERE
                    clave_etiqueta = '". $idEtiqueta. "'";

    if (mysqli_query($conexion, $query)){
        
        //echo "tarima es estatus de reacondicionado<br>";   
    
    }else{
    
        echo "error para mandar a reacondicionar tarima:\n".mysqli_errno($conexion)."descripcion:\n".mysqli_error($conexion);
        
    }
}

function reiniciarUbicacion($id, $conexion){

    $query = "  UPDATE 
                    tb_ubicaciones_pallets_2021 
                SET
                    clave_etiqueta = null,
                    id_estatus = 92
                WHERE
                    id = $id";

    if(mysqli_query($conexion, $query)){
        //echo "Ubicacion reiniciada<br>";
        
        return true;

    }else{
        //echo "ubicacion sin modificaciones<br>";
        
        return false;

    }
}

function verificarClaveProducto($clave, $rack, $almacen, $conexion){

    $query = "  SELECT DISTINCT
                clave_almacen, clave_rack, clave_producto, clave_producto1, clave_producto2, clave_producto3 
            FROM
                tb_ubicaciones_pallets_2021
            WHERE
                clave_almacen = ".$almacen." AND clave_rack = '".$rack."' AND
                (clave_producto = '".$clave."'
                    OR clave_producto1 = '".$clave."'
                        OR clave_producto2 = '".$clave."'
                            OR clave_producto3 = '".$clave."')";

    $consulta = $conexion->query($query);
    
    if ($consulta->num_rows>0){
    
        //echo "Posicion correcta";
        return false;
    
    }else{
    
        //echo "Ese rack no corresponde";
        return true;
    
    }


}

?>