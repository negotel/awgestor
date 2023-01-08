$(function(){


    page_atual = $("#pagename").attr("content");
    $("#"+page_atual).addClass('active');

    if(page_atual == "clientes" || page_atual == "home"){
        $("#row_1_menu").addClass('mm-active');
        $("#row_1_menu a").attr('aria-expanded', false);
        $("#row_1_menu .mm-collapse").addClass('mm-show');

    }

     if(page_atual == "linkzap" || page_atual == "notify_gestor"){
        $("#row_2_menu").addClass('mm-active');
        $("#row_2_menu a").attr('aria-expanded', false);
        $("#row_2_menu .mm-collapse").addClass('mm-show');
     }


     if( page_atual == "gateways" || page_atual == "integracoes" || page_atual == "chatbot" || page_atual == "whatsapi" ||  page_atual == "fila_zap" || page_atual == "settings_chatbot" || page_atual == "teste_bot" || page_atual == "edit_reply_bot"){
        $("#row_3_menu").addClass('mm-active');
        $("#row_3_menu a").attr('aria-expanded', false);
        $("#row_3_menu .mm-collapse").addClass('mm-show');

        if(page_atual == "settings_chatbot" || page_atual == "teste_bot" || page_atual == "edit_reply_bot"){
          $("#chatbot").addClass('active');
        }

        if(page_atual == "fila_zap"){
          $("#whatsapi").addClass('active');
        }


     }


   if(typeof $("#setGetClients").val() != "undefined"){

     var setGet = $("#setGetClients").val();
     var setGetCate = $("#setGetCate").val();

     if(setGet != "ativos" && setGet != "inativos"){
         setGet = "?ativos";
     }else{
         setGet = "?"+setGet;
     }

     if(setGetCate != "no"){
         setGet = setGet+"&categoria="+setGetCate;
     }

     table = $('#table_clientes').DataTable( {
        "order": [[ 6, "asc" ]],
        "processing": true,
        "serverSide": true,
        "responsive": true,
            "ajax": {
                "url": "../control/getclientes/post.php"+setGet,
                "type": "POST"
            },
            "columns": [
                { "data": "nome" },
                { "data": "vencimento" },
                { "data": "email" },
                { "data": "whatsapp" },
                { "data": "plano" },
                { "data": "opc" },
                { "data": "totime" }
            ]
        } );

        $('#busca_user_ipt').on('keyup change', function () {
            table.search(this.value).draw();
        });

     }
});

  function save_gate(gate){

      $("#btn_gate_"+gate).prop('disabled', true);
      $("#btn_gate_"+gate).html('Aguarde <i class="fa fa-refresh fa-spin" ></i>');


      var content = "";

      if(gate == "mercadopago"){
         content = $('#mp_client_id').val()+'@@@'+$('#mp_client_secret').val();
      }else if(gate == "paghiper"){
          content = $('#ph_apikey').val()+'@@@'+$('#ph_token').val();
      }else{
          content = tinymce.get(gate+'_dados').getContent();
      }



      var situ = 0;

      if($("#situ_gate_"+gate).is(":checked")){
          situ = 1;
      }else{
          situ = 0;
      }


      var gate    = gate;

      $.post('../control/control.save_gate.php',{gateway:gate,situ:situ,content:content},function(data){

          var respostaJ = JSON.parse(data);

          if(respostaJ.erro){
              $('#response-gate').removeClass();
              $('#response-gate').addClass('text-danger');
              $('#response-gate').html(respostaJ.msg);
          }else{
              $('#response-gate').removeClass();
              $('#response-gate').addClass('text-success');
              $('#response-gate').html(respostaJ.msg);
          }

          $("#btn_gate_"+gate).prop('disabled', false);
          $("#btn_gate_"+gate).html('Salvar');

          setTimeout(function(){
            $('#response-gate').html('');
          },5000);

      });
  }

  function load_modelo_gateway(gate){
      $.get('<?=SET_URL_PRODUCTION?>/painel/preview/modelo-gateway-'+ gate +'.txt',function(data){
          tinymce.get(gate+'_dados').setContent(data);
      });
  }

  function load_card_gateways(card){
      var active_tab = $("#active_tab").val();
      $("#card-"+active_tab).hide(100);
      $("#card-"+card).show(100);
      $("#active_tab").val(card);
  }


    function removeFilaMsg(id) {
        if(confirm('Vamos remover está mensagem da fila e ela não será enviada. Você confirma?')){
            $.post('../control/control.resend_cobranca.php',{
              removeFila:true,
              id:id
            },function(data){
              try {
                var obj = JSON.parse(data);
                if(obj.erro){
                  alert(obj.msg);
                  return false;
                }else{
                 alert(obj.msg);
                 location.href="";
                }
              } catch (e) {
                alert('Desculpe, não consegui fazer isso agora. Tente mais tarde');
              }
            });
        }else{
          return false;
        }
    }

    function setConfNotify(){

        $("#btn_config_notify").prop('disabled', true);
        $("#btn_config_notify").html('Aguarde <i class="fa fa-spinner fa-spin" ></i>');

        var jsonSend = new Object();
        jsonSend.notify = $("#notify").val();
        jsonSend.teste  = $("#teste").val();
        jsonSend.bussines = $("#bussines").val();

        if(jsonSend.bussines == "" || jsonSend.notify == "" || jsonSend.teste == ""){
            $("#msg_error").html('Você deve preencher todos os campos');
            $("#modal_error").modal('show');
        }

        var dados = JSON.stringify(jsonSend);
        $.post('../control/control.config_notify-gestor.php',{dados:dados},function(data){

            $("#btn_config_notify").prop('disabled', false);
            $("#btn_config_notify").html('Salvar');

            try{

                var obj = JSON.parse(data);

                if(typeof obj.erro == "undefined"){
                    $("#msg_error").html('Erro. Tire print desta pagina e mostre ao suporte <br /> Err: undefined object erro');
                    $("#modal_error").modal('show');
                }else{

                    if(obj.erro){
                      $("#msg_error").html(obj.msg);
                      $("#modal_error").modal('show');
                    }else{
                        $("#modal_code").modal('show');
                    }

                }

            }catch(e){
                $("#msg_error").html('Erro. Tire print desta pagina e mostre ao suporte <br /> Err: '+ e);
                $("#modal_error").modal('show');
            }
        });
    }


