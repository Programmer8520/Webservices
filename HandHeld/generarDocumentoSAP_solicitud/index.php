<?php
include '../../conexiones/conexion_sipisa.php';
ini_set("display_errors", "on");
if(isset($_GET["id"]))
{
	$mycomp=new COM("SAPbobsCOM.company") or die ("No connection");
	$mycomp->Server="SVRSAP10";
	//$mycomp->LicenseServer = "192.168.1.225:40000";
	$mycomp->LicenseServer = "SVRSAP10:30000";
	$mycomp->DbServerType = 10;  
	//$mycomp->CompanyDB = "Test_Innovador";
	$mycomp->CompanyDB = "Innovador";
	$mycomp->UserName = "Bodega03";
	$mycomp->Password = "An9l1st98";
	$mycomp->DbUserName = "sa";
	$mycomp->DbPassword = "P4ssw0rd";
	$mycomp->language = 23;
	$mycomp->UseTrusted = false;
	
	$lRetCode = $mycomp->Connect();

	try 
	{
		if ($lRetCode == 0)
		{
			$vItem = $mycomp->GetBusinessObject(1250000001); //SOLICITUD DE TRASPASO
			//echo "Conectado A SAP de Produccion";
			//DELCARAR DATOS CABECERO
			$id=$_GET["id"];
			$fechaSalida = obtenerFecha($conexion);
			$sql="SELECT 
					uuid_cabecero_carga_tpt,
					bodega_origen,
					bodega_destino,
					numero_analista_inventarios,
					nombre_analista_inventarios,
					numero_montacarguista,
					nombre_montacarguista,
					numero_guardia_seguridad,
					nombre_guardia_seguridad
					FROM
						tb_cabecero_carga_tpt
					WHERE
						cabecero_carga_tpt_id = $id
					ORDER BY cabecero_carga_tpt_id DESC";
			$resultado_hdr = mysqli_query($conexion, $sql);
			$uuid="";
			$bodega_origen="";
			$bodega_destino="";
			
			while ($fila = mysqli_fetch_assoc($resultado_hdr)) {

				$uuid=$fila["uuid_cabecero_carga_tpt"];
				$bodega_origen=$fila["bodega_origen"];
				$bodega_destino=$fila["bodega_destino"];

				$vItem->DocObjectCode = 67;
				$vItem->DocDate =date("d/m/Y");
				$vItem->TaxDate =date("d/m/Y");
				$vItem->FromWarehouse =intval($bodega_origen);
				$vItem->ToWarehouse =intval($bodega_destino);
				$vItem->Comments =$fila["numero_analista_inventarios"] ." - ".$fila["nombre_analista_inventarios"] ." - ". date("h:i a") ." \n ". $fila["numero_montacarguista"] ." - ". $fila["nombre_montacarguista"] ." \n ". $fila["numero_guardia_seguridad"] ." - ". $fila["nombre_guardia_seguridad"];
				$vItem->JournalMemo ="SOLICITUD GENERADA DESDE HANDHELD";
			}	
			//DECLARAR DATOS DETALLE

			/*$sql = "SELECT 
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
			GROUP BY dtl.no_lote, clave order by dtl.nombre_producto";*/
			$sql="SELECT 
				dtl.nombre_producto,
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
			GROUP BY clave;";
			
			$resultado_dtl = mysqli_query($conexion, $sql);

			while ($fila = mysqli_fetch_assoc($resultado_dtl)) {
	
				$cantidad=$fila["cantidad"];
				//echo $cantidad."<br>";
				$vItem->Lines->ItemCode=$fila["clave"];
				
				$vItem->Lines->FromWarehouseCode=intval($bodega_origen);
				$vItem->Lines->WarehouseCode=intval($bodega_destino);
				$vItem->Lines->Quantity=intval($cantidad);
				//$vItem->Lines->BatchNumbers->BatchNumber = $fila["no_lote_sap"];
				//$vItem->Lines->BatchNumbers->Quantity = intval($cantidad);

				$vItem->Lines->Add();
			}

			//GUARAR DATOS Y GENERAR DOCUMENTO SAP
			$transfer = $vItem->Add();
			if ($transfer == 0)
			{
				$strDocentry= $mycomp->GetNewObjectKey();
				//echo "SE GUARDO CON EL NUMERP DE DOCUMENTO <br>" . $strDocentry;
				
				$sqlUpdateDetalle="UPDATE tb_detalle_carga_tpt SET numero_documento=? WHERE uuid_cabecero_carga_tpt=?";
				$sentenciaUpdateDetalle=$conexion->prepare($sqlUpdateDetalle);
				$sentenciaUpdateDetalle->bind_param('ss',$strDocentry,$uuid);
				
				if($sentenciaUpdateDetalle->execute())
				{
					//echo "<br>SE GUARDO CORRECTAMENTE";
				}
				else{
					//echo "<br>ERROR DE WEB SERVICE";
				}
				
				$sqlUpdateCabecero="UPDATE tb_cabecero_carga_tpt SET numero_documento=?, salida_rampa=?, id_estatus = 202 WHERE uuid_cabecero_carga_tpt=?";
				$sentenciaUpdateCabecero=$conexion->prepare($sqlUpdateCabecero);
				$sentenciaUpdateCabecero->bind_param('sss',$strDocentry,$fechaSalida,$uuid);
			
				if($sentenciaUpdateCabecero->execute())
				{
					//echo "<br>SE GUARDO CORRECTAMENTE";
				}
				else{
					//echo "<br>ERROR DE WEB SERVICE";
				}

			
				$conexion->close();

				echo $strDocentry;
			}
			else
			{

				echo "Error al insertar: <br>". $mycomp->GetLastErrorCode() . "<br>" .$mycomp->GetLastErrorDescription();
			}

		}
		else
		{	
			echo "Error de conexion: <br>". $mycomp->GetLastErrorCode() . "<br>" .$mycomp->GetLastErrorDescription();
		}

	} catch (Exception $e) {
		
		echo '<br>Excepción capturada: ',  $e->getMessage(), "\n";
	
	}
	finally{
		
		$mycomp->Disconnect();
		//echo "<br>DESCONECTADO";

	}

}
ini_set("display_errors", "on");



?>
