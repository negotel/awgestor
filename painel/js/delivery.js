function modal_add_delivery(){
  $("#modal_add_delivery").modal('show');
}
function add_delivery(){

    $("#btn_add_delivery").prop('disabled', true);
    $("#btn_add_delivery").html('Aguarde <i class="fa fa-spinner fa-spin" ></i>');
    
  const dadosDelivery = new Object();
  dadosDelivery.nome = $("#nome_delivery").val();
  dadosDelivery.plano_id = $("#plano_delivery").val();
  dadosDelivery.text_delivery =  $("#text_delivery").val();

  const dados = JSON.stringify(dadosDelivery);

  $.post('../control/control.add_delivery.php',{dados:dados},function(data){
       try{
            
            var obj = JSON.parse(data);
            
            $("#body_msg").html(obj.msg);
            $("#modal_add_delivery").modal('hide');
            $("#modal_msg").modal('show');
            
            if(obj.erro == false){
               setTimeout(function(){
                    location.href="";
               },3000);
            }
            
        }catch (e){
            alert('Desculpe, tente mais tarde.');
        }
       
       
        $("#btn_add_delivery").prop('disabled', false);
        $("#btn_add_delivery").html('Adicionar');
        
  });
  
}


function modal_add_Subdelivery(){
  $("#modal_add_Subdelivery").modal('show');
}

function add_subdelivery(){
    
    $("#btn_add_subdelivery").prop('disabled', true);
    $("#btn_add_subdelivery").html('Aguarde <i class="fa fa-spinner fa-spin" ></i>');
    
    var content = $("#content_subdelivery").val();
    var delivery = $("#idDelivery").val();
    var reverse = $("#reverse").val();
    $.post('../control/control.add_subdelivery.php',{content:content,delivery:delivery,reverse:reverse},function(data){
     
        try{
            
            var obj = JSON.parse(data);
            
            if(obj.erro){
                alert(obj.msg);
            }else{
                alert(obj.msg);
                location.href="";
            }
            
        }catch (e){
            alert('Desculpe, tente mais tarde.');
        }
       
       
        $("#btn_add_subdelivery").prop('disabled', false);
        $("#btn_add_subdelivery").html('Adicionar');
       
    });
}

function modal_del_subdelivery(id){
    $('#input_id_del_subdelivery').val(id);
    $("#modal_del_subdelivery").modal('show');
}

function del_subdelivery(){
    
    $("#btn_del_subdelivery").prop('disabled', true);
    $("#btn_del_subdelivery").html('Aguarde <i class="fa fa-spinner fa-spin" ></i>');

    var id = $('#input_id_del_subdelivery').val();
    var deliveryId = $("#deliveryId").val();
    $.post('../control/control.add_subdelivery.php',{deleteSub:true,id:id,deliveryId:deliveryId},function(data){
           try{
            
            var obj = JSON.parse(data);
            
            if(obj.erro){
                alert(obj.msg);
            }else{
                alert(obj.msg);
                location.href="";
            }
            
        }catch (e){
            alert('Desculpe, tente mais tarde.');
        }
       
       
        $("#btn_del_subdelivery").prop('disabled', false);
        $("#btn_del_subdelivery").html('Deletar');
    });
    
}

function edite_subdelivery(id){
    var deliveryId = $("#deliveryId").val();
    $.post('../control/control.add_subdelivery.php',{getInfo:true,id:id,deliveryId:deliveryId},function(data){
         try{
            
            var obj = JSON.parse(data);
            
            $("#id_subdelivery_edite").val(id);
            $("#content_subdelivery_edite").val(obj.content);
            $("#reverse_subdelivery_edite").val(obj.reverse);
            $("#modal_edite_subdelivery").modal('show');
             
        }catch (e){
            alert('Desculpe, tente mais tarde.');
        }
    });
}

