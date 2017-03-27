<?php
# Gallery Web App - A PHP based Gallery application

/**
 *
 * CALLERS
 * This page is called from:
 * - login.php
 *
 * EXPECTED BEHAVIOUR
 * - checks is username and password provided are valid and 
 *
 * OUTPUT
 * - (username, true) => login success
 * - (NULL, error message) => login failure
 *
 * CALLS
 * - Calls api/includes/loginform.php:checkLogin()
 *
 * RESTRICTIONS & PERMISSIONS
 * - User must be authenticated
 * - Request must be through AJAX
 *
 * @package Gallery Web App
 * @link https://github.com/noonetoogreat/appsec_lab1.git
 *
 * @uses api/config.php
 * @uses api/includes/functions.php
 */

session_start();

ob_start();
include 'config.php';
require 'includes/functions.php';

// Define $myusername and $mypassword
$calc = hash_hmac('sha256', '/upload.php', $_SESSION['token']);

// Check for CSRF token
if (array_key_exists('token', $_POST)) {
    $token = sanitize($_POST['token']);
    // Check if CSRF token is valid
    if (hash_equals($calc, $token)) {
        // Check for all required variables
        if (array_key_exists('photo', $_FILES) && array_key_exists('photoname', $_POST) && array_key_exists('photocomment', $_POST)) {

            // Get required variables
            $photo = $_FILES['photo'];
            $photoname = sanitize($_POST['photoname']);
            $photocomment = sanitize($_POST['photocomment']);

            $response = '';
            $uploadCtl = new UploadForm;
            $conf = new GlobalConf;

            $request_status = false;

            // Check for AJAX request
            if (!(array_key_exists('HTTP_X_REQUESTED_WITH', $_SERVER) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
                $request_status = true; 
            }

            // File size check
            if (filesize($photo['tmp_name']) > $max_upload_size) {
                $request_status = true;
            }

            $image_status = false;

            // Check 1 - Checking the fileype from the uploaded form
            switch(strtolower($photo['type']))
            {
                //allowed file types
                case 'image/png': 
                case 'image/gif': 
                case 'image/jpeg': 
                case 'image/jpg':
                    $image_status = false;
                    break;
                default:
                    $image_status = true;
            }

            // Check 2 - Check MIME type
            $file_info = getimagesize($photo['tmp_name']); 
            $file_mime = $file_info['mime'];

            switch($file_mime) {
                //allowed file types
                case 'image/png': 
                case 'image/gif': 
                case 'image/jpeg': 
                case 'image/jpg':
                    $image_status = false;
                    break;
                default:
                    $image_status = true;
            }

            // Adding file to Database
            if (!($request_status || $image_status)) {
                $file_name          = strtolower(sanitize($photo['name']));

                $file_ext           = substr($file_name, strrpos($file_name, '.')); //get file extention

                $upload_time         = time();
                $file_name_hash     = hash ( 'sha256' , $upload_time.$file_name );
                $permenant_url      = $upload_directory.$file_name_hash;
                
                $response = '';

                if(move_uploaded_file($photo['tmp_name'], $permenant_url )) {
                    $response = $uploadCtl->insertImage($photoname, $file_name, $file_ext, $file_name_hash, $_SESSION['user_id'], $upload_time, $photocomment);
                    $respose_status = true;

                    $resp = new RespImageObj($respose_status, $response, $permenant_url);
                } 
                else {
                    $response = $success = "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>".$upload_error_message."4</div>";
                    $resp = new RespImageObj(false, $response, NULL);
                }
            }
            else {
                $response = $success = "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>".$upload_error_message."3</div>";
                $resp = new RespImageObj(false, $response, NULL);
            } 
        }
        else {
            $response = $success = "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>".$upload_error_message."2</div>";
            $resp = new RespImageObj(false, $response, NULL);
        }      
        
    } else {
        $response = $success = "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>".$upload_error_message."1</div>";
        $resp = new RespImageObj(false, $response, NULL);
    }
}
else {
    $response = $success = "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>".$upload_error_message."</div>";
    $resp = new RespImageObj(false, $response, NULL);
    
}

$jsonResp = json_encode($resp);
echo $jsonResp;
unset($resp, $jsonResp);
ob_end_flush();   
