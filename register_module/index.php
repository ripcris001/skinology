<?php 
    if(isset($SERVER_ALLOW_APP) && $SERVER_ALLOW_APP){
        $req_param = array();
        $url_components = parse_url($server->request->request_url);
        
        if(isset($url_components['query'])){
            parse_str($url_components['query'], $req_param);
        }

        $app->config->allow_view = isset($SERVER_ALLOW_APP) && $SERVER_ALLOW_APP ? true : false;
        $app->dir->root = $root;
        $app->template->layout = $utils->buildpath("template/admin/layout.php");
        $app->template->footer = $utils->buildpath("template/admin/footer.php");
        $app->template->sidebar = $utils->buildpath("template/admin/sidebar.php");
        $app->utils = $utils;

        /* set app data */
        $app->data->school_info = array();
        $app->data->partners = array();

        /* declare input variables */
        $app->input = new stdClass();
        $app->input->get = $_GET;
        $app->input->post = $_POST;
        $app->session = new stdClass();
        $app->session->haslogin = isset($_SESSION["user_data"]) ? 1 : 0;
        $app->session->loginType = isset($_SESSION["user_data"]) ? "admin" : (isset($_SESSION["student_data"]) ? "agent" : false);
        $app->session->user = isset($_SESSION["user_data"]) ? $_SESSION["user_data"] : (isset($_SESSION["student_data"]) ? $_SESSION["student_data"] : array());
        $app->session->userLogout = isset($_SESSION["user_data"]) ? $utils->genUrlRaw("logout") : (isset($_SESSION["student_data"]) ? $utils->genUrlRaw("logout") : "/?url=logout");
        $app->session->userTitle = isset($_SESSION["user_data"]) ? "Superadmin" : (isset($_SESSION["student_data"]) ? "Agent" : "");
        $app->session->userProfile = isset($_SESSION["user_data"]) ?  $utils->genUrlRaw("profile") : (isset($_SESSION["student_data"]) ? $utils->genUrlRaw("/?url=agent/user/profile") : "#");
        $app->session->userRole = isset($_SESSION["user_data"]) ?  $_SESSION["user_data"]["userrole"] : 'member';
        $app->data->sidebar = array();
        $app->data->adminSidebar = array();
        $app->data->agentSidebar = array();
        $app->data->action = isset($_GET['action']) ? $_GET['action'] : 0;
        $app->data->services = $var_service;

        $app->data->url = new stdClass();
        $app->data->url->imagefile = "http://cmsimagesfile.ggc.ph:8081";
        $app->data->url->imageportal = "http://cmsimagesportal.ggc.ph:8080";
        
        $app->data->adminSidebar[] = $utils->sidebar('Patient', $utils->genUrlRaw('patient'), 'bi-card-checklist');
        $app->data->adminSidebar[] = $utils->sidebar('Appointment', $utils->genUrlRaw('appointment'), 'bi-card-checklist');
        
        // $app->data->adminSidebar[] = $utils->sidebar('Dashboard', $utils->genUrlRaw('dashboard'), 'bi-grid');
        // $app->data->adminSidebar[] = $utils->sidebar('Members', $utils->genUrlRaw('members'), 'bi-person');
        
        if($app->session->loginType == 'admin'){
            $app->data->sidebar = $app->data->adminSidebar;
        }else{
            $app->data->sidebar = $app->data->agentSidebar;
        }

        function session_handler($param, $mode = 0){
            if($mode == 0){
                if($param == 'admin'){
                    if(isset($_SESSION["user_data"])){
                        return true;
                    }else{
                        header("location: ". ROOT_URL ."?url=admin/login");
                    }
                }else if($param == 'main'){
                    if(isset($_SESSION["user_data"])){
                        return true;
                    }else{
                        header("location: ". ROOT_URL ."?url=login");
                    }
                }else{
                    if(isset($_SESSION["user_data"])){
                        return true;
                    }else{
                        header("location: ". ROOT_URL ."?url=". $param ."/login");
                    }
                }
            }else{
                if($param == 'admin'){
                    if(isset($_SESSION["user_data"])){
                        header("location:  ". ROOT_URL ."?url=admin");
                    }else{
                        return true;
                    }
                }else if($param == 'main'){
                    if(isset($_SESSION["user_data"])){
                        header("location:  ". ROOT_URL ."?url=home");
                    }else{
                        return true;
                    }
                }else{
                    if(isset($_SESSION["user_data"])){
                        header("location:  ". ROOT_URL ."?url=". $param);
                    }else{
                        return true;    
                    }
                }
            }
        }   

        if($server->request->method == 'GET'){
            if(isset($SERVER_IS_HOMEPAGE) && $SERVER_IS_HOMEPAGE){
                session_handler(WEBSITE_HOMEPAGE);
            }else{
                require_once($utils->buildpath("routes.php", true));
            }
            
        }else if($server->request->method == 'POST'){
            require_once($utils->buildpath("api.php", true));
        }
    }else{
        $utils->error(403, $server->request->method);
    }
?>