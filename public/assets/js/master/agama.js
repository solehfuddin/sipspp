//Datatables server side
$(document).ready( function () {
    var url = '/master/agamacontroller/ajax_list';
    var table = $('#datatable-masteragama').DataTable({ 
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
function generatekodemasteragama() {
    var url = "/master/agamacontroller/getdata";
    $.ajax({
        url: BASE_URL + url,
        dataType: "JSON",
        success: function(response) {
            $('#masteragama_kode').val(response.kodegen);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
}

//Fungsi modal add data
$(document).ready(function() {
    $('.formModaltambahmasteragama').submit(function(e) {
        e.preventDefault();

        let data = new FormData(this);

        $('.masteragama_isactive').each(function() {
            if ($(this).is(":checked"))
            {
                // alert(1);
                data.append('masteragama_isactive', 1);
            }
            else
            {
                // alert(0);
                data.append('masteragama_isactive', 0);
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
                $('.btnmodaltambahmasteragama').prop('disabled', true);
                $('.btnmodaltambahmasteragama').html('<i class="fa fa-spin fa-spinner"></i> Processing');
            },
            complete: function() {
                $('.btnmodaltambahmasteragama').prop('disabled', false);
                $('.btnmodaltambahmasteragama').html('Simpan');
            },
            success: function(response) {
                if (response.error){
                    if (response.error.masteragama_kode){
                        $('#featuresjenistsakti_kode').addClass('is-invalid');
                        $('.errormasteragamaKode').html(response.error.masteragama_kode);
                    }
                    else
                    {
                        $('#masteragama_kode').removeClass('is-invalid');
                        $('.errormasteragamaKode').html('');
                    }

                    if (response.error.masteragama_nama){
                        $('#masteragama_nama').addClass('is-invalid');
                        $('.errormasteragamaNama').html(response.error.masteragama_nama);
                    }
                    else
                    {
                        $('#masteragama_nama').removeClass('is-invalid');
                        $('.errormasteragamaNama').html('');
                    }

                    if (response.error.masteragama_desc){
                        $('#masteragama_desc').addClass('is-invalid');
                        $('.errormasteragamaDesc').html(response.error.masteragama_desc);
                    }
                    else
                    {
                        $('#masteragama_desc').removeClass('is-invalid');
                        $('.errormasteragamaDesc').html('');
                    }
                }
                else
                {
                    $('#modaltambahmasteragama').modal('hide');

                    Swal.fire(
                        'Pemberitahuan',
                        response.success.data,
                        'success',
                    ).then(function() {
                        $('#masteragama_kode').val('');
                        $('#masteragama_nama').val('');
                        $('#masteragama_desc').val('');
                        $('#masteragama_isactive').prop("checked", false);
                        $('#datatable-masteragama').DataTable().ajax.reload();
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
function editmasteragama($kode) {
    var url = "/master/agamacontroller/pilihdata";
    $.ajax({
        url: BASE_URL + url,
        type: "post",
        data: {
            kode: $kode,
        },
        dataType: "JSON",
        success: function(response) {
            $('#masteragama_kodeubah').val(response.success.kode);
            $('#masteragama_namaubah').val(response.success.nama);
            $('#masteragama_descubah').val(response.success.deskripsi);

            if (response.success.is_active == 1)
            {
                $('#masteragama_isactiveubah').prop("checked", true);
            }
            else
            {
                $('#masteragama_isactiveubah').prop("checked", false);
            }

            $('#masteragama_namaubah').removeClass('is-invalid');
            $('.errormasteragamaNamaubah').html('');

            $('#masteragama_descubah').removeClass('is-invalid');
            $('.errormasteragamaDescubah').html('');

            $('#modalubahmasteragama').modal('show');
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
}

//Fungsi modal update gambar
$(document).ready(function() {
    $('.formModalubahmasteragama').submit(function(e) {
        e.preventDefault();

        let data = new FormData(this);

        $('.masteragama_isactiveubah').each(function() {
            if ($(this).is(":checked"))
            {
                // alert(1);
                data.append('masteragama_isactiveubah', 1);
            }
            else
            {
                // alert(0);
                data.append('masteragama_isactiveubah', 0);
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
                $('.btnmodalubahmasteragama').prop('disabled', true);
                $('.btnmodalubahmasteragama').html('<i class="fa fa-spin fa-spinner"></i> Processing');
            },
            complete: function() {
                $('.btnmodalubahmasteragama').prop('disabled', false);
                $('.btnmodalubahmasteragama').html('Ubah');
            },
            success: function(response) {
                if (response.error){
                    if (response.error.masteragama_namaubah){
                        $('#masteragama_namaubah').addClass('is-invalid');
                        $('.errormasteragamaNamaubah').html(response.error.masteragama_namaubah);
                    }
                    else
                    {
                        $('#masteragama_namaubah').removeClass('is-invalid');
                        $('.errormasteragamaNamaubah').html('');
                    }

                    if (response.error.masteragama_descubah){
                        $('#masteragama_descubah').addClass('is-invalid');
                        $('.errormasteragamaDescubah').html(response.error.masteragama_descubah);
                    }
                    else
                    {
                        $('#masteragama_descubah').removeClass('is-invalid');
                        $('.errormasteragamaDescubah').html('');
                    }
                }
                else
                {
                    $('#modalubahmasteragama').modal('hide');

                    Swal.fire(
                        'Pemberitahuan',
                        response.success.data,
                        'success',
                    ).then(function() {
                        $('#datatable-masteragama').DataTable().ajax.reload();
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
function deletemasteragama($kode) {
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
            var url =  '/master/agamacontroller/hapusdata';

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
                            $('#datatable-masteragama').DataTable().ajax.reload();
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