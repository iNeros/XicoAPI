<?php
//Cabeceras
header('Content-Type: application/json');
function permisos() {  
  if (isset($_SERVER['HTTP_ORIGIN'])){
      header("Access-Control-Allow-Origin: *");
      header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
      header("Access-Control-Allow-Headers: Origin, Authorization, X-Requested-With, Content-Type, Accept");
      header('Access-Control-Allow-Credentials: true');      
  }  
  if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))          
        header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: Origin, Authorization, X-Requested-With, Content-Type, Accept");
    exit(0);
  }
}
        permisos();

        include('db/conopen2.php'); 
        
        //consultar actividades de tal maestro
        if ($_SERVER['REQUEST_METHOD'] == 'GET'){
        if (isset($_GET['id_grado'])) { 
        $sql = "SELECT * FROM actividades WHERE  id_grado = '".$_GET['id_grado']."' ORDER BY id_actividad desc";
        $resultado = mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la   base de datos");
        $datos = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
        header("HTTP/1.1 200 OK");
        echo json_encode($datos);
        exit();
        }else{//consultar actividades de todos los maestros
        $sql = "SELECT * FROM actividades ORDER BY id_actividad desc";
        $resultado = mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la   base de datos");
        $datos = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
        header("HTTP/1.1 200 OK");
        echo json_encode($datos);
        }
}       //inserta actividades en la tabla actividades mediante post
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $sql = "INSERT INTO actividades VALUES ('".$_POST[nombre]."', '".$_POST[descripcion]."','".$_POST[fecha_inicio]."','".$_POST[fecha_fin]."','".$_POST[estado]."', '".$_POST[id_docente]."', '".$_POST[id_grupo]."')";		  
        $resultado = mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la   base de datos en post");
        $datos = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
        header("HTTP/1.1 200 OK");
        echo json_encode($_POST);
        exit();
  }     //update a tabla actividades usando el id_actividad
        if ($_SERVER['REQUEST_METHOD'] == 'PUT'){
        $sql = "UPDATE actividades SET `nombre`='".$_GET[nombre]."',`descripcion`='".$_GET[descripcion]."',`fecha_inicio`='".$_GET[fecha_inicio]."',`fecha_fin`='".$_GET[fecha_fin]."', `estado`='".$_GET[estado]."',`id_grupo`='".$_GET[id_grupo]."' WHERE  `id_actividad`='".$_GET[id_actividad]."';";
        $resultado = mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la   base de datos put");
        $datos = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
        header("HTTP/1.1 200 OK");
        exit();
}       //delete actividad usando el id_actividad
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE'){
        $sql = "DELETE FROM actividades WHERE  `id_actividad`='".$_GET[id_actividad]."';";
        $resultado = mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la   base de datos delete");
        $datos = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
        header("HTTP/1.1 200 OK");
        exit();
}
header("HTTP/1.1 400 Peticion HTTP inexistente");
?>