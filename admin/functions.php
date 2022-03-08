<?php 
//sleep(2);
 
      date_default_timezone_set('America/St_Thomas');
$fech=date("l, M j",strtotime("08-04-2010 22:15:00"));//SE UTILIZA PARA AGRUPAR LAS REGISTROS POR FECHAS

include("connection.php"); 
if(session_id() ===""){ session_start();}

//PARA USUARIOS ROOT
if(isset($_POST['root'])){           
    $resultado = mysqli_query($con, "SELECT * FROM users RIGHT JOIN citas ON users.iduser=citas.userid WHERE iduser='".$_POST['root']."' ORDER BY cita"); 
//    echo 1;
 }
//PARA CUENTAS DE NEGOCIOS Y BUSQUEDA CON FECHA Y USUARIO
elseif((isset($_POST['iduser']) && $_POST['iduser']!="") && (isset($_POST['dateBrowse']) && $_POST['dateBrowse']!="")){           
    $resultado = mysqli_query($con, "SELECT * FROM users RIGHT JOIN citas ON users.iduser=citas.userid WHERE iduser='".$_POST['iduser']."' AND business='".$_SESSION['business']."' AND cita LIKE '".$_POST['dateBrowse']."%' ORDER BY cita");    
//    echo 2;
 }
//PARA CUENTAS DE NEGOCIOS Y BUSQUEDA CON FECHA Y USUARIO EN GENERAL
elseif((isset($_POST['iduser']) && $_POST['iduser']=="") && (isset($_POST['dateBrowse']) && $_POST['dateBrowse']!="")){           
    $resultado = mysqli_query($con, "SELECT * FROM users RIGHT JOIN citas ON users.iduser=citas.userid WHERE business='".$_SESSION['business']."' AND cita LIKE '".$_POST['dateBrowse']."%' ORDER BY cita");    
//    echo 200;
 }
//PARA CUENTA DE NEGOCIOS Y BUSQUEDA CON USURIO
elseif(isset($_POST['iduser']) && $_POST['iduser']!=""){           
    $resultado = mysqli_query($con, "SELECT * FROM users RIGHT JOIN citas ON users.iduser=citas.userid WHERE iduser='".$_POST['iduser']."' AND business='".$_SESSION['business']."' ORDER BY cita");    
//    echo 3;
 }
//PARA CUENTAS DE EMPLEADOS Y BUSQUEDA CON FECHA 
elseif((strcasecmp($_SESSION['type'],"business")!=0) && (isset($_POST['dateBrowse']) && $_POST['dateBrowse']!="")){
    $resultado = mysqli_query($con, "SELECT * FROM users RIGHT JOIN citas ON users.iduser=citas.userid WHERE iduser='".$_SESSION['iduser']."' AND business='".$_SESSION['business']."' AND cita LIKE '".$_POST['dateBrowse']."%' ORDER BY cita");   
//    echo 4;
  }
//PARA CUENTAS DE EMPLEADOS
elseif(strcasecmp($_SESSION['type'],"business")!=0){
    $resultado = mysqli_query($con, "SELECT * FROM users RIGHT JOIN citas ON users.iduser=citas.userid WHERE iduser='".$_SESSION['iduser']."' AND business='".$_SESSION['business']."' ORDER BY cita");  
//    echo 5;
  }
//PARA CUENTAS DE NEGOCIOS Y BUSQUEDA EN GENERAL
else{
     $resultado = mysqli_query($con, "SELECT * FROM users RIGHT JOIN citas ON users.iduser=citas.userid WHERE business='".$_SESSION['business']."' ORDER BY cita");
//    echo 6;
}

echo "<center><h2>AJENDA DE CITAS</h2></center><hr>";


