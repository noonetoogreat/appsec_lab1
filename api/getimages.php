<?php
# Gallery Web App - A PHP based Gallery application

/**
 *
 * CALLERS
 * This page is called from:
 * - profile.php
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

if (array_key_exists('HTTP_X_REQUESTED_WITH', $_SERVER) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
    $response = '';

    // Set defaults for maximum and minimum
    $minimum = 0;
    $maximum = 10;

    if (array_key_exists('minimum', $_GET) & array_key_exists('maximum', $_GET)) {
        $minimum = sanitize($_GET['minimum']);
        $maximum = sanitize($_GET['maximum']);
    }

    $imageCtl = new ImageObject;
    $conf = new GlobalConf;
    $response = $imageCtl->getImages($minimum, $maximum);

    $resp = new RespImageGalleryObj($response[0], $response[1], $response[2]);
    $jsonResp = json_encode($resp);
    echo $jsonResp;

}

unset($resp, $jsonResp);
ob_end_flush();   
