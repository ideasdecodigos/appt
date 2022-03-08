<?php 

include("connection.php"); //ABRE LA CONEXION 
//ELIMINA LAS CITAS
if(isset($_POST["del"])){        
    $correcto =	mysqli_query($con, "DELETE FROM citas WHERE id='".$_POST["del"]."'") ;	

    if($correcto){ 
       echo "<script> location.reload();</script>"; 
    }else{
        echo "<script> alert('Delete failed!');</script>";
    }
    
}
//ELIMINA LOS REGISTROS DE SERVICIOS 
elseif(isset($_POST["delc"])){  
    $correcto =	mysqli_query($con, "DELETE FROM account WHERE id='".$_POST["delc"]."'") ;	
    
    if($correcto){ 
       echo "<script> location.reload();</script>"; 
    }else{
        echo "<script> alert('Delete failed!');</script>";
    }
    
     
}
//GRARDA LAS VALORACIONES HECHAS AL CLIENTE
elseif(isset($_POST["rating"])){  
    $correcto =	mysqli_query($con, "INSERT INTO ratingclients (phone, good, bad, idappt) VALUES('".$_POST["cel"]."','".$_POST["good"]."','".$_POST["bad"]."','".$_POST["idappt"]."')");	
      
     if(!$correcto){ 
         mysqli_query($con, "UPDATE ratingclients SET phone='".$_POST["cel"]."', good='".$_POST["good"]."', bad='".$_POST["bad"]."' WHERE idappt='".$_POST["idappt"]."'") ;	
    }  
}//GRARDA LAS VALORACIONES HECHAS AL CLIENTE
//Edita las politicas de los NEGOCIOS
elseif(isset($_POST["lang"])){ 
    $lang = mysqli_real_escape_string($con,$_POST['lang']);
    $negocio = mysqli_real_escape_string($con,$_POST['negocio']);
    $politicas = mysqli_real_escape_string($con,$_POST['politicas']);
    $fecha = mysqli_real_escape_string($con,$_POST['fecha']);
    
    $edit = mysqli_query($con, "SELECT lang FROM policies WHERE businesses='$negocio' AND lang='$lang'");
    
    if(mysqli_num_rows($edit) > 0 ){ 
    
    mysqli_query($con, "UPDATE policies SET lang='$lang', content='$politicas', dates='$fecha' WHERE businesses='$negocio' AND lang='$lang'") ;
         echo "<script>
                    swal.fire({
                        icon: 'success',
                        title: 'EDITDAS!',
                        text: 'Se editaron las politicas correctamente.',
                        timer: 8000            
                     });
                   </script>";
    }else{ 
    	mysqli_query($con, "INSERT INTO policies (lang,content,businesses) VALUES('$lang','$politicas','$negocio')"); 
         echo "<script>
                    swal.fire({
                        icon: 'success',
                        title: 'GUARDAD!',
                        text: 'Se guardaron las politicas correctamente.',
                        timer: 8000            
                     });
                   </script>";
        
    }    
}
//ELIMINA LAS VALORACIONES HECHAS AL CLIENTE
elseif(isset($_POST["delrating"])){          
    mysqli_query($con, "DELETE FROM ratingclients WHERE idappt='".$_POST["idrating"]."'") ;	   
}
//OBTIENE LA POLITACA EN UN IDIOMA ESPECIFICO
elseif(isset($_POST["business"])){      
  
        $res = mysqli_query($con, "SELECT * FROM policies WHERE businesses='".$_POST['business']."' AND lang='".$_POST['idioma']."'");
                if(mysqli_num_rows($res) > 0 ){  
                    while($rs=mysqli_fetch_array($res)){
                   
                        echo $rs['content'];
                        echo "<br><br><center><i>Updated on ".date("l M j, Y",strtotime($rs['dates']))."</i></center>";
                    }		    
                    mysqli_free_result($res);
                } 
            }


mysqli_close($con); //CIERRA LA CONEXION
