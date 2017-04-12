<?php
	ini_set('display_errors',1); 
	error_reporting(E_ALL);
	if($_POST['username'] && $_POST['password']){
		$creds = fopen('creds.txt', 'r');
		while(!feof($creds)) {
			$pair = fgets($creds);
			if($_POST['username'] == explode(':', $pair)[0]){
				if($_POST['password'] == explode(':', $pair)[1]){
					$sess = md5($pair);
					setcookie("sess", $sess, 0, "/");
					header("Location: menu.php");
				}else{
					header("Location: index.php?error=1");
				}
			}else{
				header("Location: index.php?error=1");
			}
		}
	}else{
		header("Location: index.php?error=1");
	}
?>