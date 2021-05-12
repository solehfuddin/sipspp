 <!-- Modal Tambah Info -->
 <div class="modal fade" id="modalubahsetting" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ubah Data Setting</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <!-- Handle Form -->
        <?= form_open_multipart('settingcontroller/perbaruidata', ['class' => 'formModalubahsetting']); ?>
        <?= csrf_field(); ?>

        <div class="modal-body">
                <div class="form-group">
                    <input class="form-control" type="hidden"  placeholder="USR001" 
                        name="setting_kodeubah" id="setting_kodeubah" readonly />
                  <label for="kode-infonews-input" class="form-control-label">Pilih Level</label>
                  <select class="form-control" id="setting_levelubah" name="setting_levelubah">
                    <?php foreach($levelcode as $item): ?>
                    <option value="<?= $item['id_level']; ?>">
                        <?= $item['nama_level']; ?>
                    </option>
                    <?php endforeach ?>
                  </select>
                </div>

                <div class="form-group">
                   <label for="kode-infonews-input" class="form-control-label">Pilih Menu</label>
                   <select class="form-control" id="setting_menuubah" name="setting_menuubah">
                      <?php foreach($menucode as $item): ?>
                      <option value="<?= $item->kode_menu; ?>">
                         <?= $item->nama_menu; ?>
                      </option>
                      <?php endforeach ?>
                   </select>

                  <br />

                  <label class="custom-toggle float-right">
                    <input type="checkbox" id="setting_isactiveubah" class="setting_isactiveubah" value="1"/>
                    <span class="custom-toggle-slider rounded-circle" data-label-off="Tidak" data-label-on="Iya"></span>
                  </label>
                  <label for="nama-infocategory-input" class="form-control-label float-right">Izinkan akses &nbsp;</label>
                </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary btnmodalubahsetting">Ubah</button>
        </div>

        <?= form_close(); ?>
        <!-- Handle FORM -->
        </div>
    </div>
</div>