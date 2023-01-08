<?php

  @session_start();

  $json = new stdClass();

  if(isset($_SESSION['SESSION_USER'])){

    if(isset($_POST['dados'])){
        
      $url_components = parse_url($_POST['dados']); 
      parse_str($url_components['path'], $params); 
      $dados = (object)$params;
 


      if($dados->color != "" && $dados->imagens != "" && $dados->altura != "" && $dados->largura != ""){

        require_once '../class/Conn.class.php';
        require_once '../class/Flyer.class.php';
        require_once '../class/User.class.php';
        require_once '../class/Whatsapi.class.php';

        $flyer    = new Flyer();
        $user     = new User();
        $whatsapi = new Whatsapi();

        $dados_user = $user->dados($_SESSION['SESSION_USER']['id']);

        if($dados_user->id_plano != 7){
            echo json_encode(['erro' => true, 'msg' => 'Seu plano não permite está função. Faça Upgrade']);
            die;
        }
        
        $cores = $dados->color;
        
        $cor = "";
        
        foreach ($cores as $color){ 
            $cor .= $color.',';
        }
        
        $cor = rtrim($cor, ',');

        
        $frist_name = explode(' ',$dados_user->nome)[0];
        
        $informacoes = "";
        
        if(isset($dados->surpreender)){
            if($dados->surpreender == 1){
                $informacoes .= "{$frist_name} deseja ser Surpreendido! <br /><br /><hr>";
            }
        }
        
        $informacoes .= "<b>Dimensões</b><br />Altura: {$dados->altura} <br /> Largura: {$dados->largura}<br /><br /><hr>";
        
        
        if(isset($dados->modelo_exemplo)){
            if($dados->modelo_exemplo == 1){
                $informacoes .= "<b>Modelo de exemplo</b><br /> {$dados->modelo_exemplo}<br /><br /><hr>";
            }
        }
        
        
        if(isset($dados->flat_design)){
            if($dados->flat_design == 'Sim'){
                $informacoes .= "<b>Flat Design</b><br />  Sim, com flat design<br /><br /><hr>";
            }
        }
        
         if(isset($dados->comments_color)){
            if($dados->comments_color != ''){
                $informacoes .= "<b>Comentários sobre as cores</b><br /> {$dados->comments_color}<br /><br /><hr>";
            }
        }
        
        
        $informacoes .= "<b>Informação dita pelo cliente</b><br /> {$dados->informacoes}<hr>";
        
        
        
        // form array object add
        $dadosAdd = new stdClass();
        $dadosAdd->id_user = $_SESSION['SESSION_USER']['id'];
        $dadosAdd->cores_principal    = $cor;
        $dadosAdd->type = $dados->type;
        $dadosAdd->prazo  = 10;
        $dadosAdd->valor = '0,00';
        $dadosAdd->free = 1;
        $dadosAdd->modelo_exemplo = $dados->modelo_exemplo;
        $dadosAdd->logo = $dados->logo;
        $dadosAdd->data = date('d/m/Y');
        $dadosAdd->mes  = date('m');
        $dadosAdd->ano  = date('Y');
        $dadosAdd->informacoes = $informacoes;
        $dadosAdd->imagens = str_replace(',','<br /><br />',$dados->imagens);
        $dadosAdd->status = 'Pendente';
        $dadosAdd->info_adm = '';


        if($flyer->add_flyer($dadosAdd)){
            
            $whatsapi->fila('554598339113',"*Solicitação para criar Banner* \n\nOlá Luan. \n\nHouve mais uma solicitação de criação de banner. Acesse /system e confira.\nMarque como entregue quando os acessos forem atingidos.",'156','gestorbot','gestorbot','0000','0000',"0000");

            echo json_encode(['erro' => false, 'msg' => 'Sua solicitação foi enviada e já foi recebida.']);
            die;
            
            
        }else{
             echo json_encode(['erro' => true, 'msg' => 'Desculpe, no momento você não pode enviar mais solicitações, talvez você já tenha feito sua solicitação deste mês.']);
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