function updateQuerystring(whatKey, newValue) {
    var exists = false;
    var qs = [];
    var __qs = window.location.search || "";
    var _qs = __qs.substring(1).split("&");

    for (var idx in _qs) {
        var _kv = _qs[idx].split("=");
        var _key = _kv[0];
        var _value = _kv[1];

        if (_key === whatKey) {
            _value = newValue;
            exists = true;
        }

        if(_value != "undefined" && _key != "undefined"){
          qs.push(_key + "=" + _value);
        }
    }

    if (!exists) {

        qs.push(whatKey + "=" + newValue);
    }

    return "?" + qs.join("&");
}


function aprova_comp(a) {
    $("#btn_aprova_comp_" + a).prop("disabled", !0), $("#btn_aprova_comp_" + a).html('<i class="fa fa-spin fa-refresh" ></i> Aguarde'), $.post("../control/control.comp_opc.php", {
        type: "aprova",
        idfat: a
    }, function(a) {
        var e = JSON.parse(a);
        alert(e.msg), location.href = ""
    })
}

function recusa_comp(a) {
    $("#btn_recusa_comp_" + a).prop("disabled", !0), $("#btn_recusa_comp_" + a).html('<i class="fa fa-spin fa-refresh" ></i> Aguarde'), $.post("../control/control.comp_opc.php", {
        type: "recusar",
        idfat: a
    }, function(a) {
        var e = JSON.parse(a);
        alert(e.msg), location.href = ""
    })
}

function renew_cli(a, e) {
    $("#_btn_renew_" + a).addClass("fa-spin"), $("#btn_renew_" + a).prop("disabled", !0), $.post("../control/control.renew_cliente.php", {
        id: a,
        plano: e
    }, function(e) {
        var o = JSON.parse(e);
        void 0 !== o ? o.erro ? (alert(o.msg), $("#_btn_renew_" + a).removeClass("fa-spin"), $("#btn_renew_" + a).prop("disabled", !1)) : location.href = "" : (alert("Ocorreu um erro, informe ao suporte"), $("#_btn_renew_" + a).disabled("fa-spin"), $("#btn_renew_" + a).prop("disabled", !1))
    })
}

function faturas_user(a) {
    $.post("../control/control.faturas_cliente.php", {
        type: "list",
        id: a
    }, function(a) {
        $("#tbody_faturas").html(a)
    })
}

function modal_faturas_cli(a, e, o) {
    faturas_user(a), $("#id_cli_fat").val(a), $("#nome_cli_fat").val(e), $("#email_cli_fat").val(o), $("#modal_fat_cli").modal("show")
}

function check_down() {
    $("#modal_downgrade").modal("toggle");
    var a = $("#id_plano").val();
    checkout(a)
}

function downgrade_plano(a) {
    $("#id_plano").val(a);
    $("#modal_downgrade").modal("show");
    $("#btn_down_confirm").prop('disabled', true);
    $("#count_sec").html(5);

   const timeValue = setInterval((interval) => {
             var num  = parseInt($("#count_sec").html());
        if(num == 0 || num < 0){
            $("#btn_down_confirm").prop('disabled', false);
            $("#count_sec").html("");
             clearInterval(timeValue);
        }else{
            $("#count_sec").html(num-1);
        }
    }, 1000);

}

function modal_text_aviso(a) {
    $.post("../control/control.avisos_painel_cli.php", {
        id: a
    }, function(a) {
        var e = JSON.parse(a);
        e.texto ? ($("#body_modal_text_aviso").html(e.texto), $("#modal_text_aviso").modal("show")) : alert("Erro ao buscar dados deste aviso")
    })
}

function modal_del_aviso(a) {
    $("#id_del_aviso").val(a), $("#modal_del_aviso").modal("show")
}

function del_aviso() {
    $("#btn_delete_aviso").prop("disabled", !0), $("#btn_delete_aviso").html('<i class="fa fa-spinner fa-spin"></i> Aguarde');
    var a = $("#id_del_aviso").val();
    $.post("../control/control.avisos_painel_cli.php", {
        remove: "",
        id: a
    }, function(a) {
        var e = JSON.parse(a);
        e.erro ? ($("#msg_response_aviso_del").removeClass("text-success"), $("#msg_response_aviso_del").addClass("text-danger"), $("#msg_response_aviso_del").html(e.msg), $("#btn_delete_aviso").prop("disabled", !1), $("#btn_delete_aviso").html("Deletar")) : ($("#msg_response_aviso_del").removeClass("text-danger"), $("#msg_response_aviso_del").addClass("text-success"), $("#msg_response_aviso_del").html(e.msg), location.href = ""), setTimeout(function() {
            $("#msg_response_aviso_del").html("")
        }, 3e3)
    })
}

