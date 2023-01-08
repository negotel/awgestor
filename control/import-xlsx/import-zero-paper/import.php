<?php

if ( $xlsx = SimpleXLSX::parse($_FILES['file_import']['tmp_name'])) {

	$i =0;
 
    foreach($xlsx->rows() as $key => $value){
        
        if($i>0){
        
            $tipo_lancamento = $value[0];
            $data_lancamento = $value[1];
            $descricao       = $value[3];
            $valor           = $financeiro->convertMoney(2,$value[4]);
            $categoria       = $value[5];
            $cliente_nome    = $value[6];
            $pago            = $value[7];
            $detalhes        = $value[8];
            $conta           = $value[9];
            
            $descricao_final = $descricao." | ".$categoria." | ".$cliente_nome." | ".$detalhes;
           
           
           $dados = new stdClass();
           $dados->id_user = $id_user;
           
           if($pago == "Sim"){
               $dados->tipo = 1;
           }else{
               $dados->tipo = 2;
           }
           
           $data1 = explode(' ',$data_lancamento);
           $data2 = explode('-',$data1[0]);
           $hora1 = explode(':',$data1[1]);
           
           $dados->data = $data2[2].'/'.$data2[1].'/'.$data2[0];
           $dados->hora = $hora1[0].':'.$hora1[1];
           $dados->valor = $valor;
           $dados->nota = $descricao_final;
           
           if($dados->tipo == 1){
            $financeiro->insert($dados);
           }            
        }
        
        $i++;
    }

    echo '<script>location.href="<?=SET_URL_PRODUCTION?>/painel/financeiro";</script>';
    unlink('../tmp/file.xlsx');

} else {
	echo SimpleXLSX::parseError();
}