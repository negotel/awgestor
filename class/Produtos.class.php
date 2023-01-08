<?php

  /**
   * Produtos
   */
  class Produtos extends Conn
  {

    function __construct()
    {
      $this->conn = new Conn();
      $this->pdo  = $this->conn->pdo();
    }


  public function listar(){

    $query = $this->pdo->query("SELECT * FROM `produtos` ");
    $fetch = $query->fetchAll(PDO::FETCH_OBJ);

    if(count($fetch)>0){

      $query = $this->pdo->query("SELECT * FROM `produtos` ");
      return $query;

    }else{
      return false;
    }

  }

  public function delete_prod($id){
      if($this->pdo->query("DELETE FROM `produtos` WHERE id='{$id}' ")){

        $this->pdo->query("DELETE FROM `license` WHERE produto='{$id}' ");

        return true;
      }else{
        return false;
      }
  }

  public function getAllprodutosActive($user){
        $query = $this->pdo->prepare("SELECT * FROM `produtos_active` WHERE user= :user");
        $query->bindValue(':user', $user);
        if($query->execute()){
    
          $query = $this->pdo->query("SELECT * FROM `produtos_active` WHERE user='$user'  ");
          $fetch = $query->fetchAll(PDO::FETCH_OBJ);
          return $fetch;
    
        }else{
          return false;
        }
  }


  public function getActiveProd($prod,$iduser,$token){
        $query = $this->pdo->prepare("SELECT * FROM `produtos_active` WHERE user= :user AND id_prod= :id_prod AND token= :token");
        $query->bindValue(':user', $iduser);
        $query->bindValue(':id_prod', $prod);
        $query->bindValue(':token', $token);
        if($query->execute()){
    
          $query = $this->pdo->query("SELECT * FROM `produtos_active` WHERE user='$iduser' AND id_prod='$prod' AND token='$token' ");
          $fetch = $query->fetch(PDO::FETCH_OBJ);
          return $fetch;
    
        }else{
          return false;
        }
  }



  public function getActiveProdById($idProd){
        $query = $this->pdo->prepare("SELECT * FROM `produtos_active` WHERE id= :id");
        $query->bindValue(':id', $idProd);
        if($query->execute()){
    
          $query = $this->pdo->query("SELECT * FROM `produtos_active` WHERE id='$idProd'");
          $fetch = $query->fetch(PDO::FETCH_OBJ);
          return $fetch;
    
        }else{
          return false;
        }
  }
  
  
  public function getProdutoById($id){
    $query = $this->pdo->prepare("SELECT * FROM `produtos` WHERE id= :id  ");
    $query->bindValue(':id', $id);
    if($query->execute()){

      $query = $this->pdo->query("SELECT * FROM `produtos` WHERE id='$id' ");
      $fetch = $query->fetch(PDO::FETCH_OBJ);
      return $fetch;

    }else{
      return false;
    }
  }


   public function insert_prod($nome,$descricao,$valor,$imagem,$id_video,$demo){
     $query = $this->pdo->query("INSERT INTO `produtos` (`valor`, `nome`, `img`, `descricao`,`id_video`,`demo`) VALUES ('$valor','$nome','$imagem','$descricao','$id_video','$demo') ");
      if($query){
        return true;
      }else{
        return false;
      }
   }

  public function addProdutoActive($ven,$token,$user,$id_prod,$infos){
      $query = $this->pdo->query("INSERT INTO `produtos_active` (`id_prod`,`user`,`vencimento`,`token`,`infos`) VALUES ('$id_prod','$user','$ven','$token','$infos') ");
      if($query){
        return true;
      }else{
        return false;
      }
  }
  

  public function updateVencimentoActive($ven,$token){
     $query = $this->pdo->query("UPDATE `produtos_active` SET `vencimento`='$ven' WHERE token='$token' ");
      if($query){
        return true;
      }else{
        return false;
      }
   }

   public function update_prod($nome,$descricao,$valor,$imagem,$id_video,$demo,$id){
     $query = $this->pdo->query("UPDATE `produtos` SET `valor`='$valor',`nome`='$nome',`img`='$imagem',`descricao`='$descricao', id_video='$id_video', demo='$demo' WHERE id='$id' ");
      if($query){
        return true;
      }else{
        return false;
      }
   }

  }
