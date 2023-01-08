<?php

  @session_start();

  if(isset($_SESSION['SESSION_USER']) && isset($_POST)){

    require_once '../class/Conn.class.php';
    require_once '../class/User.class.php';
    require_once '../class/Gestor.class.php';
    require_once '../class/Revenda.class.php';

    $user    = new User();
    $gestor  = new Gestor();
    $revenda = new Revenda();

    if(isset($_POST['calc'])){

        $plano    = $_POST['id_plano'];
        $validade = $_POST['vencimento'];

        $dados_p = $gestor->plano($plano);

        if($dados_p){

          $cred = $dados_p->creditos;
          $creditos = ($cred*$validade);

          echo '{"erro":false,"creditos":'.$creditos.'}';

        }else{

          echo '{"erro":true,"msg":"Plano não localizado"}';

        }


    }






  }


?>
