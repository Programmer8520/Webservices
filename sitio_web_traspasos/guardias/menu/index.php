<?php

include '../../conexion_sipisa.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilos/estilo_menu_opciones.css">
    <title>Menú de Opciones de Traspasos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
</head>
<body>
    
    <div class="container bg-secondary py-5">
        <h1>Menu de Opciones</h1>

        <!--Programacion de CARDS que hacen la funcionalidad de contener nuestros botones para las diferentes fuinciones que tiene el menu-->

        <div class="car">
            <div class="container">
                <?php echo '<h2 class="display-6 bg-primary h2 py-100">'.$_POST["name"].'</h2>'?>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="row justify-content-center">
            <div class="card me-3" style="width: 15rem;">
                <img src="../resources/escaneo_montacargas.png" class="card-img-top" alt="traspasos de montacarguistas">
                <!--<img src="../resources/aceptar.png" class="card-img-bottom">-->
                <div class="card-body">
                    <h5 class="card-title">Escaneo de Montacarguista</h5>
                    <p class="card-text">Dentro de este modulo, pueden llenar los datos necesarios para comenzar el     .</p>
                    <a href="menu_opciones_1/?opcion=1&nombre=<?php echo $_POST["name"]?>" class="btn btn-primary">Comenzar Escaneo</a>
                </div>
            </div>
            <div class="card me-3" style="width: 15rem;">
                <img src="../resources/busqueda1.png" class="card-img-top"  alt="recibo de tarimas escaneadaS">
                <!--<img src="../resources/aceptar.png" class="card-img-bottom">-->
                <div class="card-body">
                    <h5 class="card-title">Seguimiento de Traspasos</h5>
                    <p class="card-text">En este modulo pueden buscar toda la informacion relacionada con los traspasos.</p>
                    <a href="#" class="btn btn-primary">Buscar informacion</a>
                </div>
            </div>
            <div class="card me-3" style="width: 15rem;">
                <img src="../resources/aceptar.png" class="card-img-top" alt="seguimiento de traspasos, tablas de informaciónn y mas">
                <!--<img src="../resources/aceptar.png" class="card-img-bottom">-->
                <div class="card-body">
                    <h5 class="card-title">Entrada de Traspasos</h5>
                    <p class="card-text">El funcionamiento de este modulo, es mostrar las solicitudes que estan en proceso, para que sean cerradas.</p>
                    <a href="#" class="btn btn-primary">Dar Entrada a Traspasos</a>
                </div>
            </div>
            </div>
        </div>
        
    </div>

    
    
</body>
</html>