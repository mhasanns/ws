<?php
	ini_set('display_errors',1); 
	error_reporting(E_ALL);
	include('validate.php');
	header("Cache-Control: no-store, no-cache, must-revalidate");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Websocket Test</title>
</head>
<body>
<center>
	<p>While WebSocekt connections can be secure via checking the Origin header as demonstrated <a href="safe.php">here</a>, other techniques can also<br>
	be employed in order to assess the eligibility of the client to access the information in place. In this example, we verify the client's eligibility<br>
	by embedding a CSRF token in the page's source (view the page source to see it), and then sending it with every WebSocekts send() function call and making<br>
	sure it's valid and belongs to the logged in user. Follow the same steps mentioned in the other examples in order to see how it works. You can also click<br>
	the "Filing Attack Page" link in order to take a look at a page that sends a request to obtain the "secret" information with an invalid CSRF token.</p>
	Host: <input type="text" id="host" style="width: 170px;" value="ws://localhost:8000/secret"><br><br>
	<input type="hidden" name="csrfToken" value="<?php include('csrfToken.php');?>">
	<input onclick="connect()" type="submit" value="Connect"/>
	<input onclick="send()" type="submit" value="Show Secret">
	<input id="closeconn" type="submit" value="Disconnect"/>
	<p id="text"></p>
	<br><br><br><br>
	<a href="attackFail2.html">Failing Attack Page</a>
	<br><br>
	<a href="logout.php">Logout</a>
</center>
<script>
	var conn = null;
	var clientClose = false;
	function connect(){
		conn = new WebSocket(host.value); // ws://localhost:8000/secret
		conn.onopen = function () {
			text.innerHTML = "Connected";
		}

		conn.onclose = function(){
			var message = clientClose ? "Connection halted by the client" : "Make sure the server is running";
			clientClose = false;
			conn = null;
			text.innerHTML = "Disconnected: " + message;
		}

		conn.onerror = function (error) {
		  text.innerHTML = 'WebSocket Error: ' + error;
		}

		conn.onmessage = function (e) {
		  text.innerHTML = 'The server said: ' + e.data;
		}

		closeconn.onclick = function(){
			conn.close();
			clientClose = true;
		}
	}

	function send(){
		if(conn == null){
			text.innerHTML = 'Click the "Connect" button first';
			return;
		}
		var csrfToken = document.getElementsByName("csrfToken")[0].value;
		conn.send("getSecretWithToken:"+csrfToken);
	}
</script>
</body>
</html>