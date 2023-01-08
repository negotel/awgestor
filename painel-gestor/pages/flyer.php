<?php 

  $flyer_class = new Flyer();
  $list_flyer = $flyer_class->list_flyer($user->id);

?>
<!-- Head and Nav -->
<?php include_once 'inc/head-nav.php'; ?>



    <!-- NavBar -->
    <?php include_once 'inc/nav-bar.php'; ?>

      <main class="page-content">
    
     <div class="container">
        
        <div class="row">
            
      <div class="col-md-12">
        <h2 class="h2">Flyers <i class="fa fa-crop"></i> </h2>
        <span>Solicite a criação de um Flyer (Banner)  somente seu</span>
     </div>
     <div class="col-md-12">
     <div class="row">
       <div class="col-md-12 text-center">
        <button class="btn btn-success btn-sm" onclick="$('#modal_solicita_flyer').modal('show');" >Solicitar Novo Flyer</button>     
       </div>
       <div class="col-md-12">
        <h3>Meus últimos pedidos</h3>
         <div class="table-responsive">
            <table class="table table-striped table-sm">
              <thead>
                <tr>
                  <th>Data</th>
                  <th>Tipo</th>
                  <th>Status</th>
                  <th>Download</th>
                </tr>
              </thead>
              <tbody>
                  
                  <?php if($list_flyer){ ?>
    
    
                    <?php while($flyer = $list_flyer->fetch(PDO::FETCH_OBJ)){ 
                    
                    
                    $status['Pendente'] = '<span class="badge badge-secondary" >Pendente</span>';
                    $status['Processando'] = '<span class="badge badge-warning" >Em criação</span>';
                    $status['Entregue'] = '<span class="badge badge-success" >Entregue</span>';
                    $status['Recusado'] = '<span class="badge badge-danger" >Recusado</span>';
                    
                    
                    
                    ?>
                    
                    <tr>
                      <td><?= $flyer->data; ?></td>
                      <td><?= $flyer->type; ?></td>
                      <td>
                          <?= $status[$flyer->status]; ?>
                          <?php if($flyer->status == "Recusado"){
                              echo '<i class="fa fa-question" style="cursor:pointer;" onclick="modal_question_r(\''.$flyer->info_adm.'\');" ></i>';
                          } ?>
                      </td>
                      <td>
                          <?php if($flyer->link_download == NULL){ ?>
                           <button class="btn btn-outline-primary" style="cursor:no-drop;" disabled >Download</button>
                          <?php } ?>
                          
                          <?php if($flyer->link_download != NULL){ ?>
                           <a href="<?= $flyer->link_download; ?>" target="_blank" class="btn btn-outline-primary" >Download</a>
                          <?php } ?>
                          
                      </td>
                    </tr>
                    
                    <?php } ?>
    
                <?php }else{ ?>
                
                    <tr>
                      <td colspan="5" class="text-center" >Nada por aqui</td>
                    </tr>
                
                <?php } ?>
    
              </tbody>
            </table>
          </div>
       </div>
     </div>
    </div>
    </div>
    </div>
    </main>
  </div>
</div>



