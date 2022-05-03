<?php
include '../../conexiones/conexion_sipisa.php';
//ini_set('display_errors', 1);
$clave_etiqueta = $_GET["paramClaveEtiqueta"];
$clave_almacen = $_GET["paramClaveAlmacen"];
$clave_rack = $_GET["paramClaveRack"];
$posicion  = $_GET["paramPosicion"];
$nivel = $_GET["paramNivel"];
$mod = $_GET["mod"];
$login  = $_GET["paramLogin"];
//$clave_producto = $_POST["paramClaveProducto"];

$datosTarima = array();
$datosTarimaEncontrada = array();
$lugarTarimaEncontrada = array();

$datosTarimaEncontrada=EstaLaTarima($clave_etiqueta, $conexion);
$lugarTarimaEncontrada = QueHayEnPosicion($clave_almacen, $clave_rack, $posicion, $nivel, $conexion);
$rack_encontrado = $datosTarimaEncontrada["clave_rack"];
$posicion_encontrada = $datosTarimaEncontrada["posicion"];
$nivel_encontrado = $datosTarimaEncontrada["nivel"];

switch ($mod) {
    case 0: //COLOCAR TERIMA
        //http://www.innovador.com.mx/webservice_dev/UbicacionPallets/test/?paramClaveEtiqueta=0003516430&paramClaveAlmacen=1&paramClaveRack=A&paramPosicion=1&paramNivel=1&mod=0&paramLogin=Javier
        //http://www.innovador.com.mx/webservice_dev/UbicacionPallets/test/?paramClaveEtiqueta=0003516430&paramClaveAlmacen=1&paramClaveRack=A&paramPosicion=1&paramNivel=2&mod=0&paramLogin=Javier

        if(!empty($datosTarimaEncontrada)){

            retirarTarima("manager", $clave_etiqueta, $conexion);
            
            if(($rack_encontrado==$clave_rack)&&($posicion_encontrada==$posicion)&&($nivel_encontrado==$nivel)){
                //Si esta la tarima, y en la misma posicion
                echo "Si esta la tarima, y en la misma posicion<br>";
                colocarTarima($clave_etiqueta, $clave_almacen, $clave_rack, $posicion, $nivel, $login, $conexion);
                //fin
            }else{
                echo "Si esta la tarima, pero en posicion distinta a POST<br>";
                if(!empty($lugarTarimaEncontrada)){
                    if($lugarTarimaEncontrada["clave_etiqueta"] != null){
                        echo "La tarima ".$lugarTarimaEncontrada["clave_etiqueta"]." se encuentra en esa posicion, sera retirada<br>";
                        retirarTarima("manager", $lugarTarimaEncontrada["clave_etiqueta"], $conexion);
                        
                    }
                    colocarTarima($clave_etiqueta, $clave_almacen, $clave_rack, $posicion, $nivel, $login, $conexion);
                }else{
                    echo "Error para saber QueHayEnPosicion1<br>";
                }
            }
            
        }else{
            //colocar tarima de POST
            if($lugarTarimaEncontrada = QueHayEnPosicion($clave_almacen, $clave_rack, $posicion, $nivel, $conexion)){
                if($lugarTarimaEncontrada["clave_etiqueta"] != null){
                    echo "La tarima ".$lugarTarimaEncontrada["clave_etiqueta"]." se encuentra en esa posicion, sera retirada<br>";

                    retirarTarima("manager", $lugarTarimaEncontrada["clave_etiqueta"], $conexion);
                    colocarTarima($clave_etiqueta, $clave_almacen, $clave_rack, $posicion, $nivel, $login, $conexion);
                }else{
                    echo "La posicion esta disponible2<br>";
                    colocarTarima($clave_etiqueta, $clave_almacen, $clave_rack, $posicion, $nivel, $login, $conexion);
                }
            }else{
                echo "Error para saber QueHayEnPosicion2<br>";
            }
        }

    break;
    case 1: //RETIRAR TARIMA

        if(!empty($datosTarimaEncontrada)){
            //¿ESTA LA TARIMA EN LA MISMA POSICION DE POST?
            if(($rack_encontrado==$clave_rack)&&($posicion_encontrada==$posicion)&&($nivel_encontrado==$nivel)){
                //Si esta la tarima, y en la misma posicion
                echo "Si esta la tarima, y en la misma posicion<br>";
                retirarTarima($login, $clave_etiqueta, $conexion);
                //fin
            }else{
                echo "Si esta la tarima, pero en posicion distinta a POST<br>";
                if(!empty($lugarTarimaEncontrada)){
                    if($lugarTarimaEncontrada["clave_etiqueta"] != null){
                        echo "La tarima ".$lugarTarimaEncontrada["clave_etiqueta"]." se encuentra en esa posicion, sera retirada para colocar y retirar la de POST<br>";
                        retirarTarima("manager", $lugarTarimaEncontrada["clave_etiqueta"], $conexion);
                    }
                    colocarTarima($clave_etiqueta, $clave_almacen, $clave_rack, $posicion, $nivel, "manager", $conexion);
                    retirarTarima($login, $clave_etiqueta, $conexion);
                }
            }
            
        }else{
            //colocar tarima de POST
            if(!empty($lugarTarimaEncontrada)){
                if($lugarTarimaEncontrada["clave_etiqueta"] != null){
                    echo "La tarima ".$lugarTarimaEncontrada["clave_etiqueta"]." se encuentra en esa posicion, sera retirada<br>";

                    retirarTarima("manager", $lugarTarimaEncontrada["clave_etiqueta"], $conexion);
                }
                colocarTarima($clave_etiqueta, $clave_almacen, $clave_rack, $posicion, $nivel, "manager", $conexion);
                retirarTarima($login, $clave_etiqueta, $conexion);
            }
        }
    break;
    case 2: //SURTIR TARIMA
        
        if(!empty($datosTarimaEncontrada)){
            
            //¿ESTA LA TARIMA EN LA MISMA POSICION DE POST?
            if(($rack_encontrado==$clave_rack)&&($posicion_encontrada==$posicion)&&($nivel_encontrado==$nivel)){
                //Si esta la tarima, y en la misma posicion
                echo "Si esta la tarima, y en la misma posicion<br>";
                surtirTarima($login, $clave_etiqueta, $conexion);
                //fin
            }else{
                echo "Si esta la tarima, pero en posicion distinta a POST<br>";
                if(!empty($lugarTarimaEncontrada)){
                    if($lugarTarimaEncontrada["clave_etiqueta"] != null){
                        echo "La tarima ".$lugarTarimaEncontrada["clave_etiqueta"]." se encuentra en esa posicion, sera retirada para colocar y retirar la de POST<br>";
                        retirarTarima("manager", $lugarTarimaEncontrada["clave_etiqueta"], $conexion);
                        
                    }
                    retirarTarima("manager", $clave_etiqueta, $conexion);
                    colocarTarima($clave_etiqueta, $clave_almacen, $clave_rack, $posicion, $nivel, "manager", $conexion);
                    surtirTarima($login, $clave_etiqueta, $conexion);
                }
            }
            
        }else{
            //colocar tarima de POST
            if(!empty($lugarTarimaEncontrada)){
                if($lugarTarimaEncontrada["clave_etiqueta"] != null){
                    echo "La tarima ".$lugarTarimaEncontrada["clave_etiqueta"]." se encuentra en esa posicion, sera retirada<br>";

                    retirarTarima("manager", $lugarTarimaEncontrada["clave_etiqueta"], $conexion);
                }
                colocarTarima($clave_etiqueta, $clave_almacen, $clave_rack, $posicion, $nivel, "manager", $conexion);
                surtirTarima($login, $clave_etiqueta, $conexion);
            }
        }
    break;
    case 3: //ACONDICIONAR TARIMA
        
        if(!empty($datosTarimaEncontrada)){
            
            //¿ESTA LA TARIMA EN LA MISMA POSICION DE POST?
            if(($rack_encontrado==$clave_rack)&&($posicion_encontrada==$posicion)&&($nivel_encontrado==$nivel)){
                //Si esta la tarima, y en la misma posicion
                echo "Si esta la tarima, y en la misma posicion<br>";
                reacondicionarTarima($login, $clave_etiqueta, $conexion);
                //fin
            }else{
                echo "Si esta la tarima, pero en posicion distinta a POST<br>";
                if(!empty($lugarTarimaEncontrada)){
                    if($lugarTarimaEncontrada["clave_etiqueta"] != null){
                        echo "La tarima ".$lugarTarimaEncontrada["clave_etiqueta"]." se encuentra en esa posicion, sera retirada para colocar y retirar la de POST<br>";
                        retirarTarima("manager", $lugarTarimaEncontrada["clave_etiqueta"], $conexion);
                        
                    }
                    retirarTarima("manager", $clave_etiqueta, $conexion);
                    colocarTarima($clave_etiqueta, $clave_almacen, $clave_rack, $posicion, $nivel, "manager", $conexion);
                    reacondicionarTarima($login, $clave_etiqueta, $conexion);
                }
            }
            
        }else{
            //colocar tarima de POST
            if(!empty($lugarTarimaEncontrada)){
                if($lugarTarimaEncontrada["clave_etiqueta"] != null){
                    echo "La tarima ".$lugarTarimaEncontrada["clave_etiqueta"]." se encuentra en esa posicion, sera retirada<br>";

                    retirarTarima("manager", $lugarTarimaEncontrada["clave_etiqueta"], $conexion);
                }
                colocarTarima($clave_etiqueta, $clave_almacen, $clave_rack, $posicion, $nivel, "manager", $conexion);
                reacondicionarTarima($login, $clave_etiqueta, $conexion);
            }
        } 
    break;
    default:
    break;

}


