<?php
# Gallery Web App - A PHP based Gallery application

/**
 * Default Index Page - redirects user to the home page
 *
 * EXPECTED BEHAVIOUR
 * - Start session and redirect to home.php
 *
 * CALLS
 * This page redirects to home.php unconditionally
 *
 * RESTRICTIONS & PERMISSIONS
 * - None
 *
 * @package Gallery Web App
 * @link https://github.com/noonetoogreat/appsec_lab1.git
 *
 * @uses api/includes/session_manager.php

 */
require 'api/includes/session_manager.php';

header("location:home.php");


?>
