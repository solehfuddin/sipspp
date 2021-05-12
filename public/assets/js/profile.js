//Fungsi modal update
$(document).ready(function() {
    $('.formubahprofile').submit(function(e) {
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
                $('.btnubahprofile').prop('disabled', true);
                $('.btnubahprofile').html('<i class="fa fa-spin fa-spinner"></i> Processing');
            },
            complete: function() {
                $('.btnubahprofile').prop('disabled', false);
                $('.btnubahprofile').html('Ubah');
            },
            success: function(response) {
                if (response.error){
                    if (response.error.profile_fname){
                        $('#profile_fname').addClass('is-invalid');
                        $('.errorprofileFname').html(response.error.profile_fname);
                    }
                    else
                    {
                        $('#profile_fname').removeClass('is-invalid');
                        $('.errorprofileFname').html('');
                    }

                    if (response.error.profile_photo){
                        $('#profile_photo').addClass('is-invalid');
                        $('.errorprofilePhoto').html(response.error.profile_photo);
                    }
                    else
                    {
                        $('#profile_photo').removeClass('is-invalid');
                        $('.errorprofilePhoto').html('');
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