<?php

  set_time_limit(3000);

  require_once 'autoload.php';
  
  $user_class = new User();
  $whatsapi_class = new Whatsapi();
  $clientes_class = new Clientes();
  $planos_class = new Planos();

  $data = date('d/m/Y');

  $list_users = $clientes_class->list_vencimento($data);

  if($list_users){

    while ($user = $list_users->fetch(PDO::FETCH_OBJ)) {
        
        $adm = $user_class->dados($user->id_user);

        $ar12   = array('+',')','(',' ','-');
        $ar22   = array('','','','','');
        $phone2 = $adm->ddi.str_replace($ar12,$ar22,$adm->telefone);

        $plano = $planos_class->plano($user->id_plano);
        
        $link_plano = 'https://glite.me/p/'.str_replace('=','',base64_encode($plano->id));

        $ar1  = array('{senha_cliente}','{nome_cliente}','{primeiro_nome_cliente}','{email_cliente}','{telefone_cliente}','{vencimento_cliente}','{plano_valor}','{data_atual}','{plano_nome}','{plano_link}');
        $ar2  = array($user->senha,$user->nome,explode(' ',$user->nome)[0],$user->email,$user->telefone,$user->vencimento,$plano->valor,date('d/m/Y'),$plano->nome,$link_plano);
        $text = str_replace($ar1,$ar2,$plano->template_zap);

        $ar1   = array('+',')','(',' ','-');
        $ar2   = array('','','','','');
        $phone = str_replace($ar1,$ar2,$user->telefone);


        $device = $whatsapi_class->verific_device_situ($user->id_user);
        
        if(strlen($phone) > 10){
            
            if($device){
                
                if($device->api == "chatpro"){
                    
                    $device_id = explode('@@@@',$device->device_id)[0];
                    $codigo    = explode('@@@@',$device->device_id)[1];
                    
                }else{
                    $device_id = $device->device_id;
                    $codigo = "null";
                }
                
                if( $whatsapi_class->phoneValidate($phone)){
                
                        $whatsapi_class->fila($phone,$text,$adm->id,$device_id,$device->api,$codigo,$user->id,"vencimento_day");
                }
            }
        }

    }

  }


?>
