<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Utils {
    public $rootdir;
    public function __construct($param){
        $this->rootdir = $param;
    }

    public function buildpath($param, $isroot = false){
        $rp = getcwd();
        if($isroot){
            return $this->rootdir ."/register_module/". $param; 
        }else{
            return "/register_module/". $param; 
        }
    }

    public function error($param, $type = 'get'){
        if(isset($type)){
            if(strtolower($type) == 'post'){
                $output = new stdClass();
                $output->message = "Error ".$param;
                $output->status = false;
                print_r(json_encode($output));
            }else if(strtolower($type) == 'get'){
                print_r("error ".$param);
            }else{
                http_response_code($param);
                die();
            }
        }else{
            http_response_code($param);
            die();
        }
    }

    public function maintenance(){
        print_r('
            <html>
                <head><title></title></head>
                <body style="display:flex; align-items: center; justify-content: center;">
                    <h1>Server Maintenance</h1>
                </body>
            </html>
        ');
    }

    public function genUrl($param, $isAPI = false){
        $url = "";
        if(isset($isAPI) && $isAPI){
            $url = ROOT_URL . '?url=api/'.$param;
        }else{
            $url = ROOT_URL . '?url='. $param;
        }
        print_r($url);
    }

    public function genUrlRaw($param, $isAPI = false){
        $url = "";
        if(isset($isAPI) && $isAPI){
            $url = ROOT_URL . '?url=api/'.$param;
        }else{
            $url = ROOT_URL . '?url='. $param;
        }
        return $url;
    }

    public function render($param, $role = []){
        $app = $param;
        $utils = $param->utils;
        if(isset($role) && count($role) > 0){
            if(isset($_SESSION["user_data"])){
                if (in_array($_SESSION["user_data"]["userrole"], $role) || $_SESSION["user_data"]["userrole"] == 'admin') {
                    include($param->dir->root."/".$app->template->layout);
                }else{
                    http_response_code(403);
                    die('<h3>Unauthorize Access</h3>');
                }
            }else{
                http_response_code(403);
                die('<h3>Unauthorize Access</h3>');
            }
        }else{
            include($param->dir->root."/".$app->template->layout);
        }
        
    }

    public function reterror($err){
        if(isset($err)){
            http_response_code($err);
        }else{
            http_response_code(404);
        }
    }

    public function response($data){
        $output = $data;
        if(DEBUG_MODE){
            $output->status = isset($data->status) ? $data->status : false;
            $output->data = isset($data->data) ? $data->data : [];
            $output->message = isset($data->message) ? $data->message : "#";
            $output->redirect = isset($data->redirect) ? $data->redirect : "/";
        }else{
            $output = new stdClass();
            $output->status = isset($data->status) ? $data->status : false;
            $output->data = isset($data->data) ? $data->data : [];
            $output->message = isset($data->message) ? $data->message : "#";
            $output->redirect = isset($data->redirect) ? $data->redirect : "/";
        }
        
        http_response_code(200);
        header('Content-Type: application/json; charset=utf-8');
        print_r(json_encode($output));
        exit(1);
    }

    public function newsp($param, $all = null){
        $sp = new stdClass();
        $sp->full = false;
        $sp->mode = null;
        $sp->all = isset($all) && $all ? $all : null;
        $sp->call = isset($param) ? $param : 'sp_no_action';
        $sp->field = array();
        $sp->action = "get";
        return $sp;
    }

    public function query($param, $connection){
        $output = new stdClass();
        $output->status = false;
        $output->data = "";
        $output->query = "";
        $output->code = "";
        $counter = new stdClass();
        $counter->call = 0;
        $counter->field = 0;
        $fieldString = "";
        $queryString = "";
        if(isset($param->call)){
            $queryString = $queryString . "CALL ".$param->call;
            $counter->call++;
        }
        if(isset($param->field)){
            $output->field = $param->field;
            $type = gettype($param->field);
            if($type == 'array' || $type == 'object'){
                $count = count((array)$param->field);
                if($count){
                    for($a = 0; $a < $count; $a++){
                        $fvalue = $param->field[$a][1];
                        if($a == ($count - 1)){
                            if(gettype($fvalue) === 'string'){
                                $fieldString = $fieldString . '"'.$fvalue.'"';
                            }else{
                                $fieldString = $fieldString . $fvalue;
                            }
                        }else{
                            if(gettype($fvalue) === 'string'){
                                $fieldString = $fieldString . '"'.$fvalue.'", ';
                            }else{
                                $fieldString = $fieldString . $fvalue.", ";
                            }
                            // $fieldString = $fieldString . "?,";
                        }
                        $counter->field++;
                    }
                }
            }
        }
        $queryString = $queryString . '('.$fieldString.')';
        $query = $connection->con->prepare("$queryString");
        $query->execute();
        $query_result = $query->fetchAll();
        if($query_result){
            $output->status = true;
            if(count($query_result)){
                if($param->all){
                    $output->data = $query_result;
                }else{
                    if(isset($query_result[0])){
                        $output->data = $query_result[0];
                    }else{
                        $output->data = $query_result;
                    }
                }
            }else{
                $output->data = [];
                $output->code = "empty";
            }
        }else{
            $output->data = [];
            $output->code = "empty";
            $output->status = true;
        }
        return $output;
    }
    public function sidebar($name, $url, $icon){
        $sidebarStructure = new stdClass();
        $sidebarStructure->url = $url;
        $sidebarStructure->name = $name;
        $sidebarStructure->sub = array();
        $sidebarStructure->icon = $icon;
        return $sidebarStructure;
    }
}

?>