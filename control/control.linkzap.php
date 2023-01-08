<?php

  @session_start();

  $json = new stdClass();

  if(isset($_SESSION['SESSION_USER'])){


    if(isset($_POST['type'])){

      $type = $_POST['type'];

      require_once '../class/Conn.class.php';
      require_once '../class/Gestor.class.php';
      require_once '../class/Planos.class.php';
      require_once '../class/User.class.php';
      require_once '../class/Logs.class.php';
      require_once '../class/Linkzap.class.php';

      $gestor     = new Gestor();
      $planos     = new Planos();
      $user       = new User();
      $linkzap    = new Linkzap();
      $logs       = new Logs();
      $dados_user = $user->dados($_SESSION['SESSION_USER']['id']);
      $plano_user = $gestor->plano($dados_user->id_plano);


        if($type == "verific_slug"){
            
            $slug = trim($_POST['slug']);
            if($linkzap->get_slug_link($slug,false)){
                echo json_encode(['erro' => true, 'msg' => 'Já existe um link com este apelido']);
            }else{
                echo json_encode(['erro' => false, 'msg' => 'valido']);
            }
            
        }else if($type == "add"){
            
            if(isset($_POST['dados'])){
                
                
                $dados = json_decode($_POST['dados']);
                
                if($dados->nome != "" && $dados->numero != "" && $dados->msg != "" && $dados->slug != ""){
                    
                    $dados->id_user = $dados_user->id;
                    
                       if($linkzap->get_slug_link($dados->slug,false)){
                            echo json_encode(['erro' => true, 'msg' => 'Já existe um link com este apelido']);
                            die;
                        }
                        
                    
                    if(strlen($dados->slug) < 6){
                         echo json_encode(['erro' => true, 'msg' => 'Apelido deve conter no minimo 6 caracteres']);
                         die;
                    }    
    
                    if($linkzap->insert_link($dados,$plano_user->limit_link_zap)){
                         echo json_encode(['erro' => false, 'msg' => 'Link criado']);
                    }else{
                        echo json_encode(['erro' => true, 'msg' => 'O seu plano atual não permite criar mais links']);
                    }


                }else{
                    echo json_encode(['erro' => true, 'msg' => 'Preencha todos os campos']);
                }
                
            }
            
        }else if($type == "dados"){
            
            $id = trim($_POST['id']);
            
            $getDados = $linkzap->get_link_by_id($id);
            
            if($getDados){
                echo json_encode($getDados);
            }else{
                echo json_encode(['erro' => true, 'msg' => 'Link não encontrado']);
            }
        }else if($type == 'edite'){
            
            if(isset($_POST['dados'])){
                
                $dados = json_decode($_POST['dados']);
                
                if($dados->nome != "" && $dados->numero != "" && $dados->msg != "" && $dados->slug != "" && $dados->id != ""){
                    
                    $slugH = $dados->slugh;
                    
                    if($slugH != $dados->slug){
                        
                        if($linkzap->get_slug_link($dados->slug,false)){
                            echo json_encode(['erro' => true, 'msg' => 'Já existe um link com este apelido']);
                            die;
                        }
                    }
                    
                    if(strlen($dados->slug) < 6){
                         echo json_encode(['erro' => true, 'msg' => 'Apelido deve conter no minimo 6 caracteres']);
                         die;
                    }  

                    if($linkzap->update_link($dados)){
                         echo json_encode(['erro' => false, 'msg' => 'Link Atualizado']);
                    }else{
                        echo json_encode(['erro' => true, 'msg' => 'Erro ao atualizar link']);
                    }


                }else{
                    echo json_encode(['erro' => true, 'msg' => 'Preencha todos os campos']);
                }
                
            }
            
        }else if($type == "delete"){
            
            $id = trim($_POST['id']);
            
            $getDados = $linkzap->get_link_by_id($id);
            
            if($getDados->id_user == $_SESSION['SESSION_USER']['id']){
                
                if($linkzap->remove_link($id)){
                     echo json_encode(['erro' => false, 'msg' => 'Link removido']);
                }else{
                    echo json_encode(['erro' => true, 'msg' => 'Erro ao remover link']);
                }
                
            }else{
                echo json_encode(['erro' => true, 'msg' => 'Não autorizado']);
            }
            
        }
        

    }else{
      $json->erro = true;
      $json->msg  = "Request is required";
      echo json_encode($json);
    }

  }else{
    $json->erro = true;
    $json->msg  = "403";
    echo json_encode($json);
  }

?>
