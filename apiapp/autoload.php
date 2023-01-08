<?php

@session_start();
date_default_timezone_set('America/Sao_Paulo');

class Autoload {

    public function __construct() {

        spl_autoload_extensions('.class.php');
        spl_autoload_register(array($this, 'load'));

    }

    private function load($className) {

        $extension = spl_autoload_extensions();
         require_once ('../class/' . $className . $extension);
    }
}

$autoload = new Autoload();


$s    = scandir("../class");
$arrayClass = array();
 foreach ($s as $k){
   if($k != "." && $k != ".."){
      $ex = explode('.',$k);
      $classe = $ex[0];
      $arrayClass[$classe] = new $classe();
   }
 }

$i = (object)$arrayClass;
$idioma  = isset($_SESSION['idioma']) ? $_SESSION['idioma'] : 'br';
$idioma = (object)$i->Idioma->idioma($idioma);


?>
