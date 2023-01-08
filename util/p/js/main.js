
	
   function continuar_gliteme(){
       
        $("#button_next").prop('disabled', true);
        $("#button_next").html('Aguarde...'); 
         
          var ddiObject = iti.getSelectedCountryData();
          var ddi = ddiObject.dialCode;
         
         var plano   = new Object();
         plano.id_plano  = $("#plano_id").val();
         plano.nome  = $("#nome").val();
         plano.email = $("#email").val();
         plano.ddi   = ddi;
         plano.wpp   = $("#telefone").val();
         
         var json = JSON.stringify(plano);
         
         var captcha = $("#captcha").val();
         
         $.post('control/control.init_proc.php',{json:json,captcha:captcha},function(data){
              var respondeJson = JSON.parse(data);
              if(respondeJson.erro){
                  alert(respondeJson.msg);
                  $("#button_next").prop('disabled', false);
                  $("#button_next").html('Ir para pagamento');
              }else{
                  location.href=respondeJson.link;
              }
         });
         
     }
	