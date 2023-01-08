 
  function renew_user_rev(cli,plano){
      $("#id_plano_cli_rev_renew").val(plano);
      $("#modal_ren_cliente").modal('show');
      $("#id_cli_rev").val(cli);
  }
  
  function info_p(){
      var id_plano = $("#id_plano_cli_rev_renew").val();
      var id_plano2 = $("#id_plano_cli_rev").val();
      
      if(id_plano == 7 || id_plano2 == 7){
         // alert("Vai vender o plano Patrão ? Entre em contato conosco antes ! Isso é obrigatório.");
      }
      
  }
  
  function renew_rev_cli(){
      
      $("#btn_renew_rev").prop('disabled', true);
      $("#btn_renew_rev").html('Adicionar <i class="fa fa-refresh fa-spin" ></i>');
      
      var id_plano = $("#id_plano_cli_rev_renew").val();
      var vencimento = $("#vencimento_cli_rev_renew").val();
      var id_cli = $("#id_cli_rev").val();
      
      $.post('../control/control.renew_cli_rev.php',{id_plano:id_plano,vencimento:vencimento,id_cli:id_cli},function(data){
          var obj = JSON.parse(data);

             if(typeof obj != "undefined"){
        
               if(typeof obj.erro != "undefined"){
              
                if(obj.erro){
                    
                   $("#response_cli_rev_renew").addClass('text-danger');
                   $("#response_cli_rev_renew").removeClass('text-success');
                   $("#response_cli_rev_renew").html('<b>'+obj.msg+'</b>');
                   $("#btn_renew_rev").prop('disabled', false);
                   $("#btn_renew_rev").html('Adicionar');
                 }else{
                   $("#response_cli_rev_renew").addClass('text-success');
                   $("#response_cli_rev_renew").removeClass('text-danger');
                   $("#response_cli_rev_renew").html('<b>'+obj.msg+'</b>');
                   location.href="";
                 }
                         
              
               }else{
                   $("#response_cli_rev_renew").addClass('text-danger');
                   $("#response_cli_rev_renew").removeClass('text-success');
                   $("#response_cli_rev_renew").html('Erro, por favor, comunicar ao suporte.');
                   $("#btn_renew_rev").prop('disabled', false);
                   $("#btn_renew_rev").html('Adicionar');
                 }
            
             }else{
               $("#response_cli_rev_renew").addClass('text-danger');
               $("#response_cli_rev_renew").removeClass('text-success');
               $("#response_cli_rev_renew").html('Erro, por favor, comunicar ao suporte.');
               $("#btn_renew_rev").prop('disabled', false);
               $("#btn_renew_rev").html('Adicionar');
             }
      });
  }
 
 
  function payment_credits() {

    $("#btn_pay_cred").prop('disabled', true);
    $("#btn_pay_cred").html('<i class="fa fa-refresh fa-spin" ></i> Aguarde');

    const num_cred = $("#qtd_credit").val();
    const tipo_pay = $("#tipo_pay").val();

    if(num_cred == "" || typeof num_cred == "undefined"){
      alert('Não entendi quantos créditos você precisa, diga de novo.');
      $("#btn_pay_cred").prop('disabled', false);
      $("#btn_pay_cred").html('Pagar');
    }

    $.post('../control/control.register_pay_credits.php',{cred:num_cred,tipo_pay:tipo_pay},function(data){

      var obj = JSON.parse(data);

      if(obj.erro){

        alert(obj.msg);

        if(typeof obj.redirect != "undefined"){
          if(obj.redirect){
            location.href="pagamentos?click";
          }
        }else{
          location.href="pagamentos?click";
        }



      }else{
        if(tipo_pay == "mp"){
         location.href="pagamentos?click";
        }else{
          location.href="";
        }
      }

      $("#btn_pay_cred").prop('disabled', false);
      $("#btn_pay_cred").html('Pagar');

    });

  }
  
  function calc_qtd_credits_add_cli_renew(){
      
      var id_plano = $("#id_plano_cli_rev_renew").val();
      var vencimento = $("#vencimento_cli_rev_renew").val();
      $.post('../control/control.calc_credits.php',{calc:'',id_plano:id_plano,vencimento:vencimento},function(data){

         var obj = JSON.parse(data);
    
         if(typeof obj.erro != "undefined"){
    
           if(obj.erro == false){
             $("#qtd_cred_rev_renew").val(obj.creditos);
           }else{
             $("#qtd_cred_rev_renew").val('0');
           }
    
         }
    
      });
  }
  
  
  function calc_qtd_credits_add_cli() {
   var id_plano = $("#id_plano_cli_rev").val();
   var vencimento = $("#vencimento_cli_rev").val();
   $.post('../control/control.calc_credits.php',{calc:'',id_plano:id_plano,vencimento:vencimento},function(data){

     var obj = JSON.parse(data);

     if(typeof obj.erro != "undefined"){

       if(obj.erro == false){
         $("#qtd_cred_rev").val(obj.creditos);
       }else{
         $("#qtd_cred_rev").val('0');
       }

     }

   });
 }
 
 function add_new_cli() {

   $("#btn_add_cli_rev").prop('disabled', true);
   $("#btn_add_cli_rev").html('<i class="fa fa-refresh fa-spin" ></i> Aguarde');

   var json_cli = $("#json_inputs").val();

   $.post('../control/control.add_cli_rev.php',{add_cli:'',dados:json_cli},function(data){

     var obj = JSON.parse(data);

     if(typeof obj != "undefined"){

       if(typeof obj.erro != "undefined"){

         if(obj.erro){
           $("#response_add_new_cli_rev").addClass('text-danger');
           $("#response_add_new_cli_rev").removeClass('text-success');
           $("#response_add_new_cli_rev").html('<b>'+obj.msg+'</b>');
           $("#btn_add_cli_rev").prop('disabled', false);
           $("#btn_add_cli_rev").html('Adicionar');
         }else{
           $("#response_add_new_cli_rev").addClass('text-success');
           $("#response_add_new_cli_rev").removeClass('text-danger');
           $("#response_add_new_cli_rev").html('<b>'+obj.msg+'</b>');
           location.href="";
         }


       }else{
         $("#response_add_new_cli_rev").addClass('text-danger');
         $("#response_add_new_cli_rev").removeClass('text-success');
         $("#response_add_new_cli_rev").html('Erro, por favor, comunicar ao suporte.');
         $("#btn_add_cli_rev").prop('disabled', false);
         $("#btn_add_cli_rev").html('Adicionar');
       }

     }else{
       $("#response_add_new_cli_rev").addClass('text-danger');
       $("#response_add_new_cli_rev").removeClass('text-success');
       $("#response_add_new_cli_rev").html('Erro, por favor, comunicar ao suporte.');
       $("#btn_add_cli_rev").prop('disabled', false);
       $("#btn_add_cli_rev").html('Adicionar');
     }



   });



 }
 
   function modal_solicita_money() {
    $("#modal_solicita_saque").modal('show');
  }

 function modal_del_user_rev(id) {
   $("#id_modal_del_user_rev").val(id);
   $("btn_del_"+id).html('<i class="fa fa-refresh fa-spin" ></i>');
   if($("#modal_del_user_rev").modal('show')){
     $("btn_del_"+id).html('<i class="fa fa-trash" ></i>');
   }

 }
 
   function delete_user_rev() {

    $("#btn_modal_del_user").prop('disabled', true);

    var id = $("#id_modal_del_user_rev").val();

    $.post('../control/control.remove_cli_rev.php',{id:id},function(data){
      if(data == 1 || data == "1"){
        location.href="";
      }else{
        alert('Erro ao deltar');
        $("#btn_modal_del_user").prop('disabled', false);
      }
    });

  }


 function solicita_saque() {

   $("#btn_solicita_saque").prop('disabled', true);

   var info = $("#info_saque").val();
   var valor = $("#valor_saque").val();

   $.post('../control/control.solicita_saque.php',{info:info,valor:valor},function(data){

      var objRes = JSON.parse(data);

     if(typeof objRes.erro != "undefined"){
      
      alert(objRes.msg);
      location.reload();
     }else{
       alert('Erro, entre em contato com o suporte');
       
     }

    $("#btn_solicita_saque").prop('disabled', false);


   });

 }

   function verific_inputs_add_cli() {
   setInterval(function(){
     verific_inputs_add_cli2();
   },1000);
 }

 function verific_inputs_add_cli2() {

   var cli_add = new Object();

   cli_add.nome = $("#nome_cli_rev").val();
   cli_add.email = $("#email_cli_rev").val();
   cli_add.ddi = $("#ddi_cli_rev").val();
   cli_add.telefone = $("#telefone_cli_rev").val();
   cli_add.senha = $("#senha_cli_rev").val();
   cli_add.id_plano = $("#id_plano_cli_rev").val();
   cli_add.vencimento = $("#vencimento_cli_rev").val();
   cli_add.qtd_cred = $("#qtd_cred_rev").val();

   var dados = JSON.stringify(cli_add);
   $("#json_inputs").val(dados);

   if(cli_add.nome != "" && cli_add.email != "" && cli_add.ddi != "" && cli_add.telefone != "" && cli_add.senha != "" && cli_add.id_plano != "" && cli_add.vencimento != "" && cli_add.qtd_cred>0){
     $("#btn_add_cli_rev").prop('disabled', false);
   }else{
     $("#btn_add_cli_rev").prop('disabled', true);
   }

 }
