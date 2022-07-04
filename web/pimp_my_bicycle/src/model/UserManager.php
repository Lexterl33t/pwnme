<?php

require_once("Manager.php");
require_once("objects/User.php");

class UserManager extends Manager {

	public function getUsers(){
		$accounts = array();

		$db = $this->dbConnect();
		$accountsReq = $db->query('SELECT * FROM users');
		while ($accountReq = $accountsReq->fetch()) {
			$account = new User($accountReq["id"]);
			$account->pseudo = $accountReq["pseudo"];
			$account->password = $accountReq["password"];

			$accounts[] = $account;
		}
		return $accounts;
	}

	public function getUser($id){
		$db = $this->dbConnect();
	    $req = $db->prepare('SELECT * FROM users WHERE id=?');
	    $req->execute(array(
    		$id
		));
		$accountReq = $req->fetch();

		$account = new User($accountReq["id"]);
		$account->pseudo = $accountReq["pseudo"];
		$account->password = $accountReq["password"];

    	return $account;
	}

	public function createUser($pseudo, $password){
		$hash = password_hash($password, PASSWORD_DEFAULT);
		$db = $this->dbConnect();
	    $req = $db->prepare('INSERT INTO `users` (`pseudo`,`password`) VALUES (:pseudo, :password)');
	    if (strlen($password) <= 1 || strlen($pseudo) <= 1) {
	    	//exception
	    } else {
		    $req->execute(array(
		    	':pseudo' => htmlspecialchars($pseudo),
		    	':password' => $hash
			));
		}
	}


}

