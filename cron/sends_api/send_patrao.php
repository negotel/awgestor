<?php 

               if($fila_lock->id_user != '0'){
                   
                 
                     $device = $fila_lock->device_id;
                     $num = $fila_lock->destino;
                     $msg = urlencode($fila_lock->msg);
                    
                     $url = $device."/send?num={$num}&msg={$msg}";
                    
                    
                	$ch = curl_init($url);
                
                	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,10);
                	curl_setopt($ch, CURLOPT_HEADER, false);
                	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                	
                	$response = curl_exec($ch);
                	curl_close($ch);
                                       
                    $my_result_object = json_decode($response);
                    
                    if( $my_result_object->erro == false ){
                           if($fila_lock->id_user != '0'){
                             $whatsapi_class->insert_disparo($fila_lock->id_user,$num,$fila_lock->msg);
                           }
                    }
                    
                    
               
                }else{
                    
                    $my_apikey = $fila_lock->device_id;
                    $destination = $fila_lock->destino;
                    $message = $fila_lock->msg;
                    $api_url = $my_apikey;
                    $api_url .= "&num=". urlencode ($destination);
                    $api_url .= "&msg=". urlencode ($message);
                    $my_result_object = json_decode(file_get_contents($api_url, false));
                   
                }
            
          
                    

?>