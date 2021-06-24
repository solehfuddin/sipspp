<?= $this->extend('components/template_admin') ?>
    
<?= $this->section('content') ?>
    <!-- Header -->
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
            </div>
            <div class="col-lg-6 col-5 text-right">
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
              <h3 class="mb-0">Data siswa</h3>
              <p class="text-sm mb-0">
                Berisi data siswa yang terdaftar pada sistem informasi SPP
              </p>
              <button type="button" class="btn btn-primary btn-sm mt-3" 
                      data-toggle="modal" data-target="#modaltambahsiswa">
               <i class="fa fa-plus-circle"></i> Tambah Data
              </button>

              <button type="button" class="btn btn-primary btn-sm mt-3" 
                        data-toggle="modal" data-target="#modalimportsiswa">
                <i class="fa fa-file-excel"></i> Import Data
              </button>

              <?php
                if(session()->getFlashdata('message')){
                ?>
                <!-- <div class="container">
                  <div class="col-md-8"> -->
                  <div id="alerts-component" class="tab-pane tab-example-result fade show active" role="tabpanel" aria-labelledby="alerts-component-tab">
                    <div class="alert alert-success" role="alert">
                    <?= session()->getFlashdata('message') ?>
                    </div>
                  </div>
                  <!-- </div>
                </div> -->
                <?php
                }else if (session()->getFlashdata('error')){
                ?>
                  <div id="alerts-component" class="tab-pane tab-example-result fade show active" role="tabpanel" aria-labelledby="alerts-component-tab">
                    <div class="alert alert-danger" role="alert">
                    <?= session()->getFlashdata('error') ?>
                  </div>
                <?php
                }
                ?>
            </div>
            <div class="table-responsive py-4">
              <table class="table table-flush" id="datatable-siswa">
                <thead class="thead-light">
                    <tr>
                    <th>No</th>
                    <th>NIS</th>
                    <th>Foto</th>
                    <th>Nama Lengkap</th>
                    <th>Kelas</th>
                    <th>Jenis Kelamin</th>
                    <th>Tempat Lahir</th>
                    <th>Tanggal Lahir</th>
                    <th>Agama</th>
                    <th>No hp</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?= $this->include('datasiswa/add_datasiswa'); ?>
    <?= $this->include('datasiswa/import_datasiswa'); ?>
    <?= $this->include('datasiswa/edit_datasiswa'); ?>
<?= $this->endSection(); ?>