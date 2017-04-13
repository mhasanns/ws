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
					$csrfToken = bin2hex(random_bytes(32));
					file_put_contents('../server/tokens.txt', $sess . ':' . $csrfToken . PHP_EOL, FILE_APPEND);
					header("Location: intro.php");
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