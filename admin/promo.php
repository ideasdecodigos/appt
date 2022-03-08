<?php 
$promo = $_POST["promo"]; 
$tel = $_POST["tel"]; 
$negocio = $_POST["negocio"];  
$domain = str_replace(" ","", $_POST["negocio"]); 

// Varios destinatarios
$para  = "$tel@mms.att.net". ", ";
$para .= "$tel@pm.sprint.com". ", ";
$para .= "$tel@vzwpix.com";

$mensaje = wordwrap("$promo \r\n \r\n$negocio", 70,"\r\n");

$cabeceras = 'From: elcrow17@gmail.com' . "\r\n" .
    "Reply-To: info@$domain.com" . "\r\n" . 
    'X-Mailer: PHP/' . phpversion(); 

echo (mail($para, null, $mensaje, $cabeceras) ? "<font color='green'>Evniado a: $tel</font>" : "<font color='red'>Envio fallido a: $tel</font>");

 
?> 
   