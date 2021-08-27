<?php
header_remove("X-Powered-By"); 
header('Server: bravytech');

$page_title = 'Fish Pond List';

$script_name = strtolower(basename(__FILE__, '.php'));
require_once('admin-header.php');
require_once('core/core.inc.php');
require_once('core/func.php');


if (!isset($_SESSION['pond_admin'])) 
	header('Location: index.php');


$username = $_SESSION['pond_admin'];
$report = '';



if (isset($_POST['activate']) && is_post_request()) {
	$pond = $_POST['activate'];
	$pond = $conn->real_escape_string($pond);

	$sql = "UPDATE $dbname.user
			SET status='1'
			WHERE username='$pond'
			LIMIT 1";

	if ( query($sql) ) 
		$report = "$pond activated";
	else
		$report = 'Please try again';
}

elseif (isset($_POST['deactivate']) && is_post_request()) {
	$pond = $_POST['deactivate'];
	$pond = $conn->real_escape_string($pond);

	$sql = "UPDATE $dbname.user
			SET status='0'
			WHERE username='$pond'
			LIMIT 1";

	if ( query($sql) ) 
		$report = "$pond deactivated";
	else
		$report = 'Please try again';
}



?>

<style>
form button{
	min-width:120px;
}

/* Hide scrollbar for Chrome, Safari and Opera */
#table-div::-webkit-scrollbar {
    display: none;
}

/* Hide scrollbar for IE, Edge and Firefox */
#table-div {
  -ms-overflow-style: none;  /* IE and Edge */
  scrollbar-width: none;  /* Firefox */
}
@media (max-width:440px){
	.container.mb-5{padding:0px;}
	.rounded{padding:10px 5px !important;}
}
</style>

    <section class="features-icons bg-light" style="padding-top: 3rem;padding-bottom: 0rem;color: #09152a;">
        <div class="container mb-5" style=''>
            <div class="" id="settings-row" style="padding-bottom:0px;width:100% !important;">
                <div class="p-3">
                    <div class="rounded" style='background-color:#fefefe;padding:20px;border-radius:5px'>
                        <h4 class='mb-3 text-center'>Registered Fish Ponds</h4>
                        <div class="text-center" style='color:red;font-style:italic;font-size:1em;'><?php echo $report; ?></div>

                        <div id='table-div' style='overflow-x:auto;'>
                        	<table id="example2" class="table table-bordered table-hover">
				                <thead>
				                <tr>
				                  <th>SN</th>
				                  <th>Username</th>
				                  <th>Email</th>
				                  <th>Pond Name</th>
				                  <th>Location</th>
				                  <th>Settings</th>
				                </tr>
				                </thead>
				                <tbody>
<?php
$sql = "SELECT 
		username, email, farm_name, location, regdate, status
	FROM $dbname.user
	ORDER BY status DESC, regdate ASC";

$count = countRows($sql);

if ($count < 1)
echo '<tr> <td colspan="6">User table is empty.</td> </tr>';
else{ 
$table = ''; $sn = 0;
$result = mysqli_query($conn, $sql);
while ($fetch = mysqli_fetch_assoc($result)) {
	$username = $fetch['username'];
	$email = $fetch['email'];
	$farm_name = $fetch['farm_name'];
	$location = $fetch['location'];
	
	$status = $fetch['status'];
	if ($status=='1') {
		$status = "<form method='post' action=''>
						<button class='btn btn-danger form-control' name='deactivate' value='$username'>Deactivate</button>
					</form>";
	}
	elseif ($status=='0') {
		$status = "<form method='post' action=''>
						<button class='btn btn-success form-control' name='activate' value='$username'>Activate</button>
					</form>";
	}

	$regdate = $fetch['regdate'];
	$regdate = date('d M, Y', strtotime($regdate));
	
	++$sn;
	$table .= "<tr>
					<td>$sn</td>
					<td>$username</td>
					<td>$email</td>
					<td>$farm_name</td>
					<td>$location</td>
					<td>$status</td>
				</tr>";
}
echo $table;
}

?>
				                </tbody>
				            </table>
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

    <link rel='stylesheet' href='assets/datatables-bs4/css/dataTables.bootstrap4.css'>
    <script src='assets/datatables/jquery.dataTables.js'></script>
	<script src='assets/datatables-bs4/js/dataTables.bootstrap4.min.js'></script>

    <script>
    	//prevent resubmission of post
		if ( window.history.replaceState ) {
			window.history.replaceState(null, null, window.location.href);
		}
		
		$(function () { $("#example2").DataTable(); });
	</script>
</body>

</html>