<?php


 if($plano_usergestor->financeiro_avan == 0){
      header('Location: cart?upgrade');
     exit;
   }

   if($plano_usergestor->mini_area_cliente == 0){
      header('Location: cart?upgrade');
     exit;
   }


 $gateways_class = new Gateways();

 $picpay_gate = $gateways_class->dados_picpay_user($_SESSION['SESSION_USER']['id']);
 $bank_gate = $gateways_class->dados_bank_user($_SESSION['SESSION_USER']['id']);
 $mp_gate = $gateways_class->dados_mp_user($_SESSION['SESSION_USER']['id']);
 $ph_gate = $gateways_class->dados_ph_user($_SESSION['SESSION_USER']['id']);

?>


<?php include_once 'inc/head-nav.php'; ?>
<?php include_once 'inc/sidebar.php'; ?>

 <script src="https://cdn.tiny.cloud/1/a8et6dziwmrkdy9wmaowzufw8054zc0wnys52y4kfwuc8de1/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

<section class="main_content dashboard_part">
<?php include_once 'inc/nav.php'; ?>
   <div class="main_content_iner ">
       <div class="container-fluid plr_30 body_white_bg pt_30">
           <div style="margin-bottom:20px;" class="row justify-content-center">
               <div class="col-12">
                   <div class="QA_section">
                       <div style="margin-bottom:10px;" class="white_box_tittle list_header">
                           <h3>Receba Pagamentos
                             <img src="img/receive-money.png" width="35" alt="">
                           </h3>
                       </div>
                   </div>
               </div>
           </div>
         </div>

         <div class="container-fluid plr_30 body_white_bg pt_30">
           <div class="row justify-content-center">
               <div class="col-12">
                   <div class="QA_section">
                           <div class="row">


                             <div class="col-md-12">
                                 <div class="col-md-3"></div>
                                 <div class="col-md-12">
                                     <div class="btn-group">
                                         <button class="btn btn-outline-primary btn-lg" onclick="load_card_gateways('mercadopago');" >Mercado Pago


                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 48 48" width="35px" height="35px">
                                            <g id="surface14514034">
                                            <path style="stroke:none;fill-rule:nonzero;fill: rgb(255 255 255 / 34%);fill-opacity:1;" d="M 45 23.5 C 45 32.058594 35.375 39 23.5 39 C 11.625 39 2 32.058594 2 23.5 C 2 14.941406 11.625 8 23.5 8 C 35.375 8 45 14.941406 45 23.5 Z M 45 23.5 "/>
                                            <path style=" stroke:none;fill-rule:nonzero;fill:rgb(98.039216%,98.039216%,98.039216%);fill-opacity:1;" d="M 22.472656 24.945312 C 20.492188 19.410156 17.585938 14.066406 16.386719 11.949219 C 16.035156 11.332031 15.597656 10.765625 15.097656 10.261719 L 12.542969 7.707031 C 12.152344 7.316406 11.128906 7.707031 11.128906 7.707031 L 9.496094 8.734375 L 9.335938 11.054688 L 8.773438 11 C 8.253906 11 7.835938 11.421875 7.835938 11.9375 C 7.835938 12.457031 8.246094 12.90625 8.769531 12.898438 C 10.675781 12.867188 12.335938 14.5 12.335938 14.5 L 14.335938 14.5 C 14.65625 14.820312 15.472656 15.867188 15.664062 16.9375 C 15.769531 17.550781 15.816406 18.167969 15.78125 18.785156 C 15.457031 24.621094 16.835938 26 16.835938 26 C 11.335938 22.5 2.015625 23.035156 2.015625 23.035156 L 2.210938 26.050781 L 5 31 C 5.917969 31.210938 5.742188 30.375 6.765625 30.496094 C 12.964844 31.238281 20.335938 30.5 20.335938 30.5 C 21.835938 30.5 22.292969 29.707031 23 29 C 24 28 22.847656 26.003906 22.472656 24.945312 Z M 22.472656 24.945312 "/>
                                            <path style=" stroke:none;fill-rule:nonzero;fill:rgb(98.039216%,98.039216%,98.039216%);fill-opacity:1;" d="M 24.914062 24.945312 C 26.890625 19.410156 29.796875 14.066406 30.996094 11.949219 C 31.351562 11.332031 31.785156 10.765625 32.289062 10.261719 L 34.839844 7.707031 C 35.230469 7.316406 36.253906 7.707031 36.253906 7.707031 L 37.8125 9 L 38.050781 11.054688 L 38.609375 11 C 39.128906 11 39.550781 11.421875 39.550781 11.9375 C 39.550781 12.457031 39.136719 12.90625 38.617188 12.898438 C 36.707031 12.867188 35.050781 14.5 35.050781 14.5 L 33.050781 14.5 C 32.730469 14.820312 31.910156 15.867188 31.722656 16.9375 C 31.613281 17.550781 31.566406 18.167969 31.601562 18.785156 C 31.925781 24.621094 30.550781 26 30.550781 26 C 36.050781 22.5 45.550781 23 45.550781 23 L 45.382812 26 L 42.382812 31 C 41.464844 31.210938 41.640625 30.375 40.617188 30.496094 C 34.421875 31.238281 27.050781 30.5 27.050781 30.5 C 25.550781 30.5 25.089844 29.707031 24.382812 29 C 23.382812 28 24.535156 26.003906 24.914062 24.945312 Z M 24.914062 24.945312 "/>
                                            <path style=" stroke:none;fill-rule:nonzero;fill:rgb(47.450981%,13.333334%,100%);fill-opacity:1;" d="M 43.832031 16.324219 C 43.519531 15.910156 43.1875 15.519531 42.839844 15.140625 C 42.78125 15.074219 42.71875 15.015625 42.65625 14.953125 C 42.347656 14.628906 42.027344 14.3125 41.695312 14.015625 C 41.671875 13.992188 41.644531 13.96875 41.617188 13.945312 C 41.03125 13.425781 40.417969 12.933594 39.773438 12.492188 C 39.84375 12.316406 39.882812 12.128906 39.882812 11.9375 C 39.882812 11.144531 39.238281 10.5 38.402344 10.5 C 38.402344 10.5 38.398438 10.5 38.398438 10.5 L 38.382812 10.503906 L 38.382812 9.320312 C 38.382812 8.785156 38.09375 8.289062 37.632812 8.019531 L 36.269531 7.238281 C 36.046875 7.15625 34.914062 6.761719 34.324219 7.351562 L 32.484375 9.191406 C 32.105469 9.085938 31.597656 8.941406 31.273438 8.863281 C 28.894531 8.289062 26.445312 8.015625 24 8 C 20.96875 7.996094 17.90625 8.390625 14.980469 9.273438 L 13.0625 7.355469 C 12.472656 6.765625 11.335938 7.15625 11.042969 7.273438 L 9.75 8.019531 C 9.289062 8.289062 9 8.785156 9 9.320312 L 9 10.507812 L 8.9375 10.5 C 8.144531 10.5 7.5 11.144531 7.5 11.9375 C 7.5 12.25 7.601562 12.550781 7.78125 12.804688 C 6.804688 13.519531 5.878906 14.316406 5.0625 15.226562 C 4.746094 15.574219 4.445312 15.941406 4.160156 16.320312 C 2.636719 18.347656 2.0625 20.871094 2 23.5 C 1.964844 26.128906 2.453125 28.722656 3.933594 30.84375 C 5.410156 32.976562 7.382812 34.695312 9.554688 36.007812 C 13.933594 38.613281 18.992188 39.753906 24 39.851562 C 26.511719 39.824219 29.023438 39.53125 31.472656 38.929688 C 33.914062 38.304688 36.28125 37.347656 38.457031 36.027344 C 40.621094 34.699219 42.601562 32.988281 44.074219 30.847656 C 45.550781 28.726562 46.007812 26.128906 45.96875 23.5 C 45.90625 20.871094 45.355469 18.347656 43.832031 16.324219 Z M 40.792969 15.140625 C 41.023438 15.363281 41.242188 15.597656 41.453125 15.835938 C 41.550781 15.941406 41.648438 16.046875 41.742188 16.15625 C 42.035156 16.503906 42.316406 16.859375 42.570312 17.230469 C 43.660156 18.8125 44.355469 20.621094 44.527344 22.472656 C 42.253906 22.441406 36.085938 22.589844 31.484375 24.816406 C 31.820312 23.683594 32.105469 21.800781 31.933594 18.757812 C 31.90625 18.207031 31.941406 17.621094 32.046875 17.023438 C 32.1875 16.234375 32.75 15.40625 33.101562 15 L 33.828125 15 C 34.558594 15 35.261719 14.773438 35.855469 14.351562 C 36.476562 13.90625 37.414062 13.371094 38.441406 13.398438 C 38.515625 13.398438 38.582031 13.367188 38.652344 13.359375 C 38.917969 13.550781 39.1875 13.742188 39.445312 13.945312 C 39.519531 14.007812 39.59375 14.070312 39.667969 14.132812 C 39.941406 14.355469 40.207031 14.589844 40.464844 14.828125 C 40.574219 14.929688 40.6875 15.035156 40.792969 15.140625 Z M 24 9 C 26.367188 9.027344 28.734375 9.304688 31.027344 9.871094 C 31.234375 9.921875 31.4375 9.988281 31.644531 10.050781 C 31.160156 10.554688 30.738281 11.105469 30.398438 11.703125 C 29.222656 13.769531 26.273438 19.1875 24.277344 24.777344 C 24.203125 24.984375 24.113281 25.207031 24.023438 25.4375 C 23.910156 25.71875 23.796875 26.011719 23.691406 26.304688 C 23.585938 26.011719 23.472656 25.71875 23.359375 25.4375 C 23.269531 25.207031 23.179688 24.984375 23.105469 24.777344 C 21.105469 19.179688 18.15625 13.769531 16.984375 11.703125 C 16.6875 11.179688 16.316406 10.699219 15.910156 10.246094 C 18.523438 9.460938 21.265625 9.054688 24 9 Z M 5.433594 17.238281 C 5.6875 16.875 5.960938 16.523438 6.246094 16.1875 C 6.339844 16.074219 6.441406 15.96875 6.539062 15.859375 C 6.742188 15.632812 6.949219 15.410156 7.164062 15.195312 C 7.28125 15.082031 7.398438 14.972656 7.515625 14.863281 C 7.746094 14.648438 7.980469 14.441406 8.21875 14.238281 C 8.320312 14.15625 8.417969 14.074219 8.519531 13.992188 C 8.761719 13.800781 9.015625 13.617188 9.265625 13.433594 C 10.152344 13.523438 10.972656 13.957031 11.527344 14.351562 C 12.121094 14.777344 12.824219 15 13.554688 15 L 14.28125 15 C 14.632812 15.40625 15.195312 16.234375 15.335938 17.027344 C 15.441406 17.621094 15.480469 18.207031 15.449219 18.757812 C 15.277344 21.800781 15.5625 23.6875 15.898438 24.816406 C 11.703125 22.789062 6.164062 22.484375 3.472656 22.472656 C 3.648438 20.621094 4.347656 18.8125 5.433594 17.238281 Z M 6.234375 30.269531 C 6.042969 30.046875 5.839844 29.835938 5.664062 29.597656 C 4.328125 27.824219 3.488281 25.703125 3.425781 23.5 C 3.425781 23.492188 3.425781 23.484375 3.425781 23.476562 C 6.304688 23.480469 12.652344 23.824219 16.730469 26.421875 C 16.941406 26.554688 17.214844 26.511719 17.378906 26.316406 C 17.539062 26.128906 17.53125 25.839844 17.363281 25.65625 C 17.351562 25.640625 16.144531 24.234375 16.449219 18.8125 C 16.484375 18.183594 16.441406 17.523438 16.320312 16.851562 C 16.105469 15.617188 15.1875 14.480469 14.855469 14.144531 C 14.761719 14.054688 14.632812 14 14.5 14 L 13.554688 14 C 13.03125 14 12.535156 13.839844 12.109375 13.539062 C 11.363281 13.007812 10.183594 12.390625 8.925781 12.398438 C 8.792969 12.402344 8.699219 12.335938 8.644531 12.28125 C 8.550781 12.191406 8.5 12.066406 8.5 11.9375 C 8.5 11.695312 8.695312 11.5 8.890625 11.496094 L 9.453125 11.550781 C 9.5625 11.558594 9.667969 11.523438 9.761719 11.46875 L 10.148438 11.855469 C 10.242188 11.949219 10.371094 12 10.5 12 C 10.554688 12 10.605469 11.992188 10.65625 11.976562 L 11.863281 11.574219 L 13.144531 12.855469 C 13.242188 12.949219 13.371094 13 13.5 13 C 13.628906 13 13.757812 12.949219 13.855469 12.855469 C 14.050781 12.660156 14.050781 12.34375 13.855469 12.148438 L 12.707031 11 L 12.851562 10.855469 C 12.949219 10.757812 13 10.628906 13 10.5 C 13 10.371094 12.949219 10.242188 12.855469 10.144531 L 11.855469 9.144531 C 11.660156 8.949219 11.34375 8.949219 11.148438 9.144531 C 11.050781 9.242188 11 9.371094 11 9.5 C 11 9.628906 11.050781 9.757812 11.144531 9.855469 L 11.792969 10.5 L 11.730469 10.5625 L 10.632812 10.929688 L 10 10.292969 L 10 9.320312 C 10 9.140625 10.097656 8.976562 10.25 8.886719 L 11.46875 8.175781 C 11.835938 8.035156 12.261719 7.996094 12.351562 8.058594 L 14.90625 10.613281 C 15.382812 11.089844 15.789062 11.621094 16.117188 12.195312 C 17.277344 14.238281 20.191406 19.589844 22.164062 25.113281 C 22.242188 25.332031 22.335938 25.566406 22.433594 25.808594 C 22.777344 26.679688 23.171875 27.664062 23.011719 28.390625 C 22.808594 29.308594 21.726562 30 20.488281 30 C 20.421875 30.003906 13.367188 30.140625 7.066406 30.011719 C 6.796875 30.003906 6.507812 30.113281 6.234375 30.269531 Z M 37.21875 33.917969 C 35.238281 35.035156 33.0625 35.816406 30.832031 36.335938 C 28.605469 36.875 26.304688 37.136719 24 37.148438 C 19.40625 37.160156 14.742188 36.199219 10.769531 33.941406 C 9.367188 33.140625 8.0625 32.175781 6.9375 31.050781 C 6.972656 31.035156 7.019531 31.011719 7.046875 31.011719 C 13.367188 31.136719 20.4375 31 20.5 31 C 21.894531 31 23.117188 30.328125 23.691406 29.328125 C 24.265625 30.328125 25.484375 31 26.875 31 C 26.945312 31.003906 34.019531 31.140625 40.335938 31.011719 C 40.425781 31.015625 40.609375 31.113281 40.820312 31.261719 C 39.746094 32.289062 38.53125 33.183594 37.21875 33.917969 Z M 42.328125 29.59375 C 42.082031 29.921875 41.804688 30.226562 41.527344 30.535156 C 41.15625 30.261719 40.714844 30.011719 40.335938 30.011719 C 40.328125 30.011719 40.324219 30.011719 40.316406 30.011719 C 34.015625 30.136719 26.964844 30 26.882812 30 C 25.65625 30 24.574219 29.308594 24.371094 28.390625 C 24.210938 27.664062 24.601562 26.679688 24.949219 25.808594 C 25.046875 25.566406 25.140625 25.332031 25.21875 25.113281 C 27.1875 19.597656 30.105469 14.242188 31.265625 12.195312 C 31.59375 11.621094 32 11.089844 32.476562 10.613281 L 35.027344 8.0625 C 35.121094 8 35.546875 8.035156 35.839844 8.140625 L 37.132812 8.886719 C 37.289062 8.976562 37.382812 9.144531 37.382812 9.320312 L 37.382812 10.292969 L 36.75 10.929688 L 35.652344 10.5625 L 35.589844 10.5 L 36.238281 9.855469 C 36.335938 9.757812 36.382812 9.628906 36.382812 9.5 C 36.382812 9.371094 36.335938 9.242188 36.238281 9.144531 C 36.042969 8.949219 35.726562 8.949219 35.53125 9.144531 L 34.53125 10.144531 C 34.433594 10.242188 34.382812 10.371094 34.382812 10.5 C 34.382812 10.628906 34.433594 10.757812 34.53125 10.855469 L 34.675781 11 L 33.53125 12.144531 C 33.335938 12.339844 33.335938 12.65625 33.53125 12.851562 C 33.628906 12.949219 33.757812 13 33.882812 13 C 34.011719 13 34.140625 12.949219 34.238281 12.855469 L 35.519531 11.574219 L 36.726562 11.976562 C 36.777344 11.992188 36.832031 12 36.882812 12 C 37.015625 12 37.140625 11.949219 37.238281 11.855469 L 37.625 11.46875 C 37.714844 11.523438 37.820312 11.558594 37.933594 11.550781 L 38.445312 11.5 C 38.6875 11.5 38.886719 11.695312 38.886719 11.9375 C 38.886719 12.066406 38.832031 12.191406 38.742188 12.28125 C 38.6875 12.335938 38.585938 12.390625 38.460938 12.398438 C 37.179688 12.410156 36.019531 13.007812 35.273438 13.539062 C 34.851562 13.839844 34.351562 14 33.828125 14 L 32.882812 14 C 32.75 14 32.625 14.054688 32.53125 14.144531 C 32.195312 14.480469 31.28125 15.617188 31.0625 16.851562 C 30.945312 17.527344 30.902344 18.1875 30.9375 18.816406 C 31.238281 24.234375 30.03125 25.640625 30.03125 25.644531 C 29.851562 25.828125 29.835938 26.113281 29.992188 26.3125 C 30.152344 26.511719 30.433594 26.558594 30.652344 26.421875 C 35.058594 23.617188 42.226562 23.453125 44.574219 23.480469 C 44.574219 23.484375 44.574219 23.492188 44.574219 23.5 C 44.507812 25.703125 43.664062 27.824219 42.328125 29.59375 Z M 42.328125 29.59375 "/>
                                            </g>
                                            </svg>

                                         </button>
                                         <button class="btn btn-outline-primary btn-lg btn-picpay" onclick="load_card_gateways('picpay');" >PicPay

                                           <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="30" height="30" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M16.463 1.587v7.537H24V1.587zm1.256 1.256h5.025v5.025h-5.025zm1.256 1.256v2.513h2.513V4.099zM3.77 5.355V8.53h3.376c2.142 0 3.358 1.04 3.358 2.939c0 1.947-1.216 3.011-3.358 3.011H3.769V8.53H0v13.884h3.769v-4.76h3.57c4.333 0 6.815-2.352 6.815-6.32c0-3.771-2.482-5.978-6.814-5.978z" fill="#7922ff"/></svg>

                                         </button>
                                         <button class="btn btn-outline-primary btn-lg btn-paghiper" onclick="load_card_gateways('paghiper');" >Pag Hiper

                                           <svg width="65" height="37" viewBox="0 1 100 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                                             <path d="M19.2275 10.9224C19.5962 8.67145 19.0529 6.67271 17.7527 5.43079C16.472 4.15007 14.3569 3.52911 11.3103 3.52911C8.63243 3.52911 6.36201 3.68435 4.51855 4.01424L4.46034 4.03364L0.656974 27.1255L0.618164 27.2419H5.72166L7.0994 18.8784C7.4875 18.956 7.99203 18.9948 8.69061 18.9948C11.7372 18.9948 14.3569 18.141 16.2586 16.511C17.7721 15.2497 18.8394 13.2704 19.2275 10.9224ZM14.1046 11.0582C13.7165 13.3674 11.9312 14.7452 9.33101 14.7452C8.61299 14.7452 8.16671 14.7064 7.81742 14.6287L8.92347 7.89525C9.33101 7.79819 10.0102 7.74001 10.8834 7.74001C12.1447 7.74001 13.0955 8.06986 13.6389 8.71026C14.1046 9.29241 14.2598 10.0685 14.1046 11.0582Z" fill="#7922ff"></path>
                                             <path d="M31.859 17.1495C32.2664 14.6268 31.9366 12.7058 30.8693 11.4444C29.8797 10.2801 28.2497 9.67859 26.018 9.67859C22.6416 9.67859 20.216 10.8623 19.5562 11.2116L19.498 11.2504L19.8667 14.8597L20.0026 14.7821C21.0504 14.1417 22.8744 13.5208 24.5433 13.5208C25.5718 13.5208 26.2897 13.7536 26.6778 14.1999C26.9689 14.5492 27.0854 15.0344 26.9689 15.6165L26.9495 15.7523C20.934 15.7718 17.2471 18.1003 16.5485 22.3112C16.2962 23.786 16.6455 25.2025 17.4799 26.1728C18.2755 27.1236 19.4786 27.6087 20.9146 27.6087C22.8163 27.6087 24.5433 26.8908 25.8046 25.5712L25.824 27.2206H30.4618V27.1236C30.423 26.3086 30.5782 24.9115 30.8693 23.0486L31.859 17.1495ZM26.2509 20.9722C26.1927 21.2827 26.1151 21.5932 26.018 21.8455C25.5135 22.9322 24.3298 23.7277 23.2237 23.7277C22.6804 23.7277 22.2535 23.5531 21.9818 23.2426C21.7101 22.9127 21.6131 22.4276 21.7101 21.826C21.9818 20.1378 23.6118 19.2646 26.542 19.2452L26.2509 20.9722Z" fill="#7922ff"></path>
                                             <path d="M50.1575 10.1093H45.675L45.2093 12.0498C44.5107 10.5168 43.1911 9.7406 41.2506 9.7406C37.0204 9.7406 33.3334 13.5246 32.4796 18.7639C32.0333 21.4612 32.499 23.7898 33.7991 25.3228C34.8082 26.5065 36.2248 27.1275 37.9324 27.1275C39.6983 27.1275 41.3089 26.4094 42.512 25.0705L42.3761 25.9049C41.9104 28.6992 40.1834 30.2904 37.6025 30.2904C35.7591 30.2904 34.1484 29.6307 33.2558 29.0291L33.1588 28.9515L31.4512 33.1624L31.5094 33.2012C32.7707 34.0162 34.847 34.5013 37.0592 34.5013C39.8535 34.5013 42.1627 33.8028 43.8897 32.4056C45.8302 30.8338 47.0139 28.4082 47.6155 24.7212L49.1679 15.2904C49.5753 12.8066 49.8665 11.3901 50.1381 10.2451L50.1575 10.1093ZM43.7539 17.0951L43.3464 19.5983C43.2494 20.1805 43.1135 20.6656 42.9583 20.9955C42.4344 22.218 41.2701 23.0524 40.067 23.0524C39.3296 23.0524 38.7474 22.8002 38.3205 22.2956C37.6608 21.5194 37.4473 20.1999 37.6996 18.6669C38.1653 15.8338 39.7565 13.9321 41.6387 13.9321C42.9001 13.9321 43.6957 14.7471 43.8121 16.1637C43.8315 16.4353 43.7927 16.7652 43.7539 17.0951Z" fill="#7922ff"></path>
                                             <path d="M71.3112 3.70245H66.1881L64.6936 12.6676H56.7572L58.232 3.70245H53.0897L49.2281 27.1242L49.2087 27.2407H54.351L55.9617 17.4799H63.9174L62.3071 27.2407H67.4302L71.2913 3.81888L71.3112 3.70245Z" fill="#7922ff"></path>
                                             </svg>


                                         </button>
                                         <button class="btn btn-outline-primary btn-lg btn-bank" onclick="load_card_gateways('banco');" > PIX
                                           <svg width="25" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                             <defs/>
                                             <g fill="#7922ff" fill-rule="evenodd">
                                               <path d="M393.072 391.897c-20.082 0-38.969-7.81-53.176-22.02l-77.069-77.067c-5.375-5.375-14.773-5.395-20.17 0l-76.784 76.786c-14.209 14.207-33.095 22.019-53.179 22.019h-9.247l97.521 97.52c30.375 30.375 79.614 30.375 109.988 0l97.239-97.238h-15.123zm-105.049 74.327c-8.55 8.53-19.93 13.25-32.05 13.25h-.02c-12.12 0-23.522-4.721-32.05-13.25l-56.855-56.855c7.875-4.613 15.165-10.248 21.758-16.84l63.948-63.948 64.23 64.23c7.637 7.66 16.188 14.013 25.478 18.952l-54.439 54.46zM310.958 22.78c-30.374-30.374-79.613-30.374-109.988 0l-97.52 97.52h9.247c20.082 0 38.97 7.834 53.178 22.02l76.784 76.785c5.57 5.592 14.622 5.57 20.17 0l77.069-77.068c14.207-14.187 33.094-22.02 53.176-22.02h15.123l-97.239-97.237zm6.028 96.346l-64.23 64.23-63.97-63.97c-6.593-6.592-13.86-12.206-21.736-16.818l56.853-56.877c17.69-17.645 46.476-17.668 64.121 0l54.44 54.461c-9.292 4.961-17.842 11.315-25.479 18.974h.001z"/>
                                               <path d="M489.149 200.97l-58.379-58.377h-37.706c-13.838 0-27.394 5.635-37.185 15.426l-77.068 77.069c-7.202 7.18-16.623 10.77-26.067 10.77-9.443 0-18.885-3.59-26.066-10.77l-76.785-76.785c-9.792-9.814-23.346-15.427-37.207-15.427h-31.81L22.78 200.97c-30.374 30.375-30.374 79.614 0 109.988l58.095 58.074 31.81.021c13.86 0 27.416-5.635 37.208-15.426l76.784-76.764c13.925-13.947 38.208-13.924 52.133-.02l77.068 77.066c9.791 9.792 23.346 15.405 37.185 15.405h37.706l58.379-58.356c30.374-30.374 30.374-79.613 0-109.988zm-362.19 129.724c-3.763 3.786-8.942 5.917-14.273 5.917H94.302l-48.59-48.564c-17.689-17.69-17.689-46.476 0-64.143L94.3 175.296h18.385c5.331 0 10.51 2.154 14.295 5.918l74.74 74.74-74.761 74.74zm339.257-42.647l-48.848 48.87h-24.305c-5.309 0-10.508-2.155-14.251-5.92l-75.023-75.043 75.023-75.023c3.743-3.764 8.942-5.918 14.252-5.918h24.304l48.847 48.891c8.573 8.551 13.273 19.93 13.273 32.05 0 12.141-4.7 23.52-13.273 32.093z"/>
                                             </g>
                                           </svg>
                                         </button>
                                     </div>
                                     <p id="response-gate">

                                     </p>
                                 </div>
                                 <div class="col-md-3"></div>

                                 <div style="margin-top:5px;" id="card-mercadopago" class="col-md-12">
                                     <div style="padding:10px;" class="card">
                                         <div class="card-head">
                                             <h4>Integrar ao Mercado Pago </h4>
                                             <a target="_blank" href="https://www.mercadopago.com.br/developers/panel/credentials/" >Pegar minhas credenciais <i class="fa fa-external-link"></i></a>
                                         </div>
                                         <div class="card-body">
                                             <div class="form-group">
                                                 <input type="text" class="form-control" placeholder="client_id" value="<?php if($mp_gate){ echo $mp_gate->client_id; } ?>" id="mp_client_id" />
                                             </div>
                                              <div class="form-group">
                                                 <input type="text" class="form-control" placeholder="client_secret" value="<?php if($mp_gate){ echo $mp_gate->client_secret; } ?>" id="mp_client_secret" />
                                             </div>
                                         </div>
                                         <div class="text-center card-footer">
                                              <small>Deixe os campos em branco para deletar</small>
                                             <button class="btn btn-primary" id="btn_gate_mercadopago" onclick="save_gate('mercadopago');" style="width:100%;" id="btn_gate_mercadopago" >Salvar</button>
                                         </div>

                                     </div>
                                 </div>

                                    <div style="margin-top:5px;display:none;" id="card-paghiper" class="col-md-12">
                                     <div style="padding:10px;" class="card">
                                         <div class="card-head">
                                             <h4>Integrar ao Pag Hiper </h4>

                                               <div class="custom-control custom-checkbox mr-lg">
                                               <input <?php if($ph_gate){ if($ph_gate->situ == 1){ echo 'checked'; } } ?> type="checkbox" class="custom-control-input" id="situ_gate_paghiper">
                                               <label class="custom-control-label" for="situ_gate_paghiper">Ativo</label>
                                               </div>
                                             <a href="https://www.paghiper.com/painel/credenciais/" target="_blank" >Pegar minhas credenciais <i class="fa fa-external-link"></i></a>
                                         </div>
                                         <div class="card-body">
                                             <div class="form-group">
                                                 <input type="text" class="form-control" placeholder="API KEY" value="<?php if($ph_gate){ echo $ph_gate->apikey; } ?>" id="ph_apikey" />
                                             </div>
                                              <div class="form-group">
                                                 <input type="text" class="form-control" placeholder="TOKEN" value="<?php if($ph_gate){ echo $ph_gate->token; } ?>" id="ph_token" />
                                             </div>
                                         </div>
                                         <div class="text-center card-footer">
                                              <small>Deixe os campos em branco para deletar</small>
                                             <button class="btn btn-primary" id="btn_gate_paghiper" onclick="save_gate('paghiper');" style="width:100%;" id="btn_gate_paghiper" >Salvar</button>
                                         </div>

                                     </div>
                                 </div>

                                 <div style="margin-top:5px;display:none;" id="card-picpay" class="col-md-12">
                                     <div style="padding:10px;" class="card">
                                         <div class="card-head">
                                             <h4>PicPay</h4>
                                             <div class="custom-control custom-checkbox mr-lg">
                                               <input <?php if($picpay_gate){ if($picpay_gate->situ == 1){ echo 'checked'; } } ?> type="checkbox" class="custom-control-input" id="situ_gate_picpay">
                                               <label class="custom-control-label" for="situ_gate_picpay">Ativo</label>
                                             </div>
                                             <button onclick="save_gate('picpay');" class="btn btn-primary" style="width:100%;" id="btn_gate_picpay" >Salvar</button>
                                              <a onclick="load_modelo_gateway('picpay');" class="link text-info" style="cursor:pointer;" >Clique aqui para carregar modelo pronto</a>

                                         </div>
                                         <div class="card-body">
                                           <textarea id="picpay_dados" placeholder="Coloque aqui seu Qr Code e seu usu??rio do picpay" ><?php if($picpay_gate){ if($picpay_gate->content != ""){ echo $picpay_gate->content; } } ?></textarea>

                                             <script>

                                                 tinymce.init({
                                                   selector:'textarea#picpay_dados',
                                                   language_url : 'js/lang_editor_txt/pt_BR.js',
                                                   height: 400,
                                                   plugins: [
                                                       'lists code emoticons',
                                                       'advlist autolink lists link image charmap print preview anchor',
                                                       'searchreplace visualblocks code fullscreen',
                                                       'insertdatetime media table paste code wordcount'
                                                     ],
                                                     toolbar: 'undo redo | styleselect | bold italic | ' +
                                                               'alignleft aligncenter alignright alignjustify | ' +
                                                               'outdent indent | numlist bullist | link image | code | emoticons',
                                                 });

                                             </script>


                                         </div>
                                         <div class="card-footer">
                                         </div>
                                     </div>
                                 </div>

                                 <div style="margin-top:5px;display:none;" id="card-banco" class="col-md-12">
                                     <div style="padding:10px;" class="card">
                                         <div class="card-head">
                                             <h4>Banco & PIX</h4>
                                             <div class="custom-control custom-checkbox mr-lg">
                                               <input <?php if($bank_gate){ if($bank_gate->situ == 1){ echo 'checked'; } } ?> type="checkbox" class="custom-control-input" id="situ_gate_banco">
                                               <label class="custom-control-label" for="situ_gate_banco">Ativo</label>
                                             </div>
                                             <button class="btn btn-primary" style="width:100%;" onclick="save_gate('banco');" id="btn_gate_banco"  >Salvar</button>
                                             <a onclick="load_modelo_gateway('banco');" class="link text-info" style="cursor:pointer;" >Clique aqui para carregar modelo pronto</a>
                                         </div>
                                         <div class="card-body">


                                             <script>

                                                 tinymce.init({
                                                   selector:'textarea#banco_dados',
                                                   language_url : 'js/lang_editor_txt/pt_BR.js',
                                                   height: 400,
                                                   plugins: [
                                                       'lists code emoticons',
                                                       'advlist autolink lists link image charmap print preview anchor',
                                                       'searchreplace visualblocks code fullscreen',
                                                       'insertdatetime media table paste code wordcount'
                                                     ],
                                                     toolbar: 'undo redo | styleselect | bold italic | ' +
                                                               'alignleft aligncenter alignright alignjustify | ' +
                                                               'outdent indent | numlist bullist | link image | code | emoticons',
                                                 });

                                             </script>

                                             <textarea id="banco_dados" placeholder="Coloque aqui as informa????es do seu banco" ><?php if($bank_gate){ if($bank_gate->content != ""){ echo $bank_gate->content; } } ?></textarea>

                                         </div>
                                         <div class="card-footer">

                                         </div>
                                     </div>
                                 </div>


                             </div>
                              <input type="hidden" value="mercadopago" id="active_tab" />

                           </div>

                   </div>
               </div>
           </div>
       </div>
   </div>



<?php include_once 'inc/footer.php'; ?>
