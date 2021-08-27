<?php  

function is_post_request(){
	return $_SERVER['REQUEST_METHOD'] == 'POST';
}

function allcap($data){
	$data = trim($data);
	$data = $data = str_replace('    ', ' ', $data);
	$data = $data = str_replace('   ', ' ', $data);
	$data = $data = str_replace('  ', ' ', $data);
	$data = strtoupper($data);
	
	return $data;
}

function space($data){
	$data = trim($data);
	$data = str_replace('    ', ' ', $data);
	$data = str_replace('   ', ' ', $data);
	$data = str_replace('  ', ' ', $data);
	return $data;
}

function noSpace($data){
	$data = trim($data);
	$data = str_replace(' ', '', $data);
	return $data;
}

function firstWordCap($data){
	$data = trim($data);
	$data = str_replace('    ', ' ', $data);
	$data = str_replace('   ', ' ', $data);
	$data = str_replace('  ', ' ', $data);
	$data = strtoupper($data);
	return $data;
}

function isAlpha($data){
	$data = space($data);
	$pass = true;
	if ( strlen($data) > 0 ) {
		$data = explode(" ", $data);
		foreach ($data as $key) {
			if ( !ctype_alpha($key) ) {
				$pass = false;
				break;	
			}
		}
		return $pass;
	}
	else {
		return false;
	}
}

function isDate($date_time) {
	$date_time = noSpace($date_time);
    $date_time = explode('-', $date_time);

    if (count($date_time) != 3) 	
    	return false;
    elseif ( checkdate($date_time[1], $date_time[2], $date_time[0]) )
    	return true;
    else
    	return false;
}

function activeStatus($data) {
	if ($data == '1')
		return 'Active';
	elseif ($data == '0')
		return 'In-active';
	else
		return '';
}

function gender($data) {
	$data = strtolower($data);
	if ($data == 'm')
		return 'Male';
	elseif ($data == 'f')
		return 'Female';
	else
		return '';
}

function formStatus($data) {
	$data = strtolower($data);
	if ($data == 'a')
		return 'Completed';
	elseif ($data == 'p')
		return 'Pending';
	elseif ($data == 'r')
		return 'Rejected';
	else
		return '';
}


function zipFolder($inputFolder, $outputFile) {
	// Get real path for our folder
	$rootPath = realpath($inputFolder);

	// Initialize archive object
	$zip = new ZipArchive();
	$zip->open($outputFile, ZipArchive::CREATE | ZipArchive::OVERWRITE);

	// Create recursive directory iterator
	/** @var SplFileInfo[] $files */
	$files = new RecursiveIteratorIterator(
	    new RecursiveDirectoryIterator($rootPath),
	    RecursiveIteratorIterator::LEAVES_ONLY
	);

	foreach ($files as $name => $file)
	{
	    // Skip directories (they would be added automatically)
	    if (!$file->isDir())
	    {
	        // Get real and relative path for current file
	        $filePath = $file->getRealPath();
	        $relativePath = substr($filePath, strlen($rootPath) + 1);

	        // Add current file to archive
	        $zip->addFile($filePath, $relativePath);
	    }
	}

	// Zip archive will be created only after closing object
	$zip->close();
}


?>