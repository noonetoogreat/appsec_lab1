<?php
# Gallery Web App - A PHP based Gallery application

/**
 * Signup Page
 *
 * EXPECTED BEHAVIOUR
 * - Get username, password and email of new user and register user
 * - Redirect to home.php if registration is successful
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
		<title>Gallery Web App</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Bootstrap -->
		<link href="assets/css/bootstrap.css" rel="stylesheet" media="screen">
		<link href="assets/css/main.css" rel="stylesheet" media="screen">
	</head>

	<body>
		<div class="container">

			<form class="form-signup" id="usersignup" name="usersignup" method="post" action="createuser.php">
				<h2 class="form-signup-heading">Register</h2>
				<input type="hidden" id="token" name="token" value="<?php echo hash_hmac('sha256', '/signup.php', $_SESSION['token']); ?>"/>
				<input name="newuser" id="newuser" type="text" class="form-control" placeholder="Username" autofocus>
				<input name="email" id="email" type="text" class="form-control" placeholder="Email">
				<br>
				<input name="password1" id="password1" type="password" class="form-control" placeholder="Password">
				<input name="password2" id="password2" type="password" class="form-control" placeholder="Repeat Password">

				<button name="Submit" id="submit" class="btn btn-lg btn-primary btn-block" type="submit">Sign up</button>

				<div id="message"></div>

				<a href="login.php" class="btn btn-lg btn-primary btn-block">Login</a>
			</form>
		</div> <!-- /container -->

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="assets/js/jquery.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script type="text/javascript" src="assets/js/bootstrap.js"></script>

		<script src="assets/js/signup.js"></script>


		<script src="http://jqueryvalidation.org/files/dist/jquery.validate.min.js"></script>
		<script src="http://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>
		<script>

		$( "#usersignup" ).validate({
			rules: {
				email: {
					email: true,
					required: true
				},
				password1: {
					required: true,
					minlength: 4
				},
				password2: {
					equalTo: "#password1"
				}
			}
		});
		</script>
	</body>
</html>
