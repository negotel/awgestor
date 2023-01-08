
    <div id="box_calc"></div>


 <div class="modal fade " data-backdrop="static" id="modal_check_whatsapp" tabindex="-1" role="dialog" aria-labelledby="Titutlo_modal_check_whatsapp" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="Titutlo_modal_fat_cli">Confirmar Whatsapp</h5>
        </div>
        <div class="modal-body" id="body_modal_add_fat" >


          <div class="row">

              <div class="col-md-12" id="response_whatsapp" ></div>

              <div class="col-md-12" >
                  <p>
                      <b><?= explode(' ',$user->nome)[0]; ?></b>, para confirmar que este é seu whatsapp, vamos enviar um código de confirmação.
                  </p>
                  <p>
                      O Whatsapp: +<?= $user->ddi; ?> <?= $user->telefone; ?> está correto? <br />
                  </p>
              </div>
              <div style="margin-bottom:10px;" class="text-center col-md-12" >
                   <a href="configuracoes#telefone_user" onclick="$('#modal_check_whatsapp').modal('toggle');" class="btn btn-sm btn-primary" >
                      Corrigir
                  </a>
                  <button id="btn_send_whatsapp" onclick="send_code('whatsapp');" class="btn btn-sm btn-primary" >
                      Enviar código
                  </button>
              </div>

              <hr>

            <div class="col-md-4"></div>
            <div class="col-md-4 text-center">
            <hr>
              <div class="form-group text-center">
                <input type="text" class="form-control" id="whatsapp_code_confirm" placeholder="Código" name="whatsapp_code_confirm" value=""  >
              </div>

              <div class="form-group">
                <button style="width:100%;" id="btn_confirm_code_whatsapp" onclick="code_confirm_send('whatsapp');" class="btn btn-sm btn-primary" disabled="true" >Confirmar</button>
              </div>

            </div>


        </div>
       </div>

   </div>
  </div>
</div>


 <div class="modal fade " data-backdrop="static" id="modal_check_email" tabindex="-1" role="dialog" aria-labelledby="Titutlo_modal_check_whatsapp" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="Titutlo_modal_fat_cli">Confirmar Email</h5>
        </div>
        <div class="modal-body" id="body_modal_add_fat" >


          <div class="row">

              <div class="col-md-12" id="response_email" ></div>

              <div class="col-md-12" >
                  <p>
                      <b><?= explode(' ',$user->nome)[0]; ?></b>, para confirmar que este é seu whatsapp, vamos enviar um código de confirmação.
                  </p>
                  <p>
                      O Email: <?= $user->email; ?> está correto? <br />
                  </p>
              </div>
              <div style="margin-bottom:10px;" class="text-center col-md-12" >
                   <a href="configuracoes#email_user" onclick="$('#modal_check_email').modal('toggle');" class="btn btn-sm btn-primary" >
                      Corrigir
                  </a>
                  <button id="btn_send_email" onclick="send_code('email');" class="btn btn-sm btn-primary" >
                      Enviar código
                  </button>
              </div>

              <hr>

            <div class="col-md-4"></div>
            <div class="col-md-4 text-center">
            <hr>
              <div class="form-group text-center">
                <input type="text" class="form-control" id="email_code_confirm" placeholder="Código" name="email_code_confirm" value=""  >
              </div>

              <div class="form-group">
                <button style="width:100%;" id="btn_confirm_code_email" onclick="code_confirm_send('email');" class="btn btn-sm btn-primary" disabled="true" >Confirmar</button>
              </div>

            </div>


        </div>
       </div>

   </div>
  </div>
