//Datatables server side
$(document).ready( function () {
    var url = '/siswacontroller/ajax_list';
    var table = $('#datatable-siswa').DataTable({ 
      "processing": true,
      "serverSide": true,
      "order": [],
      "ajax": {
          "url": BASE_URL + url,
          "type": "POST"
      },
      //optional
      "lengthMenu": [10, 25, 50, 100, 250, 500],
      "columnDefs": [
        { 
            "targets": [],
            "orderable": false,
        },
      ],
      "language": {
        "paginate": 
        {
            "previous": "<i class='fas fa-angle-left'>",
            "next": "<i class='fas fa-angle-right'>"
        }
    }
    });
});

//Fungsi modal add data
$(document).ready(function() {
    $('.formModaltambahsiswa').submit(function(e) {
        e.preventDefault();

        let data = new FormData(this);

        $.ajax({
            type: "post",
            url: $(this).attr('action'),
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            cache: false,
            data: data,
            dataType: "json",
            beforeSend: function() {
                $('.btnmodaltambahsiswa').prop('disabled', true);
                $('.btnmodaltambahsiswa').html('<i class="fa fa-spin fa-spinner"></i> Processing');
            },
            complete: function() {
                $('.btnmodaltambahsiswa').prop('disabled', false);
                $('.btnmodaltambahsiswa').html('Simpan');
            },
            success: function(response) {
                if (response.error){
                    if (response.error.siswa_nis){
                        $('#siswa_nis').addClass('is-invalid');
                        $('.errorsiswaNis').html(response.error.siswa_nis);
                    }
                    else
                    {
                        $('#siswa_nis').removeClass('is-invalid');
                        $('.errorsiswaNis').html('');
                    }

                    if (response.error.siswa_name){
                        $('#siswa_name').addClass('is-invalid');
                        $('.errorsiswaName').html(response.error.siswa_name);
                    }
                    else
                    {
                        $('#siswa_name').removeClass('is-invalid');
                        $('.errorsiswaName').html('');
                    }

                    if (response.error.siswa_photo){
                        $('#siswa_photo').addClass('is-invalid');
                        $('.errorsiswaPhoto').html(response.error.siswa_photo);
                    }
                    else
                    {
                        $('#siswa_photo').removeClass('is-invalid');
                        $('.errorsiswaPhoto').html('');
                    }
                }
                else
                {
                    $('#modaltambahsiswa').modal('hide');

                    Swal.fire(
                        'Pemberitahuan',
                        response.success.data,
                        'success',
                    ).then(function() {
                        $('#siswa_nis').val('');
                        $('#siswa_name').val('');
                        $('#siswa_place').val('');
                        $('#siswa_phone').val('');
                        $('#siswa_photo').val('');
                        $('#datatable-siswa').DataTable().ajax.reload();
                    });
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });
});

//Fungsi select data 
function editsiswa($kode) {
    var url = "/siswacontroller/pilihdata";
    $.ajax({
        url: BASE_URL + url,
        type: "post",
        data: {
            kode: $kode,
        },
        dataType: "JSON",
        success: function(response) {
            $('#siswa_nisubah').val(response.success.kode);
            $('#siswa_nameubah').val(response.success.name);
            $('#siswa_placeubah').val(response.success.place);
            $('#siswa_bornubah').val(response.success.born);
            $('#siswa_classubah').val(response.success.class);
            $('#siswa_genderubah').val(response.success.gender);
            $('#siswa_phoneubah').val(response.success.hp);
            $('#siswa_religionubah').val(response.success.agama);
            $('#siswa_addressubah').val(response.success.alamat);
            $('#siswa_photoubah').val('');

            $('#siswa_nameubah').removeClass('is-invalid');
            $('.errorsiswaNameubah').html('');

            $('#siswa_photoubah').removeClass('is-invalid');
            $('.errorsiswaPhotoubah').html('');

            $('#modalubahsiswa').modal('show');
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
}

//Fungsi modal update
$(document).ready(function() {
    $('.formModalubahsiswa').submit(function(e) {
        e.preventDefault();

        let data = new FormData(this);

        $.ajax({
            type: "post",
            url: $(this).attr('action'),
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            cache: false,
            data: data,
            dataType: "json",
            beforeSend: function() {
                $('.btnmodalubahsiswa').prop('disabled', true);
                $('.btnmodalubahsiswa').html('<i class="fa fa-spin fa-spinner"></i> Processing');
            },
            complete: function() {
                $('.btnmodalubahsiswa').prop('disabled', false);
                $('.btnmodalubahsiswa').html('Ubah');
            },
            success: function(response) {
                if (response.error){
                    if (response.error.siswa_nameubah){
                        $('#siswa_nameubah').addClass('is-invalid');
                        $('.errorsiswaNameubah').html(response.error.siswa_nameubah);
                    }
                    else
                    {
                        $('#siswa_nameubah').removeClass('is-invalid');
                        $('.errorsiswaNameubah').html('');
                    }

                    if (response.error.siswa_photoubah){
                        $('#siswa_photoubah').addClass('is-invalid');
                        $('.errorsiswaPhotoubah').html(response.error.siswa_photoubah);
                    }
                    else
                    {
                        $('#siswa_photoubah').removeClass('is-invalid');
                        $('.errorsiswaPhotoubah').html('');
                    }
                }
                else
                {
                    $('#modalubahsiswa').modal('hide');

                    Swal.fire(
                        'Pemberitahuan',
                        response.success.data,
                        'success',
                    ).then(function() {
                        $('#datatable-siswa').DataTable().ajax.reload();
                    });
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });

        return false;
    });
});

// Handle Modal hapus
function deletesiswa($kode) {
    Swal.fire({
        title: 'Apakah anda yakin?',
        text: 'Data akan terhapus permanen dari sistem',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batal'
    }).then(function(result) {
        if (result.value)
        {
            var url =  '/siswacontroller/hapusdata';

            $.ajax({
                type: "post",
                url: BASE_URL + url,
                data: {
                    kode: $kode,
                },
                dataType: "json",
                success: function(response) {
                    if (response.success){
                        Swal.fire(
                            'Pemberitahuan',
                            response.success.data,
                            'success',
                        ).then(function() {
                            $('#datatable-siswa').DataTable().ajax.reload();
                        });
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        }
        else if (result.dismiss == 'batal')
        {
            swal.dismiss();
        }
    });
}

//download template excel
$(".unduhmastersiswa").click(function() {
    // // hope the server sets Content-Disposition: attachment!
    var url = '/public//doc/template_mreferal.xlsx';
    window.location = BASE_URL + url;
  });