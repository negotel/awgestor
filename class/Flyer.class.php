<?php


 /**
  *
  */
 class Flyer extends Conn
 {


      function __construct()
      {
        $this->conn = new Conn;
        $this->pdo  = $this->conn->pdo();
      }


      public function count_flyer($user){
    
        $query = $this->pdo->query("SELECT * FROM `solicita_banner` WHERE id_user='$user' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        return count($fetch);
        
    
      }
      
      
        public function count_flyer_prossing(){
    
            $query = $this->pdo->query("SELECT * FROM `solicita_banner` WHERE status='Processando' OR status='Pendente' ");
            $fetch = $query->fetchAll(PDO::FETCH_OBJ);
            return count($fetch);
        
       }
  
  
      public function dados_flyer($id){
        $query = $this->pdo->query("SELECT * FROM `solicita_banner` WHERE id='$id' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if(count($fetch)>0){
            $query = $this->pdo->query("SELECT * FROM `solicita_banner` WHERE id='$id' ");
            $fetch = $query->fetch(PDO::FETCH_OBJ);
            return $fetch;
        }
      }
      
      
      public function recusarF($id,$msg){
          if($this->pdo->query("UPDATE `solicita_banner` SET status='Recusado', info_adm='$msg' WHERE id='$id' ")){
              return true;
          }else{
              return false;
          }
      }
     
    public function entregueF($id,$link){
          if($this->pdo->query("UPDATE `solicita_banner` SET status='Entregue', link_download='$link' WHERE id='$id' ")){
              return true;
          }else{
              return false;
          }
      }
      
      public function updateStatus($id,$status){
          if($this->pdo->query("UPDATE `solicita_banner` SET status='{$status}' WHERE id='$id' ")){
              return true;
          }else{
              return false;
          }
      }


    
    public function verify_solicita_mes($user){
           $m = date('m');
           $y = date('Y');
           $query = $this->pdo->query("SELECT * FROM `solicita_banner` WHERE mes='$m' AND ano='$y' AND status !='Recusado' AND id_user='$user' ");
            $fetch = $query->fetchAll(PDO::FETCH_OBJ);
            if(count($fetch)>0){
                return false;
            }else{
                return true;
            }
        
       
    }


   public function add_flyer($dados){
       if(self::verify_solicita_mes($dados->id_user)){
          $query = $this->pdo->prepare("INSERT INTO `solicita_banner` (id_user,cores_principal,type,prazo,valor,free,modelo_exemplo,logo,data,mes,ano,informacoes,imagens,status,info_adm ) VALUES (:id_user,:cores_principal,:type,:prazo,:valor,:free,:modelo_exemplo,:logo,:data,:mes,:ano,:informacoes,:imagens,:status,:info_adm)");
          $query->bindValue(':id_user',$dados->id_user);
          $query->bindValue(':cores_principal',$dados->cores_principal);
          $query->bindValue(':type',$dados->type);
          $query->bindValue(':prazo',$dados->prazo);
          $query->bindValue(':valor',$dados->valor);
          $query->bindValue(':free',$dados->free);
          $query->bindValue(':modelo_exemplo',$dados->modelo_exemplo);
          $query->bindValue(':logo',$dados->logo);
          $query->bindValue(':data',$dados->data);
          $query->bindValue(':mes',$dados->mes);
          $query->bindValue(':ano',$dados->ano);
          $query->bindValue(':informacoes',$dados->informacoes);
          $query->bindValue(':imagens',$dados->imagens);
          $query->bindValue(':status',$dados->status);
          $query->bindValue(':info_adm',$dados->info_adm);

          if($query->execute()){
              return true;
          }else{
              return false;
          }
          
       }else{
           return false;
       }
       
   }

 
  public function list_flyer_all(){

    $query = $this->pdo->query("SELECT * FROM `solicita_banner` ");
    $fetch = $query->fetchAll(PDO::FETCH_OBJ);
    if(count($fetch)>0){

      $query = $this->pdo->query("SELECT * FROM `solicita_banner` ORDER BY id DESC");
      return $query;

    }else{
      return false;
    }


  }



  public function list_flyer($user){

    $query = $this->pdo->query("SELECT * FROM `solicita_banner` WHERE id_user='$user' ");
    $fetch = $query->fetchAll(PDO::FETCH_OBJ);
    if(count($fetch)>0){

      $query = $this->pdo->query("SELECT * FROM `solicita_banner` WHERE id_user='$user' ORDER BY id DESC");
      return $query;

    }else{
      return false;
    }


  }




 }


?>
