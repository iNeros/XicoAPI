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
        
        //consultar documentos de un niño en específico
        if ($_SERVER['REQUEST_METHOD'] == 'GET'){
        if (isset($_GET['id_documentos'])) { 
        $sql = "SELECT * FROM documentos WHERE  id_documentos = '".$_GET['id_documentos']."'";
        $resultado = mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la   base de datos");
        $datos = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
        header("HTTP/1.1 200 OK");
        echo json_encode($datos);
        exit();
        }else{//consultar documentos de todos los niños
        $sql = "SELECT * FROM documentos";
        $resultado = mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la   base de datos");
        $datos = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
        header("HTTP/1.1 200 OK");
        echo json_encode($datos);
        }
}       //inserta documentos en la tabla documento mediante post
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $sql = "INSERT INTO documentos VALUES (NULL,'".$_POST[curp_niño_ruta]."','".$_POST[curp_niño]."', '".$_POST[acta_niño]."', '".$_POST[nss_niño]."', '".$_POST[curp_padre]."', '".$_POST[acta_padre]."', '".$_POST[curp_madre]."', '".$_POST[acta_madre]."', '".$_POST[curp_tutor]."', '".$_POST[acta_tutor]."','".$_POST[id_alumno]."')";		  
        $resultado = mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la   base de datos en post");
        $datos = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
        header("HTTP/1.1 200 OK");
        echo json_encode($_POST);
        exit();
  }     //update a tabla documento usando el id_documentos
        if ($_SERVER['REQUEST_METHOD'] == 'PUT'){
        $sql = "UPDATE documentos SET `curp_niño_ruta`='".$_GET[curp_niño_ruta]."',`curp_niño`='".$_GET[curp_niño]."',`acta_niño`='".$_GET[acta_niño]."', `nss_niño`='".$_GET[nss_niño]."', `curp_padre`='".$_GET[curp_padre]."', `acta_padre`='".$_GET[acta_padre]."', `curp_madre`='".$_GET[curp_madre]."', `acta_madre`='".$_GET[acta_madre]."', `curp_tutor`='".$_GET[curp_tutor]."', `acta_tutor`='".$_GET[acta_tutor]."' WHERE  `id_documentos`='".$_GET[id_documentos]."';";
        $resultado = mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la   base de datos put");
        $datos = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
        header("HTTP/1.1 200 OK");
        exit();
}       //delete documento usando el id_documentos
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE'){
        $sql = "DELETE FROM documentos WHERE  `id_documentos`='".$_GET[id_documentos]."';";
        $resultado = mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la   base de datos delete");
        $datos = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
        header("HTTP/1.1 200 OK");
        exit();
}
header("HTTP/1.1 400 Peticion HTTP inexistente");
?>