<?php
// DATABASE
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");
require_once("include/utility/QueryStringBuilder.php");



if(!isset($_SESSION["auth"])){
    header("Location: login.php");
    exit;
}

// Template
$admin_sidebar_page = new Template("skin/admin_profile/admin_sidebar.html");

//DAO
$factory = new DataLayer(new DB_Connection);
$userDAO = $factory->getUserDAO();

$user = $userDAO->getUserById($_SESSION["id"]);
$admin_sidebar_page->setContent("user_name", $user->toString());

// Controllo dell'immagine
if($user->getUrlImage() == null || strlen($user->getUrlImage()) == 0){
    $admin_sidebar_page->setContent("user_image","img/core-img/user.svg");
}
else{
    $admin_sidebar_page->setContent("user_image",$user->getUrlImage());
}


?>