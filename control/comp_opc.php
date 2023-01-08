<?php 
  @session_start();

  $json = new stdClass();

   if(isset($_SESSION['SESSION_USER'])){

     if(isset($_POST)){
         
         if(!isset($_POST['idfat'])){
             echo json_encode(['erro' => true, 'msg' => 'not found fat']);
             die;
         }
         
         $idfat = $_POST['idfat'];
         
         require_once '../class/Conn.class.php';
         require_once '../class/Clientes.class.php';
         require_once '../class/Logs.class.php';
         require_once '../class/Planos.class.php';
         require_once '../class/Financeiro.class.php';
         require_once '../class/Whatsapi.class.php';

         $clientes   = new Clientes();
         $financeiro = new Financeiro();
         $whatsapi   = new Whatsapi();
         $fatura     = $clientes->get_fat($idfat);
         $dadosComp  = $clientes->dados_comp($idfat);
         $dados      = $clientes->dados($fatura->id_cliente);
         $logs       = new Logs();
         $planos     = new Planos();
         $plano      = $planos->plano($fatura->id_plano);
         
        
        
        
       if($dados->id_user == $_SESSION['SESSION_USER']['id']){


        if($_POST['type'] == "aprova"){
            
    
     

               
               if($clientes->aprova_comp($idfat,$dadosComp->file,$dir='../')){
    
               if($clientes->renew($plano,$dados->id,$dados->vencimento)){
    
                 $_SESSION['INFO'] = "<span><i class='fa fa-check' ></i> Comprovante de <b>{$dados->nome}</b> aprovado!</span>";
    
                 $logs->log($_SESSION['SESSION_USER']['id'],"Aprovou o comprovante de [ {$dados->nome} ] ");
    
    
               // adicionar movimentacao no financeiro
                $finan = new stdClass();
                $finan->id_user = $_SESSION['SESSION_USER']['id'];
                $finan->tipo = 1;
                $finan->data = date('d/m/Y');
                $finan->hora = date('H:i');
                $finan->valor = $fatura->valor;
                $finan->nota = "Aprovação de comprovante da fatura #{$fatura->id} do cliente {$dados->nome}";
                
                $financeiro->insert($finan);

        
    
                 $json->erro = false;
                 $json->msg  = "Comprovante aceito";
                 echo json_encode($json);
    
               }else{
    
                 $json->erro = true;
                 $json->msg  = "Erro ao atualizar cliente <b>{$dados->nome}</b>";
                 echo json_encode($json);
    
               }
           
            }
           
        }else{
            $clientes->recusa_comp($fatura->id,$dadosComp->file,$dir='../');
        }
           
           
           
           

         }else{

           $json->erro = true;
           $json->msg  = "Não autorizado";
           echo json_encode($json);

         }
         
         
     }
     
 }


?>