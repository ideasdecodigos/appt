<!--
	DESARROLLADOR: JUAN CARLOS PANIAGUA
	VERSION: 31.01.2021
	FECHA: 20 dec 2019
	
	PAGINA DE : principal
-->
<?php 
    session_start();  
    
//setlocale(LC_TIME,"es_ES");
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

    <title>Main</title>

    <link rel="shortcut icon" href="../src/logoIcon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" href="../src/logoIcon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../src/icons/styles.css">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../js/sweetAlert2/sweetalert2.min.css">
<script id="mcjs">!function(c,h,i,m,p){m=c.createElement(h),p=c.getElementsByTagName(h)[0],m.async=1,m.src=i,p.parentNode.insertBefore(m,p)}(document,"script","https://chimpstatic.com/mcjs-connected/js/users/2b404ac94570862ce9506f407/7c303df84d81f51154cedef20.js");</script>

    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/sweetAlert2/sweetalert2.all.min.js"></script>
    <script src="../js/script.js"></script>
<!--    <script src="https://cdn.ckeditor.com/ckeditor5/31.1.0/classic/ckeditor.js"></script>-->
         <script src="https://cdn.ckeditor.com/ckeditor5/32.0.0/classic/ckeditor.js"></script>
    <!--    <script src="../src/ckeditor5-32.0.0-vbzvuobps4us/build/ckeditor.js"></script>  -->

    <style>
        @media print {

            .icon-trash,
            .icon-down,
            .icon-up,
            .icon-list-ul,
            .icon-list-ol,
            .icon-print,
            .icon-list {
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
    <?php  if((strcasecmp($_SESSION['type'],"business")==0) and (strcasecmp($_SESSION['user'],"root")==0)){ ?>
    <!--USUARIOS EN MODO ROOT-->
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
		$res = mysqli_query($con, "SELECT * FROM users WHERE user!='root' ORDER BY business, status DESC, user ASC");
		if(mysqli_num_rows($res)>0){ 
		while($rs=mysqli_fetch_array($res)){ ?>

            <tr>
                <td>
                    <a class="icon-usersecret" href="userRoot.php?iduser=<?php echo $rs['iduser']; ?>&name=<?php echo $rs['user']; ?>&percent=<?php echo $rs['percent']; ?>"> <?php echo $rs['user']; ?></a>
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
        <span class="icon-confi" onclick="openwindows('','#divUser');"> <?php echo ucwords($_SESSION['user']); ?></span> |
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
   
    <!--   DIV EDITAR USUARIOS-->
    <div class="divtab" id="divPromotion">
        <form id="formPromo"> 
            <h1>Crear Promoción</h1>
             <style>
                .icon-down, .icon-up{
                    display: block;
                    margin: auto;
                    text-decoration: none;
                    font-size: 2em;
                    font-weight: bold;
                    text-align: center;
                }
                 #clean{background: green} 
                 #reset{background: red}
                 #flex{display: flex;gap:5px; width: 105%;}
                 #flex button{ flex:1;}
            </style>

            <textarea id="promo" rows="10" placeholder="Ecriba su SMS aquí.." required></textarea>
            <input type="hidden" id="negocio" value="<?php echo $_SESSION['business']; ?>">
<!--            <button type="submit">Promocionar</button>-->
            <button type="button" id="prom">Promocionar</button>
            <div id="flex"><button type="reset" id="clean">Limpiar</button>
            <button type="button" id="reset">Finalizar Promo</button>
           </div>
            <a href="#fianl" class="icon-down"></a>
            <font id="totalContactos" color='dodgerblue'></font>
            <div id="mnjPromo"></div> 
             
            <?php   
            include("../admin/connection.php");
                $res = mysqli_query($con, "SELECT DISTINCT(tel)AS phone,(SELECT nombre FROM history WHERE tel = phone LIMIT 1)AS nombre FROM history WHERE businesses='".$_SESSION['business']."' AND tel!='' ORDER BY tel");
                 if(mysqli_num_rows($res) >0){
//                     echo "<center id='idnums'><font color='red'>".mysqli_num_rows($res)." Números encontrados.</font></center>";
                    while($rs=mysqli_fetch_array($res)){
                        echo "<br><label><input type='checkbox' name='tels[]' checked value='".$rs['phone']."'>".$rs['phone']." | ".ucwords($rs['nombre'])."</label>";          
                    }  		    
                    mysqli_close($con);
                    mysqli_free_result($res);
                 }
           ?>
           <hr>
           <a href="#formPromo" id="fianl" class="icon-up"></a>
        </form>
          
        <script> 
             //MUESTRA EL NUMERO DE CONTACTOS SELECIONADO
                $("#totalContactos").append("<span id='ntotal'>"+ $("input[type='checkbox']:checked").length +"</span> Contactos seleccionados de "+ $("input[type='checkbox']").length);

            //ACTUALIZA EL NUMERO DE CONTACTOS SELECIONADO
            $("input[type='checkbox']").click(function(){
                $('#ntotal').text($("input[type='checkbox']:checked").length);   
            });
               
            let timer = 0;
            //BOTON ENVIAR PROMOCION 
            $('#prom').click(function(){
                let tels = $("input[type='checkbox']:checked"); //TOTAL DE LOS CONTACTOS SELECCIONADOS
                let allTels = $("input[type='checkbox']"); // TOTAL DE LOS CONTACTOS ENCONTRADOS
                
//                $('#idnums').empty(); //ELIMINA EL TOTAL DE CONTACTOS ENCONTRADOS
                //MUESTRA LA IMG DE LOADIONG...
                $('#mnjPromo').html("<center id='img'><img src='../src/sms.gif' alt='loading' style='width:300px;'></center>");
                //LIMPIA EL INTERVAL
                clearInterval(timer);
                let i = 0; 
                //ENVIA LA INFORMACION CADA 5 SEGUNDOS
               timer = setInterval(function(){   
                   if(i < tels.length){ 
                        $.ajax({
                            type: 'POST',
                            url: '../admin/promo.php',      
                            data: {promo: $('#promo').val(), negocio: $('#negocio').val(), tel: tels[i].value },
                            success: function(data) {
                                $("#mnjPromo").append("<br>"+ data); i++;
                            }
                        });
                        return false;
                       
                   }else{ 
                       $('#img').empty();
                       $("#mnjPromo").append("<br><b>"+ i +" Contactos Procesados.<b>");
                       $("#mnjPromo").append("<br><font color='red'>Proceso finalizado.</font>");
                      clearInterval(timer); 
                   }
                                      
                },5000);
            });
            //BOTON CANCELAR PROMOCION
            $('#reset').click(function(){
                $('#img').empty();
                $("#mnjPromo").append("<br><br><font color='red'>Proceso Cancelado.</font>");
                clearInterval(timer);
            }); 

        </script>
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
                    $fech=date("M j, Y",strtotime($rs['since']));
                    $open=date("H:i",strtotime($rs['open']));
                    $close=date("H:i",strtotime($rs['close']));
                }
		    
            mysqli_close($con);
            mysqli_free_result($res);
           ?>
        <style>#formEdit label{color: dodgerblue}</style>
        <h2 class="icon-usercircle">EDIT USER</h2>
        <section>
            <?php if($_SESSION['type']=="business"){ ?>
            <a href="javascript:void(0)" class="btn icon-globe" onclick="openwindows(this, '#divPromotion');"> Promocionar</a>
            <a href="javascript:void(0)" class="btn icon-file1" onclick="openwindows(this, '#divPolicy');"> Politicas</a>
            <?php } ?>
            <a href="javascript:void(0)" class="btn icon-calendar-minus-o" onclick="openwindows(this, '#divHistorial');"> Historial</a>
            <hr>
        </section>
        <form action="../admin/mng_staff.php" method="post" id="formEdit">
            <i><?php echo "Miembro desde: ".$fech ?></i>
            <label><?php echo "ID".$iduser. " | ". strtoupper($_SESSION['type']); ?></label>

            <?php if(strcasecmp($_SESSION['type'],"business")==0){ ?>
            <br><label for="inputBusiness">Negocio:</label>
            <input list="dataListNegocios" name="business" required placeholder="Negocio" value="<?php echo $business ?>" id="inputBusiness">
            <datalist id="dataListNegocios">
                <?php 
                      include("../admin/connection.php"); 
                      $res = mysqli_query($con, "SELECT DISTINCT(business)AS business FROM users WHERE user!='root' ORDER BY business");
                      while($rs=mysqli_fetch_array($res)){ ?>
                <option value="<?php echo $rs['business']; ?>">
                    <?php 
                }
                      mysqli_close($con);
                      mysqli_free_result($res);
               ?>
            </datalist>
            <label for="address">Dirección:</label>
            <input type="text" name="address" placeholder="Dirección" id="address" value="<?php echo $address ?>">
            <fieldset>
                <legend>Horario</legend>
                <input type="time" name="open" title="Open" value="<?php echo $open ?>">
                <input type="time" name="close" title="Close" value="<?php echo $close ?>">
            </fieldset>
            <?php }else{ ?> 
             <br><span>Horario (<?php echo date("h:ia",strtotime($open))." - ". date("h:ia",strtotime($close)) ?>)</span>
            <select name="business" id="selectNegocio" required>
                <option value="<?php echo $business ?>" selected><?php echo $business ?></option>
                <?php 
                  include("../admin/connection.php"); 
		          $res = mysqli_query($con, "SELECT DISTINCT(business)AS business FROM users WHERE user!='root' ORDER BY business");
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
            <label for="nombre">Nombre:</label>
            <input type="text" name="user" id="nombre" required placeholder="Usuario" value="<?php echo $user ?>">
            <label for="email">Correo:</label>
            <input type="email" name="email" placeholder="Correo" id="correo" value="<?php echo $email ?>">
            <label for="telephone">Teléfono:</label>
            <input type="tel" name="phone" placeholder="Teléfono" id="telephone" value="<?php echo $phone ?>">

            <?php  
            if(strcasecmp($_SESSION['type'],"business")!=0){ ?>
            <label for="porciento">Porciento:</label>
            <input type="number" min="1" max="100" name="percent" id="porciento" required placeholder="Porciento" value="<?php echo $percent ?>">
            <label for="periodo">Periodo:</label>
            <select name="periodo" required id="periodo">
                <option value="">Forma de pago</option>
                <option value="<?php echo $periodo ?>" selected><?php echo $periodo ?></option>
                <option value="Diario">Diario</option>
                <option value="Semanal">Semanal</option>
                <option value="Quincenal">Quincenal</option>
                <option value="Mensual">Mensual</option>
            </select>
            <?php }?>
            <label for="spass">Contraseña:</label>
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
		$res = mysqli_query($con, "SELECT * FROM users WHERE business='$business' AND iduser!=".$_SESSION['iduser']." ORDER BY status DESC, user ASC");
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
        <br>
        <hr><br>
        <section>
            <a href="javascript:void(0)" class="icon-user-times" onclick="delAccount(<?php echo $_SESSION['iduser']; ?>);"> Eliminar Cuenta</a>
        </section>
        <br><br><br>
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

    <!-- DIV EDITAR POLITICAS -->
    <div class="divtab" id="divPolicy">
        <br>
        <h2>CREAR O EDITAR POLITICAS</h2><br>
        <form id="editPolicy">

            <div id="start">
                <fieldset>
                    <legend>Selecione el idioma</legend>
                    <label for="enx">
                        <input id="enx" type="radio" name="lang" onclick="getPolicy($(this).val(),'<?php echo $_SESSION['business'] ?>');" value="en"> En
                    </label>
                    <label for="esx">
                        <input id="esx" type="radio" name="lang" onclick="getPolicy($(this).val(),'<?php echo $_SESSION['business'] ?>');" value="es"> Es
                    </label>
                    <label for="frx">
                        <input id="frx" type="radio" name="lang" onclick="getPolicy($(this).val(),'<?php echo $_SESSION['business'] ?>');" value="fr"> Fr
                    </label>
                </fieldset>
            </div>

            <div id="end" style="display:none">
                <section class="secBody">
                    <textarea name="politicas" id="editor" placeholder="Write business policies here"></textarea>

                    <input type="datetime-local" name="fecha" required value="<?php echo date("Y-m-d")."T".date("H:i:s"); ?>">
                    <input type="hidden" name="negocio" value="<?php echo $_SESSION['business']; ?>">
                    <div style="display: flex;gap:3px">

                        <button type="button" onclick="$('#end').hide();$('#start').show();" style="background-color:red">Atrás</button>
                        <button type="submit" id="submit">Editar</button>
                    </div>
                    <div id="mnsjs"></div>

                </section>
            </div>
        </form>

        <script>
            //CREA EL CK-EDITOR 5
            ClassicEditor
                .create(document.querySelector('#editor'), {
                    removePlugins: ['insertImage', 'bold'],
                    //        toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote' ],

                    heading: {
                        options: [{
                                model: 'paragraph',
                                title: 'Paragraph',
                                class: 'ck-heading_paragraph'
                            },
                            {
                                model: 'heading1',
                                view: 'h1',
                                title: 'Title',
                                class: 'ck-heading_heading1'
                            },
                            {
                                model: 'heading2',
                                view: 'h2',
                                title: 'Subtitle',
                                class: 'ck-heading_heading2'
                            }
                        ]
                    }
                })
                .catch(error => {
                    console.error(error);
                });

            //OCULTA Y MUESTRA LOS DIV DE LAS POLITICAS
            function getPolicy(lang, business) {
                $.ajax({
                    type: 'POST',
                    url: '../admin/manage.php',
                    data: {
                        idioma: lang,
                        business: business,
                    },
                    success: function(data) {
                        $("#mnsjs").html(data); //MUESTRA LA POLITICA EN EL IDOMA SELECIONADO
                        $("#mnsjs").prepend("<h2>Area del contenido:"); //MUESTRA LA POLITICA EN EL IDOMA SELECIONADO
                        $('#start').hide(); //OCULTA EL IDOMA 
                        $('#end').show(); //MUESTRA EL FORMULARIO 
                        //$('#' + lang).prop("checked", true); //SELECCIONA EL IDIOMA DE LA POLITICA
                    }
                });
                return false;
            }

            //GUARDA O EDITA LAS POLITICAS
            $('#editPolicy').submit(function() {
                $.ajax({
                    type: 'POST',
                    url: '../admin/manage.php',
                    data: $(this).serialize(),
                    success: function(data) {
                        $("#mnsjs").html(data);

                        $('#end').hide(); //OCULTA EL IDOMA             
                        $('#start').show(); //MUESTRA EL FORMULARIO 
                        document.getElementById("editPolicy").reset();
                    }
                });
                return false;
            });

        </script>
        <br><br><br>
    </div>

    <!-- DIV HACER RESERVACINES -->
    <div class="divtab" id="divReserve">
        <h2>HACER CITA</h2>
        <form id="formReserve">
            <?php  
            if(strcasecmp($_SESSION['type'],"business")==0){ ?>
            <section id="secUser"></section>

            <?php }//} else{            
                include("../admin/connection.php");
                $res = mysqli_query($con, "SELECT * FROM users WHERE business='".$_SESSION['business']."' AND type='business'");
                while($rs=mysqli_fetch_array($res)){
                    $open=date("H:i",strtotime($rs['open']));
                    $close=date("H:i",strtotime($rs['close']));
                    $name=$rs['user'];
                    $business=$rs['business'];
                    $address=$rs['address'];
                    $type=$rs['type'];
                    $tel=$rs['phone'];
                }		    
                mysqli_close($con);
                mysqli_free_result($res);
            //}
            ?>
            <section class="secBody">
                <fieldset id="cita" style="display:flex">
                    <legend>Fecha y Hora:</legend>
                    <input id="date" type="date" name="date" min="<?php echo date('Y-m-d'); ?>" required value="<?php echo date('Y-m-d'); ?>">
                    <input id="time" type="time" name="hour" min="<?php echo $open; ?>" max="<?php echo $close; ?>" required value="<?php echo date("H:i");?>">
                    <!--USO SOLO PARA VALIDAR CITAS DISPONIBLES -->
                    <input type="hidden" id="empleado" readonly value="<?php echo $_SESSION['iduser'] ?>">
                </fieldset>
                <fieldset>
                    <legend>Info Cliente:</legend>
                    <div class="infoCliente">
                        <input type="text" name="name" maxlength="50" placeholder="Nombre" required>
                        <input type="tel" name="phone" placeholder="Celular" maxlength="10" class="onlyNumber">
                        <textarea name="menssage" rows="2" placeholder="Mensaje" maxlength="200"></textarea>
                        <input type="hidden" name="employee" id="employee" value="<?php echo $_SESSION['user'] ?>">
                        <input type="hidden" name="address" value="<?php echo $address ?>">
                        <input type="hidden" name="business" value="<?php echo $business ?>">
                        <input type="hidden" name="currentDate" value="<?php echo date('Y-m-d H:i:s');?>">
                        <input type="hidden" name="businessPhone" value="<?php echo $tel;?>">
                    </div>
                </fieldset>
                <fieldset>
                    <legend>Tiempo estimado:</legend>
                    <section id="tiempoEstimado">
                        <input type="range" name="inputRange" min="5" max="240" step="5" value="50" id="inputRange">

                        <div>
                            <input type="hidden" id="hora" value="0">
                            <label><span id="hours">0</span> Horas </label>
                            <label><span id="minutes">50</span> Minutos</label>
                        </div>
                    </section>
                </fieldset>
                <p id="infocita"></p>
                <button type="submit">Guardar</button>
                <label id="mnj" style="color:green"></label>
            </section>
        </form>
        <script>
            //MUESTRA EL TIEMPO ESTIMADO DEL INPUTRANGE EN HORAS Y MINUTOS
            $("#inputRange").change(function() {
                let rval = $(this).val();
                //MUESTRA EL TIEMPO EN HORA
                if (rval >= 240) {
                    $("#hours").text(4);
                    $("#hora").val(4);
                } else if (rval >= 180) {
                    $("#hours").text(3);
                    $("#hora").val(3);
                } else if (rval >= 120) {
                    $("#hours").text(2);
                    $("#hora").val(2);
                } else if (rval >= 60) {
                    $("#hours").text(1);
                    $("#hora").val(1);
                } else {
                    $("#hours").text(0);
                    $("#hora").val(0);
                } //MUESTRA EL TIEMPO EN MINUTOS
                $("#minutes").text(-1 * (($("#hora").val() * 60) - rval));
            });

            //VALIDA QUE EL TIEMPO DE LA CITA ESTE DISPONIBLE
            $("#date, #time, #inputRange, #empleado").change(function() {

                if ($(this).val() != "") {
                    let empleado = $("#empleado").val();
                    let date = $("#date").val();
                    let time = $("#time").val();
                    let inputRange = $("#inputRange").val();

                    $.ajax({
                        type: 'POST',
                        url: '../admin/save.php',
                        data: {
                            iduser: empleado,
                            date: date,
                            time: time,
                            inputRange: inputRange,
                            validarCita: ''
                        },
                        success: function(data) {
                            $("#infocita").html(data);
                        }
                    });
                    return false;
                }
            });

            $('.onlyNumber').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
            });

            //GUARDA LA CITA
            $('#formReserve').submit(function() {
                $('#infocita').html("<center><img src='../src/calendar.gif' alt='loading' style='width:300px;'></center>");

                $.ajax({
                    type: 'POST',
                    url: '../admin/save.php',
                    data: $(this).serialize(),
                    success: function(data) {
                        document.getElementById("formReserve").reset();
                        $('#infocita').html(data);
                        openwindows('button.icon-calendar-check-o', '#divReservations');
                    }
                });
                return false;
            });

        </script>
        <br><br><br><br><br><br><br>
    </div>

    <!--    DIV VER HITORIAL DE CITAS-->
    <div class="divtab" id="divHistorial">


        <?php $fecha__actual = date("d-m-Y");  ?>
        <center>
            <h2>HISTORIAL DE CITAS</h2>
            <fieldset>
                <legend>Buscar desde:</legend>
                <input type="date" id="from" value="<?php echo date("Y-m-d",strtotime($fecha__actual."- 30 days")); ?>" onchange="historial();">
            </fieldset>
        </center>
        <hr>


        <div id="divhistory">
            <center><img src='../src/calendar.gif' alt='loading' width="100%"></center>
        </div>
        <br><br><br>
        <script>
            function historial(fecha) {
                $.ajax({
                    type: 'POST',
                    url: '../admin/historial.php',
                    data: {
                        from: $('#from').val()
                    },
                    success: function(data) {
                        $("#divhistory").html(data);
                    }
                });
                return false;
            }
            var interval = setInterval(function() {
                historial();
            }, 1000);

        </script>
    </div>

    <!--    DIV VER RESERBACIONES-->
    <div class="divtab" id="divReservations">

        <div id="divcontainer">
            <div id="divfiltrar"> </div>
            <div id="divcitas">
                <center><img src='../src/calendar.gif' alt='loading' width="100%"></center>
            </div>
        </div>
        <br><br><br>
        <script>
            renderizar();
            $(window).resize(function() {
                renderizar();
            }); 

            function renderizar() { 
                if (screen.width > 500) {
                    $('#divfiltrar').load("filtroPc.php");
                    $('#secUser').load("inputUserPc.php");
                    $('#formReserve').css({display:'flex'});
                } else {
                    $('#divfiltrar').load("filtroMobile.php");
                    $('#secUser').load("inputUserMobile.php");
                    $('#formReserve').css({display:'grid'});
                }
            }

            var interval = "";

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
            interval = setInterval(function() {
                chat()
            }, 1000);

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
            $('button.icon-save').click(function() {
                var x = new Date();
                var minutos = (x.getMinutes() < 10 ? '0' + x.getMinutes() : x.getMinutes());
                var hora = (x.getHours() < 10 ? '0' + x.getHours() : x.getHours());
                var dia = (x.getDate() < 10 ? '0' + x.getDate() : x.getDate());
                var mes = x.getMonth() + 1;
                mes = (mes < 10 ? '0' + mes : mes);

                $('#inptdate').val(x.getFullYear() + '-' + mes + '-' + dia + 'T' + hora + ':' + minutos);
            });

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

    <!--   DIV HISTORY DE CUENTA-->
    <div id="divHistory" class="divtab">

        <form id="formhistory">
            <?php  
            function firstDate(){
                if($_SESSION['periodo']=="Diario"){
                    return date("Y-m-d");
                }elseif($_SESSION['periodo']=="Semanal"){//MUESTRA LA FECHA DEL SABADO PASADO
                    return date('Y-m-d',strtotime('saturday last week'));
                }elseif($_SESSION['periodo']=="Quincenal"){
                    return (date("d")<=15 ? date("Y-m-01") :  date("Y-m-16") );
                }elseif($_SESSION['periodo']=="Mensual"){
                    return date("Y-m-01");
                }else{
                    return (date("d")<=15 ? date("Y-m-01") :  date("Y-m-16") );
                }
            }
            ?>
            <fieldset align='center'>
                <legend>[Desde <span class="icon-random" style="margin:0 15px"></span> Hasta]</legend>

                <input type="date" name="dateOne" onchange="$('#formhistory').submit();" value="<?php echo firstDate(); ?>">
                <input type="date" name="dateTwo" onchange="$('#formhistory').submit();" value="<?php echo date("Y-m-d"); ?>">

                <!--                LOS SIGUIENTES CAMPOS SONN SOLO PARA LAS GRAFICAS-->
                <input type="hidden" name="iduser" value="<?php echo $_SESSION['iduser'] ?>">
                <input type="hidden" name="percent" value="<?php echo $_SESSION['percent'] ?>">

            </fieldset>
        </form>

        <div id="showHistory"> </div>

        <script>
            $(function() {
                $('#formhistory').submit();
            });

            $('button .btn .icon-save').click(function() {
                document.getElementById("formhistory").reset();
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

        </script>
    </div>
    <?php }} ?>

    <br><br><br><br><br><br><br>
</body>

</html>
<?php }else{  header("location: ../index.php");   } ?>
