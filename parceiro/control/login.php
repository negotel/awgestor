<?php 

    @session_start();
    
    require_once '../../class/Conn.class.php';
    require_once '../../class/Afiliado.class.php';
    
    $afiliado = new Afiliado();
    
    
    if(isset($_POST['login'])){
        
        $email = trim($_POST['email']);
        $senha = trim($_POST['pass']);
        
        if($email != "" && $senha != ""){
            
            $login = $afiliado->login($email,$senha);
            
            if($login){
                echo json_encode(['erro' => false, 'msg' => 'Logado com sucesso']);
                die;
            }else{
                echo json_encode(['erro' => true, 'msg' => 'Login incorreto']);
                die;
            }
            
        }else{
            echo json_encode(['erro' => true, 'msg' => 'Preencha todos os campos']);
            die;
        }
        
        
    }


?>