 <?php
 echo '<script>location.href="home";</script>';
 die;
  $revenda_class = new Revenda();
  $gestor_class = new Gestor();

   $rev_list = $revenda_class->list_revendas($_SESSION['SESSION_USER']['id']);
   $ind_list = $revenda_class->list_indicados($_SESSION['SESSION_USER']['id']);
   $saldo    = $revenda_class->saldo_user($_SESSION['SESSION_USER']['id']);
   $num_rev  = $revenda_class->count_revendas($_SESSION['SESSION_USER']['id']);
   $creditos = $revenda_class->credito_rev_user($_SESSION['SESSION_USER']['id']);
   $planos_gestor = $gestor_class->list_planos();
   $saque = $revenda_class->busca_saque($_SESSION['SESSION_USER']['id']);
   $planos_gestor2 = $gestor_class->list_planos();

 ?>



<!-- Head and Nav -->
<?php include_once 'inc/head-nav.php'; ?>


    <!-- NavBar -->
    <?php include_once 'inc/nav-bar.php'; ?>

    <main class="page-content">
<div class="">
            
            <div style="padding: 10px;-webkit-box-shadow: 0px 0px 16px -2px rgb(0 0 0 / 84%);box-shadow: 0px 0px 16px -2px rgb(0 0 0 / 84%);width: 99%;" class="card row" >
            
            
      <div class="col-md-12">
        <h1 class="h2">Revenda <i class="fa fa-bullhorn" ></i> </h1>
        <div style="margin-bottom:10px!important;" class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group mr-2">
            <button onclick="$('#modal_add_cliente').modal('show');verific_inputs_add_cli();" type="button" class="btn btn-sm btn-outline-secondary"><i class="fa fa-plus" ></i> Adicionar Usuário</button>
            <button onclick="$('#modal_add_credito').modal('show');" type="button" class="btn btn-sm btn-outline-secondary"><i class="fa fa-shopping-cart" ></i> Loja de Créditos</button>
            <button onclick="modal_solicita_money();valor_saque();" type="button" class="btn btn-sm btn-outline-secondary"><i class="fa fa-arrow-down" ></i> Retirar Saldo</button>

          </div>
        </div>
      </div>
      <?php
       if(isset($_SESSION['INFO'])){
         echo '<div id="msg_hide" class="alert alert-secondary">'.$_SESSION['INFO'].'</div>';
         unset($_SESSION['INFO']);
       }
       ?>


       <div style="margin-bottom:10px;" class="col-md-12">
         <div class="row">

           <div class="col-md-4" >
              <div class="card">
                <div class="text-center card-head">
                  <span class="badge badge-secondary" >Meus créditos</span>
                </div>
                <div class="card-body">

                  <div class="row">
                      <div class="col-md-12 text-center">
                        <h2><?= $creditos; ?> <i class="fa fa-ticket" ></i></h2>
                      </div>
                  </div>

                </div>
              </div>
           </div>

           <div class="col-md-4" >
              <div class="card">
                <div class="text-center card-head">
                  <span class="badge badge-secondary" >Usuários</span>
                </div>
                <div class="card-body">

                  <div class="row">
                      <div class="col-md-12 text-center">
                        <h2><?= $num_rev; ?> <i class="fa fa-users" ></i> </h2>
                      </div>
                  </div>

                </div>
              </div>
           </div>

           <div class="col-md-4" >
              <div class="card">
                <div class="text-center card-head">
                  <span class="badge badge-secondary" >Minha Carteira</span>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-12 text-center">
                          <h4><?= $moeda->simbolo; ?> <?= $saldo; ?> <i class="fa fa-money"></i> </h4>
                        </div>
                    </div>

                </div>
              </div>
           </div>
           <?php if($moeda->nome == "BRL"){ ?>
           <div class="col-md-6">
             <div class="input-group">
              <input type="text" id="link_afiliado" class="form-control" placeholder="Link de Afiliado" value="https://glite.me/r/?af=<?= $_SESSION['SESSION_USER']['id']; ?>" >
              <div class="input-group-append">
                <button class="btn btn-outline-secondary" onclick="copy_link_afiliado()" type="button">Copiar</button>
              </div>
            </div>
            <script>
                function copy_link_afiliado(){
                     $('#link_afiliado').select();
                     var copiar = document.execCommand('copy');
                     if(copiar){
                         $("#msg_return").addClass('text-success');
                         $("#msg_return").html('| Copiado <i class="fa fa-check" ></i>');
                         
                         setTimeout(function(){
                             $("#msg_return").html('');
                         },3000);
                     }
                     
                     
                }
            </script>
            <span class="text-primary" style="cursor:pointer;" onclick="$('#modal_rev').modal('show');" > <i class="fa fa-dollar"></i> CLIQUE AQUI</span> PARA SABER MAIS.  <small><b id="msg_return" ></b></small>
           </div>
           <?php } ?>
         <div class="col-md-6">
           <button onclick="$('#modal_banners').modal('show');" type="button" class="btn btn-lg btn-outline-secondary"><i class="fa fa-bullhorn" ></i> Material de divulgação</button>
         </div>
         </div>
       </div>

       <hr>

       <div class="row">
         <div class="col-md-12 text-left">
           <h5>Usuários adicionados por revenda</h5>
         </div>
       </div>
      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>

            <tr>
              <th>Id</th>
              <th>Nome</th>
              <th>Plano</th>
              <th>Whatsapp</th>
              <th>Email</th>
              <th>Senha</th>
              <th>Vencimento</th>
              <th> <i class="fa fa-cogs" ></i> </th>
            </tr>
          </thead>
          <tbody id="tbody_clientes" class="" >
            <?php

               if($rev_list){

                 while($rev = $rev_list->fetch(PDO::FETCH_OBJ)){

                   $plano_rev = $gestor_class->plano($rev->id_plano);

                   if($rev->vencimento != '00/00/0000'){


                      // verificar data do vencimento
                      $explodeData  = explode('/',$rev->vencimento);
                      $explodeData2 = explode('/',date('d/m/Y'));
                      $dataVen      = $explodeData[2].$explodeData[1].$explodeData[0];
                      $dataHoje     = $explodeData2[2].$explodeData2[1].$explodeData2[0];

                      if($dataVen == $dataHoje){
                          $ven = "<b class='badge badge-warning'>{$rev->vencimento}</b>";
                      }else if($dataHoje > $dataVen){
                          $ven = "<b class='badge badge-danger'>{$rev->vencimento}</b>";
                      }
                      else if($dataHoje < $dataVen){
                          $ven = "<b class='badge badge-success'>{$rev->vencimento}</b>";
                      }


                  }else{
                    $ven = "<b class='badge badge-secondary'>{$rev->vencimento}</b>";
                  }

            ?>


            <tr class="trs " >
              <td><?= $rev->id; ?></td>
              <td><?= $rev->nome; ?></td>
              <td><?php if($plano_rev){ echo $plano_rev->nome; }else{ echo "Indefinido"; }?></td>
              <td><?= $rev->ddi.$rev->telefone; ?></td>
              <td><?= $rev->email;?></td>
              <td> <span class="text-info" style="cursor:pointer;" onclick="alert('<?= $rev->senha;?>');" >******</span> </td>
              <td><?= $ven;?></td>
              <td>
                <button onclick="renew_user_rev(<?= $rev->id; ?>,<?= $rev->id_plano; ?>);" title="RENOVAR" type="button" class="btn-outline-primary btn btn-sm"> <i class="fa fa-refresh" ></i> </button>
                <button id="btn_del_<?= $rev->id; ?>" onclick="modal_del_user_rev(<?= $rev->id; ?>);" title="REMOVER" type="button" class="btn-outline-danger btn btn-sm"> <i class="fa fa-trash" ></i> </button>

              </td>
            </tr>

          <?php }  }else{ ?>

            <tr>
              <td class="text-center" colspan="8" >Nenhum usuário registrado</td>
            </tr>


          <?php } ?>

          </tbody>
        </table>


      </div>
      <div class="row">
        <div class="col-md-12 text-left">
         <hr>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 text-left">
          <h5>Usuários indicados</h5>
        </div>
      </div>
      <div  style="margin-bottom:50px;" class="table-responsive">
       <table class="table table-striped table-sm">
         <thead>

           <tr>
             <th>Nome</th>
             <th>Plano</th>
             <th>Whatsapp</th>
             <th>Email</th>
             <th>Senha</th>
             <th>Vencimento</th>
           </tr>
         </thead>
         <tbody id="tbody_clientes" class="" >
           <?php

              if($ind_list){

                while($ind = $ind_list->fetch(PDO::FETCH_OBJ)){

                  $plano_ind = $gestor_class->plano($ind->id_plano);

                  if($ind->vencimento != '00/00/0000'){


                     // verificar data do vencimento
                     $explodeData  = explode('/',$ind->vencimento);
                     $explodeData2 = explode('/',date('d/m/Y'));
                     $dataVen      = $explodeData[2].$explodeData[1].$explodeData[0];
                     $dataHoje     = $explodeData2[2].$explodeData2[1].$explodeData2[0];

                     if($dataVen == $dataHoje){
                         $ven = "<b class='badge badge-warning'>{$ind->vencimento}</b>";
                     }else if($dataHoje > $dataVen){
                         $ven = "<b class='badge badge-danger'>{$ind->vencimento}</b>";
                     }
                     else if($dataHoje < $dataVen){
                         $ven = "<b class='badge badge-success'>{$ind->vencimento}</b>";
                     }


                 }else{
                   $ven = "<b class='badge badge-secondary'> Nenhum plano</b>";
                 }

           ?>


           <tr class="trs " >
             <td><?=  substr($ind->nome,0,15); ?></td>
             <td><?php if($plano_ind){ echo $plano_ind->nome; }else{ echo "Nenhum"; } ?></td>
             <td><?= $ind->ddi.substr($ind->telefone,0, -(strlen($ind->telefone)-2))."****".substr($ind->telefone,-2, 2);?></td>
             <td><?= substr($ind->email,0,2)."****@".explode('@',$ind->email)[1];?></td>
             <td>******</td>
             <td><?= $ven;?></td>
           </tr>

         <?php }  }else{ ?>

           <tr>
             <td class="text-center" colspan="7" >Nenhum usuário indicado</td>
           </tr>


         <?php } ?>

         </tbody>
       </table>


      </div>
      </div>
      </div>

    </main>
  </div>
