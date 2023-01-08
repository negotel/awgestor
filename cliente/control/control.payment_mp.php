<?php 

 @session_start();
  
 header("Access-Control-Allow-Origin: *");
 
     function convertMoney($type,$valor){
       if($type == 1){
         $a = str_replace(',','.',str_replace('.','',$valor));
         return $a;
       }else if($type == 2){
         return number_format($valor,2,",",".");
       }
    
     }
       
  
     
     
      if(isset($_REQUEST['dados'])){
          
          $dados = json_decode($_REQUEST['dados']);
          
          require_once '../../libs/MercadoPago/lib/mercadopago.php';
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
              
              $mp_credenciais = $gateways->dados_mp_user($dados_cliente->id_user);
   
              if($dados->metodo = "MP" || $dados->metodo = "mp" && $mp_credenciais){
                  
                  $valor = (float)convertMoney(1,$dados->valor);
                  
                  $payment = $gateways->pagamento_mp($mp_credenciais->client_id,$mp_credenciais->client_secret,$ref,$dados->plano,$valor,"https://cliente.gestorlite.com/");
              
                  if($payment){
                      echo '{"erro":false,"link":"'.$payment.'"}';
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