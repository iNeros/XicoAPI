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
        
        //consultar avisos por dia, semana o meses, usando id_grado
        if ($_SERVER['REQUEST_METHOD'] == 'GET'){
        if($_GET['tiempo']=='1'){
        $fecha_actual = date("Y-m-d",strtotime($fecha_actual."- 5 hour"));
        $sql = "SELECT * FROM avisos WHERE fecha BETWEEN '".$fecha_actual."' and DATE_ADD(sysdate(), INTERVAL -5 HOUR) AND id_grupo = '".$_GET['id_grupo']."'ORDER BY id_avisos desc";
        $resultado = mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la   base de datos");
        $datos = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
        header("HTTP/1.1 200 OK");
        echo json_encode($datos);
        exit();
        }if($_GET['tiempo']=='2'){
        $fecha_actual = date("Y-m-d",strtotime($fecha_actual."- 7 days"));
        $fecha_actual = date("Y-m-d",strtotime($fecha_actual."- 5 hour"));
        $fecha_actual1 = date("Y-m-d"); 
        $fecha_actual1 = date("Y-m-d",strtotime($fecha_actual1."- 5 hour"));
        $sql = "SELECT * FROM avisos WHERE fecha BETWEEN '".$fecha_actual."' and '".$fecha_actual1."' AND id_grupo = '".$_GET['id_grupo']."'ORDER BY id_avisos desc";
        $resultado = mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la   base de datos");
        $datos = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
        header("HTTP/1.1 200 OK");
        echo json_encode($datos);
        exit();
        }if($_GET['tiempo']=='3'){
        $fecha_actual = date("Y-m-d",strtotime($fecha_actual."- 7 days"));
        $fecha_actual = date("Y-m-d",strtotime($fecha_actual."- 5 hour"));  
        $sql = "SELECT * FROM avisos WHERE fecha < '".$fecha_actual."' AND id_grupo = '".$_GET['id_grupo']."'ORDER BY id_avisos desc";
        $resultado = mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la   base de datos");
        $datos = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
        header("HTTP/1.1 200 OK");
        echo json_encode($datos); 
        exit();}
        if(isset($_GET['id_docente'])){ 
          $sql = "SELECT id_grupo from grupo where id_docente = '".$_GET['id_docente']."'";
          $resultado = mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la   base de datos");
          $grupo = mysqli_fetch_array($resultado);
        while($grupo){
          $sqls = $sqls+"SELECT avisos.id_avisos,avisos.fecha,avisos.nombre,avisos.id_grupo from avisos where id_grupo = '".$grupo["id_grupo"]."' UNION";
        }
        $resultado = mysqli_query($conexion,$sqls) or die ( "Algo ha ido mal en la consulta a la   base de datos avisos id_docente");
        $datos = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
        header("HTTP/1.1 200 OK");
        echo json_encode($datos); 
        exit();   
        }if(isset($_GET['id_avisos'])){ 
        $sql = "SELECT * from avisos where id_avisos = '".$_GET['id_avisos']."'";
        $resultado = mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la   base de datos");
        $datos = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
        header("HTTP/1.1 200 OK");
        echo json_encode($datos); 
        exit();}
        else{//consultar avisos de todos los maestros
        $sql = "SELECT * FROM avisos ORDER BY id_avisos desc";
        $resultado = mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la   base de datos");
        $datos = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
        header("HTTP/1.1 200 OK");
        echo json_encode($datos);
        }
}       //inserta avisos en la tabla avisos mediante post
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $sql = "INSERT INTO avisos VALUES (NULL, '".$_POST[nombre]."', '".$_POST[descripcion]."', '".$_POST[ruta_archivo]."', '".$_POST[fecha]."', '".$_POST[urls]."', '".$_POST[id_grupo]."')";		  
        $resultado = mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la   base de datos en post");
        $datos = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
        header("HTTP/1.1 200 OK");
        echo json_encode($_POST);
        exit();
  }     //update a tabla avisos usando el id_avisos
        if ($_SERVER['REQUEST_METHOD'] == 'PUT'){
        $sql = "UPDATE avisos SET `nombre`='".$_GET[nombre]."',`descripcion`='".$_GET[descripcion]."', `ruta_archivo`='".$_GET[ruta_archivo]."', `urls`='".$_GET[urls]."', `id_grupo`='".$_GET[id_grupo]."', WHERE  `id_avisos`='".$_GET[id_avisos]."';";
        $resultado = mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la   base de datos put");
        $datos = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
        header("HTTP/1.1 200 OK");
        exit();
}       //delete avisos usando en id_avisos
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE'){
        $sql = "DELETE FROM avisos WHERE  `id_avisos`='".$_GET[id_avisos]."';";
        $resultado = mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la   base de datos delete");
        $datos = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
        header("HTTP/1.1 200 OK");
        exit();
}
header("HTTP/1.1 400 Peticion HTTP inexistente");  
?>