
<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
require '../src/mailer/Exception.php';
require '../src/mailer/PHPMailer.php';
require '../src/mailer/SMTP.php';
require '../src/mailer/OAuth.php';

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//CONECTAR CON LA DB
include("connection.php");

    //PROCESO RESET BY SMS
    if(isset($_POST['phone'])){
        
        $phone = mysqli_real_escape_string($con,$_POST["phone"]);
         
        if(mysqli_num_rows(mysqli_query($con, "SELECT phone FROM users WHERE phone='$phone'")) > 0 ){ 
            $code = mt_rand(1000,9999);
            if(mysqli_query($con, "UPDATE users SET passcode='$code' WHERE phone='$phone'") ){ 
                sendCode('',$phone, $code); 
            }
        }else{
            echo "<script>
                        alert('El número móvil ingresado, no se encuentra en nuestas base de datos.');
                       location.reload();
                 </script>";  
        } 
        //PEOCESO RESET BY MAIL
    }
elseif(isset($_POST['email'])){
        $email = mysqli_real_escape_string($con,$_POST["email"]);

        if(mysqli_num_rows(mysqli_query($con, "SELECT phone FROM users WHERE email='$email'")) > 0 ){ 
            $code = mt_rand(1000,9999);
            if(mysqli_query($con, "UPDATE users SET passcode='$code' WHERE email='$email'") ){ 
                sendCode($email, '', $code);
            }
        }else{
            echo " <script>
                        alert('El correo electrónico ingresado, no se encuentra en nuestas base de datos');
                       location.reload();
                    </script>";  
        }
    }

function sendCode($email, $phone, $code){ 
    
            $mail = new PHPMailer(true);  
            
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
                $mail->setFrom('news@en4es.com', 'Account Manager (Spa)');
                
                if($email !=''){
                    $mail->Subject = 'Recuperar cuenta.'; 
                    $mail->addAddress($email); 
                    // Contenido del mensaje
                    $mail->isHTML(true);
                    $mail->Body = "<h3>Hola, Tu código de acceso es: <font color='red' size='+1.5'>$code</font></h3> <br><br> <p>Si no has solicitado el cambio de contraseña, te recomendamos que ingresa a tu cuenta y verifiques que todo está bien o cambie tu contraseña porque alguien más podría estar tratando de ingresar a tu cuenta. </p> <br><br>
                    <strong>Account Manager (Spa)</strong>";
                    $info_user = $email;
                }else{
                    //Destinatarios
                    $mail->addAddress("$phone@mms.att.net");                  //AT&T  MMS
                    $mail->addBCC("$phone@pm.sprint.com");                  //Sprint  MMS
                    $mail->addBCC("$phone@vzwpix.com"); 
                    // Contenido del mensaje
                    $mail->Body = "Hola, Tu código de acceso es: $code ";//Verizon MMS
                    $info_user = $phone;
                }

               try { 

                $mail->send(); ?>
                <form action="../admin/mng_staff.php" method="post">

                    <h1 class="title">CONFIRMAR SMS</h1>

                    <input type="hidden" name="recuperar_cuenta">
                    <input type="hidden" name="info_user" value="<?php echo $info_user; ?>">
                    <div class="inputs">                       
                        <label for="code">Confirme su código de 4 dígitos.</label>                        
                        <input type="text" maxlength="4" required name="code" placeholder="Ingresar el código">
                    </div>
                    <em>Te enviamos un código de 4 dígitos al siguiente destino: (<?php echo $info_user ?>).</em>
                    <button type="submit" class="btn red">Confirmar</button>
                </form>
                
                <?php 
    } catch (Exception $e) {
                echo "<body>
                        <script>
                            swal.fire({
                                icon: 'error',
                                title: 'Oops!',
                                text: 'NO se pudo enviar el código.',
                             }).then((result) =>{
                                if(result.isConfirmed){
                                    location.reload();
                                }
                             });
                       </script>
                   </body>";  
    }
        $mail->clearAddresses();
}?>



