<?= $this->extend('components/template_admin') ?>
    
<?= $this->section('content') ?>
    <!-- Header -->
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
              <!-- <h6 class="h2 text-white d-inline-block mb-0">Datatables</h6>
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  <li class="breadcrumb-item"><a href="datatables.html#"><i class="fas fa-home"></i></a></li>
                  <li class="breadcrumb-item"><a href="datatables.html#">Tables</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Datatables</li>
                </ol>
              </nav> -->
            </div>
            <div class="col-lg-6 col-5 text-right">
              <!-- <a href="datatables.html#" class="btn btn-sm btn-neutral">New</a>
              <a href="datatables.html#" class="btn btn-sm btn-neutral">Filters</a> -->
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid mt--6">
      <!-- Table -->
      <div class="row">
        <div class="col">
          <div class="card">
            <!-- Card header -->
            <div class="card-header">
              <h4 class="h3 mb-0 text-center">Whatsapp Configuration Settings</h4>
              <!-- Handle Form -->
              <?= form_open_multipart('settingwacontroller/perbaruidata', ['class' => 'formsettingwa']); ?>
              <?= csrf_field(); ?>

              <div class="card-body">
                <div class="form-group">
                  <label for="nama-infocategory-input" class="form-control-label">Instance Id *</label>
                  <input class="form-control" type="text" placeholder="289162" value="<?= $setting['instance_id']; ?>"
                        name="settingwa_instance" id="settingwa_instance" />
                  <!-- Error Validation -->
                  <div class="invalid-feedback bg-secondary errorsettingwaInstance">testte</div>
                </div>

                <div class="form-group">
                  <label for="nama-infocategory-input" class="form-control-label">Token *</label>
                  <input class="form-control" type="text" placeholder="c9nnra1zixgcow81" 
                        name="settingwa_token" id="settingwa_token" value="<?= $setting['token']; ?>" />
                  <!-- Error Validation -->
                  <div class="invalid-feedback bg-secondary errorsettingwaToken">testte</div>
                </div>
                  
                <div class="text-right">
                    <button type="submit" class="btn btn-primary btn-md btnsettingwa">Perbarui Data</button>
                </div>
                
                <?= form_close(); ?>
                <!-- Handle FORM -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

<?= $this->endSection(); ?>