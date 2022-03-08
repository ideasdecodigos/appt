<?php 
   //    CONECTA CON LA BASE DE DATOS
    $con = mysqli_connect('sql102.byethost.com','b33_24890511','4544642','b33_24890511_app') or die("Error de Conexion!".mysqli_error());
    mysqli_query($con,"SET NAMES 'utf8'"); //Para que se inserten las tildes correctamente
 