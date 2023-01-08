<?php 

               if($fila_lock->id_user != '0'){
                   
                   if(isset($adm->id_plano)){
                       if($adm->id_plano != 7){
                           $copy = "\n\nwww.gestorlite.com";
                       }else{
                           $copy = "";
                       }
                   }else{
                       $copy = "";
                   }
                   
                    // Send Message
                    $device = trim($fila_lock->device_id);
                    $destination = $fila_lock->destino;
                    $message = $fila_lock->msg;
                    $api_url = "http://api-zapi.gestorlite.com:3000/send";
                    $api_url .= "?device=". urlencode ($device);
                    $api_url .= "&num=". urlencode ($destination);
                    $api_url .= "&msg=". urlencode ($message.$copy);
                  //  $my_result_object = json_decode(file_get_contents($api_url, false));
                    
                    
                    $ch=curl_init();
                    $timeout=1;
                    
                    curl_setopt($ch, CURLOPT_URL, $api_url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
                    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
                    
                    $result= curl_exec($ch);
                    curl_close($ch);

                    $whatsapi_class->insert_disparo($fila_lock->id_user,$destination,$message);
                           
                    
                    
                    
               
                }else{
                    
                    $device = trim($fila_lock->device_id);
                    $destination = $fila_lock->destino;
                    $message = $fila_lock->msg;
                    $api_url = "http://api-zapi.gestorlite.com:3000/send";
                    $api_url .= "?device=". urlencode ($device);
                    $api_url .= "&num=". urlencode ($destination);
                    $api_url .= "&msg=". urlencode ($message);
                    //$my_result_object = json_decode(file_get_contents($api_url, false));
                    
                    $ch=curl_init();
                    $timeout=1;
                    
                    curl_setopt($ch, CURLOPT_URL, $api_url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
                    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
                    
                    $result= curl_exec($ch);
                    curl_close($ch);
                    
                    $my_result_object = json_decode($result);
                    
                   
                }
            
          
                    

?>