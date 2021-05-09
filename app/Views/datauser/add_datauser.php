 <!-- Modal Tambah Info -->
 <div class="modal fade" id="modaltambahuser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Tambah Data User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <!-- Handle Form -->
        <?= form_open_multipart('usercontroller/simpandata', ['class' => 'formModaltambahuser']); ?>
        <?= csrf_field(); ?>

        <div class="modal-body">
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
                  <label for="kode-infonews-input" class="form-control-label">Pilih Level</label>
                  <select class="form-control" id="user_level" name="user_level">
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
                        name="user_uname" id="user_uname" />
                  <!-- Error Validation -->
                  <div class="invalid-feedback bg-secondary erroruserUname">testte</div>
                </div>

                <div class="form-group">
                  <label for="nama-infocategory-input" class="form-control-label">Kode sandi / Password *</label>
                  <input class="form-control" type="password" placeholder="password" 
                        name="user_pass" id="user_pass" />
                  <!-- Error Validation -->
                  <div class="invalid-feedback bg-secondary erroruserPass">testte</div>
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

                  <br />

                  <label class="custom-toggle float-right">
                    <input type="checkbox" id="user_isactive" class="user_isactive" value="1"/>
                    <span class="custom-toggle-slider rounded-circle" data-label-off="Tidak" data-label-on="Iya"></span>
                  </label>
                  <label for="nama-infocategory-input" class="form-control-label float-right">Aktifkan user &nbsp;</label>
                </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary btnmodaltambahuser">Simpan</button>
        </div>

        <?= form_close(); ?>
        <!-- Handle FORM -->
        </div>
    </div>
</div>