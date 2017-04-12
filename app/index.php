<?php
if($_COOKIE['sess']){
	header("Location: websocket.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
</head>
<body>
	<center>
		<h2>Please login</h2>
		<form action="login.php" method="POST">
			Username: <input type="text" name="username">
			Password: <input type="password" name="password">
			<input type="submit" value="Login">
		</form>
		<p id='error'></p>
	</center>
	<script>
		var search = document.location.search.substr(1);
		var id = 0;
		if(search.startsWith('error='))
			id = search.substr(6);
		if(id > 0)
			error.innerHTML = 'Error logging in';
	</script>
</body>
</html>