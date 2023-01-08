<?php
  @session_start();
  
   header("Access-Control-Allow-Origin: *");

    $json  = new stdClass();

    if(isset($_POST['dados'])){

      $dados = json_decode($_POST['dados']);

      require_once '../class/Conn.class.php';
      require_once '../class/Clientes.class.php';

      $clientes = new Clientes();

      if($dados->nome != "" && $dados->email != ""){

        if(filter_var($dados->email, FILTER_VALIDATE_EMAIL)){

          if($dados->email != $_SESSION['SESSION_CLIENTE']['email']){
            if($clientes->verific_email($dados->email) == false){
              $json->erro = true;
              $json->msg  = "Este email ja está sendo usado em nossa base de dados, tente outro";
              echo json_encode($json);
            }
          }

           $dados->senha    = $dados->senha == "none" ? $_SESSION['SESSION_CLIENTE']['senha'] : $dados->senha;
           $dados->id       = $_SESSION['SESSION_CLIENTE']['id'];
           $dados->telefone = $_SESSION['SESSION_CLIENTE']['telefone'];

           $update = $clientes->update_simple($dados);

           if($update){

             $_SESSION['SESSION_CLIENTE']['nome']  = $dados->nome;
             $_SESSION['SESSION_CLIENTE']['email'] = $dados->email;
             $_SESSION['SESSION_CLIENTE']['senha'] = $dados->senha;

             $json->erro = false;
             $json->msg  = "Dados alterados com sucesso";
             echo json_encode($json);
           }else{
             $json->erro = true;
             $json->msg  = "Erro ao alterar seus dados, entre em contato com o suporte";
             echo json_encode($json);
           }




        }else{
          $json->erro = true;
          $json->msg  = "Que email esquisito, tente outro";
          echo json_encode($json);
        }

      }else{
        $json->erro = true;
        $json->msg  = "Acho que você esqueceu de preencher alguns campos ai";
        echo json_encode($json);
      }

    }else{
      $json->erro = true;
      $json->msg  = "Request is required";
      echo json_encode($json);
    }



?>
