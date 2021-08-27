<?php

// Hearders
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
//header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');


require_once('../core/core.inc.php');

$data = json_decode(file_get_contents("php://input"));


$user = $_GET['user'];
$depth = $_GET['depth'];
$temp = $_GET['temp'];
$acidity = $_GET['acidity'];
$turbidity = $_GET['turbidity'];


if ( !preg_match('/[1-9][0-9]+$/', $depth) 
	|| !preg_match('/[1-9][0-9]+$/', $temp) 
	|| !preg_match('/[1-9][0-9]+$/', $acidity) 
	|| !preg_match('/[1-9][0-9]+$/', $turbidity) 
	|| $user == '' ) {

	echo json_encode(
	    array('message'=> 'Error')
	); return;
}




$sql = "SELECT username FROM $dbname.user WHERE username='$user'";
$count = countRows($sql);
if ($count != 1) {
	echo json_encode(
	    array('message'=> 'Error')
	);
	exit();
}


$sql = "INSERT INTO received 
		VALUES (NULL,
				'$user', '$depth', '$temp', 
				'$acidity', '$turbidity', CURRENT_TIMESTAMP)";
query($sql);

echo json_encode(
	    array('message'=> mysqli_error($conn))
	);



?>