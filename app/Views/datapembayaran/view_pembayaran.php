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
              <h3 class="mb-0">Data pembayaran</h3>
              <p class="text-sm mb-0">
                Berisi data pembayaran yang telah diinput pada sistem informasi SPP
              </p>
              <button type="button" class="btn btn-primary btn-sm mt-3" 
                      data-toggle="modal" data-target="#modaltambahpembayaran" 
                      onClick="generatekodepembayaran()">
               <i class="fa fa-plus-circle"></i> Tambah Data
              </button>

              <!-- <button type="button" class="btn btn-danger btn-sm mt-3" 
                      data-toggle="modal" data-target="#modalsmstunggakan">
               <i class="fa fa-paper-plane"></i> Kirim Notifikasi
              </button> -->

              <a href="<?= base_url() . '/admtunggakan'; ?>" class="btn btn-danger btn-sm mt-3">
               <i class="fa fa-exclamation"></i> Data Tunggakan
              </a>
            </div>
            <div class="table-responsive py-4">
              <table class="table table-flush" id="datatable-pembayaran">
                <thead class="thead-light">
                    <tr>
                    <th>No</th>
                    <th>Nis</th>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Jumlah Bayar</th>
                    <th>Tanggal bayar</th>
                    <th>Bulan</th>
                    <th>Tahun</th>
                    <th>Nama Kasir</th>
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

    <?= $this->include('datapembayaran/add_datapembayaran'); ?>
    <?= $this->include('datapembayaran/sms_datapembayaran'); ?>
    <?= $this->include('datapembayaran/sms_datatunggakan'); ?>
<?= $this->endSection(); ?>