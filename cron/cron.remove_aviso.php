<?php

  set_time_limit(3000);

  require_once 'autoload.php';
  
  $clientes_class = new Clientes();
  $logs_class = new Logs();

  $data = date('d/m/Y');

  $list_avisos = $clientes_class->list_avisos_data($data);

  if($list_avisos){

    while ($aviso = $list_avisos->fetch(PDO::FETCH_OBJ)) {

        $logs_class->log($aviso->id_user,"O aviso [ {$aviso->titulo} ] foi auto-deletado");
        $clientes_class->del_aviso($aviso->id);

    }

  }

?>
