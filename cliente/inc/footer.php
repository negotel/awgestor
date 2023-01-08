<footer class="footer footer-static footer-light navbar-border navbar-shadow">
  <div class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2"><span class="float-md-left d-block d-md-inline-block"><?= date('Y'); ?>  &copy; Copyright <a class="text-bold-800 grey darken-2" href="<?= $_SESSION['PAINEL']['slug'];?>" target="_blank"><?= $_SESSION['PAINEL']['nome'];?></a></span>

  </div>
</footer>

<script src="<?= $link_gestor; ?>/theme-assets/vendors/js/vendors.min.js" type="text/javascript"></script>
<script src="<?= $link_gestor; ?>/theme-assets/js/core/app-menu-lite.js" type="text/javascript"></script>
<script src="<?= $link_gestor; ?>/theme-assets/js/core/app-lite.js" type="text/javascript"></script>
<script src="https://cdn.skypack.dev/pin/canvas-confetti@v1.3.3-ySRaL53MTwssL5KYsZu8/mode=imports,min/optimized/canvas-confetti.js"></script>
<script src="<?= $link_gestor; ?>/assets/js/confete.js" type="text/javascript"></script>
<script src="<?= $link_gestor; ?>/src/js/function.js" type="text/javascript"></script>

<script>
 $(function(){
     if (screen.width < 766) {
            $(".menu-mobi-personal").show(200);
        }
        
     <?php if(isset($_GET['fat'])) { ?>
        $(".<?= $_GET['fat']; ?>").trigger('click');
     <?php } ?>
        
 });
    
</script>
  
  <script>
  
    function getMobileOperatingSystem() {
      var userAgent = navigator.userAgent || navigator.vendor || window.opera;
    
        if (/windows phone/i.test(userAgent)) {
            $('#SYSTEM_OPERACIONAL').val("WindowsPhone");
        }
    
        if (/android/i.test(userAgent)) {
            $('#SYSTEM_OPERACIONAL').val("Android");
        }
    
        if (/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream) {
            $('#SYSTEM_OPERACIONAL').val("iOS");
        }
    
      }
      
      $(function(){
          getMobileOperatingSystem();
      });
      
      function paymodal(idfat){
          
          
          var sysOs = $("#SYSTEM_OPERACIONAL").val();
          
          if(sysOs == "iOS"){
              location.href="<?= $_SESSION['PAINEL']['slug']; ?>/payment?fat="+idfat;
          }else{
              $('#modal_method_pay_'+idfat).modal();
          }
      }
      
  </script>

  <script type="text/javascript" src="https://use.fontawesome.com/fc727a7e55.js"></script>



</body>
</html>
