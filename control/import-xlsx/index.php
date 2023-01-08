<?php 

    @session_start();

    if(isset($_SESSION['SESSION_USER'])){
        
        
        $id_user = $_SESSION['SESSION_USER']['id'];
        
        if(isset($_FILES['file_import']['tmp_name'])){
            
            
            if(isset($_POST['type_import'])){
                
               
                require_once 'src/SimpleXLSX.php';

                require_once '../../class/Conn.class.php';
                require_once '../../class/Financeiro.class.php';
                
                $financeiro = new Financeiro();
                
                if($_POST['type_import'] != ""){
                    
                    if($_POST['type_import'] == "zeropaper"){
                        require_once 'import-zero-paper/import.php';
                    }
                    
                }
                
            }
            
            
        }
        
        
    }
    
    echo '<script>location.href="<?=SET_URL_PRODUCTION?>/painel/financeiro";</script>';


?>