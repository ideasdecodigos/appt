
<?php 
require '../src/mailer/Exception.php';
require '../src/mailer/PHPMailer.php';
require '../src/mailer/SMTP.php';
require '../src/mailer/OAuth.php';

// Import PHPMailer classes into the global namespace mostrar_sanes
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
 
session_start(); 
include("connection.php"); 
    //INSERTAR RESERVA
if(isset($_POST["date"]) && isset($_POST["hour"])){
        //DATOS PARA EL SMS POR EMAIL
        $address = mysqli_real_escape_string($con,$_POST["address"]);
        $business = mysqli_real_escape_string($con,$_POST["business"]);
        $employee = mysqli_real_escape_string($con,$_POST["employee"]);
        $businessPhone = mysqli_real_escape_string($con,$_POST["businessPhone"]);
    
        //DATOS PARA GUARDAR LA CITA
        $nombre = mysqli_real_escape_string($con,$_POST["name"]);
        $tel = mysqli_real_escape_string($con,$_POST["phone"]);
        $mensaje = mysqli_real_escape_string($con,$_POST["menssage"]);
        $appt = mysqli_real_escape_string($con,$_POST["date"]."T".$_POST["hour"]);
        $fehcActual = mysqli_real_escape_string($con,$_POST["currentDate"]);
        
        //CALCULA EL TIEMPO ESTIMADO
        $tiempoEstimado = mysqli_real_escape_string($con,$_POST["inputRange"]);
        
        if(isset($_POST['user']) && mysqli_real_escape_string($con,$_POST["user"])=="Anybody"){
            $user = mysqli_real_escape_string($con,$_SESSION["iduser"]);
        }elseif(isset($_POST['user'])){
            $user = mysqli_real_escape_string($con,$_POST["user"]);
        }else{
           $user = mysqli_real_escape_string($con,$_SESSION["iduser"]); 
        } 
        $well = mysqli_query($con, "INSERT INTO citas(cita,name,phone,menssage,userid,currentdate,tiempoEstimado)
        VALUES('$appt','$nombre','$tel','$mensaje','$user','$fehcActual','$tiempoEstimado')");
        
        if($well and $tel !=""){ sendConfirmati($appt,$tel,$employee,$business,$businessPhone,$address); } else{
         echo "<body>
                <script>
                    swal.fire({
                        icon: 'success',
                        title: 'Guardada!',
                        text: 'Se creó la cita correctamente.',
                        timer: 8000            
                     });
                   </script>
                </body>";    
        }
    
    mysqli_close($con); 
 } 
//EDITA EL TELEFONO DE LA RESERVA
elseif(isset($_POST["phoneEdit"])){
        //DATOS PARA EL SMS POR EMAIL
        $id = mysqli_real_escape_string($con,$_POST["idEdit"]);
        $tel = mysqli_real_escape_string($con,$_POST["phoneEdit"]);
        $sms = mysqli_real_escape_string($con,$_POST["smsEdit"]);
        
        mysqli_query($con, "UPDATE citas SET phone='$tel', menssage='$sms' WHERE id='$id'");        
    
    mysqli_close($con); 
 }

//INSERTAR SERVICIO 
elseif(isset($_POST["total"]) and isset($_POST['inptdate'])){
        $tipo = mysqli_real_escape_string($con,$_POST["tipo"]);
        $total = mysqli_real_escape_string($con,$_POST["total"]);
        $tip = mysqli_real_escape_string($con,$_POST["tip"]);
        $date = mysqli_real_escape_string($con,$_POST["inptdate"]);

        mysqli_query($con, "INSERT INTO account(total,tip,tipo,date,user)VALUES('$total','$tip','$tipo','$date','".$_SESSION['iduser']."')") ;
        mysqli_close($con);
    }
//VERIFICA EL TIEMPO ESTIMADO DE LA CITA
elseif(isset($_POST["validarCita"])){
    $date = mysqli_real_escape_string($con,$_POST["date"]);
    $time = mysqli_real_escape_string($con,$_POST["time"]);
    $tiempoEstimado=mysqli_real_escape_string($con,$_POST["inputRange"]);
    
    //CONCATENA LA FECHA Y LA HORA LOCAL
    $localDateTime = date($date." ".$time);
    $localTime1 = date("Y-m-d H:i",strtotime($localDateTime));
    //CREA UNA NUEVA FECHA LOCAL SUMANDOLE EL TIEMPO ESTIMADO DEL SERVICIO
    $localTime2 = date("Y-m-d H:i",strtotime($localDateTime." +$tiempoEstimado minutes"));
  
    $info="<font color='red'>Tiempo reservado por las siguientes citas:</font><hr>";
    $fech="";
    
    if(isset($_POST['iduser']) && $_POST['iduser']!=""){           
        $resultado = mysqli_query($con, "SELECT name,cita AS fechaInicial, DATE_ADD(cita, INTERVAL tiempoEstimado MINUTE)AS fechaFinal,tiempoEstimado FROM citas WHERE cita >= '$localTime1%' AND cita < '$localTime2% ' AND userid='".$_POST['iduser']."' ");    
     }
    elseif(strcasecmp($_SESSION['type'],"business")!=0){
         $resultado = mysqli_query($con, "SELECT name,cita AS fechaInicial, DATE_ADD(cita, INTERVAL tiempoEstimado MINUTE)AS fechaFinal,tiempoEstimado FROM citas WHERE (cita >= '$localTime1%' AND cita < '$localTime2%') or ( DATE_ADD(cita, INTERVAL tiempoEstimado MINUTE) > '$localTime1%' AND DATE_ADD(cita, INTERVAL tiempoEstimado MINUTE) < '$localTime2%') AND userid='".$_SESSION['iduser']."' ");          
    }
    else{
        $resultado = mysqli_query($con, "SELECT name,cita AS fechaInicial, DATE_ADD(cita, INTERVAL tiempoEstimado MINUTE)AS fechaFinal,tiempoEstimado FROM citas WHERE userid=40 AND cita >= '$localTime1%' AND cita < '$localTime2% ' AND userid='".$_SESSION['business']."' ");   
    }    
    
    echo "<font color='blue'>New appointment<br>". date("h:ia",strtotime($localTime1))." - ".date("h:ia",strtotime($localTime2))." </font><br>";
    
    if(mysqli_num_rows($resultado) > 0 ){ 
    while($fila=mysqli_fetch_array($resultado)){   
        
          $sqlTime1 = date("H:i",strtotime($fila['fechaInicial']));  
          $sqlTime2 = date("H:i",strtotime($fila['fechaFinal']));          
        
       $fech.="Con ".$fila['name']." de:<br><font class='icon-care' size='+1'> ". date("h:ia",strtotime($sqlTime1))." - ".date("h:ia",strtotime($sqlTime2))."</font><hr>";   
                
              } 
          } 
    if($fech!=""){
      echo $info."<font color='darkorange'>$fech</font>";   
    }
} 



function sendConfirmati($cita,$tel,$employee,$business,$businessPhone,$address){ 
    
            $mail = new PHPMailer(true);  
            try {
                //Server settings
                $mail->SMTPDebug = 0;                                       // Enable verbose debug output
                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host       = 'smtp.hostinger.com';                   // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = 'news@en4es.com';                    // SMTP username
                $mail->Password   = 'Juan4544642';                          // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

                //Recipients
                $mail->setFrom('news@en4es.com', 'Appt. Notification');
                //Destinatarios
                $mail->addAddress("$tel@mms.att.net");                  //AT&T  MMS
                $mail->addBCC("$tel@pm.sprint.com");                  //Sprint  MMS
                $mail->addBCC("$tel@vzwpix.com");                     //Verizon MMS

                // Contenido del mensaje
                $mail->Body = "Hi, you booked an appt with $employee for ".date("l, M j",strtotime($cita))." at ".date("h:ia",strtotime($cita))." ( $business | $businessPhone | $address ). Please, let us know if you wish reschedule or cancel.  Thanks for choosing us! For more info, visit: https://en4es.com/appt/app/appt.php?business=".str_replace(' ','%20',$business);

                $mail->send();
                echo "<body>
                <script>
                    swal.fire({
                        icon: 'success',
                        title: 'SMS Enviado!',
                        text: 'Se envió una confirmación SMS al cliente.',
                        timer: 8000            
                     });
                   </script>
                </body>"; 
            } catch (Exception $e) {
                echo "<body>
                        <script>
                            swal.fire({
                                icon: 'error',
                                title: 'Oops!',
                                text: 'La confirmación SMS NO se pudo enviar.',
                                timer: 8000            
                             });
                       </script>
                   </body>";  
            }
        $mail->clearAddresses();
}?>
