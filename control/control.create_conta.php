<?php

  @session_start();

  $json = new stdClass();
  $teste_free = true;

  if(isset($_POST['dados'])){

    $dados = json_decode($_POST['dados']);

    if($dados->nome != "" && $dados->telefone != "" && $dados->email != "" && $dados->senha != "" && $dados->ddi != ""){

      require_once '../class/Conn.class.php';
      require_once '../class/User.class.php';
      require_once '../class/Login.class.php';
      require_once '../class/Gestor.class.php';
      require_once '../class/Faturas.class.php';

      $user = new User();
      $login = new Login();
      $gestor = new Gestor();
      $faturas = new Faturas();

      $nome_explo = explode(' ',trim($dados->nome));

      if(!isset($nome_explo[1])){

        $json->erro = true;
        $json->type = 0;
        $json->msg  = "Adicione um sobrenome";
        echo json_encode($json);
        die;

      }

      if($user->verific_email($dados->email)){
        $json->erro = true;
        $json->type = 1;
        $json->msg  = "Este email já esta em uso em nosso sistema, faça login";
        echo json_encode($json);
        die;
      }



      if(strlen($dados->senha)<5 || $dados->senha == "123456"){
        $json->erro = true;
        $json->type = 0;
        $json->msg  = "Senha muito fraca";
        echo json_encode($json);
        die;
      }

      $ar_str1 = array(')','(',' ','-','.');
      $ar_str2 = array('','','','','');

      $dados->telefone = str_replace($ar_str1,$ar_str2,$dados->telefone);
      $id_rev = 0;
      $af = 0;
      $indicado = 0;
     // $indicado = isset($_SESSION['afiliado']) ? $_SESSION['afiliado'] : 0;
      
      if(isset($_SESSION['af'])){
         $af = $_SESSION['af'];
      }
      
      if(isset($_SESSION['afiliado'])){
         $indicado = $_SESSION['afiliado'];
      }
      
      if($user->create($dados,'00/00/0000',0,$id_rev,$indicado,$af)){


        $request['email'] = $dados->email;
        $request['pass']  = $dados->senha;

        $logg   = $login->login($request);
        $return = json_decode($logg);

        if($return->erro){

          $json->erro = true;
          $json->type = 1;
          $json->msg  = "Conta criada, agora faça login";
          echo json_encode($json);

        }else{

          if($user->verific_pre_cadastro($dados->email)){

             $idU     = $return->id;
             $idPlano = 6;

             $timestamp      = strtotime('+1 months',strtotime(date('d-m-Y')));
             $novoVencimento = date('d/m/Y', $timestamp);

             $plano  = $gestor->plano($idPlano);
             $fatura = $faturas->create($plano,$return,"Aprovado","Pré cadastro");

             if($fatura != false){
                //update vencimento
                $user->update_vencimento($novoVencimento,$idU,$idPlano);

                $_SESSION['pre_cadastro'] = true;
             }

          }
          
          if($teste_free){
              
              
             $idU     = $return->id;
             $idPlano = 6;

             $timestamp      = strtotime('+5 days',strtotime(date('d-m-Y')));
             $novoVencimento = date('d/m/Y', $timestamp);

             $plano  = $gestor->plano($idPlano);
             $fatura = $faturas->create($plano,$return,"Aprovado","Teste Grátis");

             if($fatura != false){
                //update vencimento
                $user->update_vencimento($novoVencimento,$idU,$idPlano);

                $_SESSION['pre_cadastro'] = true;
             } 
              
          }


          $_SESSION['PLANO_SELECT'] = true;

          $json->erro = false;
          $json->type = 0;
          $json->msg  = "Conta criada, e login efetuado.";
          echo json_encode($json);

        }

      }else{

        $json->erro = true;
        $json->type = 0;
        $json->msg  = "Erro ao criar conta, entre em contato com o suporte.";
        echo json_encode($json);

      }

    }else{

      $json->erro = true;
      $json->type = 0;
      $json->msg  = "Preencha todos os campos, por gentileza";
      echo json_encode($json);
    }

  }

?>
