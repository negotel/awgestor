<?php

  set_time_limit(30000);

  require_once 'autoload.php';
  
  $user_class = new User();
  $gestor_class = new Gestor();
  $faturas_class = new Faturas();
  $whatsapi_class = new Whatsapi();
  $financeiro_class = new Financeiro();

  $daqui_5_days = date('d/m/Y', strtotime('+5 days', strtotime(date('d-m-Y'))));

  $list_users = $user_class->list_5_days($daqui_5_days);

  if($list_users){

      while ($user = $list_users->fetch(PDO::FETCH_OBJ)) {
          
        $moeda       = $financeiro_class->getmoeda($user->moeda);

        $plano      = $gestor_class->plano($user->id_plano);
        $create_fat = $faturas_class->create($plano,$user,@$moeda->nome);
        $tema       = $whatsapi_class->get_template('faturas');

        if($tema){

          $ar1  = array('{vencimento}','{valor}','{primeiro_nome}','{plano_nome}');
          $ar2  = array($daqui_5_days,$plano->valor,explode(' ',$user->nome)[0],$plano->nome);
          $text = str_replace($ar1,$ar2,$tema->texto);

          $ar1   = array('+',')','(',' ','-');
          $ar2   = array('','','','','');
          $phone = $user->ddi.str_replace($ar1,$ar2,$user->telefone);

          $whatsapi_class->fila($phone,$text,$user->id,'gestorbot','gestorbot','0000','0000',"vencimento_user");

        }


      }
  }

?>
