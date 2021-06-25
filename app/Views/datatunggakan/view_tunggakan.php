<?= $this->extend('components/template_admin') ?>
    
<?= $this->section('content') ?>

<?php
  $session = \Config\Services::session();
?>
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
              <h3 class="mb-0">Data tunggakan</h3>
              <p class="text-sm mb-0">
                Berisi data siswa yang menunggak SPP pada sistem informasi SPP dan bisa diekport (hanya untuk kepsek)
              </p>
              
              <br>
              <?= form_open('/tunggakancontroller/filterdata', 
                ['class' => 'formFiltertunggakan']); ?>
              <?= csrf_field(); ?>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-control-label">Dari tanggal</label>
                    <input class="form-control datepicker" placeholder="Start date" type="text" 
                      value="<?= $start_date; ?>" name="tunggakan_filterstdate" id="tunggakan_filterstdate" required>
                    <div class="invalid-feedback bg-secondary errorFeaturesfilterstdate">test</div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-control-label">Hingga tanggal</label>
                    <input class="form-control datepicker" placeholder="End date" type="text" 
                     value="<?= $end_date ?>"  name="tunggakan_filtereddate" id="tunggakan_filtereddate" required>
                    <div class="invalid-feedback bg-secondary errorFeaturesfiltereddate">test</div>
                  </div>
                </div>
                <div class="col-md-4 pt-4">
                <button type="submit" class="btn btn-primary btn-sm mt-3 btnfiltertunggakan">
                  Filter
                </button>
                <?= form_close(); ?>

                <?php if($session->get('namalevel') == "Kepala Sekolah") {?>
                <button type="button" class="btn btn-success btn-sm mt-3" data-toggle="modal" data-target="#modalexporttunggakan">Export Excel</button>
                <?php } ?>
                
                <?php if($session->get('namalevel') == "Kasir") {?>
                <button type="button" class="btn btn-warning btn-sm mt-3" onclick="broadcastWa()">Sent Notification</button>
                <?php } ?>
            </div>
            <div class="table-responsive py-4">
              <h4 class="text-center" id="filterdate">Periode <?= date("d-m-Y", strtotime($start_date)); ?> sampai <?= date("d-m-Y", strtotime($end_date)); ?></h4>
              <br/>
              <table class="table table-flush" id="datatable-tunggakan">
                <thead class="thead-light">
                    <tr>
                    <th>No</th>
                    <th>Nis</th>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Bulan</th>
                    <th>Tahun</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    $no = 0;
                    foreach($data as $item): 
                    $no++;

                    $tomboledit = "<button type=\"button\" class=\"btn btn-warning btn-sm btneditpembayaran\"
                                                onclick=\"editpembayaran(".$item->nis. ',' .$item->kode_bulan. ',' .$item->kode_tahun.")\">
                                                <i class=\"fa fa-envelope-open-text\"> Bayar</i></button>";
                  ?>
                  <tr>
                    <td><?= $no; ?></td>
                    <td><?= $item->nis; ?></td>
                    <td><?= $item->nama_siswa; ?></td>
                    <td><?= $item->nama_kelas; ?></td>
                    <td><?= $item->nama_bulan; ?></td>
                    <td><?= $item->kode_tahun; ?></td>
                    <td><?= $item->keterangan; ?></td>
                    <td><?= $tomboledit; ?></td>
                  </tr>
                <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?= $this->include('datatunggakan/export_tunggakan'); ?>
    <?= $this->include('datatunggakan/edit_tunggakan'); ?>
<?= $this->endSection(); ?>