<?php


 /**
  *
  */
 class Whatsgw extends Conn
 {

    private $apikey = "";

      function __construct()
      {
        $this->conn = new Conn;
        $this->pdo  = $this->conn->pdo();
      }


    public function removeInstance($device){

        $curl = curl_init();
        
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://app.whatsgw.com.br/api/WhatsGw/RemoveInstance',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => 'apikey='.$this->apikey.'&w_instancia_id='.$device,
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/x-www-form-urlencoded'
          ),
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);
        
        try{
            
            $json = json_decode($response);
            
            if(isset($json->result)){
                if($json->result == "success"){
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }
            
            
        }catch(\Exception  $e){
            return false;
        }

    }

     public function restartQrCode($device){

        $curl = curl_init();
        
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://app.whatsgw.com.br/api/WhatsGw/RestartInstance',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => 'apikey='.$this->apikey.'&w_instancia_id='.$device,
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/x-www-form-urlencoded'
          ),
        ));
        
        $response = curl_exec($curl);
        curl_close($curl);
        
          try{
                
                $json = json_decode($response);
                
                if(isset($json->result)){
                    if($json->result == "success"){
                        return true;
                    }else{
                        return false;
                    }
                }else{
                    return false;
                }
                
                
            }catch(\Exception  $e){
                return false;
            }

     }



      public function initQrcode(){

            $curl = curl_init();
            
            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://app.whatsgw.com.br/api/WhatsGw/NewInstance',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_POSTFIELDS => 'apikey='.$this->apikey.'&type=1',
              CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded'
              ),
            ));
            
            $response = curl_exec($curl);
            
            curl_close($curl);
            
            try{
                
                $json = json_decode($response);
                
                if(isset($json->result)){
                    if($json->result == "success"){
                        return $json->w_instancia_id;
                    }else{
                        return false;
                    }
                }else{
                    return false;
                }
                
                
            }catch(\Exception  $e){
                return false;
            }
            


      }



 }




?>
