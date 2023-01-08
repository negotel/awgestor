
(function ($) {
    "use strict";


    /*==================================================================
    [ Focus Contact2 ]*/
    $('.input100').each(function(){
        $(this).on('blur', function(){
            if($(this).val().trim() != "") {
                $(this).addClass('has-val');
            }
            else {
                $(this).removeClass('has-val');
            }
        })
    })



    /*==================================================================
    [ Validate ]*/
    var name = $('.validate-input input[name="name"]');
    var email = $('.validate-input input[name="email"]');
    var whatsapp = $('.validate-input input[name="whatsapp"]');


    $('.validate-form').on('submit',function(event){

      event.preventDefault();
      
      
      
      if (grecaptcha === undefined) {
    		alert('Recaptcha not defined'); 
    		return; 
    	}
    
    	var response = grecaptcha.getResponse();
    
    	if (!response) {
    	  	  $("#modal_return").modal('show');
              $("#msg_return").removeClass();
              $("#msg_return").addClass('text-danger');
              $("#msg_return").html('<i class=\'fa fa-close\' ></i> Complete o reCAPTCHA para continuar');
              
              setTimeout(function(){
                $("#modal_return").modal('hide');
              },3000);
              
    		return; 
    	}
  
  
     	var ajax = new XMLHttpRequest();
    	ajax.onreadystatechange = function() {
    		if (this.readyState === 4) {
    			if (this.status === 200) {
    				alert(this.responseText);
    			}
    		}
    	}   
      
      
      
      
      
      
      
      
      $.post('control/valida_recaptcha.php',{recaptcha:response},function(data1){
          
          var objRes = JSON.parse(data1);
          
          if(objRes.erro == false){
              
              if(objRes.success == false){
                  $("#modal_return").modal('show');
                  $("#msg_return").removeClasass();
                  $("#msg_return").addClass('text-danger');
                  $("#msg_return").html(objRes.msg);
                  
                  setTimeout(function(){
                    $("#modal_return").modal('hide');
                  },3000);
                  
                  grecaptcha.reset();
                  
              }else if(objRes.success == true){
                  
                        
              $("#btn_gerar").prop('disabled', true);
              $("#icon_refresh").addClass('fa-spin');
        
                var check = true;
        
                if($(name).val().trim() == ''){
                    showValidate(name);
                    check=false;
                }
        
        
                if($(email).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
                    showValidate(email);
                    check=false;
                }
        
                if(check){
        
                  var obj        = new Object();
                  obj.email      = $(email).val();
                  obj.nome       = $(name).val();
                  obj.whatsapp   = $(whatsapp).val();
                  obj.ddi        = $("#ddi").val();
                  obj.package_id = $("#package_id").val();
                  obj.chave      = $("#chave").val();
        
                  var json = JSON.stringify(obj);
        
                  $.post('control/control.request.php',{json},function(data){
        
                    var objReturn = JSON.parse(data);
        
                    if(typeof objReturn.erro != "undefined"){
        
                        $("#modal_return").modal('show');
                        $("#msg_return").removeClass();
        
                        if(objReturn.erro){
                          $("#msg_return").addClass('text-danger');
                          $("#msg_return").html('<i class="fa fa-close" ></i> '+objReturn.msg);
        
                        }else{
                          $("#msg_return").addClass('text-success');
                          $("#msg_return").html('<i class="fa fa-check" ></i> '+objReturn.msg);
        
                        }
        
                    }else{
                      $("#modal_return").modal('show');
                      $("#msg_return").removeClass();
                      $("#msg_return").addClass('text-danger');
                      $("#msg_return").html('Erro ineperado');
                    }
        
                    setTimeout(function(){
                        $("#modal_return").modal('hide');
                    },10000);
        
                    $("#btn_gerar").prop('disabled', false);
                    $("#icon_refresh").removeClass('fa-spin');
        
                  });
        
                }else{
                  $("#btn_gerar").prop('disabled', false);
                  $("#icon_refresh").removeClass('fa-spin');
                }
                  
              }
              
              
          }else{
                $("#modal_return").modal('show');
                $("#msg_return").removeClass();
                $("#msg_return").addClass('text-danger');
                $("#msg_return").html('Erro inesperado');
                
                setTimeout(function(){
                    $("#modal_return").modal('hide');
                },10000);
    
                $("#btn_gerar").prop('disabled', false);
                $("#icon_refresh").removeClass('fa-spin');
          }
          
          
          
      });
      
    });


    $('.validate-form .input100').each(function(){
        $(this).focus(function(){
           hideValidate(this);
       });
    });

    function showValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).addClass('alert-validate');
    }

    function hideValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).removeClass('alert-validate');
    }



})(jQuery);
