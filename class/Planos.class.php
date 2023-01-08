<?php


 /**
  *
  */
 class Planos extends Conn
 {


      function __construct()
      {
        $this->conn = new Conn;
        $this->pdo  = $this->conn->pdo();
      }

    
     public function get_colors_link($id){
         
            $query = $this->pdo->query("SELECT * FROM `config_cores_plano` WHERE id_plano='$id' ");
            $fetch = $query->fetchAll(PDO::FETCH_OBJ);
            if(count($fetch)>0){

              $query = $this->pdo->query("SELECT * FROM `config_cores_plano` WHERE id_plano='$id' ");
              $fetch = $query->fetch(PDO::FETCH_OBJ);
              return $fetch;

            }else{
              return false;
            }

     }

     public function plano_aleatorio($id){
        $query = $this->pdo->query("SELECT * FROM `planos` WHERE id_user='$id' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if(count($fetch)>0){

          $query = $this->pdo->query("SELECT * FROM `planos` WHERE id_user='$id' ORDER BY RAND() LIMIT 1 ");
          $fetch = $query->fetch(PDO::FETCH_OBJ);
          return $fetch;

        }else{
          return false;
        }  
      }
      
      public function plano($id){

            $query = $this->pdo->query("SELECT * FROM `planos` WHERE id='$id' ");
            $fetch = $query->fetchAll(PDO::FETCH_OBJ);
            if(count($fetch)>0){

              $query = $this->pdo->query("SELECT * FROM `planos` WHERE id='$id' ");
              $fetch = $query->fetch(PDO::FETCH_OBJ);
              return $fetch;

            }else{
              return false;
            }


      }


    public function insert($dados){

      $query = $this->pdo->prepare("INSERT INTO `planos` (id_user,nome,valor,dias,template_zap) VALUES (:id_user,:nome,:valor,:dias,:template_zap) ");
      $query->bindValue(':id_user',$dados->id_user);
      $query->bindValue(':nome',$dados->nome);
      $query->bindValue(':valor',str_replace(" ","",str_replace("R$","",str_replace("€","",$dados->valor))));
      $query->bindValue(':dias',$dados->dias);
      $query->bindValue(':template_zap',$dados->template_zap);


      if($query->execute()){
        return true;
      }else{
        return false;
      }

    }


    public function list($user=''){

      $query = $this->pdo->query("SELECT * FROM `planos` WHERE id_user='$user'");
      $fetch = $query->fetchAll(PDO::FETCH_OBJ);
      if(count($fetch)>0){

        $query = $this->pdo->query("SELECT * FROM `planos` WHERE id_user='$user' ORDER BY id DESC ");
        return $query;

      }else{
        return false;
      }

    }

    public function update($dados){

      $query = $this->pdo->prepare("UPDATE `planos` SET nome= :nome, valor= :valor, dias= :dias, template_zap= :template_zap WHERE id= :id");
      $query->bindValue(':nome',$dados->nome);
      $query->bindValue(':valor',str_replace('R$','',str_replace(' ','',str_replace("€","",$dados->valor))));
      $query->bindValue(':dias',$dados->dias);
      $query->bindValue(':template_zap',$dados->template_zap);
      $query->bindValue(':id',$dados->id_plano);

      if($query->execute()){
        return true;
      }else{
        return false;
      }


    }
    
    public function update_banner($dados){

      $query = $this->pdo->prepare("UPDATE `planos` SET banner_link= :banner_link, delete_banner_hash= :delete_banner_hash WHERE id= :id");
      $query->bindValue(':banner_link',$dados->banner_link);
      $query->bindValue(':delete_banner_hash',$dados->delete_banner_hash);
      $query->bindValue(':id',$dados->id);

      if($query->execute()){
        return true;
      }else{
        return false;
      }


    }


    public function delete($id){

      $query = $this->pdo->query("DELETE FROM `planos` WHERE id='$id' ");

      if($query){
        return true;
      }else{
        return false;
      }


    }



 }




?>
