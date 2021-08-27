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


$sql = "SELECT username 
		FROM $dbname.pool_limit
		WHERE username='$username'";
$count = countRows($sql);
if ($count<1) {
	query("INSERT INTO $dbname.pool_limit
			VALUES ('$username',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'')"); 
}// create table if it doesn't exist


$depth_report = $temp_report = $turb_report = $ph_report = '';



//depth settings
if (isset($_POST['depth-frm']) && is_post_request()) {
	$min_depth = $_POST['min-depth'];
	$max_depth = $_POST['max-depth'];

	if ( !ctype_digit($min_depth) || $min_depth<0 || $min_depth>100000 || $min_depth>=$max_depth
		 || !ctype_digit($max_depth) || $max_depth<0 || $max_depth>100000 || $max_depth<=$min_depth ) 
		$depth_report = 'Error in input';

	if ($depth_report=='') {
		$sql = "UPDATE $dbname.pool_limit
				SET 
					min_depth='$min_depth',
					max_depth='$max_depth'
				WHERE username='$username'";
		if ( query($sql) )
			$depth_report = 'Updated';
		else
			$depth_report = 'Please try again later';
	}
} //form submitted
else {
	$sql = "SELECT min_depth, max_depth
			FROM $dbname.pool_limit
			WHERE username='$username'";
	$fetch = getRow($sql);
	$min_depth = $fetch['min_depth'];
	$max_depth = $fetch['max_depth'];
} //get value from db



//temp settings
if (isset($_POST['temp-frm']) && is_post_request()) {
	$min_temp = $_POST['min-temp'];
	$max_temp = $_POST['max-temp'];

	if ( !ctype_digit($min_temp) || $min_temp<0 || $min_temp>100 || $min_temp>=$max_temp
		 || !ctype_digit($max_temp) || $max_temp<0 || $max_temp>100 || $max_temp<=$min_temp ) 
		$temp_report = 'Error in input';

	if ($temp_report=='') {
		$sql = "UPDATE $dbname.pool_limit
				SET 
					min_temp='$min_temp',
					max_temp='$max_temp'
				WHERE username='$username'";
		if ( query($sql) )
			$temp_report = 'Updated';
		else
			$temp_report = 'Please try again later';
	}
} //form submitted
else {
	$sql = "SELECT min_temp, max_temp
			FROM $dbname.pool_limit
			WHERE username='$username'";
	$fetch = getRow($sql);
	$min_temp = $fetch['min_temp'];
	$max_temp = $fetch['max_temp'];
} //get value from db



//turb settings
if (isset($_POST['turb-frm']) && is_post_request()) {
	$min_turb = $_POST['min-turb'];
	$max_turb = $_POST['max-turb'];

	if ( !ctype_digit($min_turb) || $min_turb<0 || $min_turb>100 || $min_turb>=$max_turb
		 || !ctype_digit($max_turb) || $max_turb<0 || $max_turb>100 || $max_turb<=$min_turb ) 
		$turb_report = 'Error in input';

	if ($turb_report=='') {
		$sql = "UPDATE $dbname.pool_limit
				SET 
					min_turb='$min_turb',
					max_turb='$max_turb'
				WHERE username='$username'";
		if ( query($sql) )
			$turb_report = 'Updated';
		else
			$turb_report = 'Please try again later';
	}
} //form submitted
else {
	$sql = "SELECT min_turb, max_turb
			FROM $dbname.pool_limit
			WHERE username='$username'";
	$fetch = getRow($sql);
	$min_turb = $fetch['min_turb'];
	$max_turb = $fetch['max_turb'];
} //get value from db



//ph settings
if (isset($_POST['ph-frm']) && is_post_request()) {
	$min_ph = $_POST['min-ph'];
	$max_ph = $_POST['max-ph'];

	if ( !ctype_digit($min_ph) || $min_ph<0 || $min_ph>14 || $min_ph>=$max_ph
		 || !ctype_digit($max_ph) || $max_ph<0 || $max_ph>14 || $max_ph<=$min_ph ) 
		$ph_report = 'Error in input';

	if ($ph_report=='') {
		$sql = "UPDATE $dbname.pool_limit
				SET 
					min_ph='$min_ph',
					max_ph='$max_ph'
				WHERE username='$username'";
		if ( query($sql) )
			$ph_report = 'Updated';
		else
			$ph_report = 'Please try again later';
	}
} //form submitted
else {
	$sql = "SELECT min_ph, max_ph
			FROM $dbname.pool_limit
			WHERE username='$username'";
	$fetch = getRow($sql);
	$min_ph = $fetch['min_ph'];
	$max_ph = $fetch['max_ph'];
} //get value from db




?>

    <section class="features-icons bg-light text-center" style="padding-top: 3rem;padding-bottom: 0rem;color: #09152a;">
        <div class="container mb-5">
            <div class="row justify-content-center gauge-container" id="settings-row" style="padding-bottom:0px;">
                <div class="col-sm-12 col-md-6 col-lg-4 p-3">
                    <div style="background-color: #e6e6e6;">
                        <div class="rounded" style="background-color: #eaeaea;">
                            <form class="p-3" method="post">
                                <h4>Depth (cm)</h4>
                                <div style='color:red;font-style:italic;font-size:0.9em;'><?php echo $depth_report; ?></div>
                                <div class="input-group mb-3">
			            			<div class="input-group-prepend">
			            				<span class="input-group-text">Min</span>
			            			</div>
			                    	<input class="form-control " type="number" id="min-depth" name="min-depth" placeholder="eg 100" min="1" max="1000" value='<?php echo $min_depth; ?>' required>
			                    </div>
                                <div class="input-group mb-3">
			            			<div class="input-group-prepend">
			            				<span class="input-group-text">Max</span>
			            			</div>
			                    	<input class="form-control" type="number" id="max-depth" name="max-depth" placeholder="eg 320" min="1" max="1000" value='<?php echo $max_depth; ?>' required>
			                    </div>
                                <button class="btn btn-dark" type="submit" name='depth-frm'>Save</button></form>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4 p-3">
                    <div style="background-color: #e6e6e6;">
                        <div class="rounded" style="background-color:#eaeaea;">
                            <form class="p-3" method="post">
                                <h4>Temperature (<sup>0</sup>C)</h4> 
                                <div style='color:red;font-style:italic;font-size:0.9em;'><?php echo $temp_report; ?></div>                               
                                <div class="input-group mb-3">
			            			<div class="input-group-prepend">
			            				<span class="input-group-text">Min</span>
			            			</div>
			                    	<input class="form-control" type="number" id="min-temp" name="min-temp" placeholder="eg 19" min="1" max="100" value='<?php echo $min_temp; ?>' required>
			                    </div>
                                <div class="input-group mb-3">
			            			<div class="input-group-prepend">
			            				<span class="input-group-text">Max</span>
			            			</div>
			                    	<input class="form-control" type="number" id="max-temp" name="max-temp" placeholder="eg 75" min="1" max="100" value='<?php echo $max_temp; ?>' required>
			                    </div>
			                    <button class="btn btn-dark" type="submit" name='temp-frm'>Save</button></form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center gauge-container" id="settings-row-1" style="padding-bottom:0px;">
                <div class="col-sm-12 col-md-6 col-lg-4 p-3">
                    <div style="background-color: #e6e6e6;">
                        <div class="rounded" style="background-color:#eaeaea;">
                            <form class="p-3" method="post">
                                <h4>Turbidity (%)</h4>    
                                <div style='color:red;font-style:italic;font-size:0.9em;'><?php echo $turb_report; ?></div>                         
                                <div class="input-group mb-3">
			            			<div class="input-group-prepend">
			            				<span class="input-group-text">Min</span>
			            			</div>
			                    	<input class="form-control" type="number" id="min-turb" name="min-turb" placeholder="eg 75" min="1" max="100" value='<?php echo $min_turb; ?>' required>
			                    </div>
                                <div class="input-group mb-3">
			            			<div class="input-group-prepend">
			            				<span class="input-group-text">Max</span>
			            			</div>
			                    	<input class="form-control" type="number" id="max-turb-1" name="max-turb" placeholder="eg 100" min="1" max="100" value='<?php echo $max_turb; ?>' required>
			                    </div>
			                    <button class="btn btn-dark" type="submit" name='turb-frm'>Save</button></form>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4 p-3">
                    <div style="background-color: #e6e6e6;">
                        <div class="rounded" style="background-color:#eaeaea;">
                            <form class="p-3" method="post">
                                <h4>PH (1-14)</h4>  
                                <div style='color:red;font-style:italic;font-size:0.9em;'><?php echo $ph_report; ?></div>                           
                                <div class="input-group mb-3">
			            			<div class="input-group-prepend">
			            				<span class="input-group-text">Min</span>
			            			</div>
			                    	<input class="form-control" type="number" id="max-ph" name="min-ph" placeholder="eg 7" min="1" max="14" value='<?php echo $min_ph; ?>' required>
			                    </div>
                                <div class="input-group mb-3">
			            			<div class="input-group-prepend">
			            				<span class="input-group-text">Max</span>
			            			</div>
			                    	<input class="form-control" type="number" id="max-ph" name="max-ph" placeholder="eg 9" min="1" max="14" value='<?php echo $max_ph; ?>' required>
			                    </div>
			                    <button class="btn btn-dark" type="submit" name='ph-frm'>Save</button></form>
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