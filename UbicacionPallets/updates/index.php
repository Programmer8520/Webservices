<?php
//http://innovador.com.mx/webservice_dev/UbicacionPallets/updates/
//?mod=0
//&paramClaveAlmacen=1
//&paramClaveRack=A
//&paramPosicion=1
//&paramNivel=1
//&paramClaveEtiqueta=0003516430
//&paramClaveProducto=109008-001001
//&paramLogin=PS00112
ini_set('display_errors', 1);
include '../../conexiones/conexion_sipisa.php';


$mod = $_POST["mod"];
$clave_almacen = $_POST["paramClaveAlmacen"];
$clave_rack = $_POST["paramClaveRack"];
$posicion  = intval($_POST["paramPosicion"]);
$nivel = $_POST["paramNivel"];
$clave_etiqueta = $_POST["paramClaveEtiqueta"];
//$clave_producto = $_POST["paramClaveProducto"];
$login  = strtoupper($_POST["paramLogin"]);


//echo $mod . " " . $clave_almacen  . " " . $clave_rack  . " " . $posicion   . " " . $nivel  . " " . $clave_etiqueta  . " " . $clave_producto . " " . $login ; 


/*
$mod = $_GET["mod"];


$clave_almacen = $_GET["paramClaveAlmacen"];
$clave_rack = $_GET["paramClaveRack"];
$posicion  = $_GET["paramPosicion"];
$nivel = $_GET["paramNivel"];
$clave_etiqueta = $_GET["paramClaveEtiqueta"];
$clave_producto = $_GET["paramClaveProducto"];

$login  = $_GET["paramLogin"];
*/



switch ($mod) {
    case 0: //COLOCAR TARIMA

        //---VERIFICA SI LA TARIMA SE ENCUENTRA EN OTRA POSICION DE LA QUE SE ESCANEO
        verificaOtraPosicionTarima($clave_almacen, $clave_rack, $posicion, $nivel, $clave_etiqueta, $conexion,false);

        //--AL FINAL VA A COLOCAR LA TARIMA
        colocarTarima($login, $clave_almacen, $clave_rack, $posicion, $nivel, $clave_etiqueta, $conexion);


        break;
    case 1: //RETIRAR TARIMA

        //---VERIFICA SI LA TARIMA SE ENCUENTRA EN OTRA POSICION DE LA QUE SE ESCANEO
        verificaOtraPosicionTarima($clave_almacen, $clave_rack, $posicion, $nivel, $clave_etiqueta, $conexion);

        //---VERIFICA SI EN LA POSICION QUE SE ESCANEO NO TIENE TARIMA
        verificaPosicionSinTarima($clave_almacen, $clave_rack, $posicion, $nivel, $clave_etiqueta, $conexion);

        //--AL FINAL VA A RETIRAR LA TARIMA
        retirarTarima($login, $clave_almacen, $clave_rack, $posicion, $nivel, $clave_etiqueta, $conexion);

        break;
    case 2: //SURTIR TARIMA

        //---VERIFICA SI LA TARIMA SE ENCUENTRA EN OTRA POSICION DE LA QUE SE ESCANEO
        verificaOtraPosicionTarima($clave_almacen, $clave_rack, $posicion, $nivel, $clave_etiqueta, $conexion);

        //---VERIFICA SI EN LA POSICION QUE SE ESCANEO NO TIENE TARIMA
        verificaPosicionSinTarima($clave_almacen, $clave_rack, $posicion, $nivel, $clave_etiqueta, $conexion);

        //---AL FINAL VA A SURTIR LA TARIMA
        surtirTarima($login, $clave_almacen, $clave_rack, $posicion, $nivel, $clave_etiqueta, $conexion);

        break;
    case 3: //REACONDICIONAR TARIMA

        //---VERIFICA SI LA TARIMA SE ENCUENTRA EN OTRA POSICION DE LA QUE SE ESCANEO
        verificaOtraPosicionTarima($clave_almacen, $clave_rack, $posicion, $nivel, $clave_etiqueta, $conexion);

        //---VERIFICA SI EN LA POSICION QUE SE ESCANEO NO TIENE TARIMA
        verificaPosicionSinTarima($clave_almacen, $clave_rack, $posicion, $nivel, $clave_etiqueta, $conexion);

        //---AL FINAL VA A REACONDICIONAR LA TARIMA
        reacondicionarTarima($login, $clave_almacen, $clave_rack, $posicion, $nivel, $clave_etiqueta, $conexion);

        break;
    default:
        break;
}




