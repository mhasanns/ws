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
	<p>This page contains the same function explained in the <a href="unsafe.php">unsafe example page</a>, but here the function<br>
	is performed in a secure way by checking if the Origin header is valid. Click the "Failing Attack Page" link in order to see how <br>
	an attack page that attempts to do the same attack fails because of the Origin checks performed before transmitting the "secret" information.</p>
	Host: <input type="text" id="host" style="width: 170px;" value="ws://localhost:8000/secret" disabled="disabled"><br><br>
	<input onclick="connect()" type="submit" value="Connect"/>
	<input onclick="send()" type="submit" value="Show Secret">
	<input id="closeconn" type="submit" value="Disconnect"/>
	<p id="text"></p>
	<br><br><br><br>
	<a href="attackFail.html">Failing Attack Page</a>
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
		conn.send("getSecretWithOrigin");
	}
</script>
</body>
</html>