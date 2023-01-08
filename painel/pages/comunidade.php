<?php 
 
 echo '<script>location.href="home";</script>';
 die;

 $comunidade_class = new Comunidade();
 $user_class       = new User();
 $gestor_class     = new Gestor();
 
 $total_posts = 6;
 

 if(isset($_GET['page'])){
     if(is_numeric($_GET['page'])){
         if($_GET['page'] == 0){
             $pagina = 1;
         }else{
             $pagina = $_GET['page'];
         }
     }else{
         $pagina = 1;
     }
 }else{
     $pagina = 1;
 }
 
 $inicio = $pagina - 1;
 $inicio = $inicio * $total_posts;
 
 
 $anterior = $pagina -1;
 $proximo  = $pagina +1;


 $posts = $comunidade_class->get_posts($inicio,$total_posts);
 $total_posts_bd = $comunidade_class->get_posts_qtd();
 $num_paginas = ($total_posts_bd/$total_posts);
 
   function formata_texto($texto){

     if (!is_string ($texto))
         return $texto;

        $er = "/(https:\/\/(www\.|.*?\/)?|http:\/\/(www\.|.*?\/)?|www\.)([a-zA-Z0-9]+|_|-)+(\.(([0-9a-zA-Z]|-|_|\/|\?|=|&)+))+/i";

        $texto = preg_replace_callback($er, function($match){
            $link = $match[0];

            //coloca o 'http://' caso o link nÃ£o o possua
            $link = (stristr($link, "http") === false) ? "http://" . $link : $link;

            //troca "&" por "&", tornando o link vÃ¡lido pela W3C
            $link = str_replace ("&", "&amp;", $link);
            $a = str_replace('http://','',((strlen($link) > 60) ? substr ($link, 0, 25). "...". substr ($link, -15) : $link));

            return "<a style=\"color: #9100ff;text-decoration: none;\" href=\"" . strtolower($link) . "\" target=\"_blank\">". $a ."</a>";
        },$texto);


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
            
            return $texto;

    }
