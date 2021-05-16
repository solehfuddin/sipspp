 <!-- Modal Tambah Info -->
 <div class="modal fade" id="modaltambahpembayaran" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Tambah Data Pembayaran</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <!-- Handle Form -->
        <?= form_open_multipart('pembayarancontroller/simpandata', ['class' => 'formModaltambahpembayaran']); ?>
        <?= csrf_field(); ?>

        <div class="modal-body">
                <div class="form-group">
                  <label for="kode-infocategory-input" class="form-control-label">Kode Pembayaran</label>
                  <input class="form-control" type="text"  placeholder="KWT160521092021" 
                        name="pembayaran_kode" id="pembayaran_kode" readonly />
                  <!-- Error Validation -->
                  <div class="invalid-feedback bg-secondary errorPembayaranKode">test</div>
                </div>

                <div class="form-group">
                  <label for="nama-infocategory-input" class="form-control-label">Nama Siswa *</label>
                  <input class="form-control" type="text" placeholder="Abdul Rahman" 
                        name="pembayaran_search" id="pembayaran_search" />
                  <!-- Error Validation -->
                  <div class="invalid-feedback bg-secondary errorpembayaranSearch">testte</div>
                </div>

                <div class="form-group">
                  <label for="nama-infocategory-input" class="form-control-label">Nomor Induk Siswa *</label>
                  <input class="form-control" type="text" placeholder="abdul" 
                        name="pembayaran_nis" id="pembayaran_nis" />
                  <!-- Error Validation -->
                  <div class="invalid-feedback bg-secondary errorpembayaranNis">testte</div>
                </div>

                <div class="form-group">
                  <label for="nama-infocategory-input" class="form-control-label">Jumlah Bayar *</label>
                  <input class="form-control" type="text" placeholder="abdul.rahman77@gmail.com" 
                        name="pembayaran_biaya" id="pembayaran_biaya" />
                  <!-- Error Validation -->
                  <div class="invalid-feedback bg-secondary errorpembayaranBiaya">testte</div>
                </div>

                <div class="form-group">
                  <label for="kode-infonews-input" class="form-control-label">Pilih Bulan</label>
                  <select class="form-control" id="pembayaran_month" name="pembayaran_month">
                    <option value="1"> Januari </option>
                    <option value="2"> Pebruari </option>
                    <option value="3"> Maret </option>
                    <option value="4"> April </option>
                    <option value="5"> Mei </option>
                    <option value="6"> Juni </option>
                    <option value="7"> Juli </option>
                    <option value="8"> Agustus </option>
                    <option value="9"> September </option>
                    <option value="10"> Oktober </option>
                    <option value="11"> Nopember </option>
                    <option value="12"> Desember </option>
                  </select>
                </div>

                <div class="form-group">
                  <label for="kode-infonews-input" class="form-control-label">Pilih Tahun</label>
                  <select class="form-control" id="pembayaran_year" name="pembayaran_year">
                    <option value="2021"> 2021 </option>
                    <option value="2022"> 2022 </option>
                    <option value="2023"> 2023 </option>
                    <option value="2024"> 2024 </option>
                    <option value="2025"> 2025 </option>
                    <option value="2026"> 2026 </option>
                    <option value="2027"> 2027 </option>
                    <option value="2028"> 2028 </option>
                    <option value="2029"> 2029 </option>
                    <option value="2030"> 2030 </option>
                    <option value="2031"> 2031 </option>
                    <option value="2032"> 2032 </option>
                    <option value="2033"> 2033 </option>
                    <option value="2034"> 2034 </option>
                    <option value="2035"> 2035 </option>
                  </select>
                </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary btnmodaltambahpembayaran">Simpan</button>
        </div>

        <?= form_close(); ?>
        <!-- Handle FORM -->
        </div>
    </div>
</div>