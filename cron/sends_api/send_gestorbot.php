<?php 

               if($fila_lock->id_user != '0'){
                   
                 
                    $device = $fila_lock->device_id;
                    $num = $fila_lock->destino;
                    $msg = urlencode($fila_lock->msg);
                    
                    $url = "http://api-zapi.gestorlite.com:3000/send?device=2f8cbc1b5b92ce32b422&num={$num}&msg={$msg}";

                    $ch=curl_init();
                    $timeout=1;
                    
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
                    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
                    
                   $result= curl_exec($ch);
                    curl_close($ch);
                    
                    $my_result_object = json_decode($result);
                    
                    if($my_result_object){
                           if($fila_lock->id_user != '0'){
                             $whatsapi_class->insert_disparo($fila_lock->id_user,$num,$fila_lock->msg);
                           }
                    }
                    
                    
               
                }else{
                    
                    $my_apikey = $fila_lock->device_id;
                    $destination = $fila_lock->destino;
                    $message = $fila_lock->msg;
                    
                    $url = "http://api-zapi.gestorlite.com:3000/send?device=2f8cbc1b5b92ce32b422&num={$num}&msg={$msg}";

                	$ch=curl_init();
                    $timeout=1;
                    
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
                    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
                    
                    $result= curl_exec($ch);
                    curl_close($ch);
                    
                    $my_result_object = json_decode($result);
                    
                                       
                    if( $my_result_object->error == false ){
                           if($fila_lock->id_user != '0'){
                             $whatsapi_class->insert_disparo($fila_lock->id_user,$num,$fila_lock->msg);
                           }
                    }
                   
                }
            
          
                    

?>