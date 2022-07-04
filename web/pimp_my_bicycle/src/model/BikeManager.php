<?php

require_once("model/Manager.php");
require_once("model/objects/Bike.php");

class BikeManager extends Manager {
	
	
	public function getElements(){
		$db = $this->dbConnect();
	    $req = $db->prepare('SELECT * FROM elements');
	    $req->execute();

		$elements = array();
		while ($elementReq = $req->fetch()) {
			$element = array(
				"type" => $elementReq["type"],
				"svg" => $elementReq["svg"]
			);

			$elements[$elementReq["name"]] = $element;
		}
		
    	return json_encode($elements);
	}

	public function getUserBikes(){
		$db = $this->dbConnect();
	    $req = $db->prepare('SELECT * FROM bikes WHERE user_id=?');
	    $req->execute(array(
    		$_SESSION["user_id"]
		));

		$bikes = array();
		while ($bike = $req->fetch()) {
			$bikes[] = new Bike($bike["id"],$bike["user_id"],$bike["data"]);
		}
		return $bikes;
	}

	public function getBikeOwnerId($id){
		$db = $this->dbConnect();
	    $req = $db->prepare('SELECT * FROM bikes WHERE id=?');
	    $req->execute(array(
    		$id
		));
		$bikeReq = $req->fetch();

    	return intval($bikeReq["user_id"]);
	}

	public function isBikeInShop($id){
		$db = $this->dbConnect();
	    $req = $db->prepare('SELECT * FROM bikes WHERE id=?');
	    $req->execute(array(
    		$id
		));
		$bikeReq = $req->fetch();

    	return intval($bikeReq["likes"]) > 0;
	}

	public function getBike($id){
		$db = $this->dbConnect();
	    $req = $db->prepare('SELECT * FROM bikes WHERE id=?');
	    $req->execute(array(
    		$id
		));
		$bikeReq = $req->fetch();
		if($bikeReq['user_id'] == $_SESSION["user_id"] || $_SESSION['pseudo'] === 'admin' || $this->isBikeInShop($id)){
			return json_encode($bikeReq["data"]);
		} else {
			return "This bike doesn't belong to you ! You can preview other bikes only if you're admin";
		}
	}

	public function getBestBikes(){
		$db = $this->dbConnect();
	    $req = $db->prepare('select bikes.id,pseudo, data, likes from bikes join users where likes > 0 and bikes.user_id = users.id order by likes DESC limit 10');
	    $req->execute();

		$bikes = array();
		while ($bike = $req->fetch()) {
			$bikes[] = new Bike($bike["id"],$bike["pseudo"],$bike["data"],$bike["likes"]);
		}
		return $bikes;
	}

	public function saveBike($build){
		$db = $this->dbConnect();
	    $req = $db->prepare('INSERT INTO `bikes` (`user_id`,`data`) VALUES (:user_id, :data)');
		$ok = $req->execute(array(
			':user_id' => $_SESSION["user_id"],
			':data' => $build
		));

		if(!$ok){
			return false;
		}

	    $req = $db->prepare('select id from bikes where user_id=:user_id order by id desc');
	    $req->execute(array(
			':user_id' => $_SESSION["user_id"]
		));

		$bike = $req->fetch();
		return $bike['id'];
	}

	public function editBike($id, $build){
		$db = $this->dbConnect();
	    $req = $db->prepare('SELECT * FROM bikes WHERE id=?');
	    $req->execute(array(
    		$id
		));
		$bikeReq = $req->fetch();
		if($this->isBikeInShop($id)){
			return "You can't edit a bike in shop !";
		}
		if($bikeReq['user_id'] == $_SESSION["user_id"] || $_SESSION['pseudo'] === 'admin'){
			$req = $db->prepare('UPDATE `bikes` SET data = :data WHERE (`id` = :id)');
			$req->execute(array(
				':id' => $id,
				':data' => $build
			));
			return "ok";
		} else {
			return "This bike doesn't belong to you ! You can edit other bikes only if you're admin. note: If the bike is in shop, you can't edit it anymore !";
		}
	}
}