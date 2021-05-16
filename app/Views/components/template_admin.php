<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
  <meta name="author" content="Creative Tim">
  <title>Sistem Informasi SPP</title>
  <!-- Extra details for Live View on GitHub Pages -->
  <!-- Canonical SEO -->
  <link rel="canonical" href="https://www.creative-tim.com/product/argon-dashboard-pro" />
  <!--  Social tags      -->
  <meta name="keywords" content="dashboard, bootstrap 4 dashboard, bootstrap 4 design, bootstrap 4 system, bootstrap 4, bootstrap 4 uit kit, bootstrap 4 kit, argon, argon ui kit, creative tim, html kit, html css template, web template, bootstrap, bootstrap 4, css3 template, frontend, responsive bootstrap template, bootstrap ui kit, responsive ui kit, argon dashboard">
  <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
  <!-- Schema.org markup for Google+ -->
  <meta itemprop="name" content="Argon - Premium Dashboard for Bootstrap 4 by Creative Tim">
  <meta itemprop="description" content="Start your development with a Dashboard for Bootstrap 4.">
  <meta itemprop="image" content="https://s3.amazonaws.com/creativetim_bucket/products/137/original/opt_adp_thumbnail.jpg">
  <!-- Twitter Card data -->
  <meta name="twitter:card" content="product">
  <meta name="twitter:site" content="@creativetim">
  <meta name="twitter:title" content="Argon - Premium Dashboard for Bootstrap 4 by Creative Tim">
  <meta name="twitter:description" content="Start your development with a Dashboard for Bootstrap 4.">
  <meta name="twitter:creator" content="@creativetim">
  <meta name="twitter:image" content="https://s3.amazonaws.com/creativetim_bucket/products/137/original/opt_adp_thumbnail.jpg">
  <!-- Open Graph data -->
  <meta property="fb:app_id" content="655968634437471">
  <meta property="og:title" content="Argon - Premium Dashboard for Bootstrap 4 by Creative Tim" />
  <meta property="og:type" content="article" />
  <meta property="og:url" content="https://demos.creative-tim.com/argon-dashboard/index.html" />
  <meta property="og:image" content="https://s3.amazonaws.com/creativetim_bucket/products/137/original/opt_adp_thumbnail.jpg" />
  <meta property="og:description" content="Start your development with a Dashboard for Bootstrap 4." />
  <meta property="og:site_name" content="Creative Tim" />
  <!-- Favicon -->
  <link rel="icon" href="<?= base_url() ?>/public/assets/img/brand/favicon.ico">
  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
  <!-- Icons -->
  <link rel="stylesheet" href="<?= base_url() ?>/public/assets/vendor/nucleo/css/nucleo.css" type="text/css">
  <link rel="stylesheet" href="<?= base_url() ?>/public/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css" type="text/css">
  <!-- Page plugins -->
  <link rel="stylesheet" href="<?= base_url() ?>/public/assets/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>/public/assets/vendor/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>/public/assets/vendor/datatables.net-select-bs4/css/select.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>/public/assets/vendor/sweetalert2/dist/sweetalert2.min.css">

  <!-- Argon CSS -->
  <link rel="stylesheet" href="<?= base_url() ?>/public/assets/css/argon.min-v=1.0.0.css" type="text/css">
  <!-- Google Tag Manager -->
  <!-- End Google Tag Manager -->
</head>

