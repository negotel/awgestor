
 function modal_del_linkzap(id){
     
     $('#input_id_del_linkzap').val(id);
     $("#modal_del_linkzap").modal('show');
     

 }
 
 function del_link(){
    $("#btn_del_linkzap").prop('disabled', true);
    var id = $('#input_id_del_linkzap').val();
    
    $.post('../control/control.linkzap.php',{type:'delete',id:id},function(data){
           var obj = JSON.parse(data);
          
          if(typeof obj.erro != 'undefined'){
              if(obj.erro){
                  alert(obj.msg);
                  $("#btn_del_linkzap").prop('disabled', false);
              }else{
                  alert("Deletado com sucesso!");
                  location.href="";
              }
          }else{
              alert('Erro javascript');
              $("#btn_del_linkzap").prop('disabled', false);
          }
     });
     
    
 }
 
 function edite_linkzap_form(){
     
     $("#btn_edite_linkzap").prop('disabled', true);
     
     var dadoObj    = new Object();
     dadoObj.numero = $("#numero_link_edite").val();
     dadoObj.nome   = $("#nome_link_edite").val();
     dadoObj.slug   = $("#slug_link_edite").val();
     dadoObj.slugh  = $("#slug_link_edite_h").val();
     dadoObj.msg    = $("#msg_link_edite").val();
     dadoObj.id     = $("#id_link_edite").val();
     
     var dados = JSON.stringify(dadoObj);
     
     $.post('../control/control.linkzap.php',{type:'edite',dados:dados},function(data){
           var obj = JSON.parse(data);
          
          if(typeof obj.erro != 'undefined'){
              if(obj.erro){
                  $("#info_slug_edite").html(obj.msg);
                  $("#btn_edite_linkzap").prop('disabled', false);
              }else{
                  $("#info_slug_edite").html("");
                  location.href="";
              }
          }else{
              $("#info_slug_edite").html('Erro javascript');
              $("#btn_edite_linkzap").prop('disabled', false);
          }
     });
     
     
 }
 
 
 function edite_linkzap(id){
     
       $.post('../control/control.linkzap.php',{type:'dados',id:id},function(data){
           var obj = JSON.parse(data);
          
                 
             $("#numero_link_edite").val(obj.numero);
             $("#nome_link_edite").val(obj.nome);
             $("#slug_link_edite").val(obj.slug);
             $("#msg_link_edite").val(obj.msg);
             $("#id_link_edite").val(obj.id);
             $("#slug_link_edite_h").val(obj.slug);
             
             $("#modal_edite_linkzap").modal('show');
                 
 
     });
     
 }
 
 function add_linkzap(){
     
     $("#btn_add_linkzap").prop('disabled', true);
     
     var dadoObj = new Object();
     dadoObj.numero = $("#numero_link").val();
     dadoObj.nome = $("#nome_link").val();
     dadoObj.slug = $("#slug_link").val();
     dadoObj.cliques = 0
     dadoObj.msg  = $("#msg_link").val();
     
     var dados = JSON.stringify(dadoObj);
     
     $.post('../control/control.linkzap.php',{type:'add',dados:dados},function(data){
           var obj = JSON.parse(data);
          
          if(typeof obj.erro != 'undefined'){
              if(obj.erro){
                  $("#info_slug").html(obj.msg);
                  $("#btn_add_linkzap").prop('disabled', false);
              }else{
                  $("#info_slug").html("");
                  location.href="";
              }
          }else{
              $("#info_slug").html('Erro javascript');
              $("#btn_add_linkzap").prop('disabled', false);
          }
     });
     
 }
 
 
 
 $("#slug_link").keyup(function(){
      var slug = $("#slug_link").val();
      $.post('../control/control.linkzap.php',{type:'verific_slug',slug:slug},function(data){
          
          var obj = JSON.parse(data);
          
          if(typeof obj.erro != 'undefined'){
              if(obj.erro){
                  $("#info_slug").html(obj.msg);
                  $("#btn_add_linkzap").prop('disabled', true);
              }else{
                  $("#info_slug").html("");
                  $("#btn_add_linkzap").prop('disabled', false);
              }
          }
      });
  });
 
 
  
 
 $("#slug_link_edite").keyup(function(){
      var slug = $("#slug_link_edite").val();
      
      if(slug != $("#slug_link_edite_h").val()){
          
          $.post('../control/control.linkzap.php',{type:'verific_slug',slug:slug},function(data){
              
              var obj = JSON.parse(data);
              
              if(typeof obj.erro != 'undefined'){
                  if(obj.erro){
                      $("#info_slug_edite").html(obj.msg);
                      $("#btn_edite_linkzap").prop('disabled', true);
                  }else{
                      $("#info_slug_edite").html("");
                      $("#btn_edite_linkzap").prop('disabled', false);
                  }
              }
          });
    
      }
      
  });
 
   function modal_add_linkzap(){
       $("#modal_add_linkzap").modal('show');
   }
 
     function copyToClipboard(id) {
         
        var tempInput = document.createElement("input");
        tempInput.style = "position: absolute; left: -1000px; top: -1000px";
        tempInput.value = $("#linkzap_"+id).val();
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand("copy");
        document.body.removeChild(tempInput);
        
        $("#icon_copy_"+id).addClass('text-success');
        $("#info_copy_"+id).show(200);
        
        
        setTimeout(function(){
            $("#icon_copy_"+id).removeClass('text-success');
            $("#info_copy_"+id).hide(200);
        },3000);

    }
    
    