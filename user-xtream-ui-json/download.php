<?php
	
	@session_start();

	if(!isset($_FILES['file'])){
		
		$_SESSION['erro'] = "<i class='fa fa-window-close' ></i> Envie um arquivo";
		header('Location: ../');
		die;
	}
	

  
   $file = file_get_contents($_FILES['file']['tmp_name']);

   $trinit = "<tr ";
   $trend = "</tr>";

   $index_tr_init = strpos($file, $trinit);
   
   if(!$index_tr_init){
	   
	  $_SESSION['erro'] = "<i class='fa fa-window-close' ></i> Arquivo não reconhecido";
	  header('Location: ../');
	  die;
	  
   }
   
   $index_tr_end  = strpos($file, $trend);

   $qtd_trs       = substr_count($file, $trend);


   $indexadorTr   = $index_tr_end + strlen($trend);

   $y 	    = $qtd_trs;
   $dadosTr = array();
   
   
   $dadosTr[0]  = substr($file, $index_tr_init, $index_tr_end + strlen($trend));
   
   $resTr_string = substr($file, $indexadorTr);
   
   $y--;
	
	
	for ($i = 1; $i <= $y; $i++) {
	   $index_tr_init = strpos($resTr_string, $trinit);
	   $index_tr_end = strpos($resTr_string, $trend);
	   $indexadorTr = $index_tr_end + strlen($trend);
	   $dadosTr[$i] = substr($resTr_string, $index_tr_init, $index_tr_end + strlen($trend));
	   $resTr_string = substr($resTr_string, $indexadorTr);
   }
   
   $a = 0;
	
	foreach($dadosTr as $key => $val){
		
		$string  = explode('<tr class="user-',$val);
		$string2 = explode('role="row"',$string[1]);
		$users[(int)str_replace('odd','',str_replace('even','',strip_tags($string2[0])))] = $val;
		
		$a++;
	}
	

	foreach($users as $idu => $string){
	
		   $separa   = explode("role=\"row\">", $string);
		   $separa3  = explode("</tr>", $separa[1]);

		   $variavel1 = $separa3[0];

		   $optioninit = "<td>";
		   $optionend = "</td>";

		   $index_option_init = strpos($variavel1, $optioninit);
		   $index_option_end  = strpos($variavel1, $optionend);

		   $qtd_tds       = substr_count($variavel1, $optionend);
		   $dados = array();
		   
		   $indexador   = $index_option_end + strlen($optionend);
		   
		   $j = $qtd_tds;
		   $dados[0]   = substr($variavel1, $index_option_init, $index_option_end + strlen($optionend));

		   $res_string = substr($variavel1, $indexador);


		   $j--;
		 
		   for ($i = 1; $i <= $j; $i++) {
			   $index_option_init = strpos($res_string, $optioninit);
			   $index_option_end = strpos($res_string, $optionend);
			   $indexador = $index_option_end + strlen($optionend);
			   $dados[$i] = substr($res_string, $index_option_init, $index_option_end + strlen($optionend));
			   $res_string = substr($res_string, $indexador);
		   }


			$arstr1 = array('<td class="dt-center sorting_1">','</td>','<td>','<td class=" dt-center">','<i class="text-success fas fa-circle"></i>','<i class="text-warning far fa-circle"></i>','<i class="text-secondary far fa-circle"></i>','<i class="text-secondary fas fa-circle"></i>','<i class="text-warning fas fa-circle"></i>',' ');
			$arstr2 = array('','','','1','0','0','1','1','');



			$dados_us = array();
			$option_value_init = "\">";
			$option_value_end  = "</td>";
			$option_valor = 0;
			$length_value = 0;
			$str_encontrada = false;
			$str_busca = "";
			
			
			$name_value = array(
				1 => 'username',
				2 => 'password',
				3 => 'reseller',
				4 => 'status',
				5 => 'online',
				6 => 'trial',
				7 => 'expiration',
				8 => 'active',
				9 => 'conexao'
			);

			for ($i = 0; $i < $qtd_tds; $i++) {
				
			   $index_optioninit = strpos($dados[$i], $option_value_init) + strlen($option_value_init);
			   $index_optionend  = strpos($dados[$i], $option_value_end);
			   $length_value = $index_optionend - $index_optioninit;
			   $option_valor = substr($dados[$i], $index_optioninit, $length_value);
							
				// fas => 1
				// far => 0
							
				$ar1 = array(
				 '<i class="text-success fas fa-circle"></i>', //1
				 '<i class="text-success far fa-circle"></i>', //0
				 '<i class="text-secondary fas fa-circle"></i>', //1
				 '<i class="text-secondary far fa-circle"></i>', //0
				 '<i class="text-warning fas fa-circle"></i>', //1
				 '<i class="text-warning far fa-circle"></i>' //0
				);

				$ar2 = array('1','0','1','0','1','0');

							
			   if(isset($name_value[$i])){
				   $position[$idu][$name_value[$i]] = strip_tags(str_replace($ar1,$ar2,str_replace('d>','',$option_valor)));
			   }  

		   }
			
			
			
	}
			


		header('Content-disposition: attachment; filename='.date('dmYHi').'_export-xtream-ui.json');
		header('Content-type: application/json');

        echo json_encode($position);
    