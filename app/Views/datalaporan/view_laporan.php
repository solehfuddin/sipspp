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
              <h3 class="mb-0">Data laporan</h3>
              <p class="text-sm mb-0">
                Berisi data laporan yang telah diinput kasir pada sistem informasi SPP dan bisa diekport
              </p>
              
              <br>
              <?= form_open('/laporancontroller/ajax_list', 
                ['class' => 'formFilterlaporan']); ?>
              <?= csrf_field(); ?>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-control-label">Dari tanggal</label>
                    <input class="form-control datepicker" placeholder="Start date" type="text" 
                      value="<?= $start_date; ?>" name="laporan_filterstdate" id="laporan_filterstdate" required>
                    <div class="invalid-feedback bg-secondary errorFeaturesfilterstdate">test</div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-control-label">Hingga tanggal</label>
                    <input class="form-control datepicker" placeholder="End date" type="text" 
                     value="<?= $end_date ?>"  name="laporan_filtereddate" id="laporan_filtereddate" required>
                    <div class="invalid-feedback bg-secondary errorFeaturesfiltereddate">test</div>
                  </div>
                </div>
                <div class="col-md-4 pt-4">
                <button type="submit" class="btn btn-primary btn-sm mt-3 btnfilterlaporan">
                  Filter
                </button>
                <?= form_close(); ?>

                <button type="button" class="btn btn-success btn-sm mt-3" data-toggle="modal" data-target="#modalexportlaporan">Export Excel</button>
           
                <a href="<?= base_url() . '/admtunggakan'; ?>" class="btn btn-warning btn-sm mt-3">
                <i class="fa fa-exclamation"></i> Data Tunggakan
                </a>
            </div>
            <div class="table-responsive py-4">
              <h4 class="text-center" id="filterdate">Periode <?= date("d-m-Y", strtotime($start_date)); ?> sampai <?= date("d-m-Y", strtotime($end_date)); ?></h4>
              <br/>
              <table class="table table-flush" id="datatable-laporan">
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


    <?= $this->include('datalaporan/export_laporan'); ?>
<?= $this->endSection(); ?>