<?php

 @session_start();

 if(isset($_SESSION['SESSION_USER'])){
     
      require_once '../class/Conn.class.php';
      require_once '../class/User.class.php';

      $user_class = new User();
     
      $user  = $user_class->dados($_SESSION['SESSION_USER']['id']);
      $moeda = $user_class->getmoeda($user->moeda);


   if(isset($_POST['save'])){

     $json = new stdClass();

     if(isset($_POST['dados'])){

         $dados = json_decode($_POST['dados']);

         if($dados->valor != "" && $dados->data != "" && $dados->hora != "" && $dados->nota != "" && $dados->tipo != ""){

         require_once '../class/Financeiro.class.php';
         require_once '../class/Logs.class.php';
        

         $financeiro = new Financeiro();
         $logs       = new Logs();
       
         $detalhe    = $financeiro->detalhe($dados->id);

         $dados->data  = date('d/m/Y',  strtotime($dados->data));

         if($detalhe->id_user == $_SESSION['SESSION_USER']['id']){

           $update = $financeiro->update($dados);

           if($update){

             if($detalhe->valor != $dados->valor){
               $con = "para ".$dados->valor;
             }else{
               $con = "";
             }

             $logs->log($_SESSION['SESSION_USER']['id'],"Alterou a movimentação de {$moeda->simbolo} {$detalhe->valor} {$con}, da data de {$detalhe->data}");

             $_SESSION['INFO'] = "Alterou a movimentação de {$moeda->simbolo} {$detalhe->valor} {$con}";

             $json->erro = false;
             $json->msg  = "Alterado com sucesso";
             echo json_encode($json);

           }else{

             if($detalhe->valor != $dados->valor){
               $con = "para ".$dados->valor;
             }else{
               $con = "";
             }

             $logs->log($_SESSION['SESSION_USER']['id'],"Tentou alterar a movimentação de {$moeda->simbolo} {$detalhe->valor} {$con}, da data de {$detalhe->data}");
             $_SESSION['INFO'] = "Tentou alterar a movimentação de {$moeda->simbolo} {$detalhe->valor} {$con}";

             $json->erro = true;
             $json->msg  = "Erro ao alterar movimentação";
             echo json_encode($json);

           }


         }else{

           $json->erro = true;
           $json->msg  = "Não pode editar uma mivimentação que não é sua.";
           echo json_encode($json);

         }
       }else{

         $json->erro = true;
         $json->msg  = "Preencha todos os campos";
         echo json_encode($json);

       }

     }else{

       $json->erro = true;
       $json->msg  = "Request is required";
       echo json_encode($json);

     }

   }

   if(isset($_POST['dados_edite'])){

     require_once '../class/Conn.class.php';
     require_once '../class/Financeiro.class.php';

     $financeiro = new Financeiro();

     $detalhe       = $financeiro->detalhe($_POST['id_mov']);

     if($detalhe){

       $explo_data    = explode('/',$detalhe->data);
       $detalhe->data = $explo_data[2].'-'.$explo_data[1].'-'.$explo_data[0];

       echo json_encode($detalhe);

     }else{
       echo "erro";
     }


   }


   if(isset($_POST['nota'])){

     require_once '../class/Conn.class.php';
     require_once '../class/Financeiro.class.php';

     $financeiro = new Financeiro();

     $detalhe = $financeiro->detalhe($_POST['id_mov']);

     if($detalhe){
       echo $detalhe->nota;
     }else{
       echo "erro";
     }

   }

   if(isset($_POST['del'])){

     require_once '../class/Conn.class.php';
     require_once '../class/Financeiro.class.php';
     require_once '../class/Logs.class.php';

     $financeiro = new Financeiro();
     $logs       = new Logs();

     $detalhe = $financeiro->detalhe($_POST['id_mov']);

     if($detalhe){

       if($detalhe->id_user == $_SESSION['SESSION_USER']['id']){

          $delete = $financeiro->delete($_POST['id_mov']);
          if($delete){
              $_SESSION['INFO'] = "Movimentação deletada com sucesso!";
              $logs->log($_SESSION['SESSION_USER']['id'],"Deletou uma movimentação de {$moeda->simbolo} {$detalhe->valor} da data de {$detalhe->data}");
              echo 'deletedo';
          }else{
            $_SESSION['INFO'] = "Erro ao deletar movimentação";
            $logs->log($_SESSION['SESSION_USER']['id'],"Tentou deletar uma movimentação de {$moeda->simbolo} {$detalhe->valor} da data de {$detalhe->data}");
            echo 'erro';
          }

       }else{
         $_SESSION['INFO'] = "Parece que está movimentação não pertence a você, por isso não pode deletar";
         $logs->log($_SESSION['SESSION_USER']['id'],"Tentou deletar uma movimentação de {$moeda->simbolo} {$detalhe->valor} da data de {$detalhe->data}");

       }

     }else{
       $_SESSION['INFO'] = "Parece que está movimentação já não existe mais.";
       echo "erro";
     }

   }

   if(isset($_POST['dados'])){


      $request = $_POST['dados'];

      require_once '../class/Conn.class.php';
      require_once '../class/Financeiro.class.php';

      $financeiro = new Financeiro();


      if($request == "mes_a_mes"){

        /*Buscar valores de todos os meses do ano atual*/
        $var_dados_carts_1 = "";

        $array_meses_charts_1 = [
          '01' => 0,
          '02' => 0,
          '03' => 0,
          '04' => 0,
          '05' => 0,
          '06' => 0,
          '07' => 0,
          '08' => 0,
          '09' => 0,
          '10' => 0,
          '11' => 0,
          '12' => 0
        ];

        $list = $financeiro->charts($_SESSION['SESSION_USER']['id']);

        if($list){

          while ($mov = $list->fetch(PDO::FETCH_OBJ)) {

            $data_explode = explode('/',$mov->data);

            if($data_explode[2] == date('Y')){

              $valor = $financeiro->convertMoney(1,$mov->valor);
              $mes   = $data_explode[1];
              $v1    = $array_meses_charts_1[$mes];

              $vl_final = $valor+$v1;
              $array_meses_charts_1[$mes] = $vl_final;

            }

          }

          $dado_return = "";

          foreach ($array_meses_charts_1 as $key => $value) {
            $dado_return .= $value.',';
          }

          echo rtrim($dado_return,',');

        }

      }else if($request == "seven_dias"){

        /*Buscar valores dos ultimos 7 dias*/
        $var_dados_carts_2 = $financeiro->array_seven_days();
        $var_dados_carts_2_sem = $financeiro->array_seven_days_sem();

        $sem = array();


        $list = $financeiro->seven_mov($_SESSION['SESSION_USER']['id']);

        if($list){

          $return = "";

          while ($mov = $list->fetch(PDO::FETCH_OBJ)) {

            $data_explode = explode('/',$mov->data);

            $valor = $financeiro->convertMoney(1,$mov->valor);
            $dia   = $data_explode[0];
            $v1    = $var_dados_carts_2[$dia];

            $vl_final = $valor+$v1;
            $var_dados_carts_2[$dia] = $vl_final;
            $sem[$dia] = explode('/',$mov->data)[0];

          }

          $dado_return  = "";
          $dado_return2 = "";

          foreach ($var_dados_carts_2 as $key => $value) {
            $dado_return  .= $value.',';
            $dado_return2 .= $var_dados_carts_2_sem[$key].',';
          }

          $valores = rtrim($dado_return,',');
          $dias_r  = rtrim($dado_return2,',');

          echo $valores.'|'.$dias_r;


        }

      }else if($request == "ultima_decada"){

        echo $financeiro->dados_decada($_SESSION['SESSION_USER']['id']);

      }else if($request == "mes_a_mes_gastos"){

        /*Buscar valores de todos os meses do ano atual*/
        $var_dados_carts_1 = "";

        $array_meses_charts_1 = [
          '01' => 0,
          '02' => 0,
          '03' => 0,
          '04' => 0,
          '05' => 0,
          '06' => 0,
          '07' => 0,
          '08' => 0,
          '09' => 0,
          '10' => 0,
          '11' => 0,
          '12' => 0
        ];

        $list = $financeiro->charts_g($_SESSION['SESSION_USER']['id']);

        if($list){

          while ($mov = $list->fetch(PDO::FETCH_OBJ)) {

            $data_explode = explode('/',$mov->data);

            if($data_explode[2] == date('Y')){

              $valor = $financeiro->convertMoney(1,$mov->valor);
              $mes   = $data_explode[1];
              $v1    = $array_meses_charts_1[$mes];

              $vl_final = $valor+$v1;
              $array_meses_charts_1[$mes] = $vl_final;

            }

          }

          $dado_return = "";

          foreach ($array_meses_charts_1 as $key => $value) {
            $dado_return .= $value.',';
          }

          echo rtrim($dado_return,',');

        }

      }

    }
  }




?>
