<?php
include '../../conexiones/conexion_sipisa.php';

/*
$hostname='192.168.1.112';
$database='sipisa';
$username='root';
$password='58737217';

$conexion=new mysqli($hostname,$username,$password,$database);
if($conexion->connect_errno){
    echo "El sitio web está experimentado problemas";
}
*/
ini_set("display_errors", "on");
if(isset($_GET["id"]))
{
	$mycomp=new COM("SAPbobsCOM.company") or die ("No connection");
	$mycomp->Server="SVRSAP01";
	//$mycomp->LicenseServer = "192.168.1.225:40000";
	$mycomp->LicenseServer = "SVRSAP01:30000";
	$mycomp->DbServerType = 7;  
	//$mycomp->CompanyDB = "Test_Innovador";
	$mycomp->CompanyDB = "Innovador";
	$mycomp->UserName = "manager";
	$mycomp->Password = "In58737217";
	$mycomp->DbUserName = "sa";
	$mycomp->DbPassword = "P4ssw0rd";
	$mycomp->language = 23;
	$mycomp->UseTrusted = false;
	
	$lRetCode = $mycomp->Connect();
	$doc_num=$_GET["id"];
	$fecha = obtenerFecha($conexion);

	$arr = array();
	$query = "SELECT no_lote FROM tb_detalle_carga_tpt WHERE numero_documento = '$doc_num' order by numero_linea";
	try 
	{
		if ($lRetCode == 0)
		{
			$consulta = mysqli_query($conexion, $query);
			if(mysqli_num_rows($consulta) > 0)
			{
				$i=0;
				while($fila = mysqli_fetch_array($consulta))
				{
					$arr[$i] = $fila[0]."P";
					$i++;
					//var_dump($fila)."<br>";
				}
			//var_export($arr);
			}
			//obtenemos los datos de la aplicacion

			$vItem_request = $mycomp->GetBusinessObject(1250000001); //SOLICITUD DE TRASPASO
			if($vItem_request->GetByKey($doc_num))
			{

				$vItem_transfer = $mycomp->GetBusinessObject(67); //TRASPASO
				$vItem_transfer->DocObjectCode = $vItem_request->DocObjectCode;
				$vItem_transfer->DocDate =$vItem_request->DocDate;
				$vItem_transfer->TaxDate =$vItem_request->TaxDate;
				$vItem_transfer->FromWarehouse =$vItem_request->FromWarehouse;
				$vItem_transfer->ToWarehouse =$vItem_request->ToWarehouse;
				$vItem_transfer->Comments =$vItem_request->Comments;
				$vItem_transfer->JournalMemo =$vItem_request->JournalMemo;
				for ($i = 0; $i < $vItem_request->Lines->Count; $i++) 
				{
					$vItem_request->Lines->SetCurrentLine($i);
					//echo "<hr><br>DATOS A INSERTAR<br>";
					//echo $vItem_request->Lines->ItemCode."<br>";
					//echo $vItem_request->Lines->FromWarehouseCode."<br>";
					//echo $vItem_request->Lines->WarehouseCode."<br>";
					//echo $vItem_request->Lines->Quantity."<br>";
					//echo $vItem_request->Lines->Quantity."<br>";
					//echo $arr[$i]."<br>";

					$vItem_transfer->Lines->ItemCode			=$vItem_request->Lines->ItemCode;
					$vItem_transfer->Lines->FromWarehouseCode 	=$vItem_request->Lines->FromWarehouseCode;
					$vItem_transfer->Lines->WarehouseCode		=$vItem_request->Lines->WarehouseCode;
					$vItem_transfer->Lines->Quantity			=$vItem_request->Lines->Quantity;
					
					$vItem_transfer->Lines->BatchNumbers->BatchNumber = $arr[$i];
					$vItem_transfer->Lines->BatchNumbers->Quantity = $vItem_request->Lines->Quantity;
				
					$vItem_transfer->Lines->Add();	
					
					
				}
				
				$transfer = $vItem_transfer->Add();
				if ($transfer == 0)
				{
					$strDocentry= $mycomp->GetNewObjectKey();
					//echo "SE GUARDO CON EL NUMERP DE DOCUMENTO <br>" . $strDocentry;
					$sqlUpdateCabecero="UPDATE tb_cabecero_carga_tpt SET salida_rampa_destino =  ,numero_documento_entrada=$strDocentry, id_estatus = 214 WHERE numero_documento=$doc_num";
					
					if(mysqli_query($conexion, $sqlUpdateCabecero)){
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
	
					echo "Error al insertar: <br>". utf8_encode($mycomp->GetLastErrorCode()) . "<br>" .utf8_encode($mycomp->GetLastErrorDescription());
				}
				
			}
			
			else
			{

				echo "No se encontro el documento". $mycomp->GetLastErrorCode() . "<br>" .$mycomp->GetLastErrorDescription();
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

function cerrarDocumento($numero_solicitud, $conexion){

	if(isset($numero_solicitud))
	{
		$mycomp=new COM("SAPbobsCOM.company") or die ("No connection");
		$mycomp->Server="SVRSAP01";
		//$mycomp->LicenseServer = "192.168.1.225:40000";
		$mycomp->LicenseServer = "SVRSAP01:30000";
		$mycomp->DbServerType = 7;  
		//$mycomp->CompanyDB = "Test_Innovador";
		$mycomp->CompanyDB = "Innovador";
		$mycomp->UserName = "manager";
		$mycomp->Password = "In58737217";
		$mycomp->DbUserName = "sa";
		$mycomp->DbPassword = "P4ssw0rd";
		$mycomp->language = 23;
		$mycomp->UseTrusted = false;
		
		$lRetCode = $mycomp->Connect();
		
		$fecha = obtenerFecha($conexion);
		
		$arr = array();
		$query = "SELECT no_lote FROM tb_detalle_carga_tpt WHERE numero_documento = '$numero_solicitud' order by numero_linea";
		try 
		{
			if ($lRetCode == 0)
			{
				$consulta = mysqli_query($conexion, $query);
				if(mysqli_num_rows($consulta) > 0)
				{
					$i=0;
					while($fila = mysqli_fetch_array($consulta))
					{
						$arr[$i] = $fila[0]."P";
						$i++;
						//var_dump($fila)."<br>";
					}
				//var_export($arr);
				}
				//obtenemos los datos de la aplicacion
	
				$vItem_request = $mycomp->GetBusinessObject(1250000001); //SOLICITUD DE TRASPASO
				if($vItem_request->GetByKey($numero_solicitud))
				{
	
					$vItem_transfer = $mycomp->GetBusinessObject(67); //TRASPASO
					$vItem_transfer->DocObjectCode = $vItem_request->DocObjectCode;
					$vItem_transfer->DocDate =$vItem_request->DocDate;
					$vItem_transfer->TaxDate =$vItem_request->TaxDate;
					$vItem_transfer->FromWarehouse =$vItem_request->FromWarehouse;
					$vItem_transfer->ToWarehouse =$vItem_request->ToWarehouse;
					$vItem_transfer->Comments =$vItem_request->Comments;
					$vItem_transfer->JournalMemo =$vItem_request->JournalMemo;
					for ($i = 0; $i < $vItem_request->Lines->Count; $i++) 
					{
						$vItem_request->Lines->SetCurrentLine($i);
						//echo "<hr><br>DATOS A INSERTAR<br>";
						//echo $vItem_request->Lines->ItemCode."<br>";
						//echo $vItem_request->Lines->FromWarehouseCode."<br>";
						//echo $vItem_request->Lines->WarehouseCode."<br>";
						//echo $vItem_request->Lines->Quantity."<br>";
						//echo $vItem_request->Lines->Quantity."<br>";
						//echo $arr[$i]."<br>";
	
						$vItem_transfer->Lines->ItemCode			=$vItem_request->Lines->ItemCode;
						$vItem_transfer->Lines->FromWarehouseCode 	=$vItem_request->Lines->FromWarehouseCode;
						$vItem_transfer->Lines->WarehouseCode		=$vItem_request->Lines->WarehouseCode;
						$vItem_transfer->Lines->Quantity			=$vItem_request->Lines->Quantity;
						
						$vItem_transfer->Lines->BatchNumbers->BatchNumber = $arr[$i];
						$vItem_transfer->Lines->BatchNumbers->Quantity = $vItem_request->Lines->Quantity;
					
						$vItem_transfer->Lines->Add();	
						
						
					}
					
					$transfer = $vItem_transfer->Add();
					if ($transfer == 0)
					{
						$strDocentry= $mycomp->GetNewObjectKey();
						//echo "SE GUARDO CON EL NUMERP DE DOCUMENTO <br>" . $strDocentry;
						$sqlUpdateCabecero="UPDATE tb_cabecero_carga_tpt SET salida_rampa_destino = '$fecha' ,numero_documento_entrada=$strDocentry, id_estatus = 214 WHERE numero_documento=$numero_solicitud";
						
						if(mysqli_query($conexion, $sqlUpdateCabecero)){
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
		
						echo "Error al insertar: <br>". utf8_encode($mycomp->GetLastErrorCode()) . "<br>" .utf8_encode($mycomp->GetLastErrorDescription());
					}
					
				}
				
				else
				{
	
					echo "No se encontro el documento". $mycomp->GetLastErrorCode() . "<br>" .$mycomp->GetLastErrorDescription();
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

}

?>
