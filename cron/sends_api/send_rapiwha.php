<?php 

               if($fila_lock->id_user != '0'){
                   
                    // Send Message
                    $my_apikey = $fila_lock->device_id;
                    $destination = $fila_lock->destino;
                    $message = $fila_lock->msg;
                    $api_url = "http://panel.rapiwha.com/send_message.php";
                    $api_url .= "?apikey=". urlencode ($my_apikey);
                    $api_url .= "&number=". urlencode ($destination);
                    $api_url .= "&text=". urlencode ($message);
                    $my_result_object = json_decode(file_get_contents($api_url, false));
                    
                    if( $my_result_object->success ){
                           if($fila_lock->id_user != '0'){
                             $whatsapi_class->insert_disparo($fila_lock->id_user,$destination,$fila_lock->msg);
                           }
                    }
                    
                    
               
                }else{
                    
                    $my_apikey = $fila_lock->device_id;
                    $destination = $fila_lock->destino;
                    $message = $fila_lock->msg;
                    $api_url = "http://panel.rapiwha.com/send_message.php";
                    $api_url .= "?apikey=". urlencode ($my_apikey);
                    $api_url .= "&number=". urlencode ($destination);
                    $api_url .= "&text=". urlencode ($message);
                    $my_result_object = json_decode(file_get_contents($api_url, false));
                   
                }
            
          
                    

?>