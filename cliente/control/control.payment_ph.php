<?php 

 @session_start();
  
 header("Access-Control-Allow-Origin: *");
 
     function convertMoney($type,$valor){
       if($type == 1){
         $a = str_replace(',','.',str_replace('.','',$valor));
         return $a;
       }else if($type == 2){
         return number_format($valor,2,",",".");
       }else if($type == 3){
         return  str_replace('.','',str_replace(',','',$valor));
       }
    
     }
       
    
    function validaCPF($cpf) {
         
            // Extrai somente os números
            $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
             
            // Verifica se foi informado todos os digitos corretamente
            if (strlen($cpf) != 11) {
                return false;
            }
        
            // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
            if (preg_match('/(\d)\1{10}/', $cpf)) {
                return false;
            }
        
            // Faz o calculo para validar o CPF
            for ($t = 9; $t < 11; $t++) {
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf[$c] * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($cpf[$c] != $d) {
                    return false;
                }
            }
            return true;
        
        }
     
     
      if(isset($_REQUEST['dados'])){
          
          $dados = json_decode($_REQUEST['dados']);
          
          require_once '../../class/Conn.class.php';
          require_once '../../class/Clientes.class.php';
          require_once '../../class/User.class.php';
          require_once '../../class/Gateways.class.php';
          require_once '../../class/Gestor.class.php';
          
        
          $clientes  = new Clientes();
          $user_dono = new User();
          $gateways  = new Gateways();
          $gestor    = new Gestor();
     
          $dados_cliente = $clientes->dados($dados->id_cli);
          $dados_dono    = $user_dono->dados($dados_cliente->id_user);
          $planouser     = $gestor->plano($dados_dono->id_plano);
          $ref           = $dados->ref;
          
          if($planouser->gateways == 1){
              
              $ph_credenciais = $gateways->dados_ph_user($dados_cliente->id_user);
   
              if($dados->metodo = "PH" || $dados->metodo = "ph" && $ph_credenciais){
                  
                  $valor = convertMoney(3,$dados->valor);
                  $refUrl = base64_encode($ref);
                  
                  if(validaCPF($dados->cpf) == false){
                      echo '{"erro":true,"msg":"Coloque um CPF válido"}';
                      die;
                  }

                  $payment = $gateways->pagamento_ph($ph_credenciais->token,$ph_credenciais->apikey,$ref,$dados->plano,$valor,"<?=SET_URL_PRODUCTION?>/painel/payment_notification/'.$refUrl.'/paghiper",$dados_cliente,$dados->cpf);
              
                  if(json_decode($payment)){
                      
                      $res = json_decode($payment);
                      
                      if($res->erro){
                          echo '{"erro":true,"msg":"Entre em contato com o suporte"}';
                      }else{
                          echo '{"erro":false,"link":"'.$res->boleto.'","numeroBoleto":"'.$res->numeroBoleto.'"}';
                      }
                      
                  }else{
                      echo '{"erro":true,"msg":"Entre em contato com o suporte"}';
                  }
              }
              
          }else{
              echo "erro";
          }
     
     }else{
        echo "erro";
     }
 




?>