<?php

//SYSTEM SETTINGS
$base_url = 'http://' . $_SERVER['SERVER_NAME'];
$signin_url = substr($base_url . $_SERVER['PHP_SELF'], 0, -(6 + strlen(basename($_SERVER['PHP_SELF']))));

//REQUEST SETTINGS
$ip_address = $_SERVER['REMOTE_ADDR'];


//DATABASE CONNECTION VARIABLES
$host = "localhost"; // Host name
$username = "root"; // Mysql username
$password = ""; // Mysql password
$db_name = "testdatabase"; // Database name

//TABLE VARIABLES
$tbl_prefix = ""; 
$tbl_members = $tbl_prefix."members";
$tbl_attempts = $tbl_prefix."loginAttempts";
$tbl_images = $tbl_prefix."images";

//Set this for global site use
$site_name = 'Gallery';

//LOGIN SETTINGS
//Maximum Login Attempts
$max_attempts = 5;
//Timeout (in seconds) after max attempts are reached
$login_timeout = 300;
$timeout_minutes = round(($login_timeout / 60), 1);

//GLOBAL ERROR MESSAGES
//LOGIN FORM RESPONSE MESSAGES/ERRORS
$signupthanks = 'Thank you for signing up! Please click on the Login button to login.';

//UPLOAD SETTINGS
//Upload Directory
$upload_directory = '../tmp/';
$max_upload_size = 1024*1024*1024;
$upload_error_message = "There has been an error in processing your form. Please try again.";