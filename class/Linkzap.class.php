<?php


 /**
  *
  */
 class Linkzap extends Conn
 {


      function __construct()
      {
        $this->conn = new Conn;
        $this->pdo  = $this->conn->pdo();
      }



   public function get_engajamento($user,$today=false){

         if($today == false){
        
              $data1 = date('Y-m-d 00:00:00', strtotime('-3 days', strtotime(date('d-m-Y'))));
              $data2 = date('Y-m-d 23:59:59');
        
              $query = $this->pdo->query("SELECT count(*) as result FROM reference_linkzap INNER JOIN linkzap WHERE linkzap.id_user = '{$user}' AND reference_linkzap.id_link=linkzap.id AND reference_linkzap.create_ref BETWEEN  '{$data1}' AND '{$data2}' LIMIT 1");
              $fetch = $query->fetch(PDO::FETCH_OBJ);
              if(count($fetch)>0){
                    return $fetch->result;
              }else{
                 return 0;
              }
              
         }else{
             
              $data1 = date('Y-m-d 00:00:00');
              $data2 = date('Y-m-d 23:59:59');
        
              $query = $this->pdo->query("SELECT count(*) as result FROM reference_linkzap INNER JOIN linkzap WHERE linkzap.id_user = '{$user}' AND reference_linkzap.id_link=linkzap.id AND reference_linkzap.create_ref BETWEEN  '{$data1}' AND '{$data2}' LIMIT 1");
              $fetch = $query->fetch(PDO::FETCH_OBJ);
              if(count($fetch)>0){
                    return $fetch->result;
              }else{
                 return 0;
              }
              
         }

    }
    
     public function get_browser_name($user_agent){
    
            if (strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR/')) return 'Opera';
            elseif (strpos($user_agent, 'Edge')) return 'Edge';
            elseif (strpos($user_agent, 'Chrome')) return 'Chrome';
            elseif (strpos($user_agent, 'Safari')) return 'Safari';
            elseif (strpos($user_agent, 'Firefox')) return 'Firefox';
            elseif (strpos($user_agent, 'MSIE') || strpos($user_agent, 'Trident/7')) return 'Internet Explorer';
    
            return 'Browser desconhecido';
        }

function getOS($user_agent) { 

    $os_platform    =   "Desconhecido";

    $os_array       =   array(
                            '/windows nt 10/i'     =>  'Windows 10',
                            '/windows nt 6.3/i'     =>  'Windows 8.1',
                            '/windows nt 6.2/i'     =>  'Windows 8',
                            '/windows nt 6.1/i'     =>  'Windows 7',
                            '/windows nt 6.0/i'     =>  'Windows Vista',
                            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                            '/windows nt 5.1/i'     =>  'Windows XP',
                            '/windows xp/i'         =>  'Windows XP',
                            '/windows nt 5.0/i'     =>  'Windows 2000',
                            '/windows me/i'         =>  'Windows ME',
                            '/win98/i'              =>  'Windows 98',
                            '/win95/i'              =>  'Windows 95',
                            '/win16/i'              =>  'Windows 3.11',
                            '/macintosh|mac os x/i' =>  'Mac OS X',
                            '/mac_powerpc/i'        =>  'Mac OS 9',
                            '/linux/i'              =>  'Linux',
                            '/ubuntu/i'             =>  'Ubuntu',
                            '/iphone/i'             =>  'iPhone',
                            '/ipod/i'               =>  'iPod',
                            '/ipad/i'               =>  'iPad',
                            '/android/i'            =>  'Android',
                            '/blackberry/i'         =>  'BlackBerry',
                            '/webos/i'              =>  'Mobile'
                        );

    foreach ($os_array as $regex => $value) { 

        if (preg_match($regex, $user_agent)) {
            $os_platform    =   $value;
        }

    }   

    return $os_platform;

}

   public function get_slug_link($slug,$count=true){
       
        $query = $this->pdo->query("SELECT * FROM `linkzap` WHERE slug='$slug' ");
        if($query){
            $fetch = $query->fetchAll(PDO::FETCH_OBJ);
    
            if(count($fetch)>0){
                
                if($count){
                 $update = $this->pdo->query("UPDATE `linkzap` SET cliques=cliques + 1 WHERE slug='$slug' ");
                }
                
                $query = $this->pdo->query("SELECT * FROM `linkzap` WHERE slug='$slug' ");
                $fetch = $query->fetch(PDO::FETCH_OBJ);
                return $fetch;
    
            }else {
              return false;
            }
        }else{
            return false;
        }
   }
   
   
   
   
   
   public function get_link_by_id($id){
       
        $query = $this->pdo->query("SELECT * FROM `linkzap` WHERE id='$id' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);

        if(count($fetch)>0){
            
            $query = $this->pdo->query("SELECT * FROM `linkzap` WHERE id='$id' ");
            $fetch = $query->fetch(PDO::FETCH_OBJ);
            return $fetch;

        }else {
          return false;
        }

   }
   
   
  public function list_links($user){
      
       $query = $this->pdo->query("SELECT * FROM `linkzap` WHERE id_user='$user' ");
       $fetch = $query->fetchAll(PDO::FETCH_OBJ);

        if(count($fetch)>0){
            
            $query = $this->pdo->query("SELECT * FROM `linkzap` WHERE id_user='$user' ORDER BY cliques DESC");
            return $query;

        }else {
          return false;
        }

      
  }
  
  public function get_reference_os_plus($user){
      
       $query = $this->pdo->query("SELECT * FROM `linkzap` WHERE id_user='$user' ");
       $fetch = $query->fetchAll(PDO::FETCH_OBJ);

        if(count($fetch)>0){
            
            $query = $this->pdo->query("SELECT count(*) as NrVezes, os FROM reference_linkzap as reference INNER JOIN linkzap as link WHERE link.id_user = '{$user}' AND link.id = reference.id_link GROUP BY reference.os ORDER BY NrVezes DESC LIMIT 7 ");
            return $query;

        }else {
          return false;
        }

  }
  
    public function get_reference_city_plus($user){
      
       $query = $this->pdo->query("SELECT * FROM `linkzap` WHERE id_user='$user' ");
       $fetch = $query->fetchAll(PDO::FETCH_OBJ);

        if(count($fetch)>0){
            
            $query = $this->pdo->query("SELECT count(*) as NrVezes, cidade FROM reference_linkzap as reference INNER JOIN linkzap as link WHERE link.id_user = '{$user}' AND link.id = reference.id_link GROUP BY reference.cidade ORDER BY NrVezes DESC LIMIT 7 ");
            return $query;

        }else {
          return false;
        }

  }
  
   public function get_reference_device_plus($user){
      
       $query = $this->pdo->query("SELECT * FROM `linkzap` WHERE id_user='$user' ");
       $fetch = $query->fetchAll(PDO::FETCH_OBJ);

        if(count($fetch)>0){
            
            $query = $this->pdo->query("SELECT count(*) as NrVezes, dispositivo FROM reference_linkzap as reference INNER JOIN linkzap as link WHERE link.id_user = '{$user}' AND link.id = reference.id_link GROUP BY reference.dispositivo ORDER BY NrVezes DESC LIMIT 7 ");
            return $query;

        }else {
          return false;
        }

  }
  
    public function get_reference_plus($user){
      
       $query = $this->pdo->query("SELECT * FROM `linkzap` WHERE id_user='$user' ");
       $fetch = $query->fetchAll(PDO::FETCH_OBJ);

        if(count($fetch)>0){
            
            $query = $this->pdo->query("SELECT count(*) as NrVezes, origem FROM reference_linkzap as reference INNER JOIN linkzap as link WHERE link.id_user = '{$user}' AND link.id = reference.id_link GROUP BY reference.origem  ORDER BY NrVezes DESC LIMIT 7 ");
            return $query;

        }else {
          return false;
        }

      
  }
    
 public function get_num_cliques_mes($user){
     
       $query = $this->pdo->query("SELECT * FROM `linkzap` WHERE id_user='$user' ");
       $fetch = $query->fetchAll(PDO::FETCH_OBJ);

        if(count($fetch)>0){
            
            $query = $this->pdo->query("SELECT count(*) as num FROM reference_linkzap as reference INNER JOIN linkzap as link WHERE reference.id_link = link.id AND link.id_user = '{$user}' AND MONTH(FROM_UNIXTIME(reference.data))= MONTH(CURDATE()) ");
            $fetch = $query->fetchAll(PDO::FETCH_OBJ);
            return $fetch;

        }else {
          return false;
        }

 }

  public function insert_info($dados){ 
      
      $query = $this->pdo->prepare("INSERT INTO `reference_linkzap` (data,id_link,navegador,cidade,dispositivo,origem,os) VALUES (:data,:id_link,:navegador,:cidade,:dispositivo,:origem,:os) ");
      $query->bindValue(':data',$dados->data);
      $query->bindValue(':id_link',$dados->id_link);
      $query->bindValue(':navegador',$dados->navegador);
      $query->bindValue(':cidade',$dados->cidade);
      $query->bindValue(':dispositivo',$dados->dispositivo);
      $query->bindValue(':origem',$dados->origem);
      $query->bindValue(':os',$dados->os);

      if($query->execute()){
        return true;
      }else{
        return false;
      }

  }
  
  
  public function update_link($dados){ 
      
      $query = $this->pdo->prepare("UPDATE `linkzap` SET numero= :numero, nome= :nome, slug= :slug, msg= :msg WHERE id = :id");
      $query->bindValue(':numero',$dados->numero);
      $query->bindValue(':nome',$dados->nome);
      $query->bindValue(':slug',$dados->slug);
      $query->bindValue(':msg',$dados->msg);
      $query->bindValue(':id',$dados->id);

      if($query->execute()){
        return true;
      }else{
        return false;
      }

  }
  
  
  public function count_links($user,$limit_plano,$return=false){
      $query = $this->pdo->query("SELECT * FROM `linkzap` WHERE id_user='$user' ");
      $fetch = $query->fetchAll(PDO::FETCH_OBJ);
      
      if($return){
          
          if(count($fetch) > 0){
              return count($fetch);
          }else{
              return 0;
          }
          
      }else{
           if(count($fetch) >= $limit_plano){
              return false;
          }else{
              return true;
          }
      }
      
     
  }
  

   public function insert_link($dados,$limit_plano){ 
      
      $query = $this->pdo->prepare("INSERT INTO `linkzap` (numero,nome,slug,cliques,msg,id_user) VALUES (:numero,:nome,:slug,:cliques,:msg,:id_user) ");
      $query->bindValue(':numero',$dados->numero);
      $query->bindValue(':nome',$dados->nome);
      $query->bindValue(':slug',$dados->slug);
      $query->bindValue(':cliques',$dados->cliques);
      $query->bindValue(':msg',$dados->msg);
      $query->bindValue(':id_user',$dados->id_user);

        if(self::count_links($dados->id_user,$limit_plano)){
    
          if($query->execute()){
            return true;
          }else{
            return false;
          }
          
        }else{
            return false;
        }
          
     
  }
  
  public function remove_link($id){
      
      $delete = $this->pdo->query("DELETE FROM `linkzap` WHERE id='$id' ");
      $delete = $this->pdo->query("DELETE FROM `reference_linkzap` WHERE id_link='$id' ");
      
      if($delete){
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
