<?php
   @session_start();

   $json = new stdClass();
require_once "../config/settings.php";
   if(isset($_SESSION['SESSION_USER'])){
       
        require_once '../class/Conn.class.php';
        require_once '../class/Comunidade.class.php';
        
        $comunidade = new Comunidade();
       
       if(isset($_POST['add_like'])){
          
           $post = trim($_POST['post']);
          
           $num_like = $comunidade->add_like($post);
           echo $num_like;
           
       }
       
       
       if(isset($_POST['remove_post'])){
           $post = trim($_POST['post']);
           
           $post_dados = $comunidade->get_post($post);
           
           if($post_dados->autor == $_SESSION['SESSION_USER']['id']){
               $remove = $comunidade->remove_post($post);
               if($remove){
                   echo '1';
               }else{
                   echo '0';
               }
           }else{
               echo '0';
           }
       }
       
       if(isset($_POST['publicar'])){
           
           
              $conteudo = strip_tags($_POST['content']);
           
           

              // encontrar palavras proibidas
              include 'black_list/lista.php';

                $palavroes1=0;
                $msg = explode(' ', $conteudo);
                $cont = count($msg);
                $cont1 = count($palavroes);
                for($i=0;$i<$cont;$i++){
                	for($j=0;$j<$cont1;$j++){
                
                		if(strcasecmp($msg[$i],$palavroes[$j])==0){
                			 $palavroes1++;
                
                		}
                
                	}
                }

                if($palavroes1>0){
                    echo json_encode(array(
                       'erro' => true,
                       'msg' => 'Conteúdo não permitido'
                    ));
                    exit;
                }  
            
            
            if($conteudo == ""){
                echo json_encode(array(
                   'erro' => true,
                   'msg' => 'Digite alguma coisa'
                ));
                exit;
            }
           
           if(strlen($conteudo)>500){
               echo json_encode(array(
                   'erro' => true,
                   'msg' => 'Muitos caracteres'
                ));
                exit;
           }else{
               
               $data  = date('m/d/Y H:i:s');
               $autor =  $_SESSION['SESSION_USER']['id'];
               
               
               $publicar = $comunidade->post_push($autor,$conteudo,$data);
               
               if($publicar){
                   echo json_encode(array(
                       'erro' => false,
                       'msg' => 'Publicado'
                    ));
                    exit;
               }else{
                   echo json_encode(array(
                       'erro' => true,
                       'msg' => 'Erro ao publicar'
                    ));
                    exit;
               }
               
           }
           
           
           
       }
       
   }