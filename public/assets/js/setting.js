//Datatables server side
$(document).ready( function () {
    var url = '/settingcontroller/ajax_list';
    var table = $('#datatable-setting').DataTable({ 
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
    $('.formModaltambahsetting').submit(function(e) {
        e.preventDefault();

        let data = new FormData(this);

        $('.setting_isactive').each(function() {
            if ($(this).is(":checked"))
            {
                // alert(1);
                data.append('setting_isactive', 1);
            }
            else
            {
                // alert(0);
                data.append('setting_isactive', 0);
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
                $('.btnmodaltambahsetting').prop('disabled', true);
                $('.btnmodaltambahsetting').html('<i class="fa fa-spin fa-spinner"></i> Processing');
            },
            complete: function() {
                $('.btnmodaltambahsetting').prop('disabled', false);
                $('.btnmodaltambahsetting').html('Simpan');
            },
            success: function(response) {
                if (response.error){
                    
                }
                else
                {
                    $('#modaltambahsetting').modal('hide');

                    Swal.fire(
                        'Pemberitahuan',
                        response.success.data,
                        'success',
                    ).then(function() {
                        $('#setting_isactive').prop("checked", false);
                        $('#datatable-setting').DataTable().ajax.reload();
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
function editsetting($kode) {
    var url = "/settingcontroller/pilihdata";
    $.ajax({
        url: BASE_URL + url,
        type: "post",
        data: {
            kode: $kode,
        },
        dataType: "JSON",
        success: function(response) {
            $('#setting_kodeubah').val(response.success.inc);
            $('#setting_levelubah').val(response.success.kode);
            $('#setting_menuubah').val(response.success.menu);

            if (response.success.status == 1)
            {
                $('#setting_isactiveubah').prop("checked", true);
            }
            else
            {
                $('#setting_isactiveubah').prop("checked", false);
            }

            $('#modalubahsetting').modal('show');
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
}

//Fungsi modal update
$(document).ready(function() {
    $('.formModalubahsetting').submit(function(e) {
        e.preventDefault();

        let data = new FormData(this);

        $('.setting_isactiveubah').each(function() {
            if ($(this).is(":checked"))
            {
                // alert(1);
                data.append('setting_isactiveubah', 1);
            }
            else
            {
                // alert(0);
                data.append('setting_isactiveubah', 0);
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
                $('.btnmodalubahsetting').prop('disabled', true);
                $('.btnmodalubahsetting').html('<i class="fa fa-spin fa-spinner"></i> Processing');
            },
            complete: function() {
                $('.btnmodalubahsetting').prop('disabled', false);
                $('.btnmodalubahsetting').html('Ubah');
            },
            success: function(response) {
                if (response.error){
                    
                }
                else
                {
                    $('#modalubahsetting').modal('hide');

                    Swal.fire(
                        'Pemberitahuan',
                        response.success.data,
                        'success',
                    ).then(function() {
                        $('#datatable-setting').DataTable().ajax.reload();
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
function deletesetting($kode) {
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
            var url =  '/settingcontroller/hapusdata';

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
                            $('#datatable-setting').DataTable().ajax.reload();
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