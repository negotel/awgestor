<?php

  @session_start();
require_once "../config/settings.php";
  if(isset($_SESSION['SESSION_USER'])){

    if(isset($_POST['id'])){

      $id = trim($_POST['id']);

      require_once '../class/Conn.class.php';
      require_once '../class/Clientes.class.php';
      require_once '../class/Logs.class.php';

      $clientes = new Clientes();
      $logs     = new Logs();

      $busca_aviso = $clientes->busca_aviso($_SESSION['SESSION_USER']['id'],$id);

      if($busca_aviso || isset($_POST['add'])){

        if(isset($_POST['edite'])){

          $json  = new stdClass();
          $dados = json_decode($_POST['dados']);

          if($dados->titulo  != "" && $dados->texto != "" && $dados->auto_delete != "" && $dados->color != ""){

            $title = $dados->titulo;
            $dados->auto_delete = date('d/m/Y',  strtotime($dados->auto_delete));

            $update = $clientes->update_aviso($id,$dados);

            if($update){
              $logs->log($_SESSION['SESSION_USER']['id'],"Editou o aviso [ {$title} ]");
              $json->erro = false;
              $json->msg  = "Aviso editado com sucesso";
              echo json_encode($json);
            }else{
              $json->erro = true;
              $json->msg  = "Não conseguimos editar este aviso";
              echo json_encode($json);
            }

          }else{
            $json->erro = true;
            $json->msg  = "Existem campos vazios";
            echo json_encode($json);
          }

        }else if(isset($_POST['add'])){

          $json  = new stdClass();
          $dados = json_decode($_POST['dados']);

          if($dados->titulo  != "" && $dados->texto != "" && $dados->auto_delete != "" && $dados->color != ""){

            $title = $dados->titulo;
            $dados->id_user = $_SESSION['SESSION_USER']['id'];
            $dados->auto_delete = date('d/m/Y',  strtotime($dados->auto_delete));

            $add = $clientes->add_aviso($dados);

            if($add){
              $logs->log($_SESSION['SESSION_USER']['id'],"Adicionou um aviso [ {$title} ]");
              $json->erro = false;
              $json->msg  = "Aviso adicionado com sucesso";
              echo json_encode($json);
            }else{
              $json->erro = true;
              $json->msg  = "Não conseguimos adicionar este aviso";
              echo json_encode($json);
            }

          }else{
            $json->erro = true;
            $json->msg  = "Existem campos vazios";
            echo json_encode($json);
          }

        }else if(isset($_POST['remove'])){

          $json   = new stdClass();
          $title  = $busca_aviso->titulo;
          $remove = $clientes->del_aviso($id);

            if($remove){
              $logs->log($_SESSION['SESSION_USER']['id'],"Removeu o aviso [ {$title} ]");
              $json->erro = false;
              $json->msg  = "Aviso removido com sucesso";
              echo json_encode($json);
            }else{
              $json->erro = true;
              $json->msg  = "Não conseguimos remover este aviso";
              echo json_encode($json);
            }


        }else{

        $busca_aviso->auto_delete = date('Y-m-d',  strtotime(str_replace('/','-',$busca_aviso->auto_delete)));
        echo json_encode($busca_aviso);

      }

      }else{
        echo "Não encontramos este aviso.";
      }



    }


  }

?>
