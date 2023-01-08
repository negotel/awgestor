<?php


 /**
  *
  */
 class Logs extends Conn
 {


      function __construct()
      {
        $this->conn = new Conn;
        $this->pdo  = $this->conn->pdo();
      }

    public function get_browser_name($user_agent){

        if (strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR/')) return 'Browser Opera';
        elseif (strpos($user_agent, 'Edge')) return 'Browser Edge';
        elseif (strpos($user_agent, 'Chrome')) return 'Browser Chrome';
        elseif (strpos($user_agent, 'Safari')) return 'Browser Safari';
        elseif (strpos($user_agent, 'Firefox')) return 'Browser Firefox';
        elseif (strpos($user_agent, 'MSIE') || strpos($user_agent, 'Trident/7')) return 'Browser Internet Explorer';

        return 'Browser desconhecido';
    }


    public function get_browser_name_2($user_agent){

        if (strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR/')) return 'opera';
        elseif (strpos($user_agent, 'Edge')) return 'edge';
        elseif (strpos($user_agent, 'Chrome')) return 'chrome';
        elseif (strpos($user_agent, 'Safari')) return 'safari';
        elseif (strpos($user_agent, 'Firefox')) return 'firefox';
        elseif (strpos($user_agent, 'MSIE') || strpos($user_agent, 'Trident/7')) return 'internet-explorer';

        return 'desconhecido';
    }


    public function get_client_ip(){
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
          return $ipaddress;
      }


  public function count_logs($user){

    $query = $this->pdo->query("SELECT * FROM `logs` WHERE id_user='$user' ");
    $fetch = $query->fetchAll(PDO::FETCH_OBJ);
    return count($fetch);


  }



  public function log($user,$ativdade){


       // contar quantos registros o user tem
       $num = self::count_logs($user);

       if($num>9){
         $this->pdo->query("DELETE FROM `logs` WHERE id_user='$user' ORDER BY id ASC LIMIT 1");
       }

      $data = date('d/m/Y');
      $hora = date('H:i');

      $browser_2 = self::get_browser_name_2($_SERVER['HTTP_USER_AGENT']);
      $browser   = self::get_browser_name($_SERVER['HTTP_USER_AGENT']);
      $ip        = self::get_client_ip();
      $ativdade0 = $ativdade.' - '.$browser.' ('.$ip.') ';

      $query = $this->pdo->query("INSERT INTO `logs`(`id_user`, `data`, `hora`, `browser`, `atividade`) VALUES ('$user','$data','$hora','$browser_2','$ativdade0') ");

      if($query){
        return true;
      }else{
        return false;
      }

  }


  public function list_logs($user){

    $query = $this->pdo->query("SELECT * FROM `logs` WHERE id_user='$user' ");
    $fetch = $query->fetchAll(PDO::FETCH_OBJ);
    if(count($fetch)>0){

      $query = $this->pdo->query("SELECT * FROM `logs` WHERE id_user='$user' ORDER BY id DESC LIMIT 20");
      return $query;

    }else{
      return false;
    }


  }




 }


?>
