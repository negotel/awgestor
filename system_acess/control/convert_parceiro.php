<?php 

   @session_start();

    if(isset($_SESSION['ADMIN_LOGADO'])){
        if(isset($_POST['id'])){
            
            $id = trim($_POST['id']);
            
            require_once '../../class/Conn.class.php';
            require_once '../../class/Afiliado.class.php';
            
            $afiliado = Afiliado();
            
            if(is_numeric($id)){
                $transform_parceiro = $afiliado->transform_parceiro($id);
                if($transform_parceiro){
                    echo json_encode(['erro' => false, 'msg' => 'Este cliente agora é um parceiro']);
                }else{
                    echo json_encode(['erro' => true, 'msg' => 'Não consegui transformar este cliente em parceiro. Lamento.']);
                }
            }
            
        }
    
    }
    
    
?>