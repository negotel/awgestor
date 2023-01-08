<?php


  if(isset($_GET['msg'])){


    $msg   = trim($_GET['msg']);
    if(isset($_GET['valor'])){
      $valor = $_GET['valor'] == "" ? "0,00" : $_GET['valor'];
    }else{
      $valor = "0,00";
    }

    if(isset($_GET['plano_nome'])){
      $plano_nome = $_GET['plano_nome'] == "" ? "Plano nome" : $_GET['plano_nome'];
    }else{
      $plano_nome = "Plano nome";
    }



    $array1 =  array('{senha_cliente}','{nome_cliente}','{primeiro_nome_cliente}','{email_cliente}','{telefone_cliente}','{vencimento_cliente}','{plano_nome}','{plano_valor}','{data_atual}','{plano_link}');
    $array2 = array("senha#exemplo","Raul Seixas","Raul","cliente_mail@gestorlite.com","5544991136458","14/01/2020",$plano_nome,str_replace(' ','',str_replace('R$','',$valor)),date('d/m/Y'),'https://glite.me/p/GWg');


    $texto = str_replace($array1,$array2,$msg);

    $pattern = '/\*.*?\*/';

    preg_match_all($pattern, $texto, $result);

    $ar1 = $result[0];
    $ar2 = array();

    foreach ($result as $value) {
      foreach ($value as $key => $palavras){

        $explo = explode("*",$palavras);
        $new   = '<b>'.$explo[1].'</b>';

       $ar2[$key] = $new;

      }
    }

   $texto = str_replace($ar1,$ar2,$texto);


   function link_texto($texto){

         if (!is_string ($texto))
             return $texto;

            $er = "/(https:\/\/(www\.|.*?\/)?|http:\/\/(www\.|.*?\/)?|www\.)([a-zA-Z0-9]+|_|-)+(\.(([0-9a-zA-Z]|-|_|\/|\?|=|&)+))+/i";

            $texto = preg_replace_callback($er, function($match){
                $link = $match[0];

                //coloca o 'http://' caso o link não o possua
                $link = (stristr($link, "http") === false) ? "http://" . $link : $link;

                //troca "&" por "&", tornando o link válido pela W3C
                $link = str_replace ("&", "&amp;", $link);
                $a = str_replace('http://','',((strlen($link) > 60) ? substr ($link, 0, 25). "...". substr ($link, -15) : $link));

                return "<a href=\"" . strtolower($link) . "\" target=\"_blank\">". $a ."</a>";
            },$texto);

            return $texto;

        }


        $texto = link_texto($texto);


        $pattern = '/\_.*?\_/';

        preg_match_all($pattern, $texto, $result);

        $ar1 = $result[0];
        $ar2 = array();

        foreach ($result as $value) {
          foreach ($value as $key => $palavras){

            $explo = explode("_",$palavras);
            $new   = '<i>'.$explo[1].'</i>';

           $ar2[$key] = $new;

          }
        }

       $texto = str_replace($ar1,$ar2,$texto);

  }




?>








<!doctype html>
<html lang="pt-br">
  <head><meta charset="windows-1252">
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Script Mundo">
    <meta name="generator" content="Script Mundo">
    <title id="page-title" >Preview Whatsapp - Planos</title>

    <!-- Custom styles for this template -->
    <link href="style.css" rel="stylesheet">
  </head>
  <body >



<div class="page">
  <div class="marvel-device nexus5">
    <div class="top-bar"></div>
    <div class="sleep"></div>
    <div class="volume"></div>
    <div class="camera"></div>
    <div class="screen">
      <div class="screen-container">
        <div class="status-bar">
          <div class="time"></div>
          <div class="battery">
            <i class="zmdi zmdi-battery"></i>
          </div>
          <div class="network">
            <i class="zmdi zmdi-network"></i>
          </div>
          <div class="wifi">
            <i class="zmdi zmdi-wifi-alt-2"></i>
          </div>
          <div class="star">
            <i class="zmdi zmdi-star"></i>
          </div>
        </div>
        <div class="chat">
          <div class="chat-container">
            <div class="user-bar">
              <div class="back">
                <i class="zmdi zmdi-arrow-left"></i>
              </div>
              <div class="avatar">
                <img src="avatar.png" alt="Avatar">
              </div>
              <div class="name">
                <span>Notificações</span>
                <span class="status">online</span>
              </div>
              <div class="actions more">
                <i class="zmdi zmdi-more-vert"></i>
              </div>
              <div class="actions attachment">
                <i class="zmdi zmdi-attachment-alt"></i>
              </div>
              <div class="actions">
                <i class="zmdi zmdi-phone"></i>
              </div>
            </div>
            <div class="conversation">
              <div style="white-space:pre;" class="conversation-container">

                <div class="message received " ><?= $texto; ?><span class="metadata"><span class="time"></span></span></div>
                <div class="message sent"> OK 🤙<span class="metadata"><span class="time"></span><span class="tick"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="15" id="msg-dblcheck-ack" x="2063" y="2076"><path d="M15.01 3.316l-.478-.372a.365.365 0 0 0-.51.063L8.666 9.88a.32.32 0 0 1-.484.032l-.358-.325a.32.32 0 0 0-.484.032l-.378.48a.418.418 0 0 0 .036.54l1.32 1.267a.32.32 0 0 0 .484-.034l6.272-8.048a.366.366 0 0 0-.064-.512zm-4.1 0l-.478-.372a.365.365 0 0 0-.51.063L4.566 9.88a.32.32 0 0 1-.484.032L1.892 7.77a.366.366 0 0 0-.516.005l-.423.433a.364.364 0 0 0 .006.514l3.255 3.185a.32.32 0 0 0 .484-.033l6.272-8.048a.365.365 0 0 0-.063-.51z" fill="#4fc3f7"/></svg></span></span></div>

              </div>
              <div class="conversation-compose">

                <p style="margin:5px;font-size:10px;" >DICA: Sempre quebre a linha para melhor visualização</p>


              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://use.fontawesome.com/fc727a7e55.js"></script>
<script src="js/function.js"></script>

</body>
</html>