function add_aviso() {
    $("#btn_add_aviso").prop("disabled", !0), $("#btn_add_aviso").html('<i class="fa fa-spinner fa-spin"></i> Aguarde');
    var a = new Object;
    a.titulo = $("#titulo_aviso_add").val(), a.texto = $("#texto_aviso_add").val(), a.color = $("#color_aviso_add").val(), a.auto_delete = $("#auto_delete_aviso_add").val();
    var e = JSON.stringify(a);
    $.post("../control/control.avisos_painel_cli.php", {
        add: "",
        dados: e,
        id: 0
    }, function(a) {
        var e = JSON.parse(a);
        e.erro ? ($("#msg_response_aviso").removeClass("text-success"), $("#msg_response_aviso").addClass("text-danger"), $("#msg_response_aviso").html(e.msg), $("#btn_save_aviso").prop("disabled", !1), $("#btn_save_aviso").html("Salvar")) : ($("#msg_response_aviso").removeClass("text-danger"), $("#msg_response_aviso").addClass("text-success"), $("#msg_response_aviso").html(e.msg), location.href = ""), setTimeout(function() {
            $("#msg_response_aviso").html("")
        }, 3e3)
    })
}

function save_aviso() {
    $("#btn_save_aviso").prop("disabled", !0), $("#btn_save_aviso").html('<i class="fa fa-spinner fa-spin"></i> Aguarde');
    var a = new Object;
    a.id = $("#id_aviso_edite").val(), a.titulo = $("#titulo_aviso_edite").val(), a.texto = $("#texto_aviso_edite").val(), a.color = $("#color_aviso_edite").val(), a.auto_delete = $("#auto_delete_aviso_edite").val();
    var e = a.id,
        o = JSON.stringify(a);
    $.post("../control/control.avisos_painel_cli.php", {
        edite: "",
        dados: o,
        id: e
    }, function(a) {
        var e = JSON.parse(a);
        e.erro ? ($("#msg_response_aviso").removeClass("text-success"), $("#msg_response_aviso").addClass("text-danger"), $("#msg_response_aviso").html(e.msg)) : ($("#msg_response_aviso").removeClass("text-danger"), $("#msg_response_aviso").addClass("text-success"), $("#msg_response_aviso").html(e.msg)), $("#btn_save_aviso").prop("disabled", !1), $("#btn_save_aviso").html("Salvar"), setTimeout(function() {
            $("#msg_response_aviso").html("")
        }, 3e3)
    })
}

function modal_edite_aviso(a) {
    $.post("../control/control.avisos_painel_cli.php", {
        id: a
    }, function(e) {
        var o = JSON.parse(e);
        o.texto ? ($("#id_aviso_edite").val(a), $("#titulo_aviso_edite").val(o.titulo), $("#texto_aviso_edite").val(o.texto), $("#auto_delete_aviso_edite").val(o.auto_delete), $("#color_aviso_edite").val(o.color), $("#modal_edite_aviso").modal("show")) : alert("Erro ao buscar dados deste aviso")
    })
}

function busca_plano_fat() {
    var a = $("#plano_fat").val(),
        e = $("#id_cli_new_fat").val();
    $.post("../control/control.faturas_cliente.php", {
        type: "busca_plano",
        id: e,
        plano: a
    }, function(a) {
        $("#valor_fat_add").val(a)
    })
}

function delete_fat(a, e) {
    $("#btn_delete_fat" + a).prop("disabled", !0), $("#btn_delete_fat" + a).html('<i class="fa fa-spinner fa-spin"></i>'), $.post("../control/control.faturas_cliente.php", {
        type: "delete",
        id: e,
        idfat: a
    }, function(a) {
        faturas_user(e)
    })
}

function update_status_fat(a, e) {
    var o = $("#status_fat_" + a).val(),
        l = $("#valor_fat_tale_" + a).val();
    if (void 0 !== $("#lancar_finan_status").val())
        if (1 == $("#lancar_finan_status").is(":checked")) var t = 1;
        else t = 0;
    else t = 0;
    $.post("../control/control.faturas_cliente.php", {
        type: "update_status",
        id: e,
        idfat: a,
        status: o,
        finan: t,
        valor: lC
    }, function(a) {
        var o = JSON.parse(a);
        o.erro ? $("#response_msg_fat_").html('<b class="text-danger" ><i class="fa fa-close" ></i> ' + o.msg + "</b>") : ($("#response_msg_fat_").html('<b class="text-success" ><i class="fa fa-check" ></i> ' + o.msg + "</b>"), faturas_user(e)), setTimeout(function() {
            $("#response_msg_fat_").html("")
        }, 3e3)
    })
}

function status_lanca_finan() {
    var a = $("#status_lanca_finan").val();
    $.post("../control/control.status_lancamento_finan_automatico.php", {
        status: a
    }, function(a) {})
}

function mostra_move() {
    "Pago" == $("#status_fat").val() ? $("#div_move_fat").show(100) : ($("#div_move_fat").hide(100), $("#move_fatura").prop("checked", !1))
}

function create_fat() {
    var a = new Object;
    a.id_cli = $("#id_cli_new_fat").val(), a.id_plano = $("#plano_fat").val(), a.valor = $("#valor_fat_add").val(), a.data = $("#data_fat_add").val(), a.status = $("#status_fat").val(), void 0 !== $("#move_fatura").val() && 1 == $("#move_fatura").is(":checked") ? a.move = 1 : a.move = 0;
    var e = JSON.stringify(a);
    $.post("../control/control.faturas_cliente.php", {
        type: "create",
        id: a.id_cli,
        dados: e
    }, function(e) {
        var o = JSON.parse(e);
        o.erro ? $("#response_msg").html('<b class="text-danger" ><i class="fa fa-close" ></i> ' + o.msg + "</b>") : ($("#plano_fat").val(""), $("#valor_fat_add").val("0,00"), $("#status_fat").val("Pendente"), $("#response_msg").html(""), $("#modal_create_fat").modal("toggle"), $("#modal_fat_cli").modal("show"), faturas_user(a.id_cli), $("#div_move_fat").hide(100), $("#move_fatura").prop("checked", !1))
    })
}

