 <!-- Modal Tambah Info -->
 <div class="modal fade" id="modalsmstunggakan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Kirim Informasi WA</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <!-- Handle Form -->
        <?= form_open_multipart('pembayarancontroller/tunggakansms', ['class' => 'formModaltunggakansms']); ?>
        <?= csrf_field(); ?>

        <div class="modal-body">
                <div class="form-group">
                  <label for="nama-infocategory-input" class="form-control-label">Perihal Informasi *</label>
                  <input class="form-control" type="text" placeholder="Informasi tunggakan" 
                        name="tunggakansms_perihal" id="tunggakansms_perihal" />
                  <!-- Error Validation -->
                  <div class="invalid-feedback bg-secondary errorantriasmsPerihalubah">testte</div>
                </div>

                <div class="form-group">
                  <label for="nama-infocategory-input" class="form-control-label">Nomor Hp Ortu *</label>
                  <input class="form-control" type="text" placeholder="085710035920" 
                        name="tunggakansms_nohpubah" id="tunggakansms_nohpubah" />
                  <!-- Error Validation -->
                  <div class="invalid-feedback bg-secondary errorantriasmsNohpubah">testte</div>
                </div>

                <div class="form-group">
                  <label for="nama-infocategory-input" class="form-control-label">Isi pesan</label>
                  <textarea class="form-control" rows="3" name="tunggakansms_pesanubah" 
                        id="tunggakansms_pesanubah"></textarea>
                  <!-- Error Validation -->
                  <div class="invalid-feedback bg-secondary errortunggakansmsPesanubah">testte</div>
                </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary btnmodaltunggakansms">Kirim Notifikasi</button>
        </div>

        <?= form_close(); ?>
        <!-- Handle FORM -->
        </div>
    </div>
</div>