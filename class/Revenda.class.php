<?php


 /**
  *
  */
 class Revenda extends Conn
 {


      function __construct()
      {
        $this->conn = new Conn;
        $this->pdo  = $this->conn->pdo();
      }


      public function list_revendas($user)
      {

        $query = $this->pdo->query("SELECT * FROM `user` WHERE id_rev='$user' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if(count($fetch)>0){
          return $this->pdo->query("SELECT * FROM `user` WHERE id_rev='$user' ORDER BY STR_TO_DATE(vencimento, '%d/%m/%Y') ");
        }else{
          return false;
        }
      }

      public function count_revendas($user)
      {

        $query = $this->pdo->query("SELECT * FROM `user` WHERE id_rev='$user' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if(count($fetch)>0){
         return count($fetch);
        }else{
          return 0;
        }
      }


      public function verific_creditos($creditos_plano,$meses,$user)
      {

        $creditos = self::credito_rev_user($user);
        $cred = ($creditos_plano*$meses);

        if($creditos>=$cred){
          return true;
        }else{
          return false;
        }


      }

      public function list_indicados($user)
      {

        $query = $this->pdo->query("SELECT * FROM `user` WHERE indicado='$user' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if(count($fetch)>0){
          return $this->pdo->query("SELECT * FROM `user` WHERE indicado='$user' ORDER BY STR_TO_DATE(vencimento, '%d/%m/%Y') ");
        }else{
          return false;
        }
      }

      public function convertMoney($type,$valor){
          if($type == 1){
            $a = str_replace(',','.',str_replace('.','',$valor));
            return $a;
          }else if($type == 2){
            return number_format($valor,2,",",".");
          }

        }

      public function saldo_user($user,$pay=false)
      {
        $query = $this->pdo->query("SELECT * FROM `saldo_user` WHERE id_user='$user' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if(count($fetch)>0){

          $query = $this->pdo->query("SELECT * FROM `saldo_user` WHERE id_user='$user' ");
          $fetch = $query->fetch(PDO::FETCH_OBJ);

          if($pay){
            return self::convertMoney(1,$fetch->valor);
          }else{
            return $fetch->valor;
          }

        }else{
          if($pay){
            return 0;
          }else{
            return "0,00";
          }
        }

      }

      public function credito_rev_user($user)
      {
        $query = $this->pdo->query("SELECT * FROM `creditos_rev` WHERE id_user='$user' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if(count($fetch)>0){

          $query = $this->pdo->query("SELECT * FROM `creditos_rev` WHERE id_user='$user' ");
          $fetch = $query->fetch(PDO::FETCH_OBJ);

          return $fetch->qtd;

        }else{
            return 0;
        }

      }

      public function change_saldo($user,$remove=false,$add=false)
      {

        $saldo_atual = self::saldo_user($user,true);

        if($remove){
          $new_saldo = ($saldo_atual-$remove);
        }

        if($add){
          $new_saldo = ($saldo_atual+$add);
        }

        $saldo = self::convertMoney(2,$new_saldo);

        $query = $this->pdo->query("SELECT * FROM `saldo_user` WHERE id_user='$user' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if(count($fetch)<0 || count($fetch) == 0 ){
          // insert new saldo
          if($this->pdo->query("INSERT INTO `saldo_user` (valor,id_user) VALUES ('$saldo','$user') ")){
            return $saldo;
          }else{
            return false;
          }
        }else{
          // update
          if($this->pdo->query("UPDATE `saldo_user` SET valor='$saldo' WHERE id_user='$user' ")){
            return $saldo;
          }else{
            return false;
          }
        }

      }

      public function busca_saque($id_rev)
      {
        $query = $this->pdo->query("SELECT * FROM `solicita_saque` WHERE id_rev='$id_rev' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if(count($fetch)>0){

          return true;

        }else{
          return false;
        }
      }


      public function solicita_saque($valor,$info,$id_rev)
      {

        $query = $this->pdo->prepare("INSERT INTO `solicita_saque`  (`id_rev`, `dados`, `valor`) VALUES (:id_rev,:dados,:valor)");
        $query->bindValue(':id_rev',$id_rev);
        $query->bindValue(':dados',$info);
        $query->bindValue(':valor',$valor);

        if($query->execute()){
          return true;
        }else{
          return false;
        }


      }

      public function delete_user($id)
      {

        $query = $this->pdo->query("DELETE FROM `user` WHERE id='$id' ");

        if($query){
          return true;
        }else{
          return false;
        }

      }

      public function dados_cli($id)
      {

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

      public function creditos_rev_change($user,$cred,$add=false)
      {

        $atual = self::credito_rev_user($user);
        if($add == false){
          $newcred = ($atual-$cred);
        }
        if($add){
          $newcred = ($atual+$cred);
        }

        $query = $this->pdo->query("SELECT * FROM `creditos_rev` WHERE id_user='$user' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if(count($fetch)<0 || count($fetch) == 0){
          // insert new cred
          if($this->pdo->query("INSERT INTO `creditos_rev` (id_user,qtd) VALUES ('$user','$newcred') ")){
            return $newcred;
          }else{
            return false;
          }
        }else{
          // update
          if($this->pdo->query("UPDATE `creditos_rev` SET qtd='$newcred' WHERE id_user='$user' ")){
            return $newcred;
          }else{
            return false;
          }
        }

      }


 }




?>
