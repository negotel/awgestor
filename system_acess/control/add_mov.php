<?php

 require_once 'conf.php';
 
 if(isset($_POST['nota'])){
     
     if($_POST['nota'] == "" || $_POST['valor'] == "" || $_POST['tipo'] == ""){
         echo json_encode(['erro' => true, 'msg' => "Preencha todos os campos"]);
         die;
     }
     
     $dados = new stdClass();
     $dados->tipo = $_POST['tipo'];
     $dados->valor = $_POST['valor'];
     $dados->data = date('d/m/Y');
     $dados->nota = $_POST['nota'];
     
      $financeiro_class = new Financeiro();

     
     $insert = $financeiro_class->insert_admin($dados);
     
     if($insert){
         echo json_encode(['erro' => false, 'msg' => "Adicionado com sucesso"]);
         die;
     }else{
         echo json_encode(['erro' => false, 'msg' => "Erro ao adicionar"]);
         die;
     }
     
 
 }







?>