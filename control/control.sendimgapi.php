<?php 


  set_time_limit(3000);

  require_once '../class/Conn.class.php';
  require_once '../class/User.class.php';
  require_once '../class/Clientes.class.php';
  require_once '../class/Planos.class.php';
  
  $user_c     = new User();
  $clientes_c = new Clientes();
  $planos_c   = new Planos();
  
  $client_id = "303beb55fb36c03"; //imgur
  
  if(isset($_SESSION['SESSION_USER'])){
      
      if(isset($_FILES)){
    
            if( isset($_POST['idplano_img']) ){
                
                $id = trim($_POST['idplano_img']);
                
                $plano_dados = $planos_c->plano($id);
                
                if(!$plano_dados){
                    echo json_encode(array('erro'=>true,'msg'=>'Este plano é inexistente'));
                    die;
                }
                
                if($plano_dados->id_user != $_SESSION['SESSION_USER']['id']){
                    echo json_encode(array('erro'=>true,'msg'=>'Este plano é inexistente'));
                    die;
                }
                
                $image_content = file_get_contents($_FILES['img_plano']['tmp_name']);
                $tamanhos      = getimagesize($_FILES['img_plano']["tmp_name"]);
                
               
                
                // Verifica largura 
                if($tamanhos[0] != 906 ) {
                    echo json_encode(array('erro'=>true,'msg'=>'As dimensões da imagem deve ser 906x134'));
                    die;
                } 
                
                // Verifica altura 
                if($tamanhos[1] != 134) { 
                    echo json_encode(array('erro'=>true,'msg'=>'As dimensões da imagem deve ser 906x134'));
                    die;
                }
                
                
                // remove imagem anterior imgur
                if($plano_dados->delete_banner_hash != NULL && $plano_dados->delete_banner_hash != ""){
                    
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, "https://api.imgur.com/3/image/".$plano_dados->delete_banner_hash);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                    
                    $headers = array();
                    $headers[] = "Authorization: Client-ID ".$client_id;
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    $result = curl_exec($ch);
                    curl_close($ch);
                }
                
                
                
                
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://api.imgur.com/3/image.json');
                curl_setopt($ch, CURLOPT_POST, TRUE);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Client-ID ' . $client_id));
                curl_setopt($ch, CURLOPT_POSTFIELDS, array('image' => base64_encode($image_content)));
                
                $reply = curl_exec($ch);
                curl_close($ch);
                $reply = json_decode($reply);
                
                if($reply){
                    
                    if(isset($reply->data->link)){
                        
                        if($reply->data->link != ""){
                            
                            $banner_link = $reply->data->link;
                            $delete_banner_hash = $reply->data->deletehash;
                            
                            $dados = new stdClass();
                            $dados->banner_link = $banner_link;
                            $dados->delete_banner_hash = $delete_banner_hash;
                            $dados->id = $id;
                            
                            $update = $planos_c->update_banner($dados);
                            
                            if($update){
                                
                                echo json_encode(array('erro'=>false,'msg'=>'Imagem alterada com sucesso','link'=>$banner_link));
                                die;
                                
                            }else{
                                echo json_encode(array('erro'=>true,'msg'=>'Erro, entre em contato com o suporte. <br />Tire uma captura de tela para enviar ao suporte.<br />Erro: Error 104 line'));
                                die;
                            }
                            
                        }else{
                            echo json_encode(array('erro'=>true,'msg'=>'Erro, entre em contato com o suporte. <br />Tire uma captura de tela para enviar ao suporte.<br />Erro: Error 109 line'));
                            die;
                        }
                        
                    }else{
                        echo json_encode(array('erro'=>true,'msg'=>'Erro, entre em contato com o suporte. <br />Tire uma captura de tela para enviar ao suporte.<br />Erro: Error 114 line '));
                        die;
                    }
                    
                }else{
                    echo json_encode(array('erro'=>true,'msg'=>'Erro, entre em contato com o suporte. <br />Tire uma captura de tela para enviar ao suporte.<br />Erro: Error 119 line'));
                    die;
                }
                                

            }
            
        }
      
  }
  



?>