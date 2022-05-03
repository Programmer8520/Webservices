<?php

include '../../../conexion_sipisa.php';

$uuid = $_GET["uuid"];
$query = "SELECT clave, nombre_producto FROM tb_detalle_carga_tpt WHERE uuid_cabecero_carga_tpt = '$uuid' AND numero_documento != '-1' ORDER BY id";
$string_table = "";

if ($consulta = mysqli_query($conexion, $query)) {
    $string_table.= "<table border='1'>";
    $string_table.= "<thead>";
    $string_table.= "<tr>";
    $string_table.= "<td>Clave de Producto</td>";
    $string_table.= "<td>Nombre de Producto</td>";
    $string_table.= "<td>Tarimas</td>";
    $string_table.= "<td>Verificado</td>";
    $string_table.= "</tr>";
    $string_table.= "</thead>";
    if (mysqli_num_rows($consulta) > 0) {
        $string_table.= "<tbody>";
        $arr = array();
        $cadena = "";
        $i = 0;
        while ($fila = mysqli_fetch_array($consulta)){
            $n = $i+1;
            $string_table.= "<tr>";
            $string_table.= "<td>".$fila[0]."</td>";
            $string_table.= "<td>".utf8_decode($fila[1])."</td>";
            $arr[$i]["nombre_producto"] = utf8_encode($fila[1]);
            $cadena .= utf8_encode($fila[1]);
            
            $string_table.= "<td>".$n."</td>";
            $string_table.= "<td><input type='checkbox' id='cbox2' value='second_checkbox'></td>";
            $string_table.= "</tr>";
            $i++;
        }
        $string_table.= "</tbody>";
        $string_table.= "</table>";
    }else {

        $solicitud = "SELECT numero_documento FROM tb_cabecero_carga_tpt WHERE uuid_cabecero_carga_tpt = '$uuid'";

        if ($nSoli = mysqli_query($conexion, $solicitud)){

            if (mysqli_num_rows($nSoli) > 0) {

                $fila = mysqli_fetch_array($nSoli);

                if ($fila[0] == '-') {
                    echo "la consulta no dio datos";

                }else {

                    echo $fila[0];

                }
                
            }else {

                echo "la consulta no dio datos";

            }

        }else {

            echo "No se ejecuto la consulta";

        }


    }

}else {

    echo  "consulta no ejecutada<br>";
    echo mysqli_error($conexion)."->".mysqli_errno($conexion)."<br>";

}

//echo $cadena;

echo $string_table;

mysqli_close($conexion);

?>