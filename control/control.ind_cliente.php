<?php

  @session_start();

  $json = new stdClass();

  if(isset($_SESSION['SESSION_USER'])){


      
      if(isset($_POST['amostra_plans'])){
          
        require_once '../class/Conn.class.php';
        require_once '../class/Clientes.class.php';

        $clientes_class = new Clientes();
        
        $amostra_planos = $_POST['amostra_planos'];
              
          if($clientes_class->update_amostra_plans_painel($_SESSION['SESSION_USER']['id'],$amostra_planos)){
                
                $json->erro = false;
                $json->msg  = "Alterado com sucesso";
                echo json_encode($json);
                
            }else{
                
                $json->erro = true;
                $json->msg  = "Erro, tente mais tarde";
                echo json_encode($json);
                
            }
        
        die;
      }


    if(isset($_POST['dados'])){
        

       $dados = json_decode($_POST['dados']);


      if($dados->status != "" && $dados->qtd != "" && $dados->meses != "" && $dados->msg != ""){

        require_once '../class/Conn.class.php';
        require_once '../class/Clientes.class.php';

        $clientes_class = new Clientes();

        $area_cli_conf  = $clientes_class->area_cli_conf($_SESSION['SESSION_USER']['id']);
        $dados->msg = base64_encode($dados->msg);
        
        if($clientes_class->update_indicacao_painel($_SESSION['SESSION_USER']['id'],json_encode($dados))){
            
            $json->erro = false;
            $json->msg  = "Alterado com sucesso";
            echo json_encode($json);
            
        }else{
            
            $json->erro = true;
            $json->msg  = "Erro, tente mais tarde";
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


  }else{

    $json->erro = true;
    $json->msg  = "Nao autorizado";
    echo json_encode($json);

  }




?>
