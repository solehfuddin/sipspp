<?= $this->extend('components/template_admin') ?>

<?php
  $session = \Config\Services::session();
?>
    
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
              <h4 class="h3 mb-0 text-center">Data Profil</h4>
              <div class="card-header d-flex align-items-center">
                <div class="d-flex align-items-center">
                    <a href="#">
                    <img src="<?= base_url() . '/public/assets/img/profile/' . $session->get('foto'); ?>" class="avatar">
                    </a>
                    <div class="mx-3">
                    <a href="#" class="text-dark font-weight-600 text-sm">@ <?= $session->get('username'); ?></a>
                    </div>
                </div>
              </div>
              <!-- Handle Form -->
              <?= form_open_multipart('profilecontroller/perbaruidata', ['class' => 'formubahprofile']); ?>
              <?= csrf_field(); ?>

              <div class="card-body">
                <div class="form-group">
                  <input class="form-control" type="hidden"  placeholder="USR001" 
                        name="profile_kode" id="profile_kode" value="<?= $session->get('kodeuser'); ?>" readonly />
                  <label for="nama-infocategory-input" class="form-control-label">Nama Lengkap *</label>
                  <input class="form-control" type="text" placeholder="Abdul Rahman" value="<?= $session->get('namalengkap'); ?>"
                        name="profile_fname" id="profile_fname" />
                  <!-- Error Validation -->
                  <div class="invalid-feedback bg-secondary errorprofileFname">testte</div>
                </div>

                <div class="form-group">
                  <label for="nama-infocategory-input" class="form-control-label">Alamat Email *</label>
                  <input class="form-control" type="text" placeholder="abdul.rahman77@gmail.com" 
                        name="profile_email" id="profile_email" value="<?= $session->get('alamatemail'); ?>" />
                  <!-- Error Validation -->
                  <div class="invalid-feedback bg-secondary errorprofileEmail">testte</div>
                </div>

                <div class="form-group">
                  <label for="nama-infocategory-input" class="form-control-label">Telp / Nomor Hp</label>
                  <input class="form-control" type="text" placeholder="08578900200" value="<?= $session->get('nohp'); ?>"
                        name="profile_phone" id="profile_phone" />
                  <!-- Error Validation -->
                  <div class="invalid-feedback bg-secondary errorprofilePhone">testte</div>
                </div>

                <div class="form-group">
                  <label for="nama-infocategory-input" class="form-control-label">Pilih Foto</label>
                  <input type="file" name="profile_photo" class="form-control" id="profile_photo" accept=".jpg, .jpeg, .png" /></p>
                  <div class="invalid-feedback bg-secondary errorprofilePhoto">testte</div>
                </div>

                <div class="form-group">
                  <label for="nama-infocategory-input" class="form-control-label">Alamat Lengkap</label>
                  <textarea class="form-control" rows="3" name="profile_address"
                        id="profile_address"><?= $session->get('alamat'); ?></textarea>
                  <!-- Error Validation -->
                  <div class="invalid-feedback bg-secondary errorprofileAddress">testte</div>
                </div>
                  
                <div class="text-right">
                    <button type="submit" class="btn btn-primary btn-md btnubahprofile">Perbarui Data</button>
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