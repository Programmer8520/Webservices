<?php

include '../../../conexion_sipisa.php';

function obtenerAlmacenes($conexion){

    $consulta_almacen ="SELECT tb_almacenes_sap.id_almacen 
                                ,tb_almacenes_sap.clave
                                ,tb_almacenes_sap.nombre
                        FROM 
                            sipisa.tb_almacenes_sap
                        WHERE
                            sipisa.tb_almacenes_sap.id_estatus =  90
                        ORDER BY
                            tb_almacenes_sap.nombre";
    $resultado = mysqli_query($conexion, $consulta_almacen);

    if (mysqli_num_rows($resultado) > 0){   
        while ($fila = mysqli_fetch_assoc($resultado)){

            echo '<option value="'.$fila["clave"].'">'.utf8_encode($fila["nombre"]).'</option>';
        }
    }else{
        echo "No se pudo completar la consulta de los almacenes";
    }

    //mysqli_close($conexion);

}

function obtenerLT($conexion){
    $comandoSQL = "SELECT
                     tb_transportistas.clave
                    ,tb_transportistas.nombre
                from 
                    sipisa.tb_transportistas
                join 
                    sipisa.tb_tipos on sipisa.tb_tipos.id_tipo = sipisa.tb_transportistas.id_tipo
                join 
                    sipisa.tb_estatus on sipisa.tb_estatus.id_estatus = sipisa.tb_transportistas.id_estatus
                where
                    sipisa.tb_transportistas.id_estatus = 60
                order by sipisa.tb_transportistas.nombre";
    $lineasT = mysqli_query($conexion, $comandoSQL);

    if(mysqli_num_rows($lineasT) > 0){
        while ($fila = mysqli_fetch_assoc($lineasT)){

            echo '<option value="'.$fila["clave"].'">'.utf8_encode($fila["nombre"]).'</option>';
        }

    }else {

        echo "No se encontraron las lineas de transporte";

    }

    //mysqli_close($conexion);
}

