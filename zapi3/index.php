<?php 

    $url_api = "http://localhost:5000";


	$obj = json_decode(file_get_contents('php://input'), true);


    if(isset($obj['msg'])){
        
        
        
        $message = $obj['msg']['_data']['body'];
        $number  = explode("@",$obj['msg']['_data']['from'])[0];
        
        
        if( !file_exists("sessions/{$number}.json") ){
            
   
            $message_reply  = "Oi sou um bot, vamos começar?"; 
            $message_reply2 = "Digite Com apenas números. \n\n *Quantos novos casos de COVID?*"; 
            
            
            $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL => $url_api.'/chat/sendmessage/554598339113',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_POSTFIELDS => 'message='.$message_reply,
              CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded',
                'Accept: application/json'
              ),
            ));
            
            $response = curl_exec($curl);
            curl_close($curl);
            
            sleep(2);
            
            $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL => $url_api.'/chat/sendmessage/554598339113',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_POSTFIELDS => 'message='.$message_reply2,
              CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded',
                'Accept: application/json'
              ),
            ));
            
            $response = curl_exec($curl);
            curl_close($curl);

            //  $fp = fopen("sessions/{$number}.json","wb");
            // fwrite($fp,"{}");
            // fclose($fp);
            
            
        }else{
            
        }
        
        
        
        
        
        
        
        
    }