function EstaLaTarima($clvEti, $conexion){

    $datos = array();
    $query = "SELECT * FROM tb_ubicaciones_pallets_2021 WHERE clave_etiqueta = '$clvEti'";

    if($consulta = mysqli_query($conexion, $query)){
        if(mysqli_num_rows($consulta) > 0){
            echo "Existe<br>";
            $datos = obtenerDatos($consulta);
            return $datos;
        }else{
            echo "No Existe<br>";
            return $datos;
        }
    }
}

function QueHayEnPosicion($almacen, $rack, $posicion, $nivel, $conexion){
    $datos = array();
    $query = "SELECT * FROM tb_ubicaciones_pallets_2021 WHERE clave_almacen = '$almacen' AND clave_rack = '$rack' AND posicion = $posicion AND nivel = $nivel";

    if($consulta = mysqli_query($conexion, $query)){
        if(mysqli_num_rows($consulta) > 0){
            $datos = obtenerDatos($consulta);
            return $datos;
        }else{
            echo "No Hay ninguna tarima en esa posicion<br>";
            return $datos;
        }
    }
}

function obtenerDatos($vResultado){
    
    $arr= array();
    $i=0;

    while ($fila = mysqli_fetch_assoc($vResultado)) {

        $arr["id"] = $fila["id"];
        $arr["clave_almacen"] = $fila["clave_almacen"];
        $arr["clave_rack"] = $fila["clave_rack"];
        $arr["posicion"] = $fila["posicion"];
        $arr["nivel"] = $fila["nivel"];
        $arr["clave_etiqueta"] = $fila["clave_etiqueta"];
        $arr["id_estatus"] = $fila["id_estatus"];
        $arr["clave_producto"] = $fila["clave_producto"];
        $arr["clave_producto1"] = $fila["clave_producto1"];
        $arr["clave_producto2"] = $fila["clave_producto2"];
        $arr["clave_producto3"] = $fila["clave_producto3"];

        $i++;
    }
    //$vResultado -> close();

    return $arr;
    
}

