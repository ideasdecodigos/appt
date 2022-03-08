
<?php 
   //    CONECTA CON LA BASE DE DATOS
    $con = mysqli_connect('localhost','u795806260_spa','Juan4544642','u795806260_spa') or die("Error de Conexion!".mysqli_error());
    mysqli_query($con,"SET NAMES 'utf8mb4'"); //Para que se inserten las tildes correctamente
  