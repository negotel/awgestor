<?php


 /**
  *
  */
 class Gateways extends Conn
 {


      function __construct()
      {
        $this->conn = new Conn;
        $this->pdo  = $this->conn->pdo();
      }



    public function dados_mp_user($user){

      $query = $this->pdo->query("SELECT * FROM `dados_mp_user` WHERE id_user='$user'");
      $fetch = $query->fetchAll(PDO::FETCH_OBJ);
      if(count($fetch)>0){

        $query = $this->pdo->query("SELECT * FROM `dados_mp_user` WHERE id_user='$user'");
        $fetch = $query->fetch(PDO::FETCH_OBJ);
        return $fetch;

      }else{
        return false;
      }

    }
    
    
    public function dados_ph_user($user,$apikey=false){

     if($apikey == false){

      $query = $this->pdo->query("SELECT * FROM `dados_paghiper` WHERE id_user='$user'");
      $fetch = $query->fetchAll(PDO::FETCH_OBJ);
      if(count($fetch)>0){

        $query = $this->pdo->query("SELECT * FROM `dados_paghiper` WHERE id_user='$user'");
        $fetch = $query->fetch(PDO::FETCH_OBJ);
        return $fetch;

      }else{
        return false;
      }
      
     }else{
              $query = $this->pdo->query("SELECT * FROM `dados_paghiper` WHERE apikey='$apikey'");
              $fetch = $query->fetchAll(PDO::FETCH_OBJ);
              if(count($fetch)>0){
        
                $query = $this->pdo->query("SELECT * FROM `dados_paghiper` WHERE apikey='$apikey'");
                $fetch = $query->fetch(PDO::FETCH_OBJ);
                return $fetch;
        
              }else{
                return false;
              }
         }

    }
    
    public function dados_picpay_user($user){

      $query = $this->pdo->query("SELECT * FROM `dados_picpay_user` WHERE id_user='$user'");
      $fetch = $query->fetchAll(PDO::FETCH_OBJ);
      if(count($fetch)>0){

        $query = $this->pdo->query("SELECT * FROM `dados_picpay_user` WHERE id_user='$user'");
        $fetch = $query->fetch(PDO::FETCH_OBJ);
        return $fetch;

      }else{
        return false;
      }

    }
    
    public function dados_bank_user($user){

      $query = $this->pdo->query("SELECT * FROM `dados_bank_user` WHERE id_user='$user'");
      $fetch = $query->fetchAll(PDO::FETCH_OBJ);
      if(count($fetch)>0){

        $query = $this->pdo->query("SELECT * FROM `dados_bank_user` WHERE id_user='$user'");
        $fetch = $query->fetch(PDO::FETCH_OBJ);
        return $fetch;

      }else{
        return false;
      }

    }
    
    public function delete_dados_mp($user){
         $query = $this->pdo->prepare("DELETE FROM `dados_mp_user` WHERE id_user= :id_user");
         $query->bindValue(':id_user',$user);
          
          if($query->execute()){
              return true;
          }else{
              return false;
          }
    }
    
    public function update_dados_mp($user,$client_id,$client_secret){

      $query = $this->pdo->prepare("UPDATE `dados_mp_user` SET client_id= :client_id, client_secret= :client_secret WHERE id_user= :id_user");
      $query->bindValue(':client_id',$client_id);
      $query->bindValue(':client_secret',$client_secret);
      $query->bindValue(':id_user',$user);
      
      if($query->execute()){
          return true;
      }else{
          return false;
      }
   
    }
    
     public function delete_dados_ph($user){
         $query = $this->pdo->prepare("DELETE FROM `dados_paghiper` WHERE id_user= :id_user");
         $query->bindValue(':id_user',$user);
          
          if($query->execute()){
              return true;
          }else{
              return false;
          }
    }
    
    public function update_dados_ph($user,$apikey,$token,$situ){

      $query = $this->pdo->prepare("UPDATE `dados_paghiper` SET apikey= :apikey, token= :token, situ= :situ WHERE id_user= :id_user");
      $query->bindValue(':apikey',$apikey);
      $query->bindValue(':token',$token);
      $query->bindValue(':situ',$situ);
      $query->bindValue(':id_user',$user);
      
      if($query->execute()){
          return true;
      }else{
          return false;
      }
   
    }
    
    
    public function insert_dados_mp($user,$client_id,$client_secret){
      $query = $this->pdo->prepare("INSERT INTO `dados_mp_user` (id_user, client_id, client_secret) VALUES (:id_user,:client_id,:client_secret) ");
      $query->bindValue(':id_user',$user);
      $query->bindValue(':client_id',$client_id);
      $query->bindValue(':client_secret',$client_secret);
      
      
      if($query->execute()){
          return true;
      }else{
          return false;
      }
   
    }


   public function insert_dados_ph($user,$apikey,$token,$situ){
      $query = $this->pdo->prepare("INSERT INTO `dados_paghiper` (id_user,apikey,token,situ) VALUES (:id_user,:apikey,:token,:situ) ");
      $query->bindValue(':id_user',$user);
      $query->bindValue(':apikey',$apikey);
      $query->bindValue(':token',$token);
      $query->bindValue(':situ',$situ);
      
      if($query->execute()){
          return true;
      }else{
          return false;
      }
   
    }
    
    public function pagamento_ph($token,$apikey,$ref,$nome,$valor,$url,$cliente,$cpf='00000000000'){
        

            $data = array(
              'apiKey' => $apikey,
              'order_id' => $ref, // código interno do lojista para identificar a transacao.
              'payer_email' => $cliente->email,
              'payer_name' => $cliente->nome, // nome completo ou razao social
              'payer_cpf_cnpj' => $cpf, // cpf ou cnpj
              'payer_phone' => $cliente->telefone, // fixou ou móvel
              'notification_url' => $url,
              'type_bank_slip' => 'boletoA4', // formato do boleto
              'days_due_date' => '5', // dias para vencimento do boleto
              'late_payment_fine' => '2',// Percentual de multa após vencimento.
              'per_day_interest' => true, // Juros após vencimento.
              'items' => array(
                      array ('description' => $nome,
                             'quantity' => '1',
                             'item_id' => '1',
                              'price_cents' => $valor
                         )
                )
            );
            $data_post = json_encode( $data );
            $url = "https://api.paghiper.com/transaction/create/";
            $mediaType = "application/json"; // formato da requisição
            $charSet = "UTF-8";
            $headers = array();
            $headers[] = "Accept: ".$mediaType;
            $headers[] = "Accept-Charset: ".$charSet;
            $headers[] = "Accept-Encoding: ".$mediaType;
            $headers[] = "Content-Type: ".$mediaType.";charset=".$charSet;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_post);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $result = curl_exec($ch);
            $json = json_decode($result, true);
            // captura o http code
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if($httpCode == 201):

            // CÓDIGO 201 SIGNIFICA QUE O BOLETO FOI GERADO COM SUCESSO
            // Exemplo de como capturar a resposta json
            $transaction_id = $json['create_request']['transaction_id'];
            $url_slip = $json['create_request']['bank_slip']['url_slip'];
            $digitable_line = $json['create_request']['bank_slip']['digitable_line'];
            
            return json_encode(['erro' => false, 'boleto' => $url_slip, 'numeroBoleto' => $digitable_line]);
            
            else:
              return json_encode(['erro' => true]);
            endif;
            

    
    }
    
    
    public function notification_hp($json){
        
        $data_post = $json;
        $url = "https://api.paghiper.com/transaction/notification/ ";
        $mediaType = "application/json"; // formato da requisição
        $charSet = "UTF-8";
        $headers = array();
        $headers[] = "Accept: ".$mediaType;
        $headers[] = "Accept-Charset: ".$charSet;
        $headers[] = "Accept-Encoding: ".$mediaType;
        $headers[] = "Content-Type: ".$mediaType.";charset=".$charSet;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_post);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        $json = json_decode($result, true);
        // captura o http code
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if($httpCode == 201):
       
        switch ($json['status_request']['status']):
                case "paid"         : $status = "Pago";        break;
                case "pending"      : $status = "Pendente";    break;
                case "reserved"     : $status = "Pendente";    break;
                case "canceled"     : $status = "Cancelado";   break;
                case "completed"    : $status = "Pago";        break;
                case "processing"   : $status = "Pendente";    break;
                case "refunded"     : $status = "Devolvido";   break;
            endswitch;
            
            $return['status']      = $status;

            $json = json_encode($return);
            return $json;

       
        else:
          return json_encode(['erro' => true]);
         endif;
    }
    
    
    
    public function pagamento_mp($client_id,$client_secret,$ref,$nome,$valor,$url){
        
        $mp     = new MP($client_id, $client_secret);
        $refUrl = base64_encode($ref);
        
        $preference_data = array(
            "items" => array(
                array(
                    "id" => $ref,
                    "title" => $nome,
                    "currency_id" => "BRL",
                    "picture_url" => "https://www.mercadopago.com/org-img/MP3/home/logomp3.gif",
                    "description" => $nome,
                    "quantity" => 1,
                    "unit_price" => $valor
                )
            ),


            "back_urls" => array(
                "success" => '<?=SET_URL_PRODUCTION?>/painel/payment_notification/'.$refUrl.'/mercadopago',
                "failure" => '<?=SET_URL_PRODUCTION?>/painel/payment_notification/'.$refUrl.'/mercadopago',
                "pending" => '<?=SET_URL_PRODUCTION?>/painel/payment_notification/'.$refUrl.'/mercadopago'

            ),
            "notification_url" => '<?=SET_URL_PRODUCTION?>/painel/payment_notification/'.$refUrl.'/mercadopago',
            "external_reference" => $ref,
        );
        
        $preference = $mp->create_preference($preference_data);
        $mp->sandbox_mode(FALSE);
        $link = $preference["response"]["init_point"];
        
        return $link;
        
    }


    public function notification_mp($credenciais,$cod){
        
        $mp = new MP($credenciais->client_id,$credenciais->client_secret);
        
        $token_access = ["access_token" => $mp->get_access_token()];
        
        $payment_info = $mp->get("/collections/notifications/" . $cod , $token_access, false);
        
        if($payment_info){
            
            $status     = $payment_info["response"]["collection"]["status"];
            $reference  = $payment_info["response"]["collection"]["external_reference"];
            
            switch ($payment_info["response"]["collection"]["payment_type"]):

                case "ticket"        : $forma = "Boleto";            break;
                case "account_money" : $forma = "Saldo MP";          break;
                case "credit_card"   : $forma = "Cartão de Crédito"; break;
                default : $forma = $payment_info["response"]["collection"]["payment_type"];
    
            endswitch;
            
            switch ($payment_info["response"]["collection"]["status"]):
                case "approved"    : $stat = "Pago";        break;
                case "pending"     : $stat = "Pendente";    break;
                case "in_process"  : $stat = "Pendente";    break;
                case "rejected"    : $stat = "Rejeitado";   break;
                case "refunded"    : $stat = "Devolvido";   break;
                case "cancelled"   : $stat = "Rejeitado";   break;
                case "in_mediation": $stat = "Rejeitado";   break;
            endswitch;
            
            $return['ref']         = $reference;
            $return['status']      = $status;
            $return['forma']       = $forma;
            $return['nome_status'] = $stat;
        
            $json = json_encode($return);
            return $json;
            
        }else{
            return false;
        }
        
    }
    
    
    public function picpay_dados_user($content,$situ,$user){
        
        $dados_picpay = self::dados_picpay_user($user);
        
        if($dados_picpay){
            // update
            
            if($this->pdo->query("UPDATE `dados_picpay_user` SET situ='$situ', content='$content' WHERE id_user='$user' ")){
                return true;
            }else{
                return false;
            }
            
        }else{
            // insert
            
            $query = $this->pdo->query("INSERT INTO `dados_picpay_user` (id_user,situ,content) VALUES ('$user','$situ','$content')");
            
            if($query){
                return true;
            }else{
                return false;
            }
        }
        
        
    }
    
    
    public function bank_dados_user($content,$situ,$user){
        
        $dados_picpay = self::dados_bank_user($user);
        
        if($dados_picpay){
            // update
            
            if($this->pdo->query("UPDATE `dados_bank_user` SET situ='$situ', content='$content' WHERE id_user='$user' ")){
                return true;
            }else{
                return false;
            }
            
        }else{
            // insert
            
            $query = $this->pdo->query("INSERT INTO `dados_bank_user` (id_user,situ,content) VALUES ('$user','$situ','$content')");
            
            if($query){
                return true;
            }else{
                return false;
            }
        }
        
        
    }
    
    

 }





?>
