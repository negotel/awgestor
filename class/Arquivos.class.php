<?php


 /**
  *
  */
 class Arquivos extends Conn
 {

   function __construct()
   {
     $this->conn = new Conn();
     $this->pdo  = $this->conn->pdo();
   }


   public function upload($file,$n_nome=false,$dir="../img/",$ext_perm=false){

     $return = new stdClass();


     $extensao    = pathinfo ( $file['name'], PATHINFO_EXTENSION );
     $extensao    = strtolower ( $extensao );
     $nome        = $n_nome ? substr(md5(date('His')),0,30).'.'.$extensao : $file['name'];
     $destino     = $dir.$nome;
     $arquivo_tmp = $file['tmp_name'];

     $next = true;

     if($ext_perm){
       if(!in_array($extensao,$ext_perm)){
         $next = false;
       }else{
          $next = true;
       }
     }

     if($next){

       if ( @move_uploaded_file ( $arquivo_tmp, $destino ) ) {

         $return->erro     = false;
         $return->msg      = "Arquivo carregado com sucesso";
         $return->destino  = $dir;
         $return->nome     = $nome;
         $return->src      = $destino;
         $return->extensao = $extensao;
         $return->type     = $file['type'];
         $return->new_name = $n_nome;
         $return->tmp_name = $file['tmp_name'];
         $return->size     = $file['size'];

         return json_encode($return);

       }else{

         $return->erro     = true;
         $return->msg      = "Erro ao fazer upload.";
         $return->destino  = $dir;
         $return->nome     = $nome;
         $return->extensao = $extensao;
         $return->src      = $destino;

         return json_encode($return);

       }

     }else{

       $return->erro = true;
       $return->msg  = "Extensão '{$extensao}' não é permitida.";
       return json_encode($return);

     }



   }




 }







?>
