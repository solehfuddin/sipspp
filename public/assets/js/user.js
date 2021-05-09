//Datatables server side
$(document).ready( function () {
    var url = '/usercontroller/ajax_list';
    var table = $('#datatable-user').DataTable({ 
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
function generatekodeuser() {
    var url = "/usercontroller/getdata";
    $.ajax({
        url: BASE_URL + url,
        dataType: "JSON",
        success: function(response) {
            $('#user_kode').val(response.kodegen);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
}

//Fungsi modal add data
$(document).ready(function() {
    $('.formModaltambahuser').submit(function(e) {
        e.preventDefault();

        let data = new FormData(this);

        $('.user_isactive').each(function() {
            if ($(this).is(":checked"))
            {
                // alert(1);
                data.append('user_isactive', 1);
            }
            else
            {
                // alert(0);
                data.append('user_isactive', 0);
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
                $('.btnmodaltambahuser').prop('disabled', true);
                $('.btnmodaltambahuser').html('<i class="fa fa-spin fa-spinner"></i> Processing');
            },
            complete: function() {
                $('.btnmodaltambahuser').prop('disabled', false);
                $('.btnmodaltambahuser').html('Simpan');
            },
            success: function(response) {
                if (response.error){
                    if (response.error.user_fname){
                        $('#user_fname').addClass('is-invalid');
                        $('.erroruserFname').html(response.error.user_fname);
                    }
                    else
                    {
                        $('#user_fname').removeClass('is-invalid');
                        $('.erroruserFname').html('');
                    }

                    if (response.error.user_uname){
                        $('#user_uname').addClass('is-invalid');
                        $('.erroruserUname').html(response.error.user_uname);
                    }
                    else
                    {
                        $('#user_uname').removeClass('is-invalid');
                        $('.erroruserUname').html('');
                    }

                    if (response.error.user_pass){
                        $('#user_pass').addClass('is-invalid');
                        $('.erroruserPass').html(response.error.user_pass);
                    }
                    else
                    {
                        $('#user_pass').removeClass('is-invalid');
                        $('.erroruserPass').html('');
                    }

                    if (response.error.user_email){
                        $('#user_email').addClass('is-invalid');
                        $('.erroruserEmail').html(response.error.user_email);
                    }
                    else
                    {
                        $('#user_email').removeClass('is-invalid');
                        $('.erroruserEmail').html('');
                    }

                    if (response.error.user_photo){
                        $('#user_photo').addClass('is-invalid');
                        $('.erroruserPhoto').html(response.error.user_photo);
                    }
                    else
                    {
                        $('#user_photo').removeClass('is-invalid');
                        $('.erroruserPhoto').html('');
                    }
                }
                else
                {
                    $('#modaltambahuser').modal('hide');

                    Swal.fire(
                        'Pemberitahuan',
                        response.success.data,
                        'success',
                    ).then(function() {
                        $('#user_fname').val('');
                        $('#user_uname').val('');
                        $('#user_pass').val('');
                        $('#user_email').val('');
                        $('#user_phone').val('');
                        $('#user_photo').val('');
                        $('#user_address').val('');
                        $('#user_isactive').prop("checked", false);
                        $('#datatable-user').DataTable().ajax.reload();
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
function deleteuser($kode) {
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
            var url =  '/usercontroller/hapusdata';

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
                            $('#datatable-user').DataTable().ajax.reload();
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