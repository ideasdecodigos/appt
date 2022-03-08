<?php 
require '../src/mailer/Exception.php';
require '../src/mailer/PHPMailer.php';
require '../src/mailer/SMTP.php';
require '../src/mailer/OAuth.php';

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

session_start(); 
include("connection.php"); 

//VERIFICA USER ESISTE
if(isset($_POST["validar"])){
    $inputVal = mysqli_real_escape_string($con,$_POST["inputVal"]);
     if($_POST['name']=="business"){
        if(mysqli_num_rows(mysqli_query($con, "SELECT business FROM users WHERE business='$inputVal' AND type='business'")) > 0 ){
          echo "<font color='red' class='icon-smiley-frown'> El negocio: ($inputVal) ya está registrado.</font>";
        }else{
        echo " <font color='darkgreen' class='icon-smile'> Correcto!</font>";
     }
    }
    elseif($_POST['name']=='user'){
        if(mysqli_num_rows(mysqli_query($con, "SELECT user FROM users WHERE user='$inputVal'")) > 0 ){
          echo "<font color='red' class='icon-smiley-frown'> El usuario: ($inputVal) ya existe, agréguele números o inténtelo con otro diferente.</font>";
        }else{
            echo " <font color='darkgreen' class='icon-smile'> Correcto!</font>";
        }
    }
    elseif($_POST['name']=='correo'){
        if(mysqli_num_rows(mysqli_query($con, "SELECT email FROM users WHERE email='$inputVal'")) > 0 ){
          echo "<font color='red' class='icon-smiley-frown'> El correo: ($inputVal) ya existe!</font>";
        }else{
            echo " <font color='darkgreen' class='icon-smile'> Correcto!</font>";
        }
    }
    elseif($_POST['name']=='phone'){
        if(mysqli_num_rows(mysqli_query($con, "SELECT phone FROM users WHERE phone='$inputVal'")) > 0 ){
            echo "<font color='red' class='icon-smiley-frown'> El teléfono: ($inputVal) ya existe!</font>";
        }else{
            echo " <font color='darkgreen' class='icon-smile'> Correcto!</font>";
        }
    }
}
//VERIFICAR EDIT USER
elseif(isset($_POST["validarEdit"])){
    $id = mysqli_real_escape_string($con,$_POST["inputId"]);
    $inputVal = mysqli_real_escape_string($con,$_POST["inputVal"]);
  if($_POST['name']=='user'){
        if(mysqli_num_rows(mysqli_query($con, "SELECT user FROM users WHERE user='$inputVal' AND iduser!='$id'")) > 0 ){
          echo "<font color='red' class='icon-smiley-frown'> El usuario: ($inputVal) ya existe, agréguele números o inténtelo con otro diferente.</font>";
        }else{
        echo " <font color='darkgreen' class='icon-smile'> Correcto!</font>";
        }
    }
    elseif($_POST['name']=='email'){
        if(mysqli_num_rows(mysqli_query($con, "SELECT email FROM users WHERE email='$inputVal' AND iduser!='$id'")) > 0 ){
          echo "<font color='red' class='icon-smiley-frown'> El correo: ($inputVal) ya existe!</font>";
        }else{
        echo " <font color='darkgreen' class='icon-smile'> Correcto!</font>";
     }
    }
    elseif($_POST['name']=='phone'){
        if(mysqli_num_rows(mysqli_query($con, "SELECT phone FROM users WHERE phone='$inputVal' AND iduser!='$id'")) > 0 ){
            echo "<font color='red' class='icon-smiley-frown'> El teléfono: ($inputVal) ya existe!</font>";
        }else{
        echo " <font color='darkgreen' class='icon-smile'> Correcto!</font>";
      }
    }
}
//SAVE USER
elseif(isset($_POST["signup"])){
     $user = mysqli_real_escape_string($con,$_POST["user"]);
        $phone = mysqli_real_escape_string($con,$_POST["phone"]);
        $business = mysqli_real_escape_string($con,$_POST["business"]);
        $address = "";
        $pass = mysqli_real_escape_string($con,$_POST["pass"]);
        $mail = mysqli_real_escape_string($con,$_POST["correo"]);
        $type = mysqli_real_escape_string($con,$_POST["type"]);
        $periodo = mysqli_real_escape_string($con,$_POST["periodo"]);
        $pass = password_hash($pass, PASSWORD_DEFAULT);  //SIFRA EL PASS
    if(isset($_POST['percent'])){    
        $percent = mysqli_real_escape_string($con,$_POST["percent"]);      
        $r = mysqli_query($con, "SELECT address FROM users WHERE business='$business'");

		if( mysqli_num_rows($r) > 0 ){  
			while($f=mysqli_fetch_array($r)){
				   $address=$f['address'];
            }
        }
    }else{
        $percent=0;
        $address = mysqli_real_escape_string($con,$_POST["address"]);
    }

	if(mysqli_num_rows(mysqli_query($con, "SELECT user FROM users WHERE user='$user'")) > 0 ){ //SI EL CORREO YA EXISTE, SE LE NOTIFICA EL USUARIO
		echo " <script>  alert('El usuario: ($user) ya existe, agréguele números o inténtelo con otro diferente.'); window.history.back(); </script>";
    }
    elseif(mysqli_num_rows(mysqli_query($con, "SELECT email FROM users WHERE email='$mail'")) > 0 ){ //SI EL CORREO YA EXISTE, SE LE NOTIFICA EL USUARIO
		echo " <script>  alert('El correo: ($mail) ya existe!!'); window.history.back(); </script>";
    }elseif(mysqli_num_rows(mysqli_query($con, "SELECT phone FROM users WHERE phone='$phone'")) > 0 ){ //SI EL CORREO YA EXISTE, SE LE NOTIFICA EL USUARIO
		echo " <script>  alert('El teléfono: ($phone) ya existe!!'); window.history.back(); </script>";
    }
    elseif($type==="business" and (mysqli_num_rows(mysqli_query($con, "SELECT business FROM users WHERE business='$business' AND type='business'")) > 0 )){ //SI EL CORREO YA EXISTE, SE LE NOTIFICA EL USUARIO
		echo " <script>  alert('El negocio: ($business) ya está registrado.'); window.history.back(); </script>";
	}
    else{  				
	    //INGRESA LOS DATOS A LA DB
    	$exitosa = mysqli_query($con, "INSERT INTO users(user,email,phone,pass,percent,business,periodo,address,type)VALUES('$user','$mail','$phone','$pass','$percent','$business','$periodo','$address','$type')") 
            or die(" <script> alert('Error al registrarse!'); window.history.go(-1);</script>");
				
    	if($exitosa){    
			if(session_id() ===""){ session_start();}
			$res = mysqli_query($con, "SELECT * FROM users WHERE user='$user'");

		if( mysqli_num_rows($res) > 0 ){  
			while($fila=mysqli_fetch_array($res)){
				   $_SESSION['iduser']=$fila['iduser'];
                    $_SESSION['user']=$fila['user'];
                    $_SESSION['percent']=$fila['percent'];
                    $_SESSION['business']=$fila['business'];
                    $_SESSION['type']=$fila['type']; 
                    $_SESSION['periodo']=$fila['periodo']; 
                
                        setcookie("user",$user,time()+2592000,"/");
                        setcookie("pass",$pass,time()+2592000,"/");
			}
            mysqli_free_result($res);//libera la memoria
			mysqli_close($con);
									
			header("location: ../app/main.php");  
    		}
		} 
	}
    }
