<?php


 /**
  *
  */
 class Contato extends Conn
 {


      function __construct()
      {
        $this->conn = new Conn;
        $this->pdo  = $this->conn->pdo();
      }




  public function insert($dados){
      
      $ip = self::getip();
      $cidade = self::getcidade($ip);
       
      $query = $this->pdo->prepare("INSERT INTO `contato_gestorlite` (nome,email,whatsapp,assunto,msg,cliente,data,ip,cidade) VALUES (:nome,:email,:whatsapp,:assunto,:msg,:cliente,:data,:ip,:cidade) ");
      $query->bindValue(':nome',$dados->nome);
      $query->bindValue(':email',$dados->email);
      $query->bindValue(':whatsapp',$dados->ddi.$dados->whatsapp);
      $query->bindValue(':assunto',$dados->assunto);
      $query->bindValue(':msg',$dados->msg);
      $query->bindValue(':cliente',$dados->cliente);
      $query->bindValue(':data',date('d/m/Y'));
      $query->bindValue(':ip',$ip);
      $query->bindValue(':cidade',$cidade);


      if($query->execute()){
        return true;
      }else{
        return false;
      }

    
    
  }
  
  
   public function getcidade($ip)
   {

     $json = json_decode(file_get_contents("http://ip-api.com/json/{$ip}"));

     if(isset($json->status)){

       if($json->status == "success"){

         $cidade = $json->city.'/'.$json->region;
         return $cidade;

       }else{
         return 'Desconhecido';
       }

     }else{
       return 'Desconhecido';
     }


   }


   public function getip()
  {
     $ipaddress = '';
     if (isset($_SERVER['HTTP_CLIENT_IP']))
         $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
     else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
         $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
     else if(isset($_SERVER['HTTP_X_FORWARDED']))
         $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
     else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
         $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
     else if(isset($_SERVER['HTTP_FORWARDED']))
         $ipaddress = $_SERVER['HTTP_FORWARDED'];
     else if(isset($_SERVER['REMOTE_ADDR']))
         $ipaddress = $_SERVER['REMOTE_ADDR'];
     else
         $ipaddress = 'UNKNOWN';
     return explode(',',$ipaddress)[0];

   }







 }


?>
