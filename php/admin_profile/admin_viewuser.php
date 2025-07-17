<?php
// DATABASE
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");
require_once("include/utility/QueryStringBuilder.php");



if(!isset($_SESSION["auth"])){
    // Si rimanda ad una nuova pagina di errore
}

// Template
$admin_viewuser_page = new Template("skin/admin_profile/admin_viewuser.html");

//DAO
$factory = new DataLayer(new DB_Connection);
$userDAO = $factory->getUserDAO();


$user = $userDAO->getUserById($_REQUEST["user_id"]);

$admin_viewuser_page->setContent("user_id",$user->getId());
$admin_viewuser_page->setContent("user_name",$user->getName());
$admin_viewuser_page->setContent("user_surname",$user->getSurname());
$admin_viewuser_page->setContent("user_email",$user->getEmail());
$admin_viewuser_page->setContent("user_role",$user->getRole());
$admin_viewuser_page->setContent("user_url_image",$user->getImage());
$admin_viewuser_page->setContent("user_registration_date",$user->getRegistrationDate());

?>