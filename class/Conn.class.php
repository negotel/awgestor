<?php

@date_default_timezone_set('America/Sao_Paulo');
@session_start();

class Conn
{

    private $host = SET_DB_HOSTNAME;
    private $user = SET_DB_USERNAME;
    private $senha = SET_DB_PASSWORD;
    private $bd = SET_DB_NAME;

    public function pdo()
    {
        $host = $this->host;
        $user = $this->user;
        $senha = $this->senha;
        $bd = $this->bd;

        try {
            $pdo = new \PDO("mysql:host=$host;dbname=$bd", $user, $senha, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8MB4"));

            if (isset($_SESSION['SEND_MAIL_ERRO'])) {
                unset($_SESSION['SEND_MAIL_ERRO']);
            }

            return $pdo;
            $pdo = null;
        } catch (PDOException $e) {
            echo "<div style='margin-top:100px;text-align:center;font-family:arial;'><h1 >Manutenção</h1><p>Retornaremos em breve: {$e}</p><div>";
            // enviar email to me

            /*  if(!isset($_SESSION['SEND_MAIL_ERRO'])){
                   $texto = "Olá Admin. O site está desconectado da base de dados. \n\n\n Data: ".date('d/m/Y - H:i:s');

                   $html   = file_get_contents("<?=SET_URL_PRODUCTION?>/template_mail/template_1/index.html");
                   $img    = "<?=SET_URL_PRODUCTION?>/template_mail/template_1/img/close.png";
                   $titulo = "Site desconectado da base de dados";
                   $email  = 'luanalvesnsr@gmail.com';
                   $nome   = 'Administrador';

                   $body = str_replace(date('d/m/Y'),"Hoje",str_replace("{imagem}",$img,str_replace("{titulo}","Olá {$nome} !",str_replace("{texto}",$texto,$html))));

                   $to = $email;
                   $subject = $titulo;
                   $from = 'contact@gestorlite.com';

                   $headers  = 'MIME-Version: 1.0' . "\r\n";
                   $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

                    $headers .= "From: Gestor Lite <{$from}> \r\n".
                      'Reply-To: '.$from."\r\n" .
                      'X-Mailer: PHP/' . phpversion();
                   if( mail($to, $subject, $body, $headers) ){
                       $_SESSION['SEND_MAIL_ERRO'] = true;
                   }

              } */

            die;
        }
    }

}

?>
