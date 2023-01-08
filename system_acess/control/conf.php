<?php 
  
  @session_start();
  
  
  if(isset($_GET['sair'])){
      unset($_SESSION['ADMIN_LOGADO']);
      echo '<script>location.href="index.php";</script>';
      die;
  }


 // Autoload
 class Autoload {
    
        public function __construct() {
    
            spl_autoload_extensions('.class.php');
            spl_autoload_register(array($this, 'load'));
    
        }
    
        private function load($className) {
    
            $extension = spl_autoload_extensions();
             require_once ('../../class/' . $className . $extension);
        }
    }
    
    $autoload = new Autoload();
    
    

?>