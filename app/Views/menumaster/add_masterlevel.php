 <!-- Modal Tambah Info -->
 <div class="modal fade" id="modaltambahmasterlevel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Tambah Data Master Level</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <!-- Handle Form -->
        <?= form_open_multipart('master/levelcontroller/simpandata', ['class' => 'formModaltambahmasterlevel']); ?>
        <?= csrf_field(); ?>

        <div class="modal-body">
                <div class="form-group">
                  <label for="kode-infocategory-input" class="form-control-label">Id Level</label>
                  <input class="form-control" type="text"  placeholder="MLV001" 
                        name="masterlevel_kode" id="masterlevel_kode" readonly />
                  <!-- Error Validation -->
                  <div class="invalid-feedback bg-secondary errormasterlevelKode">test</div>
                </div>

                <div class="form-group">
                  <label for="nama-infocategory-input" class="form-control-label">Nama Level</label>
                  <input class="form-control" type="text" placeholder="Kasir" 
                        name="masterlevel_nama" id="masterlevel_nama" />
                  <!-- Error Validation -->
                  <div class="invalid-feedback bg-secondary errormasterlevelNama">testte</div>
                </div>

                <div class="form-group">
                  <label for="nama-infocategory-input" class="form-control-label">Deskripsi Level</label>
                  <textarea class="form-control" rows="3" name="masterlevel_desc" 
                        id="masterlevel_desc"></textarea>
                  <!-- Error Validation -->
                  <div class="invalid-feedback bg-secondary errormasterlevelDesc">testte</div>

                  <br />

                  <label class="custom-toggle float-right">
                    <input type="checkbox" id="masterlevel_isactive" class="masterlevel_isactive" value="1"/>
                    <span class="custom-toggle-slider rounded-circle" data-label-off="Tidak" data-label-on="Iya"></span>
                  </label>
                  <label for="nama-infocategory-input" class="form-control-label float-right">Aktifkan level &nbsp;</label>
                </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary btnmodaltambahmasterlevel">Simpan</button>
        </div>

        <?= form_close(); ?>
        <!-- Handle FORM -->
        </div>
    </div>
</div>