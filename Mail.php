<?php
//Así se solicita por GET.
//https://xicoclass.online/Mail.php?mail=ejemplo@gmail.com
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
if(isset($_GET['mail'])) {
        include('db/conopen2.php'); 
        $sql = "SELECT * FROM `docente` WHERE usuario = '".$_GET['mail']."';";
        $resultado2 = mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la   base de datos mail");
        $sql = mysqli_fetch_array($resultado2);
        if ($sql < 1){
        echo "¡El correo no existe!";
        }else{
        $from = "administradores@xicoclass.online";          
        $to = $_GET['mail'];
        $subject = "Recuperación de contraseña XicoClass";
        $message = "<html><body><table style='max-width: 600px; padding: 10px; margin:0 auto; border-collapse: collapse;'>
        <tr>
            <td style='background-color: #ecf0f1; text-align: left; padding: 0'>
                <a href='https://xicoclassproject-579bb.web.app/'>
                    <img width='100%' style='padding: 0; display: block' src='https://firebasestorage.googleapis.com/v0/b/xicoclassproject-579bb.appspot.com/o/ImagenesCorreo%2FRecuperas%20Contra.png?alt=media&token=d40b6542-724e-4b2b-b470-b2c34166526f'>
                </a>
            </td>
        </tr>
        
        <tr>
            <td style='background-color: #ecf0f1'>
                <div style='color: #34495e; margin: 4% 10% 2%; text-align: justify;font-family: sans-serif'>
                    <h2 style='color: #e67e22; margin: 0 0 7px'>Hola ".$sql['nombre']."!</h2>
                    <p style='margin: 2px; font-size: 15px'>
                    Recientemente solicitó saber la contraseña de su cuenta de XicoClass. Su contraseña es la siguiente:
                    <br><br>
                    <h4>".$sql['contraseña']."</h4>
                    <br><br>
                    Si no solicitó un restablecimiento de contraseña, ignore este correo electrónico o contáctenos para informarnos.<br>
                    Gracias, el <a href='https://xicoclass.firebaseapp.com/Equipo'>equipo de XicoClass</a>.</p>
                    <p style='color: #b3b3b3; font-size: 12px; text-align: center;margin: 30px 0 0'>XicoClass 2021</p>
                </div>
            </td>
        </tr>
    </table>
    </body><html>";
        $cabeceras = 'MIME-Version: 1.0' . "\r\n";
        $cabeceras = 'Content-type: text/html; charset=utf-8' . "\r\n";
        $cabeceras .= 'From:' . $from . "\r\n";
        mail($to,$subject,$message,$cabeceras);
        echo "¡Te hemos enviado un correo con tu contraseña!";
        exit();}
}if(isset($_GET['upuser'])) {
    include('db/conopen2.php'); 
    $sql = "UPDATE docente SET `tipoUsuario`= 1 WHERE  `usuario`='".$_GET['upuser']."';";
    mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la   base de datos tipo usuario update");
    header("Location: https://xicoclassproject-579bb.web.app/");
}
if(isset($_GET['confirmar'])){
        $from = "administradores@xicoclass.online";          
        $to = $_GET['mail1'];
        $subject = "Confirmación de registro docente XicoClass";
        $message = "<html><body><table style='max-width: 600px; padding: 10px; margin:0 auto; border-collapse: collapse;'>
        <tr>
            <td style='background-color: #ecf0f1; text-align: left; padding: 0'>
                <a href='https://xicoclassproject-579bb.web.app/'>
                    <img width='100%' style='padding: 0; display: block' src='https://firebasestorage.googleapis.com/v0/b/xicoclassproject-579bb.appspot.com/o/ImagenesCorreo%2FCorreos%20Confirmacion.png?alt=media&token=7cfa74cd-5d14-4120-b03a-ab1888178578'>
                </a>
            </td>
        </tr>
        
        <tr>
            <td style='background-color: #ecf0f1'>
                <div style='color: #34495e; margin: 4% 10% 2%; text-align: justify;font-family: sans-serif'>
                    <h2 style='color: #e67e22; margin: 0 0 7px'>¡Hola ".$_GET['confirmar']."!</h2>
                    <p style='margin: 2px; font-size: 15px'>
                    Para habilitar su cuenta y continuar, presione el botón para confirmar su cuenta en XicoClass
                    <br><br>
                    Haz click aquí. --> <a href='https://xicoclass.online/Mail.php?upuser=".$to."'>CONFIRMAR</a> <--
                    <br><br>
                    Si no solicitó un registro a XicoClass, ignore este correo electrónico o contáctenos para informarnos.<br>
                    Gracias, el <a href='https://xicoclass.firebaseapp.com/Equipo'>equipo de XicoClass</a>.</p>
                    <p style='color: #b3b3b3; font-size: 12px; text-align: center;margin: 30px 0 0'>XicoClass 2021</p>
                </div>
            </td>
        </tr>
    </table>
    </body><html>";
        $cabeceras = 'MIME-Version: 1.0' . "\r\n";
        $cabeceras = 'Content-type: text/html; charset=utf-8' . "\r\n";
        $cabeceras .= 'From:' . $from . "\r\n";
        mail($to,$subject,$message,$cabeceras);
        echo "¡Te hemos enviado un correo con tu contraseña!";
        exit();
}
if(isset($_GET['id_docente'])){ 
    $sql = "SELECT id_grupo from grupo where id_docente = '".$_GET['id_docente']."'";
    $resultado = mysqli_query($conexion,$sql) or die ( "Algo ha ido mal en la consulta a la   base de datos");
    while($grupo = mysqli_fetch_array($resultado)){
    $sqls = $sqls+" SELECT avisos.id_avisos,avisos.fecha,avisos.nombre,avisos.id_grupo from avisos where id_grupo = '".$grupo['id_grupo']."' UNION ";
  }
 // $resultado = mysqli_query($conexion,$sqls) or die ( "Algo ha ido mal en la consulta a la   base de datos avisos id_docente");
 // $datos = mysqli_fetch_all($resultado,MYSQLI_ASSOC);
  echo $sqls;
  echo "°°termina"
  //echo json_encode($datos);   
  }
?>