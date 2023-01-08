$(function(){

    
});

 function login(token){
     var email = $("#email").val();
     var pass  = $("#password").val();
     
     if(email == "" || pass == ""){
         $("#response").html("Preencha todos os campos");
         return false;
     }
     
     $.post('../control/control.login.php',{parceiro:true,login:true,email:email,senha:pass,token:token},function(data){
         
         try{
             
             var obj = JSON.parse(data);
             
             if(obj.erro){
                 $("#response").html(obj.msg);
             }else{
                 $("#response").html(obj.msg);
                 location.href="home";
             }
             
         }catch(e){
             $("#response").html('Desculpe, tente mais tarde.');
         }
         
         
     });
     
 }