<?php
# Gallery Web App - A PHP based Gallery application

/**
 *
 * CALLERS
 * This page is called from:
 * - profile.php
 *
 * EXPECTED BEHAVIOUR
 * - Returns 
 *
 * OUTPUT
 * - (true, image_count, image_data) => login success
 * - (false, NULL, NULL) => Request not through 
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

//Checking if the request is via AJAX
if (array_key_exists('HTTP_X_REQUESTED_WITH', $_SERVER) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {

    $imageCtl = new ImageObject;
    $conf = new GlobalConf;
    $response = $imageCtl->getOwnImages();

    $resp = new RespImageGalleryObj($response[0], $response[1], $response[2]);
    $jsonResp = json_encode($resp);
    echo $jsonResp;

}
else {
	$resp = new RespImageGalleryObj(false, NULL, NULL);
    $jsonResp = json_encode($resp);
    echo $jsonResp;
}

unset($resp, $jsonResp);
ob_end_flush();   
