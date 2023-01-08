<?php


 /**
  *
  */
 class API extends Conn
 {

   function __construct()
   {
     $this->conn = new Conn();
     $this->pdo  = $this->conn->pdo();
   }


  public function auth($token){
      
        $query = $this->pdo->query("SELECT * FROM `acesso_app` WHERE token='$token' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if(count($fetch)>0){
            
             $query = $this->pdo->query("SELECT * FROM `acesso_app` WHERE token='$token' LIMIT 1 ");
             $fetch = $query->fetch(PDO::FETCH_OBJ);
             return $fetch;
            
        }else{
            return false;
        }
          
  }
  
 
    public function getusers($request,$user){
         
          $query = $this->pdo->query("SELECT * FROM `clientes` WHERE id_user='$user'");
          $fetch = $query->fetchAll(PDO::FETCH_OBJ);
          if(count($fetch)>0){
    
            $query = $this->pdo->query("SELECT * FROM `clientes` WHERE id_user='$user' ORDER BY STR_TO_DATE(vencimento, '%d/%m/%Y') ");
            $fetch = $query->fetchAll(PDO::FETCH_OBJ);
            
            return json_encode($fetch);
    
          }else{
            return false;
          }
          
     }
     
     public function getuserspaginacao($request,$user){
         
         if(!isset($request->pagina)){
             return json_encode(['erro' => true, 'msg' => 'page not defined']);
         }
         
         if(!isset($request->limit)){
             return json_encode(['erro' => true, 'msg' => 'limit not defined']);
         }
         
         $pc = $request->pagina == "" ? 1 : $request->pagina;
         $total_reg = $request->limit == "" ? 10 : $request->limit;
         
         $inicio = $pc - 1;
         $inicio = $inicio * $total_reg;
         
         
         $query = $this->pdo->query("SELECT * FROM `clientes` WHERE id_user='$user'");
         $fetch = $query->fetchAll(PDO::FETCH_OBJ);
         $todos = count($fetch);
          
         $query__ =  $this->pdo->query("SELECT * FROM `clientes` WHERE id_user='$user' LIMIT $inicio,$total_reg ");
         $users__ = $query__->fetchAll(PDO::FETCH_OBJ);

         return json_encode($users__);
         
     }
     
     
     public function editeprofile($request,$user){
         
         if(!isset($request->senha) || $request->senha == ""){

            $query = $this->pdo->prepare("UPDATE `user` SET nome= :nome, email= :email, telefone= :telefone, ddi= :ddi, dias_aviso_antecipado= :dias, dark= :dark WHERE id= :id");
            $query->bindValue(':nome',$request->nome);
            $query->bindValue(':email',$request->email);
            $query->bindValue(':telefone',$request->telefone);
            $query->bindValue(':ddi',$request->ddi);
            $query->bindValue(':dias',$request->dias);
            $query->bindValue(':dark',$request->dark);
            $query->bindValue(':id',$user);
    
            if($query->execute()){
              return json_encode(['erro' => false, 'msg' => 'profile change']);
            }else{
              return json_encode(['erro' => true, 'msg' => 'profile not change']);
            }
    
          }else{
    
          $query = $this->pdo->prepare("UPDATE `user` SET nome= :nome, email= :email, telefone= :telefone, ddi= :ddi, senha= :senha, dias_aviso_antecipado= :dias, dark= :dark WHERE id= :id");
          $query->bindValue(':nome',$request->nome);
          $query->bindValue(':email',$request->email);
          $query->bindValue(':telefone',$request->telefone);
          $query->bindValue(':ddi',$request->ddi);
          $query->bindValue(':senha',$request->senha);
          $query->bindValue(':dias',$request->dias);
          $query->bindValue(':dark',$request->dark);
          $query->bindValue(':id',$user);
    
          if($query->execute()){
            return json_encode(['erro' => false, 'msg' => 'profile change']);
          }else{
            return json_encode(['erro' => true, 'msg' => 'profile not change']);
          }
    
        }
     }


 }







?>
