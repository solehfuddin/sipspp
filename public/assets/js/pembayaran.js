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

var biaya = document.getElementById('pembayaran_biaya');
var tmpbiaya = document.getElementById('pembayaran_biayatmp');
biaya.addEventListener('keyup', function(e){
    // tambahkan 'Rp.' pada saat form di ketik
    // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
    biaya.value = formatRupiah(this.value, 'Rp. ');
    tmpbiaya.value = convertToAngka(this.value);
});


$(document).ready(function(){
    // Initialize
    $( "#pembayaran_search").autocomplete({

       source: function( request, response ) {

          // Fetch data
          $.ajax({
             url: BASE_URL + "/pembayarancontroller/getSiswa",
             type: 'post',
             dataType: "json",
             data: {
                search: request.term,
             },
             success: function( data ) {
                response( data.data );
             }
          });
       },
       select: function (event, ui) {
          // Set selection
          $('#pembayaran_search').val(ui.item.label); // display the selected text
          $('#pembayaran_nis').val(ui.item.value); // save selected id to input
          return false;
       },
       focus: function(event, ui){
         $( "#pembayaran_search" ).val( ui.item.label );
         $( "#pembayaran_nis" ).val( ui.item.value );
         return false;
       },
     }); 
  }); 
  

/* Fungsi formatRupiah */
function formatRupiah(angka, prefix){
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
    split   		= number_string.split(','),
    sisa     		= split[0].length % 3,
    rupiah     		= split[0].substr(0, sisa),
    ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if(ribuan){
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
}

// Kembalikan rupiah
function convertToAngka(rupiah)
{
	return parseInt(rupiah.replace(/,.*|[^0-9]/g, ''), 10);
}

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
    $('.formModaltambahpembayaran').submit(function(e) {
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
                $('.btnmodaltambahpembayaran').prop('disabled', true);
                $('.btnmodaltambahpembayaran').html('<i class="fa fa-spin fa-spinner"></i> Processing');
            },
            complete: function() {
                $('.btnmodaltambahpembayaran').prop('disabled', false);
                $('.btnmodaltambahpembayaran').html('Simpan');
            },
            success: function(response) {
                if (response.error){
                    if (response.error.pembayaran_nis){
                        $('#pembayaran_nis').addClass('is-invalid');
                        $('.errorpembayaranNis').html(response.error.pembayaran_nis);
                    }
                    else
                    {
                        $('#pembayaran_nis').removeClass('is-invalid');
                        $('.errorpembayaranNis').html('');
                    }

                    if (response.error.pembayaran_biaya){
                        $('#pembayaran_biaya').addClass('is-invalid');
                        $('.errorpembayaranBiaya').html(response.error.pembayaran_biaya);
                    }
                    else
                    {
                        $('#pembayaran_biaya').removeClass('is-invalid');
                        $('.errorpembayaranBiaya').html('');
                    }
                }
                else
                {
                    $('#modaltambahpembayaran').modal('hide');

                    Swal.fire(
                        'Pemberitahuan',
                        response.success.data,
                        'success',
                    ).then(function() {
                        $('#pembayaran_search').val('');
                        $('#pembayaran_nis').val('');
                        $('#pembayaran_biaya').val('');
                        $('#datatable-pembayaran').DataTable().ajax.reload();
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