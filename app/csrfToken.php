<?php
if(isset($_COOKIE['sess']))
	$sess = $_COOKIE['sess'];
else{
	echo "NoToken";
	return;
}
$tokens = fopen('../server/tokens.txt', 'r');
while(!feof($tokens)) {
	$pair = fgets($tokens);
	if($sess === explode(":", $pair)[0]){
		echo trim(explode(":", $pair)[1]);
		return;
	}
}
echo "NoToken";
?>