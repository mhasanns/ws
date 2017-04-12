<?php
	error_reporting(E_ALL);
	if(isset($_COOKIE['sess'])){
		unset($_COOKIE['sess']);
		setcookie('sess', null, -1, '/');
	}
	header("Location: index.php");
?>