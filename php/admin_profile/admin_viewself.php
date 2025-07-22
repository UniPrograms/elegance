<?php
// DATABASE
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");
require_once("include/utility/QueryStringBuilder.php");



if(!isset($_SESSION["auth"])){
    // Si rimanda ad una nuova pagina di errore
}



// Template
$admin_viewself_page = new Template("skin/admin_profile/admin_viewself.html");

//DAO
$factory = new DataLayer(new DB_Connection);
$userDAO = $factory->getUserDAO();


$user = $userDAO->getUserById($_SESSION["id"]);

// Inizializzo i campi base
$admin_viewself_page->setContent("user_id",$user->getId());
$admin_viewself_page->setContent("user_name",$user->getName());
$admin_viewself_page->setContent("user_surname",$user->getSurname());
$admin_viewself_page->setContent("user_email",$user->getEmail());
$admin_viewself_page->setContent("user_role",$user->getRole());
$admin_viewself_page->setContent("user_phone",trim($user->getPhoneNumber()));
$admin_viewself_page->setContent("user_registration_date",$user->getRegistrationDate());

// Controllo dell'immagine
if($user->getUrlImage() == null || strlen($user->getUrlImage()) == 0){
    $admin_viewself_page->setContent("user_image","img/core-img/user.svg");
}
else{
    $admin_viewself_page->setContent("user_image",$user->getUrlImage());
}

?>