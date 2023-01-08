<?php

if($plano_usergestor->chatbot != 1){
  echo '<script>location.href="cart?upgrade"</script>';
  exit;
}

 if(!isset($_GET['app'])){
   echo '<script>location.href="settings_chatbot"</script>';
   exit;
 }else{
   $app = trim($_GET['app']);
 }

$chatbot = new ChatBot();
$getChatbot = $chatbot->getchatbotByUser($user->id);

$chatbot_id = 0;

if($getChatbot){
  $replys = $chatbot->get_replys_chat_bot($user->id);
  $chatbot_id = $getChatbot->id;
}

?>



<!-- Head and Nav -->
<?php include_once 'inc/head-nav.php'; ?>




  <?php include_once 'inc/head-nav.php'; ?>
  <?php include_once 'inc/sidebar.php'; ?>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">

  <link rel="stylesheet" href="css/whatsapp.css?v=<?= filemtime("css/whatsapp.css"); ?>" />

  <script src="js/whatsapp.js?v=<?= filemtime("js/whatsapp.js"); ?>" ></script>


  <input type="hidden" id="chatbot_id" value="<?= $user->id; ?>" />
  <input type="hidden" id="app" value="<?= $app; ?>" />

  <section class="main_content dashboard_part">
    <?php include_once 'inc/nav.php'; ?>

    <div class="main_content_iner ">

      <div class="container-fluid plr_30 body_white_bg pt_30">

        <div class="row justify-content-center">

          <div class="right">
            <div class="info">
              <div class="thumbnail"></div>
              <span class="chatname">Chat Bot</span>
              <div class="edit">
                <span class="menu">…</span>
                <span class="attachment"></span>
                <span class="searchchat"></span>
              </div>
            </div>
            <div class="chat">
              <div class="chat-msg">
                <div class="recebe">
                   Digite uma mensagem para o bot
                </div>
              </div>

            </div>
            <div class="send">
              <input id="msg_send" type="text" placeholder="Digite aqui a mensagem" />
              <span class="mic"></span>
              <span onclick="sendMsg();" class="sendmessage" >
                <img width="20" style="cursor:pointer;" src="img/btn_send.png" alt="">
              </span>
            </div>
          </div>
        </div>
      </div>

    </div>

  </section>

  <!-- footer -->
  <?php include_once 'inc/footer.php'; ?>
