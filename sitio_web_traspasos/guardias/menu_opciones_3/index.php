<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos/estilo_menu_seleccion1.css">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <title>Seleccion de Menú</title>
</head>
<body>
    
</body>
</html>

<?php


if ($_GET["opcion"] == 1) {
    //echo "Opcion 1. Iniciar Traspaso";
    $nombre = $_GET["nombre"];
    ?>
    <form action="ingresarCabeceroCargarTPT.php" method="POST">
    <div class="container">


    <div class="jumbotron">
     <?php echo "<h1>Bienvenido Al Formulario $nombre</h1>"?>

    </div>
        <h4>Menu dinamico</h4>

        <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" href="#link1">Almacen</a></li>
          <li><a data-toggle="tab" href="#link2">Personal</a></li>
          <li><a data-toggle="tab" href="#link3">Transportista</a></li>
        </ul>

        <div class="tab-content">
            <div id="link1" class="tab-pane fade in active">
            
            <div class="form-group">
                <label for="sel">Almacen de Origen</label>
                <select class="form-control" id="sel">
                    <option>Nave 8</option>
                    <option>Nave 7</option>
                    <option>Nave 39</option>
                    <option>Nave 3</option>
                </select>
                </div>

                <div class="form-group">
                <label for="sel">Seleccionar Cortina</label>
                <select class="form-control" id="sel">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                </select>
                </div>

                <div class="form-group">
                <label for="sel">Almacen de Destino</label>
                <select class="form-control" id="sel">
                    <option>Nave 8</option>
                    <option>Nave 7</option>
                    <option>Nave 39</option>
                    <option>Nave 3</option>
                </select>
                </div>

                


            </div>
            <div id="link2" class="tab-pane fade">
                <div class="form-group">
                    <label for="usr">Numero de Analista de Inventarios</label>
                    <input type="text" class="form-control" id="numero_analista" placeholder="Numero de Analista">

                    <label for="usr">Nombre de Analista de Inventarios</label>
                    <input type="text" class="form-control" id="nombre_analista" placeholder="Nombre de Analista de Inventarios">
                </div>

                <div class="form-group">
                    <label for="usr">Numero de Montacarguista</label>
                    <input type="text" class="form-control" id="numero_analista" placeholder="Numero de Montacarguista">

                    <label for="usr">Nombre de Montacarguista</label>
                    <input type="text" class="form-control" id="nombre_analista" placeholder="Nombre de Montacarguista">
                </div>

                <div class="form-group">
                    <label for="usr">Numero de Guardia de Seguridad</label>
                    <input type="text" class="form-control" id="numero_analista" placeholder="Numero de Guardia de Seguridad">

                    <label for="usr">Nombre de Guardia de Seguridad</label>
                    <input type="text" class="form-control" id="nombre_analista" placeholder="Nombre de Guardia de Seguridad">
                </div>
            </div>
            <div id="link3" class="tab-pane fade">
                <div class="form-group">
                <label for="sel">Linea Transportista</label>
                <select class="form-control" id="sel">
                    <option>Linea 8</option>
                    <option>Linea 7</option>
                    <option>Linea 39</option>
                    <option>Linea 3</option>
                </select>
                </div>

                <div class="form-group">
                <label for="sel">Nombre del Conductor</label>
                <select class="form-control" id="sel">
                    <option>Conductor 8</option>
                    <option>Conductor 7</option>
                    <option>Conductor 39</option>
                    <option>Conductor 3</option>
                </select>
                </div>
            </div>
        </div>
    </div>
    </form>
    <?php

}else{
    echo "Opcion 2. Recuperar Traspaso";

    ?>  
    <?php

}



?>