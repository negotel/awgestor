<?php 


   /*
    *
    * Class Xtream connect API
    *
    */
    
 class ApiPainel extends Conn
 {


         function __construct()
      {
        $this->conn = new Conn;
        $this->pdo  = $this->conn->pdo();
      }
      
      public function cont_teste_mes($user_id){
        $query = $this->pdo->query("SELECT * FROM `historic_teste` WHERE id_user='$user_id' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if(count($fetch)>0){
            return count($fetch);
        }else{
            return 0;
        }
      }
      
      public function verific_chave($chave){
        $query = $this->pdo->query("SELECT * FROM `dados_painel` WHERE chave='$chave' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if(count($fetch)>0){
            
             $query = $this->pdo->query("SELECT * FROM `dados_painel` WHERE chave='$chave' LIMIT 1 ");
             $fetch = $query->fetch(PDO::FETCH_OBJ);
              return $fetch;
            
        }else{
            return false;
        }
      }
      
     public function info_credenciais($id,$user){
        $query = $this->pdo->query("SELECT * FROM `dados_painel` WHERE id='$id' AND id_user='$user' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if(count($fetch)>0){
            
             $query = $this->pdo->query("SELECT * FROM `dados_painel` WHERE id='$id' AND id_user='$user' LIMIT 1 ");
             $fetch = $query->fetch(PDO::FETCH_OBJ);
             return $fetch;
            
        }else{
            return false;
        }
      }
      
      public function get_panel($id){
        $query = $this->pdo->query("SELECT * FROM `dados_painel` WHERE id='$id' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if(count($fetch)>0){
            
             $query = $this->pdo->query("SELECT * FROM `dados_painel` WHERE id='$id' LIMIT 1 ");
             $fetch = $query->fetch(PDO::FETCH_OBJ);
             return $fetch;
            
        }else{
            return false;
        }
      }
      
       public function reset_testes(){
          $query = $this->pdo->query("DELETE FROM `historic_teste` ");
          if($query){
              return true;
          }else{
              return false;
          }
      }
      
      
      public function verific_ip($ip,$id_user){
       
        $query = $this->pdo->query("SELECT * FROM `historic_teste` WHERE id_user='$id_user' AND ip='$ip' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if(count($fetch)>0){
           return true;
        }else{
            return false;
        }
      }
      
      
      
      public function verific_mail($email,$id_user,$wpp){
       if($email != "Djonatan@c.us"){
            $query = $this->pdo->query("SELECT * FROM `historic_teste` WHERE id_user='$id_user' AND email='$email' ");
            $fetch = $query->fetchAll(PDO::FETCH_OBJ);
            if(count($fetch)>0){
                
               return false;
              
            }else{
                
                
                $query = $this->pdo->query("SELECT * FROM `historic_teste` WHERE id_user='$id_user' AND whatsapp='$wpp' ");
                $fetch = $query->fetchAll(PDO::FETCH_OBJ);
                if(count($fetch)>0){
                    return false;
                }else{
                    return true;
                }
    
                
            }
       }else{
           return true;
       }
      }
      
      public function verific_cloud_is_fila($idpanel){
       
        $query = $this->pdo->query("SELECT * FROM `fila_cloud` WHERE id_panel='$idpanel'");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if(count($fetch)>0){
           return true;
        }else{
            return false;
        }
      }
      
      public function insert_cloud_fila($idpanel){
          
        if(self::verific_cloud_is_fila($idpanel)){
            return true;
        }else{
            
            $query = $this->pdo->prepare("INSERT INTO `fila_cloud` (id_panel) VALUES (:id_panel) ");
            $query->bindValue(':id_panel',$idpanel);
            
            if($query->execute()){
              return true;
            }else{
              return false;
            }
            
        }
        
      }
      
      public function list_cloud(){
          
            $query = $this->pdo->query("SELECT * FROM `dados_painel` WHERE cloud='1' ");
            $fetch = $query->fetchAll(PDO::FETCH_OBJ);
            if(count($fetch)>0){
    
              $query = $this->pdo->query("SELECT * FROM `dados_painel` WHERE cloud='1'");
              return $query;
    
            }else{
              return false;
            }
      }
      
       public function get_fila_cloud(){
          
            $query = $this->pdo->query("SELECT * FROM `fila_cloud`");
            $fetch = $query->fetchAll(PDO::FETCH_OBJ);
            if(count($fetch)>0){
    
              $query = $this->pdo->query("SELECT * FROM `fila_cloud` ORDER BY id ASC LIMIT 1");
              $fetch = $query->fetch(PDO::FETCH_OBJ);
              return $fetch;
    
            }else{
              return false;
            }
      }
      
      public function list_teste_history($idUser,$limit,$max){
          
        $query = $this->pdo->query("SELECT * FROM `historic_teste` WHERE id_user='$idUser' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if(count($fetch)>0){

          $query = $this->pdo->query("SELECT * FROM `historic_teste` WHERE id_user='$idUser' ORDER BY id DESC LIMIT {$limit},{$max}");
          return $query;

        }else{
          return false;
        }

      }
      
      public function update_message_modelo($content,$modelo,$idUser,$id){
          
          if($modelo == "whatsapp"){
              $query_string = "UPDATE `dados_painel` SET template_zap='$content' WHERE id='$id' AND id_user='$idUser'";
          }else if($modelo == "mail"){
              $query_string = "UPDATE `dados_painel` SET template_mail='$content' WHERE id='$id' AND id_user='$idUser'";
          }
          
          if($this->pdo->query($query_string)){
              return true;
          }else{
              return false;
          }
          
      }
      
      public function credenciais($user_id,$api){
          
          if($api != false){
          
                $query = $this->pdo->query("SELECT * FROM `dados_painel` WHERE id_user='$user_id' AND api='$api'");
                $fetch = $query->fetchAll(PDO::FETCH_OBJ);
                if(count($fetch)>0){
        
                  $query = $this->pdo->query("SELECT * FROM `dados_painel` WHERE id_user='$user_id' AND api='$api'");
                  $fetch = $query->fetch(PDO::FETCH_OBJ);
                  return $fetch;
        
                }else{
                  return false;
                }
        
        
          }else{
              
               $query = $this->pdo->query("SELECT * FROM `dados_painel` WHERE id_user='$user_id'");
                $fetch = $query->fetchAll(PDO::FETCH_OBJ);
                if(count($fetch)>0){
        
                  $query = $this->pdo->query("SELECT * FROM `dados_painel` WHERE id_user='$user_id' ORDER BY id DESC");
                  return $query;
        
                }else{
                  return false;
                }
        
          }
        
      }
      
      public function remove_credenciais($id,$user){
         $query = $this->pdo->query("DELETE FROM `dados_painel` WHERE id='$id' AND id_user='$user'");
         if($query){
             return true;
         }else{
             return false;
         }
      }
      
      
      public function delete_fila_cloud($id){
         $query = $this->pdo->query("DELETE FROM `fila_cloud` WHERE id_panel='$id'");
         if($query){
             return true;
         }else{
             return false;
         }
      }
      
      public function update_credencial($dados){
          
        $query = $this->pdo->prepare("UPDATE `dados_painel` SET cms= :cms, nome= :nome, username= :username, password= :password, limit_testes= :limit_testes, situ_teste= :situ_teste, receber_aviso= :receber_aviso, api= :api, cloud= :cloud WHERE id= :id");
        $query->bindValue(':cms',$dados->cms);
        $query->bindValue(':nome',$dados->nome);
        $query->bindValue(':username',$dados->username);
        $query->bindValue(':password',$dados->password);
        $query->bindValue(':limit_testes',$dados->limit_testes);
        $query->bindValue(':situ_teste',$dados->situ_teste);
        $query->bindValue(':receber_aviso',$dados->receber_aviso);
        $query->bindValue(':api',$dados->api);
        $query->bindValue(':cloud',$dados->cloud);
        $query->bindValue(':id',$dados->id);

        if($query->execute()){
          return true;
        }else{
          return false;
        }
        
      }
      
      public function insert_credencial($dados){
        
        $query = $this->pdo->prepare("INSERT INTO `dados_painel` (chave,cms,nome,username,password,id_user,limit_testes,situ_teste,receber_aviso,api) VALUES (:chave,:cms,:nome,:username,:password,:id_user,:limit_testes,:situ_teste,:receber_aviso,:api) ");
        $query->bindValue(':chave',$dados->chave);
        $query->bindValue(':cms',$dados->cms);
        $query->bindValue(':nome',$dados->nome);
        $query->bindValue(':username',$dados->username);
        $query->bindValue(':password',$dados->password);
        $query->bindValue(':id_user',$dados->id_user);
        $query->bindValue(':limit_testes',$dados->limit_testes);
        $query->bindValue(':situ_teste',$dados->situ_teste);
        $query->bindValue(':receber_aviso',$dados->receber_aviso);
        $query->bindValue(':api',$dados->api);
        
        if($query->execute()){
          return true;
        }else{
          return false;
        }
        
      }
      
      
      public function insert_historic_teste($dados){
        
        $query = $this->pdo->prepare("INSERT INTO `historic_teste` (id_user,nome,email,whatsapp,data,hora,nota,username,password,ip,api_name) VALUES (:id_user,:nome,:email,:whatsapp,:data,:hora,:nota,:username,:password,:ip,:api_name) ");
        $query->bindValue(':id_user',$dados->id_user);
        $query->bindValue(':nome',$dados->nome);
        $query->bindValue(':email',$dados->email);
        $query->bindValue(':whatsapp',$dados->whatsapp);
        $query->bindValue(':data',$dados->data);
        $query->bindValue(':hora',$dados->hora);
        $query->bindValue(':nota',$dados->nota);
        $query->bindValue(':username',$dados->username);
        $query->bindValue(':password',$dados->password);
        $query->bindValue(':ip',$dados->ip);
        $query->bindValue(':api_name',$dados->api_name);

        if($query->execute()){
          return true;
        }else{
          return false;
        }
        
      }
      
   
 }