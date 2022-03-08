<?php 

include("connection.php"); 
if(session_id() ===""){ session_start();}
     $resultado = mysqli_query($con, "SELECT *,(SELECT user FROM users WHERE iduser=history.iduser)AS usuario FROM history
     WHERE fecha >='".$_POST['from']."' AND businesses='".$_SESSION['business']."' ORDER BY idhistory DESC");

 ?> 

<table>
   <tr>
        <td colspan="2"><center><?php echo mysqli_num_rows($resultado); ?> Citas encontradas</center></td>
    </tr>
    <tr>
        <th>Cliente Info</th>
        <th>Negocio Info</th>
    </tr>
    
    <?php
 $cont=0;
    if(mysqli_num_rows($resultado) > 0){   
         while($fila= mysqli_fetch_array($resultado)){ ?>
            <tr>
                <td>
                    <?php echo "Client: ".$fila['nombre'] ."<br>
                    Appt: ".date("M d, y h:ia",strtotime($fila['cita'])) ."<br>
                    Tel: ". $fila['tel'] ."<br>
                    SMS: ".$fila['mensaje']; ?>
                </td>

                <td>
                    <?php echo "Technician: ".$fila['usuario'] ."<br>
                    Booked: ".date("d M y h:ia",strtotime($fila['fechareserva']))."<br>
                    Time: ".$fila['duracioncita']." mins";?>
                </td>
            </tr>
            <tr>
                <td><br></td>
            </tr>
            

       <?php $cont++;   } 
        mysqli_free_result($resultado);
        mysqli_close($con); 
        
    }else{ ?>
        <br><br><center class='icon-calendar-o'> Sin Citas!</center>     
    <?php  } ?>
    
</table>
           
           
           
           
           
           
           
           
            