</div>

    <!--  Modal banners -->
           <div class="modal fade" id="modal_rev" tabindex="-1" role="dialog" aria-labelledby="titulo_modal_banners" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="titulo_modal_banners">GANHOS RECORRENTES !</h5>
                  &nbsp;&nbsp;&nbsp;
                  <button type="button" onclick="hideModal();" class="text-right btn btn-secondary btn-sm" >
                    Não lembrar mais
                  </button>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body"  >
                   
                   <div class="row" >
                       
                       <div class="text-center col-md-12" >
                          <h2>Agora com a Gestor você ganha todo mês!</h2>
                       </div>
                       <div class="col-md-12">
                           <h4>
                               Isso mesmo. Agora você pode indicar amigos e conhecidos e ganhar sempre que ele renovar conosco, o cashback é todo seu.
                           </h4>
                       </div>
                       
                       <div class="col-md-12">
                            <div class="row text-center">
                                <div class="col-md-2"></div>
                                <div class="card col-md-4">
                                    <div class="card-header">
                                        <h5>R$ 3,00</h5>
                                    </div>
                                    <p>
                                        Ganhe com Plano Profissional e Amador
                                    </p>
                                </div>
                                 <div class="card col-md-4">
                                    <div class="card-header">
                                        <h5>R$ 5,00</h5>
                                    </div>
                                    <p>
                                        Ganhe com Plano Patrão
                                    </p>
                                </div>
                                <div class="col-md-2"></div>
                            </div>
                       </div>
                       <div class="text-center col-md-12">
                           <img width="60%" src="<?=SET_URL_PRODUCTION?>/img/cashback.jpg" />
                       </div>
                   </div>
                   
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
              </div>
            </div>
           </div>


        <!--  Modal banners -->
           <div class="modal fade" id="modal_banners" tabindex="-1" role="dialog" aria-labelledby="titulo_modal_banners" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="titulo_modal_banners">Material de divulgação</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body"  >
                   
                   <div class="row" >
                       
                       <div class="col-md-12" >
                           <div class="row">
                               <div style="margin-bottom:5px;" class="col-md-6">
                                   <label>Embed <i class="fa fa-code"></i></label>
                                   <textarea class="form-control"><a target="_blank" href="https://glite.me/r/?af=<?= $_SESSION['SESSION_USER']['id']; ?>" ><img src="<?=SET_URL_PRODUCTION?>/img/gestorlite_home.png" width="100%" /></a></textarea>
                                   <br />
                                   <label>Link <i class="fa fa-link"></i></label>
                                   <input type="text" value="<?=SET_URL_PRODUCTION?>/img/gestorlite_home.png" class="form-control" />
                                    <br />
                                    <a style="margin-bottom:10px;width:100%;" href="<?=SET_URL_PRODUCTION?>/painel/divulgacao/material-divulgacao.zip" class="btn btn-info" >Baixar mais materiais de divulgação <i class="fa fa-download" ></i></a>

                                    <a style="width:100%;" target="_blank" href="https://www.youtube.com/channel/UCPJ7L33FkMayMW6EExnXCkw" class="btn btn-danger" >Canal do Youtube <i class="fa fa-youtube" ></i></a>

                               </div>
                                <div class="col-md-6">
                                    <img src="<?=SET_URL_PRODUCTION?>/img/gestorlite_home.png" width="100%" />
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

