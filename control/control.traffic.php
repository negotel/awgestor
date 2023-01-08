<?php

  @session_start();

  $json = new stdClass();

  if(isset($_SESSION['SESSION_USER'])){

    if(isset($_POST['dados'])){
        
      $url_components = parse_url($_POST['dados']); 
      parse_str($url_components['path'], $params); 
      $dados = (object)$params;
 


      if($dados->url_traffic != "" && $dados->type_link != "" && $dados->qtd_acessos != "" && $dados->porcent_plataform_desktop != "" && $dados->porcent_plataform_mobile != ""){

        require_once '../class/Conn.class.php';
        require_once '../class/Traffic.class.php';
        require_once '../class/User.class.php';
        require_once '../class/Whatsapi.class.php';

        $traffic  = new Traffic();
        $user     = new User();
        $whatsapi = new Whatsapi();

        $dados_user = $user->dados($_SESSION['SESSION_USER']['id']);

        if($dados_user->id_plano != 7){
            echo json_encode(['erro' => true, 'msg' => 'Seu plano não permite está função. Faça Upgrade']);
            die;
        }

        // planos acessos 
        $planoAcesso[1] = 500;
        $planoAcesso[2] = 1000;
        
        if(!isset($planoAcesso[$dados->qtd_acessos])){
             echo json_encode(['erro' => true, 'msg' => 'Informe a quantidade de acessos ao link']);
            die;
        }
        
        $url = $dados->url_traffic;
        
        if(!filter_var($url, FILTER_VALIDATE_URL)) {
             echo json_encode(['erro' => true, 'msg' => 'Informe um link válido com "http://" ou "https://" sem www ']);
             die;
        } 
        
        $keyW = NULL;
        if($dados->deseja_key_words == 'sim'){
            $keyW = $dados->key_words;
        }
        
        $origem_link = NULL;
        if($dados->deseja_origem == 'sim'){
            $origem_link = $dados->origem_link;
        }
        
        $percent_mobi = (100 - $dados->porcent_plataform_desktop);
        if($percent_mobi < 0 || $percent_mobi > 100){
            echo json_encode(['erro' => true, 'msg' => 'Informe uma porcentagem até 100']);
            die;
        }
       
        
        
        
        // form array object add
        $dadosAdd = new stdClass();
        $dadosAdd->id_user = $_SESSION['SESSION_USER']['id'];
        $dadosAdd->link    = $url;
        $dadosAdd->tipo_link = $dados->type_link;
        $dadosAdd->origem = $origem_link;
        $dadosAdd->keywords = $keyW;
        $dadosAdd->status = "Processando";
        $dadosAdd->qtd_acesso = $planoAcesso[$dados->qtd_acessos];
        $dadosAdd->percent_desktop = $dados->porcent_plataform_desktop;
        $dadosAdd->percent_mobile = $dados->porcent_plataform_mobile;
        $dadosAdd->data = date('d/m/Y');
        $dadosAdd->pais = $dados->pais;
        
        
        
        if($traffic->add_traffic($dadosAdd)){
            
            $whatsapi->fila('553192393620',"Olá Marcos. \n\nHouve mais uma solicitação de tráfego. Acesse /system e confira.\nMarque como entregue quando os acessos forem atingidos.",'156','gestorbot','gestorbot','0000','0000',"0000");
            $whatsapi->fila('554598339113',"Olá Luan. \n\nHouve mais uma solicitação de tráfego. Acesse /system e confira.\nMarque como entregue quando os acessos forem atingidos.",'156','gestorbot','gestorbot','0000','0000',"0000");

            echo json_encode(['erro' => false, 'msg' => 'Sua solicitação foi enviada e já foi recebida.']);
            die;
            
            
        }else{
             echo json_encode(['erro' => true, 'msg' => 'Desculpe, no momento você não pode enviar mais solicitações, talvez você já tenha feito sua solicitação hoje.']);
             die;
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
