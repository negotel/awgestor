<?php

  @session_start();
require_once "../config/settings.php";
  if(isset($_SESSION['SESSION_USER'])){

    if(isset($_POST)){

      require_once '../class/Conn.class.php';
      require_once '../class/Arquivos.class.php';
      require_once '../class/Clientes.class.php';
      require_once '../class/Logs.class.php';

      $arquivos = new Arquivos();
      $clientes = new Clientes();
      $logs     = new Logs();

      $logo_atual = $_POST['logo_atual'];

      $ext_perm = array('png');

      if(isset($_FILES['logo_area'])){
        if($_FILES['logo_area']['name'] != ""){
          $up = json_decode($arquivos->upload($_FILES['logo_area'],true,"../cliente/logo/",$ext_perm));
          if($up->erro == false){

            if(is_file("../cliente/logo/".$logo_atual) && $logo_atual != "none_area_cliente.png"){
              unlink("../cliente/logo/".$logo_atual);
            }

            $logo = $up->nome;
          }else{
            $_SESSION['INFO'] =  $up->msg;
            echo '<script>location.href="../painel/painel_cliente_conf";</script>';
            die;
          }
        }else{
          $logo = $logo_atual;
        }
      }else{
        $logo = $logo_atual;
      }

      if($_POST['nome_area'] != "" && $_POST['slug_area'] != "" && $_POST['situ_area'] != "" ){

        if($_POST['slug_area'] != $_POST['slug_atual']){
          if($clientes->area_cli_dados($_POST['slug_area'])){
            $_SESSION['INFO'] = "Este caminho de painel ja está em uso";
            echo '<script>location.href="../painel/painel_cliente_conf";</script>';
            die;
          }
        }

          $update = $clientes->update_area_cli($_POST,$logo);

          if($update){

            $logs->log($_SESSION['SESSION_USER']['id'],'Alterou a área do cliente');
            $_SESSION['INFO'] = "Painel cliente alterado com sucesso";
            echo '<script>location.href="../painel/painel_cliente_conf";</script>';
            die;
          }else{
            $_SESSION['INFO'] = "Erro ao alterar painel cliente";
            echo '<script>location.href="../painel/painel_cliente_conf";</script>';
            die;
          }


      }else{
        $_SESSION['INFO'] = "Preencha todos os campos";
        echo '<script>location.href="../painel/painel_cliente_conf";</script>';
        die;
      }

    }else{
      echo 'REQUEST IS REQUIRED';
      die;
    }

}







?>
