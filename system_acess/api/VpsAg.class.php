<?php

 
 class VpsAg {
     
     private $X_API_KEY = "E5LZKbWWXQfZ6DdLBHXPeuPD7QVFcmZjMRjz37ljPigLwu8OAmWsjzHxqXv4sZks4PuUqu7DgP4P88Dr5qdGRf1p736yofY";
     private $X_API_USER = "luanalvesns@gmail.com";
     
     
     function list_vps(){
         
         $ch = curl_init('https://www.vpsag.com/api/v1/vps/');
		 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/32.0.1700.107 Chrome/32.0.1700.107 Safari/537.36');
		 curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		     'X_API_KEY: '.$this->X_API_KEY,
		     'X_API_USER: '.$this->X_API_USER,
		     'Content-Type: application/x-www-form-urlencoded',
		     'Host: www.vpsag.com'
		     )
		    );

		 $res = curl_exec($ch);
		 curl_close($ch);
	     $return = json_decode($res);

		 return $return;
         
     }
     
     
     function vps_info($id){
         
         $ch = curl_init('https://www.vpsag.com/api/v1/vps/'.$id);
		 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/32.0.1700.107 Chrome/32.0.1700.107 Safari/537.36');
		 curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		     'X_API_KEY: '.$this->X_API_KEY,
		     'X_API_USER: '.$this->X_API_USER,
		     'Content-Type: application/x-www-form-urlencoded',
		     'Host: www.vpsag.com'
		     )
		    );

		 $res = curl_exec($ch);
		 curl_close($ch);
	     $return = json_decode($res);

		 return $return;
     }
     
     
     
 }



?>