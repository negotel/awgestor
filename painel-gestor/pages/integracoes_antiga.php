<?php

    $ApiPainel = new ApiPainel();
     
     
     
    $maximo = 20;
    $pagina = isset($_GET['page']) ? ($_GET['page']) : '1'; 
    $inicio = $pagina - 1;
    $inicio = $maximo * $inicio;

    $list_testes  = $ApiPainel->list_teste_history($_SESSION['SESSION_USER']['id'],$inicio,$maximo);
     
    $gerados      = $ApiPainel->cont_teste_mes($_SESSION['SESSION_USER']['id']);
    $total        = $gerados;
    $financeiro   = new Financeiro();
    $paineis = $ApiPainel->credenciais($_SESSION['SESSION_USER']['id'],false);
     
     
     
?>
<!-- Head and Nav -->
<?php include_once 'inc/head-nav.php'; ?>


    <!-- NavBar -->
    <?php include_once 'inc/nav-bar.php'; ?>

    <main class="page-content">
    
     <div class="container">
        
        <div class="row">
            
      <div class="col-md-12">
       <div class="row">
              <div class="col-md-6">
                    <h1 class="h2">Integrações <i class="fa fa-code" ></i> <span style="font-size:10px!important;" class="badge badge-danger">BETA</span></h1>
                   <span style="font-size:10px;" >Integre seu painel Gestor para gerar teste automáticos.</span>
              </div>
              <div class="col-md-6">
                  <div class="btn-group">
                      <button class="btn btn-sm btn-success" onclick="$('#modal_credencial').modal('show');" ><i class="fa fa-plus" ></i> CONECTAR UM NOVO PAINEL</button>
                  </div>
              </div>
              <div class="col-md-12" >
        
              <div style="margin-bottom:20px;" class="col-md-6" >
                 <span style="font-size:20px;" >
                   <i class="fa fa-calendar" ></i> <?= $financeiro->text_mes(date('m'),TRUE); ?>  | Testes gerados <?= $gerados; ?> / <?php if($plano_usergestor->limit_teste > 100000000){ echo "&infin;"; }else{ echo $plano_usergestor->limit_teste; } ?>
                 </span>
              </div>
              
          </div>
        </div>
      </div>
      
    
      
     


        <div class="col-md-12" >
        <div class="row">
            <div class="col-md-12" >
              <div class="card" style="padding:10px;">
                  <div class="table-responsive">
                      <p>
                          Paineis integrados
                      </p>
                    <table class="table table-striped table-sm">
                      <thead>
                        <tr>
                          <th>Painel</th>
                          <th>CMS</th>
                          <th>Testes</th>
                          <th>Link de teste</th>
                          <th>Opções</th>
                        </tr>
                      </thead>
                      <tbody id="tbody_" class="" >
                        <?php
                         
            
                           if($paineis){
            
                             while($painel = $paineis->fetch(PDO::FETCH_OBJ)){
                                 
                                 $teste = "<span class='badge badge-success' > Ativo</span>";
                                 
                                 if($painel->situ_teste == 0){
                                     $teste = "<span class='badge badge-danger' > Inativo</span>";
                                 }
            
                        ?>
            
            
                        <tr >
                          <td><?= $painel->nome; ?></td>
                          <td><a href="<?= $painel->cms; ?>" target="_blank" ><?php echo substr($painel->cms,0,20); ?>...</a></td>
                          <td><?= $teste; ?></td>
                          <td><a href="https://glite.me/t/<?= $painel->chave; ?>" target="_blank" >https://glite.me/t/<?php echo substr($painel->chave,0,6); ?>...</td>
                          <td>
                              <button class="btn btn-sm btn-outline-danger" onclick="remove_painel_modal(<?= $painel->id; ?>);" > <i class="fa fa-trash"></i> </button>
                              <button class="btn btn-sm btn-outline-info" onclick="edit_modal_painel(<?= $painel->id; ?>);" > <i class="fa fa-pencil"></i> </button>
                              <button onclick="location.href='template-message-teste?id=<?= $painel->id; ?>';" type="button" class="btn btn-sm btn-outline-secondary"><i class="fa fa-whatsapp" ></i></button>
                              <button onclick="modal_iframe(<?= $painel->id; ?>);" type="button" class="btn btn-sm btn-outline-primary"><i class="fa fa-code" ></i></button>

                          </td>
                        </tr>
                        
                        <textarea style="display:none;" id="ifram_cod_<?= $painel->id; ?>" ><iframe src="https://glite.me/t/<?= $painel->chave; ?>" style="height:100%;width:100%;border:none;" name="Gerador de testes" ></iframe></textarea>
            
                      <?php } }else{ ?>
            
                        <tr>
                          <td style="padding:10px;" class="text-center" colspan="5" >
                            <p>Nenhum painel integrado</p>
                          </td>
                        </tr>
            
            
                      <?php } ?>
            
                      </tbody>
                    </table>
            
            
                  </div>
              </div>                
            </div>
            
            
            
            
            
            
            <div class="col-md-12" >
              <div class="card" style="padding:10px;">
                  <div class="table-responsive">
                      <p>
                          Todos os testes são excluidos após 1 mês
                      </p>
                    <table class="table table-striped table-sm">
                      <thead>
                        <tr>
                          <th>Nome</th>
                          <th>Email</th>
                          <th>Whatsapp</th>
                          <th>Data</th>
                          <th>Hora</th>
                          <th>User</th>
                          <th>Senha</th>
                          <th>Painel</th>
                        </tr>
                      </thead>
                      <tbody id="tbody_clientes" class="" >
                        <?php
                         
            
                           if($list_testes){
            
                             while($teste = $list_testes->fetch(PDO::FETCH_OBJ)){
            
                        ?>
            
            
                        <tr >
                          <td><?= $teste->nome; ?></td>
                          <td><?= $teste->email; ?></td>
                          <td><?= $teste->whatsapp; ?></td>
                          <td><?= $teste->data; ?></td>
                          <td><?= $teste->hora; ?></td>
                          <td><?= $teste->username; ?></td>
                          <td><?= $teste->password; ?></td>
                          <td><?= $teste->api_name; ?></td>
                        </tr>
            
                      <?php } }else{ ?>
            
                        <tr>
                          <td style="padding:10px;" class="text-center" colspan="8" >
                            <p>Nenhum teste gerado ainda</p>
                          </td>
                        </tr>
            
            
                      <?php } ?>
            
                      </tbody>
                    </table>
            
            
                  </div>
                  
              </div>
                     <nav aria-label="Navegação">
                         <ul class="pagination">
                          <?php
                            //determina de quantos em quantos links serão adicionados e removidos
                            $max_links = 6;
                            //dados para os botões
                            $previous = $pagina - 1; 
                            $next = $pagina + 1; 
                            //usa uma funcção "ceil" para arrendondar o numero pra cima, ex 1,01 será 2
                            $pgs = ceil($total / $maximo); 
                            //se a tabela não for vazia, adiciona os botões
                            if($pgs > 1 ){   
                                echo "<br/>"; 
                                //botao anterior
                                if($previous > 0){
                                    echo '<li class="page-item">
                                          <a class="page-link" href="?page='.$previous.'" aria-label="Anterior">
                                            <span aria-hidden="true">&laquo;</span>
                                            <span class="sr-only">Anterior</span>
                                          </a>
                                        </li>';
                                } else{
                                       echo '<li class="page-item">
                                          <a class="page-link" href="" disabled style="cursor:no-drop" aria-label="Anterior">
                                            <span aria-hidden="true">&laquo;</span>
                                            <span class="sr-only">Anterior</span>
                                          </a>
                                        </li>';
                                }   
                                   
                               
                                    for($i=$pagina-$max_links; $i <= $pgs-1; $i++) {
                                        if ($i <= 0){
                                        //enquanto for negativo, não faz nada
                                        }else{
                                            //senão adiciona os links para outra pagina
                                            if($i != $pagina){
                                                if($i == $pgs){ //se for o final da pagina, coloca tres pontinhos
                                                    echo '<li class="page-item"><a class="page-link" href="?page='.($i).'">'.$i.'</a></li>';
                                                }else{
                                                    echo '<li class="page-item"><a class="page-link" href="?page='.($i).'">'.$i.'</a></li>';
                                                }
                                            } else{
                                                if($i == $pgs){ 
                                                    echo '<li class="page-item active"><a class="page-link" href="#">'.$i.'</a></li>';
                                                }else{
                                                    echo '<li class="page-item active"><a class="page-link" href="#">'.$i.'</a></li>';
                                                }
                                            } 
                                        }
                                    }
                                       
                                   
                                //botao proximo
                                if($next <= $pgs){
                                    echo ' <li class="page-item">
                                              <a class="page-link" href="?page='.$next.'" aria-label="Próximo">
                                                <span aria-hidden="true">&raquo;</span>
                                                <span class="sr-only">Próximo</span>
                                              </a>
                                            </li>';
                                }else{
                                    echo ' <li class="page-item">
                                      <a class="page-link" href="#" disabled style="cursor:no-drop;" aria-label="Próximo">
                                        <span aria-hidden="true">&raquo;</span>
                                        <span class="sr-only">Próximo</span>
                                      </a>
                                    </li>';                                
                                    
                                }
                                       
                            }
                                           
                   ?>   
                          
                          </ul>
                        </nav>
            </div>
            </div>
        </div>
      </div>
      </div>
      

    </main>
  </div>
