// Handle Form Login
$(document).ready(function() {
    $('.formLogin').submit(function(e) {
        e.preventDefault();

        $.ajax({
            type: "post",
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: "json",
            beforeSend: function() {
                $('.btnLogin').prop('disabled', true);
                $('.btnLogin').html('<i class="fa fa-spin fa-spinner"></i> Processing');
            },
            complete: function() {
                $('.btnLogin').prop('disabled', false);
                $('.btnLogin').html('Login');
            },
            success: function(response) {
                if (response.error){
                    if (response.error.emailaddr){
                        $('#emailaddr').addClass('is-invalid');
                        $('.errorEmailAddr').html(response.error.emailaddr);
                    }
                    else
                    {
                        $('#emailaddr').removeClass('is-invalid');
                        $('.errorEmailAddr').html('');
                    }

                    if (response.error.pass){
                        $('#pass').addClass('is-invalid');
                        $('.errorPass').html(response.error.pass);
                    }
                    else
                    {
                        $('#pass').removeClass('is-invalid');
                        $('.errorPass').html('');
                    }

                    if (response.error.errorauth)
                    {
                        Swal.fire(
                            'Pemberitahuan',
                            response.error.errorauth,
                            'warning',
                        );
                    }
                }
                else
                {
                    window.location = response.success.link;
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });

        return false;
    })
});

//Handle format rupiah
function formatRupiah(angka, prefix){
    var number_str  = angka.replace(/[^,\d]/g, '').toString(),
    split = number_str.split(','),
    sisa  = split[0].length % 3,
    rupiah= split[0].substr(0, sisa),
    ribuan= split[0].substr(sisa).match(/\d{3}/gi);

    //Tambah titik ribuan
    if (ribuan){
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
}

function formatAngka(rupiah){
    return parseInt(rupiah.replace(/,.*|[^0-9]/g, ''), 10);
}