if(mysqli_num_rows($resultado) > 0){   
     while($fila= mysqli_fetch_array($resultado)){ 
         $id=$fila['id'];
          //EL SIGUIENTE CODIGO INDICA CUANDO UNA CITA CHOCA CON OTRA
         $SQLTiempoEstimado= $fila['tiempoEstimado'];         
         $colorHour2="";

           //CODIGO PARA MOSTRAR ALERTE DE CITA DUPLICADA         
         $time1=date("Y-m-d H:i:s",strtotime($fila['cita'])); 
         $time2= date("Y-m-d H:i:s",strtotime($fila['cita']." +$SQLTiempoEstimado minutes")); 
         
         if(isset($_POST['root'])){           
            $notif = mysqli_query($con,"SELECT (SELECT MIN(currentdate) FROM citas WHERE (cita >= '$time1' AND cita < '$time2') AND userid='".$_POST['root']."')AS last FROM users RIGHT JOIN citas ON users.iduser=citas.userid WHERE (cita >= '$time1' AND cita < '$time2') AND userid='".$_POST['root']."'");   
         }
         elseif(isset($_POST['iduser']) && $_POST['iduser']!=""){           
            $notif = mysqli_query($con,"SELECT (SELECT MIN(currentdate) FROM citas WHERE (cita >= '$time1' AND cita < '$time2') AND userid='".$_POST['iduser']."')AS last FROM users RIGHT JOIN citas ON users.iduser=citas.userid WHERE (cita >= '$time1' AND cita < '$time2')  AND userid='".$_POST['iduser']."'"); 
         }
         elseif(strcasecmp($_SESSION['type'],"business")!=0){
            $notif = mysqli_query($con,"SELECT (SELECT MIN(currentdate) FROM citas WHERE (cita >= '$time1' AND cita < '$time2') AND userid='".$_SESSION['iduser']."')AS last FROM users RIGHT JOIN citas ON users.iduser=citas.userid WHERE (cita >= '$time1' AND cita < '$time2') AND userid='".$_SESSION['iduser']."'"); 
         }
         else{
             $notif = mysqli_query($con,"SELECT (SELECT MIN(currentdate) FROM citas WHERE (cita >= '$time1' AND cita < '$time2') AND userid='".$fila['userid']."')AS last FROM users RIGHT JOIN citas ON users.iduser=citas.userid WHERE (cita >= '$time1' AND cita < '$time2') AND userid='".$fila['userid']."'"); 
         } 
                 
        $classAlert="";//MUESTRA LA CITA DUPLICADA CON UN ICONO DE ALERTA
        $infoAlert="";//MUESTRA LA CITA DUPLICADA EN LA VENTANA EMERGENTE
        if(mysqli_num_rows($notif) > 1){ 
            while($rowAlert= mysqli_fetch_array($notif)){ 
                $classAlert = ($fila['currentdate']!=$rowAlert['last'] ? 'icon-care' : '');
                $infoAlert = "<br><font color=orange class=icon-care> This appt. is in conflict with other appts.</font>";
            }mysqli_free_result($notif);
        } //FIN DE CODIGO PARA ALERTA DE CITA DUPLICADA
         
         //MENSAJE DE AUTORELLENO EN LOS SMS Y WHATSAPP
          $body="Hi, Remember your appt. with ".$fila['user']." for ".date(" h:ia",strtotime($fila['cita']))." at ".$fila['business']." [".$fila['address']."]. Please, let us know if you wish reschedule or cancel. Thanks for choosing us! Read our appt. policies: en4es.com/appt/app/policy.html"; 
         
         //FORMATE LA FECHA, EJEMPLO: SUNDAY 5 DEC*****************************
        $date=date("l, M j",strtotime($fila['cita']));
          
        $hourStart=date("h:i",strtotime($fila['cita'])); //QUITA LOS SEGUNDOS 
        $hourEnd= date("h:i",strtotime($fila['cita']." +$SQLTiempoEstimado minutes")); 
         
         //VALIDA EL FORMATO AM PM DE LA HORA*******************************
             $hourStart.= "<div class='am_pm'> <span> ".date("a",strtotime($time1))." </span> </div>";
             $hourEnd.= "<div class='am_pm'> <span> ".date("a",strtotime($time2))." </span> </div>";
         
          //VALIDA EL COLOR QUE TENDRA LA FECHA***********SI LA CITA ES MAYOR A HOY=ORENGE *******************
        if(date("Y-m-d",strtotime($fila['cita'])) > date("Y-m-d")){
            $colorDate="orange";
            $classDate="icon-calendar-o";
            $colorHour="orange";
        } 
         //********SI LA CITA ES IGUAL A HOY=GREEN
        elseif(date("Y-m-d",strtotime($fila['cita'])) == date("Y-m-d")){
            $colorDate="green";  
            $classDate="icon-calendar-check-o";  
         //10 MINUTOS ANTES Y 10 MINUTOS DESPUES DE LA FECHA ACTUAL
            $f1=date('H:i:s',strtotime(date('H:i:s').'+ 10 minutes'));
            $f2=date('H:i:s',strtotime(date('H:i:s').'- 10 minutes'));
                        
            if($f1 >= date("H:i:s",strtotime($fila['cita'])) && $f2 <= date("H:i:s",strtotime($fila['cita']))){
                $colorHour="green";                 
                 if(date("H:i:s") == date("H:i:s",strtotime($fila['cita'])) ){ ?>
                 <!-- MUESTRA UNA NOFICICACION-->
                    <script> notifications('<?php echo "Con ".$fila['name']." a la ".$hourStart."  ".$fila['phone']; ?>');</script> 
        <?php    } 
            }
            elseif(date('H:i:s') < date("H:i:s",strtotime($fila['cita']))){
                $colorHour="orange";
            }
            elseif(date('H:i:s') > date("H:i:s",strtotime($fila['cita']))){
                $colorHour="red;text-decoration:line-through"; 
            }           
            
               //*******************************************
          //HORA FINAL DE LA CITA
            $horaCitaFinal = date("H:i:s",strtotime($fila['cita']." +$SQLTiempoEstimado minutes"));                  
            if(date('H:i:s') >= date("H:i:s",strtotime($fila['cita'])) && date("H:i:s") <= $horaCitaFinal){
                 
    //CREA UNA BARRA DE PROGRESO CON EL TIEMPO ESTIMADO DEL SERVICIO
                $horaActal = date("H:i:s");
                
                $horaA = new DateTime($horaActal);
                $horaCitaF = new DateTime($horaCitaFinal);
                
                $intervalo = $horaCitaF->diff($horaA);
                $horaRestante = $intervalo->format('%H');
                $minutosRestante = $intervalo->format('%i');
                
                $tiempoRestante = ($intervalo->format('%H') > 0 ? (($horaRestante * 60) + $minutosRestante) : $minutosRestante );
                ?>
            <script>
                $('#<?php echo $id ?> .left').append("<p class='load'><span>Time Left: <b class='reloj running'><?php echo $intervalo->format('%H:%I:%S') ?></b> </span> <meter min='0' max='<?php echo $SQLTiempoEstimado ?>' value='<?php echo $tiempoRestante ?>' low='<?php echo ($SQLTiempoEstimado / 2) ?>' high='<?php echo ($SQLTiempoEstimado / 1.2) ?>' optimum='<?php echo ($SQLTiempoEstimado /1.1)?>'></meter></p>");
            </script>
<?php     $colorHour="green";               
            } 
        }
         //SI LA CITA YA PASO=RED
        elseif(date("Y-m-d",strtotime($fila['cita'])) < date("Y-m-d")){
            //SI LA CITA TIENE MAS DE 1 DIA QUE PASO, ENTONCES SE ELIMINA AUTOMATICAMENTE
            if(date("Y-m-d H:i",strtotime($fila['cita']." +12 hours")) < date("Y-m-d H:i")){
               echo "<script> 
                         $.ajax({
                                type: 'post',
                                url: '../admin/manage.php',
                                data: {del:".$fila['id']."}
                            });
                    </script>";
            }
            $colorDate="red; ";
            $classDate="icon-calendar-minus-o";
            $colorHour="red; text-decoration:line-through;";
        } 
         
         //MUESTRA UNA UNICA FECHA POR DIAS
         if($date != $fech){ 
             echo "<center> 
                    <span class='$classDate citafecha' style='color:$colorDate;'> 
                        <font color='dodgerblue'>$date</font>
                        <font class='icon-load'></font>
                    </span>
                  </center>";
            $fech=$date; 
         }    ?>

<div class="container" id="<?php echo $id ?>">
    <div class="left">

        <?php if(strcasecmp($_SESSION['type'],"business")==0){  ?>
        <div class="header">
            <span class="icon-usercircle" onclick="citas('<?php echo $fila['iduser']; ?>');">
             <?php echo ($_SESSION['iduser']==$fila['iduser']? "Con Cualquiera" : " Con ".ucwords($fila['user'])); ?>
            </span>
       
        </div>
        <?php } ?>
               
        <div class="body">           
            <?php  echo "<h2 style='color:$colorHour'>$hourStart </h2> <h2 class='gion icon-android-arrow-up'></h2> <h2 style='color:#ccc'>$hourEnd</h2>"; ?>
        </div>

        <div class="foot">
            <strong><?php echo ucwords($fila['name']); ?></strong>
            <?php if($fila['phone']!=""){ 
             //AGREGA GUIONES A LOS # DE TELEFONOS
             $aux = $fila['phone'];
             $tel = substr($aux,0,3)."-".substr($aux,3,3)."-".substr($aux,6,4);
                //INFORMACION DE LA CITA EN UNA VENTANA EMERGENTE
                $information = '<strong>Phone:</strong> <a href=tel:+'.$fila['phone'].'>'.$tel.'</a><br><strong>Duration: </strong><i>'.$fila['tiempoEstimado'].' minutes</i><br><strong>Reserved: </strong> <i>'.date("D, M j",strtotime($fila['currentdate'])).' at '.date("h:i:s a",strtotime($fila['currentdate'])).'</i>';
                
                $information.=$infoAlert;
             
            ?>
             | <a title="Enviar Whatsapp" class="icon-whatsapp"  href="https://api.whatsapp.com/send?phone=+1<?php echo $fila['phone']."&text=$body"; ?>"></a>
            | <a title="Enviar SMS" class="icon-mail" href="sms:<?php echo $fila['phone']."?body=$body"; ?>"></a>
            | <a title="Llamar" class="icon-phone" href="tel:+<?php echo $fila['phone']; ?>"></a>
          
            | <span style="color:blue;cursor:pointer" class="icon-plus" onclick="Swal.fire({title:'ID<?php echo $fila['id']; ?>',html:'<?php echo $information; ?>',icon:'info'}); "></span>
            <?php }else{             
                $information = '<strong>Duration: </strong><i>'.$fila['tiempoEstimado'].' minutes</i><br><strong>Reserved: </strong> <i>'.date("D, M j",strtotime($fila['currentdate'])).' at '.date("h:i:s a",strtotime($fila['currentdate'])).'</i><br><font color=red>Edit phone and message</font><br><input type=number placeholder=Phone id=alertPhone><br><br><textarea id=smsEdit placeholder=messange>'.$fila['menssage'].'</textarea><input id=idEdit type=hidden value='.$fila['id'].'>';
             
                $information.=$infoAlert;
            ?>
            <script>
                function editPhone(){
                      $.ajax({
                        type: 'post',
                        url: '../admin/save.php',
                        data: {
                            idEdit:$('#idEdit').val(),
                            phoneEdit: $('#alertPhone').val(),
                            smsEdit: $('#smsEdit').val()
                        }
                    });
                    return false;
                }  
            </script>
            | <span class="icon-bell2" style="color:red"> </span>
            | <span style="color:blue;cursor:pointer" class="icon-plus" onclick="
                    Swal.fire({                
                        title:'ID<?php echo $fila['id']; ?>',                
                        html:'<?php echo $information; ?>',                
                        icon:'info', 
                        showDenyButton: true,
                        showCancelButton: true,
                        confirmButtonText: 'Save',             
                         denyButtonText: 'Delete Appt.',
                         cancelButtonText: 'Close'
                        }).then((result) => {
                          if (result.isConfirmed) {
                                editPhone();
                            }else if (result.isDenied) {
                                borrar(<?php echo $fila['id']; ?>);
                            }     
                    });                
             "></span>

            <?php } ?>
            <!--FIN DE LOS ENLACES A LLAMADAS Y TEXTO-->

            <p><?php echo $fila['menssage']; ?></p>           
        </div>
       
        <!--DIV RATING -->
        <div id="rating">                
        <?php 
         if($fila['phone']!=""){ 
             //OBTINE EL ESTILO DEL RATING
             $styles = mysqli_query($con,"SELECT good, bad FROM ratingclients WHERE idappt='".$fila['id']."'"); 
      
             $colorgood='color:gray';
             $colorbad='color:gray';
             $colormeh='color:gray';
            if(mysqli_num_rows($styles) === 0){ $colormeh = 'color:blue;font-weight:bold'; }
            while($rowss= mysqli_fetch_array($styles)){ 
                if($rowss['good'] == 1){ $colorgood='color:blue;font-weight:bold'; }
                if($rowss['bad'] == 1){ $colorbad = 'color:blue;font-weight:bold'; }
                
            }mysqli_free_result($styles);
             //FIN DEL ESTILO PARA EL RATING
             
             //OBTIENE LOS NUMEROS DEL RATING
              $rating = mysqli_query($con,"SELECT SUM(good) AS sumgood, SUM(bad)AS sumbad FROM ratingclients WHERE phone='".$fila['phone']."'");
            while($rows= mysqli_fetch_array($rating)){  ?>
                  
<!--                   <i class="ratingtitle">Rating: </i>-->
                    <font class="icon-smiley-frown" style="<?php echo $colorbad ?>" 
                     onclick="rating('<?php echo $fila['id']; ?>','<?php echo $fila['phone']; ?>',0,1);"><i><?php echo $rows['sumbad'] ?></i></font> 
                    
                    <font class="icon-smiley-meh" style="<?php echo $colormeh ?>"  onclick="delrating('<?php echo $fila['id']; ?>');"></font> 
                    
                     <font class="icon-smile" style="<?php echo $colorgood ?>"
                      onclick="rating('<?php echo $fila['id']; ?>','<?php echo $fila['phone']; ?>',1,0);"><i><?php echo $rows['sumgood'] ?></i></font> 
        <?php }mysqli_free_result($rating);             
        } //FIN DE LOS NUMEROS DEL RATING   ?>           
        </div>
    </div>

    <div class="right">
        <button onclick="borrar(<?php echo $fila['id']; ?>);" class="icon-calendar-times-o"></button>
        <input type="checkbox" class="input" value="<?php echo $fila['id']; ?>" onclick="clearInterval(interval);$('.icon-load').fadeIn(1000);">
        <?php if($classAlert!=""){ ?>
        <button style='color:orange' class="<?php echo $classAlert; ?>"></button>
        <?php } ?>
          
    </div>
   
</div>
<?php    } 
    mysqli_free_result($resultado);
    mysqli_close($con); 
}else{ ?>
    <br><br><center class='icon-calendar-o'> Sin Citas!</center>     
    <?php  } ?>
    
        <script>
            function borrar(id) {
                if ($('.input').is(':checked')) {
                    var eliminar = confirm('¿Eliminar todas las citas seleccionadas?');
                    if (eliminar) {
                        $('.input').each(function() {
                            if ($(this).is(':checked')) {
                                $.ajax({
                                    type: 'post',
                                    url: '../admin/manage.php',
                                    data: {
                                        del: $(this).val()
                                    },
                                    success: function() {
                                        location.reload();
                                    }
                                });

                            }
                        });
                    }
                } else {
                    var eliminar = confirm('¿Eliminar cita?');
                    if (eliminar) {
                        $.ajax({
                            type: 'post',
                            url: '../admin/manage.php',
                            data: {
                                del: id
                            }
                        });
                    }
                }
            }

            $('.icon-load').click(function() {
                location.reload();
            });

            function citas(id) {
                $.ajax({
                    type: 'POST',
                    url: '../admin/functions.php',
                    data: {
                        iduser: id
                    },
                    success: function(data) {
                        $("#divcitas").html(data);
                        $('#verCitas select').val(id);
                    }
                });
                return false;
            }


            function rating(idappt, cel, good, bad) {
                $.ajax({
                    type: 'post',
                    url: '../admin/manage.php',
                    data: {
                        idappt: idappt,
                        cel: cel,
                        rating: '',
                        good: good,
                        bad: bad
                    }
                });
                return false;
            }

            function delrating(idrating) {
                $.ajax({
                    type: 'post',
                    url: '../admin/manage.php',
                    data: {
                        idrating: idrating,
                        delrating: '',
                    }
                });
                return false;
            }
        </script>
           
           
           
            
