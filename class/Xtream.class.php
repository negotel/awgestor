<?php 


   /*
    *
    * Class Xtream connect API
    *
    */
    
 class Xtream extends Conn
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
        $query = $this->pdo->query("SELECT * FROM `dados_xtream` WHERE chave='$chave' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if(count($fetch)>0){
            
             $query = $this->pdo->query("SELECT * FROM `dados_xtream` WHERE chave='$chave' LIMIT 1 ");
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
        $query = $this->pdo->query("SELECT * FROM `historic_teste` WHERE id_user='$id_user' AND email='$email' AND whatsapp='$wpp' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if(count($fetch)>0){
            
            
           return false;
          
            
        }else{
            return true;
        }
      }
      
      public function list_teste_history($idUser,$limit){
          
        $query = $this->pdo->query("SELECT * FROM `historic_teste` WHERE id_user='$idUser' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if(count($fetch)>0){

          $query = $this->pdo->query("SELECT * FROM `historic_teste` WHERE id_user='$idUser' ORDER BY id DESC LIMIT {$limit}");
          return $query;

        }else{
          return false;
        }

      }
      
      public function update_message_modelo($content,$modelo,$user_id){
          
          if($modelo == "whatsapp"){
              $query_string = "UPDATE `dados_xtream` SET template_zap='$content' WHERE id_user='$user_id' ";
          }else if($modelo == "mail"){
              $query_string = "UPDATE `dados_xtream` SET template_mail='$content' WHERE id_user='$user_id' ";
          }
          
          if($this->pdo->query($query_string)){
              return true;
          }else{
              return false;
          }
          
      }
      
      public function credenciais($user_id){
          
        $query = $this->pdo->query("SELECT * FROM `dados_xtream` WHERE id_user='$user_id' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if(count($fetch)>0){

          $query = $this->pdo->query("SELECT * FROM `dados_xtream` WHERE id_user='$user_id' LIMIT 1");
          $fetch = $query->fetch(PDO::FETCH_OBJ);
          return $fetch;

        }else{
          return false;
        }
        
      }
      
      public function remove_credenciais($id_user){
         $query = $this->pdo->query("DELETE FROM `dados_xtream` WHERE id_user='$id_user' ");
         if($query){
             return true;
         }else{
             return false;
         }
      }
      
      public function update_credencial($dados){
          
        $query = $this->pdo->prepare("UPDATE `dados_xtream` SET chave= :chave, cms= :cms, username= :username, password= :password, limit_testes= :limit_testes, situ_teste= :situ_teste, receber_aviso= :receber_aviso WHERE id_user= :id_user");
        $query->bindValue(':chave',$dados->chave);
        $query->bindValue(':cms',$dados->cms);
        $query->bindValue(':username',$dados->username);
        $query->bindValue(':password',$dados->password);
        $query->bindValue(':limit_testes',$dados->limit_testes);
        $query->bindValue(':situ_teste',$dados->situ_teste);
        $query->bindValue(':receber_aviso',$dados->receber_aviso);
        $query->bindValue(':id_user',$dados->id_user);

        if($query->execute()){
          return true;
        }else{
          return false;
        }
        
      }
      
      public function insert_credencial($dados){
        
        $query = $this->pdo->prepare("INSERT INTO `dados_xtream` (chave,cms,username,password,id_user,limit_testes,situ_teste,receber_aviso) VALUES (:chave,:cms,:username,:password,:id_user,:limit_testes,:situ_teste,:receber_aviso) ");
        $query->bindValue(':chave',$dados->chave);
        $query->bindValue(':cms',$dados->cms);
        $query->bindValue(':username',$dados->username);
        $query->bindValue(':password',$dados->password);
        $query->bindValue(':id_user',$dados->id_user);
        $query->bindValue(':limit_testes',$dados->limit_testes);
        $query->bindValue(':situ_teste',$dados->situ_teste);
        $query->bindValue(':receber_aviso',$dados->receber_aviso);
        
        if($query->execute()){
          return true;
        }else{
          return false;
        }
        
      }
      
      
      public function insert_historic_teste($dados){
        
        $query = $this->pdo->prepare("INSERT INTO `historic_teste` (id_user,nome,email,whatsapp,data,hora,nota,username,password,ip) VALUES (:id_user,:nome,:email,:whatsapp,:data,:hora,:nota,:username,:password,:ip) ");
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

        if($query->execute()){
          return true;
        }else{
          return false;
        }
        
      }
      
      public function get_saldo($cms,$api_key){
          
        return false;        
        
      }
      
      
      public function getAllPackegs($cms,$username,$password,$trial=0){
          
       
       $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "http://api-panels.gestorlite.com/apps/xtreamUI/?chave=Fkw3MYiK0ya9ZCl0nZ9nZI4t7d5ZDT&panel={$cms}&username={$username}&password={$password}&trial={$trial}&action=getpackages",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);
        return $response;
       
        
      }
      
      public function getAllClients($cms,$username,$password){
          
          
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, "https://api-panels.gestorlite.com/apps/xtreamUI/?chave=Fkw3MYiK0ya9ZCl0nZ9nZI4t7d5ZDT&action=listusers&panel={$cms}&username={$username}&password={$password}");
          curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/32.0.1700.107 Chrome/32.0.1700.107 Safari/537.36');
          curl_setopt($ch, CURLOPT_POST, true);
          curl_setopt($ch, CURLOPT_POSTFIELDS, "");
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_COOKIESESSION, true);
          curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
          curl_setopt($ch, CURLOPT_COOKIEFILE, '/var/www/ip4.x/file/tmp');
          $answer = curl_exec($ch);
    
          return $answer;
    
          curl_close($ch);
           
      }
      
      
      public function testconnection($cms,$api_key){

        return false;
         
      }
      
      
      
      public function gerateste($cms,$username,$password,$package){

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "http://api-panels.gestorlite.com/apps/xtreamUI/?chave=Fkw3MYiK0ya9ZCl0nZ9nZI4t7d5ZDT&panel={$cms}&username={$username}&password={$password}&member_id=0&package={$package}&trial=1&action=createuser",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);
        return $response;
         
      }
      
       public function usercreate($cms,$username,$password,$dados){
          
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "http://api-panels.gestorlite.com/apps/xtreamUI/?chave=Fkw3MYiK0ya9ZCl0nZ9nZI4t7d5ZDT&action=createuser&trial=0&panel={$cms}&username={$username}&password={$password}&package={$dados->package}&usuario={$dados->usuario}&senha={$dados->senha}&member_id=",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);
        return $response;
         
         
      }
      
      public function renewuser($cms,$username,$password,$dados){

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://api-panels.gestorlite.com/apps/xtreamUI/?chave=Fkw3MYiK0ya9ZCl0nZ9nZI4t7d5ZDT&action=renew&panel={$cms}&username={$username}&password={$password}&package={$dados->package}&id_user={$dados->id_user}&user={$dados->usuario}&pass={$dados->senha}&member_id=");
        curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/32.0.1700.107 Chrome/32.0.1700.107 Safari/537.36');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_COOKIESESSION, true);
        curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
        curl_setopt($ch, CURLOPT_COOKIEFILE, '/var/www/ip4.x/file/tmp');
        $answer = curl_exec($ch);

        return $answer;

        curl_close($ch);

      }
      
      
      
      
      
      
      
      
 }