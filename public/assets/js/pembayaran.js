//Datatables server side
$(document).ready( function () {
    var url = '/pembayarancontroller/ajax_list';
    var table = $('#datatable-pembayaran').DataTable({ 
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
function generatekodepembayaran() {
    var url = "/pembayarancontroller/getdata";
    $.ajax({
        url: BASE_URL + url,
        dataType: "JSON",
        success: function(response) {
            $('#pembayaran_kode').val(response.kodegen);
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
function edituser($kode) {
    var url = "/usercontroller/pilihdata";
    $.ajax({
        url: BASE_URL + url,
        type: "post",
        data: {
            kode: $kode,
        },
        dataType: "JSON",
        success: function(response) {
            $('#user_kodeubah').val(response.success.kode);
            $('#user_fnameubah').val(response.success.fname);
            $('#user_levelubah').val(response.success.level);
            $('#user_unameubah').val(response.success.uname);
            $('#user_genderubah').val(response.success.gender);
            $('#user_emailubah').val(response.success.email);
            $('#user_phoneubah').val(response.success.hp);
            $('#user_religionubah').val(response.success.agama);
            $('#user_addressubah').val(response.success.alamat);
            $('#user_photoubah').val('');

            if (response.success.is_active == 1)
            {
                $('#user_isactiveubah').prop("checked", true);
            }
            else
            {
                $('#user_isactiveubah').prop("checked", false);
            }

            $('#user_fnameubah').removeClass('is-invalid');
            $('.erroruserFnameubah').html('');

            $('#user_photoubah').removeClass('is-invalid');
            $('.erroruserPhotoubah').html('');

            $('#modalubahuser').modal('show');
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
}