<?php
session_start();
// header("Access-Control-Allow-Origin: *");
require_once('controller/ConnectionController.php');

require_once('controller/UserController.php');
require_once('controller/DefaultController.php');

$page = isset($_GET['page']) ? $_GET['page'] : "home";
$action = isset($_GET['action']) ? $_GET['action'] : "list";
$id = isset($_GET['id']) ? $_GET['id'] : "0";
$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : false;


if($userId){
    $userController = new UserController();

    switch ($page) {
        case "preview":
            switch ($action) {
                case "edit":
                    $userController->editor();
                    break;
                case "getElements":
                    $userController->getElements();
                    break;
                case "getBike":
                    $userController->getBike($id);
                    break;
                case "saveBike":
                    if(!isset($_POST["data"])){
                        echo "Missing data";
                        break;
                    }
                    echo $userController->saveBike($_POST["data"]);
                    break;
                case "editBike":
                    if(!isset($_POST["data"])){
                        echo "Missing data";
                        break;
                    }
                    echo $userController->editBike($id,$_POST["data"]);
                    break;
                case "viewBike":
                    $userController->viewBike($id);
                    break;
                default:
                    $userController->editor();
                    break;
            }
            break;
        case "bikes":
            $userController->bikes();
            break;
        case "about":
            $userController->about();
            break;
        case "faq":
            $userController->faq();
            break;
        case "admin":
            $userController->admin();
            break;
        case "sendBike":
            if(!$_POST["id"]){
                echo "Missing id";
                break;
            }
            echo $userController->review($_POST["id"]);
            break;
        default:
            $userController->home();
            break;
    }


} else {
    $defaultController = new DefaultController();
    switch ($page) {
        case "home":
            $defaultController->home();
            break;
        case "faq":
            $defaultController->faq();
            break;
        case "login":
            $connectionController = new ConnectionController();
            $connectionController->login();
            break;
        case "connect":
            $connectionController = new ConnectionController();
            if(!isset($_POST["remember"])){
                $remember = false;
            } else {
                $remember = true;
            }
            $connectionController->connect($_POST["pseudo"],$_POST["password"],$remember);
            break;
        case "register":
            $connectionController = new ConnectionController();
            $connectionController->register();
            break;
        case "create":
            $connectionController = new ConnectionController();
            $connectionController->create($_POST["pseudo"],$_POST["password"]);
            break;
        case "about":
            $defaultController->about();
            break;
        default:
            $connectionController = new ConnectionController();
            $connectionController->register();
            break;
    }
}