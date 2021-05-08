 <!-- Modal Tambah Info -->
 <div class="modal fade" id="modalubahmasterkelas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ubah Data Master Kelas</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <!-- Handle Form -->
        <?= form_open_multipart('master/kelascontroller/perbaruidata', ['class' => 'formModalubahmasterkelas']); ?>
        <?= csrf_field(); ?>

        <div class="modal-body">
                <div class="form-group">
                  <label for="kode-infocategory-input" class="form-control-label">Id Kelas</label>
                  <input class="form-control" type="text"  placeholder="MAG001" 
                        name="masterkelas_kodeubah" id="masterkelas_kodeubah" readonly />
                  <!-- Error Validation -->
                  <div class="invalid-feedback bg-secondary errormasterkelasKodeubah">test</div>
                </div>

                <div class="form-group">
                  <label for="nama-infocategory-input" class="form-control-label">Nama Kelas</label>
                  <input class="form-control" type="text" placeholder="Islam" 
                        name="masterkelas_namaubah" id="masterkelas_namaubah" />
                  <!-- Error Validation -->
                  <div class="invalid-feedback bg-secondary errormasterkelasNamaubah">testte</div>
                </div>

                <div class="form-group">
                  <label for="nama-infocategory-input" class="form-control-label">Deskripsi Kelas</label>
                  <textarea class="form-control" rows="3" name="masterkelas_descubah" 
                        id="masterkelas_descubah"></textarea>
                  <!-- Error Validation -->
                  <div class="invalid-feedback bg-secondary errormasterkelasDescubah">testte</div>

                  <br />

                  <label class="custom-toggle float-right">
                    <input type="checkbox" id="masterkelas_isactiveubah" class="masterkelas_isactiveubah" value="1"/>
                    <span class="custom-toggle-slider rounded-circle" data-label-off="Tidak" data-label-on="Iya"></span>
                  </label>
                  <label for="nama-infocategory-input" class="form-control-label float-right">Aktifkan kelas &nbsp;</label>
                </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary btnmodalubahmasterkelas">Ubah</button>
        </div>

        <?= form_close(); ?>
        <!-- Handle FORM -->
        </div>
    </div>
</div>