<div class="modal fade"  data-backdrop="static" id="modal_solicita_flyer" tabindex="-1" role="dialog" aria-labelledby="Titutlo_modal_pareamento" aria-hidden="true">
 <div class="modal-dialog" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title" id="Titutlo_modal_fat_cli">Solicitar Criação de um Flyer</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body " id="body_modal_solicita_flyer" >
         

        <div class="row" >
            
            
             <form id="form_solicita_flyer" class="col-md-12" name="form_solicita_flyer" action="" >
                

                    
                     <div class="col-md-12" id="div_1">  
                     
                         <div class="form-group">
                             <label><?php echo explode(' ',$user->nome)[0];?>, selecione até 3 cores principais</label>
                             <div class="row">
                                 <div class="col-md-4">
                                     <input type="color" class="form-control" id="color" name="color[]" />
                                 </div>
                                 <div class="col-md-4">
                                     <input type="color" class="form-control" id="color" name="color[]" />
                                 </div>
                                 <div class="col-md-4">
                                     <input type="color" class="form-control" id="color" name="color[]" />
                                 </div>
                             </div>
                         </div>
                         <small>A cor número 1 será considerada a principal.</small>
                     </div>



                   <div class="col-md-12" style="display:none;" id="div_2">
                       <div class="form-group">
                           <label>Você gostaria de adicionar algum comentário sobre as cores?</label>
                           <input type="text" class="form-control" placeholder="Ex: quero que a cor número 1 apareça mais do que as demais" name="comments_color" />
                           <small>Deixe em branco caso não deseje adicionar um comentário.</small>
                       </div>
                   </div>
                   


                  <div class="col-md-12" style="display:none;" id="div_3">
                     <div class="form-group">
                         <label>Deseja o flyer no modelo Flat Design?</label>
                         <select class="form-control" id="flat_design" name="flat_design">
                            <option value="Não" >Não</option>
                            <option value="Sim" >Sim</option>
                         </select>
                         <small>O que é <a href="https://www.google.com/search?q=Flat+Design" target="_blank">Flat Design</a>?</small>
                     </div>
                  </div>
                   
                   
                   
                 <div class="col-md-12" style="display:none;" id="div_4" >
                     <div class="form-group">
                         <label>Qual tipo de arte você deseja <?php echo explode(' ',$user->nome)[0];?>?</label>
                         <select class="form-control" id="type" name="type">
                             
                            <option value="Flyer para Promoção " >Flyer para Promoção </option>
                            <option value="Flyer para Divulgação Institucional" >Flyer para Divulgação Institucional</option>
                            <option value="Flyer para ONGs" >Flyer para ONGs</option>
                            <option value="Flyer para Festa" >Flyer para Festa</option>
                            <option value="Flyer para Manifestações Sociais" >Flyer para Manifestações Sociais</option>
                            <option value="Flyer para Política" >Flyer para Política</option>
                            <option value="Flyer para Banda" >Flyer para Banda</option>
                            <option value="Flyer de Comunicado" >Flyer de Comunicado</option>
                            <option value="Flyer apresentação de produto" >Flyer apresentação de produto</option>
                            
                         </select>
                     </div>
                 </div>
                 
                    
                   
                    <div class="col-md-12" style="display:none;" id="div_5">
                      <div class="form-group">
                         <label>Muito bem <?php echo explode(' ',$user->nome)[0];?>, agora, se você deseja que adicionamos imagens em seu flyer. Por favor coloque-as no campo abaixo separadas por vírgula.</label>
                         <textarea class="form-control" id="imagens" name="imagens" placeholder="Ex: https://drive.google.com/view/3dY45d, https://site.com/img/54dh.jpg" ></textarea>
                         <small>Use Google Drive para upload das imagens ou um banco de imagens gratuito, como por exemplo <a href="https://uploaddeimagens.com.br" target="_blank" >UploadDeImagens.com.br</a></small>
                      </div>
                    </div>
                    
                    
                    
                    <div class="col-md-12" style="display:none;" id="div_6">  
                         <div class="form-group">
                             <label><?php echo explode(' ',$user->nome)[0];?> agora você deve definir quais as dimensões do flyer</label>
                             <div class="row">
                                 <div class="col-md-6">
                                     <small>Altura</small>
                                     <input type="number" placeholder="Ex: 1080" class="form-control" id="altura" name="altura" />
                                 </div>
                                 <div class="col-md-6">
                                     <small>Largura</small>
                                     <input type="number" placeholder="Ex: 1080" class="form-control" id="largura" name="largura" />
                                 </div>
                             </div>
                         </div>
                         <small>Dica: as dimensões 1080x1080 são consideradas o padrão para midias sociais</small>
                   </div>
                    
                    
                    
                     <div class="col-md-12" style="display:none;" id="div_7">
                       <div class="form-group">
                           <label>Você gostaria de linkar uma imagem que você particularmente gosta?</label>
                           <input type="text" class="form-control" placeholder="Ex: https://exemplo.com/imagens/flyer-bonitao.png" name="modelo_exemplo" />
                           <small>Você pode colocar o link de um banner que você gostou para entendermos melhor seu gosto.</small>
                       </div>
                     </div>
                     
                     
                     <div class="col-md-12" style="display:none;" id="div_8">
                      <div class="form-group">
                         <label>Este campo é destinado para você descrever todas as informações que devem ter no banner. Como preços, Nomes, Logos, Redes socias, etc...</label>
                         <textarea rows="8" class="form-control" id="informacoes" name="informacoes" placeholder="Ex: Eu quero que no centro do flyer tenha o nome 'Doces da vovó' bem grande, e mais abaixo..." ></textarea>
                         <small>Adicione o máximo de informações necessárias. Nós não fazemos alterações.</small>
                      </div>
                    </div>
                    
                     <div class="col-md-12" style="display:none;" id="div_9">
                      <div class="form-group">
                         <label>Adicione o link da sua logo</label>
                           <input type="text" class="form-control" placeholder="Ex: https://site.com/minhalogo.png" name="logo" id="logo" />
                         <small>Envie uma imagem com fundo transparente e com boa qualidade para ter um melhor resultado e seu pedido ser aceito.</small>
                      </div>
                    </div>
                     
                     
                      <div class="col-md-12" style="display:none;" id="div_10">
                       <div class="form-group">
                           <label>Por último, mas não menos importane.</label>
                           <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="1" class="custom-control-input" name="surpreender" id="surpreender">
                                <label class="custom-control-label" for="surpreender">Surpreenda-me</label>
                            </div>
                            <small>E aí <?php echo explode(' ',$user->nome)[0];?>, quer que façamos da melhor maneira possível seu flyer levando em consideração nosso conhecimento?</small>
                       </div>
                     </div>
                     
                     <div style="display:none;" class="col-md-12" id="div_11">
                      
                       <div class="row">
                            <div class="col-md-12 text-center">
                               <h4>Agora é so enviar e aguardar...</h4>
                             </div>
                           <div class="col-md-6">
                               <p>
                                   Após enviar, as informações serão enviadas para análise.
                                   Caso necessário nosso design entrará em contato para mais informações. 
                                   O prazo varia de 5 á 15 dias úteis para o termino da arte.
                               </p>
                           </div>
                           <div class="col-md-6">
                               <img width="100%" src="img/arte-para-flyer.png" />
                           </div>
                       </div>
                     </div>
                    
                    
                    <div class="" id="msg_return" ></div>
                    
                
                
             </form>
         
        </div>
     
      </div>
      
     <input type="hidden" id="div_active" value="1" />

     <div class="modal-footer">
       <button style="display:none;" type="button" onclick="back_div();" id="btn_back_div" class="btn btn-info" >Voltar</button>
       <button type="button" onclick="next_div();" id="btn_next_div" class="btn btn-primary" >Próximo</button>
       <button style="display:none;" type="button" onclick="solicita_flyer();" id="btn_solicita_flyer" class="btn btn-primary" >Enviar</button>
     </div>
    </div>

   </div>
 </div>
 
 
<div class="modal fade" id="modalR" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
 <div class="modal-dialog" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title" id="Titutlo_modal_fat_cli">Informações</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body " id="bodyMR" >
        
     </div>
    </div>

   </div>
 </div> 
 

 
 <!-- footer -->
 <?php include_once 'inc/footer.php'; ?>
