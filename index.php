<?php

require 'flight/Flight.php';

Flight::register('db', 'PDO', array('mysql:host=localhost;dbname=api','root',''));

//Lee los datos y los muestra a cualquier interface que solicita dichos datos
Flight::route('GET /alumnos', function () {
    $sentencia= Flight::db()->prepare("SELECT * FROM `alumnos`");
    $sentencia->execute();
    $datos=$sentencia->fetchAll();
    Flight::json($datos);

});
//Recepciona los datos por metodo POST y hace una inserción
Flight::route('POST /alumnos', function () {
    
    $nombres= (Flight::request()->data->nombres);
    $apellidos= (Flight::request()->data->apellidos);

    $sql="INSERT INTO `alumnos` (nombres,apellidos) VALUES (?,?)";
    $sentencia= Flight::db()->prepare($sql);
    $sentencia->binParam(1,$nombres);
    $sentencia->binParam(2,$apellidos);
    $sentencia->execute();
    
    Flight::jsonp(["Alumno agregado"]);


});

Flight::start();
