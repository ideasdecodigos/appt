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
    if(isset($_GET['iduser'])){ 
        $iduser=$_GET['iduser'];
        $percent=$_GET['percent'];
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
    <script src="../js/script.js"></script>
</head>

<body>
    <!--  LINK A EDITAR USUARIOS -->
    <div class="menu">
        <font color="white"><img src="../src/imgclear.png"><a href="company.php">IDCSchool</a></font>
        <span class="icon-usersecret" onclick=""> <?php echo $_GET['name']; ?></span> |
        <button onclick="window.location.href='../admin/logout.php'" class="icon-logout"></button>
    </div>
    <!--  DIV BOTONES PRINCIPALES-->
    <div class="divbtn">
        <button class="btn icon-home" onclick="location.href='main.php';"></button>
        <button class="btn icon-calendar-check-o" id="default" onclick="openwindows(this, '#divReservations');"></button>
        <button class="btn icon-calculator" onclick="openwindows(this, '#divHistory');"></button>
    </div>

    <!--    DIV VER RESERBACIONES-->
    <div class="divtab" id="divReservations">
       <input type="hidden" value="<?php echo $iduser; ?>" id="iduser">
        <div id="divcitas">
            <center><img src='../src/calendar.gif' alt='loading' width="100%"></center>
                
            <script>
                function chat(iduser) {
                    $.ajax({
                        type: 'POST',
                        url: '../admin/functions.php',
                        data: {
                            root: iduser
                        },
                        success: function(data) {
                            $("#divcitas").html(data);
                        }
                    });
                    return false;
                }
                setInterval(function() {
                    chat($('#iduser').val())
                }, 1000);

            </script>
        </div>
        <br><br><br>
    </div>

 
    <!--   DIV HISTORY-->
    <div id="divHistory" class="divtab">
        <form id="formhistory">
           <fieldset>
               <legend>Desde [<button class="icon-print" onclick="imprSelecion('divInforme');" style="width:50px"></button>] Hasta</legend>
          
                <input type="date" name="dateOne" onchange="$('#formhistory').submit();" value="<?php if(date("d")<=15){echo date("Y-m-01");}else{echo date("Y-m-16");}?>">
                <input type="date" name="dateTwo" onchange="$('#formhistory').submit();" value="<?php echo date("Y-m-d"); ?>">
            </fieldset>
            <input type="hidden" name="root" value="<?php echo $iduser; ?>">
            <input type="hidden" name="percent" value="<?php echo $percent; ?>">
        </form>

        <div id="showHistory"> </div> 
        <script>
            $(function() {
                $('#formhistory').submit();
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
</body>

</html>
<?php }else{  header("location: ../index.php");   } ?>
