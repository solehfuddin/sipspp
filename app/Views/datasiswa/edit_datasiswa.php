 <!-- Modal Tambah Info -->
 <div class="modal fade" id="modalubahsiswa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ubah Data Siswa</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <!-- Handle Form -->
        <?= form_open_multipart('siswacontroller/perbaruidata', ['class' => 'formModalubahsiswa']); ?>
        <?= csrf_field(); ?>

        <div class="modal-body">
                <div class="form-group">
                  <label for="kode-infocategory-input" class="form-control-label">Nomor Induk Siswa *</label>
                  <input class="form-control" type="text"  placeholder="2021586711" 
                        name="siswa_nisubah" id="siswa_nisubah" readonly/>
                  <!-- Error Validation -->
                  <div class="invalid-feedback bg-secondary errorsiswaNisubah">test</div>
                </div>

                <div class="form-group">
                  <label for="nama-infocategory-input" class="form-control-label">Nama Siswa *</label>
                  <input class="form-control" type="text" placeholder="Desti Handayani" 
                        name="siswa_nameubah" id="siswa_nameubah" />
                  <!-- Error Validation -->
                  <div class="invalid-feedback bg-secondary errorsiswaNameubah">testte</div>
                </div>

                <div class="form-group">
                  <label for="nama-infocategory-input" class="form-control-label">Tempat Lahir </label>
                  <input class="form-control" type="text" placeholder="Jakarta" 
                        name="siswa_placeubah" id="siswa_placeubah" />
                  <!-- Error Validation -->
                  <div class="invalid-feedback bg-secondary errorsiswaPlaceubah">testte</div>
                </div>

                <div class="form-group">
                  <label for="nama-infocategory-input" class="form-control-label">Tanggal Lahir</label>
                  <input class="form-control datepicker" placeholder="Start date" type="text" 
					 name="siswa_bornubah" id="siswa_bornubah">
                  <!-- Error Validation -->
                  <div class="invalid-feedback bg-secondary errorsiswaBornubah">testte</div>
                </div>

                <div class="form-group">
                  <label for="kode-infonews-input" class="form-control-label">Pilih Kelas</label>
                  <select class="form-control" id="siswa_classubah" name="siswa_classubah">
                    <?php foreach($kelascode as $item): ?>
                    <option value="<?= $item['id_kelas']; ?>">
                        <?= $item['nama_kelas']; ?>
                    </option>
                    <?php endforeach ?>
                  </select>
                </div>

                <div class="form-group">
                  <label for="kode-infonews-input" class="form-control-label">Pilih Gender</label>
                  <select class="form-control" id="siswa_genderubah" name="siswa_genderubah">
                    <option value="Laki-laki"> Laki-laki </option>
                    <option value="Perempuan"> Perempuan </option>
                  </select>
                </div>

                <div class="form-group">
                  <label for="nama-infocategory-input" class="form-control-label">Telp / Nomor Hp</label>
                  <input class="form-control" type="text" placeholder="08578900200" 
                        name="siswa_phoneubah" id="siswa_phoneubah" />
                  <!-- Error Validation -->
                  <div class="invalid-feedback bg-secondary errorsiswaPhoneubah">testte</div>
                </div>

                <div class="form-group">
                  <label for="kode-infonews-input" class="form-control-label">Pilih Agama</label>
                  <select class="form-control" id="siswa_religionubah" name="siswa_religionubah">
                    <?php foreach($agamacode as $item): ?>
                    <option value="<?= $item['id_agama']; ?>">
                        <?= $item['nama_agama']; ?>
                    </option>
                    <?php endforeach ?>
                  </select>
                </div>

                <div class="form-group">
                  <label for="nama-infocategory-input" class="form-control-label">Pilih Foto</label>
                  <input type="file" name="siswa_photoubah" class="form-control" id="siswa_photoubah" accept=".jpg, .jpeg, .png" /></p>
                  <div class="invalid-feedback bg-secondary errorsiswaPhotoubah">testte</div>
                </div>

                <div class="form-group">
                  <label for="nama-infocategory-input" class="form-control-label">Alamat Rumah</label>
                  <textarea class="form-control" rows="3" name="siswa_addressubah" 
                        id="siswa_addressubah"></textarea>
                  <!-- Error Validation -->
                  <div class="invalid-feedback bg-secondary errorsiswaAddressubah">testte</div>
                </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary btnmodalubahsiswa">Ubah</button>
        </div>

        <?= form_close(); ?>
        <!-- Handle FORM -->
        </div>
    </div>
</div>