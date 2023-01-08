<?php

  $quebra = "\r\n";
  $txt = "";

  foreach ($dados_exp as $key => $value) {

     $tipo = $value->tipo == 1 ? "Entrada" : "Saida";


     $txt .= $quebra;
     $txt .= 'ID: '.$value->id.' | ';
     $txt .= 'TIPO: '.$tipo.' | ';
     $txt .= 'DATA: '.$value->data.' | ';
     $txt .= 'HORA: '.$value->hora.' | ';
     $txt .= 'VALOR: '.$value->valor.' | ';
     $txt .= 'NOTA: '.$value->nota;
     $txt .= $quebra;


  }

  $arquivo = "financeiro_getor_lite.txt";

  // Configurações header para forçar o download
  header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
  header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
  header ("Cache-Control: no-cache, must-revalidate");
  header ("Pragma: no-cache");
  header ("Content-type: application/x-msexcel");
  header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
  header ("Content-Description: PHP Generated Data" );
  // Envia o conteúdo do arquivo
  echo $txt;
  exit;


?>
