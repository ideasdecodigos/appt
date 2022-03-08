


<?php 

$message= isset($_GET['message']) ? $_GET['message'] : null ;
$phone= isset($_GET['phone']) ? $_GET['phone'] : null ;

if($message != null && $phone != null){
 $url = "http://192.168.1.101:8090/SendSMS?username=sadiq&password=1234&phone=".$phone."&message=".urldecode($message);   
    $curl= curl_init($url);
    curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
    $curl_response= curl_exec($curl);
    
    if($curl_response === false){
     $info=curl_getinfo($curl);
        curl_close($curl);
        die("Error ocurrido".var_export($info));
    }
            
            curl_close($curl);
            
            $response= json_decode($curl_response);
            if($response ->status == 200){
                echo "Message Enviado correctamente";
            }
            
}
            
            

?>