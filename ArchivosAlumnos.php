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
        
        //consultar todos los archivos de un alumno en especifico
        if ($_SERVER['REQUEST_METHOD'] == 'GET'){
        if (isset($_GET['id_alumno'])) { 
        $sql = "SELECT * FROM archivos_alumnos WHERE  id_alumno = '".$_GET['id_alumno']."' ORDER BY id_archivos_alumnos desc";
        $resultado = mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la   base de datos");
        $datos = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
        header("HTTP/1.1 200 OK");
        echo json_encode($datos);
        exit();
        }else{//consultar archivos de todos los alumnos
        $sql = "SELECT * FROM archivos_alumnos ORDER BY id_archivos_alumnos desc";
        $resultado = mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la   base de datos");
        $datos = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
        header("HTTP/1.1 200 OK");
        echo json_encode($datos);
        }
}       //inserta archivos de alumnos en la tabla archivos_alumnos mediante post
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $sql = "INSERT INTO archivos_alumnos VALUES (NULL, '".$_POST[nombre]."', '".$_POST[ruta]."',NULL,'".$_POST[id_alumno]."', '".$_POST[id_actividad]."')";		  
        $resultado = mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la   base de datos en post");
        $datos = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
        header("HTTP/1.1 200 OK");
        echo json_encode($_POST);
        exit();
  }     //update a tabla archivos_alumnos usando el id_archivos_alumnos
        if ($_SERVER['REQUEST_METHOD'] == 'PUT'){
        $sql = "UPDATE archivos_alumnos SET `nombre`='".$_GET[nombre]."',`ruta`='".$_GET[ruta]."',`calificacion`='".$_GET[calificacion]."' WHERE  `id_archivos_alumnos`='".$_GET[id_archivos_alumnos]."';";
        $resultado = mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la   base de datos put");
        $datos = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
        header("HTTP/1.1 200 OK");
        exit();
}       //delete archivos alumnos usando el id_archivos_alumnos
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE'){
        $sql = "DELETE FROM archivos_alumnos WHERE  `id_archivos_alumnos`='".$_GET[id_archivos_alumnos]."';";
        $resultado = mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la   base de datos delete");
        $datos = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
        header("HTTP/1.1 200 OK");
        exit();
}
header("HTTP/1.1 400 Peticion HTTP inexistente");
?>