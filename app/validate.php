<?php
	ini_set('display_errors',1); 
	error_reporting(E_ALL);

	if(isset($_COOKIE['sess']))
		$sess = $_COOKIE['sess'];
	else
		header("Location: index.php");
	$flag = false;
	$creds = fopen('creds.txt', 'r');
	while(!feof($creds)) {
		$pair = fgets($creds);
		if($sess == md5($pair))
			$flag = true;
	}
	if($flag === false)
		header("Location: index.php");
?>