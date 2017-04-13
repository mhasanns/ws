<?php
namespace WebSocket\Application;
// error_reporting(E_ALL);
// ini_set('display_errors',1); 

/**
 * Websocket-Server demo and test application.
 * 
 * @author Simon Samtleben <web@lemmingzshadow.net>
 */
class SecretApplication extends Application
{
    private $_clients = array();
    private $isAuth = false;
    private $server = null;
    private $origin = '';
    private $cookie = '';

	public function onConnect($client)
    {
		$id = $client->getClientId();
        $this->_clients[$id] = $client;
        $this->server = $client->server;
        $this->origin = $client->origin;
        $this->cookie = $client->sessCookie;
        $this->isAuth = $this->checkCookie($client);
    }

    public function onDisconnect($client)
    {
        $id = $client->getClientId();		
		unset($this->_clients[$id]);     
    }

    public function onData($data, $client)
    {	
    	// echo $data;
    	$arr = explode(":", $data);
    	if($arr[0] === $data){
	    	if($data === 'getSecret'){
				$this->getSecret($data, $client);
				return;
			}

			if($data === 'getSecretWithOrigin'){
				$this->getSecretWithOrigin($data, $client);
				return;
			}
		}else{
			$action = $arr[0];
			$csrfToken = $arr[1];
			if($action === 'getSecretWithToken'){
				$this->getSecretWithToken($data, $csrfToken, $client);
			}
		}
    }

    public function getSecret($data, $client){
    	$info = "Invalid session cookie, no secret to show";
		if($this->isAuth)
			$info = "Hacking = Happiness";
		$this->sendSecret($client, $info);
		$this->server->log("Received: $data, responded with $info");
    }

    public function getSecretWithOrigin($data, $client){
    	$info = "Invalid session cookie or Origin header";
		if($this->isAuth && $this->server->checkOrigin($this->origin)){
			$info = "Valid Origin header, Hacking = Happiness";
		}
		$this->sendSecret($client, $info);
		$this->server->log("Received: $data, responded with $info");
    }
	
    public function getSecretWithToken($data, $csrfToken, $client){
    	$info = "Invalid session cookie or CSRF token";
    	if ($this->isAuth && $this->checkToken($csrfToken, $client)){
    		$info = "Valid CSRF Token, Hacking = Happiness";
    	}
    	$this->sendSecret($client, $info);
		// $this->server->log("Received: $data, responded with $info");
    }

	public function sendSecret($client, $info){
		if(count($this->_clients) < 1)
		{
			return false;
		}
		$client->send($info);
	}

	public function checkCookie($client){
		$flag = false;
		$creds = fopen('creds.txt', 'r');
		while(!feof($creds)) {
			$pair = fgets($creds);
			if($this->cookie == md5($pair))
				$flag = true;
		}
		return $flag;
	}

	public function checkToken($csrfToken, $client){
    	$tokens = fopen('tokens.txt', 'r');
		while(!feof($tokens)) {
			$pair = fgets($tokens);
			// echo $this->cookie . ":" . trim(explode(":", $pair)[1]);
			if($this->cookie === trim(explode(":", $pair)[0])){
				if($csrfToken === trim(explode(":", $pair)[1])){
					return true;
				}
				return false;
			}
		}
		return false;
	}

}