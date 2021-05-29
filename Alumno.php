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
        
        //consultar datos del alumno por id_alumno
        if ($_SERVER['REQUEST_METHOD'] == 'GET'){
        if (isset($_GET['id_alumno'])) { 
        $sql = "SELECT * FROM alumno WHERE  id_alumno = '".$_GET['id_alumno']."'";
        $resultado = mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la   base de datos");
        $datos = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
        header("HTTP/1.1 200 OK");
        echo json_encode($datos);
        exit();
        }else{//consultar datos de todos los alumnos
        $sql = "SELECT * FROM alumnos";
        $resultado = mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la   base de datos");
        $datos = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
        header("HTTP/1.1 200 OK");
        echo json_encode($datos);
        }
}       //inserta datos de alumno en la tabla alumno mediante post
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $sql = "INSERT INTO alumnos VALUES ('".$_POST[id_alumno]."', '".$_POST[nombre]."', '".$_POST[appPat]."', '".$_POST[appMat]."', '".$_POST[usuario]."', '".$_POST[contraseña]."', '".$_POST[id_grado]."', '".$_POST[id_tutor]."', '".$_POST[id_documentos]."')";		  
        $resultado = mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la   base de datos en post");
        $datos = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
        header("HTTP/1.1 200 OK");
        echo json_encode($_POST);
        exit();
  }     //update a tabla alumno usando el id_alumno
        if ($_SERVER['REQUEST_METHOD'] == 'PUT'){
        $sql = "UPDATE alumnos SET `nombre`='".$_GET[nombre]."',`appPat`='".$_GET[appPat]."', `appMat`='".$_GET[appMat]."', `usuario`='".$_GET[usuario]."', `contraseña`='".$_GET[contraseña]."', `id_grado`='".$_GET[id_grado]."', `id_tutor`='".$_GET[id_tutor]."', `id_documentos`='".$_GET[id_documentos]."' WHERE  `id_alumno`='".$_GET[id_alumno]."';";
        $resultado = mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la   base de datos put");
        $datos = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
        header("HTTP/1.1 200 OK");
        exit();
}       //delete alumno usando el id_alumno
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE'){
        $sql = "DELETE FROM alumnos WHERE  `id_alumno`='".$_GET[id_alumno]."';";
        $resultado = mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la   base de datos delete");
        $datos = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
        header("HTTP/1.1 200 OK");
        exit();
}
header("HTTP/1.1 400 Peticion HTTP inexistente");
?>