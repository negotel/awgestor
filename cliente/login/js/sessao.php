<?php

 @session_start();
 header("Access-Control-Allow-Origin: *");

 if(isset($_POST['dados'])){

    $dados = json_decode($_POST['dados']);
    
    $data = new stdClass();
    $data->erro         = false;
    $data->id           = $dados->id;
    $data->nome         = $dados->nome;
    $data->email        = $dados->email;
    $data->telefone     = $dados->telefone;
    $data->id_plano     = $dados->id_plano;
    $data->senha        = $dados->senha;
    $data->notas        = $dados->notas;
    $data->vencimento   = $dados->vencimento;
    
    $_SESSION['SESSION_CLIENTE'] = (array)$data;
    $_SESSION['LOGADO'] = true;

    
 }


?>
