<!--
	DESARROLLADOR: JUAN CARLOS PANIAGUA
	VERSION: 20122019
	FECHA: 20 dec 2019
	
	PAGINA DE : inicio de secsion
-->
<?php 
    date_default_timezone_set('America/St_Thomas');  
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="description" content="A web for make appointments">
    <meta name="keywords" content="appointements, carlos, nails, saint thomas, virgin iliands">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="author" content="Juan C. Paniagua R.">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="shortcut icon" href="../src/imgclear.png" type="image/x-icon">
    <link rel="apple-touch-icon" href="../src/imgclear.png" type="image/x-icon">
    <title>reset password</title>
    <link rel="stylesheet" href="../src/icons/styles.css">
    <link rel="stylesheet" href="../css/styles.css">
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/script.js"></script>
    <style>
        p,
        cite {
            padding: 0 20px;
            text-align: justify;
            max-width: 350px;
            margin: auto;
            display: block;
        }
#loading{
    text-align: center;
    display: none;    
        }
        #loading img{max-width: 500px}
    </style>
</head>

<body>

    <section class="divbtn">
        <button class="btn" onclick="location.href='../index.php';"> <span class="icon-home"></span></button>
        <button class="btn" id="default" onclick="openwindows(this,'#contEmail');"> <span class="icon-mail"></span></button>
        <button class="btn" onclick="openwindows(this, '#contSMS');"> <span class="icon-phone"></span></button>
    </section>
    <section id="contEmail" class="divtab">
        <form id="resetByEmail">
            <h1 class="title">RECUPERAR CUENTA</h1>
            <h1 class="title">VÍA EMAIL</h1>
            <div class="inputs">
                <label for="name">* Ingrese correo</label>
                <input type="email" name="email" required placeholder="Email">
            </div>
            <button type="submit" name="signup" class="btn red">Enviar</button>
        </form>
    </section>

    <section id="contSMS" class="divtab">
        <form id="resetBySMS">
            <h1 class="title">RECUPERAR CUENTA</h1>
            <h1 class="title">VÍA SMS</h1>
            <div class="inputs">
                <label for="name">* Ingrese número móvil</label>
                <input type="tel" name="phone" required placeholder="Número móvil">
            </div>
            <button type="submit" name="signup" class="btn red">Enviar </button>
        </form>
    </section>
    
    <div id="loading">
    <p>Por favor, espere...</p>
    <img src="../src/calendar.gif" alt="Loading">
    </div>

    <script>        
        //ENVIA EL FORMULARIO                       
        $('#resetByEmail').submit(function() {
            $("#loading").show();
            $.ajax({
                type: 'POST',
                url: '../admin/reset_pass.php',
                data: $(this).serialize(),
                success: function(data) {
                    $("#contEmail").html(data);
                    $('#loading').hide();
                }
            });
            return false;
        });

        //ENVIA EL FORMULARIO                       
        $('#resetBySMS').submit(function() {
            $("#loading").show();
            $.ajax({
                type: 'POST',
                url: '../admin/reset_pass.php',
                data: $(this).serialize(),
                success: function(data) {
                    $("#contSMS").html(data);
                    $("#loading").hide();
                }
            });
            return false;
        });
    </script>

</body>

</html>
