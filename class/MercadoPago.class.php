<?php

  class MercadoPago extends Conn{

      public  $btn_mp;
      private $lightbox = false;
      public  $info = array();
      private $sandbox = false;

      private $client_id     = "";
      private $client_secret = "";
      private $acces_token   = "";

      private $url_retorno = SET_URL_PRODUCTION."/pay?return";

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
                  if($this->pdo->query("INSERT INTO `saldo_user` (id_user,valor) VALUES ('$user','3,00') ")){
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
          $tarifa['bank_transfer'] = 1;
          
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


       public function paymentAf($afiliado,$fatura,$ref,$plano,$access_tokenMP){
          
         $valor_af = false;
           
         // get value AfProd   
         $query = $this->pdo->prepare("SELECT * FROM `rateio_afiliado` WHERE plano= :plano  AND afiliado= :afiliado");
         $query->bindValue(':plano', $plano->id);
         $query->bindValue(':afiliado', $afiliado->id);
         $query->execute();
         $retorno = $query->fetchAll();
         if(count($retorno) > 0){
    
           $query = $this->pdo->query("SELECT * FROM `rateio_afiliado` WHERE plano= '$plano->id'  AND afiliado= '$afiliado->id'");
           $fetch = $query->fetch(PDO::FETCH_OBJ);
           
           $valor_af = self::convertMoney(1,$fetch->valor);
    
         }else{
           return 'not_af';
         }
           
        if($valor_af){
            
                $valor_loja = (self::convertMoney(1,$fatura->valor)-$valor_af);
            
                MercadoPago\SDK::setAccessToken($access_tokenMP->acess_token_mp);
                
                $preference = new MercadoPago\Preference();
                
                $item = new MercadoPago\Item();
                $item->id = $fatura->id;
                $item->title = 'Plano '.$plano->nome;
                $item->picture_url = SET_URL_PRODUCTION.'/img/logo.png';
                $item->quantity = 1;
                $item->description = 'Plano '.$plano->nome;
                $item->unit_price = (double)self::convertMoney(1,$fatura->valor);
                
                $preference->items = array($item);
            
                $preference->back_urls = array(
                   "success" => SET_URL_PRODUCTION.'/painel/pagamentos',
                   "failure" => SET_URL_PRODUCTION.'/painel/pagamentos',
                   "pending" => SET_URL_PRODUCTION.'/painel/pagamentos'
                );
            
            
                $preference->notification_url   = $this->url_retorno."&af=".$afiliado->id;
                $preference->external_reference = $ref;
                $preference->marketplace_fee    = (double)$valor_loja;
                
                $preference->save();
            
               if($preference){
                   return $preference->init_point;
               }else{
                   return false;
               }
    
          }else{
              return 'not_af';
          }
    
      }

      public function payment($ref, $nome , $valor){

          $mp = new MP($this->client_id, $this->client_secret);


          $items = array(
              array(
                "id" => 0001,
                "title" => $nome,
                "currency_id" => "BRL",
                "picture_url" => SET_URL_PRODUCTION."/img/logo.png",
                "description" => $nome.' - Gestor Lite',
                "quantity" => 1,
                "unit_price" => $valor
              )
          );

          $back_urls = array(
              "success" => $this->url_retorno,
              "failure" => $this->url_retorno,
              "pending" => $this->url_retorno
             );


          $preference_data = array(
              "items" => $items,
              "back_urls" => $back_urls,
              "notification_url" => $this->url_retorno,
              "external_reference" => $ref,
              );

          $preference = $mp->create_preference($preference_data);

          if($this->sandbox):
                $mp->sandbox_mode(TRUE);
                $link = $preference["response"]["sandbox_init_point"];
            else:
                $mp->sandbox_mode(FALSE);
                $link = $preference["response"]["init_point"];
            endif;

            $this->btn_mp = $link;

            return $this->btn_mp;
      }


     public function RetornoAf($afiliado,$id,$access_mp){

        $curl = curl_init();
        
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.mercadopago.com/v1/payments/'.$id,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$access_mp->acess_token_mp
          ),
        ));
        
         $payment_info = json_decode(curl_exec($curl), true);
         curl_close($curl);

          switch ($payment_info["status"]):

              case "approved"     : $status = "Aprovado";  break;
              case "pending"      : $status = "Pendente";  break;
              case "in_process"   : $status = "Análise";   break;
              case "rejected"     : $status = "Rejeitado"; break;
              case "refunded"     : $status = "Devolvido"; break;
              case "cancelled"    : $status = "Cancelado"; break;
              case "in_mediation" : $status = "Mediação";  break;

           endswitch;


        switch ($payment_info["payment_type_id"]):

            case "ticket"        : $forma = "Boleto";            break;
            case "account_money" : $forma = "Saldo MP";          break;
            case "credit_card"   : $forma = "Cartão de Crédito"; break;
            case "digital_currency" : $forma = "Moeda Digital";  break;
            case "debit_card" : $forma = "Cartão de Débito";     break;
            case "bank_transfer" : $forma = "PIX";               break;
            default : $forma = $payment_info["payment_type_id"];

        endswitch;


         $ref = $payment_info["external_reference"];

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
                 
         /*REAJUSTE DE VALORES*/
         
           $valor_adm = self::convertMoney(1,$fatura->valor);
           $data = date('d/m/Y');
           
          if($user->af != 0 && $user->af  != NULL){
              
            // get comissao
            $query = $this->pdo->query("SELECT * FROM `rateio_afiliado` WHERE afiliado='$afiliado->id' AND plano='$plano->id' ");
            $fetch = $query->fetchAll(PDO::FETCH_OBJ);
            
            if(count($fetch)>0){
                $query = $this->pdo->query("SELECT * FROM `rateio_afiliado` WHERE afiliado='$afiliado->id' AND plano='$plano->id' ");
                $fetch = $query->fetch(PDO::FETCH_OBJ);
                $comissao_af = self::convertMoney(1,$fetch->valor);
            
            }else{
                $comissao_af = false;
            }
            
            if($comissao_af){
                
                $valor_add = self::convertMoney(2,$comissao_af);
                
                $this->pdo->query("INSERT INTO `vendas_parceiro` (`user_id`, `parceiro`, `valor`, `plano`, `data`) VALUES ('$user->id','$afiliado->id','$valor_add','$plano->id','$data')");
                $valor_adm = ($valor_adm-$comissao_af);
                
                
                $textoN = "Você vendeu {$plano->nome}. Ganhou uma comissão de R$ {$valor_add}";
                $this->pdo->query("INSERT INTO `notification_af` (`texto`, `af`) VALUES ('$textoN','$afiliado->id')");
    
                
            }
    
          }
          
          $valor_adm = self::convertMoney(2,$valor_adm);
          
          /* -------------------- REAJUSTE DE VALORES*/
          
          
                 
        $valor_tarifado = $valor_adm;
                 
    $nota = "
