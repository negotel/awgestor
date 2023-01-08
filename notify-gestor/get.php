<?php

 header("Access-Control-Allow-Origin: *");
 
 if(isset($_GET['member'])){
     
     $id = trim($_GET['member']);
     
     if($id != ""){
         
         if(is_numeric($id)){
             
             require_once '../class/Conn.class.php';
             require_once '../class/User.class.php';
             require_once '../class/Gestor.class.php';
             require_once '../class/Planos.class.php';
             
             $user   = new User();
             $gestor = new Gestor();
             $planos = new Planos();
             
             $dados_user = $user->dados($id);
             
             if($dados_user){
                 
                $vencimento = $user->vencimento($dados_user->vencimento);
                
                if($vencimento != 'vencido'){
                    
                    $plano_gestor = $gestor->plano($dados_user->id_plano);
                    
                    if($plano_gestor){
                        
                        if($plano_gestor->notify_page == 1){
                            
                            if($dados_user->notify_page == NULL || $dados_user->notify_page == ""){
                                echo 'inactive';
                                die;
                            }
                   
                            $dados_notify = json_decode($dados_user->notify_page);
                            
                            try{
                                
                              $dados_notify = json_decode($dados_user->notify_page);
                              
                                 if($dados_notify->notify == 0){
                                    echo 'inactive';
                                    die;
                                }
                                
                                if($dados_notify->teste == false || $dados_notify->teste == 'false'){
                                
                                    $lasted_conversion = $user->getLastedConversion($id);
                                    if($lasted_conversion){
                                        
                                        $time = $gestor->tempo_corrido($lasted_conversion->data);
                                        $info_time = explode(' ',$time); 
                                        
                                        if(isset($info_time[1])){
                                            if(trim($info_time[1]) == "minutos"){
                                                $min = (int)preg_replace('/[^0-9]/', '', $info_time[0]);
                                                if($min > 50){
                                                    $user->removeLastedConversion($lasted_conversion->id);
                                                }
                                            }
                                        }
                                        
                                         echo json_encode(
                                           array(
                                             'nome' => $lasted_conversion->nome,
                                             'produto' => $lasted_conversion->produto,
                                             'bussines' => $dados_notify->bussines,
                                             'time' => 'há '.$time
                                           )
                                         );
                                    }else{
                                        echo 'inactive';
                                    }
                                    
                                }else{
                                    // aleatorio
                                    
                                    $nome = json_decode(file_get_contents('http://gerador-nomes.herokuapp.com/nome/aleatorio'), true);
                                    $plano_aleatorio = $planos->plano_aleatorio($id);
                                    
                                    $produto = $plano_aleatorio->nome;
                                    
                                    if(!$plano_aleatorio){
                                        $produto = " um produto";
                                    }
                                    
                                      echo json_encode(
                                           array(
                                             'nome' => $nome[0],
                                             'produto' => $produto,
                                             'bussines' => $dados_notify->bussines,
                                             'time' => 'há '.rand(2,60).' minutos'
                                           )
                                         );
                                    
                                }
                            
                            
                                
                            }catch(Exception $e){
                                echo 'inactive';
                                die; 
                            }
                            
                   
                            
                        }else{
                            echo 'inactive';
                        }
                        
                    }else{
                        echo 'inactive';
                    }
                    
                }else{
                    echo 'inactive';
                }
                
             }else{
               echo 'inactive';
             }
             
         }else{
             echo 'inactive';
         }
         
     }else{
        echo 'inactive';
     }
 }else{
     echo 'inactive';
 }
 
 
 
 


 ?>
