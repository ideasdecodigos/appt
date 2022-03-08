 <?php 
    if(isset($_COOKIE["user"]) && isset($_COOKIE["pass"])){
        include("admin/autentication.php");
        
} ?>
 <!--
	DESARROLLADOR: JUAN CARLOS PANIAGUA
	VERSION: 20122019
	FECHA: 20 dec 2019
	
	PAGINA DE : inicio de secsion
-->
 <!DOCTYPE html>
 <html lang="en"> 
 
 <head> 
     <meta charset="utf-8"> 
     <meta name="description" content="A web for make appointments">
     <meta name="keywords" content="appointements, carlos, nails, saint thomas, virgin iliands">
     <meta http-equiv="X-UA-Compatible" content="IE=Edge">
     <meta name="author" content="Juan C. Paniagua R.">
     <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
     <link rel="shortcut icon" href="src/imgclear.png" type="image/x-icon">
     <link rel="apple-touch-icon" href="src/logoIcon.ico" type="image/x-icon">
     <title>access</title>
     <link rel="stylesheet" href="css/styles.css">
     <link rel="stylesheet" href="src/icons/styles.css">
     <script src="js/jquery-3.3.1.min.js"></script>
     <script src="js/script.js"></script>
 </head>

 <body>
     <div class="divbtn">
         <button class="btn icon-login" id="default" onclick="openwindows(this, '#divlogin');"></button>
         <button class="btn icon-user-plus" onclick="openwindows(this, '#divsignup');"></button>
     </div>
     <div class="welcome">
         <img src="../config/schedule.png" alt="Logo" onclick="location.href='../'">
         <h1>Welcome</h1>
         <i>to Appt. Manager.</i>
     </div>
     <hr>

     <div class="divtab" id="divlogin">
         <h2>ACCEDER</h2>
         <form action="admin/mng_staff.php" method="post" id="formLogin">
             <input type="text" name="user" required placeholder="Usuario o Correo">
             <input type="password" name="pass" id="lpass" placeholder="Contraseña">

             <input type="checkbox" onchange="showpass('lpass','#lpw');">
             <span id="lpw">Mostrar contraseña</span><br>
             <input type="checkbox" name="cookie" id="cookie" value="Olvídame" checked>
             <span id="ckinfo">Olvídame</span>
             <button type="submit" name="login">Entrar</button>
             <br>
             <p> <span onclick="location.href='app/reset.php';">Olvide mi contrseña. </span> |
                 <span onclick="location.href='app/help.php#acceder';">¿Cómo acceder?</span>
             </p>
         </form>

     </div>

     <div class="divtab" id="recuperarPass">
         <h2>RECUPERAR CONTRASEÑA</h2>
         <section>
            <center>
             <a href="javascript:void(0);" class='icon-mail' onclick="chooseMethod('mail')"> Enviar un link a mi correo.</a>
             <br>
             <br>
             <a href="javascript:void(0);" class='icon-phone' onclick="chooseMethod('cell')"> Enviar un link SMS a mi celular.</a>
             </center>
         </section>


         <form id="formResetPassword">
             <a href="javascript:void(0);" class='icon-refresh' onclick="$('#formResetPassword , section').toggle();"> Intentar con otro método de recuperación.</a>
             <br><br>
             <input type="hidden" name="resetPass" id="method">
             <input type="hidden" name="url" id="url">
             <input type="text" name="mailCell" required id="txtinput">
             <button type="submit">Enviar link</button>
             <div id="msm"></div>
             <p>
                 <span onclick="openwindows('', '#divsignup');">Crear una cuenta.</span> |
                 <span onclick="openwindows('', '#divlogin');">Acceder.</span>
             </p>


         </form>

         <script>
             $('#formResetPassword ').toggle();

             function chooseMethod(method) {
                 if (method == "mail") {
                     $('#method').val(method);
                     $('#txtinput').attr('placeholder', 'Ingresa tu correo electrónico.');
                 } else {
                     $('#method').val(method);
                     $('#txtinput').attr('placeholder', 'Ingresa tu número de celular.');
                 }

                 $('#formResetPassword , section').toggle();

             }

             $('#formResetPassword').submit(function() {
                 $('#url').val(window.location.href);
                 $.ajax({
                     type: 'POST',
                     url: 'admin/mng_staff.php',
                     data: $(this).serialize(),
                     success: function(data) {
                         $("#msm").html(data);
                     }
                 });
                 return false;
             });

         </script>
     </div>

     <div class="divtab" id="divsignup">
         <h2>REGISTRARSE</h2>
         <form action="admin/mng_staff.php" method="post" id="formSignup">
             <fieldset style="display:inline;text-align:center">
                 <legend>[Tipo de cuenta]</legend>
                 <input type="radio" name="type" value="personal" checked id="radioStaffSignup" style="width:15px;">Personal
                 <input type="radio" name="type" value="business" id="radioBusinessSignup" style="width:15px;">Negocio
             </fieldset>
             <input type="text" list="dataListNegocios" name="business" required placeholder="Negocio" id="inputNegocio">

             <datalist id="dataListNegocios">
                 <?php 
                  include("admin/connection.php"); 
		          $res = mysqli_query($con, "SELECT DISTINCT(business)AS business FROM users ORDER BY business");
		          while($rs=mysqli_fetch_array($res)){ ?>
                 <option value="<?php echo $rs['business']; ?>">
                     <?php 
            }
                  mysqli_close($con);
                  mysqli_free_result($res); 
           ?> 
             </datalist> 

             <select name="business" id="selectNegocio" required>
                 <option value="" selected>Negocio al que pertenece</option>
                 <?php 
                  include("admin/connection.php"); 
		          $res = mysqli_query($con, "SELECT DISTINCT(business)AS business FROM users ORDER BY business");
		          while($rs=mysqli_fetch_array($res)){ ?>
                 <option value="<?php echo $rs['business']; ?>"><?php echo $rs['business']; ?></option>
                 <?php 
            }
                  mysqli_close($con);
                  mysqli_free_result($res);
           ?>
             </select>

             <input type="text" name="user" required placeholder="Nombre">
             <textarea name="address" id="direccion" rows="2" placeholder="Dirección"></textarea>
             <input type="email" name="correo" required placeholder="Correo">
             <input type="tel" name="phone" required placeholder="Teléfono">
             <input type="password" name="pass" id="spass" placeholder="Contraseña" required>
             <input type="number" min="1" maxlength="3" max="100" name="percent" required placeholder="Porciento" id="inputPorcent">
             <select name="periodo" required id="periodo">
                 <option value="" selected>Formato de pago</option>
                 <option value="Diario">Diario</option>
                 <option value="Semanal">Semanal</option>
                 <option value="Quincenal">Quincenal</option>
                 <option value="Mensual">Mensual</option>
             </select>
             <input type="checkbox" onchange="showpass('spass','#spw');" style="width:15px; margin-right:3px;">
             <span id="spw">Mostrar contraseña</span>
             <button type="submit" name="signup">Registrar</button>
             <br>
             <p>Ya tienes una cuenta? <span onclick="openwindows('', '#divlogin');">Accede.</span></p>
         </form>
     </div>
     <script>
         $("#formSignup input[type='text'], #formSignup input[type='email'], #formSignup input[type='tel'], #inputNegocio").focusout(function() {
             if ($(this).val() != "") {
                 var inputName = $(this).attr("name");
                 $("#" + inputName).remove();
                 $(this).after("<span id='" + inputName + "'></span>");

                 $.ajax({
                     type: 'POST',
                     url: 'admin/mng_staff.php',
                     data: {
                         inputVal: $(this).val(),
                         name: inputName,
                         validar: ''
                     },
                     success: function(data) {
                         $("#" + inputName).html(data);
                     }
                 });
                 return false;
             }
         });

         //CREAR CUENTA PARA NEGOCIOS
         $('#radioBusinessSignup').click(function() {
             if ($(this).is(':checked')) {
                 $("#inputNegocio,#direccion").show();
                 $("#inputNegocio,#direccion").attr('disabled', false);
                 $("#selectNegocio, #periodo, #inputPorcent").hide();
                 $("#selectNegocio, #periodo, #inputPorcent").attr('disabled', true);
             }
         });

         //CREAR CUENTA PARA EMPLEADOS
         $('#radioStaffSignup').click(function() {
             if ($(this).is(':checked')) {
                 $("#inputNegocio,#direccion").hide();
                 $("#inputNegocio,#direccion").attr('disabled', true);
                 $("#selectNegocio, #periodo, #inputPorcent").show();
                 $("#selectNegocio, #periodo, #inputPorcent").attr('disabled', false);
             }
         });

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

         //RECORDAR PASSWORD
         $('#cookie').on('change', function() {
             if ($(this).is(':checked')) {
                 $(this).val("Olvídame");
                 $("#ckinfo").text("Olvídame");
             } else {
                 $(this).val("Recuérdame");
                 $("#ckinfo").text("Recuérdame");

             }
         });

         $(function() {
             $('#radioStaffSignup').click();
         });

     </script> 
     <br><br>
     <center>
         <form action="https://www.paypal.com/donate" method="post" target="_top">
             <input type="hidden" name="hosted_button_id" value="2UUWMR9S7DMBS" />
             <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" />
             <img alt="" border="0" src="https://www.paypal.com/en_DO/i/scr/pixel.gif" width="1" height="1" />
         </form>
     </center>


     <br><br><br><br><br><br>
     <!--   ***********ALERTA DE COOKIES**************-->
     <style>
         #cajacookies a {
             text-decoration: none;
         }

         #cajacookies button {
             background: dodgerblue;
             color: white;
             border: none;
             padding: 10px;
             display: inline;
             display: block;
             margin: 10px auto;
             cursor: pointer;

         }

         #cajacookies {
             padding: 10px 20px;
             position: fixed;
             bottom: 20px;
             z-index: 10;
             color: white;
             background: rgba(0,0,0,0.5);
             display: block;
             margin: auto;
             width: 80%;
             max-width: 250px;
             border-radius: 5px;
             right: 10px;
             /*            bottom: 80px*/
         }

     </style>
     <div id="cajacookies">
         <p>
             Usaremos cookies para guardar tu información de acceso en tu dispositivo y accedas automáticamente la próxima vez. Saber más sobre las <a lang="en" translate="no" target="_blank" href="https://es.wikipedia.org/wiki/Cookie_(inform%C3%A1tica)">Cookies aquí.</a> </p>
         <button onclick="aceptarCookies()">Continuar</button>
     </div>

     <footer>

         <div class="redes">
             <a href="https://www.facebook.com/ideas.decodigos.3" target="_blank" title="Follow me in FaceBook"><img src="src/facebook.png" alt="facebook"></a>
             <a href="https://www.instagram.com/ideasdcodigos/" target="_blank" title="Follow me in Instagram"><img src="src/instagram.png" alt="instagram"></a>
             <a href="https://twitter.com/de_ideas" target="_blank" title="Follow me in Twitter"><img src="src/twitter.png" alt="twitter"></a>
             <a href="https://www.youtube.com/channel/UCwN59VLiuiL_GMX3fHTOf_A" target="_blank" title="Follow me in YouTube"><img src="src/youtube.png" alt="youtube"></a>
         </div>

         <br>
         <p>Copy rights © 2021 | All rights reserved by IDCSchool</p>
         <i> Desarrollado por Juan C. Paniagua</i>
         <div id="subir">
             <a href="#top" class="icon-up" title="Back to top"></a>
         </div>

         <br>
         <hr>
         <br>
         <p>
             <!--
        <a href="app/terms.php" target="_blank">Terms</a> |
        <a href="app/privacy.php" target="_blank">Privacy</a> | 
-->
             <a href="app/help.php" target="_blank">FAQs</a> |
             <a lang="en" translate="no" target="_blank" href="https://es.wikipedia.org/wiki/Cookie_(inform%C3%A1tica)">Cookies</a>
         </p>
         <br>
         <br>
     </footer>
     <script src="js/script.js"></script>
 </body>

 </html>
