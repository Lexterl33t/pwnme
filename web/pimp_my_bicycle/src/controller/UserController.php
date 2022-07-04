<?php

require_once('model/UserManager.php');
require_once('model/BikeManager.php');
require_once('DefaultController.php');

class UserController extends DefaultController {
	private $userManager;
	private $bikeManager;

	function __construct(){
		$this->userManager = new UserManager();
		$this->bikeManager = new BikeManager();
	}

	function home(){
		$account = $this->userManager->getSelfUser();
		require('view/shared/home.php');
	}

	function admin(){
		$account = $this->userManager->getSelfUser();
		require('view/user/pages/admin.php');
	}

	function login(){
		require('view/guest/pages/login.php');
	}

	function editor(){
		$userBikes = $this->bikeManager->getUserBikes();
		require('view/user/pages/editor.php');
	}

	function bikes(){
		$bikes = $this->bikeManager->getBestBikes();
		require('view/shared/bikes.php');
	}

	function viewBike($id){
		require('view/shared/bike.php');
	}

	function getElements(){
		header('Content-type: application/json');
		echo $this->bikeManager->getElements();
	}

	function getBike($id){
		header('Content-type: application/json');
		echo $this->bikeManager->getBike($id);
	}

	function editBike($id, $build){
		return $this->bikeManager->editBike($id, $build);
	}

	function saveBike($build){
		return $this->bikeManager->saveBike($build);
	}

	function review($id){
		$ownerId = $this->bikeManager->getBikeOwnerId($id);
		if($_SESSION['user_id'] != $ownerId){
			return "You can only review your own bikes";
		}
		try {
			$res = @file_get_contents('http://bot:3000/bike/'.intval($_POST["id"]));
			if(FALSE === $res){
				return "Error during review (should not append, please contact me on Discord (Eteck#3426) CODE: 0";
			} else {
				return $res;
			}
		} catch (\Throwable $th) {
			return "Error during review (should not append, please contact me on Discord (Eteck#3426) CODE: 1";
		}
	}
}