<?php
	ini_set('display_errors',1); 
	error_reporting(E_ALL);
	include('validate.php');
	header("Cache-Control: no-store, no-cache, must-revalidate");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Attacks Menu</title>
</head>
<body>
	<center>
		<h2>Introduction</h2>
		<p>WebSockets allow developers to open and maintain full-duplix connections with their servers over the HTTP protocol.<br>
		The technology was introduced as part of HTML5, and is not support by all the major browsers. Requests are issued by using<br>
		<strong>ws://</strong> for connections that are opened over HTTP, and <strong>wss://</strong> for connections that are opened over HTTPS, as prefixes of URLS.<br>
		A full resource URL would follow <strong>ws(s)://HOST:PORT/PATH</strong> as a scheme.<br>
		The process starts with the client initiating a WebSockets handshake with the server, which uses the <strong>Sec-WebSocket-Key</strong> header to supply a 16-bit, Base64 encoded<br>
		key, which is in turn Base64 decoded by the server, concatenated with "258EAFA5-E914-47DA-95CA-C5AB0DC85B11", SHA1 hashed, and finally Base64 encoded. The value is then returned <br>as the value of the <strong>Sec-WebSocket-Accept</strong> header, marking the end of the successful handshake process.<br>
		The following are two pages, where the first initiates an unsafe WebSocket handshake that allows for Cross Site WebSocket Hijacking<br>
		attacks to take place, and the second does the same handshake in a safe way by checking the Origin header on the server-side.<br>
		The unsafe example page contains a link to a sample attack page, and the safe example pages contain a links to pages that launch failing attacks.</p>
		<br><br>
		<a href="unsafe.php">Unsafe WebSocket Handshake</a><br><br>
		<a href="safe.php">Safe WebSocket Handshake (via Origin checks)</a><br><br>
		<a href="safe2.php">Safe WebSocket Handshake (via CSRF token checks)</a>
		<br><br><br><br>
		<a href="logout.php">Logout</a>
	</center>
</body>
</html>