function sendMsg() {
	var msg = $("#msg_send").val();

	if(msg != ""){
		var html = '<div class="chat-msg"><div class="envia">'+msg+'</div></div>';
		$(".chat").append(html);
		var div = $(".chat");
	  div.scrollTop(div.prop('scrollHeight'));

		var chatbot_id = $("#chatbot_id").val();
		var app = $("#app").val();

		$.post('../control/teste_bot.php',{
			key:chatbot_id,
			msg:msg
		},function(data){
			var obj = JSON.parse(data);

			if(obj.success){
				var html = '<div class="chat-msg"><div class="recebe">'+obj.msg+'</div></div>';
				$(".chat").append(html);
				var div = $(".chat");
			  div.scrollTop(div.prop('scrollHeight'));
			}else{
					alert('Ocorreu algum erro ao testar, talvez você não tenha um chatbot');
			}

		});


	}else{
		alert('Digite uma mensagem');
	}

 $("#msg_send").val('');


}
