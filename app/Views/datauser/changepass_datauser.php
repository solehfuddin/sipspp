 <!-- Modal Tambah Info -->
 <div class="modal fade" id="modalchangepassuser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ubah Password User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <!-- Handle Form -->
        <?= form_open_multipart('usercontroller/ubahpassword', ['class' => 'formModalchangepassuser']); ?>
        <?= csrf_field(); ?>

        <div class="modal-body">
                <div class="form-group">
                  <label for="kode-infocategory-input" class="form-control-label">Id User</label>
                  <input class="form-control" type="text"  placeholder="USR001" 
                        name="user_kodechangepass" id="user_kodechangepass" readonly />
                  <!-- Error Validation -->
                  <div class="invalid-feedback bg-secondary erroruserKodechangepass">test</div>
                </div>

                <div class="form-group">
                  <label for="nama-infocategory-input" class="form-control-label">Password Baru *</label>
                  <input class="form-control" type="password" placeholder="password" 
                        name="user_changepass" id="user_changepass" />
                  <div class="invalid-feedback bg-secondary erroruserchangepass">testte</div>
                </div>

                <div class="form-group">
                  <label for="nama-infocategory-input" class="form-control-label">Ulangi Password *</label>
                  <input class="form-control" type="password" placeholder="password" 
                        name="user_confirmchangepass" id="user_confirmchangepass" />
                  <div class="invalid-feedback bg-secondary erroruserconfirmchangepass">testte</div>
                </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary btnmodalubahchangepass">Ubah Password</button>
        </div>

        <?= form_close(); ?>
        <!-- Handle FORM -->
        </div>
    </div>
</div>