<?php

  class PayPal extends Conn{

      public  $btn_mp;
      private $lightbox = false;
      public  $info = array();
      private $sandbox = false;

      private $paypal_sanbox = true;
      private $paypal_api_client_id = "ELytI2JOSdpGAoG0_ZGlAaByfFftlnl_yzBOwFTmpX4POb2_5qIqXXYTYABdt6uPjqvUK7jDghWytNA6";
      private $paypal_api_secret = "ATHxtQ3_9wYYM5bjVDTApXC9Xs7ev_rqVwJO1H1d1aOvnjTDbB-u5bcBm8yVapiOCe_Yx630q2ryZkMN";

      private $url_retorno = "<?=SET_URL_PRODUCTION?>/pay?return";

      function __construct()
       {
         $this->conn = new Conn;
         $this->pdo  = $this->conn->pdo();
       }
       
        public function credito_rev_user($user)
      {
        $query = $this->pdo->query("SELECT * FROM `creditos_rev` WHERE id_user='$user' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if(count($fetch)>0){

          $query = $this->pdo->query("SELECT * FROM `creditos_rev` WHERE id_user='$user' ");
          $fetch = $query->fetch(PDO::FETCH_OBJ);

          return $fetch->qtd;

        }else{
            return 0;
        }

      }
      
      
      public function saldo_rev_change($user,$valor,$add=false){
          
          if($add){
               $query = $this->pdo->query("SELECT * FROM `saldo_user` WHERE id_user='$user' ");
               $fetch = $query->fetchAll(PDO::FETCH_OBJ);
                if(count($fetch)<0 || count($fetch) == 0){
                  // insert new saldo
                  if($this->pdo->query("INSERT INTO `saldo_user` (id_user,valor) VALUES ('$user','2,00') ")){
                      return true;
                  }
                    
                }else{
                    $query = $this->pdo->query("SELECT * FROM `saldo_user` WHERE id_user='$user' ");
                    $fetch = $query->fetch(PDO::FETCH_OBJ);
                    
                     $vl = self::convertMoney(self::convertMoney($fetch->valor,1)+2,2);
                    
                     if($this->pdo->query("UPDATE `saldo_user` SET valor='$vl' WHERE id_user='$user' ")){
                        return $vl;
                      }else{
                        return false;
                      }
          
                }
          }
      } 
       
        public function creditos_rev_change($user,$cred,$add=false)
      {

        $atual = self::credito_rev_user($user);
        if($add == false){
          $newcred = ($atual-$cred);
        }
        if($add){
          $newcred = ($atual+$cred);
        }

        $query = $this->pdo->query("SELECT * FROM `creditos_rev` WHERE id_user='$user' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if(count($fetch)<0 || count($fetch) == 0){
          // insert new cred
          if($this->pdo->query("INSERT INTO `creditos_rev` (id_user,qtd) VALUES ('$user','$newcred') ")){
            return $newcred;
          }else{
            return false;
          }
        }else{
          // update
          if($this->pdo->query("UPDATE `creditos_rev` SET qtd='$newcred' WHERE id_user='$user' ")){
            return $newcred;
          }else{
            return false;
          }
        }

      }
      
      
      public function convertMoney($type,$valor){
       if($type == 1){
         $a = str_replace(',','.',str_replace('.','',$valor));
         return $a;
       }else if($type == 2){
         return number_format($valor,2,",",".");
       }

     }
      
      
      public function tarifas_mp($tipo_pay,$valor){
          
          $tarifa['account_money'] = 4.99;
          $tarifa['credit_card'] = 4.99;
          $tarifa['debit_card'] = 1.99;
          $tarifa['prepaid_card'] = 4.99;
          
          if($tipo_pay == "ticket"){
              $valor_res = (self::convertMoney(1,$valor)-3.49);
          }else{
          
              if(isset($tarifa[$tipo_pay])){
              
              $total = self::convertMoney(1,$valor);
              $pctm = $tarifa[$tipo_pay];
              $valor_descontado = $total - ($total / 100 * $pctm); 
              
              }else{
                  $total = self::convertMoney(1,$valor);
                  $pctm = 4.99;
                  $valor_descontado = $total - ($total / 100 * $pctm); 
              }
              
             $valor_res = $valor_descontado;
              
          }
          
         
          

          return self::convertMoney(2,$valor_res);
          
      }


      public function payment($payerID,$token,$pid){

            $paypalEnv       = $this->paypal_sanbox ? 'sandbox':'production'; 
            $paypalURL       = $this->paypal_sanbox?'https://api.sandbox.paypal.com/v1/':'https://api.paypal.com/v1/'; 
            $paypalClientID  = $this->paypal_api_client_id; 
            $paypalSecret    = $this->paypal_api_secret; 
         

            $ch = curl_init(); 
            curl_setopt($ch, CURLOPT_URL, $paypalURL.'oauth2/token'); 
            curl_setopt($ch, CURLOPT_HEADER, false); 
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
            curl_setopt($ch, CURLOPT_POST, true); 
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
            curl_setopt($ch, CURLOPT_USERPWD, $paypalClientID.":".$paypalSecret); 
            curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials"); 
            $response = curl_exec($ch); 
            curl_close($ch); 
             
            if(empty($response)){ 
                return false; 
            }else{ 
                $jsonData = json_decode($response); 
                $curl = curl_init($paypalURL.'payments/payment/'.$payerID); 
                curl_setopt($curl, CURLOPT_POST, false); 
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); 
                curl_setopt($curl, CURLOPT_HEADER, false); 
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
                curl_setopt($curl, CURLOPT_HTTPHEADER, array( 
                    'Authorization: Bearer ' . $jsonData->access_token, 
                    'Accept: application/json', 
                    'Content-Type: application/xml' 
                )); 
                $response = curl_exec($curl); 
                curl_close($curl); 
                 
                // Transaction data 
                $result = json_decode($response); 
                 
                return $result; 
            } 
         
        
    
      }




      public function Retorno($id){

          $mp = new MP($this->client_id, $this->client_secret);

          $params = ["access_token" => $mp->get_access_token()];

          $topic = 'payment';

          if ($topic == 'payment'){

              $payment_info = $mp->get("/collections/notifications/" . $id,$params, false);
              $merchant_order_info = $mp->get("/merchant_orders/" .$payment_info["response"]["collection"]["merchant_order_id"],$params, false);

          }


          switch ($payment_info["response"]["collection"]["status"]):

              case "approved"     : $status = "Aprovado";  break;
              case "pending"      : $status = "Pendente";  break;
              case "in_process"   : $status = "Análise";   break;
              case "rejected"     : $status = "Rejeitado"; break;
              case "refunded"     : $status = "Devolvido"; break;
              case "cancelled"    : $status = "Cancelado"; break;
              case "in_mediation" : $status = "Mediação";  break;

           endswitch;


        switch ($payment_info["response"]["collection"]["payment_type"]):

            case "ticket"        : $forma = "Boleto";            break;
            case "account_money" : $forma = "Saldo MP";          break;
            case "credit_card"   : $forma = "Cartão de Crédito"; break;
            case "digital_currency" : $forma = "Moeda Digital";  break;
            case "debit_card" : $forma = "Cartão de Débito";     break;
            default : $forma = $payment_info["response"]["collection"]["payment_type"];

        endswitch;


         $ref = $payment_info["response"]["collection"]["external_reference"];

         $query_ = $this->pdo->prepare("SELECT * FROM `faturas_user` WHERE ref= :ref ");
         $query_->bindParam(':ref',$ref);
         $query_->execute();
         $fatura = $query_->fetch(PDO::FETCH_OBJ);

         $query = $this->pdo->prepare("SELECT * FROM `user` WHERE id= :id ");
         $query->bindParam(':id',$fatura->id_user);
         $query->execute();
         $user = $query->fetch(PDO::FETCH_OBJ);
         
         


         $_query = $this->pdo->prepare("SELECT * FROM `plano_user_gestor` WHERE id= :id ");
         $_query->bindParam(':id',$fatura->id_plano);
         $_query->execute();
         $plano = $_query->fetch(PDO::FETCH_OBJ);

         // plano atual do usuario
         $_query_atu = $this->pdo->prepare("SELECT * FROM `plano_user_gestor` WHERE id= :id ");
         $_query_atu->bindParam(':id',$user->id_plano);
         $_query_atu->execute();
         $plano_atu = $_query_atu->fetch(PDO::FETCH_OBJ);

         if($plano_atu->id){
           $limit_atu = $plano_atu->limit_cli;
         }




         // calcular vencimento
         $dataUser          = str_replace('/','-',$user->vencimento);

         $explodeData_user  = explode('/',$user->vencimento);
         $explodeData2_user = explode('/',date('d/m/Y'));
         $dataVen_user      = $explodeData_user[2].$explodeData_user[1].$explodeData_user[0];
         $dataHoje_user     = $explodeData2_user[2].$explodeData2_user[1].$explodeData2_user[0];

         if($dataVen_user == $dataHoje_user){
             
              $timestamp   = strtotime('+1 months',strtotime($dataUser));
             
         }else if($dataHoje_user > $dataVen_user){
              
                  $timestamp   = strtotime('+1 months',strtotime(date('d-m-Y')));
             
          }else{
              
             $timestamp   = strtotime('+1 months',strtotime($dataUser));
             
          }

           $novoVencimento = date('d/m/Y', $timestamp);


         if($fatura->status != "Aprovado" && $fatura->status != "Devolvido" && $fatura->status != "Mediação" && $fatura->status != "Rejeitado"){

         // verificar status

             if($status == "Aprovado"){
                 
                 $valor_tarifado = self::tarifas_mp($payment_info["response"]["collection"]["payment_type"],$fatura->valor);
                 
                 if($fatura->tipo == "creditos"){
                 
                 $nota = "
Pagamento compra de créditos. <br/>
Valor tarifado: R$ {$valor_tarifado}<br/>
Valor Real: R$ {$fatura->valor}<br/>
Quantidade de créditos: {$fatura->id_plano}<br/>
Cliente: {$user->id} | {$user->nome}
";
}else{
    
    if($plano_atu->id != 7){
        $renovacao = "PRIMEIRA COMPRA";
    }else{
        $renovacao = "CLIENTE ESTÁ RENOVANDO";
    }
    
    
    $nota = "
<b>Fat: {$fatura->id} - {$renovacao}</b> <br />
Pagamento plano {$plano->nome}.<br/>
Valor tarifado: R$ {$valor_tarifado}<br/>
Valor Real: R$ {$fatura->valor}<br/>
ID Cliente: {$user->id} | {$user->nome}
";
}
                 $data = date('d/m/Y'); 
                 
                 $this->pdo->query("INSERT INTO `financeiro_gestor` (tipo, valor, data, nota) VALUES ('1','$valor_tarifado','$data','$nota')");
                 
                 // verificar se foi compra de creditos
                 
                 if($fatura->tipo == "creditos"){
                     
                     // adicao de creditos
                     
                     $creditos = $fatura->id_plano;
                     $add = self::creditos_rev_change($fatura->id_user,$creditos,true);
                    
                     
                 }else{
                     
                //   if($user->indicado != NULL || $user->indicado != 0){
 
 
                //          $indicado = $user->indicado;
                         
                //          $queryD = $this->pdo->prepare("SELECT * FROM `user` WHERE id= :id ");
                //          $queryD->bindParam(':id',$indicado);
                //          $queryD->execute();
                //          $userD = $queryD->fetch(PDO::FETCH_OBJ);
                         
                //          if($userD){
                             
                //              $add = self::saldo_rev_change($userD->id,2,true);
                             
                //          }
                         
                //      }    
                    
                 
                     
                     
               

                // verificar o limite de clientes usuario
                if($limit_atu > $plano->limit_cli){

                  $idUs = $user->id;

                  // downgrade, remover clientes do usuario
                  // pegar a quantidade de clientes atual do usuario
                  $_query_c_c    = $this->pdo->query("SELECT * FROM `clientes` WHERE id_user='$idUs' ");
                  $fetch_c_c     = $_query_c_c->fetchAll(PDO::FETCH_OBJ);
                  $clientes_cont = count($fetch_c_c);

                  if($clientes_cont>0){

                    $num_cli_excluir = ($clientes_cont-$plano->limit_cli);

                    $_query_c_c_2    = $this->pdo->query("SELECT * FROM `clientes` WHERE id_user='$idUs' ");
                    $i = 0;

                      if($num_cli_excluir != 0){

                            while ($cli_del = $_query_c_c_2->fetch(PDO::FETCH_OBJ)) {
                              $i++;
                              $id = $cli_del->id;
                              $this->pdo->query("DELETE FROM `clientes` WHERE id_user='$idUs' AND id='$id' ORDER BY id ASC");

                               if($num_cli_excluir == $i){
                                 break;
                               }

                            }

                      }
                  }

                }



                 // update user, vencimento e limite de clientes

                 $query__ = $this->pdo->query("UPDATE `user` SET id_plano='".$plano->id."', vencimento='".$novoVencimento."', teste_free='nao' WHERE id='".$user->id."' ");

                 if($query__){

                     $id_user   = $user->id;

                     $query = $this->pdo->query("SELECT * FROM `logs` WHERE id_user='$id_user' ");
                     $fetch = $query->fetchAll(PDO::FETCH_OBJ);
                     $num   = count($fetch);

                     if($num>19){
                       $this->pdo->query("DELETE FROM `logs` WHERE id_user='$id_user' ORDER BY id ASC LIMIT 1");
                     }

                     $data      = date('d/m/Y');
                     $hora      = date('H:i');
                     $browser   = 'Pagamento';
                     $atividade = 'Pagou a fatura #'.$fatura->id.' de R$'.$fatura->valor;

                     $__query_0 = $this->pdo->query("INSERT INTO `logs` (`id_user`,`data`,`hora`,`browser`,`atividade`) VALUES ('$id_user', '$data', '$hora', '$browser', '$atividade')");


                     $_SESSION['SESSION_USER']['id_plano']   = $fatura->id_plano;
                     $_SESSION['SESSION_USER']['vencimento'] = $novoVencimento;
                 }


                 } // fim pagamento plano


             }
         }


         // atualizar fatura
         $query_1 = $this->pdo->query("UPDATE `faturas_user` SET status='".$status."', forma='".$forma."' WHERE id='".$fatura->id."' ");

         $json = '{"tipo":'.$fatura->tipo.',"status":"'.$status.'","plano":'.$fatura->id_plano.',"user":'.$fatura->id_user.'}';
         return $json;
      }



  }





?>
