<?php

  @session_start();

  include_once '../config/settings.php';

  if(isset($_SESSION['SESSION_USER'])){


    if(isset($_POST['stage'])){

      $stage = $_POST['stage'];

      require_once '../class/Conn.class.php';
      require_once '../class/User.class.php';
      require_once '../class/Logs.class.php';
      require_once '../class/Gestor.class.php';
      require_once '../class/Financeiro.class.php';
      require_once '../class/Faturas.class.php';
      require_once '../libs/MercadoPago/lib/mercadopago.php';
      require_once '../class/MercadoPago.class.php';
      require_once '../class/PayPal.class.php';
      require_once '../class/Afiliado.class.php';
      

      $json       = new stdClass();
      $user_c     = new User();
      $user       = $user_c->dados($_SESSION['SESSION_USER']['id']);
      $logs       = new Logs();
      $gestor     = new Gestor();
      $financeiro = new Financeiro();
      $faturas    = new Faturas();
      $mp         = new MercadoPago();
      $paypal     = new PayPal();
      $afiliado   = new Afiliado();
      
      $moeda   = "BRL";
      $gateway = "mp";

      if($stage == '1'){
        // init payment

        $plano = $gestor->plano(trim($_POST['id']));

        if($plano){
            
          if(isset($_POST['gateway'])){
              $gateway = $_POST['gateway'];
          }  
            
            
          $moedaNew = $user_c->getmoeda($user->moeda);
        
          if($moedaNew){
               $moeda = $moedaNew->nome;
           }

          $ref = $faturas->create($plano,$user,$moeda);

          if($ref){
         
              $valor = (float)$financeiro->convertMoney(1,$plano->valor);

             //$init  = $mp->payment($ref,'Plano '.$plano->nome,$valor);
             $json->erro = false;
             $json->msg = "Faça o pagamento";
             echo json_encode($json);

          }else{
            $json->erro = true;
            $json->msg = "Erro inesperado, entre em contato com o suporte.";
            echo json_encode($json);
          }

        }else{

          $json->erro = true;
          $json->msg = "Plano indisponível";
          echo json_encode($json);

        }


      }

      if($stage == '2'){
        // recover payment

        $fat = $faturas->dados(trim($_POST['id']));

          if($fat){
              
            if($fat->tipo != "creditos"){

              $plano = $gestor->plano($fat->id_plano);
              if($plano == false){
                  $json->erro = true;
                  $json->msg = "Me parece que este plano não existe mais, entre em contato com o suporte.";
                  echo json_encode($json);
                  die;
              } 
            }

            

            $valor = (float)$financeiro->convertMoney(1,$fat->valor);
            
            if($fat->tipo == "creditos"){
              $name_init = "Créditos Revenda";
            }else{
              $name_init = 'Plano '.$plano->nome;
            }
            
            if($gateway == "mp"){
                
                
                  if($user->af == NULL || $user->af == 0 || $user->af == '0'){
                      // NAO AFILIADO
     
                     $init  = $mp->payment($fat->ref,$name_init,$valor);
                     $json->erro = false;
                     $json->msg = $init;
                     echo json_encode($json);
                 
                  }else{
                      // AFILIADO
                      
                      $af_dados = $afiliado->getAfiliadoById($user->af);
                      
                      if($af_dados){
                          
                           // get access token mp 
                            $access_tokenMP = $afiliado->getAccesMP($user->af);
                                  
                            if($access_tokenMP){
                                  
                                 // AFILIADO EXISTE
                                 require_once '../libs/MP2/vendor/autoload.php';
                                 $init  = $mp->paymentAf($af_dados,$fat,$fat->ref,$plano,$access_tokenMP);
                                 
                                 if($init == false || $init == "not_af"){
                                     
                                     // AFILIADO NAO EXISTE
                                    $init  = $mp->payment($fat->ref,$name_init,$valor);
                                    $json->erro = false;
                                    $json->msg = $init;
                                    echo json_encode($json);
                                 
                              }else{
                                  
                                    // LINK PAGAMENTO AFILIADO MERCADO PAGO
                                                         
                                     $json->erro = false;
                                     $json->msg = $init;
                                     echo json_encode($json);    
                              }
                              
                          }else{
                              
                               // não está com mp integrado
                                $init  = $mp->payment($fat->ref,$name_init,$valor);
                                $json->erro = false;
                                $json->msg = $init;
                                echo json_encode($json);
                                    
                          }

                         
                      }else{
                          
                         // AFILIADO NAO EXISTE
                         $init  = $mp->payment($ref,$name_init,$valor);
                         $json->erro = false;
                         $json->msg = $init;
                         echo json_encode($json);
                         
                         
                      }
                     
                      
                  }
                
            }


        }else{
          $json->erro = true;
          $json->msg = "Me parece que está fatura ja foi paga ou não existe mais.";
          echo json_encode($json);
        }


       }
       
    }
      
  }

?>
