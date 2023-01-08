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


$clientes_class_au = new Clientes();

@$cont_aviso = $clientes_class_au->count_avisos($_SESSION['PAINEL']['id_user']);


?>
