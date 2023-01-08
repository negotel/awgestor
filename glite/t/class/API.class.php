<?php

 class API {

   /*
    *@var $endpoint - type: String
    */

   private $endpoint = "<?=SET_URL_PRODUCTION?>/painel/api.php";



   public function gerateste($chave,$email,$package_id,$nome,$whatsapp){
       
       
       

    //  $curl = curl_init();

    //  curl_setopt_array($curl, array(
    //   CURLOPT_URL => "{$this->endpoint}?chave={$chave}&package={$package_id}&email={$email}&nome={$nome}&whatsapp={$whatsapp}&gerateste",
    //   CURLOPT_RETURNTRANSFER => true,
    //   CURLOPT_ENCODING => "",
    //   CURLOPT_MAXREDIRS => 10,
    //   CURLOPT_TIMEOUT => 0,
    //   CURLOPT_FOLLOWLOCATION => true,
    //   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //   CURLOPT_CUSTOMREQUEST => "POST",
    //  ));

     $response = file_get_contents("{$this->endpoint}?chave={$chave}&package={$package_id}&email={$email}&nome={$nome}&whatsapp={$whatsapp}&gerateste");

    // curl_close($curl);
     
     $json = json_decode($response);
     if($json){
       return $response;
     }else{
       return false;
     }

   }


   public function getPackages($chave){

    //  $curl = curl_init();

    //  curl_setopt_array($curl, array(
    //   CURLOPT_URL => "{$this->endpoint}?chave={$chave}&getPackages&trial",
    //   CURLOPT_RETURNTRANSFER => true,
    //   CURLOPT_ENCODING => "",
    //   CURLOPT_MAXREDIRS => 10,
    //   CURLOPT_TIMEOUT => 0,
    //   CURLOPT_FOLLOWLOCATION => true,
    //   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //   CURLOPT_CUSTOMREQUEST => "POST",
    //   CURLOPT_HTTPHEADER => array(
    //     "Cookie: __cfduid=dcd3f85f8f773f6d67f47718b23641f9e1586836805; PHPSESSID=f6308f5952b45ab70b67b25dac97e64e"
    //   ),
    // ));

    $response = file_get_contents("{$this->endpoint}?chave={$chave}&getPackages&trial");

   // curl_close($curl);
    $json = json_decode($response);
    if($json){
      return $response;
    }else{
      return false;
    }

   }



 }

?>
