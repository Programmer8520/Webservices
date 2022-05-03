<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos/estilo_menu_seleccion1.css">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <title>Seleccion de Menú</title>
</head>
<body>
    
<?php

if ($_GET["opcion"] == 1) {
    echo "Opcion 1. Recibir Traspaso";
    $nombre = $_GET["nombre"];
    ?>
    
    <div class="container bg-primary">
        <div class="jumbotron jumbotron-fluid  bg-secondary">
            <?php echo "
            <div>
                <img class='float-right bg-transparent' src='../resources/logo.png' alt='logo_innovador' width='100' height='100'>
                <h1 class='display-6 text-center text-uppercase'>Bienvenido. $nombre</h1>
            </div>";?>
        </div>

        <div class="container bg-success">
            <p class="text-dark float-right">
                Lorem ipsum dolor sit, amet consectetur adipisicing elit. Accusamus, iusto minus eligendi fugit sunt dignissimos? Veniam tenetur officia adipisci praesentium eligendi beatae. Ab possimus perferendis repellat deserunt aspernatur nemo eveniet.
            </p>
            <p class="text-primary float-left">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt minus nulla blanditiis vel itaque, reprehenderit natus assumenda tenetur. Dignissimos amet corrupti nihil laboriosam numquam eaque maxime, commodi quaerat exercitationem pariatur.

                Lorem ipsum dolor sit amet consectetur, adipisicing elit. Assumenda rerum quis ratione autem. Omnis atque delectus magni dignissimos aut saepe fugit in, excepturi quo exercitationem eos vitae sed quis autem.

                Lorem ipsum, dolor sit amet consectetur adipisicing elit. Illo facere, nam similique sint laudantium ad doloremque quasi quae atque alias repudiandae consectetur totam dolores, qui neque beatae sapiente quos repellendus.
            </p>
        </div>
    </div>

    <div>

    </div>
<?php
}else{
    echo "Opcion 2. Recuperar Traspaso";
    ?>

    <!--Contenido HTML-->
    

<?php
}
?>

</body>
</html>