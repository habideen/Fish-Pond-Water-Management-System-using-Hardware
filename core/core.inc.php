<?php  
error_reporting(0);
ob_start();
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pond";

date_default_timezone_set('Africa/Lagos'); //set default timezone

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed");
} 

function getRow( $string){
	global $conn;
	$result = $conn->query($string);
	$result = $result->fetch_assoc();
	return $result;
}

function getRows( $string){
	global $conn;
	$result = $conn->query($string);
	$result = $result->fetch_assoc();
	return $result;
}

function countRows( $string){
	global $conn;
	$result = $conn->query($string);
	$result = mysqli_num_rows($result);
	return $result;
}

function query( $string ){
	global $conn;
	if ( $conn->query($string) ) {
		return true;
	}
	else
		return false;
}

function multiQuery( $string ){
	global $conn;
	if ( $conn->multi_query($string) ) {
		return true;
	}
	else
		return false;
}

function updateReturn( $string ){
	global $conn;
	if ( $conn->multi_query($string) ) {
		$fetch = mysqli_fetch_assoc($result);
		return $fetch;
	}
	else
		return false;
}


?>