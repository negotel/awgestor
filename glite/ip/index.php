<?php

  if(isset($_SERVER['REMOTE_ADDR'])){

    function gravar($texto){
      $arquivo = "ip_instagram.txt";
      $fp = fopen($arquivo, "a+");
      fwrite($fp, $texto);
      fclose($fp);
    }

    gravar(json_encode($_SERVER));


  }

?>