//EDIT USER
elseif(isset($_POST["editar"])){ 

     $iduser = mysqli_real_escape_string($con,$_POST["iduser"]);    
        $user = mysqli_real_escape_string($con,$_POST["user"]);
        $phone = mysqli_real_escape_string($con,$_POST["phone"]);
        $business = mysqli_real_escape_string($con,$_POST["business"]);
        $pass = mysqli_real_escape_string($con,$_POST["pass"]);
        $mail = mysqli_real_escape_string($con,$_POST["email"]);
        $percent = mysqli_real_escape_string($con,$_POST["percent"]);
        $periodo = mysqli_real_escape_string($con,$_POST["periodo"]);
        $address = mysqli_real_escape_string($con,$_POST["address"]);
        $open = mysqli_real_escape_string($con,$_POST["open"]);
        $close = mysqli_real_escape_string($con,$_POST["close"]);
        $pass = password_hash($pass, PASSWORD_DEFAULT);  //SIFRA EL PASS
    
  
    if(mysqli_num_rows(mysqli_query($con, "SELECT user FROM users WHERE user='$user' AND iduser!=$iduser")) > 0 ){ 
		echo "<script> alert('Este usuario: ($user) ya existe, agréguele números o inténtelo con otro diferente. !!'); window.history.go(-1);</script>";
    }elseif(mysqli_num_rows(mysqli_query($con, "SELECT email FROM users WHERE email='$mail' AND iduser!=$iduser")) > 0 ){
		echo "<script> alert('Este correo: ($mail) ya existe!!'); window.history.go(-1);</script>";
    }elseif(mysqli_num_rows(mysqli_query($con, "SELECT phone FROM users WHERE phone='$phone' AND iduser!=$iduser")) > 0 ){
		echo "<script> alert('Este teléfono: ($phone) ya existe!!'); window.history.go(-1);</script>";
	}else{  	
	    //INGRESA LOS DATOS A LA DB
    	$exitosa = mysqli_query($con, "UPDATE users SET user='$user',phone='$phone',pass='$pass',percent='$percent',email='$mail',business='$business',periodo='$periodo',address='$address',open='$open',close='$close' WHERE iduser=$iduser") 
            or die(" <script> alert('Error al editar!'); window.history.go(-1);</script>");               						
        if($exitosa){    
            //actualiza la direccion de todos los usuarios en la empresa
            mysqli_query($con, "UPDATE users SET address='$address' WHERE business='$business'") ;

            session_start();
			$res = mysqli_query($con, "SELECT * FROM users WHERE iduser='$iduser'");

		    if( mysqli_num_rows($res) > 0 ){ 
                while($fila=mysqli_fetch_array($res)){
                       $_SESSION['iduser']=$fila['iduser'];
                        $_SESSION['user']=$fila['user'];
                        $_SESSION['business']=$fila['business'];
                        $_SESSION['percent']=$fila['percent'];
                        $_SESSION['type']=$fila['type'];
                        $_SESSION['periodo']=$fila['periodo'];
                    }
            mysqli_free_result($res);//libera la memoria
			mysqli_close($con);
									
			header("location: ../app/main.php");  
    		}
		} 
    }
}
//RESET PASS
elseif(isset($_POST["pass1"]) && isset($_POST["pass2"])){
        $iduser = mysqli_real_escape_string($con,$_POST["iduser"]);
        $pass = mysqli_real_escape_string($con,$_POST["pass2"]);
        $pass = password_hash($pass, PASSWORD_DEFAULT);  //SIFRA EL PASS     

	    //INGRESA LOS DATOS A LA DB
    	$exitosa = mysqli_query($con, "UPDATE users SET pass='$pass' WHERE iduser=$iduser") ;
        mysqli_close($con);
        if($exitosa){    
			echo "Contraseña cambiada exitosamente! <br><br><br>Ir a la página de acceso <a href='../index.php'>AQUI</a>.";
    		}else{echo "Error al editar!";} 
    }