<b>Parceiro ".explode(' ',$afiliado->nome)[0]." vendeu!</b> <br />
Fat: {$fatura->id} <br />
Pagamento plano {$plano->nome}.<br/>
Valor MarketPlace: R$ {$valor_adm}<br/>
Valor Real: R$ {$fatura->valor}<br/>
ID Cliente: {$user->id} | {$user->nome}<br />
ID PARCEIRO: {$afiliado->id} | {$afiliado->nome} <br />
Comissão: R$ {$valor_add}
";

                 $data = date('d/m/Y'); 
                 
                 $this->pdo->query("INSERT INTO `financeiro_gestor` (tipo, valor, data, nota) VALUES ('1','$valor_tarifado','$data','$nota')");


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


                // fim pagamento plano


             }
         }


         // atualizar fatura
         $query_1 = $this->pdo->query("UPDATE `faturas_user` SET status='".$status."', forma='".$forma."' WHERE id='".$fatura->id."' ");

         $json = '{"tipo":'.$fatura->tipo.',"status":"'.$status.'","plano":'.$fatura->id_plano.',"user":'.$fatura->id_user.'}';
         return $json;
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
            case "bank_transfer" : $forma = "PIX";               break;
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
                 
                file_get_contents("http://xdroid.net/api/message?k=k-1e7e607d2708&t=".urlencode('Um nova venda - Gestor Lite')."&c=".urlencode('Venda de R$ '.$fatura->valor.', para o plano: '.$plano->nome)."&u=".SET_URL_PRODUCTION);
                file_get_contents("http://xdroid.net/api/message?k=k-01ad8c7dae47&t=".urlencode('Um nova venda - Gestor Lite')."&c=".urlencode('Venda de R$ '.$fatura->valor.', para o plano: '.$plano->nome)."&u=".SET_URL_PRODUCTION);

                 
                 $this->pdo->query("INSERT INTO `financeiro_gestor` (tipo, valor, data, nota) VALUES ('1','$valor_tarifado','$data','$nota')");
                 
                 // verificar se foi compra de creditos
                 
                 if($fatura->tipo == "creditos"){
                     
                     // adicao de creditos
                     
                     $creditos = $fatura->id_plano;
                     $add = self::creditos_rev_change($fatura->id_user,$creditos,true);
                    
                     
                 }else{
                     
                  if($user->indicado != NULL || $user->indicado != 0){
 
 
                         $indicado = $user->indicado;
                         
                         $queryD = $this->pdo->prepare("SELECT * FROM `user` WHERE id= :id ");
                         $queryD->bindParam(':id',$indicado);
                         $queryD->execute();
                         $userD = $queryD->fetch(PDO::FETCH_OBJ);
                         
                         if($userD){
                             
                             $vlr = 3;
                             
                             if($plano->id == 7){
                                 $vlr = 5;
                             }
                             
                             $add = self::saldo_rev_change($userD->id,$vlr,true);
                             
                         }
                         
                     }    
                    
                 
                     
                     
                 // pagamento por plano
                 
                //  if($plano->id == 7){
                     
                //      if($plano_atu->id != 7){
                     
                //          $img = SET_URL_PRODUCTION."/template_mail/template_1/img/heart.png";
                //          $titulo = explode(' ',$user->nome)[0]." Você virou patrão  !!! ";
                //          $email = $user->email;
                //          $nome  = explode(' ',$user->nome)[0];
                                
                //          $html  = file_get_contents("../template_mail/template_1/index.html");
                //          $texto = "Olá {$nome}. \n\nYESS ! Você agora é patrão pow ! \n\nE isso te da direito a um chabot do whastapp.\n\nEntão a gente vai configurar ele pra ti, okay ?\n\nO prazo para ficar top seu bot é de 24hr, beleza ?\n\nMas ja pode ir me mandando mensagens por este whatsapp aqui: http://wa.me/553196352452 ! \n\nAssim que seu Bot ficar pronto eu dou um grito hahaha!";               
                //          $body = str_replace('{cancel_insc}','',str_replace(date('d/m/Y'),"Hoje",str_replace("{imagem}",$img,str_replace("{titulo}","",str_replace("{texto}",$texto,$html)))));
                        
                //          $obj = new stdClass();
                //          $obj->nome = $titulo;
                //          $obj->corpo = $body;
                        
                //          $to = $email;
                //          $subject = $titulo;
                //          $from = 'contact@gestorlite.com';
                         
                //          $headers  = 'MIME-Version: 1.0' . "\r\n";
                //          $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                         
                //          $headers .= "From: Gestor Lite <{$from}> \r\n".
                //             'Reply-To: '.$from."\r\n" .
                //             'X-Mailer: PHP/' . phpversion();
                           
                //          mail($to, $subject, $obj->corpo, $headers);  
                           
                //          $ar1   = array('+',')','(',' ','-');
                //          $ar2   = array('','','','','');
                //          $phone = $user->ddi.str_replace($ar1,$ar2,$user->telefone);
                         
                     
                //          $init = file_get_contents('http://api-zapi.gestorlite.com:3000/send?device=cb0e11a07208f0067a37019750&number='.$phone.'&text='.urlencode($texto));
                //      }
                     
                //      //sleep(2);
                //      //sleep(2);

                     
                     
                //  }
                 
                 

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
