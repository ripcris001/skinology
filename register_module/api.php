<?php 
    $response = new stdClass();
    $response->data = array();
    $response->status = false;
    $response->message = "Api Request";
    $response->code = $app->input->get;
    $response->input = $app->input->get;
    // $response->header = get_headers($url);
    $response->header = $_SERVER;
    if(isset($server->request->param_url)){
        switch(strtolower($server->request->param_url)){
        
            case "users/auth":
                try {
                    if(isset($app->input->post['username'])){
                        $sp = $app->sp->users->getUser($app->input->post);
                        $response->q = $sp;
                        if($sp->status && $sp->code != 'empty'){
                            $udata = $sp->data;
                            $password = isset($app->input->post['password']) ? md5($app->input->post['password']) : false;
                            if($udata["user_pwd"] == $password){
                                $response->message = 'Welcome '. $udata["name"];
                                $_SESSION["user_data"] = $udata;
                                $_SESSION["user_data"]["userrole"] = "member";
                                $response->status = true;
                            }else{
                                $response->message = "Incorrect password";
                            }
                        }else{
                            $response->message = "User doesnt exist";
                        }  
                    }  
                } catch (Exception $e) {
                    $response->message = $e->getMessage();
                }
            break;
            
            case "appointment/list/daily":
                try {
                    $sp = $app->sp->appointment->getAppointmentDaily($app->input->post, true);
                    $response->query = $sp;
                    $response->code = $sp->code;
                    $response->status = $sp->status;
                    $response->data = $sp->data;
                } catch (Exception $e) {
                    $response->message = $e->getMessage();
                }
            break;

            case "appointment/list":
                try {
                    $sp = $app->sp->appointment->getAppointment($app->input->post, true);
                    $response->query = $sp;
                    $response->code = $sp->code;
                    $response->status = $sp->status;
                    $response->data = $sp->data;
                } catch (Exception $e) {
                    $response->message = $e->getMessage();
                }
            break;

            case "appointment/list/single":
                try {
                    $sp = $app->sp->appointment->getAppointment($app->input->post);
                    $response->query = $sp;
                    $response->code = $sp->code;
                    $response->status = $sp->status;
                    $response->data = $sp->data;
                } catch (Exception $e) {
                    $response->message = $e->getMessage();
                }
            break;


            case "appointment/patient/files":
                try {
                    $fileList = array();
                    $appointment_path = $app->directory->root . "/" . DEFAULT_IMAGE_DIR . "/" . $app->input->post['patient'] . '/' . $app->input->post['reference'];
                    $webPath = DEFAULT_WEB_IMAGE_DIR . "/" . $app->input->post['patient'] . '/' . $app->input->post['reference'];
                    if(is_dir($appointment_path)){
                        $sp = $app->sp->appointment->getImageUpload(array("reference" => $app->input->post['reference']));
                        $files = scandir($appointment_path);
                        if(count($files) > 0){
                            foreach ($files as $file) {
                                $filePath = $appointment_path . '/' . $file;
                                if (is_file($filePath)) {
                                    $sp = $app->sp->appointment->getImageUpload(array("reference" => $app->input->post['reference'], "filename" => $file));
                                    $fileList[] = array("path" => $filePath, "file" => $webPath . '/' . $file, "data" => $sp->status ? $sp->data : new stdClass());
                                }
                            }
                            $response->status = true;
                        }
                    }else{
                        $response->message = "Appointment image folder doesnt exist on server.";
                    }
                    
                    $response->data = $fileList;
                } catch (Exception $e) {
                    $response->message = $e->getMessage();
                }
            break;
 
            case "appointment/patient/files/upload":
                try {
                    $fileList = array();
                    $patientPath = $app->directory->root . "/" . DEFAULT_IMAGE_DIR . "/" . $app->input->post['patient'];
                    $appointment_path = $patientPath . '/' . $app->input->post['reference'];
                    $file = $_FILES;
                    $response->data = $_FILES['file'];
                    $response->data['patient'] = $app->input->post['patient'];
                    $response->data['reference'] = $app->input->post['reference'];
                    $response->data['fullpath'] = $appointment_path;
                    if ( 0 < $_FILES['file']['error'] ) {
                        $response->message = 'Error: ' . $_FILES['file']['error'] . '<br>';
                    } else {
                        $temp = explode(".", $_FILES["file"]["name"]);
                        $newfilename = round(microtime(true)) . '.' . end($temp);
                        if(!file_exists( $patientPath ) && !is_dir( $appointment_path )){
                            mkdir( $patientPath );
                            if(!file_exists( $appointment_path ) && !is_dir( $appointment_path )){
                                mkdir( $appointment_path );
                            }
                        }else{
                            if(!file_exists( $appointment_path ) && !is_dir( $appointment_path )){
                                mkdir( $appointment_path );
                            }
                        }
                        if(move_uploaded_file($_FILES['file']['tmp_name'], $appointment_path . '/' . $newfilename)){
                            $input = array("reference" => $app->input->post['reference'], "filename" => $newfilename, "user_id" => $app->session->user["user_id"]);
                            $sp = $app->sp->appointment->uploadImage($input);
                            if($sp->status){
                                $response->res = $sp;
                            }
                        }
                        
                        $response->data = array();
                        $response->data["name"] = $newfilename;
                        $response->data["path"] = $appointment_path;
                        $response->status = true;
                    }
                } catch (Exception $e) {
                    $response->message = $e->getMessage();
                }
            break;

            case "users/list":
                try {
                    $sp = $app->sp->users->getUser($app->input->post, true);
                    $response->query = $sp;
                    $response->code = $sp->code;
                    $response->status = $sp->status;
                    $response->data = $sp->data;
                } catch (Exception $e) {
                    $response->message = $e->getMessage();
                }
            break;

            case "patient/list":
                try {
                    $sp = $app->sp->appointment->getPatient($app->input->post, true);
                    $response->query = $sp;
                    $response->code = $sp->code;
                    $response->status = $sp->status;
                    $response->data = $sp->data;
                } catch (Exception $e) {
                    $response->message = $e->getMessage();
                }
            break;

            case "patient/history":
                try {
                    $sp = $app->sp->appointment->getPatientHistory($app->input->post, true);
                    $response->query = $sp;
                    $response->code = $sp->code;
                    $response->status = $sp->status;
                    $response->data = $sp->data;
                } catch (Exception $e) {
                    $response->message = $e->getMessage();
                }
            break;

            default:
                $response->message = "Url not found!";
                $response->code = 404;
            break;
        }

    }else{
        $response->message = "Url not found!";
        $response->code = 404;
    }
    $utils->response($response);
?>