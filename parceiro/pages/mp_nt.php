<?php 

    if(isset($_GET['code']) && isset($_GET['state'])){
        
        require_once '../class/Conn.class.php';
        require_once '../class/Afiliado.class.php';
        
        $afiliado    = new Afiliado();

        $code          = trim($_GET['code']);
        $redirect_uri  = trim("<?=SET_URL_PRODUCTION?>/parceiro/mp_nt");
        $access_token  = 'APP_USR-2155770650472302-042911-2d84894bde9536c7b7a446157173518e-247306013';
        
        
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.mercadopago.com/oauth/token?client_secret='.$access_token.'&code='.$code.'&redirect_uri='.$redirect_uri,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => 'client_secret='.$access_token.'&grant_type=authorization_code&code='.$code.'&redirect_uri='.$redirect_uri,
          CURLOPT_HTTPHEADER => array(
            'accept: application/json',
            'content-type: application/x-www-form-urlencoded'
          ),
        ));
        
        $response = curl_exec($curl);
        curl_close($curl);
        $obj = json_decode($response);
        
        if(isset($obj->access_token)){
            
            $access_token  = trim($obj->access_token);
            $expires_in    = trim($obj->expires_in);
            $user_id       = trim($obj->user_id);
            $refresh_token = trim($obj->refresh_token);
            $public_key    = trim($obj->public_key);
            
            $idAf = trim($_GET['state']);
            
            $getAf = $afiliado->getAfiliadoById($idAf);
            
            if($getAf){
                
                $dados = new stdClass();
                $dados->access_token= $access_token;
                $dados->expires_in= $expires_in;
                $dados->user_id= $user_id;
                $dados->refresh_token= $refresh_token;
                $dados->public_key= $public_key;
                $dados->id = $idAf;
                
                $save_dados = $afiliado->update_credenciais($dados);
                
                if(!$save_dados){
                    $msg = urlencode("Falha ao salvar dados API MERCADO PAGO do afiliado {$idAf}");
                    file_get_contents("http://api-zapi.gestorlite.com:3000/send?device=57a8cf2091b844079c50&num=554598339113&msg={$msg}");
                }
                
            }
            
            
        }
            
        
    }
    
    
    header('Location: <?=SET_URL_PRODUCTION?>/parceiro/mp_connect?successful');
    

?>