
 function save_my_profile(){

   $("#bnt_form_profile").prop('disabled', true);
   $("#bnt_form_profile").html('<i class="fa fa-spinner fa-spin"></i> Aguarde ');

   var cliente = new Object();
   cliente.nome = $("#nome_cli").val();
   cliente.email = $("#email_cli").val();
   if($("#senha_cli").val() == ""){
     cliente.senha = "none";
   }else{
     cliente.senha = $("#senha_cli").val();
   }

   var dados = JSON.stringify(cliente);

   $.post('https://cliente.gestorlite.com/control/control.edite_dados_cliente.php',{dados:dados},function(data){

     var obj = JSON.parse(data);

     if(obj.erro){
       $("#response_msg_profile").removeClass('text-success');
       $("#response_msg_profile").addClass('text-danger');
       $("#response_msg_profile").html('<i class="fa fa-close" ></i> '+obj.msg);
     }else{
       $("#response_msg_profile").removeClass('text-danger');
       $("#response_msg_profile").addClass('text-success');
       $("#response_msg_profile").html('<i class="fa fa-check" ></i> '+obj.msg);
     }

     $("#senha_cli").val('');
     $("#bnt_form_profile").prop('disabled', false);
     $("#bnt_form_profile").html('<i class="fa fa-floppy-o" ></i> Salvar');

     setTimeout(function(){
       $("#response_msg_profile").html('');
     },3000);

   });

 }
 
 
 function payment(fat,ref,metodo,valor,plano){
     
     documento_cpf = false;


    if(metodo == "MP"){
     $("#btn_payment_"+fat).prop('disabled', true);
     $("#btn_payment_"+fat).html('<i class="fa fa-spin fa-refresh" ></i> Aguarde');
    }else if(metodo == "PH"){
        
        
          var person = prompt("POR FAVOR INFORME SEU CPF SEM TRAÇOS E SEM PONTOS", "");
          if (person == null || person == "") {
            documento_cpf = false;
          } else {
            documento_cpf = person;
          }
          
          if(documento_cpf == false){
              $("#btn_payment_ph_"+fat).prop('disabled', false);
              $("#btn_payment_ph_"+fat).html('Pag Hiper / Boleto <i class="fa fa-barcode" ></i>');
              return false;
          }
        
        $("#btn_payment_ph_"+fat).prop('disabled', true);
        $("#btn_payment_ph_"+fat).html('<i class="fa fa-spin fa-refresh" ></i> Aguarde');
    }     
     var pay = new Object();
     
     pay.id_cli = $("#USER_CLI").val();
     pay.ref    = ref;
     pay.metodo = metodo;
     pay.valor  = valor;
     pay.plano  = plano;
     pay.cpf    = documento_cpf;
     
     var dados = JSON.stringify(pay);
     
     var urlEndpoint = "";
        
        if(metodo == "MP"){
            urlEndpoint = "https://cliente.gestorlite.com/control/control.payment_mp.php";
        }else if(metodo == "PH"){
            urlEndpoint = "https://cliente.gestorlite.com/control/control.payment_ph.php";
        }
     
     
     $.post(urlEndpoint,{dados:dados},function(data){
         
         var obj = JSON.parse(data);
         
         if(obj.erro){
             alert(obj.msg);
             location.href="";
             return false;
         }
        
         location.href=obj.link;
         
         
     }).fail(function() {
        alert( "Erro, entre em contato com o suporte." );
        $("#btn_payment_"+fat).prop('disabled', false);
        $("#btn_payment_"+fat).html('Pagar');
      });
      
      
      
 }
 
 
