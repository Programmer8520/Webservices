<?php

include '../../../../conexion_sipisa.php';

if (isset($_GET["uuid"])){
    $valor =  $_GET["uuid"];

    function obtenerID($conexion, $uuid){

        $sql = "SELECT cabecero_carga_tpt_id FROM tb_cabecero_carga_tpt WHERE uuid_cabecero_carga_tpt = '$uuid'";

        $consulta = mysqli_query($conexion, $sql);

        if (mysqli_num_rows($consulta) > 0) {   
            
            $fila = mysqli_fetch_array($consulta);
            echo $fila[0];
        }else {
            echo "No existe registro para esa Clave Unica";
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEGUIMIENTO DE ESCANEO</title>

    <link rel="stylesheet" href="../../../estilos/es_escaneo.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    

</head>
<body>

<script>

    window.onload = function (){ 
        temporizadorDeActualizacion();
    }    

    function obtenerActualizacionDeAvance() {   
                
        var parametros = 
        {
            "uuid" : getParameterByName()
        };

        $.ajax(
        {
            data : parametros,
            dataType : 'TEXT',
            url : 'resumenDeTarimasEsperadas.php',
            type : 'POST',
            beforeSend : function() {

            },
            error : function() {
                console.log("Favor de verificar el Comando de conexion");
            },
            complete : function() {
                //alert("Consultando Progreso");
                console.log("peticion resumen");
            },
            success : function(valores) {

                console.log(valores);

                if (valores == "la consulta no dio datos") {

                    $("#textarea").text("NO HAY DATOS"); 

                }else if (valores.length == 6) {
                    alert("Su numero de Documento ES: " + valores);

                    //Ahora nos tiene que redireccionar con el numero de documento

                    var direccion = "documento_sap.php?uuid="+getParameterByName();
                    location.href = direccion;

                    //A la hora que detecta que el documento SAP esta generado se debe de parar el Repetidor
                }
                else {

                    $("#textarea").text(valores);
                    
                    $("#table_resumen_general").html(valores);

                }

            }
        });
    }

    function obtenerActualizacionPorTarima() {   
                
        var parametros = 
        {
            "uuid" : getParameterByName()
        };

        $.ajax(
        {
            data : parametros,
            dataType : 'TEXT',
            url : 'tablaDeTarimasIndividual.php',
            type : 'POST',
            beforeSend : function() {

            },
            error : function() {
                console.log("Favor de verificar el Comando de conexion");
            },
            complete : function() {
                console.log("peticion detallado");
            },
            success : function(valores) {

                console.log(valores);

                if (valores == "la consulta no dio datos") {

                    $("#textarea").text("NO HAY DATOS"); 

                }
                else {

                    //$("#textarea").text(valores);
                    
                    $("#table_resumen_individual").html(valores);

                    checkbox = document.getElementById('1')
                    checkbox.checked = eval(window.localStorage.getItem(checkbox.id))

                    checkbox.addEventListener('change', function(){
                    window.localStorage.setItem(checkbox.id, checkbox.checked)
                    })
                }

            }
        });
    }

    function temporizadorDeActualizacion () {

        setInterval(obtenerActualizacionDeAvance, 10000);
        setInterval(obtenerActualizacionPorTarima, 10000);
        
    }

    function getParameterByName() {
        const valores = window.location.search.substr(6);
 
        return valores;
    }
</script>
    <div class="container">
        <div class="bg-transparent">
            <img class='float-right bg-transparent' src='../../../resources/logo.png' alt='logo_innovador' width='100' height='100'>    
            <h1 class="display-1">ESCANEO DE TARIMAS</h1>
            
            <h3 id="folio" class="my-4">Folio: <?php obtenerID($conexion, $valor); ?> </h3>
        </div>
        <!--<textarea class="shadow-lg text-center" id="textarea" rows="15" cols="55" disabled></textarea>-->
        <div id="table_resumen_general">
        </div>
        <div id="table_resumen_individual">
        </div>
        
    </div>

<?php

}else {
    echo "no se envio nada";
}
?>

</body>
</html>