//LOGIN USER
elseif(isset($_POST["login"])){
        $user = mysqli_real_escape_string($con,$_POST["user"]);
        $pass = mysqli_real_escape_string($con,$_POST["pass"]);        

    //	EL USUARIO DEBE PODER INICIAR SECCION CON SU CORREO O TELEFONO Y SU CONTRASENA
		$res = mysqli_query($con, "SELECT * FROM users WHERE user='$user' OR phone='$user' OR email='$user' ");
		while($fila=mysqli_fetch_array($res)){
			if(password_verify($pass,$fila['pass']) and (strcasecmp($user,$fila['user'])==0  or strcasecmp($user,$fila['phone'])==0 or strcasecmp($user,$fila['email'])==0)){ //SI EL USER Y EL PASS SON VALIDOS, SE INICIA LA SECSION
                
				$_SESSION['iduser']=$fila['iduser']; 
                $_SESSION['user']=$fila['user'];
                $_SESSION['percent']=$fila['percent'];
                $_SESSION['business']=$fila['business'];
                $_SESSION['type']=$fila['type'];
                $_SESSION['periodo']=$fila['periodo'];
                 
                if($_POST['cookie']=="Olvídame"){  
                    setcookie("user",$user,time()+2592000,"/");
                    setcookie("pass",$pass,time()+2592000,"/");
                } 
                
			 	mysqli_free_result($res);
				mysqli_close($con);
                    header("location: ../app/main.php");
			}
		}
        if(!isset($_SESSION['iduser'])){    
            echo " <script>alert('La información de acceso proporcionada no concuerda!'); window.history.go(-1);</script>";
        }
}
//ESCONDE USER 
elseif(isset($_POST["hide"])){
        $id = mysqli_real_escape_string($con,$_POST["id"]);
        $status = mysqli_real_escape_string($con,$_POST["hide"]);

        $correcto =	mysqli_query($con, "UPDATE users SET status='$status' WHERE iduser='$id'") ;
        mysqli_close($con);
    }
//DELETE USER
elseif(isset($_POST["delete"])){
        $id = mysqli_real_escape_string($con,$_POST["delete"]);

        mysqli_query($con, "DELETE FROM users WHERE iduser=$id") ;
        mysqli_close($con);
    }  
