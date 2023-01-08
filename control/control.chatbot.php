<?php

  @session_start();

  if(isset($_SESSION['SESSION_USER']) && isset($_POST)){

    require_once '../class/Conn.class.php';
    require_once '../class/User.class.php';
    require_once '../class/Gestor.class.php';
    require_once '../class/ChatBot.class.php';

    $user     = new User();
    $chatbot  = new ChatBot();
    $gestor   = new Gestor();


    $user_access = $user->dados($_SESSION['SESSION_USER']['id']);

    $plano_user = $gestor->plano($user_access->id_plano);

    if($plano_user->chatbot == 1){


        // init chatbot
        if(isset($_POST['init'])){
            if($chatbot->generateChave($user_access->id)){
                echo json_encode(['erro' => false, 'chatbot' => 'init']);
            }else{
                echo json_encode(['erro' => true, 'chatbot' => 'init']);
            }
        }


        if(isset($_POST['remove_istoric'])){
            $chat = $_POST['chat'];
            if($chatbot->remove_historic($chat,$_SESSION['SESSION_USER']['id'])){
                echo json_encode(['erro' => false, 'msg' => 'removido']);
                die;
            }else{
                echo json_encode(['erro' => true, 'msg' => 'nao removido']);
                die;
            }
        }


        // add_reply chatbot
        if(isset($_POST['add_reply'])){
            if(isset($_POST['dados'])){
                $dados = json_decode($_POST['dados']);


                if($dados->msg == ""){
                    echo json_encode(['erro' => true, 'msg' => 'Digite a mensagem recebida']);
                    die;
                }

                if($chatbot->add_reply($dados)){
                     echo json_encode(['erro' => false, 'msg' => 'Resposta adicionada']);
                     die;
                }else{
                     echo json_encode(['erro' => true, 'msg' => 'Erro ao adicionar resposta, entre em contato com o suporte']);
                     die;
                }
            }
        }

        // edit_reply chatbot
      if(isset($_POST['edit_reply'])){
          if(isset($_POST['dados'])){
              $dados = json_decode($_POST['dados']);


              if($dados->msg == ""){
                  echo json_encode(['erro' => true, 'msg' => 'Digite a mensagem recebida']);
                  die;
              }

              if($chatbot->edit_reply($dados)){
                   echo json_encode(['erro' => false, 'msg' => 'Resposta editata']);
                   die;
              }else{
                   echo json_encode(['erro' => true, 'msg' => 'Erro ao editar resposta, entre em contato com o suporte']);
                   die;
              }
          }
      }


      if(isset($_POST['remove_reply'])){

          $id = $_POST['id'];
          if($chatbot->remove_reply($id)){
              echo json_encode(['erro' => false, 'msg' => 'Resposta removida']);
              die;
          }else{
              echo json_encode(['erro' => true, 'msg' => 'Erro ao remover resposta, entre em contato com o suporte']);
              die;
          }

      }

    }






  }


?>
