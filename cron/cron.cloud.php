<?php 

  require_once 'autoload.php';
  
  $apiPanel_class = new ApiPainel();
  $user_class = new User();
  
  if(isset($_GET['step1'])){
  
  // listar todos os paineis com cloud ligado
  
    $list_panels = $apiPanel_class->list_cloud();
      
    if($list_panels){
        
        while($panel = $list_panels->fetch(PDO::FETCH_OBJ)){
            
            $user = $user_class->dados($panel->id_user);
            
            if($user){
                if($user_class->vencimento($user->vencimento) != "vencido"){
                    
                    //apto para cadastrar na fila do cloud
                    $apiPanel_class->insert_cloud_fila($panel->id);
                    
                }
            }
        }
        
    }
      
      
  }else if(isset($_GET['step2'])){
      // send fila cloud
      
      require_once 'cloud/cloud.php';
      
  }

?>