function modal_create_fat() {
    var a = $("#id_cli_fat").val(),
        e = $("#nome_cli_fat").val(),
        o = $("#email_cli_fat").val();
    "" == o ? $("#email_cli_view").val("[sem email]") : $("#email_cli_view").val(o), $("#id_cli_new_fat").val(a), $("#nome_cli_view").val(e), $("#nome_cli_new_fat").val(e), $("#email_new_fat").val(o), $("#modal_fat_cli").modal("toggle"), $("#modal_create_fat").modal("show"), $("#div_move_fat").hide(100), $("#move_fatura").prop("checked", !1)
}

function cancel_new_fat() {
    modal_faturas_cli($("#id_cli_new_fat").val(), $("#nome_cli_new_fat").val(), $("#email_new_fat").val())
}

function save_profile() {
    $("#btn_perfil_save").prop("disabled", !0), $("#btn_perfil_save").html('Aguarde <i class="fa fa-spinner fa-spin"></i>');
    var a = new Object;
    a.dias = $("#dias_aviso_antecipado").val(), a.nome = $("#nome_user").val(), a.email = $("#email_user").val(), a.ddi = $("#ddi").val(), a.telefone = $("#telefone_user").val(), void 0 !== $("#senha_user").val() ? a.senha = $("#senha_user").val() : a.senha = Math.random(), void 0 !== $("#mp_client_id").val() ? a.mp_client_id = $("#mp_client_id").val() : a.mp_client_id = "", void 0 !== $("#mp_client_secret").val() ? a.mp_client_secret = $("#mp_client_secret").val() : a.mp_client_secret = "", void 0 !== $("#dark_user").val() && 1 == $("#dark_user").is(":checked") ? a.dark = 1 : a.dark = 0;
    var e = JSON.stringify(a);
    $.post("../control/control.edite_profile.php", {
        dados: e
    }, function(e) {
        var o = JSON.parse(e);
        1 == o.erro ? ($("#msg_retorno").removeClass("text-success"), $("#msg_retorno").addClass("text-danger")) : ($("#msg_retorno").removeClass("text-danger"), $("#msg_retorno").addClass("text-success"), 1 == a.dark ? ($("body").addClass("bg-dark"), $("#img_ferramenta_sc").attr("src", "img/ferramenta-scriptmundo_dark_on.png"), $("#logo_gestor_lite").attr("src", "img/logo-gestor-lite_dark_on.png")) : ($("body").removeClass("bg-dark"), $("#img_ferramenta_sc").attr("src", "img/ferramenta-scriptmundo.png"), $("#logo_gestor_lite").attr("src", "img/logo-gestor-lite.png"))), $("#btn_perfil_save").prop("disabled", !1), $("#btn_perfil_save").html('Salvar <i class="fa fa-floppy-o" ></i>'), $("#msg_retorno").html(o.msg), $("#senha_user").val(""), setTimeout(function() {
            $("#msg_retorno").html("")
        }, 5e3)
    })
}

function copy_tk(a) {
    var e = document.getElementById(a);
    e.select(), e.setSelectionRange(0, 99999), document.execCommand("copy"), $("#msg_copy").html('<b style="font-size:10px;" class="text-success" >Copiado!</b>'), setTimeout(function() {
        $("#msg_copy").hide(100)
    }, 3e3)
}

function checkbox_add(a) {
    $("#checkbox_" + a).is(":checked") ? ($("#tr_" + a).addClass("checked_box"), $("#com_selecionados").show(100)) : $("#ckbCheckAll").is(":checked") ? ($("#tbody_clientes").removeClass("checked_box"), $("#tr_" + a).removeClass("checked_box")) : ($("#tr_" + a).removeClass("checked_box"), $("#tr_" + a).removeClass("checkbox_invert"))
}

function modal_import_clientes() {
    $("#modal_import_clientes").modal("show")
}

function gera_area_cli(a) {
    $("#btn_gera_a").prop("disabled", !0), $("#btn_gera_a").html('<i class="fa fa-refresh fa-spin" ></i> Gerar Área do cliente'), $.post("../control/control.mini_area_cliente.php", {
        type: "create",
        idu: a
    }, function(a) {
        var e = JSON.parse(a);
        e.erro ? (alert(e.msg), location.href = "") : location.href = ""
    })
}

