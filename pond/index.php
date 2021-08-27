<?php
header_remove("X-Powered-By"); 
header('Server: bravytech');

require_once('../core/core.inc.php');
require_once('../core/func.php');



if (isset($_SESSION['pond_user'])) {
	header('Location: dashboard.php');
}
//echo password_hash('11111111', PASSWORD_DEFAULT);



$report = '';
$username = $password = '';




//register user
if (isset($_POST['signin'])) {
	$url_control = $_GET['control'];
	if (isset($_GET['control']) && $url_control=='microL@bAce123') {
		$username = $_POST['username'];
		$username = $conn->real_escape_string($username);
		$username = noSpace($username);
		$username = strtolower($username);

		$password = $_POST['password'];

		if ($username == '' || $password == '')
			$report = 'Username/password in incorrect!';
		else {
			$sql = "SELECT password, status, username
					FROM admin_user 
					WHERE email='$username'";

			$count = countRows($sql);

			if ($count != 1)
				$report = 'Username/password incorrect!' ;
			else {
				$fetch = getRow($sql);
				$password_hash = $fetch['password'];
				$status = $fetch['status'];


				if ( !password_verify($password, $password_hash) ) 
					$report = 'Username/password incorrect!';

				elseif ($status == '0')
					$report = 'Account on suspension!';

				else {
					$username = $fetch['username'];
					$_SESSION['pond_admin'] = $username; 
					header('Location: admin_dashboard.php');
					exit();
				}//redirect user
			}//user count is 1
		}//user supplied values
	} //admin control


	else { 
		$username = $_POST['username'];
		$username = $conn->real_escape_string($username);
		$username = noSpace($username);
		$username = strtolower($username);

		$password = $_POST['password'];

		if ($username == '' || $password == '')
			$report = 'Username/password in incorrect!';
		else {
			$sql = "SELECT password, status, username
					FROM user 
					WHERE email='$username'";

			$count = countRows($sql);

			if ($count != 1)
				$report = 'Username/password incorrect!' ;
			else {
				$fetch = getRow($sql);
				$password_hash = $fetch['password'];
				$status = $fetch['status'];


				if ( !password_verify($password, $password_hash) ) 
					$report = 'Username/password incorrect!';

				elseif ($status == '0')
					$report = 'Account on suspension!';

				else {
					$username = $fetch['username'];
					$_SESSION['pond_user'] = $username; 
					header('Location: dashboard.php');
					exit();
				}//redirect user
			}//user count is 1
		}//user supplied values
	}//ordinary user
}




?>





<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>poolManager</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css?h=0175b6b498de860296f1af1a5eed3086">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css?h=0c556d5438933bda409408695b5733e7">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css?h=0c556d5438933bda409408695b5733e7">
    <link rel="stylesheet" href="assets/css/styles.min.css?h=c48b9939e54dc897daeef7735d3ec808">
</head>

<body>
    <!-- Start: Login Form Dark -->
    <div class="login-dark">
        <div class="text-center" style="padding-top:105px;">
            <div style="max-width:320px;width:90%;margin:auto auto;"><a href="#"><img class="rounded img-fluid" id="logo" src="assets/img/pond-logo.png?h=74fa24083874e52b3236bd3ce25ddcc0" style="width: 75px;height: auto;padding: 3px;background-color: #e6dfff;"></a></div>
        </div>
        <form method="post">
            <h2 class="sr-only">Login Form</h2>
            <div class="illustration"><i class="icon ion-ios-locked-outline"></i></div>
            <div class="mb-2" style="color:red;font-size:0.9em;">
            	<?php echo $report; ?>
            </div>
            <div class="form-group"><input class="form-control" type="email" name="username" placeholder="Email"></div>
            <div class="form-group"><input class="form-control" type="password" name="password" placeholder="Password"></div>
            <div class="form-group"><button name='signin' class="btn btn-primary btn-block" type="submit">Log In</button></div><a class="forgot" href="#">Forgot your email or password?</a></form>
    </div>
    <!-- End: Login Form Dark -->
    <script src="assets/js/jquery.min.js?h=83e266cb1712b47c265f77a8f9e18451"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js?h=7c038681746a729e2fff9520a575e78c"></script>
    <!--script src="https://cdn3.devexpress.com/jslib/17.1.6/js/dx.all.js"></script-->
    <script src="assets/js/script.min.js?h=2961b97ba961a9dd9543f9aafd79b4b8"></script>
</body>

</html>