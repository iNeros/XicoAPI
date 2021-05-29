<?php
    echo "prueba";
    include('db/conopen2.php'); 
    $sql = "SELECT * FROM `alumno` WHERE usuario = '".$_POST['usuario']."' and contraseña = '".$_POST['contraseña']."';";
    $resultado = mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la   base de datos");
    $consulta = mysqli_fetch_array($resultado);
    if ($consulta < 1) 
    {
    echo "<script>
          Swal.fire({
        type: 'error',
        title: 'Error de inicio de sesión',
        text:'¡Verifíque sus datos!',      
    });
           </script>";
    }else{
      session_start();
      $_SESSION['nombre']=$consulta['nombre'];
      $_SESSION['id_grado']=$consulta['id_grado'];
      $_SESSION['id_documentos']=$consulta['id_documentos'];
    }	
?>