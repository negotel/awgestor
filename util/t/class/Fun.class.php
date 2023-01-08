<?php



 class Fun extends API{


   function __construct()
     {
       $this->api = new API;
     }

    public function request($request){

      if(isset($request)){

        if(isset($request['email']) && isset($request['package_id']) && isset($request['chave']) && isset($request['nome']) && isset($request['whatsapp']) ){

          if($request['email'] != "" && $request['package_id'] != "" && is_numeric($request['package_id']) && $request['chave'] != "" && $request['nome'] != "" && $request['whatsapp'] != ""){
            
            $wsapp = $request['ddi'].str_replace(' ','',str_replace('-','',str_replace(')','',str_replace('(','',$request['whatsapp']))));
    
             $_GERAR_TESTE = $this->api->gerateste($request['chave'],$request['email'],$request['package_id'],urlencode($request['nome']),$wsapp);

             if($_GERAR_TESTE){

               return $_GERAR_TESTE;

             }else{
               return json_encode(["erro" => true, "msg" => "Erro inesperado ao interagir com API"]);
             }

          }else{
            return json_encode(["erro" => true, "msg" => "Existe campos em branco"]);
          }

        }else{
          return json_encode(["erro" => true, "msg" => "Informe todos os campos"]);
        }

      }else{
        return false;
      }

    }


 }

 ?>
