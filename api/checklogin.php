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

if (array_key_exists('HTTP_X_REQUESTED_WITH', $_SERVER) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {

    $calc = hash_hmac('sha256', '/login.php', $_SESSION['token']);

    if (array_key_exists('token', $_POST)) {
        $token = sanitize($_POST['token']);
        if (hash_equals($calc, $token)) {

            if (array_key_exists('myusername', $_POST) && array_key_exists('mypassword', $_POST)) {

                $username = sanitize($_POST['myusername']);
                $password = sanitize($_POST['mypassword']);

                $response = '';
                $loginCtl = new LoginForm;
                $conf = new GlobalConf;
                $lastAttempt = checkAttempts($username);
                $max_attempts = $conf->max_attempts;


                //First Attempt
                if ($lastAttempt['lastlogin'] == '') {

                    $lastlogin = 'never';
                    $loginCtl->insertAttempt($username);
                    $response = $loginCtl->checkLogin($username, $password);

                } elseif ($lastAttempt['attempts'] >= $max_attempts) {

                    //Exceeded max attempts
                    $loginCtl->updateAttempts($username);
                    $response = $loginCtl->checkLogin($username, $password);

                } else {

                    $response = $loginCtl->checkLogin($username, $password);

                };

                if ($lastAttempt['attempts'] < $max_attempts && $response != 'true') {

                    $loginCtl->updateAttempts($username);
                    $resp = new RespObj($username, $response);

                } else {
                    $resp = new RespObj($username, $response);
                }
            }
            else {
                $response = $success = "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>There has been an error in processing your form. Please try again.</div>";
                $resp = new RespObj(NULL, $response);
            }
        } else {
            $response = $success = "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>There has been an error in processing your form. Please try again.</div>";
            $resp = new RespObj(NULL, $response);
        }
    }
    else {
        $response = $success = "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>There has been an error in processing your form. Please try again.</div>";
        $resp = new RespObj(NULL, $response);
    }
}
else {
    $response = $success = "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>There has been an error in processing your form. Please try again.</div>";
    $resp = new RespObj(NULL, $response);
}

$jsonResp = json_encode($resp);
echo $jsonResp;
unset($resp, $jsonResp);
ob_end_flush();   
