<?php
# Gallery Web App - A PHP based Gallery application

/**
 * Login Page
 *
 * EXPECTED BEHAVIOUR
 * - Get username and password and signin user
 * - Redirect to profile.php if login is successful
 *
 * CALLS
 * This page conditionally redirects upon completion
 *
 * RESTRICTIONS & PERMISSIONS
 * - No restricts
 *
 * @package Gallery Web App
 * @link https://github.com/noonetoogreat/appsec_lab1.git
 *
 * @uses api/includes/session_manager.php
 */

require 'api/includes/session_manager.php';
if (isset($_SESSION['username'])) {
    header("location:profile.php");
}

//if (empty($_SESSION['token'])) {
if (function_exists('mcrypt_create_iv')) {
    $_SESSION['token'] = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
} else {
    $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
}
//}
$token = $_SESSION['token'];

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
        <div class="container">

            <form class="form-signin" name="form1" method="post" action="checklogin.php">
                <h2 class="form-signin-heading">Please sign in</h2>
                <input type="hidden" id="token" name="token" value="<?php echo hash_hmac('sha256', '/login.php', $_SESSION['token']); ?>"/>
                <input name="myusername" id="username" type="text" class="form-control" placeholder="Username" autofocus>
                <input name="mypassword" id="password" type="password" class="form-control" placeholder="Password">
                <button name="Submit" id="submit" class="btn btn-lg btn-primary btn-block" type="submit">Login</button>

                <div id="message"></div>

                <a href="signup.php" class="btn btn-lg btn-primary btn-block">Register</a>
            </form>

        </div> <!-- /container -->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="assets/js/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script type="text/javascript" src="assets/js/bootstrap.js"></script>
    <!-- The AJAX login script -->
    <script src="assets/js/login.js"></script>

  </body>
</html>