//RECUPERAR CONTRASEÑA
elseif(isset($_POST["resetPass"])){
    
    $destino = mysqli_real_escape_string($con,$_POST['mailCell']);
    $url = mysqli_real_escape_string($con,$_POST['url']);
    $resetPass = mysqli_real_escape_string($con,$_POST['resetPass']);
    
           
//	VERIFICA QUE EL CORREO	NO EXISTA
	$existe = mysqli_query($con, "SELECT * FROM users WHERE email='$destino' OR phone='$destino'");

	if(mysqli_num_rows($existe) > 0 ){ //SI EL CORREO YA EXISTE, SE LE NOTIFICA EL USUARIO
        while($fila=mysqli_fetch_array($existe)){
            $iduser=$fila['iduser']; 
            $user=$fila['user']; 
        }
        
                   
       if(strpos($url,"index.php")){
          $newurl=str_replace("index.php","app/resetPassword.php",$url);
       }else{
          $newurl=$url."app/resetPassword.php";
       }
           
            
            
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
                $mail->setFrom('news@en4es.com', 'Reset Password');
                
        //ENVIAR UN SMS
         if($resetPass=='cell'){ 
                //Destinatarios
                $mail->addAddress("$destino@mms.att.net", "client");      //ATT MMS
//                $mail->addBCC("$destino@mms.alltelwireless.com");         //Alltel  MMS
//                $mail->addBCC("$destino@myboostmobile.com");              //Boost Mobile  MMS y SMS
//                $mail->addBCC("$destino@mms.cricketwireless.net");        //Cricket Wireless  MMS
//                $mail->addBCC("$destino@msg.fi.google.com");              //Project Fi  MMS y SMS
//                $mail->addBCC("$destino@pm.sprint.com");                  //Sprint  MMS
//                $mail->addBCC("$destino@tmomail.net");                    //T-Mobile  MMS y SMS
//                $mail->addBCC("$destino@mms.uscc.net");                   //U.S. Cellular  MMS
//                $mail->addBCC("$destino@vzwpix.com");                     //Verizon MMS
//                $mail->addBCC("$destino@vmpix.com");                      //VIRGIN MOBILE MMS
//                $mail->addBCC("$destino@text.republicwireless.com");      //Republic Wireless SMS

                // Contenido del mensaje
                $mail->Body    = "Para recuperar contraseña, haz clic en el siguiente link: $newurl?code=$iduser";
            try {
                $mail->send();
                //AQUI VAL EL MENSAJE EXITOSO
                echo " SMS enviado correctamente!";
            } catch (Exception $e) {
               //QUI VA EL MENSAJE DE ERROR 
                echo "Error al enviar SMS.";
            }
        $mail->clearAddresses();

            
         }else{//ENVIAR UN MAIL
             //Recipients
                $mail->addAddress($destino, "Client");     // Add a recipient
             
                // Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'Recuperar cuenta.';
                $mail->Body    = "<h3><font color='red'>¿Solicitaste cambiar la contraseña?</font></h3><br><br>
                <p>Si no has sido tú, has clic en este <a href='$url'>enlace</a> e ingresa a tu cuenta, y verifica que todo este marchando bien. </p>
                <p>Para cambiar contraseña has clic en este <a href='$newurl?code=".base64_encode($iduser)."'>enlace</a> e ingresa una nueva contraseña. </a>";
             try {

                $mail->send();
                echo "Enviamos un enlace al siguente correo: <a href='mailto:".$_POST['email']."'> ".$_POST['email']."</a>, revísalo  y da clic en el enlace cambiar contraseña."; 
            } catch (Exception $e) {
                echo "Error al solicitar cambio de contraseña.\n\n Intente más tarde.";
                echo " {$mail->ErrorInfo}";
            }
        }
    }else{
        echo " <script>  alert('Este destino ($destino), no está vinculado a ningun usuario en nuestra base de datos.'); </script>";
    }
}

//LOGIN WITH CODE
elseif(isset($_POST["recuperar_cuenta"])){
       
        $user = mysqli_real_escape_string($con,$_POST["info_user"]);
        $passCode = mysqli_real_escape_string($con,$_POST["code"]);        

    //	EL USUARIO DEBE PODER INICIAR SECCION CON SU CORREO O TELEFONO Y SU CONTRASENA
		$res = mysqli_query($con, "SELECT * FROM users WHERE (email='$user' OR phone='$user') AND  passcode='$passCode'");
		while($fila=mysqli_fetch_array($res)){
			if(mysqli_num_rows($res) > 0){
                //SI EL USER Y EL PASS SON VALIDOS, SE INICIA LA SECSION
                $_SESSION['iduser']=$fila['iduser']; 
                $_SESSION['user']=$fila['user'];
                $_SESSION['percent']=$fila['percent'];
                $_SESSION['business']=$fila['business'];
                $_SESSION['type']=$fila['type'];
                $_SESSION['periodo']=$fila['periodo'];
                                 
			 	mysqli_free_result($res);
				mysqli_close($con);
                header("location: ../app/main.php");				
            }else{                
        echo "<body>
                <script>
                       swal.fire({
                           icon: 'error',
                           title: 'Oops!',
                           text: 'La información de acceso proporcionada no concuerda.',
                        }).then((result) =>{
                            if(result.isConfirmed){
                                 location.href='../app/reset.php';
                            }
                        });
                       </script>  
                </body>";  
        }
        } 
} 