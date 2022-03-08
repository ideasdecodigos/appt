<!--
	DESARROLLADOR: JUAN CARLOS PANIAGUA
	VERSION: 31.01.2021
	FECHA: 20 dec 2019
	
	PAGINA DE : principal
-->
<?php 
    session_start(); 
    
setlocale(LC_TIME,"es_ES");
    date_default_timezone_set('America/St_Thomas');
    if(isset($_SESSION['user'])){
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="description" content="A web for make appointments">
    <meta name="keywords" content="appointements, carlos, nails, saint thomas, virgin iliands">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="author" content="Juan C. Paniagua R.">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="shortcut icon" href="../src/logoIcon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" href="../src/logoIcon.ico" type="image/x-icon">
    <title>Main</title>
    <link rel="stylesheet" href="../src/icons/styles.css">
    <link rel="stylesheet" href="../css/styles.css">
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/push.min.js"></script>
    <script src="../js/script.js"></script>
    <style>
        @media print {

            .icon-trash,
            .icon-move-down,
            .icon-arrow-down-a,
            .icon-delete,
            #subirtabla,
            .td {
                display: none
            }

            table,
            table td,
            table th {
                margin: auto;
                border-collapse: none;
                border-spacing: none;
                border: 1px solid #ddd;
            }

        }

    </style>
</head>

<body>
    <script>
        function hider(id, hide) {
            if (hide == "enabled") {
                hide = "disabled";
            } else {
                hide = "enabled";
            }
            $.ajax({
                type: 'POST',
                url: '../admin/mng_staff.php',
                data: {
                    hide: hide,
                    id: id
                },
                success: function(data) {
                    location.reload();
                }
            });
            return false;
        }

        function del(id) {
            var eliminar = confirm('Al hacer clic en aceptar, se eliminará el usuario seleccionado. ¿Seguro que deseas eliminarlo?');
            if (eliminar) {
                $.ajax({
                    type: 'POST',
                    url: '../admin/mng_staff.php',
                    data: {
                        delete: id
                    },
                    success: function(data) {
                        location.reload();
                    }
                });
                return false;
            }
        }

    </script>
    <!--USUARIOS EN MODO ROOT-->
    <?php  if((strcasecmp($_SESSION['type'],"business")==0) and (strcasecmp($_SESSION['user'],"root")==0)){ ?>
    <div class="menu">
        <font color="white"><img src="../src/imgclear.png"><a href="company.php">IDCSchool</a></font>
        <span class="icon-usersecret"> <?php echo $_SESSION['user']; ?></span> |
        <button onclick="window.location.href='../admin/logout.php'" class="icon-logout"></button>
    </div>

    <div class="divtab" style="display:block">
        <table>
            <h2>USER ROOT</h2>
            <?php 
            include("../admin/connection.php");
		$res = mysqli_query($con, "SELECT * FROM users WHERE user!='root' ORDER BY user");
		if(mysqli_num_rows($res)>0){ 
		while($rs=mysqli_fetch_array($res)){ ?>

            <tr>
                <td>
                    <a class="icon-usersecret" href="userRoot.php?iduser=<?php echo $rs['iduser']; ?>&name=<?php echo $rs['user']; ?>"> <?php echo $rs['user']; ?></a>
                </td>
                <td> <span><?php echo $rs['business']; ?></span></td>
                <td><span><?php if($rs['type']=="personal"){echo "<font class='icon-tag' color='dodgerblue'></font>"; }else{echo "<font class='icon-tags' color='blue'></font>";} ?></span></td>
                <td>
                    <font <?php if($rs['status']=='enabled'){echo "class='icon-views' color='darkgreen'";}else{echo "class='icon-hide' color='darkorange'";} ?> onclick="hider('<?php echo $rs['iduser']; ?>','<?php echo $rs['status']; ?>');"></font>
                </td>
                <td>
                    <font color="red" class="icon-user-times" onclick="del(<?php echo $rs['iduser']; ?>);"></font>
                </td>
            </tr>

            <?php  
            }
                mysqli_close($con);  
                mysqli_free_result($res);
        } ?>
        </table>
    </div>

    <?php } else{ ?>
    <!--  LINK A EDITAR USUARIOS -->
    <div class="menu">
        <font color="white"><img src="../src/imgclear.png"><a href="company.php">IDCSchool</a></font>
        <span class="icon-confi" onclick="openwindows('','#divUser');"> <?php echo $_SESSION['user']; ?></span> |
        <button onclick="window.location.href='../admin/logout.php'" class="icon-logout"></button>
    </div>
    <!--  DIV BOTONES PRINCIPALES-->
    <div class="divbtn">
        <button class="btn icon-calendar-plus-o" onclick="openwindows(this, '#divReserve');"></button>
        <button class="btn icon-calendar-check-o" id="default" onclick="openwindows(this, '#divReservations');"></button>
        <?php  if(strcasecmp($_SESSION['type'],"business")!=0){?>
        <button class="btn icon-save" onclick="openwindows(this, '#divAccount');"></button>
        <button class="btn icon-calculator" onclick="openwindows(this, '#divHistory');"></button>
        <?php }  ?>
    </div>

    <!-- DIV HACER RESERVACINES -->
    <div class="divtab" id="divReserve">
        <h2>HACER CITA</h2>
        <form id="formReserve">
            <?php  
            if(strcasecmp($_SESSION['type'],"business")==0){ ?>
            <select name="user" required id="iduser">
                <?php 
                  include("../admin/connection.php"); 
                  $res = mysqli_query($con, "SELECT * FROM users WHERE business='".$_SESSION['business']."' AND status='enabled' AND iduser!=".$_SESSION['iduser']." ORDER BY user"); 
                        if( mysqli_num_rows($res) > 0 ){ ?>
                <option value="" selected>Personal</option>
                <option value="Anybody">Cualquiera</option>
                <?php
                            while($rs=mysqli_fetch_array($res)){ ?>
                <option value="<?php echo $rs['iduser']; ?>"><?php echo $rs['user']; ?></option>
                <?php           }
                        }else{ ?>
                <option value="" selected>Sin personal</option>
                <option value="Anybody">Cualquiera</option>
                <?php       } mysqli_close($con);  mysqli_free_result($res); ?>
            </select>
            <?php } ?>

            <fieldset id="cita" style="display:flex">
                <legend>Fecha y Hora:</legend>
                <input id="date" type="date" name="date" min="<?php echo date('Y-m-d'); ?>" required value="<?php echo date('Y-m-d'); ?>">
                <input id="time" type="time" name="hour" min="<?php echo date('09:00'); ?>" max="<?php echo date('19:00'); ?>" required value="<?php echo date("H:i");?>">
            </fieldset>
            <input type="text" name="name" maxlength="50" placeholder="Nombre" required>
            <input type="tel" name="phone" placeholder="Celular" maxlength="17">
            <textarea name="menssage" rows="3" placeholder="Mensaje" maxlength="200"></textarea>
            <fieldset id="tiempoEstimado">
                <legend>Tiempo estimado:</legend>

                <div>
                    <label>
                        <input id="hours" type="number" name="hours" min="0" max="12" value="00">Horas:
                        <input id="minutes" type="number" name="minutes" min="0" max="60" value="45" step="5">Minutos
                    </label>
                </div>

            </fieldset>
            <p id="infocita"></p>
            <button type="submit">Guardar</button>
            <label id="mnj" style="color:green"></label>
        </form>
        <script>
            $("#date, #time, #hours, #minutes").change(function() {

                if ($(this).val() != "") {
                    var date = $("#date").val();
                    var time = $("#time").val();
                    var hours = $("#hours").val();
                    var minutes = $("#minutes").val();

                    $.ajax({
                        type: 'POST',
                        url: '../admin/save.php',
                        data: {
                            iduser: $('#iduser').val(),
                            date: date,
                            time: time,
                            hours: hours,
                            minutes: minutes,
                            validarCita: ''
                        },
                        success: function(data) {
                            $("#infocita").html(data);
                        }
                    });
                    return false;
                }
            });

            $('#formReserve').submit(function() {
                $.ajax({
                    type: 'POST',
                    url: '../admin/save.php',
                    data: $(this).serialize(),
                    success: function(data) {
                        document.getElementById("formReserve").reset();
                        openwindows('button.icon-calendar-check-o', '#divReservations');
                    }
                });
                return false;
            });

        </script>
    </div>

    <!--    DIV VER RESERBACIONES-->
    <div class="divtab" id="divReservations">
        <form id="verCitas">
            <fieldset>
                <legend>[Buscar por]</legend>
                <?php  if(strcasecmp($_SESSION['type'],"business")==0){?>
                <select name="iduser">
                    <?php 
                include("../admin/connection.php");
		        $res = mysqli_query($con, "SELECT * FROM users WHERE business='".$_SESSION['business']."' AND status='enabled' AND iduser!=".$_SESSION['iduser']." ORDER BY user");
                if( mysqli_num_rows($res) > 0 ){ ?>
                    <option value="" selected>Staff</option>
                    <?php   while($rs=mysqli_fetch_array($res)){ ?>
                    <option value="<?php echo $rs['iduser']; ?>"><?php echo $rs['user']; ?></option>
                    <?php   }
                }else{ ?>
                    <option value="" selected>No staff</option>
                    <?php }
                mysqli_close($con);
                mysqli_free_result($res);
            ?>
                </select>
                <?php } ?>
                <input type="date" name="dateBrowse" id="dateBrowse" value="<?php echo date("Y-m-d"); ?>" disabled>
                <input type="checkbox" id="switchDateBrowse">
                <label for="switchDateBrowse"></label>
            </fieldset>
        </form>
        <script>
            function chat() {
                $('#switchDateBrowse').change(function() {
                    if ($(this).is(':checked')) {
                        $('#dateBrowse').attr('disabled', false);
                    } else {
                        $('#dateBrowse').attr('disabled', true);
                        document.getElementById('verCitas').reset();
                    }
                });

                $.ajax({
                    type: 'POST',
                    url: '../admin/functions.php',
                    data: $('#verCitas').serialize(),
                    success: function(data) {
                        $("#divcitas").html(data);
                    }
                });
                return false;
            }
            var interval = setInterval(function() {
                chat();
            }, 1000);
        </script>

        <div id="divcitas">
            <center><img src='../src/calendar.gif' alt='loading' width="100%"></center>
        </div>
        <br><br><br>
    </div>

    <!--   DIV EDITAR USUARIOS-->
    <div class="divtab" id="divUser">
        <?php 
            include("../admin/connection.php");
                $res = mysqli_query($con, "SELECT * FROM users WHERE iduser='".$_SESSION['iduser']."'");
                while($rs=mysqli_fetch_array($res)){
                $iduser=$rs['iduser'];
                $user=$rs['user'];
                $percent=$rs['percent'];
                $email=$rs['email'];
                $phone=$rs['phone'];
                $periodo=$rs['periodo'];
                $business=$rs['business'];
                $address=$rs['address'];
                $fech=date("M j, Y",time($rs['since']));
            }
		    
            mysqli_close($con);
            mysqli_free_result($res);
           ?>
        <h2 class="icon-usercircle">EDIT USER</h2>
        <form action="../admin/mng_staff.php" method="post" id="formEdit">
            <i><?php echo "Miembro desde: ".$fech ?></i>
            <label><?php echo "ID-".$iduser ?></label><br>
            <label><?php echo "Cuenta de ".$_SESSION['type']; ?></label>
            <?php if(strcasecmp($_SESSION['type'],"business")==0){ ?>
            <input list="dataListNegocios" name="business" required placeholder="Negocio" value="<?php echo $business ?>" id="inputBusiness">
            <datalist id="dataListNegocios">
                <?php 
                  include("../admin/connection.php"); 
		          $res = mysqli_query($con, "SELECT DISTINCT(business)AS business FROM users ORDER BY business");
		          while($rs=mysqli_fetch_array($res)){ ?>
                <option value="<?php echo $rs['business']; ?>">
                    <?php 
            }
                  mysqli_close($con);
                  mysqli_free_result($res);
           ?>
            </datalist>
            <input type="text" name="address" placeholder="Dirección" value="<?php echo $address ?>">
            <?php }else{ ?>
            <select name="business" id="selectNegocio" required>
                <option value="<?php echo $business ?>" selected><?php echo $business ?></option>
                <?php 
                  include("../admin/connection.php"); 
		          $res = mysqli_query($con, "SELECT DISTINCT(business)AS business FROM users ORDER BY business");
		          while($rs=mysqli_fetch_array($res)){ ?>
                <option value="<?php echo $rs['business']; ?>"><?php echo $rs['business']; ?></option>
                <?php 
            }
                  mysqli_close($con);
                  mysqli_free_result($res);
           ?>
            </select>
            <?php } ?>
            <input type="hidden" name="iduser" value="<?php echo $iduser ?>" id="id">
            <input type="text" name="user" required placeholder="Usuario" value="<?php echo $user ?>">
            <input type="email" name="email" placeholder="Correo" value="<?php echo $email ?>">
            <input type="tel" name="phone" placeholder="Teléfono" value="<?php echo $phone ?>">
            <?php  
            if(strcasecmp($_SESSION['type'],"business")!=0){ ?>
            <input type="number" min="1" max="100" name="percent" required placeholder="Porciento" value="<?php echo $percent ?>">
            <select name="periodo" required>
                <option value="">Forma de pago</option>
                <option value="<?php echo $periodo ?>" selected><?php echo $periodo ?></option>
                <option value="Diario">Diario</option>
                <option value="Semanal">Semanal</option>
                <option value="Quincenal">Quincenal</option>
                <option value="Mensual">Mensual</option>
            </select>
            <?php }?>
            <input type="password" name="pass" id="spass" placeholder="Contraseña" required>
            <input type="checkbox" onchange="showpass('spass','#spw');" style="width:15px; margin-right:3px;">
            <span id="spw">Mostrar contraseña</span><br><br>
            <button type="submit" name="editar">Editar</button>
        </form>

        <script>
            $("#formEdit input[type='text'], #formEdit input[type='email'], #formEdit input[type='tel'], #inputBusiness").focusout(function() {
                if ($(this).val() != "") {
                    var ruta = $('#formEdit').attr('action');
                    var name = $(this).attr("name");
                    $('#formEdit #infoerror').remove();
                    $(this).after("<p id='infoerror'></p>");

                    $.ajax({
                        type: 'POST',
                        url: ruta,
                        data: {
                            inputVal: $(this).val(),
                            name: name,
                            validarEdit: '',
                            inputId: $('#formEdit #id').val()
                        },
                        success: function(data) {
                            $("#infoerror").html(data);
                        }
                    });
                    return false;
                }
            });

        </script>

        <?php if(strcasecmp($_SESSION['type'],"business")==0){ ?>
        <div>
            <table>
                <tr>
                    <th colspan="2">SHOW & HIDE USERS</th>
                </tr>
                <?php 
            include("../admin/connection.php");
		$res = mysqli_query($con, "SELECT * FROM users WHERE business='$business' AND iduser!=".$_SESSION['iduser']." ORDER BY user");
		if(mysqli_num_rows($res)>0){ 
		while($rs=mysqli_fetch_array($res)){ ?>

                <tr>
                    <td><?php echo $rs['user']; ?></td>
                    <td>
                        <font <?php if($rs['status']=='enabled'){echo "class='icon-views' color='darkgreen'";}else{echo "class='icon-hide' color='darkorange'";} ?> onclick="hider('<?php echo $rs['iduser']; ?>','<?php echo $rs['status']; ?>');"></font>
                    </td>
                </tr>

                <?php 
            }
                mysqli_close($con);  
                mysqli_free_result($res);
        } ?>
            </table>
        </div>
        <?php }?>
        <br><br><br>
        <hr><br>
        <center style="color:red" class="icon-user-times" onclick="delAccount(<?php echo $_SESSION['iduser']; ?>);"> Eliminar Cuanta definitivamente.</center> <br><br>
        <script>
            function delAccount(id) {
                var eliminar = confirm('Al hacer clic en aceptar, se eliminará la cuenta de manera definitiva. ¿Seguro que deseas eliminarla?');
                if (eliminar) {
                    $.ajax({
                        type: 'POST',
                        url: '../admin/mng_staff.php',
                        data: {
                            delete: id
                        },
                        success: function(data) {
                            location.href = "../admin/logout.php";
                        }
                    });
                    return false;
                }
            }

            //MUESTRA Y OCULTA EL PASSWORD
            function showpass(input, tag) {
                var pass = document.getElementById(input);
                if (pass.type === "password") {
                    pass.setAttribute("type", "text");
                    $(tag).text("Ocultar contraseña");
                } else {
                    pass.setAttribute("type", "password");
                    $(tag).text("Mostrar contraseña");
                }
            }

        </script>
    </div>

    <?php  if(strcasecmp($_SESSION['type'],"business")!=0){?>

    <!--   DIV ACCOUNT-->
    <div id="divAccount" class="divtab">
        <h2>CAJA CHICA</h2>
        <form id="formacct">
            <input type="datetime-local" name="inptdate" id="inptdate" required value="<?php echo date("Y-m-d")."T".date("H:i"); ?>">
            <fieldset>
                <legend>Forma de pago:</legend>
                <label><input type="radio" name="tipo" required value="Cash" checked>Cash</label>
                <label><input type="radio" name="tipo" required value="Card">Card</label>
            </fieldset>

            <input type="number" name="total" placeholder="Valor del servicio" required id="total">
            <input type="number" name="tip" placeholder="Propina" id="tip">
            <button type="submit" name="submit">Guardar</button>
            <label id="lblaccount" style="color:green"></label>
        </form>

        <script>
            $('#formacct').submit(function() {
                $.ajax({
                    type: 'POST',
                    url: '../admin/save.php',
                    data: $(this).serialize(),
                    success: function(data) {
                        $('#formhistory').submit();
                        document.getElementById("formacct").reset();

                        openwindows('button.icon-calculator', '#divHistory');
                        location.href = "#btnTotales";
                    }
                });
                return false;
            });

        </script>
    </div>

    <!--   DIV HISTORY-->
    <div id="divHistory" class="divtab">

        <form id="formhistory">
            <?php  $dateOne;
                if($_SESSION['periodo']=="Diario"){
                    $dateOne = date("Y-m-d");
                }elseif($_SESSION['periodo']=="Semanal"){//MUESTRA LA FECHA DEL SABADO PASADO
                    $dateOne = date('Y-m-d',strtotime('saturday last week'));
                }elseif($_SESSION['periodo']=="Quincenal"){
                    $dateOne = (date("d")<=15 ? date("Y-m-01") :  date("Y-m-16") );
                }elseif($_SESSION['periodo']=="Mensual"){
                    $dateOne = date("Y-m-01");
                }
                                      
            ?>
            <fieldset align='center'>
                <legend>[Desde <span class="icon-random" style="margin:0 15px"></span> Hasta]</legend>

                <input type="date" name="dateOne" onchange="$('#formhistory').submit();" value="<?php echo $dateOne; ?>">
                <input type="date" name="dateTwo" onchange="$('#formhistory').submit();" value="<?php echo date("Y-m-d"); ?>">
                
<!--                LOS SIGUIENTES CAMPOS SONN SOLO PARA LAS GRAFICAS-->
                 <input type="hidden" name="iduser" value="<?php echo $_SESSION['iduser'] ?>">
            <input type="hidden" name="percent" value="<?php echo $_SESSION['percent'] ?>">
           
            </fieldset>
        </form>

        <div id="showHistory"> </div>

        <form id="formGrafica" style="display:non">
           <fieldset align='center'>
                <legend>[Config]</legend>

                <select name="intervalo" id="intervalo">
                    <option value="Diario" >Diario</option>
                    <option value="Semanal">Semanal</option>
                    <option value="Quincenal" selected>Quincenal</option>
                    <option value="Mensual">Mensual</option>
                </select>
                <select name="grafica">
                    <option value="scatter" selected>Lineas</option>
                    <option value="bar">Barras</option>
                    <option value="pie" disabled>Circulos</option>
                </select>
            </fieldset>
            
            <input type="hidden" name="iduser" value="<?php echo $_SESSION['iduser'] ?>">
            <input type="hidden" name="percent" value="<?php echo $_SESSION['percent'] ?>">
            <fieldset align='center'>
                <legend>[Desde <span class="icon-random" style="margin:0 15px"></span> Hasta]</legend>

                <input type="date" name="fecha1" id="fecha1" value="<?php echo (date("d")<=15 ? date("Y-m-01") : date("Y-m-16")); ?>">
                <input type="date" name="fecha2" value="<?php echo date("Y-m-d"); ?>">
            </fieldset>
        </form>

        <div id="graficas"> </div>
        <script>
            $(function() {
                $('#formhistory, #formGrafica').submit();

            });

            $('#formhistory input[type=date]').change(function() {
                $('#formGrafica').submit();
            });

            $('#intervalo').change(function() {
                
                if ($(this).val() == "Semanal") {
                    $('#fecha1').val("<?php  echo date("Y-m-d",strtotime("last sunday")); ?>");
                }else if ($(this).val() == "Quincenal") {                  
                    $('#fecha1').val("<?php echo  (date("d") <= '15' ? date("Y-m-t",strtotime('-1 months')) : date("Y-m-16") ); ?>");
                }else if ($(this).val() == "Mensual") {
                    $('#fecha1').val("<?php echo date('Y-m-01'); ?>");
                }

            });

            $('#formhistory').submit(function() {
                $.ajax({
                    type: 'POST',
                    url: '../admin/account.php',
                    data: $(this).serialize(),
                    success: function(data) {
                        $("#showHistory").html(data);
                    }
                });
                return false;
            });

            $('#formhistory').submit(function() {
                $("#graficas").html("<center><img src='../src/calendar.gif' alt='loading' width='50%'></center>");
                $.ajax({
                    type: 'POST',
                    url: '../admin/graficas.php',
                    data: $(this).serialize(),
                    success: function(data) {
                        $("#graficas").html(data);
                    }
                });
                return false;
            });

        </script>
    </div>
    <?php }} ?>
</body>

</html>
<?php }else{  header("location: ../index.php");   } ?>
