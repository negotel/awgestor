<?php 
    
 require_once 'autoload.php';
 
 $planos_class = new Planos();
 $user_class = new User();
 $clientes_class = new Clientes();
 $whatsapi_class = new Whatsapi();
 

 if(isset($_POST['json'])){
     
     $dados = json_decode($_POST['json']);
     
     if(isset($_POST['captcha'])){
         $captcha = trim($_POST['captcha']);
         
         if($captcha == $_SESSION['captcha']){
             
             if($dados->nome != "" && $dados->email != "" && $dados->wpp != "" && $dados->ddi != "" && $dados->id_plano != ""){
                 
                 $senha = rand(99999,999999);
                 
                 // buscar dados do plano
                 $plano = $planos_class->plano($dados->id_plano);
                 
                 //buscar dados do usuario dono
                 $user = $user_class->dados($plano->id_user);
                 
                 // buscar limite de clientes do plano do usario dono
                 $limitCli = $user_class->limit_plano($user->id_plano);
                 
                 //buscar area do cliente do usuario dono
                 $areaCli  = $clientes_class->area_cli_conf($user->id);
                 
                 $telefone = $dados->ddi.str_replace(' ','',str_replace('-','',str_replace('(','',str_replace(')','',$dados->wpp))));
                 
                 if($user){
                 
                     if($plano){
                         
                         //verificar se cliente existe
                         $mail_existe = $clientes_class->verific_email($dados->email);
                         
                         if($mail_existe){
                             // cliente não existe, criar cliente
                             
                            $dadosUser = new stdClass();
                            $dadosUser->limit_plano  = $limitCli;
                            $dadosUser->id_user      = $user->id;
                            $dadosUser->nome         = $dados->nome;
                            $dadosUser->email        = $dados->email;
                            $dadosUser->telefone     = $telefone;
                            $dadosUser->vencimento   = '00/00/0000';
                            $dadosUser->id_plano     = $dados->id_plano;
                            $dadosUser->notas        = "Senha para acessar seu painel cliente futuramente {$senha}";
                            $dadosUser->senha        = $senha;
                            $dadosUser->recebe_zap   = 1;
                            
                            $inser = $clientes_class->insert2($dadosUser);
                            
                            if($inser != '0'){
                               // criar token de login 
                               $token = $clientes_class->token_login($dados->email,$senha);
                               $link = "https://cliente.gestorlite.com/{$areaCli->slug_area}?token={$token}&plano={$dados->id_plano}";
                               
                               
                               // adicioar email/whats na fila
                                $ar1  = array('{nome_cliente}','{senha}','{link_panel}');
                                $ar2  = array($dados->nome,$senha,"https://cliente.gestorlite.com/{$areaCli->slug_area}");
                                $template_mail = file_get_contents('modelo_mail.txt');
                                $text = str_replace($ar1,$ar2,$template_mail);
                                
                                
                                $phone = $telefone;
                             
                                $device = $whatsapi_class->verific_device_situ($user->id);
                                $device_id = "000";
                                $codigo = "000";
                                $api = "000";
                                
                                 if($device){
                                     $api = $device->api;
                                     
                                         if($device->api == "chatpro"){
                    
                                            $device_id = explode('@@@@',$device->device_id)[0];
                                            $codigo    = explode('@@@@',$device->device_id)[1];
                                    
                                        }else{
                                            $device_id = $device->device_id;
                                            $codigo = "null";
                                        }
                                }
                                
                                $whatsapi_class->fila($phone,$text,$user->id,$device_id,$device->api,$codigo,$inser->id,"novo_user");
                                
                                  $ar1  = array('{nome}');
                                  $ar2  = array($user->nome);
                                  $text = str_replace($ar1,$ar2,"Olá {nome} \n\nUm novo cliente se cadastrou no site ! \n\nNome: {$dados->nome}\nEmail: {$dados->email}\nWhatsapp: wa.me/{$phone}");
                        
                                  $ar1    = array('+',')','(',' ','-');
                                  $ar2    = array('','','','','');
                                  $phone2 = $user->ddi.str_replace($ar1,$ar2,$user->telefone);
                                  $whatsapi_class->fila($phone2,$text,$user->id,'0000','gestorbot','0000','0000',"novo_user_dono");
                                
                                
                                               
                               echo json_encode(['erro' => false, 'link' => $link]);
                               die;
                            }else{
                                echo json_encode(['erro' => true, 'msg' => 'Entre em contato com o suporte']);
                                die;
                            }
                             
                         }else{
                             // cliente existe
                             // preparar checkout e pedir login
                             // redirecionar para criar plano após login
                             $link = "https://cliente.gestorlite.com/{$areaCli->slug_area}?login={$dados->email}&plano={$dados->id_plano}";
                             echo json_encode(['erro' => false, 'link' => $link]);
                             die;
                         }
                         
                     }else{
                         echo json_encode(['erro' => true, 'msg' => 'Infelizmente este plano não está mais dispinível']);
                         die;
                     }
                 }else{
                      echo json_encode(['erro' => true, 'msg' => 'Me parece que aconteceu algo de errado']);
                      die;
                 }
             }else{
                  echo json_encode(['erro' => true, 'msg' => 'Preencha todos os campos']);
                  die;
             }
             
         }else{
              echo json_encode(['erro' => true, 'msg' => 'É necessário que visite https://glite.me/p/'.str_replace('=','',base64_encode($dados->id_plano)).' para fazer este checkout']);
              die;
         }
     }else{
         echo json_encode(['erro' => true, 'msg' => 'É necessário que visite https://glite.me/p/'.str_replace('=','',base64_encode($dados->id_plano)).' para fazer este checkout']);
          die;
     }
 }


?>