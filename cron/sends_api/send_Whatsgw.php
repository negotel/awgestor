<?php 

               $apikey = "";

               if($fila_lock->id_user != '0'){
     
                   
                    $device = trim($fila_lock->device_id);
                    $destination = $fila_lock->destino;
                    $message = $fila_lock->msg;

                    $data = array(
                        "apikey" => $apikey,
                        "phone_number" => $v_device->phone,
                        "contact_phone_number"=> $destination,
                        "message_type" => "text",
                        "message_body" => $message,
                        "check_status" => 0,
                        "message_custom_id" => uniqid()
                        );

                    $postdata = http_build_query($data);
                    $curl = curl_init();
                    
                    curl_setopt_array($curl, array(
                      CURLOPT_URL => 'https://app.whatsgw.com.br/api/WhatsGw/Send',
                      CURLOPT_RETURNTRANSFER => true,
                      CURLOPT_ENCODING => '',
                      CURLOPT_MAXREDIRS => 10,
                      CURLOPT_TIMEOUT => 0,
                      CURLOPT_FOLLOWLOCATION => true,
                      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                      CURLOPT_CUSTOMREQUEST => 'POST',
                      CURLOPT_POSTFIELDS => $postdata,
                      CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/x-www-form-urlencoded'
                      ),
                    ));
                    
                    $response = curl_exec($curl);
                    
                    curl_close($curl);

                    $whatsapi_class->insert_disparo($fila_lock->id_user,$destination,$message);
                           
               
                }
            
          
                    

?>