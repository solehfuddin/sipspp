 <!-- Modal Tambah Info -->
 <div class="modal fade" id="modalimportsiswa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Import Data Siswa</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <!-- Handle Form -->
        <form method="post" action="siswacontroller/proses" 
            enctype="multipart/form-data">
        <?= csrf_field(); ?>
            <div class="modal-body">
                <label>File Excel</label>
                <input type="file" name="mastersiswa_file" class="form-control" id="mastersiswa_file" 
                    required accept=".xls, .xlsx" /></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success unduhmastersiswa">Unduh template</a>
                <button type="submit" class="btn btn-primary">Upload File</button>
            </div>
        </form>
        <!-- Handle FORM -->
        </div>
    </div>
</div>