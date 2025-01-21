<html>
    <head>
        <title>
            <?php print_r(isset($app->data->header_title) ? $app->data->header_title : $app->info->title)?>
            <?php print_r(isset($app->data->header_subtitle) ? " | ".$app->data->header_subtitle : ""); ?>
        </title>
        <link href="/assets/template/admin/css/style.css" rel="stylesheet">
        <link href="/assets/custom/css/main/custom.css" rel="stylesheet">
        
        <script src="/assets/plugin/jquery/jquery.min.js"></script>
        <script src="/assets/custom/js/custom.js"></script>

        <link href="/assets/plugin/slider/swiper-bundle.min.css" rel="stylesheet">
        <script src="/assets/plugin/slider/swiper-bundle.min.js"></script>

        <!-- Sweetalert Plugin File -->
        <script src="/assets/plugin/sweetalert2/sweetalert2.all.min.js"></script>
        <link rel="stylesheet" href="/assets/plugin/sweetalert2/sweetalert2.min.css">

        <!-- QR File -->
        <script src="/assets/plugin/qr/src/jquery.qrcode.min.js"></script>
    </head>
    <body>
        <?php
            if(isset($app->template->page)){
                include($app->dir->root."/".$app->template->page);
            }else{
                print_r("No Page!");
            }
        ?>
    </body>
</html>