<?php
  @session_start();
require_once "../config/settings.php";
   if(isset($_SESSION['SESSION_USER'])){

     if(isset($_POST)){

       require_once '../class/Conn.class.php';
       require_once '../class/User.class.php';
       require_once '../class/Revenda.class.php';

       $user     = new User();
       $revenda  = new Revenda();

       $cli      = $_POST['id'];


          // buscar dados do cliente
          $cliente = $revenda->dados_cli($cli);

          if($_SESSION['SESSION_USER']['id'] == $cliente->id_rev){

            $delete = $revenda->delete_user($cli);

            if($delete){

              echo '1';

            }else{

                echo '0';

            }

          }else{

            echo '0';

          }


     }else{
       
      echo '0';

     }
   }


?>
