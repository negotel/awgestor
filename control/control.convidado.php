<?php

  @session_start();

  if(isset($_SESSION['SESSION_USER']) && isset($_POST)){

    require_once '../class/Conn.class.php';
    require_once '../class/User.class.php';

    $user    = new User();

    if(isset($_POST['add_cvd'])){

        $dados    = json_decode($_POST['dados']);


        if($dados){

          if($dados->nome != "" && $dados->email != "" && $dados->senha != "" ){


            if($user->verific_email($dados->email)){
              echo '{"erro":true,"msg":"Email não disponível"}';
              die;
            }

            if(!isset(explode(' ',$dados->nome)[1])){
              echo '{"erro":true,"msg":"Eu preciso do sobrenome também! :)"}';
              die;
            }else if(explode(' ',$dados->nome)[1] == ""){
              echo '{"erro":true,"msg":"Eu preciso do sobrenome também! :)"}';
              die;
            }

            if(strlen($dados->senha)<5 || $dados->senha == "123456" || $dados->senha == "abcdefgh" || $dados->senha == $dados->email){
              echo '{"erro":true,"msg":"Pois é meu jovem, essa senha é muito fraca!"}';
              die;
            }


             if($user->add_cvd($dados,$_SESSION['SESSION_USER']['id'])){
               echo '{"erro":false,"msg":"Criado"}';
               die;
             }

          }else{
            echo '{"erro":true,"msg":"Por obséquio, preencha todos os campos."}';
            die;
          }

        }else{
          echo '{"erro":true,"msg":"Epa! Deu ruim."}';
          die;
        }

    }else if(isset($_POST['delete_cvd'])){
        
        $id_cvd = $_POST['id_cvd'];
        $cvd = $user->dados_cvd($id_cvd);
        
        if($cvd){
        
            if($cvd->id_user == $_SESSION['SESSION_USER']['id']){
                
                if($user->delete_cvd($id_cvd)){
                   echo '{"erro":false,"msg":"Deletado"}';
                   die;
                 }else{
                      echo '{"erro":true,"msg":"Epa! Deu ruim."}';
                      die;
                }
            }else{
                echo '{"erro":true,"msg":"Epa! Deu ruim."}';
                die; 
            }
        
        }else{
           echo '{"erro":true,"msg":"Epa! Deu ruim."}';
           die;
        }
    }


  }


?>
