<?php

 /**
  * Delivery
  */
 class Delivery extends Conn
 {

   function __construct()
   {
     $this->conn = new Conn();
     $this->pdo  = $this->conn->pdo();
   }
   
      public function insert_delivery($nome,$plano,$text_delivery,$user){
       if($this->pdo->query("INSERT INTO `delivery_aut` (nome,plano_id,text_delivery,id_user) VALUES ('$nome','$plano','$text_delivery','$user') ")){
           return true;
       }else{
           return false;
       }
   }


   public function get_deliverys($user){
     $query = $this->pdo->query("SELECT * FROM `delivery_aut` WHERE id_user='$user'");
     $fetch = $query->fetchAll(PDO::FETCH_OBJ);
     if(count($fetch)>0){
       $query = $this->pdo->query("SELECT * FROM `delivery_aut` WHERE id_user='$user' ORDER BY id DESC");
       return $query;
     }else{
       return false;
     }
   }
   
   public function get_subdeliverys($id,$user){
       
       if(self::get_infoDelivery($id,$user)){
             $query = $this->pdo->query("SELECT * FROM `sub_delivery_aut` WHERE id_delivery='$id,$user' ORDER BY id DESC");
             $fetch = $query->fetchAll(PDO::FETCH_OBJ);
             if(count($fetch)>0){
               $query = $this->pdo->query("SELECT * FROM `sub_delivery_aut` WHERE id_delivery='$id,$user' ORDER BY id DESC");
               return $query;
             }else{
               return false;
             }
       }else{
           return false;
       }
   }
   
      public function get_subdeliverysEnviados($id,$user){
       
       if(self::get_infoDelivery($id,$user)){
             $query = $this->pdo->query("SELECT * FROM `sub_delivery_aut` WHERE id_delivery='$id,$user' AND enviado='1' ORDER BY id DESC");
             $fetch = $query->fetchAll(PDO::FETCH_OBJ);
             if(count($fetch)>0){
               $query = $this->pdo->query("SELECT * FROM `sub_delivery_aut` WHERE id_delivery='$id,$user' AND enviado='1' ORDER BY id DESC");
               return $query;
             }else{
               return false;
             }
       }else{
           return false;
       }
   }
   
   
   public function delete_subdelivery($id,$delivery,$user){
       if(self::get_infoDelivery($delivery,$user)){
           
           if($this->pdo->query("DELETE FROM `sub_delivery_aut` WHERE id='$id' ")){
               return true;
           }else{
               return false;
           }
           
       }else{
           return false;
       }
   }
   
   public function delete_delivery($id,$user){
       if(self::get_infoDelivery($id,$user)){
           
           if($this->pdo->query("DELETE FROM `delivery_aut` WHERE id='$id' ")){
               $this->pdo->query("DELETE FROM `sub_delivery_aut` WHERE id_delivery='$id' ");
               return true;
           }else{
               return false;
           }
           
       }else{
           return false;
       }
   }
   
         public function get_subdeliverysNEnviados($id,$user){
             
             if(!is_numeric($id)){
                 return 'negado';
             }
       
               if(self::get_infoDelivery($id,$user)){
                     $query = $this->pdo->query("SELECT * FROM `sub_delivery_aut` WHERE id_delivery='$id' AND enviado='0' ORDER BY id DESC");
                     $fetch = $query->fetchAll(PDO::FETCH_OBJ);
                     if(count($fetch)>0){
                       $query = $this->pdo->query("SELECT * FROM `sub_delivery_aut` WHERE id_delivery='$id' AND enviado='0' ORDER BY id DESC");
                       return $query;
                     }else{
                       return false;
                     }
               }else{
                   return 'negado';
               }
           }
   
   
   public function insert_subdelivery($content,$delivery,$reverse=0){
       if($this->pdo->query("INSERT INTO `sub_delivery_aut` (id_delivery,content,enviado,reverse) VALUES ('$delivery','$content','0','$reverse') ")){
           return true;
       }else{
           return false;
       }
   }
   
   public function get_infoDelivery($id,$user){
        if(!is_numeric($id)){
             return false;
         }
         
     $query = $this->pdo->query("SELECT * FROM `delivery_aut` WHERE id='$id' AND id_user='$user'");
     $fetch = $query->fetchAll(PDO::FETCH_OBJ);
     if(count($fetch)>0){
       $query = $this->pdo->query("SELECT * FROM `delivery_aut` WHERE id='$id' AND id_user='$user' LIMIT 1");
       $fetch = $query->fetch(PDO::FETCH_OBJ);
       return $fetch;
     }else{
       return false;
     }
   }
   
      public function get_deliveryByPlano($plano,$user){
    
            
             $query = $this->pdo->query("SELECT * FROM `delivery_aut` WHERE plano_id='$plano' AND id_user='$user'");
             $fetch = $query->fetchAll(PDO::FETCH_OBJ);
             if(count($fetch)>0){
                 
               $query = $this->pdo->query("SELECT * FROM `delivery_aut` WHERE plano_id='$plano' AND id_user='$user' LIMIT 1");
               $fetch = $query->fetch(PDO::FETCH_OBJ);
               return $fetch;
               
             }else{
               return false;
             }
    
            
       }
       
        public function get_subdeliveryByDelivery($delivery){
    
            
             $query = $this->pdo->query("SELECT * FROM `sub_delivery_aut` WHERE id_delivery='$delivery'");
             $fetch = $query->fetchAll(PDO::FETCH_OBJ);
             if(count($fetch)>0){
                 
               $query = $this->pdo->query("SELECT * FROM `sub_delivery_aut` WHERE id_delivery='$delivery' LIMIT 1");
               $fetch = $query->fetch(PDO::FETCH_OBJ);
               return $fetch;
               
             }else{
               return false;
             }
    
            
       }
       
       
 
       
    public function get_infoSubDelivery($id,$deliveryId,$user){
        if(!is_numeric($id)){
             return false;
         }
         
         if(!is_numeric($deliveryId)){
                 return false;
         }
             
        if(self::get_infoDelivery($deliveryId,$user)){
            
             $query = $this->pdo->query("SELECT * FROM `sub_delivery_aut` WHERE id='$id'");
             $fetch = $query->fetchAll(PDO::FETCH_OBJ);
             if(count($fetch)>0){
               $query = $this->pdo->query("SELECT * FROM `sub_delivery_aut` WHERE id='$id'");
               $fetch = $query->fetch(PDO::FETCH_OBJ);
               return $fetch;
             }else{
               return false;
             }
             
        }else{
            return false;
        }
        

   }
   
   public function update_subdelivery($id,$content,$deliveryId,$user,$reverse){
       
         if(!is_numeric($id)){
             return false;
         }
         
       if(self::get_infoDelivery($deliveryId,$user)){
            
               if($this->pdo->query("UPDATE `sub_delivery_aut` SET content='$content', reverse='$reverse' WHERE id='$id' ")){
                   return true;
               }else{
                   return false;
               }
             
        }else{
            return false;
        }
   }
   
   public function update_delivery($dados,$user){
       if(self::get_infoDelivery($dados->id,$user)){
           
            if($this->pdo->query("UPDATE `delivery_aut` SET nome='{$dados->nome}',plano_id='$dados->plano_id',text_delivery='$dados->text_delivery',situ='$dados->situ' WHERE id='$dados->id' ")){
                   return true;
               }else{
                   return false;
               }
           
       }else{
           return false;
       }
   }

   public function count_subdelivery($delivery){

     $query = $this->pdo->query("SELECT count(*) as num FROM `sub_delivery_aut` WHERE id_delivery='$delivery'");
     $fetch = $query->fetch(PDO::FETCH_OBJ);
     return $fetch;

   }
   
   public function count_subdelivery_not_send($delivery){

     $query = $this->pdo->query("SELECT count(*) as num FROM `sub_delivery_aut` WHERE id_delivery='$delivery' AND enviado='0'");
     $fetch = $query->fetch(PDO::FETCH_OBJ);
     return $fetch;

   }

   public function count_delivery($user){

     $query = $this->pdo->query("SELECT * FROM `delivery_aut` WHERE id_user='$user'");
     $fetch = $query->fetchAll(PDO::FETCH_OBJ);
     return count($fetch);

   }

   public function verific_deliverys($num_perm,$user){

     $numdeliverys = self::count_delivery($user);

     if($numdeliverys < $num_perm ){
       return false;
     }else{
       return true;
     }

   }

 }

 ?>
