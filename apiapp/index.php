<?php

 header('Content-Type: application/json');

 if(isset($_REQUEST['token'])){
     
     
     $token = trim($_REQUEST['token']);
     
     require_once 'autoload.php';
     
     $auth = $i->API->auth($token);
     
     if($auth){
         
         $dados_user = $i->User->dados($auth->id_user);
         $plano_user = $i->Gestor->plano($dados_user->id_plano);
         $vencimento = $i->User->vencimento($dados_user->vencimento);
         
         
         if($dados_user == false){
             echo json_encode(["erro" => true, "codigo" => 001, "msg" => "Usuário proveniente deste token não existe mais"]);
             die;
         }
         
     }else{
         echo json_encode(["erro" => true, "codigo" => 002, "msg" => "token inválido"]);
         die;
     }
     
     if(!isset($_REQUEST['action'])){
         echo json_encode(["erro" => true, "codigo" => 003, "msg" => "action is required"]);
         die;
     }
    
     if($vencimento == "vencido"){
         echo json_encode(["erro" => true, "codigo" => 004, "msg" => "Painel Gestor Lite vencido"]);
         die;
     }
     
     
     /*Pronto para o uso*/
     
     $action  = $_REQUEST['action'];
     $request = $_REQUEST;
     
     if(method_exists($i->API,$action)){
         
         
         
         /*Dados para atualizar perfil*/
         
         $request['nome'] = !isset($request['nome']) ? $dados_user->nome : $request['nome'];
         $request['email'] = !isset($request['email']) ? $dados_user->email : $request['email'];
         $request['telefone'] = !isset($request['telefone']) ? $dados_user->telefone : $request['telefone'];
         $request['ddi'] = !isset($request['ddi']) ? $dados_user->nome : $request['ddi'];
         $request['dias'] = !isset($request['dias']) ? $dados_user->dias_aviso_antecipado : $request['dias'];
         $request['dark'] = !isset($request['dark']) ? $dados_user->dark : $request['dark'];
         
         

         $response = $i->API->$action((object)$request,$auth->id_user);
         
         if($response){
             echo $response;
         }else{
             echo json_encode(["erro" => true, "codigo" => 005, "msg" => "Ocorreu algum erro"]);
             die;
         }
         
         
     }else{
         echo json_encode(["erro" => true, "codigo" => 006, "msg" => "action not found"]);
         die;
     }
     
  
 }else{
     echo json_encode(["erro" => true, "codigo" => 007, "msg" => "token is required"]);
     die;
 }

?>