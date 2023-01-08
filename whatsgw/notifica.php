<?php 

    require_once '../class/Conn.class.php';
    
    $conn = new Conn();
    $pdo = $conn->pdo();

    $conteudo = file_get_contents('php://input');
    
    if(json_decode($conteudo)){
        
        $json = json_decode($conteudo);
        
        $devive_id = $json->w_instancia_id;
        
        if($json->event == "qrcode"){
        
            $query = "UPDATE `whats_api` SET response='$conteudo' WHERE device_id='$devive_id' AND api='Whatsgw' ";
            $pdo->query($query);
            
        }
    }else{
        
        parse_str($conteudo, $array);
        $json = (object)$array;
    
        if($json->event == "phonestate"){
            
            $devive_id = $json->w_instancia_id;
            
            $query = "UPDATE `whats_api` SET status='".$json->state."', phone='".$json->phone_number."' WHERE device_id='$devive_id' AND api='Whatsgw' ";
            $pdo->query($query);
        }
    }


    
   
   
    // save lasted qr in file
    $fp = fopen("request.txt","wb");
    fwrite($fp,$conteudo);
    fclose($fp);
    echo '200';

?>