function obtenerConductoresLaroye($conexion){
    
    $comandoSQLL = "SELECT 
                        tb_nombres_operadores_laroye.id_operador,
                        tb_nombres_operadores_laroye.nombre_operador
                    FROM
                        sipisa.tb_nombres_operadores_laroye
                    WHERE
                        estatus = 1
                    ORDER BY
	                    tb_nombres_operadores_laroye.id_operador";
    $nombresLaroye = mysqli_query($conexion, $comandoSQLL);

    if (mysqli_num_rows($nombresLaroye) > 0) {
    
        while ($fila = mysqli_fetch_assoc($nombresLaroye)){
            
            echo '<option value="'.$fila["id_operador"].'">'.utf8_encode($fila["nombre_operador"]).'</option>';
        }

    }else {
        //echo "<script>alert(".mysqli_error($conexion).mysqli_errno($conexion).");</script>";
        //echo "<script>alert(0No se ejecuto la consulta por".mysqli_error($conexion).mysqli_errno($conexion).");</script>";
        echo '<option value="x">'.mysqli_error($conexion)."/".mysqli_errno($conexion).'</option>';    
    }

    mysqli_close($conexion);
    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos/estilo_menu_seleccion1.css">
    <link rel="stylesheet" href="estilos/botones_pro.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <title>Seleccion de Menú</title>
</head>
<body class="bg-warning">
    
<script>
    function obtenerNombreAnalista(){
        numero_empleado = $("#numero_analista").val();
        var parametros = 
        {
          "nEmpleado": numero_empleado
        };
        $.ajax(
        {
            data:  parametros,
            dataType: 'json',
            url: 'obtener_empleado.php',
            type: 'POST',
            beforeSend: function(){/*alert("enviando")*/;}, 
            error: function(){alert("Error");},
            complete: function(){/*alert("¡Listo!");*/},
            success:  function (nom) {
                //alert("nombre: " + nom.nombre)
                $("#nombre_analista").val(nom.nombre);
                $("#numero_montacarguista").focus();
            }
        }); 
    }

    function obtenerNombreMontacargas(){
        numero_empleado = $("#numero_montacarguista").val();
        var parametros = 
        {
          "nEmpleado": numero_empleado
        };
        $.ajax(
        {
            data:  parametros,
            dataType: 'json',
            url: 'obtener_empleado.php',
            type: 'POST',
            beforeSend: function(){/*alert("enviando")*/;}, 
            error: function(){alert("Error");},
            complete: function(){/*alert("¡Listo!");*/},
            success:  function (nom) {
                //alert("nombre: " + nom.nombre)
                $("#nombre_montacarguista").val(nom.nombre);
                $("#numero_guardia").focus();
            }
        }); 
    }

    function obtenerNombreGuardia(){
        numero_empleado = $("#numero_guardia").val();
        var parametros = 
        {
          "nEmpleado": numero_empleado
        };
        $.ajax(
        {
            data:  parametros,
            dataType: 'json',
            url: 'obtener_empleado.php',
            type: 'POST',
            beforeSend: function(){/*alert("enviando")*/;}, 
            error: function(){alert("Error");},
            complete: function(){/*alert("¡Listo!");*/},
            success:  function (nom) {
                //alert("nombre: " + nom.nombre)
                $("#nombre_guardia").val(nom.nombre);
            }
        }); 
    }

    function obtenerPlacas(){

        id_seleccion = document.getElementById("select_nt").value;
        //var id = document.getElementById("select_nt");
        //var contenido = id.options[id.selectedIndex].text;
        //console.log(contenido);
        var parametros = 
        {
          "id_operador": id_seleccion
        };
        $.ajax(
        {
            data:  parametros,
            dataType: 'json',
            url: 'obtener_placas.php',
            type: 'POST',
            beforeSend: function(){/*alert("enviando")*/;}, 
            error: function(){alert("Error");},
            complete: function(){/*alert("¡Listo!");*/},
            success:  function (dt) {
                //alert("nombre: " + nom.nombre)
                $("#placas_tractor").val(dt.placas_tractor);
                $("#placas_remolque").val(dt.placas_remolque);
            }
        }); 
    }

    function create_UUID(){
        var dt = new Date().getTime();
        var uuid = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
            var r = (dt + Math.random()*16)%16 | 0;
            dt = Math.floor(dt/16);
            return (c=='x' ? r :(r&0x3|0x8)).toString(16);
        });
        return uuid;
    }

    function insertarCabeceroCargaTPT(){
        const button = document.getElementById('btn_cabecero');

        id_seleccion = document.getElementById("select_nt").value;
        //var id = document.getElementById("select_nt");
        //var contenido = id.options[id.selectedIndex].text;

        uuid = create_UUID();
        bodega_origen = document.getElementById("almacen_origen").value;
        var b_o = document.getElementById("almacen_origen");
        bodega_origen_nombre = b_o.options[b_o.selectedIndex].text;
        
        bodega_destino = document.getElementById("almacen_destino").value;
        var b_d = document.getElementById("almacen_destino");
        bodega_destino_nombre = b_d.options[b_d.selectedIndex].text;

        cortina = document.getElementById("cortina").value;

        numero_analista = document.getElementById("numero_analista").value;
        numero_montacargas = document.getElementById("numero_montacarguista").value;
        numero_guardia = document.getElementById("numero_guardia").value;

        nombre_analista = document.getElementById("nombre_analista").value;
        nombre_montacargas = document.getElementById("nombre_montacarguista").value;
        nombre_guardia = document.getElementById("nombre_guardia").value;

        clave_lt = document.getElementById("select_lt").value;
        var c_lt = document.getElementById("select_lt");
        nombre_lt = c_lt.options[c_lt.selectedIndex].text;

        var n_con = document.getElementById("select_nt");
        nombre_conductor = n_con.options[n_con.selectedIndex].text;

        placas_tractor = document.getElementById("placas_tractor").value;
        placas_remolque = document.getElementById("placas_remolque").value;
        
        var parametros = 
        {
            "paramUUID": uuid,
            "paramBodegaOrigen": bodega_origen,
            "paramBodegaOrigenNombre": bodega_origen_nombre,
            "paramCortina": cortina,
            "paramBodegaDestino": bodega_destino,
            "paramBodegaDestinoNombre": bodega_destino_nombre,
            "paramNumeroMontacarguista": numero_montacargas,
            "paramNombreMontacarguista": nombre_montacargas,
            "paramNumeroAnalistaInventarios":numero_analista,
            "paramNombreAnalistaInventarios": nombre_analista,
            "paramNumeroGuardiaSeguridad": numero_guardia,
            "paramNombreGuardiaSeguridad": nombre_guardia,
            "paramClaveTransportista": clave_lt,
            "paramNombreTransportista": nombre_lt,
            "paramConductor": nombre_conductor,
            "paramPlacasTractor": placas_tractor,
            "paramPlacasRemolque": placas_remolque,
            "paramSellos": "SELLOS: ",
            "paramIdStatus": "200"
        };
        
        $.ajax({
            data:  parametros,
            dataType: 'json',
            url: 'insertar_cabecero_carga.php',
            type: 'POST',
            beforeSend: function(){/*alert("enviando")*/;}, 
            error: function(){alert("Error");},
            complete: function(){/*alert("¡Listo!");*/},
            success:  function (dt) {
                alert("Insertado correctamente con el id ->" + dt.id);
                button.disabled = true;
                var direccion = "escaneo/?uuid="+uuid;
                location.href = direccion;
                
            }   
        }); 
    }
    
</script>

<?php

