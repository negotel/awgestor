<?php 


  
    $message = $fila_lock->msg;
    $token = $fila_lock->device_id;
    $recipient = $fila_lock->destino;
	$url = 'https://'.$fila_lock->codigo.'/api/v1/send_message';


	$params = array ('menssage'=> $message , 'number'=> $recipient);
	
	
 /*
	$data_string = json_encode($params);                                                                                   
																														 
	$ch = curl_init($url);                                                                      
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); 
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
		'Content-Type: application/json',                                                                                
		'Authorization: ' . $token
		)                                                                       
	);                                                                                                                   
																														 
	$result = curl_exec($ch);
	
	$my_result_object = json_decode($result); */
	
	$my_result_object = true;
	
	if($my_result_object){

           if($fila_lock->id_user != '0'){
             $i->Whatsapi->insert_disparo($fila_lock->id_user,$recipient,$fila_lock->msg);
           }
       
	}




?>