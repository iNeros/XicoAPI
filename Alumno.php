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
        if (isset($_GET['AlumnosGrupo'])) { 
        $sql = "SELECT id_alumno , nombre , appPat , appMat FROM `alumno` WHERE id_grado = '".$_GET['AlumnosGrupo']."' ORDER BY id_alumno ASC";
        $resultado = mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la   base de datos");
        $datos = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
        header("HTTP/1.1 200 OK");
        echo json_encode($datos);
        exit();
        }if (isset($_GET['User'])) { 
        $sql = "SELECT * FROM alumno WHERE usuario = '".$_GET['User']."' AND contraseña = '".$_GET['Pass']."'";
        $resultado = mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la   base de datos");
        $datos = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
        header("HTTP/1.1 200 OK");
        echo json_encode($datos);
        exit();
        }if (isset($_GET['id_alumno'])) { 
        $sql = "SELECT * FROM alumno WHERE  id_alumno = '".$_GET['id_alumno']."'";
        $resultado = mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la   base de datos");
        $datos = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
        header("HTTP/1.1 200 OK");
        echo json_encode($datos);
        exit();
        }if (isset($_GET['Perfil'])) { 
        $sql = "SELECT CONCAT(alumno.nombre,' ',alumno.appPat,' ',alumno.appMat) NameA,documentos.curp_niño, alumno.fechaNac, grupo.grupo,concat(tutor.nombre,' ',tutor.appPat,' ',tutor.appMat) NameP FROM alumno,tutor,documentos,grupo WHERE (alumno.id_alumno='".$_GET['Perfil']."') and (tutor.id_alumno=alumno.id_alumno) AND (alumno.id_alumno=documentos.id_alumno) AND (alumno.id_grado=grupo.id_grupo);";
        $resultado = mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la   base de datos");
        $datos = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
        header("HTTP/1.1 200 OK");
        echo json_encode($datos);
        exit();
        }else{//consultar datos de todos los alumnos
        $sql = "SELECT * FROM alumno";
        $resultado = mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la   base de datos");
        $datos = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
        header("HTTP/1.1 200 OK");
        echo json_encode($datos);
        }
}       //inserta datos de alumno en la tabla alumno mediante post
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $usuario = $_POST[nombre].rand(10,99);
        $contraseña = rand(1000,9999);
        $sql = "INSERT INTO alumno VALUES (NULL,'".$_POST[nombre]."', '".$_POST[appPat]."', '".$_POST[appMat]."','".$_POST[fechaNac]."', '".$usuario."', '".$contraseña."','".$_POST[id_grado]."');";		  
        $resultado = mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la   base de datos en post");
        $datos = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
        header("HTTP/1.1 200 OK");
        echo json_encode($_POST);
        exit();
  }     //update a tabla alumno usando el id_alumno
        if ($_SERVER['REQUEST_METHOD'] == 'PUT'){
        $sql = "UPDATE alumno SET `nombre`='".$_GET[nombre]."',`appPat`='".$_GET[appPat]."', `appMat`='".$_GET[appMat]."',`fechaNac`='".$_GET[fechaNac]."', `usuario`='".$_GET[usuario]."', `contraseña`='".$_GET[contraseña]."', `id_grado`='".$_GET[id_grado]."' WHERE  `id_alumno`='".$_GET[id_alumno]."';";
        $resultado = mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la   base de datos put");
        $datos = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
        header("HTTP/1.1 200 OK");
        exit();
}       //delete alumno usando el id_alumno
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE'){
        $sql = "DELETE FROM alumno WHERE  `id_alumno`='".$_GET[id_alumno]."';";
        $resultado = mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la   base de datos delete");
        $datos = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
        header("HTTP/1.1 200 OK");
        exit();
}
header("HTTP/1.1 400 Peticion HTTP inexistente");
?>