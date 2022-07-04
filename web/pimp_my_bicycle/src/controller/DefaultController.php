<?php

require_once('model/BikeManager.php');

class DefaultController {

	function home(){
		require('view/shared/home.php');
	}

	function faq(){
		require('view/shared/faq.php');
	}

	function about(){
		require('view/shared/about.php');
	}

}