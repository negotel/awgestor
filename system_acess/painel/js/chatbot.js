 window.onload = function(e){ 
       
       
    
        $('#type_response').on('change', function () {
            type_responde($('#type_response').val());
        });
        
        $('#painel').on('change', function () {
            select_pacote($('#painel').val());
        });
        
        $('#pacote_teste').on('change', function () {
            pacote_teste($('#pacote_teste').val());
        });
        
    };
    
    function deletar_reply(id){
        if(window.confirm("Deseja deletar está resposta?")){
            $.post('../control/control.chatbot.php',{remove_reply:true,id:id},function(data){
                location.href="";
            });
        }
    }
    
    function edit_reply(id){
        $("#modal_edit_reply").modal();
    }
    
    function pacote_teste(){
        
    }
    
    function add_reply(type){
        
        $("#btn_add_reply_"+type).prop('disabled', true);
        $("#btn_add_reply_"+type).html('Aguarde <i class="fa fa-spinner fa-spin" ></i>');
        
        var msg = $("#recebe").val();
        var id_chat = $("#chatbot_id").val();
        
        if(type == "teste"){
            
            var painel = $("#painel").val();

            var pacote = $("#pacote_teste").val();
            
            var sender_info = "senderTeste";
            var info = '{"painel":'+painel+',"pacote":'+pacote+'}';
            var reply = "senderTeste";
        }else
        
        if(type == "texto"){
            
            var sender_info = "false";
            var info = '';
            var reply = $("#responde").val();
        }else
        
        if(type == "dados"){
            
            var sender_info = $("#dados_response").val();
            var info = '';
            var reply = $("#dados_response").val();
        }
        
        var dadosPost = new Object();
        dadosPost.msg = msg;
        dadosPost.reply = reply;
        dadosPost.id_chat = id_chat;
        dadosPost.sender_info = sender_info;
        dadosPost.info = info;
        
        var dados = JSON.stringify(dadosPost);
        
         $.post('../control/control.chatbot.php',{add_reply:true,dados:dados},function(data){
             
             try{
                 
                 var obj = JSON.parse(data);
                 
                 if(obj.erro){
                     $("#res_add").html('<p class="alert alert-danger">'+obj.msg+'</p>');
                     setTimeout(function(){
                        $("#res_add").html('');
                     },3000);
                     
                      $("#btn_add_reply_"+type).prop('disabled', false);
                      $("#btn_add_reply_"+type).html('Adicionar');
        
        
                 }else{
                     $("#res_add").html('<p class="alert alert-success">'+obj.msg+'</p>');
                     setTimeout(function(){
                        $("#res_add").html('');
                        location.href="";
                     },1000);
                 }
                 
             }catch(e){
                $("#res_add").html('<p class="alert alert-danger">Desculpe, erro ao adicionar resposta. Entre em contato com o suporte.</p>');
                setTimeout(function(){
                    $("#res_add").html('');
                },3000);
                
                 $("#btn_add_reply_"+type).prop('disabled', false);
                 $("#btn_add_reply_"+type).html('Adicionar');
        
             }
        });
        
    }
    
    function type_responde(type){
        
        $("#btn_add_reply_texto").hide();
        $("#btn_add_reply_dados").hide();
        $("#btn_add_reply_teste").hide();
        
        $("#btn_add_reply_"+type).show();
        
        if(type == "texto"){
            $("#div_responde").show();
            $("#dados_painel_div").hide();
            $("#paineis_integrados").hide();
            $("#div_pacote_teste").hide();
            $("#painel").val("");
        }
        
        if(type == "dados"){
            $("#div_pacote_teste").hide();
            $("#div_responde").hide();
            $("#paineis_integrados").hide();
            $("#dados_painel_div").show();
            $("#painel").val("");
            
        }
        
        if(type == "teste"){
            $("#div_pacote_teste").hide();
            $("#div_responde").hide();
            $("#dados_painel_div").hide();
            $("#paineis_integrados").show();
            
        }
    }
    
    function select_pacote(){
        $("#pacote_teste").html("<option value='' >Aguarde...</option>");
        $("#div_pacote_teste").show();
        
        var painel = $("#painel").val();
        var chave  = $("#chave_"+painel).val();

        $.get('<?=SET_URL_PRODUCTION?>/painel/api.php?chave='+chave+'&getPackages&trial',function(data){
            try{ 
                
                var obj = JSON.parse(data);
                    
                var html = "";

                if(typeof obj.erro == "undefined"){
                    Object.values(obj).forEach(val => {
                       html += '<option value="'+val.id+'" >'+val.name+'</option>';
                    });
                    $("#pacote_teste").html(html);
                }else{
                    
                    $("#res_add").html('<p class="alert alert-danger">Desculpe, não localizamos nenhum pacote de teste para este painel</p>');
                    setTimeout(function(){
                        $("#res_add").html('');
                    },3000);
                    
                }
                
            }catch(e){
                $("#res_add").html('<p class="alert alert-danger">Desculpe, não localizamos nenhum pacote de teste para este painel</p>');
                setTimeout(function(){
                    $("#res_add").html('');
                },3000);
            }
            
        });
    }



    function organize_messages(chat,name){
        $(".msger-chat").html('<center><h1 style="margin-top:50px;" ><i class="fa fa-spin fa-spinner"></i></h1></center>');
        var jsonChat = $("#json_"+chat).val();
        $.post('../control/control.organizechat.php',{messages:jsonChat,name:name},function(data){
            if(data == ""){
                $(".msger-chat").html('<center><img width="300" src="<?=SET_URL_PRODUCTION?>/painel/img/robot_default.png" /></center>');
            }else{
               $(".msger-chat").html(data);
            }
             scrollchat();
        });
    }

    function consegui(){
        $('button').prop('disabled', true);
        $.post('../control/control.chatbot.php',{init:true},function(data){
            location.href="";
             $('button').prop('disabled', false);
        });
    }
   
    function scrollchat() {
        $('.msger-chat').scrollTop($('.msger-chat')[0].scrollHeight);
    }