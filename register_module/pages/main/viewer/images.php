<!-- Sweetalert Plugin File -->
<script src="/assets/plugin/viewerjs/dist/viewer.min.js"></script>
<link rel="stylesheet" href="/assets/plugin/viewerjs/dist/viewer.css">
<?php 
    $isView = false;
    $fileList = array();
    $messageHead = "Invalid Input";
    $message = "Invalid input parameter";
    if(ISSET($app->input->get['code']) && ISSET($app->input->get['reference'])){
        $appointment_path = $app->directory->root . "/" . DEFAULT_IMAGE_DIR . "/" . $app->input->get['code'] . '/' . $app->input->get['reference'];
        $webPath = DEFAULT_WEB_IMAGE_DIR . "/" . $app->input->get['code'] . '/' . $app->input->get['reference'];
        if(is_dir($appointment_path)){
            $files = scandir($appointment_path);
            if(count($files) > 0){
                foreach ($files as $file) {
                    $filePath = $appointment_path . '/' . $file;
                    if (is_file($filePath)) {
                        $fileList[] = array("path" => $filePath, "file" => $webPath . '/' . $file);
                    }
                }
                $isView = true;
            }else{
                $messageHead = "Empty Folder";
                $message = "Patient folder doesnt have any image uploaded";
            }
        }else{
            $messageHead = "Folder Not Found";
            $message = "Patient folder doesnt exist on the server";
        }
    }

    if($isView){
        print_r('<div class="d-flex flex-wrap" id="image_gallery">');
        foreach ($fileList as $key => $value) { 
        
?>
    <div class="img-container ps-2 pe-2" style="display: none;">
        <div class="col pe-0">
            <div class="card shadow-sm" style="width: 25vh;">
                <div class="d-flex justify-content-center flex-column" style="width: 100%; height: 20vh; max-height: 20vh; align-items: center; padding: 5px;">
                    <img id="document_img" data-url="<?php print_r($value['file']); ?>" src="<?php print_r($value['file']); ?>" style="width: 100%; height: 98%;" onerror="this.src='/assets/custom_assets/images/noimg.png';">
                </div>
            </div>
        </div>        
    </div>
<?php
        } 
        print_r('</div>');
    // end of loop 
    // insert code for loading viewerjs
?>
    <script>
        $(document).ready(function(){
            const viewer = new Viewer(document.getElementById('image_gallery'), {
                        url: 'data-url',
                        inline: true
                        
                    });
        })
    </script>
<?php
    }else{
?>
    <script>
        $(document).ready(function(){
            const option = {
                icon: 'error',
                title: '<?php print_r($messageHead); ?>',
                text: '<?php print_r($message); ?>',
                allowOutsideClick: false,
                showConfirmButton: false
            }
            swal.fire(option);
        })
    </script>
<?php
    }
?>

