function value_checkbox(id){
  if(typeof $(id).val() != "undefined"){
    
    if( $(id).is(":checked") == true ){
        var situ = 1;
    }else{
        var situ = 0;
    }
       
   }else{
       var situ = 0;
   }

 return situ;
}

function remove_painel(){
    $("#btn_remove").prop('disabled', true);
    $("#btn_remove").html('Aguarde <i class="fa fa-refresh fa-spin" ></i> ');
    
    var id = $("#id_remove_painel").val();
    
    $.post('../control/xtream-ui/control.add_credenciais.php',{remove:true,id:id},function(data){
        
        location.reload();
        
    });
}


function edit_modal_painel(id){
    $.post('../control/xtream-ui/control.add_credenciais.php',{info_painel:true,id:id},function(data){
       if(data != 0){
           
           var obj = JSON.parse(data);
           
           $("#nome_edit").val(obj.nome);
           $("#username_edit").val(obj.username);
           $("#password_edit").val(obj.password);
           $("#cms_edit").val(obj.cms);
           $("#painel_edit").val(obj.api);
           $("#chave_edit").val(obj.chave);
           
           
           $("#modal_credencial_edit").modal('show');
           
           if(obj.receber_aviso == '1' || obj.receber_aviso == 1){
               $("#situ_aviso_zap_edit").prop('checked', true);
           }else{
               $("#situ_aviso_zap_edit").prop('checked', false);
           }
           
           if(obj.cloud == '1' || obj.cloud == 1){
               $("#situ_cloud").prop('checked', true);
           }else{
               $("#situ_cloud").prop('checked', false);
           }
           
          if(obj.situ_teste == '1' || obj.situ_teste == 1){
               $("#situ_api_teste_api_edit").prop('checked', true);
           }else{
               $("#situ_api_teste_api_edit").prop('checked', false);
           }
           
           
       }else{
           alert('Desculpe, tente mais tarde.');
       } 
    });
}

function remove_painel_modal(id){
    $("#id_remove_painel").val(id);
    $('#remove_painel_modal').modal('show');
}


function modal_iframe(id){
    var iframe_c = $("#ifram_cod_"+id).val();
    $("#codigo_iframe").val(iframe_c);
    $("#api_painel_iframe").modal('show');
}

function save_dados_painel(){
    
    $("#btn_save_dados_painel").prop('disabled', true);
    $("#btn_save_dados_painel").html('Salvar <i class="fa fa-refresh fa-spin" ></i>');
    
    var obj = new Object();
    obj.nome     = $("#nome_edit").val();
    obj.username = $("#username_edit").val();
    obj.password = $("#password_edit").val();
    obj.cms     = $("#cms_edit").val();
    obj.situ_teste = value_checkbox("#situ_api_teste_api_edit");
    obj.receber_aviso = value_checkbox("#situ_aviso_zap_edit");
    obj.chave   = $("#chave_edit").val();
    obj.painel  = $("#painel_edit").val();
    obj.cloud   = value_checkbox("#situ_cloud");
    
    dados = JSON.stringify(obj);
    
    $.post('../control/xtream-ui/control.add_credenciais.php',{dados},function(data){
        
        var objReturn = JSON.parse(data);
        
        if(typeof objReturn.erro != "undefined"){
            
            if(objReturn.erro){
                $("#return-msg").show();
                $("#return-msg").removeClass();
                $("#return-msg").addClass('alert alert-danger');
                $("#return-msg").html(objReturn.msg);
            }else{
                $("#return-msg").show();
                $("#return-msg").removeClass();
                $("#return-msg").addClass('alert alert-success');
                $("#return-msg").html(objReturn.msg);
                
                setTimeout(function(){
                    $("#return-msg").hide();
                    $("#return-msg").removeClass();
                    location.reload();
                    
                },3000);
        
        
            }
            
        }else{
            $("#return-msg").show();
            $("#return-msg").removeClass();
            $("#return-msg").addClass('alert alert-danger');
            $("#return-msg").html("Houve algum problema, entre em contato com o suporte");
        }
        
        
        $("#btn_save_dados_painel").prop('disabled', false);
        $("#btn_save_dados_painel").html('Salvar');
        
        
    });
    
}


function add_dados_painel(){
    
    $("#btn_add_dados_painel").prop('disabled', true);
    $("#btn_add_dados_painel").html('Salvar <i class="fa fa-refresh fa-spin" ></i>');
    
    var obj = new Object();
    obj.nome = $("#nome").val();
    obj.username = $("#username").val();
    obj.password = $("#password").val();
    obj.cms     = $("#cms").val();
    obj.situ_teste = value_checkbox("#situ_api_teste_api");
    obj.receber_aviso = value_checkbox("#receber_aviso");
    obj.chave   = 'null';
    obj.painel  = $("#painel").val();
    
    dados = JSON.stringify(obj);
    
    $.post('../control/xtream-ui/control.add_credenciais.php',{dados},function(data){
        
        var objReturn = JSON.parse(data);
        
        if(typeof objReturn.erro != "undefined"){
            
            if(objReturn.erro){
                $("#return-msg_add").show();
                $("#return-msg_add").removeClass();
                $("#return-msg_add").addClass('alert alert-danger');
                $("#return-msg_add").html(objReturn.msg);
            }else{
                $("#return-msg_add").show();
                $("#return-msg_add").removeClass();
                $("#return-msg_add").addClass('alert alert-success');
                $("#return-msg_add").html(objReturn.msg);
                
                setTimeout(function(){
                    $("#return-msg_add").hide();
                    $("#return-msg_add").removeClass();
                    location.reload();
                    
                },3000);
        
        
            }
            
        }else{
            $("#return-msg_add").show();
            $("#return-msg_add").removeClass();
            $("#return-msg_add").addClass('alert alert-danger');
            $("#return-msg_add").html("Houve algum problema, entre em contato com o suporte");
        }
        
        
        $("#btn_add_dados_painel").prop('disabled', false);
        $("#btn_add_dados_painel").html('Salvar');
        
        
    });
    
}

