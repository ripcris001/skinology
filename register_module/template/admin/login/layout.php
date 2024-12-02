

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?php print_r($app->info->title); ?><?php print_r(isset($app->info->subtitle) ? " | " .$app->info->subtitle : ""); ?></title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="<?php print_r($app->info->favicon); ?>" rel="icon">
  <link href="<?php print_r($app->info->favicon); ?>" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="/assets/template/admin/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="/assets/template/admin/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="/assets/template/admin/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="/assets/template/admin/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="/assets/template/admin/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="/assets/template/admin/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="/assets/template/admin/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="/assets/template/admin/css/style.css" rel="stylesheet">
  <script src="/assets/plugin/jquery/jquery.min.js"></script>

  <!-- Sweetalert Plugin File -->
  <script src="/assets/plugin/sweetalert2/sweetalert2.all.min.js"></script>
  <link rel="stylesheet" href="/assets/plugin/sweetalert2/sweetalert2.min.css">

  <!-- QR File -->
  <script src="/assets/plugin/qr/src/jquery.qrcode.min.js"></script>
</head>

<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
        <?php
            if(isset($app->template->page)){
                include($app->dir->root."/".$app->template->page);
            }else{
                print_r("No Page!");
            }
        ?>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script href="/assets/template/admin/vendor/apexcharts/apexcharts.min.js"></script>
  <script href="/assets/template/admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script href="/assets/template/admin/vendor/chart.js/chart.umd.js"></script>
  <script href="/assets/template/admin/vendor/echarts/echarts.min.js"></script>
  <script href="/assets/template/admin/vendor/quill/quill.js"></script>
  <script href="/assets/template/admin/vendor/simple-datatables/simple-datatables.js"></script>
  <script href="/assets/template/admin/vendor/tinymce/tinymce.min.js"></script>
  <script href="/assets/template/admin/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script href="/assets/template/admin/js/main.js"></script>

</body>

</html>