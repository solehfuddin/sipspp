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
              <h3 class="mb-0">Master kelas</h3>
              <p class="text-sm mb-0">
                Berisi data kelas yang dipilih ketika mengisi data siswa
              </p>
              <button type="button" class="btn btn-primary btn-sm mt-3" 
                      data-toggle="modal" data-target="#modaltambahmasterkelas" 
                      onClick="generatekodemasterkelas()">
               <i class="fa fa-plus-circle"></i> Tambah Data
              </button>
            </div>
            <div class="table-responsive py-4">
              <table class="table table-flush" id="datatable-masterkelas">
                <thead class="thead-light">
                    <tr>
                    <th>No</th>
                    <th>Status</th>
                    <th>Nama Kelas</th>
                    <th>Keterangan</th>
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
    
    <?= $this->include('menumaster/add_masterkelas'); ?>
    <?= $this->include('menumaster/edit_masterkelas'); ?>
<?= $this->endSection(); ?>