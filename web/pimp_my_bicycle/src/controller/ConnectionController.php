<?php

require_once('model/ConnectionManager.php');

class ConnectionController {

	private $connectionManager;

	function __construct(){
		$this->connectionManager = new ConnectionManager();
	}

	function login(){
		require('view/guest/pages/login.php');
	}

	function register(){
		require('view/guest/pages/register.php');
	}

	function connect($pseudo, $password, $remember){
		$connected = $this->connectionManager->connect($pseudo, $password, $remember);
        if($connected === true){
			header('Location: /');
		} else {
			header('Location: /?page=login&error='.$connected);
		}
	}

	function create($pseudo, $password){
		$created = $this->connectionManager->createAccount($pseudo, $password);
        if($created === true){
            $this->connect($pseudo, $password, true);
        } else {
            header('Location: /?page=register&error='.$created);
        }
        
	}

}