<?php

  require_once 'autoload.php';

  $clientes_class = new Clientes();
  $user_class = new User();
  $gestor_class = new Gestor();
  $whatsapi_class = new Whatsapi();

  if(isset($_POST['json'])){
      
      
      $dados = json_decode($_POST['json']);
      
      if($dados->nome != "" && $dados->email != "" && $dados->wpp != "" && $dados->senha != ""){
          
          
          
          // buscar user com o painel de referencia
          $painel     = $clientes_class->area_cli_dados($dados->painel);
          $user       = $user_class->dados($painel->id_user);
          $plano      = $gestor_class->plano($user->id_plano);
          $limitCli   = $user_class->limit_plano($user->id_plano);
          $areaCli    = $clientes_class->area_cli_conf($user->id);
          
          
          $telefone = '55'.str_replace(' ','',str_replace('-','',str_replace('(','',str_replace(')','',$dados->wpp))));
          
          if($user){
              
              if($plano){
                  
                  $mail_existe = $clientes_class->verific_email($dados->email);
                  
                  if($mail_existe){
                      
                      
                    $dadosUser = new stdClass();
                    $dadosUser->limit_plano  = $limitCli;
                    $dadosUser->id_user      = $user->id;
                    $dadosUser->nome         = $dados->nome;
                    $dadosUser->email        = $dados->email;
                    $dadosUser->telefone     = $telefone;
                    $dadosUser->vencimento   = '00/00/0000';
                    $dadosUser->id_plano     = '0';
                    $dadosUser->notas        = "Senha para acessar seu painel cliente futuramente ".$dados->senha;
                    $dadosUser->senha        = $dados->senha;
                    $dadosUser->recebe_zap   = 1;
                    $dadosUser->indicado     = $dados->ind;

                    
                    $inser = $clientes_class->insert2($dadosUser);
                    
                    if($inser != '0'){
                        
                        $token = $clientes_class->token_login($dados->email,$dados->senha);
                        $link = "https://cliente.gestorlite.com/{$areaCli->slug_area}?token={$token}";
                        
                        $ar1  = array('{nome_cliente}','{senha}','{link_panel}');
                        $ar2  = array($dados->nome,$dados->senha,"https://cliente.gestorlite.com/{$areaCli->slug_area}");
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
                          $text = str_replace($ar1,$ar2,"Olá {nome} \n\nUm novo cliente se cadastrou no site ! \n\nNome: {$dados->nome}\nEmail: {$dados->email}\nWhatsapp: wa.me/{$telefone}");
                
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
                      echo json_encode(['erro' => true, 'msg' => 'Este email já está em uso']);
                      die;
                  }
                  
                  
              }else{
                echo json_encode(['erro' => true, 'msg' => 'Entre em contato com o suporte']);
                die;
            }
              
              
          }else{
                echo json_encode(['erro' => true, 'msg' => 'Entre em contato com o suporte']);
                die;
            }
  
      }else{
        echo json_encode(['erro' => true, 'msg' => 'Preencha todos os campos']);
        die;
    }
      
      
      
  }