<?php


 class VpsOvh extends Conn
 { 


      function __construct()
      {
        $this->conn = new Conn;
        $this->pdo  = $this->conn->pdo();
      }


    public function list_vps(){
        
        
        $query = $this->pdo->query("SELECT * FROM `vps` WHERE service='ovh'");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);

        if(count($fetch)>0){

          $query = $this->pdo->query("SELECT * FROM `vps` WHERE service='ovh'");
          return $query;

        }else {
          return false;
        }

        
    }


}