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
        
        //consultar datos de tutor por id_tutor
        if ($_SERVER['REQUEST_METHOD'] == 'GET'){
        if (isset($_GET['id_tutor'])) { 
        $sql = "SELECT * FROM tutor WHERE  id_tutor = '".$_GET['id_tutor']."'";
        $resultado = mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la   base de datos");
        $datos = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
        header("HTTP/1.1 200 OK");
        echo json_encode($datos);
        exit();
        }else{//consulta todos los datos de la tabla tutor
        $sql = "SELECT * FROM tutor";
        $resultado = mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la   base de datos");
        $datos = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
        header("HTTP/1.1 200 OK");
        echo json_encode($datos);
        }
}       //inserta daots en la tabla tutor mediante post
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $sql = "INSERT INTO tutor VALUES (NULL, '".$_POST[nombre]."', '".$_POST[appPat]."', '".$_POST[appMat]."', '".$_POST[id_alumno]."')";		  
        $resultado = mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la   base de datos en post");
        $datos = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
        header("HTTP/1.1 200 OK");
        echo json_encode($_POST);
        exit();
  }     //update a tabla tutor usando el id_tutor
        if ($_SERVER['REQUEST_METHOD'] == 'PUT'){
        $sql = "UPDATE tutor SET `nombre`='".$_GET[nombre]."',`appPat`='".$_GET[appPat]."', `appMat`='".$_GET[appMat]."', `id_alumno`='".$_GET[id_alumno]."' WHERE  `id_tutor`='".$_GET[id_tutor]."';";
        $resultado = mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la   base de datos put");
        $datos = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
        header("HTTP/1.1 200 OK");
        exit();
}       //delete tutor usando el id_tutor
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE'){
        $sql = "DELETE FROM tutor WHERE  `id_tutor`='".$_GET[id_tutor]."';";
        $resultado = mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la   base de datos delete");
        $datos = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
        header("HTTP/1.1 200 OK");
        exit();
}
header("HTTP/1.1 400 Peticion HTTP inexistente");
?>