//Datatables server side
$(document).ready( function () {
    var url = '/laporancontroller/ajax_list';
    var table = $('#datatable-laporan').DataTable({ 
      "processing": true,
      "serverSide": true,
      "order": [],
      "ajax": {
          "url": BASE_URL + url,
          "type": "POST",
          "data": function ( data ) {
            data.stdate = $('#laporan_filterstdate').val();
            data.eddate = $('#laporan_filtereddate').val();
          }
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

//Fungsi filter data
$(document).ready(function() {
    $('.formFilterlaporan').submit(function(e) {
        e.preventDefault();

        var stdate = $('#laporan_filterstdate').val();
        var eddate = $('#laporan_filtereddate').val();      

        $.ajax({
            type: "post",
            url: $(this).attr('action'),
            data: $(this).serialize(),
            // data: this.data,
            dataType: "json",
            beforeSend: function() {
                $('.btnfilterlaporan').prop('disabled', true);
                $('.btnfilterlaporan').html('<i class="fa fa-spin fa-spinner"></i> Processing');
            },
            complete: function() {
                $('.btnfilterlaporan').prop('disabled', false);
                $('.btnfilterlaporan').html('Filter Data');
            },
            success: function(response) {
                if (response.error){
                   
                }
                else
                {
                    $('#datatable-laporan').DataTable().ajax.reload();
                    var element = document.getElementById("filterdate");
                    var stdateParts = stdate.split("/");
                    var eddateParts = eddate.split("/");
                    
                    var stdateFormat = stdateParts[1] + '-' + stdateParts[0] + '-' + stdateParts[2];
                    var eddateFormat = eddateParts[1] + '-' + eddateParts[0] + '-' + eddateParts[2];
                    element.innerHTML = "Periode " + stdateFormat + " sampai " + eddateFormat;
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });
});