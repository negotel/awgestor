<?php


 /**
  *
  */
 class Login extends Conn
 {


      function __construct()
      {
        $this->conn = new Conn;
        $this->pdo  = $this->conn->pdo();
      }



    public function login($request){

     if(isset($request['email']) && isset($request['pass']))
     {

        $pass   = $request['pass'];  //substr(sha1($request['pass']),0,13);
        $email  = $request['email'];

        $q = $this->pdo->prepare("SELECT * FROM `user` WHERE email= :email AND senha= :pass");
        $q->bindValue(':email', $email);
        $q->bindValue(':pass', $pass);
        $q->execute();
        $fetch = $q->fetchAll(PDO::FETCH_OBJ);
        if(count($fetch)>0)
        {

          $q = $this->pdo->prepare("SELECT * FROM `user` WHERE email= :email AND senha= :pass");
          $q->bindValue(':email', $email);
          $q->bindValue(':pass', $pass);
          $q->execute();
          $fetch = $q->fetch(PDO::FETCH_OBJ);

          $_SESSION['token_access'] = sha1(md5(date('dmYHis').rand().$fetch->id));
          $tk = $_SESSION['token_access'];
          $id = $fetch->id;
          $this->pdo->query("UPDATE `user` SET token_access='$tk' WHERE id='$id' ");
 
          $data = new stdClass();
          $data->erro         = false;
          $data->id           = $fetch->id;
          $data->nome         = $fetch->nome;
          $data->email        = $fetch->email;
          $data->telefone     = $fetch->telefone;
          $data->id_plano     = $fetch->id_plano;
          $data->token_access = $tk;
          $data->parceiro     = $fetch->parceiro;
          $data->google_auth_code     = $fetch->google_auth_code;
          $data->two_facto     = $fetch->two_facto;

          $_SESSION['SESSION_USER'] = (array)$data;

          return json_encode($data);

        }else{
            
            
            
            $q = $this->pdo->prepare("SELECT * FROM `convidade_acesso` WHERE email= :email AND senha= :pass");
            $q->bindValue(':email', $email);
            $q->bindValue(':pass', $pass);
            $q->execute();
            $fetch = $q->fetchAll(PDO::FETCH_OBJ);
            if(count($fetch)>0)
            {
                
              $q = $this->pdo->prepare("SELECT * FROM `convidade_acesso` WHERE email= :email AND senha= :pass");
              $q->bindValue(':email', $email);
              $q->bindValue(':pass', $pass);
              $q->execute();
              $fetchC = $q->fetch(PDO::FETCH_OBJ);
              
              $q = $this->pdo->prepare("SELECT * FROM `user` WHERE id= :id ");
              $q->bindValue(':id', $fetchC->id_user);
              $q->execute();
              $fetch = $q->fetch(PDO::FETCH_OBJ);
              
              $data = new stdClass();
              $data->erro         = false;
              $data->id           = $fetch->id;
              $data->nome         = $fetch->nome;
              $data->email        = $fetch->email;
              $data->telefone     = $fetch->telefone;
              $data->id_plano     = $fetch->id_plano;
              $data->token_access = $fetch->token_access;
    
              $_SESSION['SESSION_USER'] = (array)$data;
              $_SESSION['SESSION_CVD'] = (array)$fetchC;
              return json_encode($data);
                
            }else{
                
              $data = new stdClass();
              $data->erro = true;
              $data->msg = "Login inválido";
    
              return json_encode($data);

            }
            
        }

     }


   }


 }




?>
