<?php 

  @session_start();

  require_once '../class/Conn.class.php';
  require_once '../class/Afiliado.class.php';

  $class_af = new Afiliado();

  
  // get af by id
  $afiliado = $class_af->getAfiliadoById($_SESSION['AFILIADO']['id']);
  
  if(!$afiliado){
      echo '<script>location.href="sair";</script>';
  }
  
   $credenciais = $class_af->getAccesMP($_SESSION['AFILIADO']['id']);


    $curl = curl_init();
    
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.mercadopago.com/oauth/token',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => 'client_secret='.$credenciais->acess_token_mp.'&grant_type=refresh_token&refresh_token='.$credenciais->refresh_acess_token_mp,
      CURLOPT_HTTPHEADER => array(
        'accept: application/json',
        'content-type: application/x-www-form-urlencoded'
      ),
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
    
    if(json_decode($response)){
        
        $obj = json_decode($response);
        
        $access_token  = trim($obj->access_token);
        $expires_in    = trim($obj->expires_in);
        $user_id       = trim($obj->user_id);
        $refresh_token = trim($obj->refresh_token);
        $public_key    = trim($obj->public_key);

        
        $dados = new stdClass();
        $dados->access_token= $access_token;
        $dados->expires_in= $expires_in;
        $dados->user_id= $user_id;
        $dados->refresh_token= $refresh_token;
        $dados->public_key= $public_key;
        $dados->id = $afiliado->id;
                    
        $update = $class_af->update_credenciais($dados);
        
    
        if($update){
           echo '<script>location.href="mp_connect?successful";</script>';
        }else{
            echo '<script>location.href="mp_connect?error";</script>';
        }
        
        
    }
    
 
    
?>