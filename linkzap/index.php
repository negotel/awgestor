<?php 

 /* Sistema de redirecionamento para whatsapp
  * Propriedade de Gestor Lite
  * 2020 - @author - Luan Alves
  * linkzap.me | gestorlite.com
  */
  

   header('Access-Control-Allow-Origin: *'); 
   date_default_timezone_set('America/Sao_Paulo');
  
   $date = new DateTime();

  
   require_once 'autoload.php';
   require_once 'libs/Mobile_Detect.php';
  
   $linkzap_class = new Linkzap();
   $detect = new Mobile_Detect;

//   $url = "http://www.useragentstring.com/?uas=%s&getJSON=all";
//   $url = sprintf($url, urlencode($_SERVER["HTTP_USER_AGENT"]));
//   $ch = curl_init();
//   curl_setopt($ch, CURLOPT_URL, $url);
//   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//   $output = curl_exec($ch);
//   curl_close($ch);
//   $osData = json_decode($output);
   
   $http_reference = @$_SERVER['HTTP_REFERER'] ? @$_SERVER['HTTP_REFERER'] : "<?=SET_URL_PRODUCTION?>";

   $origem = parse_url($http_reference, PHP_URL_HOST);
   $cidade = $linkzap_class->getcidade($linkzap_class->getip());
   $navegador = $linkzap_class->get_browser_name($_SERVER['HTTP_USER_AGENT']);
   $os        = $linkzap_class->getOS($_SERVER['HTTP_USER_AGENT']);
  
   $mobile = FALSE;
   $user_agents = array("iPhone","iPad","Android","webOS","BlackBerry","iPod","Symbian","IsGeneric");
 
   foreach($user_agents as $user_agent){
     if (strpos($_SERVER['HTTP_USER_AGENT'], $user_agent) !== FALSE) {
        $mobile = TRUE;
	    $modelo	= $user_agent;
	break;
     }
   }
 
   if ($mobile){
      $device = strtolower($modelo);
   }else{
      $device = "Desktop";
   }
   
   $info_acesso['origem'] = $origem;
   $info_acesso['cidade'] = $cidade;
   $info_acesso['navegador'] = $navegador;
   $info_acesso['os'] = $os;
   $info_acesso['dispositivo'] = $device;
   $info_acesso['data'] = $date->getTimestamp();
   
   
   if(isset($_GET['url'])){
       
       $explo_url = explode('/', $_GET['url']);
       
       if(isset($explo_url[0])){
           
           if($explo_url[0] != 'error'){
               
               $slug = $explo_url[0];
               
               $getlink = $linkzap_class->get_slug_link($slug);
               
               if($getlink){
                   
                   $ar1 = array('+','(',')','-',' ');
                   $ar2 = array('','','','','');
                   $phone = str_replace($ar1,$ar2,$getlink->numero);
                   $msg   = urlencode($getlink->msg);
                   
                   if ( $detect->isMobile() ) {
                        $link_redirect = "https://api.whatsapp.com/send?phone={$phone}&text={$msg}";
                    }else{
                        $link_redirect = "https://web.whatsapp.com/send?phone={$phone}&text={$msg}";
                    }
                   
                    // insert info
                    $dados              = new stdClass();
                    $dados->data        = $info_acesso['data'];
                    $dados->id_link     = $getlink->id;
                    $dados->navegador   = $info_acesso['navegador'];
                    $dados->cidade      = $info_acesso['cidade'];
                    $dados->dispositivo = $info_acesso['dispositivo'];
                    $dados->origem      = str_replace('gestorlite.com','Acesso direto',$info_acesso['origem']);
                    $dados->os          = $info_acesso['os'];
                    
                    if($dados->os != "unknown"){
                       $insert = $linkzap_class->insert_info($dados);
                    }
                    
                    header('Location: '.$link_redirect);
                   
               }else{
                   echo 'Error Link';
               }
               
           }else{
               echo 'Error Link';
           }
           
       }else{
          // header('Location: https://linkzap.me/error');
       }
       
   }else{
       //header('Location: https://linkzap.me/error');
   }
   
   
   
    
?>