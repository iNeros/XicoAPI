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
        
        //consultar archivos de una actividad usando id_actividades
        if ($_SERVER['REQUEST_METHOD'] == 'GET'){
        if (isset($_GET['id_actividades'])) { 
        $sql = "SELECT * FROM archivos_docentes WHERE  id_actividades = '".$_GET['id_actividades']."' ORDER BY id_archivo desc";
        $resultado = mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la   base de datos");
        $datos = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
        header("HTTP/1.1 200 OK");
        echo json_encode($datos);
        exit();
        }if (isset($_GET['nombre'])) { 
        //$token = $_GET['ruta']."&token=".$_GET['token'];
        $url = mysqli_real_escape_string( urlencode("https://firebasestorage.googleapis.com/v0/b/xicoclassproject-579bb.appspot.com/o/ArchivosDocentes%2F101%2FERRORES%20NERO.txt?alt=media&token=905123f1-33ad-47c6-8277-b7dd6fad2396") );
        $sql = "INSERT INTO archivos_docentes VALUES (NULL, '".$_GET['nombre']."', '".$url."', '".$_GET['tipo']."', '".$_GET['id_actividades1']."')";		  
        $resultado = mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la base de datos");
        $datos = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
        header("HTTP/1.1 200 OK");
        echo json_encode($datos);
        exit();
        }else{//consultar archivos de todos los maestros
        $sql = "SELECT * FROM archivos_docentes ORDER BY id_archivo desc";
        $resultado = mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la   base de datos");
        $datos = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
        header("HTTP/1.1 200 OK");
        echo json_encode($datos);
        exit();
        }
}       //inserta archivos en la tabla archivos mediante post
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        //$token = $_POST[ruta]."&token=".$_POST[token];
        $url = mysqli_real_escape_string( urlencode('".$_POST['ruta']."'));
        $sql = "INSERT INTO archivos_docentes VALUES (NULL, '".$_POST[nombre]."', '".$url."', '".$_POST[tipo]."', '".$_POST[id_actividades]."')";		  
        $resultado = mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la   base de datos en post 1");
        $datos = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
        header("HTTP/1.1 200 OK");
        echo json_encode($_POST);
        exit();
  }     //update a tabla archivos usando el id_archivo
        if ($_SERVER['REQUEST_METHOD'] == 'PUT'){
        $sql = "UPDATE archivos_docentes SET `nombre`='".$_GET[nombre]."',`ruta`='".$_GET[ruta]."', `tipo`='".$_GET[tipo]."' WHERE  `id_archivo`='".$_GET[id_archivo]."';";
        $resultado = mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la   base de datos put");
        $datos = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
        header("HTTP/1.1 200 OK");
        exit();
}       //delete archivo usando el id_archivo
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE'){
        $sql = "DELETE FROM archivos_docentes WHERE  `id_archivo`='".$_GET[id_archivo]."';";
        $resultado = mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la   base de datos delete");
        $datos = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
        header("HTTP/1.1 200 OK");
        exit();
}
header("HTTP/1.1 400 Peticion HTTP inexistente");
?>