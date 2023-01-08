<?php 


   // __autoload
   require_once '../libs/MercadoPago/lib/mercadopago.php';
   require_once 'autoload.php';
   
   $clientes_class = new Clientes();
   $planos_class = new Planos();
   $user_class = new User();
   $gateways_class = new Gateways();
   $whatsapi_class = new Whatsapi();
   $financeiro_class = new Financeiro();
   $delivery_class = new Delivery();
   

   if(isset($explo_url[1]) && isset($explo_url[2])){
       
       
       $ref = base64_decode($explo_url[1]);
       
       if($ref){
           
           $fatura = $clientes_class->search_fat_by_ref($ref,true);
           
           if($fatura){
               
               $cliente = $clientes_class->dados($fatura->id_cliente);
               
               if($cliente){
                   
                   $plano = $planos_class->plano($fatura->id_plano);
                   
                   if($plano){
                       
                       $dono     = $user_class->dados($cliente->id_user);
                       $delivery = $delivery_class->get_deliveryByPlano($plano->id,$dono->id);
                       
                       if($dono){
                           
                           // MERCADO PAGO
                           if($explo_url[2] == 'mercadopago'){
                               
                              echo '<script>location.href="https://cliente.gestorlite.com";</script>';
                               
                               if(isset($_REQUEST['collection_id']) || isset($_REQUEST['id'])){
                                   
                                   $cod         = isset($_GET['collection_id']) ? $_REQUEST['collection_id'] : $_REQUEST['id'];
                                   $credenciais = $gateways_class->dados_mp_user($dono->id);
                                   
                               
                                   if($credenciais){
                                       
                                       $notification = $gateways_class->notification_mp($credenciais,$cod);
                             
                                       
                                        if($notification){

                                            $info_notification = json_decode($notification);
                                            
                                            if($info_notification->status == "approved"){
                                                
                                                $renew = $clientes_class->renew($plano,$cliente->id,$cliente->vencimento);
                                            
                                                
                                                if($renew){
                                                    
                                                    if($dono->notify_page != NULL && $dono->notify_page != ""){
                                                    
                                                        $dados_notify = json_decode($dono->notify_page);
                                                        
                                                        if($dados_notify->notify == 1){
                                                            
                                                            if($dados_notify->teste == false){
                                                        
                                                                $dadosInsertConversion = new stdClass();
                                                                $dadosInsertConversion->nome = explode(' ',$cliente->nome)[0];
                                                                $dadosInsertConversion->produto = $plano->nome;
                                                                $dadosInsertConversion->id_user = $dono->id;
                                                                $user_class->insert_lasted_conversion($dadosInsertConversion);
                                                            
                                                            }
                                                        }
                                                    }
                                                    
                                                    $num_faturas_pagas = $clientes_class->get_faturas_count_pay($cliente->id);
                                                    
                                                    if($num_faturas_pagas == 0){
                                                        $indicacao = base64_decode($cliente->indicado);
                                                        $clientes_class->add_indicacao($indicacao,$dono->id);
                                                    }
                                                    
                                                    $update_status = $clientes_class->update_fat_status($fatura->id,$info_notification->nome_status);
                                                    
                                                    $cliente_nome  = explode(' ',$cliente->nome)[0];
                                                    $zap_cliente   = str_replace('-','',str_replace(' ','',$cliente->telefone));
                                                    $nome_dono     = explode(' ',$dono->nome)[0];
                                                    
                                                    $ar12     = array('+',')','(',' ','-');
                                                    $ar22     = array('','','','','');
                                                    $zap_dono = $dono->ddi.str_replace($ar12,$ar22,$dono->telefone);
                                                    
                                                    
                                                    $saudacao[1] = "Olá {nome_dono}. Tudo jóia";
                                                    $saudacao[2] = "Eae {nome_dono}. como andas?";
                                                    $saudacao[3] = "Tem novo pagamento na área {nome_dono}.";
                                                    $saudacao[4] = "Como você está {nome_dono}?";
                                                    $saudacao[5] = "Mais uma venda {nome_dono} !!! To feliz de mais.";
                                                    
                                                    
                                                    $saudacaoF[1] = "\n\nBeijinhos :*";
                                                    $saudacaoF[2] = "\n\nAté depois :)";
                                                    $saudacaoF[3] = "\n\nTchau tchau !!!";
                                                    $saudacaoF[4] = "\n\nBye!";
                                                    $saudacaoF[5] = "\n\nÓtimas vendas Amore... ";
                                                    
                                                    // notificacoes whatsapp
                                                    
                                                    $srt1 = array('{data}','{forma}','{nome_cliente}','{nome_dono}','{plano_nome}','{valor}','{zap_cliente}','{status}');
                                                    $str2 = array(date('d/m/y'),"Mercado Pago / ".$info_notification->forma,$cliente->nome,$nome_dono,$plano->nome,$plano->valor,$zap_cliente,$info_notification->nome_status);
                                                    
                                                    $string_dono = $saudacao[rand(1,5)]."\n\nUm cliente seu pagou o plano *{plano_nome}*, utlizando o Gestor Lite. \n\n\nE estou aqui para te notificar desta transação.\n\n\nSegue os dados:\n*Data*: {data}\n*Cliente*: {nome_cliente}\n*Valor*: R$ {valor}\n*Forma*: {forma}\n*Status*: {status}\n*Zap Cliente*: {zap_cliente}\n\n\nPara mais informações acesse o seu painel gestor.".$saudacaoF[rand(1,5)];
                                                    $string_cli  = "Oi {nome_cliente}. Seu pagamento de R$ {valor} para o plano {plano_nome}, foi aprovado! \n\n Em caso de dúvidas ou suporte, pode responder está mensagem com sua dúvida.";
                                                
        
                                                    $text_dono = str_replace($srt1,$str2,$string_dono);
                                                    $text_cli  = str_replace($srt1,$str2,$string_cli);
                                                    
                                                    // verificar device dono
                                                    $device    = $whatsapi_class->verific_device_situ($dono->id);
                                                    
                                                     // enviar cliente
                                                    if($device){
                                                        
                                                        if($device->api == "chatpro"){
                
                                                            $device_id = explode('@@@@',$device->device_id)[0];
                                                            $codigo    = explode('@@@@',$device->device_id)[1];
                                                            
                                                        }else{
                                                            $device_id = $device->device_id;
                                                            $codigo = "null";
                                                        }
                                                        
                                                                        
                                                    if($delivery){
                                                        
                                                        if($delivery->situ == 1){
                                                      
                                                          $subdelivery = $delivery_class->get_subdeliveryByDelivery($delivery->id);
                                                        
                                                           if($subdelivery){
                                                                
                                                                $msg = str_replace('{delivery}',$subdelivery->content,$delivery->text_delivery);
                                                                $whatsapi_class->fila($zap_cliente,$msg,$dono->id,$device_id,$device->api,$codigo,$cliente->id,'send_delivery',1);
                                                                
                                                                if($subdelivery->reverse == 0){
                                                                    $delivery_class->delete_subdelivery($subdelivery->id,$delivery->id,$dono->id);
                                                                }
                                                                
                                                            }
                                                        }
                                                    }
                                                        
                                                        $whatsapi_class->fila($zap_cliente,$text_cli,$dono->id,$device_id,$device->api,$codigo,$cliente->id,'pagamento_confirmado');
                                                        
                                                    }
                                                    
                                                    // fim enviar cliente
                                                    
                                                    // enviar dono
                                                    $whatsapi_class->fila($zap_dono,$text_dono,$dono->id,'gestorbot','gestorbot','0000','0000',"pagamento_aprovado");
                                                    // fim evia dono 
                                                    
                                                    // verificar se esta ativo registro de financeiro
                                                    if($dono->lancar_finan == 1){
                                                        $dados_finan = new stdClass();
                                                        $dados_finan->id_user = $dono->id;
                                                        $dados_finan->tipo    = 1;
                                                        $dados_finan->data    = date('d/m/Y');
                                                        $dados_finan->hora    = date('H:i');
                                                        $dados_finan->valor   = $plano->valor;
                                                        $dados_finan->nota    = "Mercado Pago Automático.\n\nCliente: {$cliente_nome}.\nPlano: {$plano->nome}";
                                                        
                                                        $insert_finan = $financeiro_class->insert($dados_finan);
                                                    }
                                                    
                                                }
                                            }
                                            
                                            
                                        }else{
                                            echo "erro ao se comunicar com mercado pago";
                                            echo "<br />Redirecionando... <script>setTimeout(function(){location.href='https://cliente.gestorlite.com/';},2000);</script>";
                                        }
                                       
                                   }else{
                                       echo "usuario dono nao possui credenciais mercado pago";
                                       echo "<br />Redirecionando... <script>setTimeout(function(){location.href='https://cliente.gestorlite.com/';},2000);</script>";
                                   }
                              }
                           }
                           // FIM MERCADO PAGO
                           
                           
                           // PAG HIPER
                           if($explo_url[2] == 'paghiper'){
    
                               
                               if(isset($_REQUEST['apiKey']) && isset($_REQUEST['transaction_id'])){
                                   
                                   $credenciais = $gateways_class->dados_ph_user(false,$_REQUEST['apiKey']);

                                    
                                   if($credenciais){
                                       
                                         $jsonSend = new stdClass();
                                         $jsonSend->token = $credenciais->token;
                                         $jsonSend->apiKey = $_REQUEST['apiKey'];
                                         $jsonSend->transaction_id = $_REQUEST['transaction_id'];
                                         $jsonSend->notification_id = $_REQUEST['notification_id'];
                                   
                                         $data = json_encode($jsonSend);
                                         
                                       
                                       $notification = $gateways_class->notification_hp($data);
                             
                                       
                                        if($notification){

                                            $info_notification = json_decode($notification);
                                            
                                            if(@$info_notification->status == "Pago"){
                                                
                                                $renew = $clientes_class->renew($plano,$cliente->id,$cliente->vencimento);
                                                
                                                if($renew){
                                                    
                                                      if($dono->notify_page != NULL && $dono->notify_page != ""){
                                                    
                                                        $dados_notify = json_decode($dono->notify_page);
                                                        
                                                        if($dados_notify->notify == 1){
                                                            
                                                            if($dados_notify->teste == false){
                                                        
                                                                $dadosInsertConversion = new stdClass();
                                                                $dadosInsertConversion->nome = explode(' ',$cliente->nome)[0];
                                                                $dadosInsertConversion->produto = $plano->nome;
                                                                $dadosInsertConversion->id_user = $dono->id;
                                                                $user_class->insert_lasted_conversion($dadosInsertConversion);
                                                            
                                                            }
                                                        }
                                                    }
                                                    
                                                    
                                                    $num_faturas_pagas = $clientes_class->get_faturas_count_pay($cliente->id);
                                                    
                                                    if($num_faturas_pagas == 0){
                                                        $indicacao = base64_decode($cliente->indicado);
                                                        $clientes_class->add_indicacao($indicacao,$dono->id);
                                                    }
                                                    
                                                    $update_status = $clientes_class->update_fat_status($fatura->id,$info_notification->status);
                                                    
                                                    $cliente_nome  = explode(' ',$cliente->nome)[0];
                                                    $zap_cliente   = str_replace('-','',str_replace(' ','',$cliente->telefone));
                                                    $nome_dono     = explode(' ',$dono->nome)[0];
                                                    
                                                    $ar12     = array('+',')','(',' ','-');
                                                    $ar22     = array('','','','','');
                                                    $zap_dono = $dono->ddi.str_replace($ar12,$ar22,$dono->telefone);
                                                    
                                                    
                                                    $saudacao[1] = "Olá {nome_dono}. Tudo jóia";
                                                    $saudacao[2] = "Eae {nome_dono}. como andas?";
                                                    $saudacao[3] = "Tem novo pagamento na área {nome_dono}.";
                                                    $saudacao[4] = "Como você está {nome_dono}?";
                                                    $saudacao[5] = "Mais uma venda {nome_dono} !!! To feliz de mais.";
                                                    
                                                    
                                                    $saudacaoF[1] = "\n\nBeijinhos :*";
                                                    $saudacaoF[2] = "\n\nAté depois :)";
                                                    $saudacaoF[3] = "\n\nTchau tchau !!!";
                                                    $saudacaoF[4] = "\n\nBye!";
                                                    $saudacaoF[5] = "\n\nÓtimas vendas Amore... ";
                                                    
                                                    // notificacoes whatsapp
                                                    
                                                    $srt1 = array('{data}','{forma}','{nome_cliente}','{nome_dono}','{plano_nome}','{valor}','{zap_cliente}','{status}');
                                                    $str2 = array(date('d/m/y'),"Pag Hiper / ".$info_notification->forma,$cliente->nome,$nome_dono,$plano->nome,$plano->valor,$zap_cliente,$info_notification->nome_status);
                                                    
                                                    $string_dono = $saudacao[rand(1,5)]."\n\nUm cliente seu pagou o plano *{plano_nome}*, utlizando o Gestor Lite. \n\n\nE estou aqui para te notificar desta transação.\n\n\nSegue os dados:\n*Data*: {data}\n*Cliente*: {nome_cliente}\n*Valor*: R$ {valor}\n*Forma*: {forma}\n*Status*: {status}\n*Zap Cliente*: {zap_cliente}\n\n\nPara mais informações acesse o seu painel gestor.".$saudacaoF[rand(1,5)];
                                                    $string_cli  = "Oi {nome_cliente}. Seu pagamento de R$ {valor} para o plano {plano_nome}, foi aprovado! \n\n Em caso de dúvidas ou suporte, pode responder está mensagem com sua dúvida.";
                                                
        
                                                    $text_dono = str_replace($srt1,$str2,$string_dono);
                                                    $text_cli  = str_replace($srt1,$str2,$string_cli);
                                                    
                                                    // verificar device dono
                                                    $device    = $whatsapi_class->verific_device_situ($dono->id);
                                                    
                                                     // enviar cliente
                                                    if($device){
                                                        
                                                        if($device->api == "chatpro"){
                
                                                            $device_id = explode('@@@@',$device->device_id)[0];
                                                            $codigo    = explode('@@@@',$device->device_id)[1];
                                                            
                                                        }else{
                                                            $device_id = $device->device_id;
                                                            $codigo = "null";
                                                        }
                                                        
                                                            
                                                    if($delivery){
                                                          
                                                          if($delivery->situ == 1){
                                                                  
                                                              $subdelivery = $delivery_class->get_subdeliveryByDelivery($delivery->id);
                                                            
                                                               if($subdelivery){
                                                                    
                                                                    $msg = str_replace('{delivery}',$subdelivery->content,$delivery->text_delivery);
                                                                    $whatsapi_class->fila($zap_cliente,$msg,$dono->id,$device_id,$device->api,$codigo,$cliente->id,'send_delivery',1);
                                                                    
                                                                    if($subdelivery->reverse == 0){
                                                                        $delivery_class->delete_subdelivery($subdelivery->id,$delivery->id,$dono->id);
                                                                    }
                                                                    
                                                                }
                                                          }
                                                          
                                                        }
                                                            
                                                        $whatsapi_class->fila($zap_cliente,$text_cli,$dono->id,$device_id,$device->api,$codigo,$cliente->id,'pagamento_confirmado');
                                                        
                                                    }
                                                    
                                                    // fim enviar cliente
                                                    
                                                    // enviar dono
                                                    $whatsapi_class->fila($zap_dono,$text_dono,$dono->id,'gestorbot','gestorbot','0000','0000',"pagamento_aprovado");
                                                    // fim evia dono 
                                                    
                                                    // verificar se esta ativo registro de financeiro
                                                    if($dono->lancar_finan == 1){
                                                        $dados_finan = new stdClass();
                                                        $dados_finan->id_user = $dono->id;
                                                        $dados_finan->tipo    = 1;
                                                        $dados_finan->data    = date('d/m/Y');
                                                        $dados_finan->hora    = date('H:i');
                                                        $dados_finan->valor   = $plano->valor;
                                                        $dados_finan->nota    = "Pag Hiper Automático.\n\nCliente: {$cliente_nome}.\nPlano: {$plano->nome}";
                                                        
                                                        $insert_finan = $financeiro_class->insert($dados_finan);
                                                    }
                                                    
                                                }
                                            }
                                            
                                            
                                        }else{
                                            echo "erro ao se comunicar com paghiper";
                                            echo "<br />Redirecionando... <script>setTimeout(function(){location.href='https://cliente.gestorlite.com/';},2000);</script>";
                                        }
                                       
                                   }else{
                                       echo "usuario dono nao possui credenciais paghiper";
                                       echo "<br />Redirecionando... <script>setTimeout(function(){location.href='https://cliente.gestorlite.com/';},2000);</script>";
                                   }
                              }
                           }
                           // FIM PAG HIPER
                           
                           
                       }else{
                           echo "usuario dono nao localizado";
                           echo "<br />Redirecionando... <script>setTimeout(function(){location.href='https://cliente.gestorlite.com/';},2000);</script>";
                       }
                       
                       
                   }else{
                       echo "plano nao localizado";
                       echo "<br />Redirecionando... <script>setTimeout(function(){location.href='https://cliente.gestorlite.com/';},2000);</script>";
                   }
                   
               }else{
                   echo "cliente nao localizao";
                   echo "<br />Redirecionando... <script>setTimeout(function(){location.href='https://cliente.gestorlite.com/';},2000);</script>";
               }
               
               
           }else{
               echo "fatura nao encontrada ou paga";
               echo "<br />Redirecionando... <script>setTimeout(function(){location.href='https://cliente.gestorlite.com/';},2000);</script>";
           }
           
           
       }else{
           echo "referencia exigida";
           echo "<br />Redirecionando... <script>setTimeout(function(){location.href='https://cliente.gestorlite.com/';},2000);</script>";
       }
       
   }
    


?>