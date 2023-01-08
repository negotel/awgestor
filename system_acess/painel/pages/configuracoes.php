<?php 
 
  include_once("../auth/lib/GoogleAuthenticator.php");

 
 
 $gateways_class = new Gateways();
 
 if($plano_usergestor->gateways){
     $plano_gate = 1;
     $mp_credenciais = $gateways_class->dados_mp_user($_SESSION['SESSION_USER']['id']);
 }else{
     $mp_credenciais = new stdClass;
     $mp_credenciais->client_id = '';
     $mp_credenciais->client_secret = '';
     $plano_gate = 0;
 }
 
 

?>
<!-- Head and Nav -->
<?php include_once 'inc/head-nav.php'; ?>

   <link href="js/intlTelInput/css/intlTelInput.css" rel="stylesheet">
   
   <style>
       .iti {
           width:100%;
       }
   </style>

    <!-- NavBar -->
    <?php include_once 'inc/nav-bar.php'; ?>

     <main class="page-content">
    
<div class="">
            
            <div style="padding: 10px;-webkit-box-shadow: 0px 0px 16px -2px rgb(0 0 0 / 84%);box-shadow: 0px 0px 16px -2px rgb(0 0 0 / 84%);width: 99%;" class="card row" >
           
        
      <div class="col-md-12">
        <h1 class="h2"><?= $idioma->configuracoes;?> <i class="fa fa-cogs" ></i> </h1>
        <span>
          <a href="registros" > <i class="fa fa-bug"></i> Logs</a>
        <?php if(!isset($_SESSION['SESSION_CVD'])){ ?>
          - <a href="convidados" ><i class="fa fa-users"></i> Membros da equipe </a>
        <?php } ?>
        </span>
         
      </div>

     
      
     <?php if(isset($_SESSION['SESSION_CVD'])){ ?>
      
      <div class="col-md-12">
      <div class="row text-center">
        <div class="col-md-12">
          <h2>Você não permissão para acessar está pagina</h2>
        </div>
      </div>
      </div>
      
      <?php }else{ ?>
      
    <div class="col-md-12">
        
      <div class="form-group row text-center">
        <div class="col-md-12">
          <span class="text-center" id="msg_retorno"></span>
        </div>
      </div>
      
        <div class="form-group row">
          <label for="" class="col-sm-2 col-form-label">Autenticação de 2 fatores</label>
          <div class="col-sm-10">
            <div class="col-auto my-1">
              <button class="btn btn-primary btn-sm" onclick='$("#modalGoogleAuth").modal("show");' > <i class="fa fa-google" ></i> Configurar autenticação</button>
            </div>
          </div>
        </div>
      
       <div class="form-group row">
          <label for="" class="col-sm-2 col-form-label">Idioma</label>
          <div class="col-sm-10">
            <div class="col-auto my-1">
              <div id="google_translate_element"></div>
            </div>
          </div>
        </div>
      
       <div class="form-group row">
          <label for="dark_user" class="col-sm-2 col-form-label">Tema Escuro</label>
          <div class="col-sm-10">
            <div class="col-auto my-1">
              <div class="custom-control custom-checkbox mr-sm-2">
                <input style="cursor:pointer;" <?php if($user->dark == '1'){ echo "checked"; } ?> value="1" type="checkbox" id="dark_user" name="dark_user" class="custom-control-input">
                <label style="cursor:pointer;" class="custom-control-label" for="dark_user">Status</label>
              </div>
            </div>
          </div>
        </div>

       
      <div class="form-group row">
        <label for="dias_aviso_antecipado" class="col-sm-2 col-form-label">Notificações com antecedência </label>
        <div class="col-sm-10">
          <select class="form-control" id="dias_aviso_antecipado" name="dias_aviso_antecipado">
            <option <?php if($user->dias_aviso_antecipado == '1'){ echo "selected"; } ?> value="1">1 dia antes do vencimento de seus clientes</option>
            <option <?php if($user->dias_aviso_antecipado == '2'){ echo "selected"; } ?> value="2">2 dias antes do vencimento de seus clientes</option>
            <option <?php if($user->dias_aviso_antecipado == '3'){ echo "selected"; } ?> value="3">3 dias antes do vencimento de seus clientes</option>
            <option <?php if($user->dias_aviso_antecipado == '4'){ echo "selected"; } ?> value="4">4 dias antes do vencimento de seus clientes</option>
            <option <?php if($user->dias_aviso_antecipado == '5'){ echo "selected"; } ?> value="5">5 dias antes do vencimento de seus clientes </option>
            <option <?php if($user->dias_aviso_antecipado == '6'){ echo "selected"; } ?> value="6">6 dias antes do vencimento de seus clientes </option>
            <option <?php if($user->dias_aviso_antecipado == '7'){ echo "selected"; } ?> value="7">7 dias antes do vencimento de seus clientes</option>
          </select>
          <small>Você pode escolher com quantos dias de antecedência o gestor lembre seu cliente para pagamento do plano</small>
        </div>
      </div>

      <div class="form-group row">
        <label for="nome_user" class="col-sm-2 col-form-label">Nome</label>
        <div class="col-sm-10">
          <input type="text" name="nome_user" class="form-control" id="nome_user" value="<?= $user->nome; ?>">
        </div>
      </div>


        <div class="form-group row">
          <label for="email_user" class="col-sm-2 col-form-label">Email</label>
          <div class="col-sm-10">
            <input type="email" name="email_user" class="form-control" id="email_user" value="<?= $user->email; ?>">
          </div>
        </div>

        <div class="form-group row">

        <label for="telefone_user" class="col-sm-2 col-form-label">Telefone</label>

          <div class="col-sm-10">
            <input style="width:100%;" type="text" name="telefone_user" class="form-control" value="<?= $user->telefone; ?>" id="telefone_user" placeholder="Telefone">
          </div>
        </div>

        <div class="form-group row">
          <label for="senha_user" class="col-sm-2 col-form-label">Senha</label>
          <div class="col-sm-10">
            <input type="password" name="senha_user" class="form-control" id="senha_user" value="" placeholder="Alterar senha" >
          </div>
        </div>
        
         <?php if($plano_gate){ ?>
        
          <div style="display:none;" class="form-group row">
            <label for="" class="col-sm-2 col-form-label">Mercado Pago <i class="fa fa-handshake-o" ></i>  </label>
            <div class="col-sm-5">
              <input type="text" name="mp_client_id" class="form-control" id="mp_client_id" placeholder="Credencial Mercado Pago ( client_id )" value="<?= @$mp_credenciais->client_id; ?>">
               <small><a href="https://www.mercadopago.com/mlb/account/credentials?type=basic" target="_blank" ><i class="fa fa-external-link"></i></a> <b>cliente_id</b> do <b>Mercado Pago</b>.  (Deixe em branco para não utilizar)</small>
            </div>
            <div class="col-sm-5">
              <input type="text" name="mp_client_secret" class="form-control" id="mp_client_secret" placeholder="Credencial Mercado Pago ( client_secret ) " value="<?= @$mp_credenciais->client_secret; ?>">
              <small><a href="https://www.mercadopago.com/mlb/account/credentials?type=basic" target="_blank" ><i class="fa fa-external-link"></i></a> <b>cliente_secret</b> do <b>Mercado Pago</b>. (Deixe em branco para não utilizar)</small>
            </div>
          </div>
          
    
        <?php }else{ ?>
        
          <div class="form-group row">
            <label for="" class="col-sm-2 col-form-label"><i class='text-primary fa fa-star' ></i> Mercado Pago <i class="fa fa-handshake-o" ></i> </label>
            
            <div class="col-sm-5">
              <a href="<?=SET_URL_PRODUCTION?>/painel/cart?upgrade">
               <input style="cursor:no-drop;" type="text" disabled class="form-control" placeholder="Credencial Mercado Pago ( client_id ) UPGRADE" value="">
              </a>
              <small><b>cliente_id</b> do <b>Mercado Pago</b>. (Deixe em branco para não utilizar)</small>
            </div>
            <div class="col-sm-5">
              <a href="<?=SET_URL_PRODUCTION?>/painel/cart?upgrade">
                <input style="cursor:no-drop;" type="text" disabled class="form-control" placeholder="Credencial Mercado Pago ( client_secret ) UPGRADE" value="">
              </a>
              <small><b>cliente_secret</b> do <b>Mercado Pago</b>. (Deixe em branco para não utilizar)</small>
              
            </div>
            
          </div>
          
        <?php } ?>
      

        <div class="form-group row">
          <label for="inputPassword" class="col-sm-2 col-form-label"></label>
          <div class="col-sm-10">
            <button id="btn_perfil_save" type="button" onclick="save_profile();" class="btn btn-primary" style="width:100%;" name="button">Salvar <i class="fa fa-floppy-o" ></i> </button>
          </div>
        </div>

        <?php } ?>
    </div>
    
    </div>
    </div>
    </main>
  </div>
</div>



 <!-- footer -->
 <?php include_once 'inc/footer.php'; ?>
 
 
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