<body>
  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NKDMSK6" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->
  
  <!-- Side Nav -->
  <?= $this->include('components/sidenav_admin'); ?>

  <!-- Main content -->
  <div class="main-content" id="panel">
    <!-- Top Nav -->
    <?= $this->include('components/topnav_admin'); ?>

    <!-- Page content -->
    <?= $this->renderSection('content'); ?>
    
    <!-- Footer -->
      <footer class="footer pt-0">
        <div class="row align-items-center justify-content-lg-between">
          <div class="col-lg-6">
            <div class="copyright text-center text-lg-left text-muted">
              <!-- &copy; 2020 <a href="https://www.panensaham.com" class="font-weight-bold ml-1" target="_blank">PanenSaham Tim</a> -->
            </div>
          </div>
          <div class="col-lg-6">
            <!-- <ul class="nav nav-footer justify-content-center justify-content-lg-end">
              <li class="nav-item">
                <a href="https://www.creative-tim.com" class="nav-link" target="_blank">Creative Tim</a>
              </li>
              <li class="nav-item">
                <a href="https://www.creative-tim.com/presentation" class="nav-link" target="_blank">About Us</a>
              </li>
              <li class="nav-item">
                <a href="http://blog.creative-tim.com" class="nav-link" target="_blank">Blog</a>
              </li>
              <li class="nav-item">
                <a href="https://www.creative-tim.com/license" class="nav-link" target="_blank">License</a>
              </li>
            </ul> -->
          </div>
        </div>
      </footer>
    </div>
  </div>
  <!-- Argon Scripts -->
  <!-- Core -->
  <script src="<?= base_url() ?>/public/assets/vendor/jquery/dist/jquery.min.js"></script>
  <script src="<?= base_url() ?>/public/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url() ?>/public/assets/vendor/js-cookie/js.cookie.js"></script>
  <script src="<?= base_url() ?>/public/assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js"></script>
  <script src="<?= base_url() ?>/public/assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js"></script>
  <script src="<?= base_url() ?>/public/assets/vendor/lavalamp/js/jquery.lavalamp.min.js"></script>
  <!-- Optional JS -->
  <script src="<?= base_url() ?>/public/assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
  <script src="<?= base_url() ?>/public/assets/vendor/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="<?= base_url() ?>/public/assets/vendor/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?= base_url() ?>/public/assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
  <script src="<?= base_url() ?>/public/assets/vendor/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
  <script src="<?= base_url() ?>/public/assets/vendor/datatables.net-buttons/js/buttons.html5.min.js"></script>
  <script src="<?= base_url() ?>/public/assets/vendor/datatables.net-buttons/js/buttons.flash.min.js"></script>
  <script src="<?= base_url() ?>/public/assets/vendor/datatables.net-buttons/js/buttons.print.min.js"></script>
  <script src="<?= base_url() ?>/public/assets/vendor/datatables.net-select/js/dataTables.select.min.js"></script>
  <script src="<?= base_url() ?>/public/assets/vendor/chart.js/dist/Chart.min.js"></script>
  <script src="<?= base_url() ?>/public/assets/vendor/chart.js/dist/Chart.extension.js"></script>
  <script src="<?= base_url() ?>/public/assets/vendor/sweetalert2/dist/sweetalert2.min.js"></script>
  <!-- Argon JS -->
  <script src="<?= base_url() ?>/public/assets/js/argon.js"></script>
  <!-- Demo JS - remove this in your project -->
  <script src="<?= base_url() ?>/public/assets/js/demo.min.js"></script>
  <!-- Custom JS -->
  <script src="<?= base_url() ?>/public/assets/js/master/agama.js"></script>
  <script src="<?= base_url() ?>/public/assets/js/master/kelas.js"></script>
  <script src="<?= base_url() ?>/public/assets/js/master/level.js"></script>
  <script src="<?= base_url() ?>/public/assets/js/user.js"></script>
  <script src="<?= base_url() ?>/public/assets/js/siswa.js"></script>
  <script src="<?= base_url() ?>/public/assets/js/profile.js"></script>
  <script src="<?= base_url() ?>/public/assets/js/setting.js"></script>
  <script src="<?= base_url() ?>/public/assets/js/pembayaran.js"></script>
  <script src="<?= base_url() ?>/public/assets/js/app.js"></script>
  <script>
    var BASE_URL = "<?= base_url(); ?>";
  </script>
  <script>
    // Facebook Pixel Code Don't Delete
    ! function(f, b, e, v, n, t, s) {
      if (f.fbq) return;
      n = f.fbq = function() {
        n.callMethod ?
          n.callMethod.apply(n, arguments) : n.queue.push(arguments)
      };
      if (!f._fbq) f._fbq = n;
      n.push = n;
      n.loaded = !0;
      n.version = '2.0';
      n.queue = [];
      t = b.createElement(e);
      t.async = !0;
      t.src = v;
      s = b.getElementsByTagName(e)[0];
      s.parentNode.insertBefore(t, s)
    }(window,
      document, 'script', '//connect.facebook.net/en_US/fbevents.js');

    try {
      fbq('init', '111649226022273');
      fbq('track', "PageView");

    } catch (err) {
      console.log('Facebook Track Error:', err);
    }
  </script>
  <noscript>
    <img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=111649226022273&ev=PageView&noscript=1" />
  </noscript>
</body>

</html>