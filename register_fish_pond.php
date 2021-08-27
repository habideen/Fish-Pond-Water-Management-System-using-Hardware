<?php
header_remove("X-Powered-By"); 
header('Server: bravytech');

$page_title = 'Register Fish Pond';

$script_name = strtolower(basename(__FILE__, '.php'));
require_once('admin-header.php');
require_once('core/core.inc.php');
require_once('core/func.php');


if (!isset($_SESSION['pond_admin'])) 
	header('Location: index.php');


$username = $_SESSION['pond_admin'];
$report = '';



if ( isset($_POST['register']) ) {
	$reg_username = $_POST['reg_username'];
	$reg_username = $conn->real_escape_string($reg_username);
	$reg_username = noSpace($reg_username);
	$reg_username = strtolower($reg_username);
	if ($reg_username=='')
		$reg_username_error='Invalid username';

	$sql = "SELECT COUNT(username) AS exist
			FROM $dbname.user 
			WHERE username='$reg_username'";
	$fetch = getRow($sql);
	$fetch = $fetch['exist'];
	if ($fetch > 0)
		$reg_username_exist = 'Username already exist';


	$reg_email = $_POST['reg_email'];
    $reg_email = $conn->real_escape_string($reg_email);
    $reg_email = trim($reg_email);
    $reg_email = strtolower($reg_email);
    if ( !(filter_var($reg_email, FILTER_VALIDATE_EMAIL)) )
        $reg_email_error = 'Invalid email';

    $sql = "SELECT COUNT(email) AS exist
			FROM $dbname.user 
			WHERE email='$reg_email'";
	$fetch = getRow($sql);
	$fetch = $fetch['exist'];
	if ($fetch > 0)
		$reg_email_exist = 'Email already exist';


	$reg_farmname = $_POST['reg_farmname'];
    $reg_farmname = trim($_POST['reg_farmname']);
    $reg_farmname = $conn->real_escape_string($reg_farmname);
    $reg_farmname = space($reg_farmname);
    if ( $reg_farmname == '' )
        $reg_farmname_error = 'Invalid farm name';


	$reg_location = $_POST['reg_location'];
    $reg_location = trim($_POST['reg_location']);
    $reg_location = $conn->real_escape_string($reg_location);
    $reg_location = space($reg_location);
    if ( $reg_location == '' || strlen($reg_location)<5 )
        $reg_location_error = 'Invalid farm location';



    if ($reg_username_error != '')
    	$report = $reg_username_error;

    elseif ($reg_username_exist != '')
    	$report = $reg_username_exist;

    elseif ($reg_email_error != '')
    	$report = $reg_email_error;

    elseif ($reg_email_exist != '')
    	$report = $reg_email_exist;

    elseif ($reg_farmname_error != '')
    	$report = $reg_farmname_error;

    elseif ($reg_location_error != '')
    	$report = $reg_location_error;

    else { //error not found
    	$password = password_hash($reg_username, PASSWORD_DEFAULT);
    	$sql = "INSERT INTO $dbname.user
    			VALUES ('$reg_username',
    					'$reg_email',
    					'$password',
    					'$reg_farmname',
    					'$reg_location',
    					CURRENT_TIMESTAMP,
    					'0')";
    	if ( query($sql) ) {
    		$report = "Register was successful.<br>
    					Username: $reg_username<br>
    					Password: $reg_username";
    		$reg_username = $reg_email = $reg_farmname = $reg_location = '';
    	}
    	else {
    		$report = 'Error! Please try again.';
    	}
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
                                <h4 class='mb-3'>Register Farm</h4>
                                <div style='color:red;font-style:italic;font-size:0.9em;'><?php echo $report; ?></div>
                                <input class="form-control mb-3" type="text" name="reg_username" placeholder="Username" pattern="^[a-zA-Z_-0-9]+$" required value='<?php echo $reg_username; ?>'>

                                <input class="form-control mb-3" type="email" name="reg_email" placeholder="Email" required value='<?php echo $reg_email; ?>'>

                                <input class="form-control mb-4" type="text" name="reg_farmname" placeholder="Farm name" pattern="^[a-zA-Z -_0-9]+$" minlenth="8" maxlenth="100" required value='<?php echo $reg_farmname; ?>'>

                                <input class="form-control mb-4" type="text" name="reg_location" placeholder="Location" minlenth="5" pattern="^[a-zA-Z0-9 .,-_]+$" required value='<?php echo $reg_location; ?>'>

                                <button class="btn btn-dark" type="submit" name='register'>Register User</button></form>
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
    <script>
    	//prevent resubmission of post
		if ( window.history.replaceState ) {
			window.history.replaceState(null, null, window.location.href);
		}
	</script>
</body>

</html>