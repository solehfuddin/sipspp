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
              <h5 class="h3 mb-0">Profile user</h5>
              <div class="card-header d-flex align-items-center">
                <div class="d-flex align-items-center">
                    <a href="#">
                    <img src="<?= base_url() ?>/public/assets/img/theme/team-1.jpg" class="avatar">
                    </a>
                    <div class="mx-3">
                    <a href="#" class="text-dark font-weight-600 text-sm">John Snow</a>
                    </div>
                </div>
              </div>
              <div class="card-body">
                <div class="form-group">
                  <label for="kode-infocategory-input" class="form-control-label">Id User</label>
                  <input class="form-control" type="text"  placeholder="USR001" 
                        name="user_kode" id="user_kode" readonly />
                  <!-- Error Validation -->
                  <div class="invalid-feedback bg-secondary erroruserKode">test</div>
                </div>

                <div class="form-group">
                  <label for="nama-infocategory-input" class="form-control-label">Nama Lengkap *</label>
                  <input class="form-control" type="text" placeholder="Abdul Rahman" 
                        name="user_fname" id="user_fname" />
                  <!-- Error Validation -->
                  <div class="invalid-feedback bg-secondary erroruserFname">testte</div>
                </div>

                <div class="form-group">
                  <label for="nama-infocategory-input" class="form-control-label">Username *</label>
                  <input class="form-control" type="text" placeholder="abdul" 
                        name="user_uname" id="user_uname" />
                  <!-- Error Validation -->
                  <div class="invalid-feedback bg-secondary erroruserUname">testte</div>
                </div>

                <div class="form-group">
                  <label for="kode-infonews-input" class="form-control-label">Pilih Gender</label>
                  <select class="form-control" id="user_gender" name="user_gender">
                    <option value="Laki-laki"> Laki-laki </option>
                    <option value="Perempuan"> Perempuan </option>
                  </select>
                </div>

                <div class="form-group">
                  <label for="nama-infocategory-input" class="form-control-label">Alamat Email *</label>
                  <input class="form-control" type="text" placeholder="abdul.rahman77@gmail.com" 
                        name="user_email" id="user_email" />
                  <!-- Error Validation -->
                  <div class="invalid-feedback bg-secondary erroruserEmail">testte</div>
                </div>

                <div class="form-group">
                  <label for="nama-infocategory-input" class="form-control-label">Telp / Nomor Hp</label>
                  <input class="form-control" type="text" placeholder="08578900200" 
                        name="user_phone" id="user_phone" />
                  <!-- Error Validation -->
                  <div class="invalid-feedback bg-secondary erroruserPhone">testte</div>
                </div>

                <div class="form-group">
                  <label for="kode-infonews-input" class="form-control-label">Pilih Agama</label>
                  <select class="form-control" id="user_religion" name="user_religion">
                    <?php foreach($agamacode as $item): ?>
                    <option value="<?= $item['id_agama']; ?>">
                        <?= $item['nama_agama']; ?>
                    </option>
                    <?php endforeach ?>
                  </select>
                </div>

                <div class="form-group">
                  <label for="nama-infocategory-input" class="form-control-label">Pilih Foto</label>
                  <input type="file" name="user_photo" class="form-control" id="user_photo" accept=".jpg, .jpeg, .png" /></p>
                  <div class="invalid-feedback bg-secondary erroruserPhoto">testte</div>
                </div>

                <div class="form-group">
                  <label for="nama-infocategory-input" class="form-control-label">Alamat Lengkap</label>
                  <textarea class="form-control" rows="3" name="user_address" 
                        id="user_address"></textarea>
                  <!-- Error Validation -->
                  <div class="invalid-feedback bg-secondary erroruserAddress">testte</div>
                </div>

                <div class="text-right ml-auto">
                    <button type="submit" class="btn btn-primary btnmodaltambahuser">Simpan Data</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
<?= $this->endSection(); ?>