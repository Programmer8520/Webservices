<?php
$objeto_pdo=null;
$hostname='192.168.1.100';
$database='sipisa';
$username='root';
$password='58737217';



function conectar(){
    try {
        //Inicializamos el objeto PDO con los datos de nuestra base de datos y servidor como parametros
        $GLOBALS['objeto_pdo'] = new PDO("mysql:host=".$GLOBALS["hostname"].";dbname=".$GLOBALS["database"]."", $GLOBALS["username"], $GLOBALS["password"]);

        //Atribuimos algunos atributos a nuestro objeto
        $GLOBALS['objeto_pdo']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        //mensaje de correcta conexion
        //echo "CONECTADO A BASE DE DATOS<br>";
        //return $mbd;
    } catch (PDOException $e) {
        print "¡Error!: " . $e->getMessage() . "<br/>";
        die();
    }   
}


function desconectar() {

    //echo "DESCONECTADO DE LA BASE DE DATOS";
    $GLOBALS['objeto_pdo']=null;
}

function metodoGet($query){
    try{
        //conectar();
        $sentencia=$GLOBALS['objeto_pdo']->prepare($query);
        $sentencia->setFetchMode(PDO::FETCH_ASSOC);
        $sentencia->execute();
        desconectar();
        return $sentencia;
    }catch(Exception $e){
        die("Error: ".$e);
    }
}

function metodoPost($query, $queryAutoIncrement){
    try{
        conectar();
        $sentencia=$GLOBALS['objeto_pdo']->prepare($query);
        $sentencia->execute();
        $idAutoIncrement=metodoGet($queryAutoIncrement)->fetch(PDO::FETCH_ASSOC);
        $resultado=array_merge($idAutoIncrement, $_POST);
        $sentencia->closeCursor();
        desconectar();
        return $resultado;
    }catch(Exception $e){
        die("Error: ".$e);
    }
}


function metodoPut($query){
    try{
        conectar();
        $sentencia=$GLOBALS['objeto_pdo']->prepare($query);
        $sentencia->execute();
        $resultado=array_merge($_GET, $_POST);
        $sentencia->closeCursor();
        desconectar();
        return $resultado;
    }catch(Exception $e){
        die("Error: ".$e);
    }
}

function metodoDelete($query){
    try{
        //conectar();
        $sentencia=$GLOBALS['objeto_pdo']->prepare($query);
        $sentencia->execute();
        $sentencia->closeCursor();
        desconectar();
        return $_GET['id'];
    }catch(Exception $e){
        die("Error: ".$e);
    }
}

?>