</div>

 <!--  Modal help CMS api xtream -->
<div class="modal fade" id="remove_painel_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
 <div class="modal-dialog " role="document">
   <div class="modal-content">
     <div class="modal-header bg-danger">
       <h5 class="modal-title text-white" id="Titutlo_modal_fat_cli">Deseja continuar ?</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body " id="body_remove_painel_modal" >
         
         <input type="hidden" id="id_remove_painel" />

        <div class="row" >
            
            <div class="col-md-12" >

                <h4>Você quer realmente remover está integração ?</h4>
                
            </div>
            
        </div>
   
      </div>

     <div class="modal-footer">
       <button type="button" class="btn btn-success" onclick="remove_painel();" id="btn_remove" data-dismiss="modal">Sim</button>
       <button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
     </div>
    </div>

   </div>
 </div>
 
  <!--  Modal codigo iframe -->
<div class="modal fade" id="api_painel_iframe" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
 <div class="modal-dialog modal-lg" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title" id="Titutlo_modal_fat_cli">Coloque um gerador de teste em seu site</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body " id="body_modal_credencial" >
         

        <div class="row" >
            
            <div class="col-md-12" >

                <div class="form-group" >
                    <textarea class="form-control" id="codigo_iframe" placeholder="Código iframe" ></textarea>
                    <small>Copie o código e coloque em seu website</small>
                </div>
                <div class="form-group">
                    <button class="btn btn-secondary btn-lg" style="width:100%;" onclick="copiar_codigo();" > <i class="fa fa-clone" ></i> Copiar</button>
                    <small id="info_msg_teste" ></small>
                </div>
                <script>
                    function copiar_codigo(){
                      $('#codigo_iframe').select();
                     var copiar = document.execCommand('copy');
                     if(copiar){
                         $("#info_msg_teste").addClass('text-success');
                         $("#info_msg_teste").html('Copiado <i class="fa fa-check" ></i>');
                         
                         setTimeout(function(){
                             $("#info_msg_teste").html('');
                         },3000);
                     }
                    }
                </script>
            </div>
          
            </div>
            
        </div>
   

     <div class="modal-footer">
       <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $idioma->fechar; ?></button>
     </div>
    </div>

   </div>
 </div>
 
 <!--  Modal help CMS api xtream -->
