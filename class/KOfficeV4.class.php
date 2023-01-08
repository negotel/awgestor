<?php 

 /*
  * Class integration Koffice V4
  */

 class kofficeV4 {

      
      public function getAllPackegs($cms,$username,$password,$trial=0){
          
       
       $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "http://api-panels.gestorlite.com/apps/kofficev4/?panel={$cms}&username={$username}&password={$password}&trial={$trial}&action=getPlanosTrial",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);
        
        $pack = json_decode($response);
        

        if($pack){
            
            $json_return = array();
            $json_return['erro'] = false;
            $json_return['packages'] = array();
            $i = 0;
            
            foreach($pack as $p){
                
                if(trim($p->nome) != "Customizado"){
                    $json_return['packages'][$i] = ['name' => $p->nome, 'id' => $p->package_id];
                }
                
                $i++;
            }
            
        }else{
            $json_return = array();
            $json_return['erro'] = true;
            
        }
    
        
        return json_encode(['erro' => $json_return['erro'], 'packages' => $json_return['packages']]);
       
        
      }
      
      
      public function testconnection($cms,$api_key){

        return false;
         
      }
      
      
      
      public function gerateste($cms,$username,$password,$package){

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "http://api-panels.gestorlite.com/apps/kofficev4/?panel={$cms}&username={$username}&password={$password}&package_id={$package}&action=createTeste",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);
        return $response;
         
      }
      
       public function usercreate($package,$cms,$api_key,$user,$pass){
          
          return false;
         
         
      }
    



 }


?>