<!--  Modal add Cli -->
<div class="modal fade" id="modal_add_cliente" tabindex="-1" role="dialog" aria-labelledby="TituloModalLongoExemplo" aria-hidden="true">
 <div class="modal-dialog" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title" id="titutlo_modal_export_financeiro">Adicionar um usuário</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body" id="body_modal_add_cliente" >

             <div class="row">

                     <div class="col-md-12">
                       <div class="form-group">
                         <input type="text" id="nome_cli_rev" name="nome_cli_rev" class="form-control" placeholder="Nome e Sobrenome" value="">
                       </div>
                     </div>

                     <div class="col-md-12">
                       <div class="form-group">
                         <input type="email" id="email_cli_rev" name="email_cli_rev" class="form-control" placeholder="Endereço de email" value="" >
                         <small id="response_email_add" ></small>
                       </div>
                     </div>

                     <div style="margin-bottom:20px;" class="input-group col-md-12"  >
                         <span style="height:10px!important;" ></span>
                 					<div class="input-group-append">
                            <input type="hidden" value="55" id="ddi_cli_rev" />
                 						<button id="dropDownDDI" type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                 							<img id="ddi_atual_rev" src="<?=SET_URL_PRODUCTION?>/img/country/br.png" /> <span>+55</span>
                 						</button>
                 						<div style="z-index:9999!important;" id="dropdown_ddi" class="dropdown-menu">
                 							<a onclick="mudaDDI('55','br')" class="dropdown-item" ><img id="ddi_55" src="<?=SET_URL_PRODUCTION?>/img/country/br.png" /> +55</a>
                 							<a onclick="mudaDDI('351','pt');" class="dropdown-item" ><img id="ddi_351" src="<?=SET_URL_PRODUCTION?>/img/country/pt.png" /> +351</a>
                 							<a onclick="mudaDDI('1','usa');" class="dropdown-item" ><img id="ddi_1" src="<?=SET_URL_PRODUCTION?>/img/country/usa.png" /> +1</a>
                 							<a onclick="mudaDDI('49','ger');" class="dropdown-item"><img id="ddi_49" src="<?=SET_URL_PRODUCTION?>/img/country/ger.png" /> +49</a>
                 							<a onclick="mudaDDI('54','arg');" class="dropdown-item" ><img id="ddi_54" src="<?=SET_URL_PRODUCTION?>/img/country/arg.png" /> +54</a>
                 							<a onclick="mudaDDI('598','uru');" class="dropdown-item" ><img id="ddi_598" src="<?=SET_URL_PRODUCTION?>/img/country/uru.png" /> +598</a>
                 							<a onclick="mudaDDI('44','gbr');" class="dropdown-item" ><img id="ddi_44" src="<?=SET_URL_PRODUCTION?>/img/country/gbr.png" /> +44</a>
                 							<a onclick="mudaDDI('34','esp');" class="dropdown-item" ><img id="ddi_34" src="<?=SET_URL_PRODUCTION?>/img/country/esp.png" /> +34</a>
                 							<a onclick="mudaDDI('1','can');" class="dropdown-item"><img id="ddi_1_can" src="<?=SET_URL_PRODUCTION?>/img/country/can.png" /> +1</a>
                 							<a onclick="mudaDDI('57','col');" class="dropdown-item" ><img id="ddi_57" src="<?=SET_URL_PRODUCTION?>/img/country/col.png" /> +57</a>
                 						</div>
                 					</div>

                 					<script>
                           function mudaDDI(ddi,country){

                               $("#ddi_cli_add").val(ddi);
                               $("#dropDownDDI").html('<img src="<?=SET_URL_PRODUCTION?>/img/country/'+country+'.png" /> +'+ddi);
                           }
                         </script>

                         <input type="text" id="telefone_cli_rev" name="telefone_cli_rev" class="form-control" placeholder="Telefone" value="" >

                     </div>

                     <div style="margin-bottom:20px;" class="input-group  col-md-12">
                       <input type="password" id="senha_cli_rev" name="senha_cli_rev" class="form-control" placeholder="Senha">
                       <div class="input-group-append">
                         <span style="cursor:pointer;" class="input-group-text" id="icon_eye" onclick="eye_pass_cli();" > <i class="fa fa-eye"></i> </span>
                       </div>
                       <script type="text/javascript">

                        function eye_pass_cli() {
                          var type_input = document.getElementById("senha_cli_rev").type;
                          if(type_input == "password"){
                            $("#senha_cli_rev").attr('type','text');
                            $("#icon_eye").html('<i class="fa fa-eye-slash" ></i>');
                          }else if(type_input == "text"){
                            $("#senha_cli_rev").attr('type','password');
                            $("#icon_eye").html('<i class="fa fa-eye" ></i>');
                          }
                        }

                       </script>
                     </div>


                     <div class="col-md-12">
                       <div class="form-group">
                          <select onchange="info_p();$('#vencimento_cli_rev').val('');$('#qtd_cred_rev').val(0);" class="form-control" name="id_plano_cli_rev" id="id_plano_cli_rev" >

                            <option value="">Selecionar plano</option>

                            <?php

                            if($planos_gestor){

                              while ($plano = $planos_gestor->fetch(PDO::FETCH_OBJ)) {

                            ?>

                            <option value="<?= $plano->id; ?>"> [ <?= $plano->creditos; ?> ] <?php if($plano->creditos>1){ echo "créditos"; }else{ echo "crédito"; } ?> (R$ <?= $plano->valor; ?> preço sugerido) | <?= $plano->nome; ?></option>

                          <?php } } ?>

                          </select>
                       </div>
                     </div>

                     <div class="col-md-12">
                       <div class="form-group">
                          <select onchange="calc_qtd_credits_add_cli();" class="form-control" name="vencimento_cli_rev" id="vencimento_cli_rev" >

                            <option value="" >Selecionar validade</option>
                            <option value="1" >1 mês</option>
                            <option value="2" >2 mêses</option>
                            <option value="3" >3 mêses</option>
                            <option value="4" >4 mêses</option>
                            <option value="5" >5 mêses</option>
                            <option value="6" >6 mêses</option>
                            <option value="7" >7 mêses</option>
                            <option value="8" >8 mêses</option>
                            <option value="9" >9 mêses</option>
                            <option value="10" >10 mêses</option>
                            <option value="11" >11 mêses</option>
                            <option value="12" >12 mêses</option>


                          </select>
                       </div>
                     </div>

                     <div style="margin-bottom:20px;" class="input-group  col-md-12">
                       <input type="text" id="qtd_cred_rev" disabled name="qtd_cred_rev" class="form-control" value="0" placeholder="">
                       <div class="input-group-append">
                         <span class="input-group-text" id="" > créditos </span>
                       </div>
                     </div>

                     <input type="hidden" id="json_inputs" name="json_inputs" value="">

                 <div class="col-md-12">
                   <div class="form-group text-center">
                     <button disabled id="btn_add_cli_rev" style="width:100%;" onclick="add_new_cli();" type="button" class="btn btn-primary" name="button">Adicionar</button>
                     <span style="margin-top:6px;" id="response_add_new_cli_rev" ></span>
                   </div>
                 </div>
               </div>

     </div>
  </div>
 </div>
