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
            case "users/gender":
                try {
                    $sp = $app->sp->users->gender($app->input->post, true);
                    $response->query = $sp;
                    $response->code = $sp->code;
                    $response->status = $sp->status;
                    $response->data = $sp->data;
                } catch (Exception $e) {
                    $response->message = $e->getMessage();
                }
            break;

            case "users/member":
                try {
                    $sp = $app->sp->users->getMember($app->input->post, true);
                    $response->query = $sp;
                    $response->code = $sp->code;
                    $response->status = $sp->status;
                    $response->data = $sp->data;
                } catch (Exception $e) {
                    $response->message = $e->getMessage();
                }
            break;

            case "users/member/register":
                try {
                    $sp = $app->sp->users->new_registration($app->input->post);
                    $response->query = $sp;
                    $response->code = $sp->code;
                    $response->status = $sp->status;
                    $response->data = $sp->data;
                } catch (Exception $e) {
                    $response->message = $e->getMessage();
                }
            break;

            case "users/registration/info":
                try {
                    $sp = $app->sp->users->getRegistrationInfo($app->input->post, true);
                    $response->query = $sp;
                    $response->code = $sp->code;
                    $response->status = $sp->status;
                    $response->data = $sp->data;
                } catch (Exception $e) {
                    $response->message = $e->getMessage();
                }
            break;


            case "users/member/add":
                try {
                    $app->input->post['id'] = 0;
                    $sp = $app->sp->users->add_update_member($app->input->post);
                    $response->query = $sp;
                    $response->code = $sp->code;
                    $response->status = $sp->status;
                    $response->data = $sp->data;
                } catch (Exception $e) {
                    $response->message = $e->getMessage();
                }
            break;

            case "users/member/update":
                try {
                    $sp = $app->sp->users->add_update_member($app->input->post);
                    $response->query = $sp;
                    $response->code = $sp->code;
                    $response->status = $sp->status;
                    $response->data = $sp->data;
                } catch (Exception $e) {
                    $response->message = $e->getMessage();
                }
            break;

            case "users/auth":
                try {
                    if(isset($app->input->post['username'])){
                        $sp = $app->sp->users->getUser($app->input->post);
                        if($sp->status && $sp->code != 'empty'){
                            $udata = $sp->data;
                            $password = isset($app->input->post['password']) ? md5($app->input->post['password']) : false;
                            if($udata["password"] == $password){
                                $response->message = 'Welcome '. $udata["fullname"];
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