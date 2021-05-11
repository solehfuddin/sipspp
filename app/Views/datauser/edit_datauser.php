 <!-- Modal Tambah Info -->
 <div class="modal fade" id="modalubahuser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ubah Data User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <!-- Handle Form -->
        <?= form_open_multipart('usercontroller/perbaruidata', ['class' => 'formModalubahuser']); ?>
        <?= csrf_field(); ?>

        <div class="modal-body">
                <div class="form-group">
                  <label for="kode-infocategory-input" class="form-control-label">Id User</label>
                  <input class="form-control" type="text"  placeholder="USR001" 
                        name="user_kodeubah" id="user_kodeubah" readonly />
                  <!-- Error Validation -->
                  <div class="invalid-feedback bg-secondary erroruserKodeubah">test</div>
                </div>

                <div class="form-group">
                  <label for="nama-infocategory-input" class="form-control-label">Nama Lengkap *</label>
                  <input class="form-control" type="text" placeholder="Abdul Rahman" 
                        name="user_fnameubah" id="user_fnameubah" />
                  <!-- Error Validation -->
                  <div class="invalid-feedback bg-secondary erroruserFnameubah">testte</div>
                </div>

                <div class="form-group">
                  <label for="kode-infonews-input" class="form-control-label">Pilih Level</label>
                  <select class="form-control" id="user_levelubah" name="user_levelubah">
                    <?php foreach($levelcode as $item): ?>
                    <option value="<?= $item['id_level']; ?>">
                        <?= $item['nama_level']; ?>
                    </option>
                    <?php endforeach ?>
                  </select>
                </div>

                <div class="form-group">
                  <label for="nama-infocategory-input" class="form-control-label">Username *</label>
                  <input class="form-control" type="text" placeholder="abdul" 
                        name="user_unameubah" id="user_unameubah" />
                  <!-- Error Validation -->
                  <div class="invalid-feedback bg-secondary erroruserUnameubah">testte</div>
                </div>

                <div class="form-group">
                  <label for="kode-infonews-input" class="form-control-label">Pilih Gender</label>
                  <select class="form-control" id="user_genderubah" name="user_genderubah">
                    <option value="Laki-laki"> Laki-laki </option>
                    <option value="Perempuan"> Perempuan </option>
                  </select>
                </div>

                <div class="form-group">
                  <label for="nama-infocategory-input" class="form-control-label">Alamat Email *</label>
                  <input class="form-control" type="text" placeholder="abdul.rahman77@gmail.com" 
                        name="user_emailubah" id="user_emailubah" />
                  <!-- Error Validation -->
                  <div class="invalid-feedback bg-secondary erroruserEmailubah">testte</div>
                </div>

                <div class="form-group">
                  <label for="nama-infocategory-input" class="form-control-label">Telp / Nomor Hp</label>
                  <input class="form-control" type="text" placeholder="08578900200" 
                        name="user_phoneubah" id="user_phoneubah" />
                  <!-- Error Validation -->
                  <div class="invalid-feedback bg-secondary erroruserPhoneubah">testte</div>
                </div>

                <div class="form-group">
                  <label for="kode-infonews-input" class="form-control-label">Pilih Agama</label>
                  <select class="form-control" id="user_religionubah" name="user_religionubah">
                    <?php foreach($agamacode as $item): ?>
                    <option value="<?= $item['id_agama']; ?>">
                        <?= $item['nama_agama']; ?>
                    </option>
                    <?php endforeach ?>
                  </select>
                </div>

                <div class="form-group">
                  <label for="nama-infocategory-input" class="form-control-label">Pilih Foto</label>
                  <input type="file" name="user_photoubah" class="form-control" id="user_photoubah" accept=".jpg, .jpeg, .png" /></p>
                  <div class="invalid-feedback bg-secondary erroruserPhotoubah">testte</div>
                </div>

                <div class="form-group">
                  <label for="nama-infocategory-input" class="form-control-label">Alamat Lengkap</label>
                  <textarea class="form-control" rows="3" name="user_addressubah" 
                        id="user_addressubah"></textarea>
                  <!-- Error Validation -->
                  <div class="invalid-feedback bg-secondary erroruserAddressubah">testte</div>

                  <br />

                  <label class="custom-toggle float-right">
                    <input type="checkbox" id="user_isactiveubah" class="user_isactiveubah" value="1"/>
                    <span class="custom-toggle-slider rounded-circle" data-label-off="Tidak" data-label-on="Iya"></span>
                  </label>
                  <label for="nama-infocategory-input" class="form-control-label float-right">Aktifkan user &nbsp;</label>
                </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary btnmodalubahuser">Ubah</button>
        </div>

        <?= form_close(); ?>
        <!-- Handle FORM -->
        </div>
    </div>
</div>