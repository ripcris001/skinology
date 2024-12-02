<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
            <?php print_r($app->info->title); ?><?php print_r(isset($app->info->subtitle) ? " | " .$app->info->subtitle : ""); ?>
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
    <!-- <link href="/assets/plugin/fontawesome/css/fontawesome.min.css" rel="stylesheet"> -->
  
    <script src="/assets/plugin/jquery/jquery.min.js"></script>
</head>
<body>
    <?php
        if(isset($app->template->page)){
            include($app->dir->root."/".$app->template->page);
        }else{
            print_r("No Page!");
        }
    ?>  
    <script src="/assets/template/admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/plugin/fontawesome/js/fontawesome.min.js"></script>

    <link href="/assets/plugin/sweetalert2/sweetalert2.min.css" rel="stylesheet">
    <script src="/assets/plugin/sweetalert2/sweetalert2.min.js"></script>
</body>
</html>