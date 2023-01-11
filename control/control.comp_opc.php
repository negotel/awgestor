<?php
  @session_start();
require_once "../config/settings.php";
  $json = new stdClass();

   if(isset($_SESSION['SESSION_USER'])){

     if(isset($_POST)){
         
         if(!isset($_POST['idfat'])){
             echo json_encode(['erro' => true, 'msg' => 'not found fat']);
             die;
         }
         
         $reffat = $_POST['idfat'];
         
         require_once '../class/Conn.class.php';
         require_once '../class/Clientes.class.php';
         require_once '../class/Logs.class.php';
         require_once '../class/User.class.php';
         require_once '../class/Planos.class.php';
         require_once '../class/Whatsapi.class.php';
         require_once '../class/Financeiro.class.php';
         require_once '../class/Delivery.class.php';

         $clientes = new Clientes();
         $whatsapi_class = new Whatsapi();
         $financeiro = new Financeiro();
         $delivery_class = new Delivery();
         $fatura   = $clientes->get_fat($reffat);
         $dadosComp  = $clientes->dados_comp($reffat);
         $dados    = $clientes->dados($fatura->id_cliente);
         $logs     = new Logs();
         $planos   = new Planos();
         $user_class   = new User();
         $plano    = $planos->plano($fatura->id_plano);
         $moeda    = $user_class->getmoeda($dados->id_user);
         $user_dados = $user_class->dados($dados->id_user);
         
         if($dados->id_user != $_SESSION['SESSION_USER']['id']){
             $json->erro = true;
             $json->msg  = "Não utorizado";
             echo json_encode($json);
         }
     
        if($_POST['type'] == "aprova"){
            
                 
           $num_faturas_pagas = $clientes->get_faturas_count_pay($dados->id);
            
            if($num_faturas_pagas == 0){
                $indicacao = base64_decode($dados->indicado);
                $clientes->add_indicacao($indicacao,$dados->id_user);
            }
            
                  if($user_dados->notify_page != NULL && $user_dados->notify_page != ""){
                    
                        $dados_notify = json_decode($user_dados->notify_page);
                        
                        if($dados_notify->notify == 1){
                            
                            if($dados_notify->teste == false){
                        
                                $dadosInsertConversion = new stdClass();
                                $dadosInsertConversion->nome = explode(' ',$dados->nome)[0];
                                $dadosInsertConversion->produto = $plano->nome;
                                $dadosInsertConversion->id_user = $user_dados->id;
                                $user_class->insert_lasted_conversion($dadosInsertConversion);
                            
                            }
                        }
                    }

         
              $delivery = $delivery_class->get_deliveryByPlano($plano->id,$_SESSION['SESSION_USER']['id']);


               if($clientes->aprova_comp($reffat,$dadosComp->file,$dir='../comprovantes/')){
             
                   if($clientes->renew($plano,$dados->id,$dados->vencimento)){
                      

                     $_SESSION['INFO'] = "<span><i class='fa fa-check' ></i> Comprovante de <b>{$dados->nome}</b> aprovado!</span>";
        
                     $logs->log($_SESSION['SESSION_USER']['id'],"Aprovou o comprovante de [ {$dados->nome} ] ");
        
                     $text = "Oi {$dados->nome}. Seu comprovante para a fatura #{$fatura->id} de {$moeda->simbolo} {$fatura->valor}, foi aprovado.";
           
        
                      $ar1   = array('+',')','(',' ','-');
                      $ar2   = array('','','','','');
                      $phone = str_replace($ar1,$ar2,$dados->telefone);
    
                      $device = $whatsapi_class->verific_device_situ($dados->id_user);
                        
                        if(strlen($phone) > 10){
                            
                            if($device){
                                
                                if($device->api == "chatpro"){
                                    
                                    $device_id = explode('@@@@',$device->device_id)[0];
                                    $codigo    = explode('@@@@',$device->device_id)[1];
                                    
                                }else{
                                    $device_id = $device->device_id;
                                    $codigo = "null";
                                }
                                
                                if($device->api == "gestorbot"){
                                    $text .= "\n\n*Mensagem automática, não responder*";
                                }
                                
                                if( $whatsapi_class->phoneValidate($phone)){
                                
                                        $whatsapi_class->fila($phone,$text,$_SESSION['SESSION_USER']['id'],$device_id,$device->api,$codigo,$dados->id,"comprovante_aceito_cli");
                                }
                                
                                if($delivery){
                                 
                                  if($delivery->situ == 1){
                                      
                                       $subdelivery = $delivery_class->get_subdeliveryByDelivery($delivery->id);
                                    
                                       if($subdelivery){
                                            
                                            $msg = str_replace('{delivery}',$subdelivery->content,$delivery->text_delivery);
                                            $whatsapi_class->fila($phone,$msg,$_SESSION['SESSION_USER']['id'],$device_id,$device->api,$codigo,$dados->id,'send_delivery',1);
                                            
                                            if($subdelivery->reverse == 0){
                                                $delivery_class->delete_subdelivery($subdelivery->id,$delivery->id,$_SESSION['SESSION_USER']['id']);
                                            }
                                            
                                        }
                                        
                                    }
                                }
                            }
                        }
        
                       // adicionar movimentacao no financeiro
                        $finan = new stdClass();
                        $finan->id_user = $_SESSION['SESSION_USER']['id'];
                        $finan->tipo = 1;
                        $finan->data = date('d/m/Y');
                        $finan->hora = date('H:i');
                        $finan->valor = $fatura->valor;
                        $finan->nota = "Aprovação de comprovante da fatura #{$fatura->id} do cliente {$dados->nome}";
                        
                        $financeiro->insert($finan);
        
        
        
                     $json->erro = false;
                     $json->msg  = "Comprovante aceito";
                     echo json_encode($json);
        
                   }else{
        
                     $json->erro = true;
                     $json->msg  = "Erro ao aceita comprovante de {$dados->nome}";
                     echo json_encode($json);
        
                   }
           
           
           }else{

             $json->erro = true;
             $json->msg  = "Erro ao aceita comprovante de {$dados->nome}";
             echo json_encode($json);

           }
           
        }else if($_POST['type'] == "recusar"){
            
            
            
            
               if($clientes->recusa_comp($reffat,$dadosComp->file,$dir='../comprovantes/')){
    

                     $_SESSION['INFO'] = "<span><i class='fa fa-check' ></i> Comprovante de <b>{$dados->nome}</b> foi recusado </span>";
        
                     $logs->log($_SESSION['SESSION_USER']['id'],"Aprovou o comprovante de [ {$dados->nome} ] ");
        
                     $text = "Oi {$dados->nome}. Seu comprovante para a fatura #{$fatura->id} de {$moeda->simbolo} {$fatura->valor}, foi recusado, sentimos muito.\n\nO que pode ter acontecido ?\n - Comprovante ilegível\n - Meio de pagamento não aceito\n - Pagamento não identificado.";
        
        
                      $ar1   = array('+',')','(',' ','-');
                      $ar2   = array('','','','','');
                      $phone = str_replace($ar1,$ar2,$dados->telefone);
    
                      $device = $whatsapi_class->verific_device_situ($dados->id_user);
                        
                        if(strlen($phone) > 10){
                            
                            if($device){
                                
                                if($device->api == "chatpro"){
                                    
                                    $device_id = explode('@@@@',$device->device_id)[0];
                                    $codigo    = explode('@@@@',$device->device_id)[1];
                                    
                                }else{
                                    $device_id = $device->device_id;
                                    $codigo = "null";
                                }
                                
                                if($device->api == "gestorbot"){
                                    $text .= "\n\n*Mensagem automática, não responder*";
                                }
                                
                                if( $whatsapi_class->phoneValidate($phone)){
                                
                                        $whatsapi_class->fila($phone,$text,$_SESSION['SESSION_USER']['id'],$device_id,$device->api,$codigo,$dados->id,"comprovante_recusado_cli");
                                }
                            }
                        }
        
        
        
        
                     $json->erro = false;
                     $json->msg  = "Comprovante recusado";
                     echo json_encode($json);
    
            
        }else{
        
         $json->erro = true;
         $json->msg  = "Erro ao RECUSAR comprovante de {$dados->nome}";
         echo json_encode($json);

       }
           
           
           
           

         }else{

           $json->erro = true;
           $json->msg  = "Não utorizado";
           echo json_encode($json);

         }
         
         
     }
     
 }
       
  


?>