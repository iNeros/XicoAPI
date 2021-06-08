<?php
	$usuario = "u377615737_xico_admin";
    $password = "1ProyectoXico";
    $servidor = "151.106.96.1";
    $basededatos = "u377615737_xico_class";
    $conexion = mysqli_connect( $servidor, $usuario, $password ) or die ("No se ha podido conectar al servidor de Base de datos");
    $db = mysqli_select_db( $conexion, $basededatos ) or die ( "Upps! Pues va a ser que no se ha podido conectar a la base de datos" ); 
?>