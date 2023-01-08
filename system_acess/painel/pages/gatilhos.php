
<!-- Head and Nav -->
<?php include_once 'inc/head-nav.php'; ?>


    <!-- NavBar -->
    <?php include_once 'inc/nav-bar.php'; ?>
   <main class="page-content">
    
    <div class="container">
        
       <div class="row">
           
           
                  <div class="col-md-12">
                    <h1 class="h2">Gatilhos para ser usado nos templates de mensgens</h1>
                  </div>
                  
                 <div class="col-md-12">
                      
                  <div class="table-responsive">
                    <span>Ao utilizar alguma dos gatilhos, deve-se usar juntamente com o <b>{ &nbsp; }</b></span>
                    <table class="table-bordered table table-striped table-sm">
                      <thead>
                        <tr>
                          <th class="text-right" >Gatilho</th>
                          <th style="width:60%;" >Função</th>
                        </tr>
                      </thead>
                      <tbody>
            
            
                        <tr>
                          <td class="text-right" ><b class="text-danger" >{nome_cliente}</b></td>
                          <td class="text-left" >Nome do seu cliente que está a receber</td>
                        </tr>
            
                        <tr>
                          <td class="text-right" ><b class="text-danger" >{primeiro_nome_cliente}</b></td>
                          <td class="text-left" >Primeiro nome do seu cliente que está a receber</td>
                        </tr>
            
                        <tr>
                          <td class="text-right" ><b class="text-danger" >{email_cliente}</b></td>
                          <td class="text-left" >Email do seu cliente que está a receber</td>
                        </tr>
                
                        <tr>
                          <td class="text-right" ><b class="text-danger" >{senha_cliente}</b></td>
                          <td class="text-left" >Senha do cliente, para login na área do cliente</td>
                        </tr>
            
            
                        <tr>
                          <td class="text-right" ><b class="text-danger" >{telefone_cliente}</b></td>
                          <td class="text-left" >Telefone do seu cliente que está a receber</td>
                        </tr>
            
                        <tr>
                          <td class="text-right" ><b class="text-danger" >{vencimento_cliente}</b></td>
                          <td class="text-left" >Vencimento do seu cliente que está a receber</td>
                        </tr>
            
                        <tr>
                          <td class="text-right" ><b class="text-danger" >{plano_nome}</b></td>
                          <td class="text-left" >Nome do plano que seu cliente contratou [ nome do plano que estás a configurar ]</td>
                        </tr>
            
                        <tr>
                          <td class="text-right" ><b class="text-danger" >{plano_valor}</b></td>
                          <td class="text-left" >Valor do plano que seu cliente contratou [ valor do plano que estás a configurar ]</td>
                        </tr>
            
                        <tr>
                          <td class="text-right" ><b class="text-danger" >{data_atual}</b></td>
                          <td class="text-left" >Data atual no momento do envio da mensagem</td>
                        </tr>
                        
                        <tr>
                          <td class="text-right" ><b class="text-danger" >{plano_link}</b></td>
                          <td class="text-left" >Link de pagamento (É necessário credenciais MP e Área do cliente ativa)</td>
                        </tr>
            
            
                      </tbody>
                    </table>
                  </div>
              </div>
              </div>
       </main>
  </div>
</div>



 <!-- footer -->
 <?php include_once 'inc/footer.php'; ?>
