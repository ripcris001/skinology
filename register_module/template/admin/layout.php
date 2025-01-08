<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>
    <?php print_r(isset($app->data->header_title) ? $app->data->header_title : $app->info->title)?>
    <?php print_r(isset($app->data->header_subtitle) ? " | ".$app->data->header_subtitle : ""); ?>
  </title>
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
  <link href="/assets/plugin/sweetalert2/sweetalert2.min.css" rel="stylesheet">

  

  <!-- Template Main CSS File -->
  <link href="/assets/template/admin/css/style.css" rel="stylesheet">
  <link href="/assets/custom_assets/css/main/custom.css" rel="stylesheet">
  
  <script src="/assets/plugin/jquery/jquery.min.js"></script>
  <script src="/assets/custom_assets/js/custom.js"></script>


  <link href="/assets/plugin/slider/swiper-bundle.min.css" rel="stylesheet">
  <script src="/assets/plugin/slider/swiper-bundle.min.js"></script>

  <!-- Sweetalert Plugin File -->
  <script src="/assets/plugin/sweetalert2/sweetalert2.all.min.js"></script>
  <link rel="stylesheet" href="/assets/plugin/sweetalert2/sweetalert2.min.css">
</head>

<body
    
>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a class="logo d-flex align-items-center" href="#">
        <img src="<?php print_r($app->info->logo); ?>" alt="" style="margin: 0 auto; max-height: 5rem;">
      </a>
      
      <?php 
        if(isset($app->template->sidebar) && $app->template->sidebar){
            print_r('<i class="bi bi-list toggle-sidebar-btn"></i>');  
        }
        ?>
    </div><!-- End Logo -->

    <div class="search-bar">
      <!-- <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form> -->
    </div><!-- End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <?php  if(isset($app->session->user) && isset($app->session->user['fullname'])) { ?>
        <li class="nav-item dropdown pe-3">
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="/assets/template/admin/img/profile-img.jpg" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2"><?php print_r(isset($app->session->user) ? $app->session->user['fullname'] : ""); ?></span>
          </a>

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6><?php print_r(isset($app->session->user) ? $app->session->user['fullname'] : "") ?></h6>
              <span><?php print_r(isset($app->session->userTitle) ? $app->session->userTitle : "") ?></span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="<?php print_r(isset($app->session->userProfile) ? $app->session->userProfile : ""); ?>&action=overview">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <!-- <li>
              <a class="dropdown-item d-flex align-items-center" href="<?php print_r(isset($app->session->userProfile) ? $app->session->userProfile : ""); ?>&action=update-info">
                <i class="bi bi-person"></i>
                <span>Change Info</span>
              </a>
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="<?php print_r(isset($app->session->userProfile) ? $app->session->userProfile : ""); ?>&action=update-password">
                <i class="bi bi-person"></i>
                <span>Change Password</span>
              </a>
            </li> -->
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="<?php print_r(isset($app->session->userLogout) ? $app->session->userLogout : ""); ?>">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul>
        </li>
        <?php } ?>
        <!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">
    <?php
        if(isset($app->template->sidebar) && $app->template->sidebar){
          include($app->dir->root."/".$app->template->sidebar);
        }
      ?>
  </aside><!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1><?php print_r(isset($app->data->subtitle) ? $app->data->subtitle : ""); ?></h1>
      <!-- <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Pages</li>
          <li class="breadcrumb-item active">Blank</li>
        </ol>
      </nav> -->
    </div>
    <!-- End Page Title -->

    <section class="section">
      <?php
            if(isset($app->template->page)){
                include($app->dir->root."/".$app->template->page);
            }else{
                print_r("No Page!");
            }
      ?>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
      Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="/assets/template/admin/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="/assets/template/admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="/assets/template/admin/vendor/chart.js/chart.umd.js"></script>
  <script src="/assets/template/admin/vendor/echarts/echarts.min.js"></script>
  <script src="/assets/template/admin/vendor/quill/quill.js"></script>
  <script src="/assets/template/admin/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="/assets/template/admin/vendor/tinymce/tinymce.min.js"></script>
  <script src="/assets/template/admin/vendor/php-email-form/validate.js"></script>
  <script src="/assets/plugin/sweetalert2/sweetalert2.min.js"></script>
  <script src="/assets/plugin/validate/dist/jquery.validate.min.js"></script>

  <link href="/assets/plugin/viewerjs/dist/viewer.min.css" rel="stylesheet" />  
  <script src="/assets/plugin/viewerjs/dist/viewer.min.js" ></script>

  <!-- Template Main JS File -->
  <script src="/assets/template/admin/js/main.js"></script>
  <script>
    $(document).ready(function(){
      function validateActiveSB(){
        let sb_url = window.location.search;
        sb_url = `/${sb_url.replaceAll('%20', " ")}`;
        let active_count = 0;
        const sidebar_length = $('body').find('.sidebar-data').length;
        $('body').find('.sidebar-data').each(function(i){
          const local = $(this);
          const s_url = local.attr('href');
          const sidebar_tag = local.attr('data-tag');
          if(s_url == sb_url){
            if(sidebar_tag == 'single'){
              local.removeClass('collapsed');
            }else{
              local.closest('.nav-item').find('.collapsed').removeClass('collapsed');
              local.closest('.nav-item').find('.collapse').removeClass('collapse');
              local.addClass('active');
            }
          }
        })
      }
      validateActiveSB();
    })
  </script>
</body>

</html>