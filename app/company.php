<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="description" content="Pratice and learn english">
    <meta name="keywords" content="pratice, test, learn, english">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="author" content="Juan C. Paniagua R.">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta name="google" value="notranslate">
    <link rel="shortcut icon" href="../src/imgclear.png" type="image/x-icon">
    <link rel="apple-touch-icon" href="../src/imgclear.png" type="image/x-icon">
    <title> Company</title>
    <link rel="stylesheet" href="../src/icons/styles.css">
    <link rel="stylesheet" href="../css/policy.css">
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/script.js"></script>
</head>

<body> 

    

      <!--  DIV BOTONES PRINCIPALES-->
    <div class="divbtn">
        <button class="btn icon-home" onclick="location.href='main.php';"></button>
        <button class="btn icon-logout" onclick="window.location.href='../admin/logout.php'"></button>
       
    </div>
<div class="body">
   <center>
    
    <img src="../../config/schedule.png" height="100" alt="Logo">
    <h1>Appt. Manager. </h1>
    </center>
    <h2>¿Qué es  Appt. Manager?</h2>

    <p> Appt. Manager es un sitio que te provee una agenda de citas y te ayuda a mantener el control de los ingresos de un determinado servicio. </p>

    <h2>Fácil de usar y entender </h2>

    <p> Appt. Manager es un sitio pensado para tener control total de los ingresos de un determinado servicio, ya sea este formal o informal. Ideal para manicuristas y peluqueros. El sitio reune las mejores prácticas y medios tecnológicos en agendas de citas e ingresos de los servicios ofrecidos a cada cliente, así como, los ingresos en propinas de los mismos, de una manera eficaz y eficiente.  Appt. Manager se centra en la simplicidad, provee un uso sencillo y directo.  Appt. Manager muestra estadísticas simples de los totales desde día 1 al día 15 y del día 16 hasta fin de mes automáticamente. </p>

    <h2> Appt. Manager es gratis</h2>

    <p> Appt. Manager es, y siempre será, un recurso de uso personal completamente gratuito. A pesar de que nos esforzamos al máximo para mantener tu información segura y accesible en todo momento, no estamos interesados en los datos que almacenas en nuestra base de datos, y los mismos no son compartidos por nosotros con ninguna entidad</p>

    <h2>Puedes ayudar</h2>

    <p>Trabajamos arduamente para garantizar que  Appt. Manager siga siendo útil, seguro, actualizado e interesante. Si encuentras un error o un enlace roto, háganoslo saber a través del siguiente formulario. </p>

    <br><br>

    <h1 > Report a problem</h1>
    <div class="contactos">
        <!--   contiene los telefonos de contactos-->
        <div class="column">
            <h2 class="icon-phone">Phone:</h2>
            <p>Tell me, how may I help you?</p>
            <a href="tel:+3402444327>">+1 340 244 4327</a>
            <br><br>

            <h2 class="icon-arroba">Email:</h2>
            <p>For all types of questions, comments and concerns; please text me at: <a href="mailto:ideasdecodigos@gmail.com">ideasdecodigos@gmail.com</a> or complete the next form.
            </p>
        </div>

        <div class="column" >
            <form action="../admin/contacts.php" method="post" id="contacto">
                <input type="text" name="nombre" maxlength="100" required placeholder="Name" title="Enter name">
                <input type="email" name="correo" required maxlength="60" placeholder="Email" title="Enter email">
                <input type="tel" name="tel" maxlength="15" placeholder="Phone" title="Enter phone">
                <input type="text" name="asunto" maxlength="300" required placeholder="Subject" title="Enter subject">
                <textarea name="mensaje" required placeholder="Message" title="Enter massage" maxlength="5000"></textarea>
                <button type="submit">SEND</button>
            </form>
        </div>
    </div>
    <br>
    </div>
 <?php include("footer.php"); ?>

</body>

</html>