</div>



    <?php

        $atendente[1] = "+553196352452";
        $atendente[2] = "+553196352452";

     ?>

    <!-- main content part end -->

    <!-- footer  -->
    <!-- jquery slim -->

    <script src="js/jquery-3.4.1.min.js?v=<?= filemtime('js/jquery-3.4.1.min.js'); ?>"></script>
    <!-- popper js -->
    <script src="js/popper.min.js?v=<?= filemtime('js/popper.min.js'); ?>"></script>
    <!-- bootstarp js -->
    <script src="js/bootstrap.min.js?v=<?= filemtime('js/bootstrap.min.js'); ?>"></script>
    <!-- sidebar menu  -->
    <script src="js/metisMenu.js?v=<?= filemtime('js/metisMenu.js'); ?>"></script>
    <!-- waypoints js -->
    <script src="vendors/count_up/jquery.waypoints.min.js?v=<?= filemtime('vendors/count_up/jquery.waypoints.min.js'); ?>"></script>
    <!-- waypoints js -->
    <script src="vendors/chartlist/Chart.min.js?v=<?= filemtime('vendors/chartlist/Chart.min.js'); ?>"></script>
    <!-- counterup js -->
    <script src="vendors/count_up/jquery.counterup.min.js?v=<?= filemtime('vendors/count_up/jquery.counterup.min.js'); ?>"></script>
    <!-- swiper slider js -->
    <script src="vendors/swiper_slider/js/swiper.min.js?v=<?= filemtime('vendors/swiper_slider/js/swiper.min.js'); ?>"></script>
    <!-- nice select -->
    <script src="vendors/niceselect/js/jquery.nice-select.min.js?v=<?= filemtime('vendors/niceselect/js/jquery.nice-select.min.js'); ?>"></script>
    <!-- owl carousel -->
    <script src="vendors/owl_carousel/js/owl.carousel.min.js?v=<?= filemtime('vendors/owl_carousel/js/owl.carousel.min.js'); ?>"></script>
    <!-- gijgo css -->
    <script src="vendors/gijgo/gijgo.min.js?v=<?= filemtime('vendors/gijgo/gijgo.min.js'); ?>"></script>
    <!-- responsive table -->
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="vendors/datatable/js/dataTables.responsive.min.js?v=<?= filemtime('vendors/datatable/js/dataTables.responsive.min.js'); ?>"></script>
    <script src="vendors/datatable/js/dataTables.buttons.min.js?v=<?= filemtime('vendors/datatable/js/dataTables.buttons.min.js'); ?>"></script>
    <script src="vendors/datatable/js/buttons.flash.min.js?v=<?= filemtime('vendors/datatable/js/buttons.flash.min.js'); ?>"></script>
    <script src="vendors/datatable/js/jszip.min.js?v=<?= filemtime('vendors/datatable/js/jszip.min.js'); ?>"></script>
    <script src="vendors/datatable/js/pdfmake.min.js?v=<?= filemtime('vendors/datatable/js/pdfmake.min.js'); ?>"></script>
    <script src="vendors/datatable/js/vfs_fonts.js?v=<?= filemtime('vendors/datatable/js/vfs_fonts.js'); ?>"></script>
    <script src="vendors/datatable/js/buttons.html5.min.js?v=<?= filemtime('vendors/datatable/js/buttons.html5.min.js'); ?>"></script>
    <script src="vendors/datatable/js/buttons.print.min.js?v=<?= filemtime('vendors/datatable/js/buttons.print.min.js'); ?>"></script>
    <script type="text/javascript" src="js/jquery.maskMoney.js?v=<?= filemtime('js/jquery.maskMoney.js'); ?>"></script>
    <script type="text/javascript" src="js/jquery.mask.js?v=<?= filemtime('js/jquery.mask.js'); ?>"></script>
    <script src="js/chart.min.js?v=<?= filemtime('js/chart.min.js'); ?>"></script>
    <!-- progressbar js -->
    <script src="vendors/progressbar/jquery.barfiller.js?v=<?= filemtime('vendors/progressbar/jquery.barfiller.js'); ?>"></script>
    <!-- tag input -->
    <script src="vendors/tagsinput/tagsinput.js?v=<?= filemtime('vendors/tagsinput/tagsinput.js'); ?>"></script>
    <!-- text editor js -->
    <script src="vendors/text_editor/summernote-bs4.js?v=<?= filemtime('vendors/text_editor/summernote-bs4.js'); ?>"></script>

    <script src="vendors/apex_chart/apexcharts.js?v=<?= filemtime('vendors/apex_chart/apexcharts.js'); ?>"></script>

    <!-- custom js -->
    <script src="js/custom.js?v=<?= filemtime('js/custom.js'); ?>"></script>

    <script type="text/javascript" src="js/function.js?v=<?=filemtime('js/function.js')?>"></script>


    <!-- active_chart js -->
    <script src="js/active_chart.js?v=<?= filemtime('js/active_chart.js'); ?>"></script>
    <script src="vendors/apex_chart/radial_active.js?v=<?= filemtime('vendors/apex_chart/radial_active.js'); ?>"></script>
    <!-- <script src="vendors/apex_chart/pie.js"></script> -->


    <script src="emojis/js/config.js?v=<?= filemtime('emojis/js/config.js'); ?>"></script>
    <script src="emojis/js/util.js?v=<?= filemtime('emojis/js/util.js'); ?>"></script>
    <script src="emojis/js/jquery.emojiarea.js?v=<?= filemtime('emojis/js/jquery.emojiarea.js'); ?>"></script>
    <script src="emojis/js/emoji-picker.js?v=<?= filemtime('emojis/js/emoji-picker.js'); ?>"></script>
    <script src="js/link_zap.js?v=<?= filemtime('js/link_zap.js'); ?>" ></script>
    <script src="js/linkzap.js?v=<?= filemtime('js/linkzap.js'); ?>"></script>
    <script src="js/chatbot.js?v=<?= filemtime('js/chatbot.js'); ?>"></script>

    <script src="vendors/apex_chart/bar_active_1.js?v=<?= filemtime('vendors/apex_chart/bar_active_1.js'); ?>"></script>
    <script>
    function modal_check(type){
        $('#modal_check_'+type).modal();
    }


    function count_block(type){
        $("#btn_send_"+type).prop("disabled", true);
        $("#btn_send_"+type).html("Enviar código ( <span id='num_cunt_"+type+"' >60</span> )");

        timeValue = setInterval(function(){

            var num  = parseInt($("#num_cunt_"+type).html());
            var newN = (num-1);
            $("#btn_send_"+type).html("Enviar código ( <span id='num_cunt_"+type+"' >"+newN+"</span> )");

            if(newN == 0 || newN < 0){
                $("#btn_send_"+type).html("Enviar código");
                $("#btn_send_"+type).prop("disabled", false)
                clearInterval(timeValue);
            }

        },1000);

    }

    function reset_block(type){
       clearInterval(timeValue);
       clearInterval(disabled_btn_code);
       $("#btn_send_"+type).html("Enviar código");
       $("#btn_send_"+type).prop("disabled", false);
       $("#btn_confirm_code_"+type).prop("disabled", true);
    }


    function send_code(type){

        count_block(type);
        $.post('../control/confirm/'+type+'.php',{confirm:true},function(data){
          try {

               var obj = JSON.parse(data);

               if(obj.erro){
                   reset_block(type);
                   $("#response_"+type).html('<center><p class="alert alert-danger" ><span style="font-size:14px;" >'+obj.msg+'</span></p></center>');
                   $("#btn_confirm_code_"+type).prop('disabled', false);

                    setTimeout(function(){
                        $("#response_"+type).html("");
                    },3000);

               }else{
                   $("#response_"+type).html('<center><p class="alert alert-success" ><span style="font-size:14px;" >'+obj.msg+'</span></p></center>');

                    setTimeout(function(){
                        $("#response_"+type).html("");
                    },3000);

               }

            } catch (e) {
                 reset_block(type);
                 $("#response_"+type).html('<center><p class="alert alert-danger" ><span style="font-size:14px;" >Desculpe, ocorreu algum erro, entre em contato com o suporte.</span></p></center>');
                 $("#btn_confirm_code_"+type).prop('disabled', false);

                setTimeout(function(){
                    $("#response_"+type).html("");
                },3000);

            }
        });

        disabled_btn_code = setInterval(function(){
        if($('#'+type+'_code_confirm').val() != ""){
            $('#btn_confirm_code_'+type).prop('disabled', false);
        }else{
            $('#btn_confirm_code_'+type).prop('disabled', true);
        }
        },500);

    }

    function code_confirm_send(type){
        clearInterval(disabled_btn_code);
        $("#btn_confirm_code_"+type).prop('disabled', true);
        var code = $('#'+type+'_code_confirm').val();
        $.post('../control/confirm/'+type+'.php',{code:code,check:true},function(data){

            try {

               var obj = JSON.parse(data);

               if(obj.erro){
                   reset_block(type);
                   $("#response_"+type).html('<center><p class="alert alert-danger" ><span style="font-size:14px;" >'+obj.msg+'</span></p></center>');
                   $("#btn_confirm_code_"+type).prop('disabled', false);

                    setTimeout(function(){
                        $("#response_"+type).html("");
                    },3000);

               }else{
                   $("#response_"+type).html('<center><p class="alert alert-success" ><span style="font-size:14px;" >'+obj.msg+'</span></p></center>');
                   setTimeout(function(){
                       location.href="";
                   },3000);
               }

            } catch (e) {
                 reset_block(type);
                 $("#response_"+type).html('<center><p class="alert alert-danger" ><span style="font-size:14px;" >Desculpe, ocorreu algum erro, entre em contato com o suporte.</span></p></center>');
                 $("#btn_confirm_code_"+type).prop('disabled', false);

                setTimeout(function(){
                    $("#response_"+type).html("");
                },3000);

            }

        });
    }


