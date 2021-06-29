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

//Function broadcast
function broadcastWa(){
    // alert("ok");
    var from = document.getElementById('tunggakan_filterstdate').value;
    var until = document.getElementById('tunggakan_filtereddate').value;

    var url = "/tunggakancontroller/broadcast";
    $.ajax({
        url: BASE_URL + url,
        type: "post",
        data: {
            from: from,
            until: until
        },
        dataType: "JSON",
        success: function(response) {
            Swal.fire(
                'Pemberitahuan',
                response.success.data,
                'success',
            );
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
function cetakKwitansi($kode) {
    var url = "/pembayarancontroller/cetakresi";
    $.ajax({
        url: BASE_URL + url,
        type: "post",
        data: {
            kode: $kode,
        },
        dataType: "JSON",
        success: function(response) {
           
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
}

//Fungsi select data 
function kirimSms($kode) {
    var url = "/pembayarancontroller/reviewsms";
    $.ajax({
        url: BASE_URL + url,
        type: "post",
        data: {
            kode: $kode,
        },
        dataType: "JSON",
        success: function(response) {
            $('#antriansms_kodeubah').val(response.success.kode);
            $('#antriansms_nohpubah').val(response.success.nohp);
            $('#antriansms_pesanubah').val(response.success.pesan);

            $('#antriansms_nohpubah').removeClass('is-invalid');
            $('.errorantriasmsNohpubah').html('');

            $('#modalantriansms').modal('show');
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
}

//Fungsi modal add data
$(document).ready(function() {
    $('.formModalantriansms').submit(function(e) {
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
                $('.btnmodalantriansms').prop('disabled', true);
                $('.btnmodalantriansms').html('<i class="fa fa-spin fa-spinner"></i> Processing');
            },
            complete: function() {
                $('.btnmodalantriansms').prop('disabled', false);
                $('.btnmodalantriansms').html('Simpan');
            },
            success: function(response) {
                if (response.error){
                    if (response.error.antriansms_nohpubah){
                        $('#antriansms_nohpubah').addClass('is-invalid');
                        $('.errorantriasmsNohpubah').html(response.error.antriansms_nohpubah);
                    }
                    else
                    {
                        $('#antriansms_nohpubah').removeClass('is-invalid');
                        $('.errorantriasmsNohpubah').html('');
                    }

                    if (response.error.antriansms_pesanubah){
                        $('#antriansms_pesanubah').addClass('is-invalid');
                        $('.errorantriansmsPesanubah').html(response.error.antriansms_pesanubah);
                    }
                    else
                    {
                        $('#antriansms_pesanubah').removeClass('is-invalid');
                        $('.errorantriansmsPesanubah').html('');
                    }
                }
                else
                {
                    $('#modalantriansms').modal('hide');

                    Swal.fire(
                        'Pemberitahuan',
                        response.success.data,
                        'success',
                    ).then(function() {
                        $('#antriansms_nohpubah').val('');
                        $('#antriansms_pesanubah').val('');
                    });
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });
});

//Fungsi modal add data
$(document).ready(function() {
    $('.formModaltunggakansms').submit(function(e) {
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
                $('.btnmodaltunggakansms').prop('disabled', true);
                $('.btnmodaltunggakansms').html('<i class="fa fa-spin fa-spinner"></i> Processing');
            },
            complete: function() {
                $('.btnmodaltunggakansms').prop('disabled', false);
                $('.btnmodaltunggakansms').html('Simpan');
            },
            success: function(response) {
                if (response.error){
                    if (response.error.tunggakansms_perihal){
                        $('#tunggakansms_perihal').addClass('is-invalid');
                        $('.errorantriasmsPerihalubah').html(response.error.tunggakansms_perihal);
                    }
                    else
                    {
                        $('#tunggakansms_perihal').removeClass('is-invalid');
                        $('.errorantriasmsPerihalubah').html('');
                    }

                    if (response.error.tunggakansms_nohpubah){
                        $('#tunggakansms_nohpubah').addClass('is-invalid');
                        $('.errorantriasmsNohpubah').html(response.error.tunggakansms_nohpubah);
                    }
                    else
                    {
                        $('#tunggakansms_nohpubah').removeClass('is-invalid');
                        $('.errorantriasmsNohpubah').html('');
                    }

                    if (response.error.tunggakansms_pesanubah){
                        $('#tunggakansms_pesanubah').addClass('is-invalid');
                        $('.errortunggakansmsPesanubah').html(response.error.tunggakansms_pesanubah);
                    }
                    else
                    {
                        $('#tunggakansms_pesanubah').removeClass('is-invalid');
                        $('.errortunggakansmsPesanubah').html('');
                    }
                }
                else
                {
                    $('#modalsmstunggakan').modal('hide');

                    Swal.fire(
                        'Pemberitahuan',
                        response.success.data,
                        'success',
                    ).then(function() {
                        $('#tunggakansms_perihal').val('');
                        $('#tunggakansms_nohpubah').val('');
                        $('#tunggakansms_pesanubah').val('');
                    });
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });
});


//Fungsi select data tunggakan
function editpembayaran($kode, $bln, $thn) {
    var url = "/tunggakancontroller/pilihdata";

    $.ajax({
        url: BASE_URL + url,
        type: "post",
        data: {
            kode: $kode,
            bulan: $bln,
            tahun: $thn,
        },
        dataType: "JSON",
        success: function(response) {
            $('#pembayaran_kode').val(response.success.kodegen);
            $('#pembayaran_nis').val(response.success.kode);
            $('#pembayaran_search').val(response.success.nama);
            $('#pembayaran_month').val(response.success.bln);
            $('#pembayaran_year').val(response.success.thn);

            $('#modalubahpembayaran').modal('show');
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
}

//Fungsi modal add dari tunggakan
$(document).ready(function() {
    $('.formModalubahpembayaran').submit(function(e) {
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
                $('.btnmodalubahpembayaran').prop('disabled', true);
                $('.btnmodalubahpembayaran').html('<i class="fa fa-spin fa-spinner"></i> Processing');
            },
            complete: function() {
                $('.btnmodalubahpembayaran').prop('disabled', false);
                $('.btnmodalubahpembayaran').html('Simpan');
            },
            success: function(response) {
                if (response.error){
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
                    $('#modalubahpembayaran').modal('hide');

                    Swal.fire(
                        'Pemberitahuan',
                        response.success.data,
                        'success',
                    ).then(function() {
                        $('#pembayaran_biaya').val('');
                        window.open(response.success.resi, "_blank");
                        window.location = response.success.link;
                    });
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });
});