function checkFilled(id){
    var cor = $("#color_cate_"+id).val();
    $("#card_cate_"+id).css("background-color", cor);
    $(".etiqueta_cate_"+id).css("color", cor);
    $(".etiqueta_cate1_"+id).css("background-color", cor);
}


     function rename_categoria(id){
         $("#title_categoria_"+id).hide();
         $("#input_categoria_"+id).show();
         $("#input_categoria_"+id).focus();

     }

     function list_categorias_cards(){
           $.post('../control/control.categorias_cliente.php',{type:"list"},function(dataRes){
             try{
                 var responseObj = JSON.parse(dataRes);

                 if(typeof responseObj.erro == "undefined"){
                     $("#div_list_categorias").html(dataRes);
                 }else{
                     $("#div_list_categorias").html('<div class="col-md-12 text-center" ><h5>Nenhuma categoria no momento</h5></div>');
                 }
             }catch(e){
                 $("#div_list_categorias").html(dataRes);
             }

         });
     }

     function remove_categoria(categoria){

         $.post('../control/control.categorias_cliente.php',{type:"remove",categoria:categoria},function(data){

           var obj = JSON.parse(data);

           if(obj.erro){
                 $("#msg_return_categoria").show();
                 $("#msg_return_categoria").html(obj.msg);
                 setTimeout(function(){
                     $("#msg_return_categoria").html("");
                     $("#msg_return_categoria").hide();
                 },5000);
             }else{
                list_categorias_cards();
             }

         });

     }

     function add_categoria(){

         $("#btn_add_categoria").prop('disabled', true);
         $("#btn_add_categoria").html('Aguarde <i class="fa fa-spinner fa-spin" ></i> ');

         $.post('../control/control.categorias_cliente.php',{type:"add"},function(data){
             var obj = JSON.parse(data);

             if(obj.erro){
                 $("#msg_return_categoria").show();
                 $("#msg_return_categoria").html(obj.msg);
                 setTimeout(function(){
                     $("#msg_return_categoria").html("");
                     $("#msg_return_categoria").hide();
                 },5000);
             }else{
                list_categorias_cards();
             }

             $("#btn_add_categoria").prop('disabled', false);
             $("#btn_add_categoria").html('<i class="fa fa-plus"></i> Nova categoria');

         });
     }

     function agenda_envio(){

         $("#btn_send_zap").prop('disabled', true);
         $("#btn_send_zap").html('Aguarde <i class="fa fa-refresh fa-spin" ></i>');

         var id_cli = $("#id_cli_send").val();
         var text_to = $(".emoji-wysiwyg-editor").text();

         $.post('../control/control.resend_cobranca.php',{id_cli:id_cli,text_to:text_to},function(data){

             var ResJson = JSON.parse(data);

             if(ResJson.erro){

                 $("#form_send_zap").hide();
                 $("#btn_send_zap").hide();
                 $("#msg_send_zap_aguarde").show('100');

                 $("#msg_send_zap_aguarde").html('<h5 class="text-danger">'+ ResJson.msg +'</h5><br /><p>Confira sua fila de envio <a href="fila_zap">aqui</a></p>');

                 setTimeout(function(){
                     $("#modal_send_zap").modal('toggle');
                 },3000);

             }else{
                 $("#form_send_zap").hide();
                 $("#btn_send_zap").hide();
                 $("#msg_send_zap_aguarde").show('100');


                 $("#msg_send_zap_aguarde").html('<h5 class="text-success">'+ ResJson.msg +'</h5><br /><p>Confira sua fila de envio <a href="fila_zap">aqui</a></p>');
                  setTimeout(function(){
                     $("#modal_send_zap").modal('toggle');
                 },4000);
             }

             $("#btn_send_zap").prop('disabled', false);
             $("#btn_send_zap").html('Agendar envio');

         });
     }

     $('#modal_send_zap').on('hide.bs.modal', function (event) {

          $("#form_send_zap").hide();
          $("#btn_send_zap").hide();
          $("#msg_send_zap_aguarde").show('100');

       $("#msg_send_zap_aguarde").html('<h4>Aguarde <i class="fa fa-refresh fa-spin"></i></h4>');
    })



     function modal_send_zap(id_cli,nome_cli,tel_cli,plano){

         $("#modal_send_zap").modal();
         $("#nome_cli_send").html(nome_cli);

         $.post('../control/control.dados_plano.php',{id_plano:plano},function(data){

             var returnJsonP = JSON.parse(data);

             if(returnJsonP.erro){

                 $("#msg_send_zap_aguarde").html('<h5 class="text-danger">'+ returnJsonP.msg +'</h5>');

             }else{

                emojiPicker = new EmojiPicker({

                  emojiable_selector: '[data-emojiable=true]',
                  assetsPath: 'emojis/img/',
                  popupButtonClasses: 'fa fa-smile-o'
                });

                emojiPicker.discover();


                 $("#msg_send_zap_aguarde").hide();
                 $("#form_send_zap").show('100');
                 $("#btn_send_zap").show('100');

                 $(".emoji-wysiwyg-editor").text(returnJsonP.template_zap);
                 $("#id_cli_send").val(id_cli);
                 $("#nome_cli_send1").val(nome_cli);
                 $("#zap_cli").val(tel_cli);
             }

         });


     }

     function save_color_categoria(id){
         var cor = $("#color_cate_"+id).val();
         $.post('../control/control.categorias_cliente.php',{type:"save_color",cor:cor,id:id},function(data){

             try{

               var responseObj = JSON.parse(data);

               if(typeof responseObj.erro == "undefined"){
                     $("#msg_return_categoria").show();
                     $("#msg_return_categoria").html('Desculpe, volte mais tarde');
                     setTimeout(function(){
                         $("#msg_return_categoria").html("");
                         $("#msg_return_categoria").hide();
                     },5000);
                 }else{

                     if(responseObj.erro){
                         $("#msg_return_categoria").show();
                         $("#msg_return_categoria").html(responseObj.msg);
                         setTimeout(function(){
                             $("#msg_return_categoria").html("");
                             $("#msg_return_categoria").hide();
                         },5000);
                     }else{

                     }

                 }
             }catch(e){
                 $("#msg_return_categoria").show();
                 $("#msg_return_categoria").html('Desculpe, volte mais tarde');
                 setTimeout(function(){
                     $("#msg_return_categoria").html("");
                     $("#msg_return_categoria").hide();
                 },5000);
             }

        });
     }

    function save_name_categoria(id){
        var name = $("#input_categoria_"+id).val();
        $.post('../control/control.categorias_cliente.php',{type:"save",nome:name,id:id},function(data){

             try{

               var responseObj = JSON.parse(data);

               if(typeof responseObj.erro == "undefined"){
                     $("#msg_return_categoria").show();
                     $("#msg_return_categoria").html('Desculpe, volte mais tarde');
                     setTimeout(function(){
                         $("#msg_return_categoria").html("");
                         $("#msg_return_categoria").hide();
                     },5000);
                 }else{

                     if(responseObj.erro){
                         $("#msg_return_categoria").show();
                         $("#msg_return_categoria").html(responseObj.msg);
                         setTimeout(function(){
                             $("#msg_return_categoria").html("");
                             $("#msg_return_categoria").hide();
                         },5000);
                     }else{
                         $("#title_categoria_"+id).html(name+' <i class="fa fa-edit" ></i>');
                         $("#title_categoria_"+id).show();
                         $("#input_categoria_"+id).hide();
                         $(".etiqueta_cate_name_"+id).html(name);

                     }

                 }
             }catch(e){
                 $("#msg_return_categoria").show();
                 $("#msg_return_categoria").html('Desculpe, volte mais tarde');
                 setTimeout(function(){
                     $("#msg_return_categoria").html("");
                     $("#msg_return_categoria").hide();
                 },5000);
             }

        });
    }


