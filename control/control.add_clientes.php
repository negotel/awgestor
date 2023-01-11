<?php

  @session_start();
require_once "../config/settings.php";
  $json = new stdClass();

  if(isset($_SESSION['SESSION_USER'])){

    if(isset($_POST['dados'])){

        $dados = json_decode($_POST['dados']);

      if($dados->nome != "" && $dados->vencimento != "" && $dados->telefone != "" && $dados->notas != "" && $dados->id_plano != ""){

        require_once '../class/Conn.class.php';
        require_once '../class/Clientes.class.php';
        require_once '../class/User.class.php';
        require_once '../class/Logs.class.php';

        $clientes = new Clientes();
        $user     = new User();
        $logs     = new Logs();

        $dados_user = $user->dados($_SESSION['SESSION_USER']['id']);

        $limit = $user->limit_plano($dados_user->id_plano);

        $dados->limit_plano = $limit;
        $dados->id_user     = $_SESSION['SESSION_USER']['id'];
        $dados->vencimento  = date('d/m/Y',  strtotime($dados->vencimento));
        
        $explode        = explode('/',$dados->vencimento);
        $totime         = $explode[2].$explode[1].$explode[0];
        $dados->totime  = $totime;
    
    
        
          if(strlen($dados->telefone) < 10){
                echo json_encode(['erro' => true, 'msg' => 'Telefone incorreto']);
                die;
            }
        
        if(isset($dados->email)){
            if($dados->email != ""){
                if($clientes->verific_email($dados->email)){
                    $dados->email = $dados->email;
                }else{
                    $json->erro = true;
                    $json->msg  = "Um cliente com este mesmo email foi encontrado.";
                    echo json_encode($json);
                }
                
            }else{
                $dados->email = "";
            }
        }else{
            $dados->email = "";
        }        
        
        
      if(!isset($dados->categoria)){
            echo json_encode(array(['erro' => true, 'msg' => 'Selecione uma categoria']));
            die;
        }else{
            if($dados->categoria == "" || $dados->categoria == 'Selecionar uma categoria' || $dados->categoria == 'Nenhuma categoria cadastrada'){
                echo json_encode(array(['erro' => true, 'msg' => 'Selecione uma categoria']));
                die;
            }
        }
        

        $inser = $clientes->insert($dados);

        if($inser == '1' ){

          $_SESSION['INFO'] = '<span><i class="text-success fa fa-check" ></i> Cliente <b>'.$dados->nome.'</b> cadastrado com sucesso!</span>';

          $logs->log($_SESSION['SESSION_USER']['id'],"Cadastrou um novo cliente. [ {$dados->nome} ] ");

          $json->erro = false;
          $json->msg  = "cadastrado";
          echo json_encode($json);

        }else{
          if($inser == "limit"){

            $json->erro = true;
            $json->msg  = "Seu plano não permite cadastrar  mais clientes";
            echo json_encode($json);

          }else{

            $json->erro = false;
            $json->msg  = "Falha ao cadastrar";
            echo json_encode($json);

          }

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


  }else{

    $json->erro = true;
    $json->msg  = "Não autorizado";
    echo json_encode($json);

  }




?>
