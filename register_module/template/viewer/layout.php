<html>
    <head>
        <title>Image Viewer</title>
        <link href="/assets/template/admin/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        
        <link href="/assets/template/admin/css/style.css" rel="stylesheet">
        <link href="/assets/custom/css/main/custom.css" rel="stylesheet">

        <script src="/assets/plugin/jquery/jquery.min.js"></script>
        <script src="/assets/custom/js/custom.js"></script>

        <!-- Sweetalert Plugin File -->
        <script src="/assets/plugin/sweetalert2/sweetalert2.all.min.js"></script>
        <link rel="stylesheet" href="/assets/plugin/sweetalert2/sweetalert2.min.css">

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