<div class="modal fade" id="api_cms_painel_help" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
 <div class="modal-dialog modal-lg" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title" id="Titutlo_modal_fat_cli">Tutorial: Seu Link do painel, ou sua CMS</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body " id="body_modal_credencial" >
         

        <div class="row" >
            
            <div class="col-md-12" >

                    <p>
                        Passo a Passo <b>Xtream-UI</b>:
                        <ul>
                            <li>Acesse seu painel Xtream UI</li>
                            <li>Na barra de endereço do navegador, copie o endereço do painel até mesmo a porta.</b></li>
                            <li>OBS: Não copie nenhum endereço a mais do que o link principal, exemplo:
                                <ul>
                                    <li><i class="fa fa-close text-danger" ></i> Incorreto: <b class="text-success" >http://seupainel.me:2550</b><b class="text-danger" >/login.php</b></li>
                                    <li><i class="fa fa-check text-success" ></i> Correto: <b class="text-success" >http://seupainel.me:2550</b></li>
                                </ul>
                            </li>
                        </ul>
                    </p>
                    
                    <p>
                       Veja a imagem a seguir como exemplo
                    </p>

                <div class="row" >
                    <div class="col-md-12 text-center" >
                       <img src="img/help_cms_xtream.png" width="100%"  />
                    </div>
                    
                </div>

                
            </div>
            
       
            <div style="margin-top:20px;" class="col-md-12" >

                    <p>
                        Passo a Passo <b>KOffice v2</b>:
                        <ul>
                            <li>Acesse seu painel KOffice v2 </li>
                            <li>Na barra de endereço do navegador, copie o endereço do painel.</b></li>
                            <li>OBS: Não copie nenhum endereço a mais do que o link principal, exemplo:
                                <ul>
                                    <li><i class="fa fa-close text-danger" ></i> Incorreto: <b class="text-success" >http://seupainel.me</b><b class="text-danger" >/index.php</b></li>
                                    <li><i class="fa fa-check text-success" ></i> Correto: <b class="text-success" >http://seupainel.me</b></li>
                                </ul>
                            </li>
                        </ul>
                    </p>
                    
                    <p>
                       Veja a imagem a seguir como exemplo
                    </p>

                <div class="row" >
                    <div class="col-md-12 text-center" >
                       <img src="img/help_cms_koffice.png" width="100%"  />
                    </div>
                    
                </div>

                
            </div>
            
        </div>
   
      </div>

     <div class="modal-footer">
       <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $idioma->fechar; ?></button>
     </div>
    </div>

   </div>
 </div>
 
 <!--  Modal api xtream -->
