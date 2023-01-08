<?php


 /**
  *
  */
 class Whatsapi extends Conn
 {

    private $client_id = "cid5e705af0299fc";

    private $secret    = "sec5e705af029a060.856790185e705af029a279.42814883";

    private $endpoint  = "http://167.114.10.6";

    private $token = "HSMXNK28SKLXBWPLAIJ37SNDLAPOWJAG";

      function __construct()
      {
        $this->conn = new Conn;
        $this->pdo  = $this->conn->pdo();
      }


      public function list_msgs($idUser){

        $query = $this->pdo->query("SELECT * FROM `disparos_zap` WHERE id_user='$idUser' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if(count($fetch)>0){

          $query = $this->pdo->query("SELECT msg,whatsapp,data,hora FROM `disparos_zap` WHERE id_user='$idUser' ORDER BY id DESC LIMIT 50");
          return $query;

        }else{
          return false;
        }

      }

       public function list_msgs_fila(){

        $query = $this->pdo->query("SELECT * FROM `fila_zap` ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if(count($fetch)>0){
          $query = $this->pdo->query("SELECT * FROM `fila_zap` ORDER BY importante != 1, id ASC LIMIT 1");
          $fetch = $query->fetch(PDO::FETCH_OBJ);
          return $fetch;

        }else{
          return false;
        }

      }


    public function list_msgs_fila_user($id_user){

        $query = $this->pdo->query("SELECT * FROM `fila_zap` WHERE id_user='$id_user' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if(count($fetch)>0){

          $query = $this->pdo->query("SELECT * FROM `fila_zap` WHERE id_user='$id_user' ORDER BY id ASC ");
          return $query;

        }else{
          return false;
        }

      }

  public function phoneValidate($phone)
    {
        $regex = '/^(?:(?:\+|00)?(55)\s?)?(?:\(?([1-9][0-9])\)?\s?)?(?:((?:9\d|[2-9])\d{3})\-?(\d{4}))$/';

        if (preg_match($regex, $phone) == false) {

            // O número não foi validado.
            return false;
        } else {

            // Telefone válido.
            return true;
        }
    }

       public function verifica_fila_lembrete($id){

        $query = $this->pdo->query("SELECT * FROM `fila_zap` WHERE id_user='$id' AND tipo='vencimento_lembrete'");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if(count($fetch)>0){

         return false;

        }else{
          return true;
        }

      }

      public function delete_fila($id){
          $query = $this->pdo->query("DELETE FROM `fila_zap` WHERE id='$id' ");
          if($query){
              return true;
          }else{
              return false;
          }
      }

      public function get_msg_file_by_id($id_user,$id){

          $query = $this->pdo->query("SELECT * FROM `fila_zap` WHERE id_user='$id_user' AND id='$id' ");
          $fetch = $query->fetchAll(PDO::FETCH_OBJ);
          if(count($fetch)>0){

            $query = $this->pdo->query("SELECT * FROM `fila_zap` WHERE id_user='$id_user' AND id='$id'");
            $fetch = $query->fetchAll(PDO::FETCH_OBJ);

            if(count($fetch)>0){
              return $fetch[0];
            }else{
              return false;
            }

          }else{
            return false;
          }

        }

     public function verific_device_situ($user){
        $query = $this->pdo->query("SELECT * FROM `whats_api` WHERE id_user='$user' AND situ='1' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if(count($fetch)>0){

          $query = $this->pdo->query("SELECT * FROM `whats_api` WHERE id_user='$user' AND situ='1' LIMIT 1");
          $fetch = $query->fetch(PDO::FETCH_OBJ);
          return $fetch;

        }else{
          return false;
        }
     }



      public function verific_device($user,$type='rapiwha'){

        $query = $this->pdo->query("SELECT * FROM `whats_api` WHERE id_user='$user' AND api='$type' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if(count($fetch)>0){

          $query = $this->pdo->query("SELECT * FROM `whats_api` WHERE id_user='$user' AND api='$type' LIMIT 1");
          $fetch = $query->fetch(PDO::FETCH_OBJ);
          return $fetch;

        }else{
          return false;
        }

      }

      public function disconect_device($device){

        $url = $this->endpoint.'/api/device/disconnect?client_id='.$this->client_id.'&secret='.$this->secret.'&device_id='.$device;
        $options = array(
            'http' => array(
                'method'  => 'GET',
            )
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        if ($result === FALSE) {
            return false;
            exit();
        }

        $retorno = json_decode($result);
        if($retorno->success == 1){
            return true;
        }else{
            return false;
            exit();
        }


      }

      public function qrcode($device){

        $url = $this->endpoint.'/api/device/connect?client_id='.$this->client_id.'&secret='.$this->secret.'&device_id='.$device;
        $options = array(
            'http' => array(
                'method'  => 'GET'
            )
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        if ($result === FALSE) {
            return false;
            exit();
        }

        $retorno = json_decode($result);
        if($retorno->success == 1){
            return $retorno->qr_code;
        }else{
            return false;
            exit();
        }


      }

      public function dados_fila($id){
        $query = $this->pdo->query("SELECT * FROM `fila_zap` WHERE id='$id' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if(count($fetch)>0){

          $query = $this->pdo->query("SELECT * FROM `fila_zap` WHERE id='$id' LIMIT 1");
          $fetch = $query->fetch(PDO::FETCH_OBJ);
          return $fetch;

        }else{
          return false;
        }
      }

      public function get_template_not_pareado(){

        $query = $this->pdo->query("SELECT * FROM `msg_not_pareado` ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if(count($fetch)>0){

          $query = $this->pdo->query("SELECT * FROM `msg_not_pareado` LIMIT 1");
          $fetch = $query->fetch(PDO::FETCH_OBJ);
          return $fetch;

        }else{
          return false;
        }

      }

      public function verifique_connect($device){

        $url = $this->endpoint.'/api/device/get?client_id='.$this->client_id.'&secret='.$this->secret.'&device_id='.$device;
        $options = array(
            'http' => array(
                'method'  => 'GET',
            )
        );

        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        if ($result === FALSE) {
            return false;
            exit();
        }

        $retorno = json_decode($result);
        if($retorno->success == 1){

            return $retorno->device->status;

        }else{
            return false;
            exit();
        }

      }


      public function create_device_api($nome){

        $url = $this->endpoint.'/api/device/create?client_id='.$this->client_id.'&secret='.$this->secret.'&name='.$nome;
        $options = array(
            'http' => array(
                'method'  => 'GET',
            )
        );


        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        if ($result === FALSE) {
         return false;
         exit();
        }

        $retorno = json_decode($result);
        if($retorno->success == 1){
            return $retorno->device_id;
        }else{
            return false;
            exit();
        }
      }



      public function fila($phone,$text,$user,$device,$api,$codigo,$cliente=0,$tipo=0,$importante=0){


            $query = $this->pdo->prepare("INSERT INTO `fila_zap` (device_id,id_user,destino,msg,api,codigo,id_cliente,tipo,importante) VALUES (:device_id,:id_user,:destino,:msg,:api,:codigo,:id_cliente,:tipo,:importante) ");
            $query->bindValue(':device_id',$device);
            $query->bindValue(':id_user',$user);
            $query->bindValue(':destino',$phone);
            $query->bindValue(':msg',$text);
            $query->bindValue(':api',$api);
            $query->bindValue(':codigo',$codigo);
            $query->bindValue(':id_cliente',$cliente);
            $query->bindValue(':tipo',$tipo);

            if($api == 'gestorbot'){
               $query->bindValue(':importante',1);
            }else{
                $query->bindValue(':importante',$importante);
            }

            if($query->execute()){

             $sql1  = $this->pdo->query("SELECT * FROM `fila_zap` ORDER BY id DESC LIMIT 1 ");
             $fetch = $sql1->fetch(PDO::FETCH_OBJ);

             $this->pdo->query("UPDATE `num_cobrancas` SET num='".$fetch->id."' WHERE id='1'");

              return true;
            }else{
              return false;
            }
      }

      public function cadastro_device($devide,$user){

        $query = $this->pdo->prepare("INSERT INTO `whats_api` (device_id,id_user) VALUES (:device_id,:id_user) ");
        $query->bindValue(':device_id',$devide);
        $query->bindValue(':id_user',$user);

        if($query->execute()){
          return true;
        }else{
          return false;
        }

      }

      public function send($num,$text,$debug=false){

         $msg = urlencode($text);

         $iniciar = curl_init('https://wsapi.in/w/?token='.$this->token.'&type=text&phone='.$num.'&msg='.$msg);
         curl_setopt( $iniciar , CURLOPT_RETURNTRANSFER  , true );
         $response = curl_exec($iniciar);
         curl_close($iniciar);
         $res = json_decode($response);

        if($debug){
         var_dump($response);
        }else{
          if($res->erro){
            return false;
          }else{
            return true;
          }
        }

      }


       public function valida_num($num,$device){

        $url = $this->endpoint.'/api/device/checkNumber?client_id='.$this->client_id.'&secret='.$this->secret.'&device_id='.$device.'&number='.$num;
        $options = array(
            'http' => array(
                'method'  => 'GET'
            )
         );

        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        if ($result === FALSE) {
            return false;
            exit();
        }

        $retorno = json_decode($result);
        if(isset($retorno->success)){
           if($retorno->success == 1 && $retorno->found == 1){
           return $retorno->number;
            }else{
                return false;
                exit();
            }
        }else{
            return false;
            exit();
        }


       }

        public function send_device($num,$text,$device){

         $msg = urlencode($text);

         $url = $this->endpoint.'/api/message/sendText?client_id='.$this->client_id.'&secret='.$this->secret.'&type=text&message='.$msg.'&device_id='.$device.'&recipient='.$num;
         $options = array(
            'http' => array(
                'method'  => 'GET'
            )
         );

        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        if ($result === FALSE) {
            return false;
            exit();
        }

        $retorno = json_decode($result);
        if($retorno->success == 1){
            return true;
        }else{
            return false;
            exit();
        }

      }

      public function count_number_disparos($user){
        $query = $this->pdo->query("SELECT * FROM `disparos_zap` WHERE id_user='$user' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        return count($fetch);
      }

      public function count_fila(){
        $query = $this->pdo->query("SELECT * FROM `fila_zap` ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        return count($fetch);
      }

      public function calc_previsao_disparo($idmsg){

          // get ultimo numero
          $query = $this->pdo->query("select count(*) as pos from fila_zap where id <= {$idmsg} order by id asc");
          $fetch = $query->fetch(PDO::FETCH_OBJ);

          $posicao = $fetch->pos;

          $minutos = $posicao*1;

          $startTime = date("Y-m-d H:i:s");

          $convertedTime = date('Y-m-d H:i:s', strtotime('+'.$minutos.' minutes', strtotime($startTime)));

          return strtotime($convertedTime);

      }

      public function list_msgs_fila_2(){

        $query = $this->pdo->query("SELECT * FROM `fila_zap` ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if(count($fetch)>0){

          $query = $this->pdo->query("SELECT * FROM `fila_zap` ORDER BY id ASC");
          return $query;

        }else{
          return false;
        }

      }


      public function insert_disparo($user,$phone,$text){

        // contar quantos registros o user tem
        $num = self::count_number_disparos($user);

        if($num>19){
          $this->pdo->query("DELETE FROM `disparos_zap` WHERE id_user='$user' ORDER BY id ASC LIMIT 1");
        }

        $query = $this->pdo->prepare("INSERT INTO `disparos_zap` (msg,whatsapp,data,hora,id_user) VALUES (:msg,:whatsapp,:data,:hora,:id_user) ");
        $query->bindValue(':msg',$text);
        $query->bindValue(':whatsapp',$phone);
        $query->bindValue(':data',date('d/m/Y'));
        $query->bindValue(':hora',date('H:i'));
        $query->bindValue(':id_user',$user);


        if($query->execute()){
          return true;
        }else{
          return false;
        }

      }


      public function get_template($gatilho){

        $query = $this->pdo->query("SELECT * FROM `text_zap_gestor_lite` WHERE gatilho='$gatilho' ");
        $fetch = $query->fetchAll(PDO::FETCH_OBJ);
        if(count($fetch)>0){

          $query = $this->pdo->query("SELECT * FROM `text_zap_gestor_lite` WHERE gatilho='$gatilho' ");
          $fetch = $query->fetch(PDO::FETCH_OBJ);
          return $fetch;

        }else{
          return false;
        }

      }


 }




?>
