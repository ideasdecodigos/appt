<!--
	DESARROLLADOR: JUAN CARLOS PANIAGUA
	VERSION: 0001
	FECHA: 03 jun 2019
	
	PAGINA DE :DESCRIPCION
-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="description" content="Ofical website to learn english">
    <meta name="keywords" content="pratice, test, learn, english">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="author" content="Juan C. Paniagua R.">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="shortcut icon" href="../src/en4es68.png" type="image/x-icon">
    <link rel="apple-touch-icon" href="../src/en4es68.png" type="image/x-icon">
    <title>FAQ</title>
    <link rel="stylesheet" href="../src/icons/styles.css">
    <!--    <link rel="stylesheet" href="../css/styles.css">-->
    <link rel="stylesheet" href="../css/policy.css">
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/script.js"></script>

</head>

<body>
    <!--  DIV BOTONES PRINCIPALES-->
    <div class="divbtn">
        <button class="btn icon-home" onclick="location.href='main.php';"></button>
        <button class="btn icon-share" onclick="window.location.href='../admin/logout.php'"></button>

    </div>

    <div class="body">
        <h1>Helps & FAQs</h1>

        <ol> <b>Contenido:</b>
            <li><a href="#crear">Crear una cuenta.</a> </li>
            <li><a href="#acceder">¿Cómo acceder?</a> </li>
            <li><a href="#perfil">Info sobre el perfil</a> </li>
            <li><a href="#main">Info sobre la ventana main</a> </li>
            <li><a href="#colores">Colores</a> </li>
            <li><a href="#simbolos">Otros símbolos</a> </li>

        </ol>

        <h2>¿CÓMO CREAR UNA CUENTA?</h2>
        <div id="crear">
            <p> Para crear una cuenta en Account Manager es super rápido y sencillo: solo tienes que ir a la <a href="../index.php"> página de inicio</a> y dar clic en el siguiente botón [ <span class="icon-user-plus"> </span> ], rellena el formulario con los datos que se te piden, tomando en cuenta que no puedes olvidar el usuario y la contraseña que ingresaste (ya que con dicho datos es que iniciaras sesión nuevamente) y da clic en registrar. </p>

            <h2 id="acceder">¿CÓMO ACCEDER?</h2>
            <p>
                Para iniciar sesión con una cuenta en Account Manager es super rápido y sencillo: solo tientes que ir a la <a href="../index.php"> página de inicio</a> y dar clic en el siguiente botón [ <span class="icon-login"> </span> ], rellena el formulario con el usuario y la contraseña que ingresaste cuando creaste la cuenta y da clic en entrar.</p>
            <p>Si deseas mantener tu sesión de usuario abierta, simplemente presiona el botón <b>recuérdame</b> antes de iniciar sesión.
            </p>

            <p> Puedes usar el email, número de teléfono o nombre de usuario en el campo <b>usuario</b> de forma predeterminada y la contraseña que ingresasre al crear la cuenta.</p>
            <p>Asegúrate de usar una contraseña segura y que puedas recordar fácilmente, si llegas a olvidarla o por alguna razón no puedes acceder a tu cuenta, puedes dar clic en <b>olvide contraseña</b> y sigue las instrucciones. </p>

            <h2>PERFIL</h2>
            <p id="perfil">Una vez iniciada la sesión, podrás editar tu cuenta al dar clic en tu <b>nombre de usuario con el siguiente icono</b> [ <span class="icon-confi"> </span> ]. Si llegas a olvidar tu contraseña o por alguna razón no puedes acceder a tu cuenta, por favor, no dudes en contactarnos para ayudarte a recuperarla o simplemente rellena el siguiente <a href="company.php#contacto">formulario. </a></p>
        </div>
        <hr>
        <p>Al dar clic en el logo IDCSchool [ <img src="../src/logoIcon.ico" alt="logo" height="30px"> ], se abrirá la página acerca de quienes somos.</p>
        <p>Al dar clic en este símbolo [ <span class="icon-logout"> </span> ], se cierra la sesión iniciada y se eliminaran las cookies creadas.</p>
        <p>Al dar clic en este símbolo [ <span class="icon-confi"> </span> ], muestra el perfil del usuario activo.</p>
        <h2>VENTANA MAIN</h2>
        <p id="main">En la ventana <a href="main.php">principal (main)</a>, los iconos nos proporcionan información acerca de las posibles acciones a ejecutar o del contenido mostrado en la misma, las principales son las siguientes:</p>

        <ul>
            <b>Significado de los símbolos:</b>

            <li class="icon-load"> Refrescar sitio</li>
            <li class="icon-calendar-plus-o"> Hacer una cita</li>
            <li class="icon-calendar-check-o"> Ver citas en ajenda</li>
            <ul>
                <li class="icon-bell2">No puedes enviar notificationes</li>
                <li class="icon-phone">Enlace a llamadas</li>
                <li class="icon-mail">Enlace a mensajes SMS</li>
                <li class="icon-whatsapp">Enlace a mensajes por whatsapp</li>
                <li class="icon-calendar-times-o">Eliminar cita</li>
                <li class="icon-calendar-o">Sin citas o en espera de la cita</li>
                <li class="icon-calendar-minus-o">Citas expiradas - Historial de citas</li>
                <li class="icon-plus">Ver info sobre la cita</li>
                <li class="icon-smiley-frown">Califica el cliente como malo</li>
                <li class="icon-smiley-meh">Elimina la calificaion del cliente</li>
                <li class="icon-smile">Califica el cliente como bueno</li>
                <li class="icon-care">Indicador de citas repetidas o con choques de horas</li>
                <li class="icon-check">Selecionar citas</li>
            </ul>
            <li class="icon-save"> Guardar totales por servicios</li>
            <li class="icon-calculator"> Ver cuadres por fecha</li>
            <ul>
                <li class="icon-print">Imprimir reporte</li>
                <li class="icon-jump-down">Ir abajo</li>
                <li class="icon-jump-up">Ir arriba</li>
                <li class="icon-move-down">Mostrar totales por día </li>
                <li class="icon-move-up">Mostrar totales por fechas</li>
                <li class="icon-trash">Eliminar registro</li>
            </ul>
        </ul>

        <p id="colores" class="title">Acerca de los colores:</p>
        <p>El color naranja [ <span style="background:darkorange" class="color"></span> ] indica que la cita aun está en espera del tiempo establecido.</p>
        <p>El color verde [ <span style="background:darkgreen" class="color"></span> ] indica que la cita está en el tiempo establecido. </p>
        <p>El color rojo [ <span style="background:red" class="color"></span> ] indica que la cita ha pasado del tiempo establecido.</p>
        <br>


        <p id="simbolos" class="title"> Otros símbolos:</p>
        <p>Este símbolo [ <span class="icon-hide"></span> ] significa que el usuario está inactivo.</p>
        <p>Este símbolo [ <span class="icon-views"></span> ] significa que el usuario está activo.</p>
        <p>Este símbolo [ <span class="icon-user-times"></span> ] elimina definitivamente un usuario.</p>


        <section>
            <style>
                form {
                    padding: 50px 0
                }

                form label,
                form a {
                    display: block
                }

                form button {
                    margin: 15px;
                    /*                padding: 5px*/
                }

            </style>
            <form action="">
                <label for="">¿Te fue de ayuda éste artículo?</label>
                <input type="hidden" name="idpost" value="">
                <button type="button" id="si" class="icon-like"> SI</button>
                <button type="button" id="no" class="icon-dislike"> NO</button>

                <label style="display:none" class="icon-smile"> Nos complace haberte ayudado.</label>
                <a style="display:none" href="company.php#contacto" class="icon-smiley-frown"> Completa el siguiente formulario y te contactaremos lo antes posible, Gracias por visitar nuestro sitio.</a>

            </form>
            <script>
                $('#si').click(function() {
                    $('.icon-smile').show();
                    $('form > a').hide();
                });
                $('#no').click(function() {
                    $('.icon-smile').hide();
                    $('form > a').show();
                });

            </script>
        </section>
    </div>
    <?php include("footer.php"); ?>

</body>

</html>
