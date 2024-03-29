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
        
        //consultar datos de impreso usando id_impreso
        if ($_SERVER['REQUEST_METHOD'] == 'GET'){
        if (isset($_GET['periodoAsociado'])) {
            $sql = "SELECT periodo FROM grupo WHERE id_grupo = '".$_GET['periodoAsociado']."'";
            $resultado = mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la   base de datos");
            $periodo = mysqli_fetch_array($resultado);
          if ($periodo['periodo'] == '1'){   
            $sql = "SELECT * FROM impreso WHERE  periodoAsociado = '".$periodo['periodo']."' ORDER BY titulo";
            $resultado = mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la   base de datos");
            $datos = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
            header("HTTP/1.1 200 OK");
            echo json_encode($datos);
            exit();
          }
          if ($periodo['periodo'] == '2'){   
            $sql = "SELECT * FROM impreso WHERE  periodoAsociado = 1 UNION SELECT * FROM impreso WHERE periodoAsociado = '".$periodo['periodo']."' ORDER BY titulo";
            $resultado = mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la   base de datos");
            $datos = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
            header("HTTP/1.1 200 OK");
            echo json_encode($datos);
            exit();
          }
          if ($periodo['periodo'] == '3'){   
            $sql = "SELECT * FROM impreso ORDER BY titulo";
            $resultado = mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la   base de datos");
            $datos = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
            header("HTTP/1.1 200 OK");
            echo json_encode($datos);
            exit();
          }
        }else{//consultar todos los datos de la tabla impreso
          if (isset($_GET['id_impreso'])) {
            $sql = "SELECT * FROM impreso WHERE  id_impreso = '".$_GET['id_impreso']."'";
            $resultado = mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la   base de datos");
            $datos = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
            header("HTTP/1.1 200 OK");
            echo json_encode($datos);
            exit();
          }else{
            $sql = "SELECT * FROM impreso";
            $resultado = mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la   base de datos");
            $datos = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
            header("HTTP/1.1 200 OK");
            echo json_encode($datos);
          }
          
        }
}       //inserta datos en la tabla impreso mediante post
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $sql = "INSERT INTO impreso VALUES (NULL, '".$_POST[titulo]."', '".$_POST[ruta]."', '".$_POST[tipo]."','".$_POST[periodoAsociado]."')";		  
        $resultado = mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la   base de datos en post");
        $datos = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
        header("HTTP/1.1 200 OK");
        echo json_encode($_POST);
        exit();
  }     //update a tabla impreso usando el id_impreso
        if ($_SERVER['REQUEST_METHOD'] == 'PUT'){
        $sql = "UPDATE impreso SET `titulo`='".$_GET[titulo]."',`ruta`='".$_GET[ruta]."',`id_grupo`='".$_GET[id_grupo]."' WHERE  `id_impreso`='".$_GET[id_impreso]."';";
        $resultado = mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la   base de datos put");
        $datos = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
        header("HTTP/1.1 200 OK");
        exit();
}       //delete impreso usando el id_impreso
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE'){
        $sql = "DELETE FROM impreso WHERE  `id_impreso`='".$_GET[id_impreso]."';";
        $resultado = mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la   base de datos delete");
        $datos = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
        header("HTTP/1.1 200 OK");
        exit();
}
header("HTTP/1.1 400 Peticion HTTP inexistente");
?>