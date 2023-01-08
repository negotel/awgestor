<?php


 /**
  *
  */
 class Clientes extends Conn
 { 


      function __construct()
      {
        $this->conn = new Conn;
        $this->pdo  = $this->conn->pdo();
      }


      public function verific_email($email){
              
          if($email == ""){
                  return true;
          }else{
    
            $query = $this->pdo->query("SELECT * FROM `clientes` WHERE email='$email' ");
            $fetch = $query->fetchAll(PDO::FETCH_OBJ);
            if(count($fetch)>0){
              return false;
            }else{
              return true;
            }
              
        }

      }
      
      
       public function add_indicacao($id,$user){
     
         $atual = self::get_indicacoes($id);
         
         if($atual->qtd == 0){
            $this->pdo->query("DELETE FROM `indicacoes_clientes` WHERE id_cliente='$id' ");
            
            // add
            $this->pdo->query("INSERT INTO `indicacoes_clientes`(`id_cliente`, `qtd`, `id_user`) VALUES ('$id','1','$user')");
         }else{
             
             // update
             $nova = $atual->qtd+1;
             $this->pdo->query("UPDATE `indicacoes_clientes` SET `qtd`='$nova' WHERE id_cliente='$id'");
             
         }
        return true;
       }

      
      public function get_indicacoes($id){
          
        $query = $this->pdo->query("SELECT * FROM `indicacoes_clientes` WHERE id_cliente='$id' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);

        if(count($fetch)>0){
            
            $query = $this->pdo->query("SELECT * FROM `indicacoes_clientes` WHERE id_cliente='$id' ");
            $fetch = $query->fetch(PDO::FETCH_OBJ);
            return $fetch;

        }else {
            $obj = new stdClass();
            $obj->qtd = 0;
            return $obj;
        }
        
      }
      
    public function get_indicacoesByuser($id){
          
        $query = $this->pdo->query("SELECT * FROM `indicacoes_clientes` WHERE id_user='$id' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);

        if(count($fetch)>0){
            
            $query = $this->pdo->query("SELECT * FROM `indicacoes_clientes` WHERE id_user='$id' ORDER BY qtd DESC");
            return $query;

        }else {
            return false;
        }
        
      }
      
    public function update_indicacao_painel($iduser,$info){
        
        $query = $this->pdo->query("UPDATE `conf_cli_area` SET indicacao='$info' WHERE id_user='$iduser' ");

        if($query){

           return true;

        }else {
          return false;
        }

      }
      
     public function update_amostra_plans_painel($iduser,$info){
        
        $query = $this->pdo->query("UPDATE `conf_cli_area` SET planos_amostra='$info' WHERE id_user='$iduser' ");

        if($query){

           return true;

        }else {
          return false;
        }

      }
      
         public function get_faturas_count_pay($id){
              
            $query = $this->pdo->query("SELECT * FROM `faturas_clientes` WHERE id_cliente='$id' AND status='Pago'");
            $fetch = $query->fetchAll(PDO::FETCH_OBJ);
    
            if(count($fetch)>0){
                
                $query = $this->pdo->query("SELECT * FROM `faturas_clientes` WHERE id_cliente='$id' AND status='Pago'");
                $fetch = $query->fetch(PDO::FETCH_OBJ);
                return count($fetch);
    
            }else {
                
                return 0;
            }
            
          }
      
      public function dados_lista_negra($id){
        
        $query = $this->pdo->query("SELECT * FROM `lsita_negra_avisos` WHERE cliente_id='$id' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);

        if(count($fetch)>0){
            
            $query = $this->pdo->query("SELECT * FROM `lsita_negra_avisos` WHERE cliente_id='$id' ");
            $fetch = $query->fetch(PDO::FETCH_OBJ);
            return $fetch;

        }else {
          return false;
        }

      }
      
      public function verifica_lista_negra($id){
        
        $query = $this->pdo->query("SELECT * FROM `lsita_negra_avisos` WHERE cliente_id='$id' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);

        if(count($fetch)>0){

           return false;

        }else {
          return true;
        }

      }
      
      public function update_lista_negra($id,$email,$zap){
        
        $query = $this->pdo->query("UPDATE `lsita_negra_avisos` SET whatsapp='$zap', email='$email' WHERE cliente_id='$id' ");

        if($query){

           return true;

        }else {
          return false;
        }

      }
      
      
      public function add_lista_negra($id,$email,$zap){
        
        $query = $this->pdo->prepare("INSERT INTO `lsita_negra_avisos` (whatsapp,email,cliente_id) VALUES (:whatsapp,:email,:cliente_id) ");
        $query->bindValue(':whatsapp',$zap);
        $query->bindValue(':email',$email);
        $query->bindValue(':cliente_id',$id);

        if($query->execute()){
          return true;
        }else{
          return false;
        }
        
      }
      
         public function remove_categoria($id,$id_user){
          
          $query = $this->pdo->query("DELETE FROM `categorias_cliente` WHERE id='$id' AND id_user='$id_user' ");
    
            if($query){
                
              $this->pdo->query("UPDATE `clientes` SET categoria='0' WHERE id_user='$id_user' AND categoria='$id' ");    
                
              return true;
            }else{
              return false;
            }
            
          }


      

      public function add_categoria($id_user,$nome,$cor){
        
        $query = $this->pdo->prepare("INSERT INTO `categorias_cliente` (id_user,nome,cor) VALUES (:id_user,:nome,:cor) ");
        $query->bindValue(':id_user',$id_user);
        $query->bindValue(':nome',$nome);
        $query->bindValue(':cor',$cor);

        if($query->execute()){
          return true;
        }else{
          return false;
        }
        
      }
      
      public function get_categoria($id){
            $query = $this->pdo->query("SELECT * FROM `categorias_cliente` WHERE id='$id' ");
            $fetch = $query->fetchAll(PDO::FETCH_OBJ);
    
            if(count($fetch)>0){
                
                $query = $this->pdo->query("SELECT * FROM `categorias_cliente` WHERE id='$id' ");
                $fetch = $query->fetch(PDO::FETCH_OBJ);
                return $fetch;
    
            }else {
              return false;
            }
      }
      
    public function update_categoria($id,$nome,$id_user){
        
        $query = $this->pdo->prepare("UPDATE `categorias_cliente` SET nome= :nome WHERE id= :id AND id_user= :id_user");
        $query->bindValue(':nome',$nome);
        $query->bindValue(':id',$id);
        $query->bindValue(':id_user',$id_user);
        
        if($query->execute()){
            return true;
        }else{
            return false;
        }
        
    }
    
    public function update_categoria_cor($id,$cor,$id_user){
        
        $query = $this->pdo->prepare("UPDATE `categorias_cliente` SET cor= :cor WHERE id= :id AND id_user= :id_user");
        $query->bindValue(':cor',$cor);
        $query->bindValue(':id',$id);
        $query->bindValue(':id_user',$id_user);
        
        if($query->execute()){
            return true;
        }else{
            return false;
        }
        
    }
      
     public function count_categorias_clientes($id_user){

        $query = $this->pdo->query("SELECT * FROM `categorias_cliente` WHERE id_user='$id_user'");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);

        return count($fetch);

      }
      
      
     public function count_clientes_by_categoria($categoria,$id_user){

        $query = $this->pdo->query("SELECT * FROM `clientes` WHERE id_user='$id_user' AND categoria='$categoria' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        return count($fetch);

      }
      
    public function list_categorias_clientes($id_user){

        $query = $this->pdo->query("SELECT * FROM `categorias_cliente` WHERE id_user='$id_user'");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);

        if(count($fetch)>0){

          $query = $this->pdo->query("SELECT * FROM `categorias_cliente` WHERE id_user='$id_user' ORDER BY id DESC");
          return $query;

        }else {
          return false;
        }

      }
      
      
      

      public function list_vencimento($data){

        $query = $this->pdo->query("SELECT * FROM `clientes` WHERE vencimento='$data' AND recebe_zap='1' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);

        if(count($fetch)>0){

          $query = $this->pdo->query("SELECT * FROM `clientes` WHERE vencimento='$data' AND recebe_zap='1' ");
          return $query;

        }else {
          return false;
        }

      }

      public function list_avisos_data($data){

        $query = $this->pdo->query("SELECT * FROM `avisos_painel` WHERE auto_delete='$data'");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);

        if(count($fetch)>0){

          $query = $this->pdo->query("SELECT * FROM `avisos_painel` WHERE auto_delete='$data'");
          return $query;

        }else {
          return false;
        }

      }


    public function aprova_comp($fat,$file,$dir=''){
        
        if($this->pdo->query("UPDATE `faturas_clientes` SET status='Pago', comprovante='not' WHERE id='$fat' ")){
            
            $this->pdo->query("DELETE FROM `comprovantes_fat_cli` WHERE id_fat='$fat' ");
            
            if(is_file($dir.$file)){
                unlink($dir.$file);
            }
            
            return true;
        }else{
            return false;
        }
        
    }
    
    public function recusa_comp($fat,$file,$dir=''){
        
        if($this->pdo->query("UPDATE `faturas_clientes` SET status='Rejeitado', comprovante='not' WHERE id='$fat' ")){
            $this->pdo->query("DELETE FROM `comprovantes_fat_cli` WHERE id_fat='$fat' ");
            
            if(is_file($dir.$file)){
                unlink($dir.$file);
            }
            
            return true;
        }else{
            return false;
        }
        
    }

    public function list_fats_comp($user){
        
             
    
          $query = $this->pdo->query("SELECT * FROM comprovantes_fat_cli WHERE id_user= '$user' ");
          $fetch = $query->fetchAll(PDO::FETCH_OBJ);
          if(count($fetch)>0){
              
            $query = $this->pdo->query("SELECT * FROM comprovantes_fat_cli WHERE id_user= '$user' ");
            return $query;
    
          }else{
            return false;
          }
    
      }
      
      

      
        public function dados_comp($idFat){
          $query = $this->pdo->query("SELECT * FROM comprovantes_fat_cli WHERE id_fat= '$idFat' ");
          $fetch = $query->fetchAll(PDO::FETCH_OBJ);
          if(count($fetch)>0){
              
            $query = $this->pdo->query("SELECT * FROM comprovantes_fat_cli WHERE id_fat= '$idFat' LIMIT 1 ");
            $fetch = $query->fetch(PDO::FETCH_OBJ);
            return $fetch;
    
          }else{
            return false;
          }
    
      }



      public function list_clientes($user,$limit){

            if($limit){

              $query = $this->pdo->query("SELECT * FROM `clientes` WHERE id_user='$user'");
              $fetch = $query->fetchAll(PDO::FETCH_OBJ);
              if(count($fetch)>0){

                $query = $this->pdo->query("SELECT * FROM `clientes` WHERE id_user='$user' ORDER BY STR_TO_DATE(vencimento, '%d/%m/%Y')  LIMIT $limit ");
                return $query;

              }else{
                return false;
              }

            }else{

              $query = $this->pdo->query("SELECT * FROM `clientes` WHERE id_user='$user'");
              $fetch = $query->fetchAll(PDO::FETCH_OBJ);
              if(count($fetch)>0){

                $query = $this->pdo->query("SELECT * FROM `clientes` WHERE id_user='$user' ORDER BY STR_TO_DATE(vencimento, '%d/%m/%Y')");
                return $query;

              }else{
                return false;
              }

            }
      }


    public function getTokenLogin($token){
      

        $query = $this->pdo->query("SELECT * FROM `token_login_cliente` WHERE token='$token' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if(count($fetch)>0){

          $query = $this->pdo->query("SELECT * FROM `token_login_cliente` WHERE token='$token' LIMIT 1");
          $fetch = $query->fetch(PDO::FETCH_OBJ);
          return $fetch;

        }else{
          return false;
        }

      
    }


      public function busca_aviso($user,$id){

        $query = $this->pdo->query("SELECT * FROM `avisos_painel` WHERE id_user='$user' AND id='$id' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if(count($fetch)>0){

          $query = $this->pdo->query("SELECT * FROM `avisos_painel` WHERE id_user='$user' AND id='$id' LIMIT 1");
          $fetch = $query->fetch(PDO::FETCH_OBJ);
          return $fetch;

        }else{
          return false;
        }

      }
      
      public function removeTokenLogin($token){
      
      $query = $this->pdo->query("DELETE FROM `token_login_cliente` WHERE token='$token' ");

        if($query){
          return true;
        }else{
          return false;
        }
        
      }

      public function del_aviso($id){

        $query = $this->pdo->query("DELETE FROM `avisos_painel` WHERE id='$id' ");

        if($query){
          return true;
        }else{
          return false;
        }

      }


      public function count_avisos($user){

            $query = $this->pdo->query("SELECT * FROM `avisos_painel` WHERE id_user='$user' ");
            $fetch = $query->fetchAll(PDO::FETCH_OBJ);

            return count($fetch);
      }

      public function add_aviso($dados){

        $query = $this->pdo->prepare("INSERT INTO `avisos_painel` (id_user,titulo,texto,color,auto_delete) VALUES (:id_user,:titulo,:texto,:color,:auto_delete) ");
        $query->bindValue(':id_user',$dados->id_user);
        $query->bindValue(':titulo',$dados->titulo);
        $query->bindValue(':texto',$dados->texto);
        $query->bindValue(':color',$dados->color);
        $query->bindValue(':auto_delete',$dados->auto_delete);


        if($query->execute()){
          return true;
        }else{
          return false;
        }

      }

      public function update_aviso($id,$dados){

        $query = $this->pdo->prepare("UPDATE `avisos_painel` SET titulo= :titulo, texto= :texto, color= :color, auto_delete= :auto_delete WHERE id= :id ");
        $query->bindValue(':titulo',$dados->titulo);
        $query->bindValue(':texto',$dados->texto);
        $query->bindValue(':color',$dados->color);
        $query->bindValue(':auto_delete',$dados->auto_delete);
        $query->bindValue(':id',$id);

        if($query->execute()){
          return true;
        }else{
          return false;
        }


      }


      public function create_area_cli($dados){

        $query = $this->pdo->prepare("INSERT INTO `conf_cli_area` (`nome_area`,`logo_area`,`slug_area`,`situ_area`,`text_suporte`,`id_user`) VALUES (:nome_area,:logo_area,:slug_area,:situ_area,:text_suporte,:id_user) ");
        $query->bindValue(':nome_area',$dados->nome_area);
        $query->bindValue(':logo_area',$dados->logo_area);
        $query->bindValue(':slug_area',$dados->slug_area);
        $query->bindValue(':situ_area',$dados->situ_area);
        $query->bindValue(':text_suporte',$dados->text_suporte);
        $query->bindValue(':id_user',$dados->id_user);


        if($query->execute()){
          return true;
        }else{
          return false;
        }

      }


      public function avisos_area_cli($user){

        $query = $this->pdo->query("SELECT * FROM `avisos_painel` WHERE id_user='$user' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if(count($fetch)>0){

          $query = $this->pdo->query("SELECT * FROM `avisos_painel` WHERE id_user='$user' ORDER BY id DESC");
          return $query;

        }else{
          return false;
        }
      }
      
      public function token_login($email,$senha){
          
         $token = substr(sha1(rand(100000,9999999999)),0,220);
          
         $query = $this->pdo->query("INSERT INTO `token_login_cliente` (token,senha,email) VALUES ('{$token}','{$senha}','{$email}') ");
         
         if($query){
             return $token;
         }else{
             return false;
         }
          
      }

      public function area_cli_conf($user){
        $query = $this->pdo->query("SELECT * FROM `conf_cli_area` WHERE id_user='$user' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if(count($fetch)>0){

          $query = $this->pdo->query("SELECT * FROM `conf_cli_area` WHERE id_user='$user' LIMIT 1");
          $fetch = $query->fetch(PDO::FETCH_OBJ);
          return $fetch;

        }else{
          return false;
        }
      }

     public function isJSON($string){
           return is_string($string) 
           && is_array(json_decode($string, true)) 
           && (json_last_error() == JSON_ERROR_NONE) ? true : false;
        }

      public function area_cli_dados($slug){
        $query = $this->pdo->query("SELECT * FROM `conf_cli_area` WHERE slug_area='$slug' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if(count($fetch)>0){

          $query = $this->pdo->query("SELECT * FROM `conf_cli_area` WHERE slug_area='$slug' LIMIT 1");
          $fetch = $query->fetch(PDO::FETCH_OBJ);
          return $fetch;

        }else{
          return false;
        }

      }


      public function list_fat($id){

            $query = $this->pdo->query("SELECT * FROM `faturas_clientes` WHERE id_cliente='$id' ");
            $fetch = $query->fetchAll(PDO::FETCH_OBJ);
            if(count($fetch)>0){

              $query = $this->pdo->query("SELECT * FROM `faturas_clientes` WHERE id_cliente='$id' ORDER BY id DESC ");
              return $query;

            }else{
              return false;
            }
      }


    public function get_fat($id){

            $query = $this->pdo->query("SELECT * FROM `faturas_clientes` WHERE id='$id' ");
            $fetch = $query->fetchAll(PDO::FETCH_OBJ);
            if(count($fetch)>0){

              $query = $this->pdo->query("SELECT * FROM `faturas_clientes` WHERE id='$id' LIMIT 1");
              $fetch = $query->fetch(PDO::FETCH_OBJ);
              return $fetch;

            }else{
              return false;
            }
      }

      public function busca($term,$idu){

            $query = "SELECT * FROM `clientes` WHERE id_user='$idu' AND (CONVERT(`id` USING utf8) LIKE '%{$term}%' OR CONVERT(`nome` USING utf8) LIKE '%{$term}%' OR CONVERT(`email` USING utf8) LIKE '%{$term}%' OR CONVERT(`telefone` USING utf8) LIKE '%{$term}%' OR CONVERT(`vencimento` USING utf8) LIKE '%{$term}%' OR CONVERT(`identificador_externo` USING utf8) LIKE '%{$term}%' )";

    		$execute = $this->pdo->query($query);
    		$us1     = $execute->fetchAll(PDO::FETCH_OBJ);

        if(count($us1)>0){
          return $this->pdo->query($query);
        }else{
          return false;
        }


      }


      public function count_clientes($user){

            $query = $this->pdo->query("SELECT * FROM `clientes` WHERE id_user='$user' ");
            $fetch = $query->fetchAll(PDO::FETCH_OBJ);
            return count($fetch);

      }
      
    public function count_clientes_inadimplentes($user){

            $query = $this->pdo->query("SELECT * FROM `clientes` WHERE id_user='$user' ");
            $fetch = $query->fetchAll(PDO::FETCH_OBJ);
              
             $numV = 0; 
              
             foreach($fetch as $key => $value){
                    
                if($value->vencimento != '0' && $value->vencimento != '00/00/0000'){

                    
                     // verificar data do vencimento
                      $explodeData  = explode('/',$value->vencimento);
                      $explodeData2 = explode('/',date('d/m/Y'));
                      $dataVen      = $explodeData[2].$explodeData[1].$explodeData[0];
                      $dataHoje     = $explodeData2[2].$explodeData2[1].$explodeData2[0]; 
                      
                     if($dataHoje > $dataVen){
                          $numV++;
                      }
                 }   
                
             }
             
             return $numV;

      }


      public function list_export($user){

            $query = $this->pdo->query("SELECT * FROM `clientes` WHERE id_user='$user' ");
            $fetch = $query->fetchAll(PDO::FETCH_OBJ);
            if(count($fetch)>0){

              $query = $this->pdo->query("SELECT nome,email,telefone,vencimento,id_plano,notas,senha FROM `clientes` WHERE id_user='$user' ORDER BY STR_TO_DATE(vencimento, '%d/%m/%Y') ");
              $fetch = $query->fetchAll(PDO::FETCH_OBJ);

              return $fetch;

            }else{
              return false;
            }


      }


 
   public function insert2($dados){

      if($dados->email != "vazio"){
        if(self::verific_email($dados->email)){}else{
            return 'mail';
            die;
          }
        }

        if(!isset($dados->indicado)){
            $dados->indicado = 0;
        }

        // buscar a quantidade de cleintes que possui
        $numC = self::count_clientes($dados->id_user);
        $som = $numC+1;

        // verificar se ja atingiu o limite de cliente permitido por plano
        if($som > $dados->limit_plano){
          return 'limit';
          die;
        }


      $query = $this->pdo->query("INSERT INTO `clientes` (id_user,nome,email,telefone,vencimento,id_plano,notas,recebe_zap,senha,indicado) VALUES ('{$dados->id_user}','{$dados->nome}','{$dados->email}','{$dados->telefone}','{$dados->vencimento}','{$dados->id_plano}','{$dados->notas}','{$dados->recebe_zap}','{$dados->senha}','{$dados->indicado}') ");

      if($query){

              $query = $this->pdo->query("SELECT * FROM `clientes` ORDER BY id DESC LIMIT 1");
              $fetch = $query->fetch(PDO::FETCH_OBJ);
              return $fetch;

      }else{
        return '0';
      }


    }
    
    
    public function verific_user_cloud($username,$password){
              

    
        $query = $this->pdo->query("SELECT * FROM `clientes` WHERE nome='$username' AND senha='$password' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if(count($fetch)>0){
          return true;
        }else{
          return false;
        }
              
      

      }
    
    
   public function insert_cloud($dados){

      if($dados->email != "vazio"){
        if(self::verific_email($dados->email)){}else{
            $dados->email = "vazio";
          }
        }


        // buscar a quantidade de clientes que possui
        $numC = self::count_clientes($dados->id_user);
        $som = $numC+1;

        // verificar se ja atingiu o limite de cliente permitido por plano
        if($som > $dados->limit_plano){
          return 'limit';
          die;
        }

        // verificar se usuario ja existe
        if(self::verific_user_cloud($dados->nome,$dados->senha,$dados->id_user)){
            // atualizar
           $this->pdo->query("UPDATE `clientes` SET nome= '{$dados->nome}', vencimento='{$dados->vencimento}', senha= '{$dados->senha}' WHERE nome='{$dados->nome}' AND id_user='{$dados->id_user}' ");

        }else{
       // insert
            
          $query = $this->pdo->query("INSERT INTO `clientes` (id_user,nome,email,telefone,vencimento,id_plano,notas,recebe_zap,senha) VALUES ('{$dados->id_user}','{$dados->nome}','{$dados->email}','{$dados->telefone}','{$dados->vencimento}','{$dados->id_plano}','{$dados->notas}','{$dados->recebe_zap}','{$dados->senha}') ");
    
          if($query){
            return '1';
          }else{
            return '0';
          }
        }

    }


    public function insert($dados){

      if($dados->email != "vazio"){
        if(self::verific_email($dados->email)){}else{
            return 'mail';
            die;
          }
        }


        // buscar a quantidade de cleintes que possui
        $numC = self::count_clientes($dados->id_user);
        $som = $numC+1;

        // verificar se ja atingiu o limite de cliente permitido por plano
        if($som > $dados->limit_plano){
          return 'limit';
          die;
        }
        
        if(!isset($dados->categoria)){
            $dados->categoria = "0";
        }
        
         if(!isset($dados->identificador_externo)){
            $dados->identificador_externo = NULL;
        }


      $query = $this->pdo->query("INSERT INTO `clientes` (id_user,nome,email,telefone,vencimento,id_plano,notas,recebe_zap,senha,categoria,identificador_externo,totime) VALUES ('{$dados->id_user}','{$dados->nome}','{$dados->email}','{$dados->telefone}','{$dados->vencimento}','{$dados->id_plano}','{$dados->notas}','{$dados->recebe_zap}','{$dados->senha}','{$dados->categoria}','{$dados->identificador_externo}','{$dados->totime}') ");

      if($query){
        return '1';
      }else{
        return '0';
      }


    }


    public function update_area_cli($dados,$logo){

      $query = $this->pdo->prepare("UPDATE `conf_cli_area` SET nome_area= :nome_area, logo_area= :logo_area, slug_area= :slug_area, situ_area= :situ_area, text_suporte= :text_suporte WHERE id= :id ");
      $query->bindValue(':nome_area',$dados['nome_area']);
      $query->bindValue(':logo_area',$logo);
      $query->bindValue(':slug_area',$dados['slug_area']);
      $query->bindValue(':situ_area',$dados['situ_area']);
      $query->bindValue(':text_suporte',$dados['text_suporte']);
      $query->bindValue(':id',$dados['id_painel']);

      if($query->execute()){
        return true;
      }else{
        return false;
      }



    }

    public function update_fat_status($fat,$status){

      $query = $this->pdo->prepare("UPDATE `faturas_clientes` SET status= :status WHERE id= :id ");
      $query->bindValue(':status',$status);
      $query->bindValue(':id',$fat);

      if($query->execute()){
        return true;
      }else{
        return false;
      }


    }
    
    
  public function search_fat_by_ref($ref,$notification=false){
      
      if($notification){
          $query = $this->pdo->prepare("SELECT * FROM `faturas_clientes` WHERE ref= :ref AND status != :status");
          $query->bindValue(':ref',$ref);
          $query->bindValue(':status','Pago');
      }else{
          $query = $this->pdo->prepare("SELECT * FROM `faturas_clientes` WHERE ref= :ref");
          $query->bindValue(':ref',$ref);
      }
      
      $query->execute();
      $fetch = $query->fetchAll(PDO::FETCH_OBJ);
      
      if(count($fetch)>0){
          
          $query = $this->pdo->prepare("SELECT * FROM `faturas_clientes` WHERE ref= :ref");
          $query->bindValue(':ref',$ref);
          $query->execute();
          $fetch = $query->fetch(PDO::FETCH_OBJ);
          
          return $fetch;
          
      }else{
          return false;
      }
      
      
  }

   public function create_fat($dados){

     $query = $this->pdo->prepare("INSERT INTO `faturas_clientes` (id_plano,valor,data,status,id_cliente,ref) VALUES (:id_plano,:valor,:data,:status,:id_cliente,:ref) ");
     $query->bindValue(':id_plano',$dados->id_plano);
     $query->bindValue(':valor',$dados->valor);
     $query->bindValue(':data',$dados->data);
     $query->bindValue(':status',$dados->status);
     $query->bindValue(':id_cliente',$dados->id_cli);
     $query->bindValue(':ref',$dados->ref);

     if($query->execute()){
       return true;
     }else{
       return false;
     }

   }


    public function delete($id){

      $query = $this->pdo->query("DELETE FROM `clientes` WHERE id='$id' ");
      
      $this->pdo->query("DELETE FROM `faturas_clientes` WHERE id_cliente='$id' ");
      
      $this->pdo->query("DELETE FROM `indicacoes_clientes` WHERE id_cliente='$id' ");
      
      
      if($query){
        return true;
      }else{
        return false;
      }
    }

    public function delete_fat($id) {
      $query = $this->pdo->query("DELETE FROM `faturas_clientes` WHERE id='$id' ");
      if($query){
        return true;
      }else{
        return false;
      }
    }

    public function dados($id){

      $query = $this->pdo->query("SELECT * FROM `clientes` WHERE id='$id' ");
      $fetch = $query->fetchAll(PDO::FETCH_OBJ);

      if(count($fetch)>0){

        $query = $this->pdo->query("SELECT * FROM `clientes` WHERE id='$id' LIMIT 1");
        $fetch = $query->fetch(PDO::FETCH_OBJ);
        return $fetch;
      }else{
        return false;
      }


    }
    
    public function getDono($id){

      $query = $this->pdo->query("SELECT * FROM `user` WHERE id='$id' ");
      $fetch = $query->fetchAll(PDO::FETCH_OBJ);

      if(count($fetch)>0){

        $query = $this->pdo->query("SELECT * FROM `user` WHERE id='$id' LIMIT 1");
        $fetch = $query->fetch(PDO::FETCH_OBJ);
        return $fetch;
      }else{
        return false;
      }


    }


    public function update_simple($dados){

      $query = $this->pdo->prepare("UPDATE `clientes` SET nome= :nome, email= :email, telefone= :telefone, senha= :senha WHERE id= :id ");
      $query->bindValue(':nome',$dados->nome);
      $query->bindValue(':email',$dados->email);
      $query->bindValue(':telefone',$dados->telefone);
      $query->bindValue(':senha',$dados->senha);
      $query->bindValue(':id',$dados->id);

      if($query->execute()){
        return true;
      }else{
        return false;
      }


    }

    public function renew($plano,$id,$data_antiga){
        
     $dados_cliente = self::dados($id);  
     $id_dono = $dados_cliente->id_user;
     $dados_dono = self::getDono($id_dono);
    
     // verificar data do vencimento
      $explodeData_user  = explode('/',$data_antiga);
      $explodeData2_user = explode('/',date('d/m/Y'));
      $dataVen_user      = $explodeData_user[2].$explodeData_user[1].$explodeData_user[0];
      $dataHoje_user     = $explodeData2_user[2].$explodeData2_user[1].$explodeData2_user[0];
      
      
      if($dados_dono->vencimento_flex == 1){
    
          if($dataVen_user == $dataHoje_user){
              $ven_user = date('d/m/Y', strtotime('+'.$plano->dias.' days', strtotime(date('d-m-Y'))));
          }else if($dataHoje_user > $dataVen_user){
              $ven_user = date('d/m/Y', strtotime('+'.$plano->dias.' days', strtotime(date('d-m-Y'))));
          }else{
              $ven_user = date('d/m/Y', strtotime('+'.$plano->dias.' days', strtotime( $explodeData_user[0].'-'.$explodeData_user[1].'-'.$explodeData_user[2] )));
          }
      }else{
          $ven_user = date('d/m/Y', strtotime('+'.$plano->dias.' days', strtotime( $explodeData_user[0].'-'.$explodeData_user[1].'-'.$explodeData_user[2] )));
      }
      
      $explode        = explode('/',$ven_user);
      $totime         = $explode[2].$explode[1].$explode[0];

      $query = $this->pdo->prepare("UPDATE `clientes` SET vencimento= :vencimento, id_plano= :id_plano, totime=:totime  WHERE id= :id ");
      $query->bindValue(':vencimento',$ven_user);
      $query->bindValue(':id_plano',$plano->id);
      $query->bindValue(':totime',$totime);
      $query->bindValue(':id',$id);

      if($query->execute()){
        return true;
      }else{
        return false;
      }
    }

    public function update($dados){


      $ven = date('d/m/Y',  strtotime($dados->vencimento));
      
      $explode            = explode('/',$ven);
      $totime             = $explode[2].$explode[1].$explode[0];

      $query = $this->pdo->prepare("UPDATE `clientes` SET nome= :nome, email= :email, telefone= :telefone, vencimento= :vencimento, id_plano= :id_plano, notas= :notas, recebe_zap= :recebe_zap, senha= :senha, categoria= :categoria, identificador_externo= :identificador_externo, totime= :totime WHERE id= :id ");
      $query->bindValue(':nome',$dados->nome);
      $query->bindValue(':email',$dados->email);
      $query->bindValue(':telefone',$dados->telefone);
      $query->bindValue(':vencimento',$ven);
      $query->bindValue(':id_plano',$dados->plano);
      $query->bindValue(':notas',$dados->notas);
      $query->bindValue(':recebe_zap',$dados->recebe_zap);
      $query->bindValue(':senha',$dados->senha);
      $query->bindValue(':categoria',$dados->categoria);
      $query->bindValue(':identificador_externo',$dados->identificador_externo);
      $query->bindValue(':totime',$totime);
      $query->bindValue(':id',$dados->id);

      if($query->execute()){
        return true;
      }else{
        return false;
      }

    }

   public function login($request,$id_user){

 if(isset($request['email']) && isset($request['senha']))
 {

    $pass   = $request['senha'];
    $email  = $request['email'];

    $q = $this->pdo->prepare("SELECT * FROM `clientes` WHERE email= :email AND senha= :pass AND id_user= :id_user");
    $q->bindValue(':email', $email);
    $q->bindValue(':pass', $pass);
    $q->bindValue(':id_user', $id_user);
    $q->execute();
    $fetch = $q->fetchAll(PDO::FETCH_OBJ);
    if(count($fetch)>0)
    {

      $q = $this->pdo->prepare("SELECT * FROM `clientes` WHERE email= :email AND senha= :pass AND id_user= :id_user");
      $q->bindValue(':email', $email);
      $q->bindValue(':pass', $pass);
      $q->bindValue(':id_user', $id_user);
      $q->execute();
      $fetch = $q->fetch(PDO::FETCH_OBJ);

      $data = new stdClass();
      $data->erro         = false;
      $data->id           = $fetch->id;
      $data->nome         = $fetch->nome;
      $data->email        = $fetch->email;
      $data->telefone     = $fetch->telefone;
      $data->id_plano     = $fetch->id_plano;
      $data->senha        = $fetch->senha;
      $data->notas        = $fetch->notas;
      $data->vencimento   = $fetch->vencimento;

      $_SESSION['SESSION_CLIENTE'] = (array)$data;
      $_SESSION['LOGADO'] = true;

      return json_encode($data);

    }else{

      $data = new stdClass();
      $data->erro = true;

      return json_encode($data);

    }

 }


}


 }




?>