function estaTarimaEnPosicion($v_clave_almacen, $v_clave_rack, $v_posicion, $v_nivel, $v_clave_etiqueta, $conexion, $type = 0)
{

    $arr = array();

    if ($type == 0) {

        $query = "
        select  
        clave_almacen
        ,clave_rack
        ,posicion
        ,nivel
        ,clave_etiqueta
        from tb_ubicaciones_pallets_2021
        where
        clave_almacen = '" . $v_clave_almacen . "'
        AND clave_rack = '" . $v_clave_rack . "'
        AND posicion = '" . $v_posicion . "'
        AND nivel <> '" . $v_nivel . "'
        AND clave_etiqueta='" . $v_clave_etiqueta . "'
        ";
    } elseif ($type == 1) {
        $query = "
        select  
        clave_almacen
        ,clave_rack
        ,posicion
        ,nivel
        ,clave_etiqueta
        from tb_ubicaciones_pallets_2021
        where
        clave_almacen = '" . $v_clave_almacen . "'
        AND clave_rack = '" . $v_clave_rack . "'
        AND posicion = '" . $v_posicion . "'
        AND nivel = '" . $v_nivel . "'
        AND clave_etiqueta is null
        ";
    } else {
        $query = "
        select  
        clave_almacen
        ,clave_rack
        ,posicion
        ,nivel
        ,clave_etiqueta
        from tb_ubicaciones_pallets_2021
        where
        clave_almacen = '" . $v_clave_almacen . "'
        AND clave_rack = '" . $v_clave_rack . "'
        AND posicion = '" . $v_posicion . "'
        AND nivel = '" . $v_nivel . "'
        AND clave_etiqueta <> '" . $v_clave_etiqueta . "'
        ";
    }

    foreach ($conexion->query($query) as $row) {

        $arr["clave_almacen"] = $row["clave_almacen"];
        $arr["clave_rack"] = $row["clave_rack"];
        $arr["posicion"] = $row["posicion"];
        $arr["nivel"] = $row["nivel"];
        $arr["clave_etiqueta"] = $row["clave_etiqueta"];
    }

    return $arr;
}

function colocarTarima($param_login, $v_clave_almacen, $v_clave_rack, $v_posicion, $v_nivel, $v_clave_etiqueta, $conexion)
{

    //SI EN LA POSICIOIN QUE SE VA A COLOCAR HAY UNA TARIMA DIFERENTE A LA ESCANEADA
    $datosTarimaEncontrada = array();
    $datosTarimaEncontrada = estaTarimaEnPosicion($v_clave_almacen, $v_clave_rack, $v_posicion, $v_nivel, $v_clave_etiqueta, $conexion, 2);
    if (!empty($datosTarimaEncontrada)) {

        //SI ES ASI VA A RETIRAR LA TARIMA DE LA POSICION
        $tmp_clave_almacen = $datosTarimaEncontrada["clave_almacen"];
        $tmp_clave_rack = $datosTarimaEncontrada["clave_rack"];
        $tmp_posicion = $datosTarimaEncontrada["posicion"];
        $tmp_nivel = $datosTarimaEncontrada["nivel"];
        $tmp_clave_etiqueta = $datosTarimaEncontrada["clave_etiqueta"];
        retirarTarima("manager", $tmp_clave_almacen, $tmp_clave_rack, $tmp_posicion, $tmp_nivel, $tmp_clave_etiqueta, $conexion);
    }



    $query = "
    UPDATE tb_ubicaciones_pallets_2021 
    SET 
        id_estatus = 191,
        login = '" . $param_login . "',
        clave_etiqueta = '" . $v_clave_etiqueta . "'
    WHERE
        clave_almacen = '" . $v_clave_almacen . "'
            AND clave_rack = '" . $v_clave_rack . "'
            AND posicion = '" . $v_posicion . "'
            AND nivel = '" . $v_nivel . "'
          
    ";




    if (!$conexion->prepare($query)->execute()) {

        echo "error para colocar la tarima:\n" . mysqli_errno($conexion) . "descripcion:\n" . mysqli_error($conexion);
    }
}

