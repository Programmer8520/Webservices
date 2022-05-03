<?php
ini_set('display_errors', 1);
$mycomp=new COM("SAPbobsCOM.company") or die ("No connection");
$mycomp->Server="SVRSAP01";
$mycomp->LicenseServer = "192.168.1.226:30000";
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
		echo "Conectado a : " . $mycomp->CompanyName ."<br>";
		
		$mycomp->Disconnect();
		echo "<br>DESCONECTADO";
	}
	else
	{	
		echo "Error de conexion: <br>". $mycomp->GetLastErrorCode() . "<br>" .$mycomp->GetLastErrorDescription();
		$mycomp->Disconnect();
		echo "<br>DESCONECTADO";	 
	}

} catch (Exception $e) {
    echo '<br>Excepción capturada: ',  $e->getMessage(), "\n";
	$mycomp->Disconnect();
	echo "<br>DESCONECTADO";	
}





?>
