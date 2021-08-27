<?php
header_remove("X-Powered-By"); 
header('Server: bravytech');

require_once('../core/core.inc.php');
require_once('../core/func.php');



if (!isset($_SESSION['pond_user'])) 
	header('Location: index.php');

$username = $_SESSION['pond_user'];


$sql = "SELECT depth, temp, acidity, turbidity, regdate
		FROM $dbname.received
		WHERE username='$username'
		ORDER BY regdate DESC
		LIMIT 1";
$fetch = getRow($sql);

$received_time = $fetch['regdate'];
$received_time = date('d-M g:ia');

echo $fetch['depth'] . ';' 
		. $fetch['temp'] . ';' 
		. $fetch['acidity'] . ';' 
		. $fetch['turbidity'] . ';' 
		. $received_time;

?>