function edite_subdelivery_form(){
    
    $("#btn_edite_subdelivery").prop('disabled', true);
    $("#btn_edite_subdelivery").html('Aguarde <i class="fa fa-spinner fa-spin" ></i>');
    
    var content = $("#content_subdelivery_edite").val();
    var id  = $("#id_subdelivery_edite").val();
    var deliveryId = $("#deliveryIdEdit").val();
    var reverse = $("#reverse_subdelivery_edite").val();
    
        $.post('../control/control.add_subdelivery.php',{editSub:true,id:id,contentEdit:content,deliveryId:deliveryId,reverse:reverse},function(data){
           try{
            
            var obj = JSON.parse(data);
            
            if(obj.erro){
                alert(obj.msg);
            }else{
                alert(obj.msg);
                location.href="";
            }
            
        }catch (e){
            alert('Desculpe, tente mais tarde.');
        }
       
       
       $("#btn_edite_subdelivery").prop('disabled', false);
      $("#btn_edite_subdelivery").html('Editar');
    });
}

function edite_delivery(id){
   
       $.post('../control/control.add_delivery.php',{getInfo:true,id:id},function(data){
         try{
            
            var obj = JSON.parse(data);
            
            if(obj.erro){
                $("#body_msg").html(obj.msg);
                $("#modal_add_delivery").modal('hide');
                $("#modal_msg").modal('show');
            }else{
            
                $("#id_delivery_edit").val(id);
                $("#nome_delivery_edit").val(obj.nome);
                $("#plano_delivery_edit").val(obj.plano_id);
                $("#situ_delivery_edit").val(obj.situ);
                $("#text_delivery_edit").val(obj.text_delivery);
                $("#modal_edite_delivery").modal('show');
            }
        }catch (e){
            alert('Desculpe, tente mais tarde.');
        }
    });
    
}

function edite_delivery_form(){
    $("#btn_edite_delivery").prop('disabled', true);
    $("#btn_edite_delivery").html('Aguarde <i class="fa fa-spinner fa-spin" ></i>');
    
    var dadoSend = new Object();
    dadoSend.id = $("#id_delivery_edit").val();
    dadoSend.nome = $("#nome_delivery_edit").val();
    dadoSend.plano_id = $("#plano_delivery_edit").val();
    dadoSend.situ = $("#situ_delivery_edit").val();
    dadoSend.text_delivery = $("#text_delivery_edit").val();
    
    var dados = JSON.stringify(dadoSend);
    
    $.post('../control/control.add_delivery.php',{editDelivery:true,dadosEdit:dados},function(data){
         try{
            
            var obj = JSON.parse(data);
            
            $("#body_msg").html(obj.msg);
            $("#modal_edite_delivery").modal('hide');
            $("#modal_msg").modal('show');
            
            if(obj.erro == false){
               setTimeout(function(){
                    location.href="";
               },3000);
            }
            
        }catch (e){
            alert('Desculpe, tente mais tarde.');
        }
       
       
        $("#btn_edite_delivery").prop('disabled', false);
        $("#btn_edite_delivery").html('Editar');
    });
    
}

function  modal_del_delivery(id){
    $("#input_id_del_delivery").val(id);
    $("#modal_del_delivery").modal('show');
}

function del_delivery(){
    
    $("#btn_del_delivery").prop('disabled', true);
    $("#btn_del_delivery").html('Aguarde <i class="fa fa-spinner fa-spin" ></i>');
    
    var id = $("#input_id_del_delivery").val();
     $.post('../control/control.add_delivery.php',{deleteDelivery:true,id:id},function(data){
           try{
            
            var obj = JSON.parse(data);
            
            $("#body_msg").html(obj.msg);
            $("#modal_del_delivery").modal('hide');
            $("#modal_msg").modal('show');
            
           if(obj.erro == false){
               setTimeout(function(){
                    location.href="";
               },3000);
            }
            
        }catch (e){
            alert('Desculpe, tente mais tarde.');
        }
       
       
        $("#btn_del_delivery").prop('disabled', false);
        $("#btn_del_delivery").html('Deletar');
    });
}
