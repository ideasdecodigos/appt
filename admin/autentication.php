<?php	 
	if(isset($_COOKIE['user']) and isset($_COOKIE['pass'])){
          include("connection.php"); 
		$user = mysqli_real_escape_string($con,$_COOKIE['user']);
		$pass = mysqli_real_escape_string($con,$_COOKIE['pass']);  

    //	EL USUARIO DEBE PODER INICIAR SECCION CON SU CORREO O TELEFONO Y SU CONTRASENA
		$res = mysqli_query($con, "SELECT * FROM users WHERE user='$user'");
		while($fila=mysqli_fetch_array($res)){
			if(password_verify($pass,$fila['pass']) and strcasecmp($user,$fila['user'])==0 ){ //SI EL USER Y EL PASS SON VALIDOS, SE INICIA LA SECSION
                if(session_id() ===""){ session_start();}
                
				$_SESSION['iduser']=$fila['iduser'];
                $_SESSION['user']=$fila['user'];
                $_SESSION['percent']=$fila['percent'];
                $_SESSION['business']=$fila['business'];
                $_SESSION['type']=$fila['type'];
                
                setcookie("user",$user,time()+2592000,"/");                        
                setcookie("pass",$pass,time()+2592000,"/");
                
			 	mysqli_free_result($res);
				mysqli_close($con);
                    header("location: app/main.php");
			}
		}
}