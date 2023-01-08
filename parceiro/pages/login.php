  <?php include_once 'inc/head.php'; ?>
  <body>
      
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script>
       function onSubmit(token) {
         login(token);
       }
     </script>
     
     
    <div class="adminx-container">
      <!-- adminx-content-aside -->
      <div class="adminx-content">
        <!-- <div class="adminx-aside">
        </div> -->
        <div class="adminx-main-content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-3 col-lg-3 d-flex"></div>
              <div class="col-md-6 col-lg-6 d-flex">
                <div style="padding:10px;" class="card border-0 bg-primary text-white text-center mb-grid w-100">
                  <div class="card-head">
                      <h3>Acessar conta</h3>
                  </div>
                  <div class="card-body">
                      <div style="padding:50px;" class="row">
                          
                          <div class="col-md-12 form-group">
                              <p id="response"></p>
                          </div>
                          <div class="col-md-12 form-group">
                              <input autocomplete="off" type="email" class="form-control" name="email" placeholder="Email" id="email" />
                          </div>
                           <div class="col-md-12 form-group">
                              <input autocomplete="off" type="password" class="form-control" name="password" placeholder="Senha" id="password" />
                          </div>
                          <div class="col-md-12 form-group">
                              <button data-sitekey="6LdlwbEaAAAAAJYZSh3czVPfYVkdLMwJR8KOsFLD" data-callback='onSubmit' style="width:100%;" class="g-recaptcha btn btn-info btn-lg" id="btn_acessar"  >Acessar</button>
                          </div>
                      </div>
                      
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-lg-3 d-flex"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include_once 'inc/footer.php'; ?>
