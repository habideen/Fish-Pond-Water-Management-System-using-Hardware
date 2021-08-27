<?php
header_remove("X-Powered-By"); 
header('Server: bravytech');

$script_name = strtolower(basename(__FILE__, '.php'));
$dashboard = ($script_name=='dashboard')? '#' : 'dashboard.php';
$settings = ($script_name=='settings')? '#' : 'settings.php';
$password = ($script_name=='password')? '#' : 'password.php';
require_once('page-header.php');
require_once('../core/core.inc.php');
require_once('../core/func.php');


if (!isset($_SESSION['pond_user'])) 
	header('Location: index.php');

$username = $_SESSION['pond_user'];


$current_error = $new1_error = $new2_error = "";
//update user information 
if (isset($_POST['update'])) {
	$current = $_POST['current'];

	$new1 = $_POST['new1'];
	$new2 = $_POST['new2'];

	$sql = "SELECT password FROM $dbname.user WHERE username='$username'";
	$count = countRows($sql);
	$row = getRow($sql);
	$old = $row['password'];

	if ( !password_verify($current, $old) )
		$report = 'Error: Incorrect current password!';

	elseif ( password_verify($new, $old) )
		$report = 'Error: You cannot use your old password!';

	elseif (strlen($new1) < 8)
		$report = 'Error: New password length should is less than 8!';

	elseif ( !preg_match('/[a-z]+/', $new1) 
		|| !preg_match('/[A-Z]+/', $new1) 
		|| !preg_match('/[0-9]+/', $new1) 
		|| strlen($new1) < 8 )
		$report = "Error: Weak password!";

	elseif ($new1 != $new2) 
		$report = 'Error: New password does not match each other!';

	else {
		$password = password_hash($new1, PASSWORD_BCRYPT, ['cost' => 10]);
		$sql = "UPDATE $dbname.user
				SET 
					password='$password'
				WHERE username='$username'";
		if ( query($sql) ) 
			$report = 'Password updated';
		else
			$report = 'Error: Not updated';
	}
}



?>

    <section class="features-icons bg-light text-center" style="padding-top: 3rem;padding-bottom: 0rem;color: #09152a;">
        <div class="container mb-5">
            <div class="row justify-content-center gauge-container" id="settings-row" style="padding-bottom:0px;">
                <div class="col-sm-12 col-md-6 col-lg-4 p-3">
                    <div style="background-color: #e6e6e6;">
                        <div class="rounded" style="background-color: #eaeaea;">
                            <form class="p-3" method="post">
                                <h4>Change password</h4>
                                <div style='color:red;font-style:italic;font-size:0.9em;'><?php echo $report; ?></div>
                                <input class="form-control mb-4" type="password" name="current" placeholder="Old password" required value='11111111'>

                                <input class="form-control mb-2" type="password" name="new1" placeholder="New password" min="1" minlenth="8" required value='11111111'>

                                <input class="form-control mb-3" type="password" name="new2" placeholder="Confirm password" minlenth="8" required value='11111111'>

                                <button class="btn btn-dark" type="submit" name='update'>Change</button></form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <footer class="footer bg-light" style="background-color: #e6e6e6 !important; padding-bottom:5px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 my-auto h-100 text-center text-lg-left">
                    <ul class="list-inline mb-2">
                        <li class="list-inline-item"><a href="#">About</a></li>
                        <li class="list-inline-item"><span>⋅</span></li>
                        <li class="list-inline-item"><a href="#">Contact</a></li>
                        <li class="list-inline-item"><span>⋅</span></li>
                        <li class="list-inline-item"><a href="#">Terms of &nbsp;Use</a></li>
                        <li class="list-inline-item"><span>⋅</span></li>
                        <li class="list-inline-item"><a href="#">Privacy Policy</a></li>
                    </ul>
                    <p class="text-muted small mb-4 mb-lg-0">© Intellifarms Pool Manager 2020. All Rights Reserved.</p>
                </div>
                <div class="col-lg-6 my-auto h-100 text-center text-lg-right">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item"><a href="#"><i class="fa fa-facebook fa-2x fa-fw"></i></a></li>
                        <li class="list-inline-item"><a href="#"><i class="fa fa-twitter fa-2x fa-fw"></i></a></li>
                        <li class="list-inline-item"><a href="#"><i class="fa fa-instagram fa-2x fa-fw"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <script src="assets/js/jquery.min.js?h=83e266cb1712b47c265f77a8f9e18451"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js?h=7c038681746a729e2fff9520a575e78c"></script>
    <script src="https://cdn3.devexpress.com/jslib/17.1.6/js/dx.all.js"></script>
    <script src="assets/js/script.min.js?h=2961b97ba961a9dd9543f9aafd79b4b8"></script>
</body>

</html>