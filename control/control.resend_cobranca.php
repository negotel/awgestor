<?php

  @session_start();
  set_time_limit(3000);
require_once "../config/settings.php";
  require_once '../class/Conn.class.php';
  require_once '../class/User.class.php';
  require_once '../class/Clientes.class.php';
  require_once '../class/Whatsapi.class.php';
  require_once '../class/Planos.class.php';

  $user_c     = new User();
  $clientes_c = new Clientes();
  $whatsapi_c = new Whatsapi();
  $planos_c   = new Planos();


  if(isset($_POST['removeFila'])){

    $id = trim($_POST['id']);
    $user = $_SESSION['SESSION_USER']['id'];

    if($whatsapi_c->get_msg_file_by_id($user,$id)){

      if($whatsapi_c->delete_fila($id)){
        echo json_encode(array("erro" => false, "msg" => "A mensagem foi removida da fila"));
      }else{
        echo json_encode(array("erro" => true, "msg" => "Erro. Talvez a mensagem já não esteja mais na fila"));
      }

    }else{
      echo json_encode(array("erro" => true, "msg" => "Erro. Talvez a mensagem já não esteja mais na fila"));
    }

  }

  if(isset($_POST['id_cli']) && isset($_POST['text_to'])){

    if($_POST['text_to'] != ""){

      $id_cli  = $_POST['id_cli'];
      $text_to = $_POST['text_to'];
      $data = date('d/m/Y');

      $user = $clientes_c->dados($id_cli);

      if($user){

            $adm = $user_c->dados($user->id_user);

            if($whatsapi_c->verifica_fila_lembrete($adm->id)){

                $plano = $planos_c->plano($user->id_plano);



                $link_plano = 'https://glite.me/p/'.str_replace('=','',base64_encode($plano->id));

                $ar1   = array('+',')','(',' ','-');
                $ar2   = array('','','','','');
                $phone = str_replace($ar1,$ar2,$user->telefone);


                $ar1  = array('{senha_cliente}','{nome_cliente}','{primeiro_nome_cliente}','{email_cliente}','{telefone_cliente}','{vencimento_cliente}','{plano_valor}','{data_atual}','{plano_nome}','{plano_link}');
                $ar2  = array($user->senha,$user->nome,explode(' ',$user->nome)[0],$user->email,$user->telefone,$user->vencimento,$plano->valor,date('d/m/Y'),$plano->nome,$link_plano);
                $text = str_replace($ar1,$ar2,$text_to);


                $link_z = 'https://api.whatsapp.com/send?phone='.$phone.'&text='.$text;

                echo json_encode(['erro' => false, 'link' => $link_z]);
                die;


            }else{
                echo json_encode(['erro' => true, 'msg' => 'Você já possui um lembrete na fila de envio. Aguarde alguns minutos para tentar enviar novamente.']);
                die;
            }

       }
     }else{
         echo json_encode(['erro' => true, 'msg' => 'A mensagem não pode ser vazia']);
         die;
     }
 }

?>
