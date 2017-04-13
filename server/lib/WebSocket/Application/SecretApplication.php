<?php

namespace WebSocket\Application;

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
	public function onConnect($client)
    {
		$id = $client->getClientId();
        $this->_clients[$id] = $client;
        $this->server = $client->server;
        $this->origin = $client->origin;
        $this->isAuth = $this->checkCookie($client);
    }

    public function onDisconnect($client)
    {
        $id = $client->getClientId();		
		unset($this->_clients[$id]);     
    }

    public function onData($data, $client)
    {	
    	if($data === 'getSecret'){
			$info = "Invalid session cookie, no secret to show.";
			if($this->isAuth)
				$info = "Hacking = Happiness";
			$this->sendSecret($client, $info);
			$this->server->log("Received: $data, responded with $info");
		}

		if($data === 'getSecretSafely'){
			$info = "Invalid session cookie or Origin header.";
			if($this->isAuth && $this->server->checkOrigin($this->origin)){
				$info = "Valid Origin header, Hacking = Happiness";
			}
			$this->sendSecret($client, $info);
			$this->server->log("Received: $data, responded with $info");
		}
    }
	
	public function sendSecret($client, $info){
		if(count($this->_clients) < 1)
		{
			return false;
		}
		$client->send($info);
	}

	public function checkCookie($client){
		$cookie = $client->sessCookie;
		$flag = false;
		$creds = fopen('creds.txt', 'r');
		while(!feof($creds)) {
			$pair = fgets($creds);
			if($cookie == md5($pair))
				$flag = true;
		}
		return $flag;
	}

}