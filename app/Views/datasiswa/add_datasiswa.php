 <!-- Modal Tambah Info -->
 <div class="modal fade" id="modaltambahsiswa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Tambah Data Siswa</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <!-- Handle Form -->
        <?= form_open_multipart('siswacontroller/simpandata', ['class' => 'formModaltambahsiswa']); ?>
        <?= csrf_field(); ?>

        <div class="modal-body">
                <div class="form-group">
                  <label for="kode-infocategory-input" class="form-control-label">Nomor Induk Siswa *</label>
                  <input class="form-control" type="text"  placeholder="2021586711" 
                        name="siswa_nis" id="siswa_nis" />
                  <!-- Error Validation -->
                  <div class="invalid-feedback bg-secondary errorsiswaNis">test</div>
                </div>

                <div class="form-group">
                  <label for="nama-infocategory-input" class="form-control-label">Nama Siswa *</label>
                  <input class="form-control" type="text" placeholder="Desti Handayani" 
                        name="siswa_name" id="siswa_name" />
                  <!-- Error Validation -->
                  <div class="invalid-feedback bg-secondary errorsiswaName">testte</div>
                </div>

                <div class="form-group">
                  <label for="nama-infocategory-input" class="form-control-label">Tempat Lahir </label>
                  <input class="form-control" type="text" placeholder="Jakarta" 
                        name="siswa_place" id="siswa_place" />
                  <!-- Error Validation -->
                  <div class="invalid-feedback bg-secondary errorsiswaPlace">testte</div>
                </div>

                <div class="form-group">
                  <label for="nama-infocategory-input" class="form-control-label">Tanggal Lahir</label>
                  <input class="form-control datepicker" placeholder="Start date" type="text" 
						value="<?= date("m/d/Y", strtotime("-13 years")); ?>" name="siswa_born" id="siswa_born">
                  <!-- Error Validation -->
                  <div class="invalid-feedback bg-secondary errorsiswaBorn">testte</div>
                </div>

                <div class="form-group">
                  <label for="kode-infonews-input" class="form-control-label">Pilih Kelas</label>
                  <select class="form-control" id="siswa_class" name="siswa_class">
                    <?php foreach($kelascode as $item): ?>
                    <option value="<?= $item['id_kelas']; ?>">
                        <?= $item['nama_kelas']; ?>
                    </option>
                    <?php endforeach ?>
                  </select>
                </div>

                <div class="form-group">
                  <label for="kode-infonews-input" class="form-control-label">Pilih Gender</label>
                  <select class="form-control" id="siswa_gender" name="siswa_gender">
                    <option value="Laki-laki"> Laki-laki </option>
                    <option value="Perempuan"> Perempuan </option>
                  </select>
                </div>

                <div class="form-group">
                  <label for="nama-infocategory-input" class="form-control-label">Telp / Nomor Hp</label>
                  <input class="form-control" type="text" placeholder="08578900200" 
                        name="siswa_phone" id="siswa_phone" />
                  <!-- Error Validation -->
                  <div class="invalid-feedback bg-secondary errorsiswaPhone">testte</div>
                </div>

                <div class="form-group">
                  <label for="kode-infonews-input" class="form-control-label">Pilih Agama</label>
                  <select class="form-control" id="siswa_religion" name="siswa_religion">
                    <?php foreach($agamacode as $item): ?>
                    <option value="<?= $item['id_agama']; ?>">
                        <?= $item['nama_agama']; ?>
                    </option>
                    <?php endforeach ?>
                  </select>
                </div>

                <div class="form-group">
                  <label for="nama-infocategory-input" class="form-control-label">Pilih Foto</label>
                  <input type="file" name="siswa_photo" class="form-control" id="siswa_photo" accept=".jpg, .jpeg, .png" /></p>
                  <div class="invalid-feedback bg-secondary errorsiswaPhoto">testte</div>
                </div>

                <div class="form-group">
                  <label for="nama-infocategory-input" class="form-control-label">Alamat Rumah</label>
                  <textarea class="form-control" rows="3" name="siswa_address" 
                        id="siswa_address"></textarea>
                  <!-- Error Validation -->
                  <div class="invalid-feedback bg-secondary errorsiswaAddress">testte</div>
                </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary btnmodaltambahsiswa">Simpan</button>
        </div>

        <?= form_close(); ?>
        <!-- Handle FORM -->
        </div>
    </div>
</div>