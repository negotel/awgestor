<?php 
 
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


    <!-- NavBar -->
    <?php include_once 'inc/nav-bar.php'; ?>

     <main class="page-content">
    
    <div class="container">
        
       <div class="row">
           
        
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
      
    <div <?php if($user->verificadozap == 0 || $user->verificadomail == 0){ echo 'style="margin-bottom:300px;";';} ?> class="col-md-12">
        
      <div class="form-group row text-center">
        <div class="col-md-12">
          <span class="text-center" id="msg_retorno"></span>
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

          <div class="form-group col-md-2">
    					<span style="height:10px!important;" ></span>
    					
    					<?php 
    					
    					    $bandeira[55] = 'br';
    					    $bandeira[351] = 'pt';
    					    $bandeira[1] = 'usa';
    					    $bandeira[49] = 'ger';
    					    $bandeira[54] = 'arg';
    					    $bandeira[598] = 'uru';
    					    $bandeira[44] = 'gbr';
    					    $bandeira[34] = 'esp';
    					    $bandeira[57] = 'col';
    					    $bandeira[81] = 'jp';

    					?>
    					
    					<div class="btn-group">
    						<button id="dropDownDDI" type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    							<img id="ddi_atual" src="<?=SET_URL_PRODUCTION?>/img/country/<?= $bandeira[$user->ddi]; ?>.png" /> <span>+<?= $user->ddi; ?></span>
    						</button>
    						<div style="z-index:9999!important;" id="dropdown_ddi" class="dropdown-menu">
    							<a style="cursor:pointer;" onclick="mudaDDI('55','br')" class="dropdown-item"><img class="img_btn" src="<?=SET_URL_PRODUCTION?>/img/country/br.png" /> +55</a>
    							<a style="cursor:pointer;" onclick="mudaDDI('351','pt');" class="dropdown-item" ><img class="img_btn" src="<?=SET_URL_PRODUCTION?>/img/country/pt.png" /> +351</a>
    							<a style="cursor:pointer;" onclick="mudaDDI('1','usa');" class="dropdown-item" ><img class="img_btn" src="<?=SET_URL_PRODUCTION?>/img/country/usa.png" /> +1</a>
    							<a style="cursor:pointer;" onclick="mudaDDI('49','ger');" class="dropdown-item"><img class="img_btn" src="<?=SET_URL_PRODUCTION?>/img/country/ger.png" /> +49</a>
    							<a style="cursor:pointer;" onclick="mudaDDI('54','arg');" class="dropdown-item" ><img class="img_btn" src="<?=SET_URL_PRODUCTION?>/img/country/arg.png" /> +54</a>
    							<a style="cursor:pointer;" onclick="mudaDDI('598','uru');" class="dropdown-item"><img class="img_btn" src="<?=SET_URL_PRODUCTION?>/img/country/uru.png" /> +598</a>
    							<a style="cursor:pointer;" onclick="mudaDDI('44','gbr');" class="dropdown-item"><img class="img_btn" src="<?=SET_URL_PRODUCTION?>/img/country/gbr.png" /> +44</a>
    							<a style="cursor:pointer;" onclick="mudaDDI('34','esp');" class="dropdown-item"><img class="img_btn" src="<?=SET_URL_PRODUCTION?>/img/country/esp.png" /> +34</a>
    							<a style="cursor:pointer;" onclick="mudaDDI('1','can');" class="dropdown-item" ><img class="img_btn" src="<?=SET_URL_PRODUCTION?>/img/country/can.png" /> +1</a>
    							<a style="cursor:pointer;" onclick="mudaDDI('57','col');" class="dropdown-item" ><img class="img_btn" src="<?=SET_URL_PRODUCTION?>/img/country/col.png" /> +57</a>
    				    		<a style="cursor:pointer;" onclick="mudaDDI('81','jp');" class="dropdown-item" ><img class="img_btn" src="<?=SET_URL_PRODUCTION?>/img/country/jp.png" /> +81</a>
    						</div>
    					</div>

    	  <script>
              function mudaDDI(ddi,country){

                  $("#ddi").val(ddi);
                  $("#dropDownDDI").html('<img src="<?=SET_URL_PRODUCTION?>/img/country/'+country+'.png" /> +'+ddi);
              }
            </script>


    					<input type="hidden" value="<?= $user->ddi; ?>" id="ddi" />

    	  </div>

          <div class="col-sm-8">
            <input type="text" name="telefone_user" class="form-control" value="<?= $user->telefone; ?>" id="telefone_user" placeholder="Telefone">
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
