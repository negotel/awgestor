<?php
  @session_start();
require_once "../config/settings.php";
   if(isset($_SESSION['SESSION_USER'])){

     $_SESSION['INFO'] = "";

     if(isset($_POST)){

       require_once '../class/Conn.class.php';
       require_once '../class/Planos.class.php';
       require_once '../class/Logs.class.php';

       $planos   = new Planos();
       $log      = new Logs();

       $pla      = $_POST['id'];


          // buscar dados do plano
          $plano = $planos->plano($pla);

          if($_SESSION['SESSION_USER']['id'] == $plano->id_user){

            $delete = $planos->delete($pla);

            if($delete){
                
                
                // remove imagem anterior imgur
                if($plano->delete_banner_hash != NULL && $plano->delete_banner_hash != ""){
                    
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, "https://api.imgur.com/3/image/".$plano->delete_banner_hash);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                    
                    $headers = array();
                    $headers[] = "Authorization: Client-ID 303beb55fb36c03";
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    $result = curl_exec($ch);
                    curl_close($ch);
                }

              $_SESSION['INFO'] .= "<span class=\"text-success\" ><i class='fa fa-check text-success' ></i> Plano <b style='color:black !important;' >{$plano->nome}</b> deletado ! <br/></span>";
              $log->log($_SESSION['SESSION_USER']['id'],"Deletou o plano {$plano->nome} ");

            }else{

              $_SESSION['INFO'] .= "<span class=\"text-danger\" ><i class='fa fa-close text-danger' ></i> Plano <b style='color:black !important;' >{$plano->nome}</b> não deletado ! <br/></span>";
              $log->log($_SESSION['SESSION_USER']['id'],"Não conseguiu deletar o plano {$plano->nome} ");
            }

          }else{
            // erro: nao autorizado para deletar
             $_SESSION['INFO'] .= "<span class=\"text-success\" ><i class='fa fa-close text-danger' ></i> Você não pode deletar <b style='color:black !important;' >{$plano->nome}</b>. <br/><span>";
          }


     }else{
       $_SESSION['INFO'] = "<span class=\"text-warning\" ><i class='fa fa-warning text-warning' ></i> Request is required. <br/><span>";
     }
   }

   echo "request";


?>
