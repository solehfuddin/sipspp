  <?= $this->extend('components/template_login'); ?>

  <?= $this->section('content'); ?>
  <!-- Main content -->
  <div class="main-content">
    <!-- Page content -->
    <!-- Header -->
    <div class="header bg-gradient-primary py-6 py-lg-7 pt-lg-8">
      <div class="separator separator-bottom separator-skew zindex-100">
        <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
          <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
        </svg>
      </div>
    </div>
    <div class="container mt--8 pb-5">
      <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
          <div class="card bg-secondary border-0 mb-0">
            <div class="card-body px-lg-5 py-lg-5">
             <div class="text-center">
             <img src="<?= base_url() ?>/public/assets/img/brand/logo-smp.png" width="50%">
             </div>
              <div class="text-center text-muted mb-4" style="margin-top: 20px;">
                <h4>Login Akun</h4>
              </div>

              <!-- Handle FORM -->
               <?= form_open('login/auth', ['class' => 'formLogin']); ?>
                <?= csrf_field(); ?>
                <div class="form-group mb-3">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-circle-08"></i></span>
                    </div>
                    <input class="form-control" placeholder="Username atau Email" type="text" name="emailaddr" id="emailaddr">
                    <!-- Error Validation -->
                    <div class="invalid-feedback bg-secondary errorEmailAddr"></div>
                  </div>
                </div>

                <div class="form-group mb-3">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                    </div>
                    <input class="form-control" placeholder="Password" type="password" name="pass" id="pass">
                    <!-- Error Validation -->
                    <div class="invalid-feedback bg-secondary errorPass"></div>
                  </div>
                </div>

                <div class="text-center">
                  <button type="submit" class="btn btn-primary my-4 btnLogin">Login</button>
                </div>
                <?= form_close(); ?>
              <!-- Handle FORM -->
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-6">
              <!-- <a href="login.html#" class="text-light"><small>Forgot password?</small></a> -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?= $this->endSection(); ?>