<?php
include '../../conexiones/conexion_sipisa.php';
  //AQUI TENEMOS QUE MANDAR A LA APP EL ID QUE ACABAMOS DE INSERTAR

  $sql="select max(cabecero_carga_tpt_id) as id from tb_cabecero_carga_tpt";
	$resultado_id = $conexion->query($sql);
	
	while ($fila = mysqli_fetch_assoc($resultado_id)) {

        $arr= array();
        $arr[0]["id_max"] =$fila["id"];
        echo array_to_json($arr);
	}

?>