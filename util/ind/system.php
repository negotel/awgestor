<?php 
 


 if(isset($_GET['url'])){
  
   $clientes_class = new Clientes();
   $user_class = new User();

    $explode_url = explode('/',trim($_GET['url']));

     if(isset($explode_url[0])){
         
         $id_cliente_indicado       =  base64_decode( $explode_url[0] );
         
         if(is_numeric($id_cliente_indicado)){

             $cliente = $clientes_class->dados($id_cliente_indicado);
 
             if($cliente){
                 
                 $userGestor = $user_class->dados($cliente->id_user);
                 
                 if($userGestor){
                     
                     $vencimentoUser = $user_class->vencimento($userGestor->vencimento);
                     
                     if($vencimentoUser != "vencido"){
                         
                         
                         
                         $area_cliente = $clientes_class->area_cli_conf($userGestor->id);
                          
                         if($area_cliente){
                             
                             $auth = true;
                             header('LOCATION: https://cliente.gestorlite.com/'.$area_cliente->slug_area.'?create&ind='.$explode_url[0]);
                             exit();
                             
                         }else{
                             $auth = false;
                         }
                         
                         
                     }else{
                         $auth = false;
                     }
                     
                 }else{
                     $auth = false;
                 }
                 
             }else{
                 $auth = false;
             }
             
         }else{
           $auth = false;
        }
     }else{
       $auth = false;
    }
        
 }else{
     $auth = false;
 }




?>