<?php
# Gallery Web App - A PHP based Gallery application

/**
 *
 * CALLERS
 * This page is called from:
 * - signup.php
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

require 'includes/functions.php';
include_once 'config.php';

session_start();

$calc = hash_hmac('sha256', '/signup.php', $_SESSION['token']);

// Check for AJAX request
if (array_key_exists('HTTP_X_REQUESTED_WITH', $_SERVER) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
    // Get CSRF token
    if (array_key_exists('token', $_POST)) {

        $token = sanitize($_POST['token']);

        // Check if CSRF token is valid
        if (hash_equals($calc, $token)) {

            // Check if all required variables are present
            if (array_key_exists('newuser', $_POST) && array_key_exists('password1', $_POST) && array_key_exists('password2', $_POST) && array_key_exists('email', $_POST)) {

                //Pull username, generate new ID and hash password
                $newid = uniqid(rand(), false);
                $newuser = sanitize($_POST['newuser']);
                $newpw = password_hash(sanitize($_POST['password1']), PASSWORD_DEFAULT);
                $pw1 = sanitize($_POST['password1']);
                $pw2 = sanitize($_POST['password2']);
                $newemail = sanitize($_POST['email']);

                //Validation rules
                if ($pw1 != $pw2) {

                    echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Password fields must match</div><div id="returnVal" style="display:none;">false</div>';

                } elseif (strlen($pw1) < 4) {

                    echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Password must be at least 4 characters</div><div id="returnVal" style="display:none;">false</div>';

                } elseif (!filter_var($newemail, FILTER_VALIDATE_EMAIL) == true) {

                    echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Must provide a valid email address</div><div id="returnVal" style="display:none;">false</div>';

                } else {
                    //Validation passed
                    if (isset($_POST['newuser']) && !empty(str_replace(' ', '', $_POST['newuser'])) && isset($_POST['password1']) && !empty(str_replace(' ', '', $_POST['password1']))) {

                        //Tries inserting into database and add response to variable

                        $a = new NewUserForm;

                        $response = $a->createUser($newuser, $newid, $newemail, $newpw);

                        //Success
                        if ($response == 'true') {

                            echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'. $signupthanks .'</div><div id="returnVal" style="display:none;">true</div>';

                        } else {
                            //Failure
                            mySqlErrors($response);

                        }
                    } else {
                        //Validation error from empty form variables
                        echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>There has been an error in processing your form. Please try again.</div><div id="returnVal" style="display:none;">false</div>';
                    }
                }
            }
            else {
                echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>There has been an error in processing your form. Please try again.</div><div id="returnVal" style="display:none;">false</div>';
            }
        }
        else {
            echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>There has been an error in processing your form. Please try again.</div><div id="returnVal" style="display:none;">false</div>';
        } 
    }
    else {
        echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>There has been an error in processing your form. Please try again.</div><div id="returnVal" style="display:none;">false</div>';
    }
} 
else {
    echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>There has been an error in processing your form. Please try again.</div><div id="returnVal" style="display:none;">false</div>';
}  

