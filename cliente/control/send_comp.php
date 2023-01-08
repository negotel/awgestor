<?php 

  $comprovantes_class = new Comprovantes();
  $whatsapi_class = new Whatsapi();
  $user_class = new User();

  $adm = $user_class->dados($_SESSION['PAINEL']['id_user']);
  
    
  if(isset($_FILES) && isset($_POST['meio_pay_idFat'])){
          $files = $_FILES;
          $post  = $_POST;
          $post['cliente_id'] = $_SESSION['SESSION_CLIENTE']['id'];
          $post['id_user'] = $_SESSION['PAINEL']['id_user'];
          
          $comp = $comprovantes_class->uploadComp($files,$post,'../comprovantes/',false,$whatsapi_class);
    
          if($comp){
              $msg = explode('|',$comp)[0];
              
              
              $text = "Olá! Um de seus clientes, enviou um comprovante pelo sistema da Gestor Lite.\nReferente a fatura: #".$_POST['meio_pay_idFat']."\nAcesse Seu painel e confira.\n\nOu clique no link abaixo: <?=SET_URL_PRODUCTION?>/comprovantes/".explode('|',$comp)[1];

              $ar1   = array('+',')','(',' ','-');
              $ar2   = array('','','','','');
              $phone = $adm->ddi.str_replace($ar1,$ar2,$adm->telefone);


              $whatsapi_class->fila($phone,$text,$adm->id,'gestorbot','gestorbot','0000','0000',"comprovante_recebido");
                        

              
          }else{
              $msg = "Desculpe, ocorreu um erro. Entre em contato com o suporte.";
          }
      }

    


?>