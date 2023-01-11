<?php
  @session_start();
require_once "../config/settings.php";
   if(isset($_SESSION['SESSION_USER'])){

     $_SESSION['INFO'] = "";

     if(isset($_POST)){

       require_once '../class/Conn.class.php';
       require_once '../class/Clientes.class.php';
       require_once '../class/Logs.class.php';

       $clientes = new Clientes();
       $log      = new Logs();

       $_checkbox = $_POST['clis'];

       $log->log($_SESSION['SESSION_USER']['id'],"Deletou clientes em massa");

        foreach($_checkbox as $_valor){

          // buscar dados do cliente
          $cliente = $clientes->dados($_valor);

          if($_SESSION['SESSION_USER']['id'] == $cliente->id_user){

            $delete = $clientes->delete($_valor);

            if($delete){
              $_SESSION['INFO'] .= "<span class=\"text-success\" ><i class='fa fa-check text-success' ></i> Usuário <b style='color:black !important;' >{$cliente->nome}</b> deletado ! <br/></span>";
            }else{
              $_SESSION['INFO'] .= "<span class=\"text-danger\" ><i class='fa fa-close text-danger' ></i> Usuário <b style='color:black !important;' >{$cliente->nome}</b> não deletado ! <br/></span>";
            }

          }else{
            // erro: nao autorizado para deletar
             $_SESSION['INFO'] .= "<span class=\"text-success\" ><i class='fa fa-close text-danger' ></i> Você não pode deletar <b style='color:black !important;' >{$cliente->nome}</b>. <br/><span>";
          }

        }
     }else{
       $_SESSION['INFO'] = "<span class=\"text-warning\" ><i class='fa fa-warning text-warning' ></i> Vazio. <br/><span>";
     }
   }

   echo '<script>location.href="../painel";</script>';


?>