function colocarTarima($param_clave_etiqueta, $param_almacen, $param_rack, $param_posicion, $param_nivel, $param_login, $conexion){
    $query = " UPDATE 
                    tb_ubicaciones_pallets_2021 
                SET 
                    clave_etiqueta = '".$param_clave_etiqueta."',
                    id_estatus = 191, 
                    login = '".$param_login."' 
                WHERE  
                    clave_rack = '$param_rack'
                    AND clave_almacen='$param_almacen'
                    AND posicion=$param_posicion
                    AND nivel=$param_nivel";


    //if (mysqli_query($conexion, $query))
    $sentenciaUpdate=$conexion->prepare($query);
    
    if ($sentenciaUpdate->execute()){

        echo "tarima [$param_clave_etiqueta] colocada<br>";

    }else{

        echo "error para colocar la tarima:\n".mysqli_errno($conexion)."descripcion:\n".mysqli_error($conexion);


    }

}

function retirarTarima($param_login, $param_clave_etiqueta,$conexion){
    $query = "UPDATE 
                    tb_ubicaciones_pallets_2021 
                SET
                    clave_etiqueta = null,
                    id_estatus = 192,
                    login = '".$param_login."'
                WHERE
                    clave_etiqueta = '". $param_clave_etiqueta. "'";

                    
    $sentenciaUpdate=$conexion->prepare($query);
    
    if ($sentenciaUpdate->execute()){
        
        echo "tarima retirada [$param_clave_etiqueta] correctamente<br>";
        
    }else{
    
        echo "error para retirar la tarima:\n".mysqli_errno($conexion)."descripcion:\n".mysqli_error($conexion);
        
    }

}

function surtirTarima($param_login, $param_clave_etiqueta, $conexion){
    $query = " UPDATE 
                    tb_ubicaciones_pallets_2021 
                SET
                    id_estatus = 194,
                    login = '".$param_login."'
                WHERE
                    clave_etiqueta = '". $param_clave_etiqueta. "'";

    if (mysqli_query($conexion, $query)){
        
        echo "Tarima es estatus de surtido<br>";
        
    
    }else{
    
        echo "error para surtir la tarima:\n".mysqli_errno($conexion)."descripcion:\n".mysqli_error($conexion);
             
    }
}

function reacondicionarTarima($param_login, $param_clave_etiqueta, $conexion){
    $query = "  UPDATE 
                    tb_ubicaciones_pallets_2021 
                SET
                    id_estatus = 193,
                    login = '".$param_login."'
                WHERE
                    clave_etiqueta = '". $param_clave_etiqueta. "'";

    if (mysqli_query($conexion, $query)){
        
        echo "tarima es estatus de reacondicionado<br>";   
    
    }else{
    
        echo "error para mandar a reacondicionar tarima:\n".mysqli_errno($conexion)."descripcion:\n".mysqli_error($conexion);
        
    }
}


?>