function edite_cliente(a) {
    $.post("../control/control.dados_cliente.php", {
        id: a
    }, function(e) {
        var o = JSON.parse(e);
        o.erro ? ($("#modal_edite_cliente").modal("toggle"), alert(o.msg)) : ($("#id_cli").val(a), $("#nome_cli").val(o.nome), $("#email_cli").val(o.email), $("#email_cli_atual").val(o.email), $("#telefone_cli").val(o.telefone), $("#identificador_externo_cli").val(o.identificador_externo), $("#categoria_cli_atual").val(o.categoria), $("#vencimento_cli").val(o.vencimento), $("#notas_cli").val(o.notas), $("#recebe_zap_cli").val(o.recebe_zap), $("#senha_cli").val(o.senha), $("#plano_cli").val(o.id_plano), "vazio" == o.telefone ? $("#telefone_cli").addClass("is-invalid") : $("#telefone_cli").removeClass("is-invalid"), "vazio" == o.email ? $("#email_cli").addClass("is-invalid") : $("#email_cli").removeClass("is-invalid"))
    }), $("#modal_edite_cliente").modal("show")
}

function save_cli() {
    $("#btn_save_cli").prop("disabled", !0), $("#btn_save_cli").html('<i class="fa fa-spinner fa-spin"></i> Aguarde');
    var a = new Object;
    a.nome = $("#nome_cli").val(), a.identificador_externo = $("#identificador_externo_cli").val(), a.categoria = $("#categoria_cli_atual").val(), a.email = $("#email_cli").val(), a.email_at = $("#email_cli_atual").val(), a.telefone = $("#telefone_cli").val(), a.vencimento = $("#vencimento_cli").val(), a.notas = $("#notas_cli").val(), a.plano = $("#plano_cli").val(), a.recebe_zap = $("#recebe_zap_cli").val(), a.id = $("#id_cli").val(), void 0 !== $("#senha_cli").val() ? a.senha = $("#senha_cli").val() : a.senha = Math.random();
    var e = JSON.stringify(a);
    $.post("../control/control.post_data_clientes.php", {
        dados: e
    }, function(a) {
        var e = JSON.parse(a);
        e.erro ? ($("#btn_save_cli").prop("disabled", !1), $("#btn_save_cli").html("Salvar"), $("#modal_edite_cliente").modal("toggle"), alert(e.msg)) : location.href = ""
    })
}

function modal_add_cli() {
    $("#modal_add_cli").modal("show")
}

function add_cli() {
    $("#btn_add_cli").prop("disabled", !0), $("#btn_add_cli").html('<i class="fa fa-spinner fa-spin"></i> Aguarde');
    var a = new Object;
    a.nome = $("#nome_cli_add").val(), a.identificador_externo = $("#identificador_externo_cli_add").val(), a.categoria = $("#categoria_cli_add").val(), a.email = $("#email_cli_add").val(), a.telefone = $("#telefone_cli_add").val(), a.vencimento = $("#vencimento_cli_add").val(), a.notas = $("#notas_cli_add").val(), a.recebe_zap = $("#recebe_zap_add").val(), $("#senha_add").val() ? a.senha = $("#senha_add").val() : a.senha = Math.random().toString(36).substring(0, 7), a.id_plano = $("#plano_cli_add").val();
    var e = JSON.stringify(a);
    $.post("../control/control.add_clientes.php", {
        dados: e
    }, function(a) {
        var e = JSON.parse(a);
        e.erro ? ($("#btn_add_cli").prop("disabled", !1), $("#btn_add_cli").html("Salvar"), $("#modal_add_cli").modal("toggle"), alert(e.msg)) : location.href = ""
    })
}

function modal_del_cli(a) {
    $("#id_del_add").val(a), $("#modal_del_cli").modal("show")
}

function del_cli() {
    $("#btn_del_cli").prop("disabled", !0), $("#btn_del_cli").html('<i class="fa fa-spinner fa-spin"></i> Aguarde');
    var a = $("#id_del_add").val();
    $.post("../control/control.delete_cliente_unit.php", {
        id: a
    }, function(a) {
        location.href = ""
    })
}