?>
<!-- Head and Nav -->
<?php include_once 'inc/head-nav.php'; ?>

   <style>
       .iti {
           width:100%;
       }
       .emoji-wysiwyg-editor{
           font-size: 26px;
           padding: 22px;
           line-height: normal;
           height: 50px!important;
           border-bottom: 1px solid gray;
           border-left: none;
           border-right: none;
           border-top: none;
       }
       .bg-dark .page-item .page-link{
           color:#000!important;
       }
       .bg-dark .page-content .row .text_post_classs{
           background-color: rgb(10 10 1 / 9%);
           color:#fff!important;
       }
   </style>

    <!-- NavBar -->
    <?php include_once 'inc/nav-bar.php'; ?>

     <main class="page-content">
    
        <div class="">
            
            <div style="padding: 10px;-webkit-box-shadow: 0px 0px 16px -2px rgb(0 0 0 / 84%);box-shadow: 0px 0px 16px -2px rgb(0 0 0 / 84%);width: 99%;" class="row card">
                <div class="col-md-12">
                    <textarea class="text_post_classs" rows="3" data-emojiable="true" data-emoji-input="unicode" id="post_content" maxlength="500" style="width: 100%;height: 95px;font-size: 25px;padding: 16px;border-bottom: 1px solid gray;border-left: none;border-right: none;border-top: none;" class="" placeholder="Oque quer compartilhar hoje <?= explode(' ',$user->nome)[0];?>?" ></textarea>
                    <small>Apenas 500 carecteres | <a href="<?=SET_URL_PRODUCTION?>/painel/termo_comunidade" target="_blank"><i class="fa fa-file"></i> Regras da comunidade</a></small>
                </div>
                <div class="col-md-12 text-right">
                    <button onclick="post_push();" id="btn_post" style="width: 19%;border: none;height: 47px;font-size: 24px;background-color: #9100ff;color: #fff;border-radius: 8px;text-transform: uppercase;" >Postar</button>
                </div>
            </div>
            
           <div style="padding: 10px;-webkit-box-shadow: 0px 0px 16px -2px rgb(0 0 0 / 84%);box-shadow: 0px 0px 16px -2px rgb(0 0 0 / 84%);width: 99%;" class="card row">
               
               <?php if($posts){ ?>
               
                <?php foreach($posts as $key => $post){
                
                    // autor post
                    $autor = $user_class->dados($post->autor);
                
                
                
                
                ?>
                
                    <div style="border-bottom: 1px solid #d500ff;margin: 10px;padding-bottom: 12px;width: 99%;" class="post col-md-12">
                        <div class="row">
                            
                            <div class="header-post col-md-1">
                                <div class="row">
                                    <div class="col-md-1">
                                        <img style="border-radius: 50px;border: 1px solid #d500ff;" class="img-responsive img-rounded" src="https://www.gravatar.com/avatar/<?= md5($autor->email); ?>?v=<?= date('dmyihs'); ?>" alt="User picture">
                                    </div>
                                </div>
                            </div>
                            <div  class="col-md-11">
                                <span style="font-size: 19px;"> <?= $autor->nome; ?> <?php if($autor->id == '156' || $autor->id == '3971'){ echo '<img style="top: 6px!important;position: absolute;margin-left: 7px;" src="<?=SET_URL_PRODUCTION?>/painel/img/verificado_comunidade.png" width="20" />'; } ?></span>
                                <p style="font-size: 23px;"><?= formata_texto($post->content); ?></p>
                            </div>
                            <div class="col-md-1"></div>
                            <div class="col-md-11 footer-post">
                                <div class="row">
                                    <div class="col-md-2 text-left">
                                       <?= $gestor_class->tempo_corrido($post->data); ?>
                                    </div>
                                    <div style="font-size: 18px;color: #9100ff;"  class="col-md-1 text-left">
                                        <i onclick="add_like(<?= $post->id; ?>);" style="cursor:pointer;" class="fa fa-heart"></i> <span id="num_likes_<?= $post->id; ?>"><?= $post->likes; ?></span>
                                    </div>
                                    <?php if($autor->id == $user->id){ ?>
                                    <div style="font-size: 18px;color: #9100ff;"  class="col-md-3 text-left">
                                        <i onclick="remove_post(<?= $post->id; ?>);" style="cursor:pointer;" class="fa fa-trash"></i>  <span id="load_trash_<?= $post->id; ?>"></span>
                                    </div>
                                    <?php }else{ ?>
                                    <div onclick="reply_comunidade('<?= $autor->nome; ?>');" style="cursor:pointer;font-size: 18px;color: #9100ff;"  class="col-md-2 text-left">
                                        <i class="fa fa-reply"></i> Responder</span>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                
                <?php } ?>
               
               
               <?php }else{ ?>
                <div clas="col-md-12 text-center">
                    <h5>Não há publicações ainda</h5>
                </div>
               <?php } ?>
               
          
         
            </div>
            
            <div class="card row text-center" style="padding: 10px;-webkit-box-shadow: 0px 0px 16px -2px rgb(0 0 0 / 84%);box-shadow: 0px 0px 16px -2px rgb(0 0 0 / 84%);width: 99%;">
                <center>
                    <nav aria-label="Navegação de página exemplo">
                      <ul class="pagination">
                        <li class="page-item"><a class="page-link" href="comunidade?page=<?= $anterior; ?>">Anterior</a></li>
                        <?php for($i = 1; $i < $num_paginas + 1; $i++) {?>
                        
                            <?php if($i == $pagina){ ?>
                              <li class="page-item" style="cursor:no-drop;" ><a class="page-link" ><?= $i; ?></a></li>
                             <?php }else{ ?>
                              <li class="page-item"><a class="page-link" href="comunidade?page=<?= $i; ?>"><?= $i; ?></a></li>
                        <?php  } }?>

                        <li class="page-item"><a class="page-link" href="comunidade?page=<?= $proximo; ?>">Próximo</a></li>
                      </ul>
                    </nav>
                </center>
            </div>
            
        </div>
        
    </main>
  </div>
</div>



 <!-- footer -->
 <?php include_once 'inc/footer.php'; ?>
 
 <script src="sons/soundmanager2.js"></script>
 <script>
 
     function reply_comunidade(autor){
         
         var html_reply = '*@'+autor+'* ';
         $("#post_content").val(html_reply);
         $("#post_content").focus();
         
         $('html, body').animate({
            scrollTop: $("#post_content").offset().top
        }, 1000);
        

     }
 
    function post_push(){

        $("#btn_post").prop('disabled', true);
        $("#btn_post").html("Publicando <i class='fa fa-refresh fa-spin' ></i>");
         
         var content = $("#post_content").val();
         $.post('../control/control.post_comunidade.php',{publicar:true,content:content},function(data){
             
             $("#btn_post").prop('disabled', false);
             $("#btn_post").html("Postar");
        
             try{
                 var obj = JSON.parse(data);
                  if(obj.erro){
                     alert(obj.msg);
                     return false;
                 }else{
                       soundManager.onready(function() {
                        soundManager.createSound({
                            id: 'mySound',
                            url: 'sons/post_push.ogg'
                        });
                
                        // ...and play it
                        soundManager.play('mySound');
                    });
                    
                     setTimeout(function(){
                         location.href="";
                     },1000);
                 }
             }catch(e){
                 alert('Desculpe, tente novamente mais tarde');
             }
         });    
    }
       
 
     
     function add_like(post){
         $.post('../control/control.post_comunidade.php',{add_like:true,post:post},function(data){
             $("#num_likes_"+post).html(data);

             // where to find flash SWFs, if needed...

            soundManager.onready(function() {
                soundManager.createSound({
                    id: 'mySound',
                    url: 'sons/post_public.ogg'
                });
        
                // ...and play it
                soundManager.play('mySound');
            });
            
         });
     }
     
     function remove_post(post){
         $("#load_trash_"+post).html("Aguarde <i class='fa fa-refresh fa-spin' ></i>");
         $.post('../control/control.post_comunidade.php',{remove_post:true,post:post},function(data){
             
             if(data == 1){
                 
                soundManager.onready(function() {
                    soundManager.createSound({
                        id: 'mySound',
                        url: 'sons/post_trash.ogg'
                    });
                    soundManager.play('mySound');
                });
                
                setTimeout(function(){
                     location.href="";
                 },4000);

                
             }else{
                 alert("Erro ao remover");
                 $("#load_trash_"+post).html("");
             }
         });
     }
     
 
 </script>
 
 
<!-- Modal -->
<div class="modal fade" id="modalGoogleAuth" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Configurar Autenticação de 2 Fatores</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <?php  
            $g = new GoogleAuthenticator();
            $time = floor(time() / 30);
            $secret = $g->generateSecret();
          
          ?>
       
       <div class="row">
           
           <div class="col-md-12 text-center" >
               
               <h3> <img src="https://play-lh.googleusercontent.com/HPc5gptPzRw3wFhJE1ZCnTqlvEvuVFBAsV9etfouOhdRbkp-zNtYTzKUmUVPERSZ_lAL" width="50px" /> Google Authenticator</h3>
               <p>
                   Como usar? <a href="https://support.google.com/accounts/answer/1066447?hl=pt-br" target="_blank">Clique aqui</a>
               </p>
               
           </div>
           
           <div class="col-md-12 " >
               
               <div class="form-group" >
                  <p>Nome da conta: <b>gestorlite</b></p>
                  <center> <img src="https://chart.googleapis.com/chart?chs=200x200&chld=M|0&cht=qr&chl=otpauth://totp/gestorlite@gestorlite.com&secret=<?= $secret; ?>" class="img-thumbnail" /></center>
               </div>
               <div class="text-left" >
                   <p style='font-size:11px;color:gray;'>Não consegue ler o QrCode? Use a chave:</p>
                   <p>Chave Secreta: <b><?= $secret; ?></b></p>
               </div>
               
           </div>
           <hr>
           <div style="border-top: 1px solid #7922ff;padding-top: 14px;" class="col-md-12 text-center" >

             <div class="row">
                 
               <div class="col-md-8 form-group text-center" >
                   <label>Código de autenticação de 6 digitos</label>
                   <input maxlength="6" id="cod_auth" width="100%" type="text" placeholder="XXX XXX" value="" class="form-control" />
                   <input type="hidden" value="<?= $secret; ?>" id="secret_tk" />
               </div>
               <div class="col-md-4 form-group" >
                   <label>&nbsp;</label>
                    <button id="btn_insertTwoAuth" onclick="insertTwoAuth();" style="width:100%;" class="btn btn-success" >Validar</button>
               </div>
               <div class="text-left col-md-12 form-group" >
                   <p class="text-danger" style="font-size:12px;cursor:pointer;" onclick="removeAuth(); ">Remover Autenticação</p>
               </div>
               <div class="text-center col-md-12 form-group" >
                   <b id="reporting_auth" ></b>
               </div>
             </div>
               
           </div>
           
       </div>
       
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>

