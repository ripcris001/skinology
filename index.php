<?php
    session_start();
    
    /* import require files */
    require_once('register_module/classes/config.php');
    require_once('register_module/classes/utils.php');
    require_once("register_module/classes/connection.php");

    /* set timezone */
    date_default_timezone_set(SERVER_TIMEZONE);

    /* define server variables */
    if(!isset($root)){ $root = getcwd(); }
    if(!isset($utils)){ $utils = new Utils($root); }
    if(!isset($app)){ $app = new stdClass(); }
    if(!isset($server)){ $server = new stdClass(); }
    if(!isset($server->config)){ $server->config = new stdClass(); }
    if(!isset($server->request)){ $server->request = new stdClass(); }

    /* define app configuration */
    if(!isset($app->config)){ $app->config = new stdClass(); }
    if(!isset($app->db)){ $app->db = new Connection("PDO", DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT); }
    if(!isset($app->db)){ $app->db = new stdClass(); } // trapping if connection is not set
    if(!isset($app->info)){ 
        $app->info = new stdClass(); 
        $app->info->title = WEBSITE_TITLE;
        $app->info->title_acro = WEBSITE_TITLE_ACRO;
        $app->info->favicon = WEBSITE_LOGO_FAVICON !== null ? WEBSITE_LOGO_FAVICON : '';
        $app->info->logo = WEBSITE_LOGO !== null ? WEBSITE_LOGO : '';
    }
    if(!isset($app->data)){ $app->data = new stdClass(); }
    if(!isset($app->dir)){ $app->dir = new stdClass(); }
    if(!isset($app->template)){ $app->template = new stdClass(); }
    if(!isset($app->directory)){ 
        $app->directory = new stdClass(); 
        $app->directory->root = $root;
        $app->directory->upload = $root . '/'.DEFAULT_UPLOAD_DIR;
    }
    
    /* dynamic sp rendering */
    if(!isset($app->sp)){
        $app->sp = new stdClass();
        $source_dir = 'register_module/classes/sp';
        $spfiles = scandir($source_dir);
        foreach ($spfiles as $key => $value){
            if (!in_array($value, array(".",".."))){
                require_once($source_dir."/".$value);
                $cname = str_replace(".php","",$value);
                $app->sp->$cname = new $cname($app->db);
            }
        }
    }
        
    /* set server config */
    $server->config->maintenance = SERVER_MAINTENANCE;

    /* set request parameter */
    $server->request->server = $_SERVER;
    $server->request->method = $_SERVER['REQUEST_METHOD'];
    $server->request->request_url = $_SERVER['REQUEST_URI'];
    $server->request->param_url = isset($_GET['url']) ? $_GET['url'] : [];

    /* triggers */
    $SERVER_ALLOW_APP = false;
    $SERVER_IS_HOMEPAGE = false;

    /* validate if server is maintenance */
    if($server->config->maintenance){
        $utils->maintenance();
    }else{
        if(isset($server->request->param_url)){
            if($server->request->request_url == '/'){
                if($server->request->method == 'GET'){
                    $SERVER_ALLOW_APP = true;
                    $SERVER_IS_HOMEPAGE = true;
                    require_once('register_module/index.php');
                }else{
                    $utils->error(404, $server->request->method);
                }
            }else{
                if(count($_GET)){
                    $SERVER_ALLOW_APP = true;
                    require_once('register_module/index.php');
                }else{
                    $utils->error(404, $server->request->method);
                }
            }
        }else{
            $utils->error(403, $server->request->method);
        }
    }
?>