<div class="modal fade"  id="modal_credencial_edit" tabindex="-1" role="dialog" aria-labelledby="Titutlo_modal_pareamento" aria-hidden="true">
 <div class="modal-dialog modal-lg" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title" id="Titutlo_modal_fat_cli">Editar dados da integração</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <input type="hidden" id="cont_scan" value="0" />
     <div class="modal-body " id="body_modal_credencial" >
         

        <div class="row" >
            
            <div class="col-md-12" >

            
                <div class="row" >
                     <div class="form-group col-md-4" >
                         <div class="custom-control custom-checkbox mr-sm-12">
                            <input type="checkbox" class="custom-control-input" id="situ_api_teste_api_edit">
                            <label class="custom-control-label" for="situ_api_teste_api_edit"> Testes</label>
                          </div>
                    </div>
                     <div class="form-group col-md-4" >
                         <div class="custom-control custom-checkbox mr-sm-12">
                            <input type="checkbox" class="custom-control-input" id="situ_aviso_zap_edit">
                            <label class="custom-control-label" for="situ_aviso_zap_edit">Receber aviso no whatsapp</label>
                          </div>
                    </div>
                    <div class="form-group col-md-4" >
                         <div class="custom-control custom-checkbox mr-sm-12">
                            <input type="checkbox" class="custom-control-input" id="situ_cloud">
                            <label class="custom-control-label" for="situ_cloud">Modo Cloud <i class="fa fa-cloud" ></i> </label>
                            <br /><small>Apenas para Xtream-UI no momento <a href="#" target="_blank" >Ajuda <i class="fa fa-question"></i></a> </small>
                          </div>
                    </div>
                   <div class="form-group col-md-12" >
                        <label>Nome</label>
                        <input type="text" value="" class="form-control" name="nome_edit" id="nome_edit" placeholder="Informe um nome para está integração" />
                    </div>
                    <div class="form-group col-md-6" >
                        <label>Usuário</label>
                        <input type="text" value="" class="form-control" name="username_edit" id="username_edit" placeholder="Seu usuario" />
                    </div>
                    
                    <div class="form-group col-md-6" >
                        <label>Senha</label>
                        <input type="password" value="" class="form-control" name="password_edit" id="password_edit" placeholder="Sua senha" />
                    </div>
                    
                    <div class="form-group col-md-6" >
                        <label>CMS do painel</label>
                        <input type="url" class="form-control" value="" name="cms_edit" id="cms_edit" placeholder="Link do seu painel Xtream" />
                        <small><span class="text-info" style="cursor:pointer;" onclick="help('cms');" > <i class="fa fa-question-circle" ></i>  Ajuda</span></small>

                    </div>
                    
                    <div class="form-group col-md-6" >
                        <label>Painel</label>
                         <select class="form-control" id="painel_edit" name="painel_edit" >
                             <option value="" >Selecionar</option>
                             <option value="xtream-ui" >Xtream-UI</option>
                             <option value="kofficeV2" >KOffice V2</option>
                             <option value="kofficeV4" >KOffice V4</option>
                             <option value="kofficev4_12" >KOffice V4.1.2</option>
                             
                         </select>
                    </div>
                    
                </div>
                
                <input type="hidden" value="" id="chave_edit" />

                
            </div>
            
             <div class="col-md-12" >
                <div id="return-msg" ></div>
            </div>
            
           
            
        </div>
   
      </div>

     <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btn_save_dados_painel" onclick="save_dados_painel();" >Salvar</button>
       <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $idioma->fechar; ?></button>
     </div>
    </div>

   </div>
 </div>

