//Datatables server side
$(document).ready( function () {
    var url = '/dashboard/ajax_list';
    var table = $('#datatable-pembayaranmonth').DataTable({ 
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

// alert($('#fooo').val().toString());
var foopart = $('#fooo').val().split(",");
var loopart = $('#looo').val().split(",");

BarsChart = (SalesChart = function() {
    var e, a, t = $("#chart-sales");
    t.length && (e = t, a = new Chart(e, {
        type: "line",
        options: {
            scales: {
                yAxes: [{
                    gridLines: {
                        color: Charts.colors.gray[200],
                        zeroLineColor: Charts.colors.gray[200]
                    },
                    ticks: {}
                }]
            }
        },
        data: {
            labels: ["May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [{
                label: "Performance",
                data: [0, 20, 10, 30, 15, 40, 20, 60, 60]
                }]
            }
        }), e.data("chart", a))
     }(), function() {
        var e = $("#chart-dash");
        e.length && function(e) {
            var a = new Chart(e, {
                type: "bar",
                data: {
                    // labels: ["2019", "2020", "2021", "2022", "2023"],
                    // labels: ['2020', '2021', ],
                    labels: [foopart[0], foopart[1]],
                    datasets: [{
                        label: "Jumlah",
                        // data: [300000, 650000, ]
                        // data: [0, 20000000, 30000000, 22000000, 17000000]
                        data: [loopart[0], loopart[1]]
                    }]
                }
            });
            e.data("chart", a)
        }(e)
    }())
