 <!-- Modal Tambah Info -->
 <div class="modal fade" id="modalantriansms" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Kirim Notifikasi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <!-- Handle Form -->
        <?= form_open_multipart('pembayarancontroller/antriansms', ['class' => 'formModalantriansms']); ?>
        <?= csrf_field(); ?>

        <div class="modal-body">
                <div class="form-group">
                  <label for="kode-infocategory-input" class="form-control-label">Kode Pembayaran</label>
                  <input class="form-control" type="text"  placeholder="KWT160521092021" 
                        name="antriansms_kodeubah" id="antriansms_kodeubah" readonly />
                  <!-- Error Validation -->
                  <div class="invalid-feedback bg-secondary errorantriasmsKodeubah">test</div>
                </div>

                <div class="form-group">
                  <label for="nama-infocategory-input" class="form-control-label">Nomor Hp Ortu *</label>
                  <input class="form-control" type="text" placeholder="085710035920" 
                        name="antriansms_nohpubah" id="antriansms_nohpubah" />
                  <!-- Error Validation -->
                  <div class="invalid-feedback bg-secondary errorantriasmsNohpubah">testte</div>
                </div>

                <div class="form-group">
                  <label for="nama-infocategory-input" class="form-control-label">Isi pesan</label>
                  <textarea class="form-control" rows="3" name="antriansms_pesanubah" 
                        id="antriansms_pesanubah"></textarea>
                  <!-- Error Validation -->
                  <div class="invalid-feedback bg-secondary errorantriansmsPesanubah">testte</div>
                </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary btnmodalantriansms">Kirim Notifikasi</button>
        </div>

        <?= form_close(); ?>
        <!-- Handle FORM -->
        </div>
    </div>
</div>