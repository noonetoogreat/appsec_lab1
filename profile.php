<?php
# Gallery Web App - A PHP based Gallery application

/**
 * Profile Page
 *
 * EXPECTED BEHAVIOUR
 * - Display images uploaded by various users
 *
 * CALLS
 * - Makes an AJAX Call to api/getownimages.php to get image list to display
 * - Makes an AJAX Call to api/deleteimage.php to delete an image
 * - Makes an AJAX Call to api/updatecomment.php to update an image's comment
 *
 * RESTRICTIONS & PERMISSIONS
 * - User must be authenticated. Redirects to home.php if user is not authenticated.
 *
 * @package Gallery Web App
 * @link https://github.com/noonetoogreat/appsec_lab1.git
 *
 * @uses api/includes/session_manager.php
 */

require 'api/includes/session_manager.php';
if (!isset($_SESSION['username'])) {
    header("location:home.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Gallery Web App</title>

    <!-- Bootstrap Core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="assets/css/main.css" rel="stylesheet" media="screen">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <?php require 'assets/partials/navbar.php'; ?>

    <!-- Page Content -->
    <div class="container">

    <div id="message"></div>
    <div id="content"></div>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="assets/js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="assets/js/bootstrap.js"></script>

    <script src="assets/js/profile.js"></script>

</body>

</html>