</div>


<!--  Modal ren Cli -->
<div class="modal fade" id="modal_ren_cliente" tabindex="-1" role="dialog" aria-labelledby="TituloModalLongoExemplo" aria-hidden="true">
 <div class="modal-dialog" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title" id="titutlo_modal_ren_cliente">Renovar usuário</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body" id="body_modal_add_cliente" >

             <div class="row">

                     <div class="col-md-12">
                       <div class="form-group">
                          <select onchange="info_p();$('#vencimento_cli_rev_renew').val('');$('#qtd_cred_rev_renew').val(0);" class="form-control" name="id_plano_cli_rev_renew" id="id_plano_cli_rev_renew" >

                            <option value="">Selecionar plano</option>

                            <?php

                            if($planos_gestor2){

                              while ($plano2 = $planos_gestor2->fetch(PDO::FETCH_OBJ)) {

                            ?>

                            <option value="<?= $plano2->id; ?>"> [ <?= $plano2->creditos; ?> ] <?php if($plano2->creditos>1){ echo "créditos"; }else{ echo "crédito"; } ?> (<?= $moeda->simbolo; ?> <?= $plano2->valor; ?> preço sugerido) | <?= $plano2->nome; ?></option>

                          <?php } } ?>

                          </select>
                       </div>
                     </div>

                     <div class="col-md-12">
                       <div class="form-group">
                          <select onchange="calc_qtd_credits_add_cli_renew();" class="form-control" name="vencimento_cli_rev_renew" id="vencimento_cli_rev_renew" >

                            <option value="" >Escolha quantos meses</option>
                            <option value="1" >Renovar 1 mês</option>
                            <option value="2" >Renovar 2 mêses</option>
                            <option value="3" >Renovar 3 mêses</option>
                            <option value="4" >Renovar 4 mêses</option>
                            <option value="5" >Renovar 5 mêses</option>
                            <option value="6" >Renovar 6 mêses</option>
                            <option value="7" >Renovar 7 mêses</option>
                            <option value="8" >Renovar 8 mêses</option>
                            <option value="9" >Renovar 9 mêses</option>
                            <option value="10" >Renovar10 mêses</option>
                            <option value="11" >Renovar 11 mêses</option>
                            <option value="12" >Renovar 12 mêses</option>


                          </select>
                       </div>
                     </div>

                     <div style="margin-bottom:20px;" class="input-group  col-md-12">
                       <input type="text" id="qtd_cred_rev_renew" disabled name="qtd_cred_rev_renew" class="form-control" value="0" placeholder="">
                       <div class="input-group-append">
                         <span class="input-group-text" id="" > créditos </span>
                       </div>
                     </div>
                     
                     <p style="margin-left:5px;" >
                         Se estás a renovar o plano patrão, informe ao nosso suporte o ID do cliente e quantos meses é a renovação.
                         Procedimento <b class="text-danger">obrigatório</b>.
                     </p>

                     <input type="hidden" id="id_cli_rev" name="id_cli_rev" value="">

                 <div class="col-md-12">
                   <div class="form-group text-center">
                     <button id="btn_renew_rev" style="width:100%;" onclick="renew_rev_cli();" type="button" class="btn btn-primary" name="button">Renovar</button>
                     <span style="margin-top:6px;" id="response_cli_rev_renew" ></span>
                   </div>
                 </div>
               </div>

     </div>
  </div>
 </div>
