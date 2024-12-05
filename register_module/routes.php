<?php 
    if(isset($server->request->param_url)){
        switch(strtolower($server->request->param_url)){
            case "home":
                session_handler('main');
            break;

            case "login":
                session_handler('main', 1);
                $app->data->access = "admin";
                $app->data->subtitle = "Admin";
                $app->template->layout = $utils->buildpath("template/admin/login/layout.php");
                $app->template->page = $utils->buildpath("pages/main/login.php");
                $utils->render($app);
            break;

            case "appointment":
                session_handler('main');
                $app->data->access = "Appointment";
                $app->data->subtitle = "Appointment";
                $app->template->page = $utils->buildpath("pages/main/appointment/appointment.php");
                $utils->render($app, ["admin", "member"]);
            break;
            
            case "appointment/information":
                session_handler('main');
                $app->data->access = "Appointment";
                $app->data->subtitle = "Appointment Information";
                $app->template->page = $utils->buildpath("pages/main/appointment/info.php");
                $utils->render($app, ["admin", "member"]);
            break;

            // case "members":
            //     session_handler('main');
            //     $app->data->access = "Member List";
            //     $app->data->subtitle = "Members";
            //     $app->template->page = $utils->buildpath("pages/main/members/list.php");
            //     $utils->render($app, ["admin", "member"]);
            // break;

            // case "register":
            //     session_handler('main', 1);
            //     $app->data->access = "admin";
            //     $app->data->subtitle = "Admin";
            //     $app->template->layout = $utils->buildpath("template/admin/login/layout.php");
            //     $app->template->page = $utils->buildpath("pages/main/register.php");
            //     $utils->render($app);
            // break;

            // case "dashboard":
            //     session_handler('main');
            //     $app->data->access = "Dashboard";
            //     $app->data->subtitle = "Dashboard";
            //     $app->template->page = $utils->buildpath("pages/main/dashboard.php");
            //     $utils->render($app, ["member"]);
            // break;

            // case "qr":
            //     session_handler('main', 1);
            //     $app->data->access = "admin";
            //     $app->data->subtitle = "Admin";
            //     $app->template->layout = $utils->buildpath("template/plain/layout.php");
            //     $app->template->page = $utils->buildpath("pages/main/qr/qr.php");
            //     $utils->render($app);
            // break;

            case "logout":
                session_destroy();
                header("location: /?url=home");
            break;
            
            /* Admin Page */
            // case "admin/logout":
            //     session_destroy();
            //     header("location: /?url=admin/login");
            // break;
            
            // case "admin/login":
            //     session_handler('admin', 1);
            //     $app->data->access = "admin";
            //     $app->data->subtitle = "Admin";
            //     $app->template->layout = $utils->buildpath("template/admin/login/layout.php");
            //     $app->template->page = $utils->buildpath("pages/admin/login.php");
            //     $utils->render($app);
            // break;

            // case "admin/register":
            //     session_handler('admin', 1);
            //     $app->data->access = "admin";
            //     $app->data->subtitle = "Admin";
            //     $app->template->layout = $utils->buildpath("template/admin/login/layout.php");
            //     $app->template->page = $utils->buildpath("pages/admin/register.php");
            //     $utils->render($app);
            // break;
            
            default:
                $utils->error(404, $server->request->method);
            break;
        }
    }else{
        $utils->error(404, $server->request->method);
    }
?>