<?php


 /**
  *
  */
 class Traffic extends Conn
 {


      function __construct()
      {
        $this->conn = new Conn;
        $this->pdo  = $this->conn->pdo();
      }


      public function count_traffic($user){
    
        $query = $this->pdo->query("SELECT * FROM `solicita_traffic` WHERE id_user='$user' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        return count($fetch);
        
    
      }
      
      
        public function count_traffic_prossing(){
    
            $query = $this->pdo->query("SELECT * FROM `solicita_traffic` WHERE status='Processando' ");
            $fetch = $query->fetchAll(PDO::FETCH_OBJ);
            return count($fetch);
        
       }
  
  
      public function dados_traffic($id){
        $query = $this->pdo->query("SELECT * FROM `solicita_traffic` WHERE id='$id' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if(count($fetch)>0){
            $query = $this->pdo->query("SELECT * FROM `solicita_traffic` WHERE id='$id' ");
            $fetch = $query->fetch(PDO::FETCH_OBJ);
            return $fetch;
        }
      }
      
      
      public function updateStatus($id,$status){
          if($this->pdo->query("UPDATE `solicita_traffic` SET status='{$status}' WHERE id='$id' ")){
              return true;
          }else{
              return false;
          }
      }


    
    public function verify_solicita_today($user){
        $data = date('d/m/Y');
           $query = $this->pdo->query("SELECT * FROM `solicita_traffic` WHERE data='$data' AND id_user='$user' ");
            $fetch = $query->fetchAll(PDO::FETCH_OBJ);
            if(count($fetch)>0){
                return false;
            }else{
                return true;
            }
        
       
    }


   public function add_traffic($dados){
       if(self::verify_solicita_today($dados->id_user)){
          $query = $this->pdo->prepare("INSERT INTO `solicita_traffic` (id_user,link,tipo_link,origem,keywords,status,qtd_acesso,percent_desktop,percent_mobile,data,pais) VALUES (:id_user,:link,:tipo_link,:origem,:keywords,:status,:qtd_acesso,:percent_desktop,:percent_mobile,:data,:pais)");
          $query->bindValue(':id_user',$dados->id_user);
          $query->bindValue(':link',$dados->link);
          $query->bindValue(':tipo_link',$dados->tipo_link);
          $query->bindValue(':origem',$dados->origem);
          $query->bindValue(':keywords',$dados->keywords);
          $query->bindValue(':status',$dados->status);
          $query->bindValue(':qtd_acesso',$dados->qtd_acesso);
          $query->bindValue(':percent_desktop',$dados->percent_desktop);
          $query->bindValue(':percent_mobile',$dados->percent_mobile);
          $query->bindValue(':data',$dados->data);
          $query->bindValue(':pais',$dados->pais);

          if($query->execute()){
              return true;
          }else{
              return false;
          }
          
       }else{
           return false;
       }
       
   }

 
  public function list_traffic_all(){

    $query = $this->pdo->query("SELECT * FROM `solicita_traffic` ");
    $fetch = $query->fetchAll(PDO::FETCH_OBJ);
    if(count($fetch)>0){

      $query = $this->pdo->query("SELECT * FROM `solicita_traffic` ORDER BY id DESC");
      return $query;

    }else{
      return false;
    }


  }



  public function list_traffic($user){

    $query = $this->pdo->query("SELECT * FROM `solicita_traffic` WHERE id_user='$user' ");
    $fetch = $query->fetchAll(PDO::FETCH_OBJ);
    if(count($fetch)>0){

      $query = $this->pdo->query("SELECT * FROM `solicita_traffic` WHERE id_user='$user' ORDER BY id DESC");
      return $query;

    }else{
      return false;
    }


  }




 }


?>
