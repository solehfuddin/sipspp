//Datatables server side
$(document).ready( function () {
    var url = '/master/levelcontroller/ajax_list';
    var table = $('#datatable-masterlevel').DataTable({ 
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

//Fungsi generate kode
function generatekodemasterlevel() {
    var url = "/master/levelcontroller/getdata";
    $.ajax({
        url: BASE_URL + url,
        dataType: "JSON",
        success: function(response) {
            $('#masterlevel_kode').val(response.kodegen);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
}

//Fungsi modal add data
$(document).ready(function() {
    $('.formModaltambahmasterlevel').submit(function(e) {
        e.preventDefault();

        let data = new FormData(this);

        $('.masterlevel_isactive').each(function() {
            if ($(this).is(":checked"))
            {
                // alert(1);
                data.append('masterlevel_isactive', 1);
            }
            else
            {
                // alert(0);
                data.append('masterlevel_isactive', 0);
            }
        });

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
                $('.btnmodaltambahmasterlevel').prop('disabled', true);
                $('.btnmodaltambahmasterlevel').html('<i class="fa fa-spin fa-spinner"></i> Processing');
            },
            complete: function() {
                $('.btnmodaltambahmasterlevel').prop('disabled', false);
                $('.btnmodaltambahmasterlevel').html('Simpan');
            },
            success: function(response) {
                if (response.error){
                    if (response.error.masterlevel_kode){
                        $('#masterlevel_kode').addClass('is-invalid');
                        $('.errormasterlevelKode').html(response.error.masterlevel_kode);
                    }
                    else
                    {
                        $('#masterlevel_kode').removeClass('is-invalid');
                        $('.errormasterlevelKode').html('');
                    }

                    if (response.error.masterlevel_nama){
                        $('#masterlevel_nama').addClass('is-invalid');
                        $('.errormasterlevelNama').html(response.error.masterlevel_nama);
                    }
                    else
                    {
                        $('#masterlevel_nama').removeClass('is-invalid');
                        $('.errormasterlevelNama').html('');
                    }

                    if (response.error.masterlevel_desc){
                        $('#masterlevel_desc').addClass('is-invalid');
                        $('.errormasterlevelDesc').html(response.error.masterlevel_desc);
                    }
                    else
                    {
                        $('#masterlevel_desc').removeClass('is-invalid');
                        $('.errormasterlevelDesc').html('');
                    }
                }
                else
                {
                    $('#modaltambahmasterlevel').modal('hide');

                    Swal.fire(
                        'Pemberitahuan',
                        response.success.data,
                        'success',
                    ).then(function() {
                        $('#masterlevel_kode').val('');
                        $('#masterlevel_nama').val('');
                        $('#masterlevel_desc').val('');
                        $('#masterlevel_isactive').prop("checked", false);
                        $('#datatable-masterlevel').DataTable().ajax.reload();
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
function editmasterlevel($kode) {
    var url = "/master/levelcontroller/pilihdata";
    $.ajax({
        url: BASE_URL + url,
        type: "post",
        data: {
            kode: $kode,
        },
        dataType: "JSON",
        success: function(response) {
            $('#masterlevel_kodeubah').val(response.success.kode);
            $('#masterlevel_namaubah').val(response.success.nama);
            $('#masterlevel_descubah').val(response.success.deskripsi);

            if (response.success.is_active == 1)
            {
                $('#masterlevel_isactiveubah').prop("checked", true);
            }
            else
            {
                $('#masterlevel_isactiveubah').prop("checked", false);
            }

            $('#masterlevel_namaubah').removeClass('is-invalid');
            $('.errormasterlevelNamaubah').html('');

            $('#masterlevel_descubah').removeClass('is-invalid');
            $('.errormasterlevelDescubah').html('');

            $('#modalubahmasterlevel').modal('show');
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
}

//Fungsi modal update gambar
$(document).ready(function() {
    $('.formModalubahmasterlevel').submit(function(e) {
        e.preventDefault();

        let data = new FormData(this);

        $('.masterlevel_isactiveubah').each(function() {
            if ($(this).is(":checked"))
            {
                // alert(1);
                data.append('masterlevel_isactiveubah', 1);
            }
            else
            {
                // alert(0);
                data.append('masterlevel_isactiveubah', 0);
            }
        });

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
                $('.btnmodalubahmasterlevel').prop('disabled', true);
                $('.btnmodalubahmasterlevel').html('<i class="fa fa-spin fa-spinner"></i> Processing');
            },
            complete: function() {
                $('.btnmodalubahmasterlevel').prop('disabled', false);
                $('.btnmodalubahmasterlevel').html('Ubah');
            },
            success: function(response) {
                if (response.error){
                    if (response.error.masterlevel_namaubah){
                        $('#masterlevel_namaubah').addClass('is-invalid');
                        $('.errormasterlevelNamaubah').html(response.error.masterlevel_namaubah);
                    }
                    else
                    {
                        $('#masterlevel_namaubah').removeClass('is-invalid');
                        $('.errormasterlevelNamaubah').html('');
                    }

                    if (response.error.masterlevel_descubah){
                        $('#masterlevel_descubah').addClass('is-invalid');
                        $('.errormasterlevelDescubah').html(response.error.masterlevel_descubah);
                    }
                    else
                    {
                        $('#masterlevel_descubah').removeClass('is-invalid');
                        $('.errormasterlevelDescubah').html('');
                    }
                }
                else
                {
                    $('#modalubahmasterlevel').modal('hide');

                    Swal.fire(
                        'Pemberitahuan',
                        response.success.data,
                        'success',
                    ).then(function() {
                        $('#datatable-masterlevel').DataTable().ajax.reload();
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
function deletemasterlevel($kode) {
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
            var url =  '/master/levelcontroller/hapusdata';

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
                            $('#datatable-masterlevel').DataTable().ajax.reload();
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