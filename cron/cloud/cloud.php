<?php 

 $clientes_class = new Clientes();

 // list fila cloud
 $getP = $apiPanel_class->get_fila_cloud(); 
 $panel = $apiPanel_class->get_panel($getP->id_panel);

 if($panel){
     
     // verificar usuario
     $user = $user_class->dados($panel->id_user);
     
     if($user){
         
        if($user_class->vencimento($user->vencimento) != "vencido"){
            
            
            $limitCli = $user_class->limit_plano($user->id_plano);
            
            
            
            //apto para fazer a integração
            // identificar qual api esta usando
            
             switch ($panel->api) {
                case 'xtream-ui': $name_class_api = "Xtream"; break;
                case 'kofficeV2': $name_class_api = "KOfficeV2"; break;
                case 'kofficeV4': $name_class_api = "KOfficeV4"; break;
            }
            
            $apiAuth = new $name_class_api();
            
            $all_clis = $apiAuth->getAllClients($panel->cms,$panel->username,$panel->password);
            
            if($all_clis){
            
                if(json_decode($all_clis)){
                    
                    
                    #################################
                    # CLOUD XTREAM
                    #################################
                    
                    if($name_class_api == "Xtream"){
                    
                        $return = json_decode($all_clis);
                        $result = array();
                        
                        if(!isset($return->data)){
                   
                           $json->erro = true;
                           $json->msg  = "Desculpe, não foi possível importar";
                           echo json_encode($json);
            
                           die;
                         }
                         
                         foreach ($return->data as $key => $value) {
    
                           $explode_ven = explode('-',strip_tags($value[7]));
                           $vencimento  = $explode_ven[2].'/'.$explode_ven[1].'/'.$explode_ven[0];
            
                           if($value[3] == $panel->username){
            
                              $dadosUser = new stdClass();
                              $dadosUser->limit_plano  = $limitCli;
                              $dadosUser->id_user      = $user->id;
                              $dadosUser->nome         = $value[1];
                              $dadosUser->email        = "vazio";
                              $dadosUser->telefone     = "vazio";
                              $dadosUser->vencimento   = $vencimento;
                              $dadosUser->id_plano     = 0;
                              $dadosUser->notas        = 'Importado de '.$panel->api;
                              $dadosUser->senha        = $value[2];
                              $dadosUser->recebe_zap   = 1;
                              $dadosUser->id_painel    = $value[0];
                    
                             if($value[6] != "<i class=\"text-warning fas fa-circle\"></i>"){
                               $inser = $clientes_class->insert_cloud($dadosUser);
                             }
                             
                            
                          }
   
                        }
                    }
                         
                    #################################
                    # FINAL CLOUD XTREAM
                    #################################
                    
                    
                    
                    
                }
            }
        
        }
     }
     
     $apiPanel_class->delete_fila_cloud($panel->id);
     
 }
 





?>