<?php

require_once("Manager.php");

class ConnectionManager extends Manager {

	public function connect($pseudo, $password, $stayConnected){
        $user = $this->getUserFromPseudo($pseudo);

        if($password == "" OR $pseudo == ""){
            return "incorrect input";
        } else if(password_verify($password, $user['password'])){
            $_SESSION['pseudo'] = $pseudo;
            $_SESSION['user_id'] = $user['id'];
            if($stayConnected){
                //Extension de la durée de la session
                $params = session_get_cookie_params();
                setcookie(session_name(), $_COOKIE[session_name()], time() + 60*60*24*30, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
            }
            return true;
        } else {
            return "incorrect input";
        }
	}

	public function createAccount($pseudo, $password){
		if($this->getUserFromPseudo($pseudo)){
			return "account already exists";
		}
		$hash = password_hash($password, PASSWORD_DEFAULT);

		$db = $this->dbConnect();
	    $req = $db->prepare('INSERT INTO `users` (`pseudo`,`password`) VALUES (:pseudo, :password)');
	    if (strlen($password) <= 1 || strlen($pseudo) <= 1) {
	    	return "input len must be > 0";
	    } else {
		    $req->execute(array(
		    	':pseudo' => htmlspecialchars($pseudo),
		    	':password' => $hash
			));
			return true;
		}
	}
}