<!--  Modal api add painel -->
<div class="modal fade"  id="modal_credencial" tabindex="-1" role="dialog" aria-labelledby="Titutlo_modal_pareamento" aria-hidden="true">
 <div class="modal-dialog modal-lg" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title" id="Titutlo_modal_fat_cli">Adicionar um novo painel</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <input type="hidden" id="cont_scan" value="0" />
     <div class="modal-body " id="body_modal_credencial" >
         

        <div class="row" >
            
            <div class="col-md-12" >
                <p> <i class="fa fa-warning"></i> Atenção, os paineis não podem ter reCAPTCHA para funcionar </p>
            </div>
            
            <div class="col-md-12" >

                <div class="row" >
                     <div class="form-group col-md-6" >
                         <div class="custom-control custom-checkbox mr-sm-12">
                            <input type="checkbox" class="custom-control-input" id="situ_api_teste_api">
                            <label class="custom-control-label" for="situ_api_teste_api">Testes</label>
                          </div>
                    </div>
                     <div class="form-group col-md-6" >
                         <div class="custom-control custom-checkbox mr-sm-12">
                            <input type="checkbox" class="custom-control-input" id="situ_aviso_zap">
                            <label class="custom-control-label" for="situ_aviso_zap">Receber aviso no whatsapp</label>
                          </div>
                    </div>
                    <div class="form-group col-md-12" >
                        <label>Nome</label>
                        <input type="text" value="" class="form-control" name="nome" id="nome" placeholder="Informe um nome para está integração" />
                    </div>
                    <div class="form-group col-md-6" >
                        <label>Usuário</label>
                        <input type="text" value="" class="form-control" name="username" id="username" placeholder="Seu usuario do painel" />
                    </div>
                    
                    <div class="form-group col-md-6" >
                        <label>Senha</label>
                        <input type="password" value="" class="form-control" name="password" id="password" placeholder="Sua senha do painel" />
                    </div>
                    
                    <div class="form-group col-md-6" >
                        <label>CMS do painel</label>
                        <input type="url" class="form-control" value="" name="cms" id="cms" placeholder="Link do seu painel" />
                        <small><span class="text-info" style="cursor:pointer;" onclick="help('cms');" > <i class="fa fa-question-circle" ></i>  Ajuda</span> </small>
                        
                           <p style="margin-top:20px;" > <i class="fa fa-warning text-warning"></i> Não copie nenhum endereço a mais do que o link principal, (Clique em ajuda para saber mais)
                        </p>
                    </div>
                    <div class="form-group col-md-6" >
                        <label>Painel</label>
                         <select class="form-control" id="painel" name="painel" >
                             <option value="" >Selecionar</option>
                             <option value="xtream-ui" >Xtream-UI</option>
                             <option value="kofficeV2" >KOffice v2</option>
                             <option value="kofficeV4" >KOffice v4</option>
                             <option value="kofficev4_12" >KOffice V4.1.2</option>
                         </select>
                         <small>Quer sugerir outro painel para que possamos criar uma integração ? <a target="_blank" href="<?=SET_URL_PRODUCTION?>/faq?wpp&text=Eu gostaria de sugerir um outro painel para integrar ao gestor lite." >Clique aqui</a></small>
                    </div>
                </div>
                
                
            </div>
            
             <div class="col-md-12" >
                <div id="return-msg_add" ></div>
            </div>
            
           
            
        </div>
   
      </div>

     <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btn_add_dados_painel" onclick="add_dados_painel();" >Adicionar</button>
       <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $idioma->fechar; ?></button>
     </div>
    </div>

   </div>
 </div>
 
 <script>
     function help(tipo){
         
       $("#modal_credencial").modal('toggle');


    
         $("#api_cms_painel_help").modal('show');
         $("body").addClass('modal-open');
         
         
         setTimeout(function(){ $("body").addClass('modal-open'); },2000);
         
     }
     
     $('#api_key_help').on('hidden.bs.modal', function (e) {
       $("#modal_credencial").modal('show');
    });
    $('#api_cms_help').on('hidden.bs.modal', function (e) {
       $("#modal_credencial").modal('show');
    });


 </script>

 <!-- footer -->
 
 <?php include_once 'inc/footer.php'; ?>
<script typ="text/javascript" src="<?=SET_URL_PRODUCTION?>/painel/js/xtream_ui.js" ></script>