if ($_GET["opcion"] == 1) 
{
    //secho "Opcion 1. Iniciar Traspaso";
    $nombre = $_GET["nombre"];
    ?>
    <div class="container bg-primary">
    <!--Se debe de programar un gernerador de Folio para que el Montacarguista pueda hacer click en la aplicacion de android
        y asi pueda comenzar con el ESCANEO siempre y cuando el guardia lo autorice
        -->

    <div class="jumbotron jumbotron-fluid  bg-secondary">
    
     <?php echo "<div>
     <img class='float-right bg-transparent' src='../../resources/logo.png' alt='logo_innovador' width='100' height='100'>
     <h1 class='display-4 text-center text-uppercase'>Bienvenido Al Formulario $nombre</h1></div>"; 
            //echo "<div class='bg-5'><h1 class='animated-shadow'>SOME TEXT</h1></div>"
     ?>

    </div>
        <h4 class="display-4 text-right">Menu dinamico. Favor de Llenar todos los campos.</h4>
        
        <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" href="#link1"  class="text-light bg-dark">Almacen</a></li>
          <li><a data-toggle="tab" href="#link2" class="text-light bg-dark">Personal</a></li>
          <li><a data-toggle="tab" href="#link3" class="text-light bg-dark">Transportista</a></li>
        </ul>

        <div class="tab-content">
            <div id="link1" class="tab-pane fade in active">
            
                <div class="form-group">
                <label for="almacen_origen">Almacen de Origen</label>
                <select class="form-control" id="almacen_origen">
                    <option value="0">Seleccione:</option>
                    <?php obtenerAlmacenes($conexion); ?>
                </select>
                </div>

                <div class="form-group">
                <label for="cortina">Seleccionar Cortina</label>
                <select class="form-control" id="cortina">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                </select>
                </div>

                <div class="form-group">
                <label for="almacen_destino">Almacen de Destino</label>
                <select class="form-control" id="almacen_destino">
                    <option value="0">Seleccione:</option>
                    <?php obtenerAlmacenes($conexion); ?>
                </select>
                </div>
            </div>
            <div id="link2" class="tab-pane fade">
                <div class="form-group">
                    <label for="numero_analista">Numero de Analista de Inventarios</label>
                    <input type="text" class="form-control" id="numero_analista" placeholder="Numero de Analista" onblur="obtenerNombreAnalista();">
                    <label for="nombre_analista">Nombre de Analista de Inventarios</label>
                    <input type="text" class="form-control" id="nombre_analista" placeholder="Nombre de Analista de Inventarios" value="">
                </div>

                <div class="form-group">
                    <label for="numero_montacarguista">Numero de Montacarguista</label>
                    <input type="text" class="form-control" id="numero_montacarguista" placeholder="Numero de Montacarguista" onblur="obtenerNombreMontacargas();">

                    <label for="nombre_montacarguista">Nombre de Montacarguista</label>
                    <input type="text" class="form-control" id="nombre_montacarguista" placeholder="Nombre de Montacarguista">
                </div>

                <div class="form-group">
                    <label for="numero_guardia">Numero de Guardia de Seguridad</label>
                    <input type="text" class="form-control" id="numero_guardia" placeholder="Numero de Guardia de Seguridad" onblur="obtenerNombreGuardia();">

                    <label for="nombre_guardia">Nombre de Guardia de Seguridad</label>
                    <input type="text" class="form-control" id="nombre_guardia" placeholder="Nombre de Guardia de Seguridad">
                </div>
            </div>
            <div id="link3" class="tab-pane fade">
                <div class="form-group">
                <label for="select_lt">Linea Transportista</label>
                <select class="form-control" id="select_lt">
                    <option value="1">Seleccionar:</option>
                    <?php obtenerLT($conexion); ?>
                </select>
                </div>

                <div class="form-group">
                    <label for="select_nt">Nombre del Conductor</label>
                    <select class="form-control" id="select_nt" onchange="obtenerPlacas();">
                        <option value="2">Seleccionar:</option>
                        <?php obtenerConductoresLaroye($conexion); ?>
                    </select>

                    <div class="form-group">
                        <label for="placas_tractor">Placas de Tractor</label>
                        <input type="text" class="form-control" id="placas_tractor" placeholder="Placas de Tractor">

                        <label for="placas_remolque">Placas de Remolque</label>
                        <input type="text" class="form-control" id="placas_remolque" placeholder="Placas de Remolque">
                    </div>
                </div>
                <button type="button" id="btn_cabecero" class="btn text-white bg-dark btn-block" onclick="insertarCabeceroCargaTPT();">GUARDAR PROGRESO</button>
            </div>
        </div>
    </div>
    <?php

}else
{
    echo "Opcion 2. Recuperar Traspaso";

    ?>
    <div style="width:100%;float:left;padding-bottom:0.5em">
          <div style="width:50%;float:left;">
               <select name="tipo" id="ddlTipoAlojamiento" style="width:50%" onchange="lista(this.value)">
                  <option value="0" selected="selected"></option>
                  <option value="1"></option>
                  <option value="2"></option>
                  <option value="3"></option>
                  <option value="4"></option>
                  <option value="5"></option>
                  <option value="6"></option>
              </select> 
          </div>
          <div style="width:80%;float:left;padding-bottom:0.5em">
                <select name="categoria" id="ddlCategoria" style="width:50%">
                  <option value="0" selected="selected">Todos...</option>
              </select> 
          </div>
    </div>

    
    
    
    
    
    <?php

}



?>