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
	<p>As mentioned in the menu page, the whole process starts with a handshake between the client (the browser) and the server. After the successful<br>
	handshake, a full-duplix connection is maintained between the peers until one of them disconnects. Throughout the connection, clients can send requests<br>
	to the WebSocket server and recieve responses from it. You can try the below buttons in order to further see how things work.<br>
	Start by clicking the "Connect" button. Then, try clicking the "Show Secret" button, which shows a simple message that is returned by the server upon<br>
	recieving the string "getSecret" from a connected client. Finally, close the connection by clicking the "Disconnect" button.<br>
	Click the "Sample Attack Page" link in order to navigate to a sample page that shows how an attacker can exploit this behavior in order to get<br>
	access to data that belongs to other users, in a CSRF-like attack scenario.</p>
	Host: <input type="text" id="host" style="width: 170px;" value="ws://localhost:8000/secret"><br><br>
	<input onclick="connect()" type="submit" value="Connect"/>
	<input onclick="send()" type="submit" value="Show Secret">
	<input id="closeconn" type="submit" value="Disconnect"/>
	<p id="text"></p>
	<br><br><br><br>
	<a href="attack.html">Sample Attack Page</a>
	<br><br>
	<a href="logout.php">Logout</a>
</center>
<script>
	var conn = null;
	function connect(){
		conn = new WebSocket(host.value); // ws://localhost:8000/secret
		conn.onopen = function () {
			text.innerHTML = "Connected";
		}

		conn.onclose = function(){
			text.innerHTML = "Connection closed";
		}

		conn.onerror = function (error) {
		  text.innerHTML = 'WebSocket Error: ' + error;
		}

		conn.onmessage = function (e) {
		  text.innerHTML = 'The server said: ' + e.data;
		}

		closeconn.onclick = function(){
			conn.close();
		}
	}

	function send(){
		if(conn == null){
			text.innerHTML = 'Click the "Connect" button first';
			return;
		}
		conn.send("getSecret");
	}
</script>
</body>
</html>