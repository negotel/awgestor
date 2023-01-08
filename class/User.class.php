<?php


 /**
  *
  */
 class User extends Conn
 {


      function __construct()
      {
        $this->conn = new Conn;
        $this->pdo  = $this->conn->pdo();
      }


    public function list_users(){

        $query = $this->pdo->query("SELECT * FROM `user` ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);

        if(count($fetch)>0){

          $query = $this->pdo->query("SELECT * FROM `user`");
          return $query;

        }else {
          return false;
        }

      }
      
            
      public function update_GoogleAuth($two_facto, $id, $secret){
          
          if($this->pdo->query("UPDATE `user` SET `google_auth_code`='$secret', two_facto='$two_facto' WHERE id='$id'")){
              return true;
          }else{
              return false;
          }
      }

    
    public function getmoeda($id){

      $query = $this->pdo->query("SELECT * FROM `moeda` WHERE id='$id' ");
      $fetch = $query->fetchAll(PDO::FETCH_OBJ);

      if(count($fetch)>0){

        $query = $this->pdo->query("SELECT * FROM `moeda` WHERE id='$id' LIMIT 1");
        $fetch = $query->fetch(PDO::FETCH_OBJ);
        return $fetch;
      }else{
        return false;
      }


    }


    public function getUserCheck($info){

      $query = $this->pdo->query("SELECT * FROM `user` WHERE id='$info' OR email='$info' ");
      $fetch = $query->fetchAll(PDO::FETCH_OBJ);

      if(count($fetch)>0){

        $query = $this->pdo->query("SELECT * FROM `user` WHERE id='$info' OR email='$info'  LIMIT 1");
        $fetch = $query->fetch(PDO::FETCH_OBJ);
        return $fetch;
      }else{
        return false;
      }


    }

  public function confirm_contact($type,$user){
      
    $query = $this->pdo->prepare("UPDATE `user` SET {$type}= :{$type} WHERE id= :id");
    $query->bindValue(':'.$type,1);
    $query->bindValue(':id',$user);

    if($query->execute()){
      return true;
    }else{
      return false;
    }
      
  }

  public function limit_plano($plano){

     $query = $this->pdo->query("SELECT * FROM `plano_user_gestor` WHERE id='$plano' ");
     $fetch = $query->fetch(PDO::FETCH_OBJ);

     if($fetch->id){
       return $fetch->limit_cli;
     }else {
       return false;
     }


  }

  public function verific_pre_cadastro($email){

    $q = $this->pdo->prepare("SELECT * FROM `pre_cadastro_gestor` WHERE email= :email");
    $q->bindValue(':email', $email);
    $q->execute();
    $fetch = $q->fetchAll(PDO::FETCH_OBJ);
    if(count($fetch)>0){
      return true;
    }else{
      return false;
    }

  }

  public function list_5_days($data){

    $query = $this->pdo->query("SELECT * FROM `user` WHERE vencimento='$data' ");
    $fetch = $query->fetchAll(PDO::FETCH_OBJ);

    if(count($fetch)>0){

      $query = $this->pdo->query("SELECT * FROM `user` WHERE vencimento='$data' ");
      return $query;

    }else {
      return false;
    }

  }
  
  public function delete_cvd($id){
  if( $this->pdo->query("DELETE FROM `convidade_acesso` WHERE id='$id' ")){
      return true;
    }else{
      return false;
    } 
  }
  
  public function add_cvd($dados,$id){
      
    $query = $this->pdo->prepare("INSERT INTO `convidade_acesso`  (nome,email,senha,id_user) VALUES (:nome,:email,:senha,:id_user)");
    $query->bindValue(':nome',$dados->nome);
    $query->bindValue(':email',$dados->email);
    $query->bindValue(':senha',$dados->senha);
    $query->bindValue(':id_user',$id);

    if($query->execute()){
      return true;
    }else{
      return false;
    } 
    
  }


  public function create($dados,$vencimento='00/00/0000',$idp=0,$id_rev=0,$indicado=0,$af=0)  {

    $query = $this->pdo->prepare("INSERT INTO `user` (`nome`, `email`, `telefone`, `ddi` , `senha`, `id_plano`, `token_access`, `vencimento`, `dias_aviso_antecipado`,`lancar_finan`,`dark`,`somente_finan`,`gera_fat_cli`,`id_rev`,`indicado`,`af`) VALUES (:nome,:email,:telefone,:ddi,:senha,:id_plano,:token_access,:vencimento,:dias_aviso_antecipado,:lancar_finan,:dark,:somente_finan,:gera_fat_cli,:id_rev,:indicado,:af)");
    $query->bindValue(':nome',$dados->nome);
    $query->bindValue(':email',$dados->email);
    $query->bindValue(':telefone',$dados->telefone);
    $query->bindValue(':ddi',$dados->ddi);
    $query->bindValue(':senha',$dados->senha);
    $query->bindValue(':id_plano',$idp);
    $query->bindValue(':token_access','0');
    $query->bindValue(':vencimento',$vencimento);
    $query->bindValue(':dias_aviso_antecipado','3');
    $query->bindValue(':lancar_finan','0');
    $query->bindValue(':dark','0');
    $query->bindValue(':somente_finan','0');
    $query->bindValue(':gera_fat_cli','0');
    $query->bindValue(':id_rev',$id_rev);
    $query->bindValue(':indicado',$indicado);
    $query->bindValue(':af',$af);

    if($query->execute()){
      return true;
    }else{
      return false;
    }


  }
  
    public function insert_lasted_conversion($dados)  {

    $query = $this->pdo->prepare("INSERT INTO `lasted_conversion` (`nome`, `produto`, `data`, `id_user` ) VALUES (:nome, :produto, :data, :id_user)");
    $query->bindValue(':nome',$dados->nome);
    $query->bindValue(':produto',$dados->produto);
    $query->bindValue(':data',date('m/d/Y H:i:s'));
    $query->bindValue(':id_user',$dados->id_user);

    if($query->execute()){
      return true;
    }else{
      return false;
    }


  }
  
  
  public function renew_rev($plano,$vencimento,$idCli){
      
    $query = $this->pdo->prepare("UPDATE `user` SET id_plano= :id_plano, vencimento= :vencimento WHERE id= :id");
    $query->bindValue(':id_plano',$plano);
    $query->bindValue(':vencimento',$vencimento);
    $query->bindValue(':id',$idCli);

    if($query->execute()){
      return true;
    }else{
      return false;
    }
      
      
  }




  public function vencimento($vencimento){

    $ven_user = "";

    // verificar data do vencimento
    $explodeData_user  = explode('/',$vencimento);
    $explodeData2_user = explode('/',date('d/m/Y'));
    $dataVen_user      = $explodeData_user[2].$explodeData_user[1].$explodeData_user[0];
    $dataHoje_user     = $explodeData2_user[2].$explodeData2_user[1].$explodeData2_user[0];

    if($dataVen_user == $dataHoje_user){
        $ven_user = "ven_today";
    }else if($dataHoje_user > $dataVen_user){

       if($vencimento == "00/00/0000"){
         $ven_user = "vencido";
       }else{
         $ven_user = "vencido";
       }

    }

    return $ven_user;

  }


  public function verific_email($email){

    $q = $this->pdo->prepare("SELECT * FROM `user` WHERE email= :email");
    $q->bindValue(':email', $email);
    $q->execute();
    $fetch = $q->fetchAll(PDO::FETCH_OBJ);
    if(count($fetch)>0){
      return true;
    }else{
      return false;
    }

  }



  public function verific_access($tk,$id){

    $q = $this->pdo->prepare("SELECT * FROM `user` WHERE token_access= :token_access AND id= :id");
    $q->bindValue(':token_access', $tk);
    $q->bindValue(':id', $id);
    $q->execute();
    $fetch = $q->fetchAll(PDO::FETCH_OBJ);
    if(count($fetch)>0){
      return true;
    }else{
      return false;
    }

  }
  
  public function dados_por_email($email){

    $query = $this->pdo->query("SELECT * FROM `user` WHERE email='$email' ");
    $fetch = $query->fetchAll(PDO::FETCH_OBJ);
    if(count($fetch)>0){

      $query = $this->pdo->query("SELECT * FROM `user` WHERE email='$email' ");
      $fetch = $query->fetch(PDO::FETCH_OBJ);
      return $fetch;

    }else{
      return false;
    }


  }
  
  public function add_vps_us($id_vps,$id_user,$info){
      $query = $this->pdo->query("INSERT INTO `vps_users` (id_vps,id_user,infos) VALUES ('$id_vps','$id_user','$info') ");
      if($query){
          return true;
      }else{
          return false;
      }
  }
  
  
  public function color_vencimento($vencimento){
      
      if($vencimento != 0 && $vencimento != ""){
      
            $explodeData  = explode('/',$vencimento);
            $explodeData2 = explode('/',date('d/m/Y'));
            $dataVen      = $explodeData[2].$explodeData[1].$explodeData[0];
            $dataHoje     = $explodeData2[2].$explodeData2[1].$explodeData2[0];

            $Pvencimento = str_replace('/','-',$vencimento);
            $timestamp   = strtotime("-3 days",strtotime($Pvencimento));
            $venX        = date('d/m/Y', $timestamp);

            $timestamp   = strtotime("-2 days",strtotime($Pvencimento));
            $venY        = date('d/m/Y', $timestamp);

            $timestamp   = strtotime("-1 days",strtotime($Pvencimento));
            $venZ        = date('d/m/Y', $timestamp);

            if($dataVen == $dataHoje){
                $ven = "<b class='text-info'>{$vencimento}</b>";
            }
           if($dataHoje > $dataVen){
                $ven = "<b class='text-danger'>{$vencimento}</b>";
            }
            if($dataHoje < $dataVen && $venX != date('d/m/Y') && $venY != date('d/m/Y') && $venZ != date('d/m/Y')){
                $ven = "<b class='text-success'>{$vencimento}</b>";
            }
           if($venX == date('d/m/Y') || $venY == date('d/m/Y') || $venZ == date('d/m/Y')){
              $ven = "<b class='text-warning'>{$vencimento}</b>";
          }
          
      }else{
                $ven = "<span class='text-info'>Aguardando </span>";
          }
          
          return $ven;
  }
  
  public function remove_vps_us($id,$id_vps){
    if($this->pdo->query("DELETE FROM `vps_users` WHERE id_user='$id' AND id_vps='$id_vps' ")){
        return true;
    }else{
        return false;
    }
  }

  public function vps_user($id=false,$id_vps=false){
      
      if($id != false && $id_vps == false){

        $query = $this->pdo->query("SELECT * FROM `vps_users` WHERE id_user='$id' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if(count($fetch)>0){
    
          $query = $this->pdo->query("SELECT * FROM `vps_users` WHERE id_user='$id' ");
          $fetch = $query->fetch(PDO::FETCH_OBJ);
          return $fetch;
    
        }else{
          return false;
        }
    }else if($id_vps != false && $id == false){
        $query = $this->pdo->query("SELECT * FROM `vps_users` WHERE id_vps='$id_vps' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if(count($fetch)>0){
    
          $query = $this->pdo->query("SELECT * FROM `vps_users` WHERE id_vps='$id_vps' ");
          $fetch = $query->fetch(PDO::FETCH_OBJ);
          return $fetch;
    
        }else{
          return false;
        }
    }else if($id_vps != false && $id != false){
        $query = $this->pdo->query("SELECT * FROM `vps_users` WHERE id_vps='$id_vps' AND id_user='$id' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if(count($fetch)>0){
    
          $query = $this->pdo->query("SELECT * FROM `vps_users` WHERE id_vps='$id_vps' AND id_user='$id' ");
          $fetch = $query->fetch(PDO::FETCH_OBJ);
          return $fetch;
    
        }else{
          return false;
        }
    }
    
    

  }
  
  public function list_convidados($id){
      
        $query = $this->pdo->query("SELECT * FROM `convidade_acesso` WHERE id_user='$id'");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
    
        if(count($fetch)>0){
    
          $query = $this->pdo->query("SELECT * FROM `convidade_acesso` WHERE id_user='$id' ORDER BY id DESC");
          return $query;
    
        }else {
          return false;
        }
  }
  
  public function dados_cvd($id){
      
    $query = $this->pdo->query("SELECT * FROM `convidade_acesso` WHERE id='$id' ");
    $fetch = $query->fetchAll(PDO::FETCH_OBJ);
    if(count($fetch)>0){

      $query = $this->pdo->query("SELECT * FROM `convidade_acesso` WHERE id='$id' ");
      $fetch = $query->fetch(PDO::FETCH_OBJ);
      return $fetch;

    }else{
      return false;
    }

  }


  public function dados($id){

    $query = $this->pdo->query("SELECT * FROM `user` WHERE id='$id' ");
    $fetch = $query->fetchAll(PDO::FETCH_OBJ);
    if(count($fetch)>0){

      $query = $this->pdo->query("SELECT * FROM `user` WHERE id='$id' ");
      $fetch = $query->fetch(PDO::FETCH_OBJ);
      return $fetch;

    }else{
      return false;
    }


  }
  
  public function delete_user($id){
      if($query = $this->pdo->query("DELETE FROM `user` WHERE id= {$id}")){
         
         $this->pdo->query("DELETE FROM `faturas_user` WHERE id_user= {$id}");
         
         $this->pdo->query("DELETE FROM `financeiro` WHERE id_user= {$id}");
         
         $this->pdo->query("DELETE FROM `logs` WHERE id_user= {$id}");
         
         $this->pdo->query("DELETE FROM `clientes` WHERE id_user= {$id}");
         
         $this->pdo->query("DELETE FROM `planos` WHERE id_user= {$id}");
         
         $this->pdo->query("DELETE FROM `id_user` WHERE id_user= {$id}");
         
         $this->pdo->query("DELETE FROM `dados_mp_user` WHERE id_user= {$id}");
         
         $this->pdo->query("DELETE FROM `whats_api` WHERE id_user= {$id}");
         
         $this->pdo->query("DELETE FROM `disparos_zap` WHERE id_user= {$id}");
         
         $this->pdo->query("DELETE FROM `lasted_conversion` WHERE id_user= {$id}");
         
         return true;
          
      }else{
          return false;
      }
  }
  
  
   public function update_user_admin($nome,$email,$telefone,$senha,$vencimento,$id,$plano){

        $query = $this->pdo->prepare("UPDATE `user` SET nome= :nome, email= :email, telefone= :telefone, senha= :senha, vencimento= :vencimento, id_plano= :id_plano WHERE id= :id");
        $query->bindValue(':nome',$nome);
        $query->bindValue(':email',$email);
        $query->bindValue(':telefone',$telefone);
        $query->bindValue(':senha',$senha);
        $query->bindValue(':vencimento',$vencimento);
        $query->bindValue(':id_plano',$plano);
        $query->bindValue(':id',$id);

        if($query->execute()){
          return true;
        }else{
          return false;
        }


  }


  public function update_vencimento($vencimento,$id,$plano){

        $query = $this->pdo->prepare("UPDATE `user` SET id_plano= :id_plano, vencimento= :vencimento WHERE id= :id");
        $query->bindValue(':id_plano',$plano);
        $query->bindValue(':vencimento',$vencimento);
        $query->bindValue(':id',$id);

        if($query->execute()){
          return true;
        }else{
          return false;
        }


  }

  public function update_finan_lanc($dados){
      
      $query = $this->pdo->prepare("UPDATE `user` SET lancar_finan= :lancar_finan WHERE id= :id");
      $query->bindValue(':lancar_finan',$dados->finan);
      $query->bindValue(':id',$dados->id);

      if($query->execute()){
        return true;
      }else{
        return false;
      }
  }
  
    public function removeLastedConversion($id){
        if($this->pdo->query("DELETE FROM `lasted_conversion` WHERE id='$id'")){
            return true;
        }else{
            return false;
        }
      }
  
     public function getLastedConversion($id){
        $query = $this->pdo->query("SELECT * FROM `lasted_conversion` WHERE id_user='$id' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if(count($fetch)>0){

          $query = $this->pdo->query("SELECT * FROM `lasted_conversion` WHERE id_user='$id' ORDER BY RAND() LIMIT 1 ");
          $fetch = $query->fetch(PDO::FETCH_OBJ);
          return $fetch;

        }else{
          return false;
        }  
      }
  
    public function update_vencimento_flex($dados){
      
      $query = $this->pdo->prepare("UPDATE `user` SET vencimento_flex= :vencimento_flex WHERE id= :id");
      $query->bindValue(':vencimento_flex',$dados->vencimento_flex);
      $query->bindValue(':id',$dados->id);

      if($query->execute()){
        return true;
      }else{
        return false;
      }
   }
   
   public function setNotifyGestor($json,$id){
      
      $query = $this->pdo->prepare("UPDATE `user` SET notify_page= :notify_page WHERE id= :id");
      $query->bindValue(':notify_page',$json);
      $query->bindValue(':id',$id);

      if($query->execute()){
        return true;
      }else{
        return false;
      }
   }
  
  
  public function update_create_fat_ven($dados){
      $query = $this->pdo->prepare("UPDATE `user` SET gera_fat_cli= :gera_fat_cli WHERE id= :id");
      $query->bindValue(':gera_fat_cli',$dados->gera_fat_cli);
      $query->bindValue(':id',$dados->id);

      if($query->execute()){
        return true;
      }else{
        return false;
      }
  }

  public function update($dados){


    if(!isset($dados->senha) || $dados->senha == ""){

        $query = $this->pdo->prepare("UPDATE `user` SET nome= :nome, email= :email, telefone= :telefone, ddi= :ddi, dias_aviso_antecipado= :dias, dark= :dark, verificadozap= :verificadozap, verificadomail= :verificadomail WHERE id= :id");
        $query->bindValue(':nome',$dados->nome);
        $query->bindValue(':email',$dados->email);
        $query->bindValue(':telefone',$dados->telefone);
        $query->bindValue(':ddi',$dados->ddi);
        $query->bindValue(':dias',$dados->dias);
        $query->bindValue(':dark',$dados->dark);
        $query->bindValue(':verificadozap',$dados->verificadozap);
        $query->bindValue(':verificadomail',$dados->verificadomail);
        $query->bindValue(':id',$dados->id);

        if($query->execute()){
          return true;
        }else{
          return false;
        }

      }else{

      $query = $this->pdo->prepare("UPDATE `user` SET nome= :nome, email= :email, telefone= :telefone, ddi= :ddi, senha= :senha, dias_aviso_antecipado= :dias, dark= :dark, verificadozap= :verificadozap, verificadomail= :verificadomail WHERE id= :id");
      $query->bindValue(':nome',$dados->nome);
      $query->bindValue(':email',$dados->email);
      $query->bindValue(':telefone',$dados->telefone);
      $query->bindValue(':ddi',$dados->ddi);
      $query->bindValue(':senha',$dados->senha);
      $query->bindValue(':dias',$dados->dias);
      $query->bindValue(':dark',$dados->dark);
      $query->bindValue(':verificadozap',$dados->verificadozap);
      $query->bindValue(':verificadomail',$dados->verificadomail);
      $query->bindValue(':id',$dados->id);

      if($query->execute()){
        return true;
      }else{
        return false;
      }

    }

  }

 }




?>