</script>


 <?php  if(date('H') >= 8 && date('H') <17 ){ ?>
     <script>
    // (function(d, s, id) {
    //     var js, fjs = d.getElementsByTagName(s)[0];
    //     if (d.getElementById(id)) return;
    //     js = d.createElement(s); js.id = id;
    //     js.src = 'https://ajuda.gestorlite.com/app-assets/chat_js';
    //     fjs.parentNode.insertBefore(js, fjs);
    // }(document, 'script', 'best-support-system-chat'));
     </script>

    <?php }
    else{ ?>
    <style>
        .ticket_btn{
            right: 20px;
            background-color: #7922ff;
            z-index: 99999;
            bottom: 10px;
            color: #fff;
            float: right;
            position: fixed;
            padding: 10px;
            border-radius: 6px;
            text-decoration: none;
            text-align: center;
        }

       .ticket_btn-open{
            right: 20px;
            background-color: #7922ff;
            width: 130px;
            height: 47px;
            z-index: 99999;
            bottom: 10px;
            color: #fff;
            float: right;
            position: fixed;
            padding: 13px;
            border-radius: 20px;
            text-decoration: none;
        }



    </style>
        <a style="text-decoration:none;color: #fff;" id="a_ticket" class="ticket_btn" target="_blank" href="https://ajuda.gestorlite.com/ticket/open.html" >
           <span class="text_ticket" style="display:none;" > <i class="fa fa-info-circle" ></i> Abrir Ticket</span>
           <span class="text_ticket2" > <i class="fa fa-info-circle" ></i></span>
        </a>
    <?php }?>


    <script src="http://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit" type="text/javascript"></script>

          <script>
        $(".sidebar-dropdown > a").click(function() {
          $(".sidebar-submenu").slideUp(200);
          if (
            $(this)
              .parent()
              .hasClass("active")
          ) {
            $(".sidebar-dropdown").removeClass("active");
            $(this)
              .parent()
              .removeClass("active");
          } else {
            $(".sidebar-dropdown").removeClass("active");
            $(this)
              .next(".sidebar-submenu")
              .slideDown(200);
            $(this)
              .parent()
              .addClass("active");
          }
        });

        $("#close-sidebar").click(function() {
          $(".page-wrapper").removeClass("toggled");
        });
        $("#show-sidebar").click(function() {
          $(".page-wrapper").addClass("toggled");
        });


    </script>


       <script>

        function googleTranslateElementInit() {
         new google.translate.TranslateElement({
         pageLanguage: 'pt',
         autoDisplay: false,
         layout: google.translate.TranslateElement.InlineLayout.SIMPLE
         },
         'google_translate_element');
        }
       </script>


    <?php

        if(explode('/',@$_GET['url'])[0] == "delivery-aut"){
            echo '<script src="js/delivery.js"></script>';
        }

         if(explode('/',@$_GET['url'])[0] == "flyer"){
            echo '<script src="js/flyer.js"></script>';
        }


    ?>

    <input type="hidden" value="<?= $_SESSION['SESSION_USER']['id']; ?>" id="ID_USER" />

    <script>

    	$(".drop-menu").on('click', function(e){
    	  	e.preventDefault();

    		var subNav = $(this)[0].children[1];
    	  if($(subNav).is(':visible')){
    			$(subNav).hide(100);
    		}else{
    			$(subNav).show(100);

    		}

    	});

    	$(".nav-sub li a").on('click', function(e){
            var subNav_li = $(this);
            e.preventDefault();
           location.href=subNav_li[0].href;
        });

    function calc_btn(){
        $('#box_calc').calculator().dialog({width: 310});
        $(".ui-dialog-titlebar-close").addClass("btn");
        $(".ui-dialog-titlebar-close").html("<i class='fa fa-close' ></i>");
    }

    $(function(){


        $( "#a_ticket" ).hover(
          function() {
            $("#a_ticket").removeClass("ticket_btn");
            $("#a_ticket").addClass("ticket_btn-open");
            $(".text_ticket2").hide();
            $(".text_ticket").show();
            $(".text_ticket").fadeIn( 500 );

          }, function() {
            $("#a_ticket").addClass("ticket_btn");
            $("#a_ticket").removeClass("ticket_btn-open");
            $(".text_ticket2").show();
            $(".text_ticket").hide();

          }
        );



         var page_atual = $("#pagename").attr("content");

        info_avisos();

        if(page_atual == "traffic" || page_atual == "linkzap" || page_atual == "flyer"){
         $("#marketing").addClass("active");
        }

        if(page_atual == "revenda"){


            var modalRev =getCookie("hideModalRevenda");
            if(modalRev == "") {
                $('#modal_rev').modal('show');
             }




        }


    var SPMaskBehavior = function (val) {
     return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
     },
     spOptions = {
       onKeyPress: function(val, e, field, options) {
           field.mask(SPMaskBehavior.apply({}, arguments), options);
         }
     };

     $('#telefone_cli_rev').mask(SPMaskBehavior, spOptions);



    if(page_atual == "revenda"){
      $('#telefone_cli_rev').mask(SPMaskBehavior, spOptions);
    }

  <?php  if(isset($_GET['click'])){ ?>
        click_pay();
        function click_pay() {
          $(".click_1").trigger('click');
        };

  <?php  } ?>



    });

    function info_avisos(){

        var page_atual = $("#pagename").attr("content");


      }
    </script>

    </body>

</html>