</div>

<!--  Modal view delete user -->
<div class="modal fade" id="modal_del_user_rev" tabindex="-1" role="dialog" aria-labelledby="TituloModalLongoExemplo" aria-hidden="true">
 <div class="modal-dialog" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title" id="titutlo_modal_del_mov">Deseja realmente deletar o usuario?</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body" id="body_modal_del_mov" >
       <input type="hidden" name="id_modal_del_user_rev" id="id_modal_del_user_rev" value="">

       <h4>Deseja continuar ?</h4>
       <p>
         Seus créditos não serão ressarcidos.
       </p>
     </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      <button onclick="delete_user_rev();" type="button" id="btn_modal_del_user" class="btn btn-primary">Deletar</button>
    </div>
  </div>
</div>
</div>

<!--  Modal solicita saque -->
<div class="modal fade" id="modal_solicita_saque" tabindex="-1" role="dialog" aria-labelledby="TituloModalLongoExemplo" aria-hidden="true">
 <div class="modal-dialog" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title" id="titutlo_modal_solicita_saque">Solicitar retirada de dinheiro</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body" id="body_modal_solicita_saque" >

       <?php if($saque){ ?>

         <h4>No momento, existe uma solicitação em andamento.</h4>


       <?php }else{ ?>

       <p>É importante que você saiba, são aprovados somente saques acima de <b><?= $moeda->simbolo; ?> 50,00</b>. Abaixo disso, será desconciderado a retirada.</p>
       <p>A seguir, coloque como devemos lhe enviar o dinheiro, seja por TED, Depóstio ou Mercado Pago. É importante que suas informações sejam precisas. Depositos em contas erradas, serão de responsabilidade sua.</p>

       <div class="form-group">

         <textarea name="info_saque" id="info_saque" class="form-control" placeholder="Descreva como deseja receber o dinheiro" rows="8" cols="80"></textarea>

       </div>

       <div class="form-group">

         <input type="text" class="form-control" id="valor_saque"  placeholder="Valor desejado" name="valor_saque" value="" >
         <small>Se você não possuir a quantia informada, seu pedido será desconsiderado.</small>

       </div>

       <p>
         Após o saque for realizado, você receberá um aviso por whatsapp. O prazo é de até 3 dias após a solicitação.
       </p>

       <?php } ?>

     </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      <button onclick="solicita_saque();" type="button" id="btn_solicita_saque" class="btn btn-primary">Solicitar</button>
    </div>

  </div>
