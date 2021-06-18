//Fungsi modal update
$(document).ready(function() {
    $('.formsettingwa').submit(function(e) {
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
                $('.btnsettingwa').prop('disabled', true);
                $('.btnsettingwa').html('<i class="fa fa-spin fa-spinner"></i> Processing');
            },
            complete: function() {
                $('.btnsettingwa').prop('disabled', false);
                $('.btnsettingwa').html('Ubah');
            },
            success: function(response) {
                if (response.error){
                    if (response.error.settingwa_instance){
                        $('#settingwa_instance').addClass('is-invalid');
                        $('.errorsettingwaInstance').html(response.error.settingwa_instance);
                    }
                    else
                    {
                        $('#settingwa_instance').removeClass('is-invalid');
                        $('.errorsettingwaInstance').html('');
                    }

                    if (response.error.settingwa_token){
                        $('#settingwa_token').addClass('is-invalid');
                        $('.errorsettingwaToken').html(response.error.settingwa_token);
                    }
                    else
                    {
                        $('#settingwa_token').removeClass('is-invalid');
                        $('.errorsettingwaToken').html('');
                    }
                }
                else
                {
                    Swal.fire(
                        'Pemberitahuan',
                        response.success.data,
                        'success',
                    ).then(function() {
                        // $('#datatable-user').DataTable().ajax.reload();
                        window.location = response.success.link;
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