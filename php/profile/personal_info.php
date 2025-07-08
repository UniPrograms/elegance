<?php
// DATABASE
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");

// Utility
require_once("include/utility/QueryStringBuilder.php");


// Se non è stato fatto il login
if(!isset($_SESSION['auth'])) {
    header("Location: login.php");
    exit;
}


// DAO 
$factory = new DataLayer(new DB_Connection());
$userDAO = $factory->getUserDAO();
$orderDAO = $factory->getOrderDAO();

// Template
$personal_info_page = new Template("skin/profile/personal_info.html");


$user = $userDAO->getUserById($_SESSION["id"]);

$personal_info_page->setContent("user_email",$user->getEmail());
$personal_info_page->setContent("user_name",$user->getName());
$personal_info_page->setContent("user_surname",$user->getSurname());

?>