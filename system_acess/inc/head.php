<?php

if(!isset($_SESSION['ADMIN_LOGADO'])){
     echo '<script>location.href="index.php?page=login";</script>';
     die;
 }
 

 
 /*FATURAS-USER*/
 
   if(isset($_POST['edite_fat'])){
     $dados = json_decode($_POST['dados']);

         if($i->Faturas->update_fat_admin($dados->id,$dados->valor,$dados->data,$dados->status)){
             echo json_encode(array('success' => true));
             die;
         }else{
              echo json_encode(array('success' => false));
             die;
         }
     }
     
 if(isset($_GET['delete_fatura'])){
     if($i->Faturas->delete_fatura($_GET['delete_fatura'])){
         
         if(is_file('../qrcodes/imgs/'.$_GET['delete_fatura'].'.png')){
             unlink('../qrcodes/imgs/'.$_GET['delete_fatura'].'.png');
         }
         
         
         $msg_hide = "Fatura deletada";
         $color = "success";
     }else{
         $msg_hide = "Erro ao deletar fatura";
         $color = "danger";
     }
     
     echo '<script>location.href="?page=faturas-user&user='.$_GET['user'].'&color_msg_hide='.$color.'&msg_hide='.$msg_hide.'";</script>';
 }
 
  if(isset($_GET['dados_fatura'])){
         $fatura = $i->Faturas->dados($_GET['dados_fatura']);
         echo json_encode($fatura);
         die;
     }
     
     
 
  /*FATURAS-USER*/
 
//-------------------------------------------------------------------------------

/*COMPROVANTES*/
 $comprovantes = $i->Comprovantes->list_comp();
 $num_comprovantes = $i->Comprovantes->count_comp();
 
   if(isset($_POST['aceita_comp'])){
      
     $fat = $_POST['fat'];
     $user = $_POST['user'];

     if($i->Comprovantes->aprova_comp($fat,$user,$i)){
         echo json_encode(array('success' => true));
         die;
     }else{
          echo json_encode(array('success' => false));
         die;
     }
 }
 
 if(isset($_POST['rejeita_comp'])){
       
     $fat = $_POST['fat'];
     $user = $_POST['user'];

     if($i->Comprovantes->rejeita_comp($fat,$user,$i)){
         echo json_encode(array('success' => true));
         die;
     }else{
          echo json_encode(array('success' => false));
         die;
     }
 }
 
 
 
 /*COMPROVANTES*/
 
 //-------------------------------------------------------------------------------
 
 /*FILA ZAP*/
 
 $num_fila_zap  = $i->Whatsapi->count_fila();
 $list_fila_zap = $i->Whatsapi->list_msgs_fila_2();


 if(isset($_GET['dados_fila'])){
     $fila = $i->Whatsapi->dados_fila($_GET['dados_fila']);
     echo json_encode($fila);
     die;
 }
  /*FILA ZAP*/
  
 //-------------------------------------------------------------------------------

  
  /*CONTATOS*/
   if($list_contatos3){
         $num_contatos   = count($list_contatos3->fetchAll(PDO::FETCH_OBJ));
     }else{
         $num_contatos = 0;
     } 
     
     
 $list_contatos  = $i->Gestor->list_contatos();
 $list_contatos3 = $i->Gestor->list_contatos();
 
  if(isset($_GET['delete_contato'])){
     if($i->Gestor->delete_contato($_GET['delete_contato'])){
         $msg_hide = "Contato deletado";
         $color = "success";
     }else{
         $msg_hide = "Erro ao deletar contato";
         $color = "danger";
     }
     
     echo '<script>location.href="?page=contato&color_msg_hide='.$color.'&msg_hide='.$msg_hide.'";</script>';
 }
 
  if(isset($_GET['dados_contato'])){
     $contato = $i->Gestor->dados_contato($_GET['dados_contato']);
     echo json_encode($contato);
     die;
 }

 /*CONTATOS*/
 
 //-------------------------------------------------------------------------------
 
 /*CLIENTES*/
 
 $list_users  = $i->User->list_users();
 $list_users2 = $i->User->list_users();
 $list_users3 = $i->User->list_users();
 
 
 if(!isset($_GET['id'])){

 }else{
     $cliente = $i->User->dados($_GET['id']);
     $plano_cliente = $i->Gestor->plano($cliente->id_plano);
     
     
     
     
     if($cliente->vencimento != 0 && $cliente->vencimento != ""){
    
        $explodeData  = explode('/',$cliente->vencimento);
        $explodeData2 = explode('/',date('d/m/Y'));
        $dataVen      = $explodeData[2].$explodeData[1].$explodeData[0];
        $dataHoje     = $explodeData2[2].$explodeData2[1].$explodeData2[0];
    
        $Pvencimento = str_replace('/','-',$cliente->vencimento);
        $timestamp   = strtotime("-3 days",strtotime($Pvencimento));
        $venX        = date('d/m/Y', $timestamp);
    
        $timestamp   = strtotime("-2 days",strtotime($Pvencimento));
        $venY        = date('d/m/Y', $timestamp);
    
        $timestamp   = strtotime("-1 days",strtotime($Pvencimento));
        $venZ        = date('d/m/Y', $timestamp);
    
        if($dataVen == $dataHoje){
            $ven = "<b class='text-info'>{$cliente->vencimento}</b>";
        }
       if($dataHoje > $dataVen){
            $ven = "<b class='text-danger'>{$cliente->vencimento}</b>";
        }
        if($dataHoje < $dataVen && $venX != date('d/m/Y') && $venY != date('d/m/Y') && $venZ != date('d/m/Y')){
            $ven = "<b class='text-success'>{$cliente->vencimento}</b>";
        }
       if($venX == date('d/m/Y') || $venY == date('d/m/Y') || $venZ == date('d/m/Y')){
          $ven = "<b class='text-warning'>{$cliente->vencimento}</b>";
        }
      }else{
            $ven = "<span class='text-info'>Aguardando </span>";
      }
    
     
 }
  /*CLIENTES*/
  
  //-------------------------------------------------------------------------------
  
  /*FATURAS*/
  
  if(isset($_GET['delete_fat'])){
    if($i->Gestor->delete_fat_user($_GET['delete_fat'])){
         $msg_hide = "Fatura deletada";
         $color = "success";
    }else{
        $msg_hide = "Erro ao deletar fatura";
        $color = "danger";
    }
    
    echo '<script>location.href="?page=faturas&color_msg_hide='.$color.'&msg_hide='.$msg_hide.'";</script>';
}
 
  if(@$list_faturas2){
     $num_faturas   = count($list_faturas2->fetchAll(PDO::FETCH_OBJ));
     }else{
         $num_faturas = 0;
     }
  /*FATURAS*/
 
 
 ?>
 
 
 