<?php

  set_time_limit(3000);


 if(isset($_REQUEST['chave'])){
     
     
     $chave = trim($_REQUEST['chave']);
     
     require_once 'autoload.php';
     include_once '../libs/phpmailer/PHPMailerAutoload.php';
     
     
     $user_class = new User();
     $gestor_class = new Gestor();
     $whatsapi_class = new Whatsapi();
     
     $api_painel_class = new ApiPainel();
     
       function get_client_ip() {
                
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
    
    $ip = get_client_ip();
                
     
     $api_painel_info = $api_painel_class->verific_chave($chave);
     
     if($api_painel_info){
         
         $api_name = $api_painel_info->api;
         
         switch ($api_name) {
            case 'xtream-ui': $name_class_api = "Xtream"; break;
            case 'kofficeV2': $name_class_api = "KOfficeV2"; break;
            case 'kofficeV4': $name_class_api = "KOfficeV4"; break;
            case 'kofficev4_12': $name_class_api = "KOfficeV4_12"; break;
        }
        
         $apiAuth = new $name_class_api();
         
         $dados_user = $user_class->dados($api_painel_info->id_user);
         $plano_user = $gestor_class->plano($dados_user->id_plano);
         $vencimento = $user_class->vencimento($dados_user->vencimento);
         
         
         if($dados_user == false){
             echo json_encode(["erro" => true, "msg" => "Usuário proveniente desta chave não existe mais"]);
             die;
         }
         

         
             $gerados = $api_painel_class->cont_teste_mes($dados_user->id);
             if($gerados >= $plano_user->limit_teste){
                 echo json_encode(["erro" => true, "msg" => "Limite de testes atingido"]);
                 die;
             }
             
         
         
         if($plano_user->limit_teste > 0){
             if($vencimento == "vencido"){
                 echo json_encode(["erro" => true, "msg" => "Painel Gestor Lite vencido"]);
                 die;
             }
         }else{
             echo json_encode(["erro" => true, "msg" => "Plano usado não permite teste"]);
             die;
         }
     }else{
         echo json_encode(["erro" => true, "msg" => "Chave incorreta"]);
         die;
     }
     
     
     if(isset($_REQUEST['gerateste'])){
         
         if($api_painel_info->situ_teste == 0){
             echo json_encode(["erro" => true, "msg" => "Testes desativados"]);
             die;
         }
         
         
         if(isset($_REQUEST['bot'])){
             $_REQUEST['email'] = $_REQUEST['whatsapp'].'@c.us';
         }
         
        //  if(!isset($_REQUEST['bot'])){
        //      if($api_painel_class->verific_ip($ip,$api_painel_info->id_user)){
        //          echo json_encode(["erro" => true, "msg" => "Você ja gerou um teste."]);
        //          die;
        //      }
        //  }
         
         if($api_painel_class->verific_mail($_REQUEST['email'],$api_painel_info->id_user,$_REQUEST['whatsapp'])){

             $package    = $_REQUEST['package'];
             
             $teste = $apiAuth->gerateste($api_painel_info->cms,$api_painel_info->username,$api_painel_info->password,$package);
             
          //   echo $teste;die;
             
  
             $json = json_decode($teste);
             
             if($json->erro == false){
                 
                 if($name_class_api == "KOfficeV2"){
                     $outer_json = json_decode($teste,true);
                     $line = (object)$outer_json[0];
                 }else if($name_class_api == "KOfficeV4"){
                     $line = $json->line[0];
                 }else if($name_class_api == "KOfficeV4_12"){
                     $line = $json->line[0];
                 }else{
                     $line = $json->line;
                 }
                 
                 
                
                 
                 $insert_historic = new stdClass();
                 $insert_historic->id_user = $api_painel_info->id_user;
                 $insert_historic->nome = $_REQUEST['nome'];
                 $insert_historic->email = $_REQUEST['email'];
                 $insert_historic->whatsapp = $_REQUEST['whatsapp'];
                 $insert_historic->data = date('d/m/Y');
                 $insert_historic->hora = date('H:i');
                 $insert_historic->nota = 'Teste Gerado com Gestor Lite';
                 $insert_historic->username = $line->username;
                 $insert_historic->password = $line->password;
                 $insert_historic->ip = $ip;
                 $insert_historic->api_name = $api_painel_info->nome;
                 
                 $api_painel_class->insert_historic_teste($insert_historic);
                 
                  
                 
                 
                 /*Send mail and whatsapp*/
                 
                 
                 if($api_painel_info->template_zap == ""){
                     $template_zap = file_get_contents('<?=SET_URL_PRODUCTION?>/painel/preview/modelo-teste-whatsapp.txt');
                 }else{
                     $template_zap = $api_painel_info->template_zap;
                 }
                 
                 if(isset($_REQUEST['bot'])){
                      
                     
                      $returnBot = new stdClass();
                      $returnBot->erro = false;
                      $returnBot->tema = str_replace('{nome}',$_REQUEST['whatsapp'],str_replace('{password}',$line->password,str_replace('{username}',$line->username,$template_zap)));
                      
                      echo json_encode($returnBot);
                      
                      die;
    
                     }else{
                        echo json_encode(["erro" => false, "msg" => "Teste gerado com sucesso! Enviado para seu email."]);
                     }
                 
                  if($api_painel_info->template_mail == ""){
                      $template_mail = file_get_contents('<?=SET_URL_PRODUCTION?>/painel/preview/modelo-teste-mail.txt');
                  }else{
                      $template_mail = $api_painel_info->template_mail;
                  }
                 
                 
                 
                 
                 $text_whats = str_replace('{nome}',$_REQUEST['nome'],str_replace('{password}',$line->password,str_replace('{username}',$line->username,$template_zap))); 
                 $text_mail  = str_replace('{nome}',$_REQUEST['nome'],str_replace('{password}',$line->password,str_replace('{username}',$line->username,$template_mail))).'<br /><br />  Não responder está mensagem'; 

                
                $to = $_REQUEST['email'];
                $subject = 'Seu teste '.$_REQUEST['nome'].' 💜  !!!';
                $from = 'contact@gestorlite.com';
                 
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                 
                $headers .= "From: Gestor Lite <{$from}> \r\n".
                    'Reply-To: '.$from."\r\n" .
                    'X-Mailer: PHP/' . phpversion();
                mail($to, $subject, $text_mail, $headers);
                
                
                
                // send zap
                $device = $whatsapi_class->verific_device_situ($api_painel_info->id_user);
                
                $fila_lock = new stdClass();
                
                if($device == false){
                    $fila_lock->api = 'gestorbot';
                    $fila_lock->device_id = 'null';
                
                }else{
                    $fila_lock->device_id = $device->device_id;
                    $fila_lock->api = $device->api;
                    
                }
                
                $fila_lock->msg = $text_whats;
                $fila_lock->id_user = $api_painel_info->id_user;
                $fila_lock->destino = $_REQUEST['whatsapp'];
                
                if(is_file('../cron/sends_api/send_'.$fila_lock->api.'.php')){  
                    
                   require_once '../cron/sends_api/send_'.$fila_lock->api.'.php';
                   
                   if($api_painel_info->receber_aviso == 1){
        
                       $msg2 = "Olá ".explode(' ',$dados_user->nome)[0].". Tudo em cima ? \n\n Um usuário gerou um teste! Segue os dados abaixo: \n\n *Nome*: ".$_REQUEST['nome']."\n *Email*: ".$_REQUEST['email']."\n *Whatsapp*: wa.me/".$_REQUEST['whatsapp']."\n\n Sucesso 💜";               
                       $msg_send = urlencode($msg2);
                       
                       $ar1   = array('+',')','(',' ','-');
                       $ar2   = array('','','','','');
                       $phone_send = $dados_user->ddi.str_replace($ar1,$ar2,$dados_user->telefone);
                                   
                      
                       $url = "http://api-zapi.gestorlite.com:3000/send?device=c7208f0067a370197508&num={$phone_send}&msg={$msg_send}";

                        
                    	$ch = curl_init($url);
                    	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,10);
                    	curl_setopt($ch, CURLOPT_HEADER, false);
                    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_exec($ch);
                    	curl_close($ch);
                   }
                   
                   
                }
                 
                 
                 
                 
             }
             
         }else{
             echo json_encode(["erro" => true, "msg" => "Você já gerou um teste."]);
             die;
         }
         
     }
     
     
     
     if(isset($_REQUEST['getPackages'])){
         
         if(isset($_REQUEST['trial'])){
         
              $packages = $apiAuth->getAllPackegs($api_painel_info->cms,$api_painel_info->username,$api_painel_info->password,1);
              
         }else{
             
             $packages = $apiAuth->getAllPackegs($api_painel_info->cms,$api_painel_info->username,$api_painel_info->password,0);
             
         }
         
     
 
         $res = json_decode($packages);
         
         if($res->erro == false){
             echo json_encode($res->packages);
             die;
         }else{
             echo json_encode(["erro" => true, "msg" => "Erro ao buscar pacotes"]);
             die;
         }
         
         
     }
     
     
     
     
 }















?>