function retirarTarima($param_login, $v_clave_almacen, $v_clave_rack, $v_posicion, $v_nivel, $v_clave_etiqueta, $conexion)
{

    


    $query = "
    UPDATE tb_ubicaciones_pallets_2021 
    SET 
        clave_etiqueta = NULL,
        id_estatus = 192,
        login = '" . $param_login . "'
    WHERE
        clave_almacen = '" . $v_clave_almacen . "'
            AND clave_rack = '" . $v_clave_rack . "'
            AND posicion = '" . $v_posicion . "'
            AND nivel = '" . $v_nivel . "'
            AND clave_etiqueta = '" . $v_clave_etiqueta . "'
    ";



    if (!$conexion->prepare($query)->execute()) {

        echo "error para retirar la tarima:\n" . mysqli_errno($conexion) . "descripcion:\n" . mysqli_error($conexion);
    }
}

function surtirTarima($param_login, $v_clave_almacen, $v_clave_rack, $v_posicion, $v_nivel, $v_clave_etiqueta, $conexion)
{

    $query = "
    UPDATE tb_ubicaciones_pallets_2021 
    SET 
        clave_etiqueta = NULL,
        id_estatus = 194,
        login = '" . $param_login . "'
    WHERE
        clave_almacen = '" . $v_clave_almacen . "'
            AND clave_rack = '" . $v_clave_rack . "'
            AND posicion = '" . $v_posicion . "'
            AND nivel = '" . $v_nivel . "'
            AND clave_etiqueta = '" . $v_clave_etiqueta . "'
    ";



    if (!$conexion->prepare($query)->execute()) {

        echo "error para surtir la tarima:\n" . mysqli_errno($conexion) . "descripcion:\n" . mysqli_error($conexion);
    }
}

function reacondicionarTarima($param_login, $v_clave_almacen, $v_clave_rack, $v_posicion, $v_nivel, $v_clave_etiqueta, $conexion)
{
    $query = "
    UPDATE tb_ubicaciones_pallets_2021 
    SET 
        clave_etiqueta = NULL,
        id_estatus = 193,
        login = '" . $param_login . "'
    WHERE
        clave_almacen = '" . $v_clave_almacen . "'
            AND clave_rack = '" . $v_clave_rack . "'
            AND posicion = '" . $v_posicion . "'
            AND nivel = '" . $v_nivel . "'
            AND clave_etiqueta = '" . $v_clave_etiqueta . "'
    ";

    if (!$conexion->prepare($query)->execute()) {

        echo "error para surtir la tarima:\n" . mysqli_errno($conexion) . "descripcion:\n" . mysqli_error($conexion);
    }
}

function verificaOtraPosicionTarima($clave_almacen, $clave_rack, $posicion, $nivel, $clave_etiqueta, $conexion, $type=true)
{
    //BUSCA SI LA TARIMA SE ENCUENTRA EN OTRA POSICION DE LA QUE SE ESCANEO
    $datosTarimaEncontrada = array();
    $datosTarimaEncontrada = estaTarimaEnPosicion($clave_almacen, $clave_rack, $posicion, $nivel, $clave_etiqueta, $conexion);
    if (!empty($datosTarimaEncontrada)) {

        //SI ES ASI VA A RETIRAR LA TARIMA DE LA OTRA POSICION Y LA VA A COLOCAR EN LA POSICION
        $v_clave_almacen = $datosTarimaEncontrada["clave_almacen"];
        $v_clave_rack = $datosTarimaEncontrada["clave_rack"];
        $v_posicion = $datosTarimaEncontrada["posicion"];
        $v_nivel = $datosTarimaEncontrada["nivel"];
        $v_clave_etiqueta = $datosTarimaEncontrada["clave_etiqueta"];
        retirarTarima("manager", $v_clave_almacen, $v_clave_rack, $v_posicion, $v_nivel, $v_clave_etiqueta, $conexion);
        
        if($type)
        {
            colocarTarima("manager", $clave_almacen, $clave_rack, $posicion, $nivel, $clave_etiqueta, $conexion);

        }
        
    }
}

function verificaPosicionSinTarima($v_clave_almacen, $v_clave_rack, $v_posicion, $v_nivel, $v_clave_etiqueta, $conexion)
{
    //BUSCA SI LA POSICION ESCANEADA NO TIENE TARIMA
    $datosTarimaEncontrada = array();
    $datosTarimaEncontrada = estaTarimaEnPosicion($v_clave_almacen, $v_clave_rack, $v_posicion, $v_nivel, $v_clave_etiqueta, $conexion, 1);
    if (!empty($datosTarimaEncontrada)) {
        //SI ES ASI VA A COLOCAR LA TARIMA
        colocarTarima("manager", $v_clave_almacen, $v_clave_rack, $v_posicion, $v_nivel, $v_clave_etiqueta, $conexion);
    }
}
