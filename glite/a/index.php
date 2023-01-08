<?php 

 require_once '../p/autoload.php';
 
 $user_class = new User();
 $gestor_class = new Gestor();
 $clientes_class = new Clientes();
 
 if(isset($_GET['url'])){
     
    $explode_url = explode('/',$_GET['url']);

     $user = $user_class->dados(base64_decode($explode_url[0]));

    if($user){
        
        
        // get plano do user
        
        $plano           = $gestor_class->plano($user->id_plano);
        $vencimento_user = $user_class->vencimento($user->vencimento);
        
        
        if($vencimento_user != "vencido"){
            
            // buscar dados da area do cliente
            $are_cli = $clientes_class->area_cli_conf($user->id);
            
            if($are_cli){
                
                if($are_cli->situ_area == 1){
                    
                    if(isset($explode_url[1])){
                        if($explode_url[1] == 'c'){
                           header('LOCATION: https://cliente.gestorlite.com/'.$are_cli->slug_area.'?create');
                           exit();
                        }
                    }
                    
                    header('LOCATION: https://cliente.gestorlite.com/'.$are_cli->slug_area);
                    
                    
                }else{
                    $erro = true;
                }
                
            }else{
                $erro = true;
            }
            
            
        }else{
            $erro = true;
        }
        
    }else{
        $erro = true;
    }

 }else{
    $erro = true;
    
 }


 if(isset($erro)){
     if($erro){
       header('LOCATION: https://glite.me/403');    
     }
 }


?>
