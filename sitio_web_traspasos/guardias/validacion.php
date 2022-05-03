<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos/estilo_menu_opciones.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <title>Menú de Opciones</title>
</head>
<body class="bg-info">

<div class="mx-auto card border border-success shadow-lg" style="width: 80rem;"> 

<?php
//incluimos la biblioteca de conexion
include '../conexion_sipisa.php'; 

//obtenemos el username y la password mediante POST
$usuario = $_POST["userName"];
$contraseña = $_POST["password"];

//creamos el array contenedor de los datos del JSON y su respectivo contador
$empleado= array();
$i=0;

//declaramos el comando SQL que ayuda a validar y traer los datos en caso de que exista y que las credenciales sean correctas
$sql="  SELECT 
        log.login,
        log.pswd,
        rh.nombre AS empleado,
        rh.foto,
        dep.descripcion AS dep,
        log.email,
        log.active
        FROM
        ((SELECT 
            usrs.login, usrs.pswd, empl.numero_empleado, usrs.email,usrs.active
        FROM
            sec_users AS usrs
        LEFT JOIN tb_empleados AS empl ON usrs.login = CONVERT( empl.login USING UTF8)) UNION (SELECT 
            login, pswd, numero_empleado, email, active
        FROM
            tb_users_mobile)) AS log
            LEFT JOIN
        tb_empleados_rh AS rh ON rh.numero_empleado = log.numero_empleado
            LEFT JOIN
        tb_departamentos AS dep ON rh.id_departamento = dep.id_departamento
        WHERE
        log.login = '$usuario'
           AND log.pswd = '$contraseña'
        AND log.active = 'Y'";

//cremos el objeto contenedor de nuestro resultado de consulta
$resultado = mysqli_query($conexion, $sql);

    //validamos que la respuesta que nos dio contiene algun dato
    if (mysqli_num_rows($resultado) > 0)  {

    //comenzamos a recorrer mediante un WHILE los resultados que nos ayuda a obtener el objeto fetch_array
    while ($fila = mysqli_fetch_array($resultado)) {

        //$empleado[$i]["login"] =  $fila[0];
        //$empleado[$i]["pswd"] =  $fila[1];
        $empleado[$i]["empleado"] =  $fila[2];
        $empleado[$i]["foto"] =  $fila[3];
        $empleado[$i]["dep"] =  $fila[4];
        $empleado[$i]["email"] =  $fila[5];

        //header("192.168.1.100/programmer/guardias/index.php", TRUE, 301);

        if  ($fila[0] == $usuario && $fila[1] == $contraseña) {

            
            echo "<div class='rounded bg-primary'>
                    <img class='float-right bg-transparent' src='resources/logo.png' alt='logo_innovador' width='100' height='100'>
                    <h1 class='text-primary bg-light text-center'>Aplicacion WEB de Traspasos</h1><div><br>";
            echo "<h2 class='text-warning'>Cliente: ".$fila[2]."</h2>";
            ?>
                
                 
                    <br>
                    
                    <div class="panel-group">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" href="#expand">Menú de Opciones</a>
                        </h4>
                        </div>
                    </div>
                    
                        <div id="expand" class="panel-collapse collapse">

                        <div class="panel-footer"><a data-toggle="collapse" href="#expand_salida">Traspasos De Salida</a></div>
                            <div id="expand_salida" class="panel-collapse collapse">
                                <div class="panel-body"><a href="menu_opciones_1/?opcion=1&nombre=<?php echo $empleado[$i]["empleado"]?>" class="text-white">Inicar Traspaso</a></div>
                                <div class="panel-body"><a href="menu_opciones_1/?opcion=2&nombre=<?php echo $empleado[$i]["empleado"]?>" class="text-white">Recuperar Traspaso</a></div>
                            </div>

                        <div class="panel-footer"><a data-toggle="collapse" href="#expand_entrada">Traspasos De Entrada</a></div>
                            <div id="expand_entrada" class="panel-collapse collapse">
                                <div class="panel-body"><a href="menu_opciones_2/?opcion=1&nombre=<?php echo $empleado[$i]["empleado"]?>" class="text-white">Escanear Traspaso</a></div>
                                <div class="panel-body"><a href="menu_opciones_2/?opcion=2&nombre=<?php echo $empleado[$i]["empleado"]?>" class="text-white">Documentos por Cerrar</a></div>
                            </div>

                        <div class="panel-footer"><a data-toggle="collapse" href="#expand_inter">Seguimiento de Informacion</a></div>
                            <div id="expand_inter" class="panel-collapse collapse">
                                <div class="panel-body"><a href="menu_opciones_3/?opcion=1&nombre=<?php echo $empleado[$i]["empleado"]?>" class="text-white">Consultar Datos</a></div>
                            </div>
                        </div>
                    </div>  
                </div>

                        <!--Botones de configuracion
                            
                            Menu de configuracion donde se seleccionara lo que se puede visualizar y lo que no.
                        
                        -->
                    </div>
                </div>

                <form action="menu_opciones.php" method="POST">

                </form>

            </body>
            </html>
            
            
            
            <?php
        }else {

            echo "NO TIENE UN USUARIO REGISTRADO EN LA BASE DE DATOS, VAYA CON EL DEPARTAMENTO DE TI PARA ASIGNARLE UN USUARIO<br>";

        }


    }

    //echo json_encode($empleado);

    //con estos datos hay que redireccionar el sitio web a otra pagina que sera la que contendra el menu

    
}else {
    echo "<script>alert('Usuario No Valido, Ingrese sus credenciales correctamente')</script>";
}


?>
</div>
</body>
</html>