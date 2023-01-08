 
    function modal_novidade(){
        $("#oquee").modal('show');
    }
 
    function modal_question_r(texto){
        $("#bodyMR").html(texto);    
        $("#modalR").modal('show');
    }
    
    function back_div(){
        
        $("#btn_solicita_flyer").hide(); 
        $("#btn_next_div").show();
         
        var div_num = parseInt($("#div_active").val());
        var back_div = div_num-1;

        $("#div_"+div_num).hide(100);
        $("#div_"+back_div).show(100);
        $("#div_active").val(back_div);
        
        if(back_div == 1){
         $("#btn_back_div").hide();   
        }
        
    }
    
    function next_div(){
        
        var div_num = parseInt($("#div_active").val());
        var next_div = div_num+1;
        
      

        $("#div_"+div_num).hide(100);
        $("#div_"+next_div).show(100);
        
        $("#div_active").val(next_div);
        $("#btn_back_div").show();
        
        if(div_num == 10){
          $("#btn_next_div").hide();   
          $("#btn_solicita_flyer").show();   
        }
        
       
    }
 
 
     function solicita_flyer(){
        $("#btn_solicita_flyer").prop('disabled', true);
        $("#btn_solicita_flyer").html('Aguarde <i class="fa fa-spinner fa-spin" ></i>');
         
         
         var dados = $("#form_solicita_flyer").serialize();
         $.post("../control/control.flyer.php",{solicita:true,dados:dados},function(data){
            try {
              var obj = JSON.parse(data);
              if(obj.erro){
                  $("#msg_return").removeClass('alert alert-danger alert alert-success');
                  $("#msg_return").addClass('alert alert-danger');
                  $("#msg_return").html(obj.msg);
              }else{
                  $("#msg_return").removeClass('alert alert-danger alert alert-success');
                  $("#msg_return").addClass('alert alert-success');
                  $("#msg_return").html(obj.msg);
                  setTimeout(function(data){
                     location.href="";
                  });
              }
            }
            catch (e) {
                  $("#msg_return").removeClass('alert alert-danger alert alert-success');
                  $("#msg_return").addClass('alert alert-danger');
                  $("#msg_return").html('Desculpe, não consegui trabalhar direito. Entre em contato com suporte técnico.');
            }
            
            $("#btn_solicita_flyer").prop('disabled', false);
            $("#btn_solicita_flyer").html('Enviar');
            
            
         });
         
         
     }