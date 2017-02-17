<?php
require 'api/includes/session_manager.php';
if (!isset($_SESSION['username'])) {
    header("location:home.php");
}

if (function_exists('mcrypt_create_iv')) {
    $_SESSION['token'] = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
} else {
    $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
}

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

    <?php require 'assets/partials/navbar.php'; ?>


    <div class="container">
        <div class="col-md-6">
            <form class="form-signin" name="form1" method="post" action="api/checkupload.php" enctype="multipart/form-data">
                <h2 class="form-signin-heading">Select file to upload</h2>
                <input type="hidden" id="token" name="token" value="<?php echo hash_hmac('sha256', '/upload.php', $_SESSION['token']); ?>"/>

                <input name="photoname" id="photoname" type="text" class="form-control" placeholder="Filename" autofocus required>
                <input name="photo" id="photo" type="file" class="form-control" placeholder="Select File" required>
                <textarea name="photocomment" id="photocomment" type="textarea" class="form-control" placeholder="Enter your comment. Optional" rows="10" cols="50"></textarea> 
                <button name="Submit" id="submit" class="btn btn-lg btn-primary btn-block" type="submit">Upload</button>

                <div id="message"></div>

            </form>
        </div>
        <div class="col-md-6">
            <div class="col-lg-12">
                <h1 class="page-header">Uploaded Image</h1>
            </div>
            <img src="assets/images/noimage.jpg" class="img-responsive" id="success-image">
        </div>
            

    </div> <!-- /container -->
    <!-- jQuery -->
    <script src="assets/js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="assets/js/bootstrap.js"></script>

    <script src="assets/js/upload.js"></script>

</body>

</html>