</div>
</div>


<!--  Modal add mov -->
<div class="modal fade" id="modal_add_credito" tabindex="-1" role="dialog" aria-labelledby="TituloModalLongoExemplo" aria-hidden="true">
 <div class="modal-dialog" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title" id="Titutlo_modal_add_cliente">Adicionar creditos</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body" id="body_modal_add_credito" >

          <div class="row">

           <!--<div class="col-md-12">-->
           <!--  <input type="number" class="form-control margin" id="qtd_credit" placeholder="Quantos creditos quer comprar ?">-->
           <!--</div>-->

           <!--<div class="text-center col-md-12">-->
           <!--  <h5>Isso vai te custar: <span id="val_credi" >0,00</span> </h5>-->
           <!--</div>-->

           <!--<div class="text-left col-md-12">-->

           <!--   <div class="form-group">-->
           <!--       <label for="tipo_pay" >Pagar com: </label>-->
           <!--       <select class="form-control" name="tipo_pay" id="tipo_pay" >-->
           <!--         <option value="mp" >Escolher na próxima página</option>-->
           <!--         <option value="saldo" >Saldo em conta</option>-->
           <!--       </select>-->
           <!--   </div>-->

           <!--</div>-->
           <img width="100%" src="<?=SET_URL_PRODUCTION?>/parceiro/img/img-dash.png" />
           <h3 style="margin-left:10px;" >
               Oi. No momento estamos atualizando nosso modo de parceria. <br />
               Entre em contato conosco, e veja como ser parceiro Gestor Lite.
           </h3>
           
           
     </div>
     <div class="modal-footer">

       <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
       <!--<button type="button" onclick="payment_credits();" id="btn_pay_cred" class="btn btn-primary">Pagar</button>-->

     </div>


   </div>
 </div>
