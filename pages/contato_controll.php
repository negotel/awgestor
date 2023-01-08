<?php
        
    @session_start();

    if(isset($_POST['dados'])){
        
        $json = new stdClass();
        
        $dados = json_decode($_POST['dados']);
        
        if($dados->nome != "" && $dados->email != "" && $dados->ddi != "" && $dados->cliente != "" && $dados->msg != "" && $dados->assunto != ""){
            
            if(filter_var($dados->email, FILTER_VALIDATE_EMAIL)){
            
            
                require_once '../class/Conn.class.php';
                require_once '../class/Contato.class.php';
                
                $contato = new Contato();
                
                $ar1 = array(')','(','-',' ','+');
                $ar2 = array('','','','','');
                
                $dados->cliente = $dados->cliente == 1 ? "Sim" : "Não";
                $dados->whatsapp = str_replace($ar1,$ar2,$dados->whatsapp);
                
                $insert_contato = $contato->insert($dados);
                
                if($insert_contato){
                    
                   $json->erro = false;
                   $json->msg  = "Olha que legal ! Nossa equipe recebeu sua mensagem, em breve vamos entrar em contato !";
                   echo json_encode($json);
                    
                }else{
                   $json->erro = true;
                   $json->msg  = "Que pena, houve um erro ao enviar suas mensagem, tente mais tarde!";
                   echo json_encode($json);
                }
                    
                
            }else{
                $json->erro = true;
                $json->msg  = "Que email esquisito, coloca outro ai pra ver!";
                echo json_encode($json);
            }
            
        }else{
            $json->erro = true;
            $json->msg  = "Por gentileza parceiro(a), complete todos os campos :) !";
            echo json_encode($json);
        }
        
    }




?>