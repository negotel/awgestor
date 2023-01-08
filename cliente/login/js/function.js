
 function login(){
     
   plano = $("#idplano").val();

   $("#btn_login_cli").prop('disabled', true);
   $("#btn_login_cli").html('<i class="fa fa-spinner fa-spin"></i> &nbsp;&nbsp; Aguarde...');

   const email  = $("#email").val();
   const senha  = $("#senha").val();
   const painel = $("#painel_cliente").val();

   $.post('<?=SET_URL_PRODUCTION?>/control/control.login_cliente.php',{email:email,senha:senha,painel:painel},function(data){
     var obj = JSON.parse(data);
     
     var dados_a = JSON.stringify(obj);

     if(obj.erro){
       $("#responde_msg").addClass('text-danger');
       $("#responde_msg").html(obj.msg);
       $("#btn_login_cli").prop('disabled', false);
       $("#btn_login_cli").html('Login');
     }else{
         
       $.post('js/sessao.php',{dados:dados_a},function(data){
           
           if(plano != '0'){
               location.href="../"+painel+"?plano="+plano;
           }else{
               location.href="../"+painel;
           }
         
         $("#responde_msg").addClass('text-success');
         $("#responde_msg").html('Logado! Redirecionando...');
       });
        
       
       
     }

     setTimeout(function(){
       $("#responde_msg").removeClass('text-danger');
       $("#responde_msg").removeClass('text-success');
       $("#responde_msg").html('');
     },3000);

   });

 }


 function create(){
     
     $("#btn_create_cli").prop('disabled', true);
     $("#btn_create_cli").html('Aguarde ...');
     
     const create = new Object();
     
     create.nome = $("#nome").val();
     create.email = $("#email").val();
     create.wpp = $("#whatsapp").val();
     create.senha = $("#senha").val();
     create.painel = $("#painel_cliente").val();
     create.ind = $("#ind").val();
     
     var dados = JSON.stringify(create);
     
     $.post('js/create_post.php',{json:dados},function(data){
         
         var responseJson = JSON.parse(data);
         
         if(responseJson.erro){
             $('#responde_msg').addClass('text-danger');
             $('#responde_msg').html(responseJson.msg);
         }else{
             location.href=responseJson.link;
         }
         
         $("#btn_create_cli").prop('disabled', false);
         $("#btn_create_cli").html('Criar');
         
     });
     
     
 }


