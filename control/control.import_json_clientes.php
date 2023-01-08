
<!DOCTYPE html>
<html lang="pt-br">
  <head><meta http-equiv="Content-Type" content="text/html; charset=shift_jis">
    <!-- Meta tags Obrigatﾃｳrias -->
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../painel/css/bootstrap.min.css" >

    <title>Importar clientes</title>
  </head>
  <body>

    <div class="cointainer">
      <div style="margin-top:50px;" class="row">
        <div style="margin-bottom:20px;" class="col-md-12 text-center">
          <img src="../painel/img/logo-gestor-lite.png" width="150" alt="">
          &nbsp;&nbsp;
          <img src="../painel/img/ferramenta-scriptmundo.png" width="150" alt="">

        </div>
        <div class="col-md-2"></div>
         <div class="col-md-8">

            <table class="table">
              <thead class="thead-light">
                <tr>
                  <th scope="col">Nome</th>
                  <th scope="col">Email</th>
                  <th scope="col">Status</th>
                </tr>
              </thead>
              <tbody>

<?php

  @session_start();

  require_once '../class/Conn.class.php';
  require_once '../class/Clientes.class.php';
  require_once '../class/User.class.php';
  require_once '../class/Logs.class.php';

  $clientes = new Clientes();
  $user     = new User();
  $log      = new Logs();


  if(isset($_SESSION['SESSION_USER'])){

    if(isset($_FILES['import_cliente_json'])){
  

      $file = $_FILES['import_cliente_json'];

      $allowedExts = array("json");
      $dir = 'tmp';

      $ext = strtolower(substr($file['name'],-4));

      if(in_array($ext, $allowedExts)){

       $new_name = date("Y.m.d-H.i.s") .".". $ext;
       
         // coleta os dados do json
         $dados = json_decode(file_get_contents($file["tmp_name"]), true);

         // buscar limit de clientes do plano
         $limitCli = $user->limit_plano($_SESSION['GESTOR']['plano']);

         
       $log->log($_SESSION['SESSION_USER']['id'],"Importou clientes por JSON");
        
       if(isset($_POST['type'])){
           
           
             if($_POST['type'] == 'gestor'){
                 
                 foreach ($dados as $key => $value) {

                   
                  $plano      = 0;
        
                  $dadosUser = new stdClass();
                  $dadosUser->limit_plano  = $limitCli;
                  $dadosUser->id_user      = $_SESSION['SESSION_USER']['id'];
                  $dadosUser->nome         = $value['nome'];
                  $dadosUser->email        = $value['email'] == "" ? "vazio" : $value['email'];
                  $dadosUser->telefone     = $value['telefone'] == "" ? "vazio" : $value['telefone'];
                  $dadosUser->vencimento   = $value['vencimento'];
                  $dadosUser->id_plano     = $value['id_plano'];
                  $dadosUser->notas        = $value['notas'];
                  $dadosUser->senha        = $value['senha'];
                  $dadosUser->recebe_zap   = $value['telefone'] == "" ? 0 : 1;
                  
                  $explode            = explode('/',$dadosUser->vencimento);
                  $totime             = $explode[2].$explode[1].$explode[0];
                  $dadosUser->totime  = $totime;
   
                  $inser = $clientes->insert($dadosUser);
                                       
                 if($inser == '1'){
                      echo '<tr><td>'.$value['nome'].'</td><td>'.$value['email'].'</td><td class="text-success" >IMPORTADO</td></tr>';
                  }else{
                    if($inser == "limit"){
                      echo '<tr><td>'.$value['nome'].'</td><td>'.$value['email'].'</td><td class="text-danger" >FALHA <span style="font-size:10px;" >(Limite do plano atingido, faça upgrade)<span></td></tr>';
                    }else if($inser == "mail"){
                      echo '<tr><td>'.$value['nome'].'</td><td>'.$value['email'].'</td><td class="text-danger" >FALHA <span style="font-size:10px;" >(Um cliente foi encontrado com o mesmo email)<span></td></tr>';
                    }else{
                      echo '<tr><td>'.$value['nome'].'</td><td>'.$value['email'].'</td><td class="text-danger" >FALHA</td></tr>';
                    }
                  }

                 }
                
             }else if($_POST['type'] == 'xtream'){
                
                   // xtream
                     foreach ($dados as $key => $value) {
            
                    if(isset($value['reseller'])){
                        
                      $nome       = $value['username'];
                      $email      = 'vazio';
                      $senha      = $value['password'];  
                        
                    }else{
            
                       if(!isset($value['nome']) && !isset($value['email']) && !isset($value['validate_xtream'])){
                         echo '<tr><td colspan="2" class="text-center text-danger" >Falha - Este arquivo me parece estranho</td></tr>';
                         break;
                       }
                       
                      $nome       = $value['nome'];
                      $email      = $value['email'];
                      $senha      = $value['senha'];
                      
                    }
                    
                    
                    if(!isset($value['tel']) && !isset($value['telefone'])){
                        $telefone   = "";
                    }else{
                    
            
                      if(isset($value['tel'])){
                          if($value['tel'] != ""){
                            $telefone = '55'.str_replace(' ','',str_replace('-','',str_replace(')','',str_replace('(',"",$value['tel']))));
                          }else{
                            $telefone   = "";
                          }
                        }else{
                          if($value['telefone'] != "" || $value['telefone'] == "vazio"){
            
                            if(strlen($value['telefone']) > 12){
                              $telefone = str_replace(' ','',str_replace('-','',str_replace(')','',str_replace('(',"",$value['telefone']))));
                            }else{
                              $telefone = '55'.str_replace(' ','',str_replace('-','',str_replace(')','',str_replace('(',"",$value['telefone']))));
                            }
            
            
                          }else{
                            $telefone   = "";
                          }
                        }
                        
                    }
            
                      if(isset($value['notas'])){
                        $notas = $value['notas'];
                      }else{
                        $notas = "Importado na data de ( ".date('d/m/Y')." ) ";
                      }
            
                      if(isset($value['id_plano'])){
                        $id_plano = $value['id_plano'];
                      }else{
                        $id_plano = 0;
                      }
            
            
                      if(isset($value['reseller'])){
                          
                         $explol_date = explode('-',$value['expiration']);
                         $vencimento = $explol_date[2].'/'.$explol_date[1].'/'.$explol_date[0];
                         
                      }else{
                          
                        $vencimento = isset($value['validate_xtream']) ? $value['validate_xtream'] : $value['vencimento'];
                       
                      }
                      
                      
                      $plano      = 0;
            
                      $dadosUser = new stdClass();
                      $dadosUser->limit_plano  = $limitCli;
                      $dadosUser->id_user      = $_SESSION['SESSION_USER']['id'];
                      $dadosUser->nome         = $nome;
                      $dadosUser->email        = $email == "" ? "vazio" : $email;
                      $dadosUser->telefone     = $telefone == "" ? "vazio" : $telefone;
                      $dadosUser->vencimento   = $vencimento;
                      $dadosUser->id_plano     = $id_plano;
                      $dadosUser->notas        = $notas;
                      $dadosUser->senha        = $senha;
                      $dadosUser->recebe_zap   = $telefone == "" ? 0 : 1;
                      
                      $explode            = explode('/',$dadosUser->vencimento);
                      $totime             = $explode[2].$explode[1].$explode[0];
                      $dadosUser->totime  = $totime;
            
                      $inser = $clientes->insert($dadosUser);
            
            
            
                      if($inser == '1'){
                          echo '<tr><td>'.$nome.'</td><td>'.$email.'</td><td class="text-success" >IMPORTADO</td></tr>';
                      }else{
                        if($inser == "limit"){
                          echo '<tr><td>'.$nome.'</td><td>'.$email.'</td><td class="text-danger" >FALHA <span style="font-size:10px;" >(Limite do plano atingido, faça upgrade)<span></td></tr>';
                        }else if($inser == "mail"){
                          echo '<tr><td>'.$nome.'</td><td>'.$email.'</td><td class="text-danger" >FALHA <span style="font-size:10px;" >(Um cliente foi encontrado com o mesmo email)<span></td></tr>';
                        }else{
                          echo '<tr><td>'.$nome.'</td><td>'.$email.'</td><td class="text-danger" >FALHA</td></tr>';
                        }
                      }
            
            
                     }
                     
                    // fim xtream

                 
             }
             
             
         }
        
  

     }else{

       // error

       echo '<tr><td colspan="2" class="text-center text-danger" >FORMATO DE ARQUIVO NÃO PERMITIDO, USE UM <b>.JSON</b></td></tr>';

     }

   }else{
     // error
     echo '<tr><td colspan="2" class="text-center text-danger" >FALHA</td></tr>';
   }


 }else{
   header('LOCATION: ../login');
 }


?>



            </tbody>
          </table>
        </div>
        <div class="col-md-2"></div>
        <div class="col-md-12 text-center">
          <a class="btn btn-primary" href='' >VOLTAR</a>
        </div>
      </div>
    </div>


  <script src="../painel/js/jquery.js"></script>
  <script src="https://use.fontawesome.com/fc727a7e55.js"></script>

  <script type="text/javascript">
      $(function(){
        window.history.pushState("Object", "Importar cliente Gestor Lite", "/painel");
      });
  </script>

</body>
</html>
