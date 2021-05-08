 <!-- Modal Tambah Info -->
 <div class="modal fade" id="modalubahmasteragama" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ubah Data Master Agama</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <!-- Handle Form -->
        <?= form_open_multipart('master/agamacontroller/perbaruidata', ['class' => 'formModalubahmasteragama']); ?>
        <?= csrf_field(); ?>

        <div class="modal-body">
                <div class="form-group">
                  <label for="kode-infocategory-input" class="form-control-label">Id Agama</label>
                  <input class="form-control" type="text"  placeholder="MAG001" 
                        name="masteragama_kodeubah" id="masteragama_kodeubah" readonly />
                  <!-- Error Validation -->
                  <div class="invalid-feedback bg-secondary errormasteragamaKodeubah">test</div>
                </div>

                <div class="form-group">
                  <label for="nama-infocategory-input" class="form-control-label">Nama Agama</label>
                  <input class="form-control" type="text" placeholder="Islam" 
                        name="masteragama_namaubah" id="masteragama_namaubah" />
                  <!-- Error Validation -->
                  <div class="invalid-feedback bg-secondary errormasteragamaNamaubah">testte</div>
                </div>

                <div class="form-group">
                  <label for="nama-infocategory-input" class="form-control-label">Deskripsi Agama</label>
                  <textarea class="form-control" rows="3" name="masteragama_descubah" 
                        id="masteragama_descubah"></textarea>
                  <!-- Error Validation -->
                  <div class="invalid-feedback bg-secondary errormasteragamaDescubah">testte</div>

                  <br />

                  <label class="custom-toggle float-right">
                    <input type="checkbox" id="masteragama_isactiveubah" class="masteragama_isactiveubah" value="1"/>
                    <span class="custom-toggle-slider rounded-circle" data-label-off="Tidak" data-label-on="Iya"></span>
                  </label>
                  <label for="nama-infocategory-input" class="form-control-label float-right">Aktifkan agama &nbsp;</label>
                </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary btnmodalubahmasteragama">Ubah</button>
        </div>

        <?= form_close(); ?>
        <!-- Handle FORM -->
        </div>
    </div>
</div>