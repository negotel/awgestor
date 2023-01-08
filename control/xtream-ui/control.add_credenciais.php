<?php 


 @session_start();

  if(isset($_SESSION['SESSION_USER'])){
      
      
      $return = new stdClass();
      
      require_once '../../class/Conn.class.php';
      require_once '../../class/User.class.php';
      require_once '../../class/ApiPainel.class.php';
      require_once '../../class/Gestor.class.php';
      
      $conn = new Conn();
      $pdo = $conn->pdo();
      
     
      $user   = new User();
      $apiPainel = new ApiPainel(); 
      $gestor = new Gestor();
      
      
      $dados_u  = $user->dados($_SESSION['SESSION_USER']['id']);
      $planoGes = $gestor->plano($dados_u->id_plano);
      
      if(isset($_POST['info_painel'])){
          
          $info = $apiPainel->info_credenciais($_POST['id'],$_SESSION['SESSION_USER']['id']);
          if($info){
              echo json_encode($info);
          }else{
              echo '0';
          }
          
      }else if(isset($_POST['remove'])){
          
          $apiPainel->remove_credenciais($_POST['id'],$_SESSION['SESSION_USER']['id']);
          
          
      }else if (isset($_POST['dados'])){
      
      $json     = json_decode($_POST['dados']);
      
      if($json){
          
          if($json->username == "" || $json->password == "" || $json->cms == "" || $json->painel == ""){
             

                  $return->erro = true;
                  $return->msg = "Preencha todos os campos";
                  echo json_encode($return);
                  die; 
              
              
          }else{
              
              
              if($json->username == ""){
                  
                  $return->erro = true;
                  $return->msg = "Informe um usuario";
                  echo json_encode($return);
                  die; 
              }
              
             if($json->password == ""){
                  
                  $return->erro = true;
                  $return->msg = "Informe uma senha";
                  echo json_encode($return);
                  die; 
              }
              
               if($json->cms == ""){
                  
                  $return->erro = true;
                  $return->msg = "Informe uma cms";
                  echo json_encode($return);
                  die; 
              }
              
               if($json->painel == ""){
                  
                  $return->erro = true;
                  $return->msg = "Informe o painel";
                  echo json_encode($return);
                  die; 
              }


              
              $dados = new stdClass();
              $dados->chave         = $json->chave == "null" ? md5(microtime(true)) : $json->chave;
              $dados->cms           = trim($json->cms);
              $dados->nome          = trim($json->nome);
              $dados->username      = trim($json->username);
              $dados->password      = trim($json->password);
              $dados->id_user       = $_SESSION['SESSION_USER']['id'];
              $dados->limit_testes  = $planoGes->limit_teste;
              $dados->situ_teste    = $json->situ_teste;
              $dados->receber_aviso = $json->receber_aviso;
              $dados->api           = trim($json->painel);
              $dados->cloud         = trim($json->cloud);
    
              
              // verific dados api
              $credenciais_painel = $apiPainel->verific_chave($dados->chave);
              
              if($credenciais_painel){
                  
                  $dados->id = $credenciais_painel->id;
                  
                  // update dados api
                  $update_dados = $apiPainel->update_credencial($dados);
                  
                 if($update_dados){
                      $return->erro = false;
                      $return->msg = "Credencial atualizada";
                      echo json_encode($return);
                      die;
                  }else{
                      $return->erro = true;
                      $return->msg = "Desculpe, erro ao alterar as credenciais, entre em contato com o suporte";
                      echo json_encode($return);
                      die;
                  }
                  
              }else{
                  // add dados api
                  $insert_dados = $apiPainel->insert_credencial($dados);

                  if($insert_dados){
                      $return->erro = false;
                      $return->msg = "Novas credenciais adicionadas";
                      echo json_encode($return);
                      die;
                  }else{
                      $return->erro = true;
                      $return->msg = "Desculpe, erro ao adicionar as credenciais, entre em contato com o suporte";
                      echo json_encode($return);
                      die;
                  }
                  
              }
          }
          
      }else{
          $return->erro = true;
          $return->msg = "Request is required JSON";
          echo json_encode($return);
          die;
      }
      
    }
      
  }



?>