function modal_edite_plano(a) {
    $.post("../control/control.dados_plano.php", {
        id_plano: a
    }, function(a) {
        var e = JSON.parse(a);
        $("#id_plano_edit").val(e.id), $("#nome_plano_edit").val(e.nome), $("#valor_plano_edit").val(e.valor), $("#dias_plano_edit").val(e.dias), $("#template_zap").val(e.template_zap)
    }), $("#modal_edite_plano").modal("show")
}

function preview_zap_planos() {
    var a = $("#template_zap").val(),
        e = $("#valor_plano_edit").val(),
        o = $("#nome_plano_edit").val(),
        l = encodeURI("preview/preview_whatsapp_1/?msg=" + a + "&valor=" + e + "&plano_nome=" + o);
    return window.open(l, "Janela", "toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,width=350,height=450,left=500,top=150"), !1
}

function preview_zap_planos2() {
    var a = $("#template_zap_add").val(),
        e = $("#valor_plano_add").val(),
        o = $("#nome_plano_add").val(),
        l = encodeURI("preview/preview_whatsapp_1/?msg=" + a + "&valor=" + e + "&plano_nome=" + o);
    return window.open(l, "Janela", "toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,width=350,height=450,left=500,top=150"), !1
}

function save_plano_edit() {
    $("#btn_save_plano").prop("disabled", !0), $("#btn_save_plano").html('<i class="fa fa-spinner fa-spin"></i> Aguarde');
    var a = new Object;
    a.nome = $("#nome_plano_edit").val(), a.valor = $("#valor_plano_edit").val(), a.dias = $("#dias_plano_edit").val(), a.template_zap = $("#template_zap").val(), a.id_plano = $("#id_plano_edit").val();
    var e = JSON.stringify(a);
    $.post("../control/control.edite_plano.php", {
        dados: e
    }, function(a) {
        var e = JSON.parse(a);
        e.erro ? ($("#btn_save_plano").prop("disabled", !1), $("#btn_save_plano").html("Salvar"), $("#modal_edite_plano").modal("toggle"), alert(e.msg)) : location.href = ""
    })
}

function modal_add_plano() {
    $("#modal_add_plano").modal("show")
}

function add_plano_edit() {
    $("#btn_add_plano").prop("disabled", !0), $("#btn_add_plano").html('<i class="fa fa-spinner fa-spin"></i> Aguarde');
    var a = new Object;
    a.nome = $("#nome_plano_add").val(), a.valor = $("#valor_plano_add").val(), a.dias = $("#dias_plano_add").val(), a.template_zap = $("#template_zap_add").val();
    var e = JSON.stringify(a);
    $.post("../control/control.add_plano.php", {
        dados: e
    }, function(a) {
        var e = JSON.parse(a);
        e.erro ? ($("#btn_add_plano").prop("disabled", !1), $("#btn_add_plano").html("Adicionar"), $("#modal_add_plano").modal("toggle"), alert(e.msg)) : location.href = ""
    })
}

function modal_del_plano(a) {
    $("#id_del_plano").val(a), $("#modal_del_plano").modal("show")
}

function del_plano() {
    $("#btn_del_plano").prop("disabled", !0), $("#btn_del_plano").html('<i class="fa fa-spinner fa-spin"></i> Aguarde');
    var a = $("#id_del_plano").val();
    $.post("../control/control.delete_plano.php", {
        id: a
    }, function(a) {
        location.href = ""
    })
}

function add_mov() {
    $("#btn_add_mov").prop("disabled", !0), $("#btn_add_mov").html('<i class="fa fa-spinner fa-spin"></i> Aguarde');
    var a = new Object;
    a.valor = $("#valor_mov_add").val(), a.hora = $("#hora_mov_add").val(), a.data = $("#data_mov_add").val(), a.tipo = $("#tipo_mov_add").val(), a.nota = $("#nota_mov_add").val();
    var e = JSON.stringify(a);
    $.post("../control/control.movimentacao_financeiro.php", {
        dados: e
    }, function(a) {
        var e = JSON.parse(a);
        e.erro ? ($("#btn_add_mov").prop("disabled", !1), $("#btn_add_mov").html("Adicionar"), $("#modal_add_mov").modal("toggle"), alert(e.msg)) : location.href = ""
    })
}

function modal_add_mov() {
    $("#modal_add_mov").modal("show")
}

function ver_nota_completa(a) {
    $.post("../control/control.financeiro.php", {
        nota: "true",
        id_mov: a
    }, function(a) {
        $("#body_modal_view_mov").html('<p style="margin:10px;white-space:pre;" >' + a + "</p>"), $("#modal_view_mov").modal("show")
    })
}

function modal_del_mov(a) {
    $("#input_id_del_mov").val(a), $("#modal_del_mov").modal("show")
}

function del_mov() {
    $("#btn_del_mov").prop("disabled", !0), $("#btn_del_mov").html('<i class="fa fa-refresh fa-spin" ></i> Aguarde');
    var a = $("#input_id_del_mov").val();
    $.post("../control/control.financeiro.php", {
        del: "true",
        id_mov: a
    }, function(a) {
        location.href = ""
    })
}

function edite_movimentacao(a) {
    $.post("../control/control.financeiro.php", {
        dados_edite: "true",
        id_mov: a
    }, function(a) {
        var e = JSON.parse(a);
        $("#valor_mov").val(e.valor), $("#hora_mov").val(e.hora), $("#data_mov").val(e.data), $("#tipo_mov").val(e.tipo), $("#nota_mov").val(e.nota), $("#id_mov").val(e.id), $("#modal_edite_mov").modal("show")
    })
}

