<?php

  $arquivo = 'financeiro_gestor_lite.xls';

  $html = '';
  $html .= '<table border="1">';
  $html .= '<tr>';
  $html .= '<td colspan="6"><center>Financeiro - Gestor Lite</center></td>';
  $html .= '</tr>';

  $html .= '<tr>';
	$html .= '<td><b>ID</b></td>';
	$html .= '<td><b>Tipo</b></td>';
	$html .= '<td><b>Data</b></td>';
  $html .= '<td><b>Hora</b></td>';
  $html .= '<td><b>Valor</b></td>';
	$html .= '<td><b>Nota</b></td>';
	$html .= '</tr>';

  $html .= '<tr>';
  $html .= '<td colspan="6"></td>';
  $html .= '</tr>';

  foreach ($dados_exp as $key => $value) {

    $tipo = $value->tipo == 1 ? "Entrada" : "Saida";


  	$html .= '<tr>';
  	$html .= '<td>'.$value->id.'</td>';
  	$html .= '<td>'.$tipo.'</td>';
  	$html .= '<td>'.$value->data.'</td>';
    $html .= '<td>'.$value->hora.'</td>';
    $html .= '<td>'.$value->valor.'</td>';
  	$html .= '<td>'.$value->nota.'</td>';
  	$html .= '</tr>';


  }

    $html .= "</table>";

    header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
 		header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
 		header ("Cache-Control: no-cache, must-revalidate");
 		header ("Pragma: no-cache");
 		header ("Content-type: application/x-msexcel");
 		header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
 		header ("Content-Description: PHP Generated Data" );

    echo $html;
  exit;

?>
