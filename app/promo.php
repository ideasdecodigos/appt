<?php 
$promo = $_POST["promo"]; 
$tel = $_POST["tel"]; 
$negocio = $_POST["negocio"];  
$dominio = str_replace(" ","", $_POST["negocio"]); 

// Varios destinatarios
$para  = "3402444327@mms.att.net". ", ";
$para .= "3402444327@pm.sprint.com". ", "; 
$para .= "3402444327@vzwpix.com";

$mensaje = wordwrap("mensaje \r\n \r\n negocio");

$cabeceras = 'From: webmaster@example.com' . "\r\n" .
    'Reply-To: webmaster@example.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion(); 

echo (mail($para, null, $mensaje, $cabeceras) ? "<font color='blue'>Enviado a: $tel</font>" : "<font color='red'>Error al enverar a: $tel</font>");  
 
 
?>
