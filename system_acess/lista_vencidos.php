<?php

echo "Not Found";
die;

set_time_limit(1200);//coloque no inicio do arquivo
ini_set('max_execution_time', 1200);

// Autoload
 class Autoload {
    
        public function __construct() {
    
            spl_autoload_extensions('.class.php');
            spl_autoload_register(array($this, 'load'));
    
        }
    
        private function load($className) {
    
            $extension = spl_autoload_extensions();
             require_once ('../class/' . $className . $extension);
        }
    }
    
    $autoload = new Autoload();
    
    
    $s    = scandir("../class");
    $arrayClass = array();
     foreach ($s as $k){
       if($k != "." && $k != ".."){
          $ex = explode('.',$k);
          $classe = $ex[0];
          $arrayClass[$classe] = new $classe();
       }
     }
    
    $i = (object)$arrayClass;
    
    $conn = new Conn();
    $pdo = $conn->pdo();
    
    
    $id = $_GET['id'];
    
      function link_texto($texto){

         if (!is_string ($texto))
             return $texto;

            $er = "/(https:\/\/(www\.|.*?\/)?|http:\/\/(www\.|.*?\/)?|www\.)([a-zA-Z0-9]+|_|-)+(\.(([0-9a-zA-Z]|-|_|\/|\?|=|&)+))+/i";

            $texto = preg_replace_callback($er, function($match){
                $link = $match[0];

                //coloca o 'http://' caso o link nao o possua
                $link = (stristr($link, "http") === false) ? "http://" . $link : $link;

                //troca "&" por "&", tornando o link vÃ¡lido pela W3C
                $link = str_replace ("&", "&amp;", $link);
                $a = str_replace('http://','',((strlen($link) > 60) ? substr ($link, 0, 25). "...". substr ($link, -15) : $link));

                return "<a href=\"" . strtolower($link) . "\" target=\"_blank\">". $a ."</a>";
            },$texto);

            return $texto;

        }
    
    $query_select_vencidos = $pdo->query("SELECT * FROM `user` WHERE id='$id' ORDER BY id ASC");
    $user = $query_select_vencidos->fetch(PDO::FETCH_OBJ);
    
    
     if($user){
         
         
         if($user->vencimento != 0 && $user->vencimento != ""){

            $explodeData  = explode('/',$user->vencimento);
            $explodeData2 = explode('/',date('d/m/Y'));
            $dataVen      = $explodeData[2].$explodeData[1].$explodeData[0];
            $dataHoje     = $explodeData2[2].$explodeData2[1].$explodeData2[0];

            $Pvencimento = str_replace('/','-',$user->vencimento);
            $timestamp   = strtotime("-3 days",strtotime($Pvencimento));
            $venX        = date('d/m/Y', $timestamp);

            $timestamp   = strtotime("-2 days",strtotime($Pvencimento));
            $venY        = date('d/m/Y', $timestamp);

            $timestamp   = strtotime("-1 days",strtotime($Pvencimento));
            $venZ        = date('d/m/Y', $timestamp);


           if($dataHoje > $dataVen || $user->vencimento == "00/00/0000"){
               
               
             $img = "<?=SET_URL_PRODUCTION?>/template_mail/template_1/img/heart.png";
             $titulo = explode(' ',$user->nome)[0]." Não esqueça de nós 💜 !!! ";
             $email = $user->email;
             $nome  = explode(' ',$user->nome)[0];
                    
             $html  = file_get_contents("../template_mail/template_1/index.html");
             $texto = "Oi {$nome}. Não esqueça de nós. \n\nNós da Gestor Lite melhoramos muito desde de que nos conhecemos! \n\nVeja só algumas mudanças: \n\n - Integração com Xtream-UI\n- Gerador de Testes\n- Link de pagamentos\n- ChatBot para whatsapp\n- Mensagens automáticas whatsapp free\n- Área do cliente melhorada\n - PicPay/MercadoPago/TED \n- Envio de emails\n\n  Olha que tem mais em!\n\n https://www.youtube.com/watch?v=x4JQG3ISt-Q \n\n https://www.youtube.com/watch?v=HvIYv-rlp3Q \n\n https://www.youtube.com/watch?v=Lrtt1CJmJi8 \n\n Nos visite de novo. Podemos melhorar ainda mais com você 💜 \n\n Acesse gestorlite.com e veja as novidades. Abçs 😍";               
             $body = str_replace('{cancel_insc}',$link_cancel,str_replace(date('d/m/Y'),"Hoje",str_replace("{imagem}",$img,str_replace("{titulo}","Olá {$nome} !",str_replace("{texto}",link_texto($texto),$html)))));
            
             $obj = new stdClass();
             $obj->nome = $titulo;
             $obj->corpo = $body;
            
             $to = $email;
             $subject = $titulo;
             $from = 'contact@gestorlite.com';
             
             $headers  = 'MIME-Version: 1.0' . "\r\n";
             $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
             
             $headers .= "From: Gestor Lite <{$from}> \r\n".
                'Reply-To: '.$from."\r\n" .
                'X-Mailer: PHP/' . phpversion();
               
             mail($to, $subject, $obj->corpo, $headers);  
               
             $ar1   = array('+',')','(',' ','-');
             $ar2   = array('','','','','');
             $phone = $user->ddi.str_replace($ar1,$ar2,$user->telefone);
             
             if($_GET['id'] > 36){
                $init = file_get_contents('http://94.156.189.238:3000/send?num='.$phone.'&msg='.urlencode($texto));
             }
            
            }

         }
        
        
     }
    
    $nId = ($_GET['id']+1);
    ?>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
    
    <center>
        <div style="font-family:arial;" >
            <h2 id="" >ID: <?= $_GET['id']; ?></h2>
            <h2 id="segundos" >0</h2>
        </div>
    </center>';
    <script>
        
        setInterval(function(){ 
        
        var segundos = $("#segundos").text(); 
        var nS = (parseInt(segundos) + 1); 
        $("#segundos").text(nS); 
            
        },1000);
        
    </script>
    
    
    
  <script>
  setTimeout(function(){
      location.href="?id=<?= $nId; ?>";
  },20000);
  </script> 
    
    