<?php if(isset($_GET['business'])){ ?>
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
    <link rel="shortcut icon" href="../src/spalogo.jpg" type="image/x-icon">
    <link rel="apple-touch-icon" href="../src/spalogo.jpg" type="image/x-icon">
    <title> policy</title>
 
    <script src="../js/jquery-3.3.1.min.js"></script>
    <style>
        body {
            padding: 0 20px;
        }

    </style>
</head>

<body>
    <center class="divbtn">
        <fieldset>
            <legend> Selecione language </legend>
            <label for="enx">
                <input id="enx" type="radio" name="start" onclick="getPolicy($(this).val(),'<?php echo $_GET['business'] ?>');" value="en" checked> En</label>
            <label for="esx">
                <input id="esx" type="radio" name="start" onclick="getPolicy($(this).val(),'<?php echo $_GET['business'] ?>');" value="es"> Es</label>
            <label for="frx">
                <input id="frx" type="radio" name="start" onclick="getPolicy($(this).val(),'<?php echo $_GET['business'] ?>');" value="fr"> Fr</label>
        </fieldset>
    </center>
    <div id="sms"></div>
    <script>  
        $(function(){
            getPolicy('en', '<?php echo $_GET['business'] ?>');
        });
        function getPolicy(lang, id) {
            $.ajax({
                type: 'POST',
                url: '../admin/manage.php',
                data: {
                    idioma: lang,
                    business: id
                },
                success: function(data) {
                    $("#sms").html(data); //MUESTRA LA POLITICA EN EL IDOMA SELECIONADO
                    $("#sms").prepend("<h2>POLICY</h2>"); //MUESTRA LA POLITICA EN EL IDOMA SELECIONADO
                }
            });
            return false;
        }
    </script>
</body>
</html>
<?php }else{ ?>
   <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="description" content="Ofical website to learn english">
    <meta name="keywords" content="privacy, politicas">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="author" content="Juan C. Paniagua R.">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="shortcut icon" href="../src/imgclear.png" type="image/x-icon">
    <link rel="apple-touch-icon" href="../src/imgclear.png" type="image/x-icon">
    <title>privacy</title>
    <style> 
        h1,
        b {
            text-align: center;
            display: block;
                font-size: 1em;
        }

        p,
        h3,h2 {
            margin: 10px 5%;
        }

        i {
            margin: 10px 10%;
            display: block;
        }
        ul,ol{margin-left: 50px}

    </style>
</head>

<body>
    
   <h1> Appointment Policies</h1>
   
<p>Dear customer, if you have an appointment booked with us, you must arrive 5 minutes before the appointment time, because the nail technician cannot waste time waiting. The technician's time is valuable and it is invested in work. However, the system allows the nails tech to wait for you 10-minutes after the time established in the appointment, once that time has passed, the client loses the reservation and with the right to claim and must postpone or reserve again.</p>

<p>If you have an appointment booked with us and for some reason you cannot be on time, please contact us and let us know to assign the space to another client. If you make it a habit to be absent or late for appointments, we may not receive future reservations from you.</p>

<p>If you arrive on time for your appointment and the technician you booked is working with another person, you can choose to arrange with another available technician or you will have to wait until he can attend you. This happens frequently, since the magnitude or quantity of services is ignored when setting an appointment.</p>

<p>If you arrive at the time established in your appointment, you have the right to claim the service for that day, if it is within the limits of the working hours and within the possibilities of the technician you reserved.</p>

<p>Note: as you already know, when you book, you do not leave any amount in the fund or charge any refund if you miss your appointment, therefore, we hope the most pleasant understanding on your part and that you understand why it is important for us that you are punctual with your appointments.</p>

<p>Note: Any technician who works with us and / or us, we reserve the right to deny our services to any client at a certain time.</p>


    <b>© 2018 LANGUAGE APPS LIMITED</b>
</body>
</html>
    
<?php } ?>