function save_mov() {
    $("#btn_save_mov").prop("disabled", !0), $("#btn_save_mov").html('<i class="fa fa-spinner fa-spin"></i> Aguarde');
    var a = new Object;
    a.valor = $("#valor_mov").val(), a.hora = $("#hora_mov").val(), a.data = $("#data_mov").val(), a.tipo = $("#tipo_mov").val(), a.nota = $("#nota_mov").val(), a.id = $("#id_mov").val();
    var e = JSON.stringify(a);
    $.post("../control/control.financeiro.php", {
        save: "true",
        dados: e
    }, function(a) {
        console.log(a);
        var e = JSON.parse(a);
        e.erro ? ($("#btn_save_mov").prop("disabled", !1), $("#btn_save_mov").html("Adicionar"), $("#modal_edite_mov").modal("toggle"), alert(e.msg)) : location.href = ""
    })
}
moeda = $("#moeda").val(), $(function() {
    var a = function(a) {
            return 11 === a.replace(/\D/g, "").length ? "(00) 00000-0000" : "(00) 0000-00009"
        },
        e = {
            onKeyPress: function(e, o, l, t) {
                l.mask(a.apply({}, arguments), t)
            }
        },
        o = $("#pagename").attr("content");
    if ($("#page-title").html("Painel - " + o.toUpperCase()), $("#" + o).addClass("active"), $("#" + o + "_2").addClass("active"), "graphics" == o && ($("#financeiro").addClass("active"), $("#financeiro_2").addClass("active")), "cart" == o && ($("#pagamentos").addClass("active"), $("#pagamentos_2").addClass("active")), "configuracoes" == o) {
        var l = $("#ddi").val(),
            t = $("#ddi_" + l).attr("src");
        $("#ddi_atual").attr("src", t), $("#telefone_user").mask(a, e)
    }
    setTimeout(function() {
        $("#msg_hide").hide("200")
    }, 5e3), $("#valor_plano_edit").maskMoney({
        prefix: moeda + " ",
        thousands: ".",
        decimal: ",",
        affixesStay: !0
    }), $("#valor_mov").maskMoney({
        prefix: moeda + " ",
        thousands: ".",
        decimal: ",",
        affixesStay: !0
    }), $("#valor_mov_add").maskMoney({
        prefix: moeda + " ",
        thousands: ".",
        decimal: ",",
        affixesStay: !0
    }), $("#valor_plano_add").maskMoney({
        prefix: moeda + " ",
        thousands: ".",
        decimal: ",",
        affixesStay: !0
    }), $("#valor_fat_add").maskMoney({
        prefix: moeda + " ",
        thousands: ".",
        decimal: ",",
        affixesStay: !0
    })
}), $("#busca_user").keyup(function() {
    var a = $("#busca_user").val();
    $.post("../control/control.busca_user.php", {
        busca: a
    }, function(a) {
        $("#tbody_clientes").html(a)
    })
}), $("#email_cli_add").keyup(function() {
    var a = $("#email_cli_add").val();
    $.post("../control/control.verific_email.php", {
        email: a
    }, function(a) {
        var e = JSON.parse(a);
        e.erro ? ($("#response_email_add").removeClass("text-success"), $("#response_email_add").addClass("text-danger"), $("#response_email_add").html('<i class="fa fa-close" ></i> ' + e.msg)) : ($("#response_email_add").removeClass("text-danger"), $("#response_email_add").addClass("text-success"), $("#response_email_add").html('<i class="fa fa-check" ></i> ' + e.msg)), setTimeout(function() {
            $("#response_email_add").html("")
        }, 1e4)
    })
}), $("#email_cli").keyup(function() {
    var a = $("#email_cli").val();
    $("#email_cli_atual").val() != a ? $.post("../control/control.verific_email.php", {
        email: a
    }, function(a) {
        var e = JSON.parse(a);
        e.erro ? ($("#response_email_cli").removeClass("text-success"), $("#response_email_cli").addClass("text-danger"), $("#response_email_cli").html('<i class="fa fa-close" ></i> ' + e.msg)) : ($("#response_email_cli").removeClass("text-danger"), $("#response_email_cli").addClass("text-success"), $("#response_email_cli").html('<i class="fa fa-check" ></i> ' + e.msg)), setTimeout(function() {
            $("#response_email_cli").html("")
        }, 1e4)
    }) : $("#response_email_cli").html("")
}), $("#slug_area").keyup(function() {
    var a = $("#slug_area").val(),
        e = $("#slug_atual").val();
    $.post("../control/control.verific_slug_area_cli.php", {
        slug: a
    }, function(o) {
        var l = JSON.parse(o);
        a != e ? l.erro ? ($("#response_slug").removeClass("text-success"), $("#response_slug").addClass("text-danger"), $("#response_slug").html("O caminho '<b>" + a + "</b>' não está disponível")) : "" == a ? ($("#response_slug").removeClass("text-success"), $("#response_slug").addClass("text-danger"), $("#response_slug").html("Não é possível deixar em branco")) : ($("#response_slug").removeClass("text-danger"), $("#response_slug").addClass("text-success"), $("#response_slug").html("O caminho '<b>" + a + "</b>' está disponível")) : $("#response_slug").html("")
    })
}), $(document).ready(function() {
    $("#ckbCheckAll").click(function() {
        $(".checkbox").prop("checked", $(this).prop("checked")), $("#ckbCheckAll").is(":checked") ? ($("#tbody_clientes").addClass("checked_box"), $("#com_selecionados").show(100)) : ($("#com_selecionados").hide(100), $("#tbody_clientes").removeClass("checked_box"), $(".trs").removeClass("checked_box"), $(".trs").removeClass("checkbox_invert"))
    })
});
