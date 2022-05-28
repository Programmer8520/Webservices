<?php
//incluimos la biblioteca de conexion
include '../../conexion_sipisa.php'; 

//obtenemos el username y la password mediante POST
$usuario = $_POST["userName"];
$contraseña = $_POST["password"];

//$usuario = $_GET["userName"];
//$contraseña = $_GET["password"];

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
        
        $empleado["empleado"] =  $fila[2];
        $empleado["foto"] =  $fila[3];
        $empleado["dep"] =  $fila[4];
        $empleado["email"] =  $fila[5];

        //header("192.168.1.100/programmer/guardias/index.php", TRUE, 301);

        if  ($fila[0] == $usuario && $fila[1] == $contraseña) {

            $empleado["validado"] = "SI";
        /*echo "<div class='rounded bg-primary'>
                <img class='float-right bg-transparent' src='resources/logo.    png'alt='logo_innovador' width='100' height='100'>
                <h1 class='text-primary bg-light text-center'>Aplicacion WEB de     Traspasos<h1><div><br>";
        echo "<h2 class='text-warning'>Cliente: ".."</h2>";*/

        //echo $fila[5];
        }else {
            $empleado["validado"] = "NO";
        }
        echo json_encode($empleado);
    }
}
?>