<?php

  /**
   * Afiliado
   */ 
  class Afiliado extends Conn
  {

    function __construct()
    {
      $this->conn = new Conn();
      $this->pdo  = $this->conn->pdo();
    }


    public function create_notify($af,$texto){

     $query = $this->pdo->prepare("INSERT INTO `usuarios` (texto,af) VALUES (:texto,:af) ");
     $query->bindValue(':texto', $texto);
     $query->bindValue(':af', $af);

     if($query->execute()){
       return true;
     }else{
       return false;
     }

   }
   
     public function create_rateio($af,$valor,$prod){
    
         $query = $this->pdo->prepare("INSERT INTO `rateio_afiliado`(`produto`, `valor`, `afiliado`) VALUES (:produto, :valor, :afiliado)");
         $query->bindValue(':produto', $prod);
         $query->bindValue(':valor', $valor);
         $query->bindValue(':afiliado', $af);
    
         if($query->execute()){
           return true;
         }else{
           return false;
         }
    
     }



   public function getAfiliadoById($id){

     $query = $this->pdo->prepare("SELECT * FROM `user` WHERE id= :id  ");
     $query->bindValue(':id', $id);
     if($query->execute()){

       $query = $this->pdo->query("SELECT * FROM `user` WHERE id='$id' ");
       $fetch = $query->fetch(PDO::FETCH_OBJ);
       return $fetch;

     }else{
       return false;
     }

   }

   public function countProdsAf($id){

     $query = $this->pdo->prepare("SELECT * FROM `rateio_afiliado` WHERE afiliado= :id");
     $query->bindValue(':id', $id);
     if($query->execute()){

       $query = $this->pdo->query("SELECT * FROM `rateio_afiliado` WHERE afiliado= '$id'");
       $fetch = $query->fetchAll(PDO::FETCH_OBJ);
       return count($fetch);

     }else{
       return false;
     }

   }
   
   public function getPlanosAf($id){

     $query = $this->pdo->prepare("SELECT * FROM `rateio_afiliado` WHERE afiliado= :id  ");
     $query->bindValue(':id', $id);
     $query->execute();
     $retorno = $query->fetchAll();
     if(count($retorno) > 0){

       $query = $this->pdo->query("SELECT * FROM `rateio_afiliado` WHERE afiliado='$id' ");
       return $query;

     }else{
       return false;
     }

   }
   
  public function countNotify($id){
    $query = $this->pdo->prepare("SELECT * FROM `notification_af` WHERE af= :id  ");
    $query->bindValue(':id', $id);
    $query->execute();
    $retorno = $query->fetchAll();
    if(count($retorno) > 0){

      $query = $this->pdo->query("SELECT * FROM `notification_af` WHERE af='$id' ");
      $fetch = $query->fetchAll(PDO::FETCH_OBJ);
      return count($fetch);

    }else{
      return 0;
    }
  }
  
  public function getNotifys($id){
    $query = $this->pdo->prepare("SELECT * FROM `notification_af` WHERE af= :id  ");
    $query->bindValue(':id', $id);
    $query->execute();
    $retorno = $query->fetchAll();
    if(count($retorno) > 0){

      $query = $this->pdo->query("SELECT * FROM `notification_af` WHERE af='$id' ORDER BY id DESC ");
      return $query;

    }else{
      return false;
    }
  }
  
    
  public function getAccesMP($id){
    $query = $this->pdo->prepare("SELECT * FROM `access_mp` WHERE af= :af  ");
    $query->bindValue(':af', $id);
    $query->execute();
    $retorno = $query->fetchAll();
    if(count($retorno) > 0){

      $query = $this->pdo->query("SELECT * FROM `access_mp` WHERE af='$id'");
      $fetch = $query->fetch(PDO::FETCH_OBJ);
      return $fetch;

    }else{
      return false;
    }
  }
   
   
   public function countIndicados($id){

     $query = $this->pdo->prepare("SELECT * FROM `user` WHERE af= :af  ");
     $query->bindValue(':af', $id);
     $query->execute();
     $retorno = $query->fetchAll();
     if(count($retorno) > 0){

       $query = $this->pdo->query("SELECT * FROM `user` WHERE af='$id' ");
       $fetch = $query->fetchAll(PDO::FETCH_OBJ);
       return count($fetch);

     }else{
       return 0;
     }

   }


   public function verifyCredencial($id){

     $query = $this->pdo->prepare("SELECT * FROM `access_mp` WHERE af= :af  ");
     $query->bindValue(':af', $id);
     $query->execute();
     $retorno = $query->fetchAll();
     if(count($retorno) > 0){

       $query = $this->pdo->query("SELECT * FROM `access_mp` WHERE af='$id' ");
       $fetch = $query->fetchAll(PDO::FETCH_OBJ);
       return count($fetch);

     }else{
       return 0;
     }

   }
   
   public function transform_parceiro($id){
       
      if($this->pdo->query("UPDATE `user` SET `parceiro`='1' WHERE id='$id'")){
           return true;
       }else{
           return false;
       }
       
   }

   public function update_credenciais($dados){
       
        if(self::getAccesMP($dados->id)){
        
           if($this->pdo->query("UPDATE `access_mp` SET `acess_token_mp`='$dados->access_token',`refresh_acess_token_mp`='$dados->refresh_token',`id_cliente_mp`='$dados->user_id',`public_key_mp`='$dados->public_key',`expires_in_mp`='$dados->expires_in' WHERE af='$dados->id'")){
               return true;
           }else{
               return false;
           }
           
        }else{
            // insert
            if($this->pdo->query("INSERT INTO `access_mp`(`af`, `acess_token_mp`, `refresh_acess_token_mp`, `id_cliente_mp`, `public_key_mp`, `expires_in_mp`) VALUES ('$dados->id','$dados->access_token','$dados->refresh_token','$dados->user_id','$dados->public_key','$dados->expires_in')")){
               return true;
             }else{
               return false;
             }
        }
       
       
   }

  public function delete_afiliado($id){
       if($this->pdo->query("DELETE FROM `vendas_parceiro` WHERE parceiro='{$id}' ")){
           
           $this->pdo->query("DELETE FROM `notification_af` WHERE af='{$id}' ");
           
           $this->pdo->query("DELETE FROM `rateio_afiliado` WHERE afiliado='{$id}' ");
           
           $this->pdo->query("UPDATE `user` SET `af`='0' WHERE af='{$id}' ");
           
           return true;
       }else{
           return false;
       }
  }


   public function countCliquesLink($id){

     $query = $this->pdo->prepare("SELECT * FROM `cliques_af` WHERE af= :af  ");
     $query->bindValue(':af', $id);
     if($query->execute()){
         
       $cliques_return = 0;
       $date_explode_at = explode('/',date('d/m/Y'));

        $query = $this->pdo->query("SELECT * FROM `cliques_af` WHERE af='$id' ");

         if($query){

               while ($mov = $query->fetch(PDO::FETCH_OBJ)) {

                 $explode_mov = explode('/',$mov->data);

                 if($explode_mov[2] == $date_explode_at[2] && $explode_mov[1] == $date_explode_at[1]){
                   // mes e ano atuais

                     $cliques_return += 1;
                 }

               }

               return $cliques_return;
           }else{
             return 0;
           }
           
           

     }else{
       return 0;
     }

   }

  }
