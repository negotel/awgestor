<?php 
 


 if(isset($_GET['url'])){
  
   $planos_class = new Planos();
   $user_class = new User();
   $gateways_class = new Gateways();
     
    $explode_url = explode('/',trim($_GET['url']));

     if(isset($explode_url[0])){
         
         $planoId       =  base64_decode( $explode_url[0] );
         
         if(is_numeric($planoId)){

             $planoDados = $planos_class->plano($planoId);
 
             if($planoDados){
                 
                 $userGestor = $user_class->dados($planoDados->id_user);
                 
                 if($userGestor){
                     
                     $vencimentoUser = $user_class->vencimento($userGestor->vencimento);
                     
                     if($vencimentoUser != "vencido"){
                         
                         $auth = true;
                         
                         
                         $colorsLink = $planos_class->get_colors_link($planoId);
                         $mpUser     = $gateways_class->dados_mp_user($userGestor->id);
                         $ppUser     = $gateways_class->dados_picpay_user($userGestor->id);
                         $phUser     = $gateways_class->dados_ph_user($userGestor->id);
                         $pixUser    = $gateways_class->dados_bank_user($userGestor->id);
                         
                         
                         
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









 $color1 = isset($colorsLink->color1) ? $colorsLink->color1 : "#8019c5";
 $color2 = isset($colorsLink->color2) ? $colorsLink->color2 : "#8019c5";

 $color_ticket  = isset($colorsLink->color_ticket) ? $colorsLink->color_ticket : "#770ac1";
 $border_ticket = isset($colorsLink->border_ticket) ? $colorsLink->border_ticket : "#b13fff";

 $color_button = isset($colorsLink->color_button) ? $colorsLink->color_button : "#8019c5";
 $text_button = isset($colorsLink->text_button) ? $colorsLink->text_button : "Continuar";







?>