</div>
</div>


<div class="modal fade" id="modal_payment" tabindex="-1" role="dialog" aria-labelledby="Titutlo_modal_payment" aria-hidden="true">
 <div class="modal-dialog" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title" id="Titutlo_modal_payment"><?= $idioma->ta_quase_la; ?> <?= explode(' ',$user->nome)[0]; ?></h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body" id="body_modal_payment" >

          <div class="row">

           <div class="col-md-12 text-center margin">

             <h4><?= $idioma->pague_sua_fat; ?> <i class="fa fa-smile-o" ></i> </h4>

             <a style="width:100%" id="btn_mp" href="#" class="btn btn-info" ><?= $idioma->pagar; ?></a>
             <br />
             <small><?= $idioma->seguro_pay; ?> <i class="fa fa-lock" ></i> </small>
             <br />
             <img width="100%" src="../libs/MercadoPago/img/mercado-pago-logo.png" alt="">

           </div>

          </div>

     </div>

   </div>
 </div>
</div>

<script>
   

    function valor_saque(){
        $("#valor_saque").maskMoney({prefix:'<?= $moeda->simbolo; ?>'+' ', thousands:'.', decimal:',', affixesStay: true});
    };
         

</script>

 <script>

 function setCookie(cname,cvalue,exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays*24*60*60*1000));
        var expires = "expires=" + d.toGMTString();
        document.cookie = cname+"="+cvalue+"; "+expires;
    }
    
    function getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for(var i=0; i<ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1);
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }
    
    
    
    function hideModal(){
         setCookie("hideModalRevenda", 'true', 300);
         $('#modal_rev').modal('toggle');
    }
    
    
    
    </script>

<script src="<?=SET_URL_PRODUCTION?>/painel/js/revenda.js" ></script>
 <!-- footer -->
 <?php include_once 'inc/footer.php'; ?>
 <script type="text/javascript">
   $("#qtd_credit").keyup(function(){
     var val_cred = 10;
     var qtd_cred = $("#qtd_credit").val();

     var valor_final = (val_cred*qtd_cred);

     $("#val_credi").html(valor_final.toLocaleString('pt-br',{style: 'currency', currency: '<?= $moeda->nome; ?>'}));

   });
 </script>
