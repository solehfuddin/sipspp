//Datatables server side
$(document).ready( function () {
    var url = '/master/kelascontroller/ajax_list';
    var table = $('#datatable-masterkelas').DataTable({ 
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
function generatekodemasterkelas() {
    var url = "/master/kelascontroller/getdata";
    $.ajax({
        url: BASE_URL + url,
        dataType: "JSON",
        success: function(response) {
            $('#masterkelas_kode').val(response.kodegen);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
}

//Fungsi modal add data
$(document).ready(function() {
    $('.formModaltambahmasterkelas').submit(function(e) {
        e.preventDefault();

        let data = new FormData(this);

        $('.masterkelas_isactive').each(function() {
            if ($(this).is(":checked"))
            {
                // alert(1);
                data.append('masterkelas_isactive', 1);
            }
            else
            {
                // alert(0);
                data.append('masterkelas_isactive', 0);
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
                $('.btnmodaltambahmasterkelas').prop('disabled', true);
                $('.btnmodaltambahmasterkelas').html('<i class="fa fa-spin fa-spinner"></i> Processing');
            },
            complete: function() {
                $('.btnmodaltambahmasterkelas').prop('disabled', false);
                $('.btnmodaltambahmasterkelas').html('Simpan');
            },
            success: function(response) {
                if (response.error){
                    if (response.error.masterkelas_kode){
                        $('#masterkelas_kode').addClass('is-invalid');
                        $('.errormasterkelasKode').html(response.error.masterkelas_kode);
                    }
                    else
                    {
                        $('#masterkelas_kode').removeClass('is-invalid');
                        $('.errormasterkelasKode').html('');
                    }

                    if (response.error.masterkelas_nama){
                        $('#masterkelas_nama').addClass('is-invalid');
                        $('.errormasterkelasaNama').html(response.error.masterkelas_nama);
                    }
                    else
                    {
                        $('#masterkelas_nama').removeClass('is-invalid');
                        $('.errormasterkelasaNama').html('');
                    }

                    if (response.error.masterkelas_desc){
                        $('#masterkelas_desc').addClass('is-invalid');
                        $('.errormasterkelasDesc').html(response.error.masterkelas_desc);
                    }
                    else
                    {
                        $('#masterkelas_desc').removeClass('is-invalid');
                        $('.errormasterkelasDesc').html('');
                    }
                }
                else
                {
                    $('#modaltambahmasterkelas').modal('hide');

                    Swal.fire(
                        'Pemberitahuan',
                        response.success.data,
                        'success',
                    ).then(function() {
                        $('#masterkelas_kode').val('');
                        $('#masterkelas_nama').val('');
                        $('#masterkelas_desc').val('');
                        $('#masterkelas_isactive').prop("checked", false);
                        $('#datatable-masterkelas').DataTable().ajax.reload();
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
function editmasterkelas($kode) {
    var url = "/master/kelascontroller/pilihdata";
    $.ajax({
        url: BASE_URL + url,
        type: "post",
        data: {
            kode: $kode,
        },
        dataType: "JSON",
        success: function(response) {
            $('#masterkelas_kodeubah').val(response.success.kode);
            $('#masterkelas_namaubah').val(response.success.nama);
            $('#masterkelas_descubah').val(response.success.deskripsi);

            if (response.success.is_active == 1)
            {
                $('#masterkelas_isactiveubah').prop("checked", true);
            }
            else
            {
                $('#masterkelas_isactiveubah').prop("checked", false);
            }

            $('#masterkelas_namaubah').removeClass('is-invalid');
            $('.errormasterkelasNamaubah').html('');

            $('#masterkelas_descubah').removeClass('is-invalid');
            $('.errormasterkelasDescubah').html('');

            $('#modalubahmasterkelas').modal('show');
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
}

//Fungsi modal update gambar
$(document).ready(function() {
    $('.formModalubahmasterkelas').submit(function(e) {
        e.preventDefault();

        let data = new FormData(this);

        $('.masterkelas_isactiveubah').each(function() {
            if ($(this).is(":checked"))
            {
                // alert(1);
                data.append('masterkelas_isactiveubah', 1);
            }
            else
            {
                // alert(0);
                data.append('masterkelas_isactiveubah', 0);
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
                $('.btnmodalubahmasterkelas').prop('disabled', true);
                $('.btnmodalubahmasterkelas').html('<i class="fa fa-spin fa-spinner"></i> Processing');
            },
            complete: function() {
                $('.btnmodalubahmasterkelas').prop('disabled', false);
                $('.btnmodalubahmasterkelas').html('Ubah');
            },
            success: function(response) {
                if (response.error){
                    if (response.error.masterkelas_namaubah){
                        $('#masterkelas_namaubah').addClass('is-invalid');
                        $('.errormasterkelasNamaubah').html(response.error.masterkelas_namaubah);
                    }
                    else
                    {
                        $('#masterkelas_namaubah').removeClass('is-invalid');
                        $('.errormasterkelasNamaubah').html('');
                    }

                    if (response.error.masterkelas_descubah){
                        $('#masterkelas_descubah').addClass('is-invalid');
                        $('.errormasterkelasDescubah').html(response.error.masterkelas_descubah);
                    }
                    else
                    {
                        $('#masterkelas_descubah').removeClass('is-invalid');
                        $('.errormasterkelasDescubah').html('');
                    }
                }
                else
                {
                    $('#modalubahmasterkelas').modal('hide');

                    Swal.fire(
                        'Pemberitahuan',
                        response.success.data,
                        'success',
                    ).then(function() {
                        $('#datatable-masterkelas').DataTable().ajax.reload();
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
function deletemasterkelas($kode) {
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
            var url =  '/master/kelascontroller/hapusdata';

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
                            $('#datatable-masterkelas').DataTable().ajax.reload();
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