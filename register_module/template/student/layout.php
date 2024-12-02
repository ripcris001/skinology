<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?php print_r($app->info->title); ?><?php print_r(isset($app->data->subtitle) ? " | " .$app->data->subtitle : ""); ?>
    </title>
    <link href="/assets/custom_assets/images/logo.png" rel="icon">
    <link href="/assets/custom_assets/images/logo.png" rel="apple-touch-icon">
    <link href="https://fonts.googleapis.com/css2?family=Cabin:wght@700&display=swap" rel="stylesheet">
    
    <!-- Vendor CSS Files -->
    <link href="/assets/template/admin/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/template/admin/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="/assets/template/admin/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="/assets/template/admin/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="/assets/template/admin/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="/assets/template/admin/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="/assets/template/admin/vendor/simple-datatables/style.css" rel="stylesheet">
    <link href="/assets/custom_assets/css/main/custom.css" rel="stylesheet">

    <link href="/assets/plugin/fontawesome/css/all.min.css" rel="stylesheet">
    <link href="/assets/plugin/sweetalert2/sweetalert2.min.css" rel="stylesheet">
    <!-- <link href="/assets/plugin/fontawesome/css/fontawesome.min.css" rel="stylesheet"> -->
  
    <script src="/assets/plugin/jquery/jquery.min.js"></script>
</head>
<body>
    <header>
        <nav>
            <a class="toggle-sidebar-btn"> 
                <i class="bi bi-list"></i>
            </a>
            <a href="?url=agent/logout">Logout</a>
        </nav>
    </header>
    <main>
        <aside class="sidebar">
            <a href="?url=calculate/motorcar-insurance">Motorcar Insurance</a>
            <a href="?url=calculate/fire-insurance">Fire Insurance</a>
            <a href="?url=calculate/bond-insurance">Bonds Insurance</a>
            <a href="?url=calculate/cari">CARI</a>
            <a href="?url=calculate/cargo-insurance">International and Inter-Island Cargo</a>
        </aside>
        <section class="main-content">
            <?php
                if(isset($app->template->page)){
                    include($app->dir->root."/".$app->template->page);
                }else{
                    print_r("No Page!");
                }
            ?>
        </section>
    </main>
    <script src="/assets/template/admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/plugin/fontawesome/js/fontawesome.min.js"></script>
    <script src="/assets/plugin/sweetalert2/sweetalert2.min.js"></script>
    <script>
        $(document).ready(function(){
            $('body').on('click', '.toggle-sidebar-btn', function(){
                if($('body').find('.sidebar').hasClass('toggle-sidebar')){
                    $('body').find('.sidebar').removeClass('toggle-sidebar');
                }else{
                    $('body').find('.sidebar').addClass('toggle-sidebar')
                }
            });
        })
    </script>
</body>
</html>