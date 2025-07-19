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

// Inizializzo i campi base
$admin_viewuser_page->setContent("user_id",$user->getId());
$admin_viewuser_page->setContent("user_name",$user->getName());
$admin_viewuser_page->setContent("user_surname",$user->getSurname());
$admin_viewuser_page->setContent("user_email",$user->getEmail());
$admin_viewuser_page->setContent("user_role",$user->getRole());
$admin_viewuser_page->setContent("user_phone",$user->getPhoneNumber());
$admin_viewuser_page->setContent("user_registration_date",$user->getRegistrationDate());

// Controllo dell'immagine
if($user->getUrlImage() == null || strlen($user->getUrlImage()) == 0){
    $admin_viewuser_page->setContent("user_image","img/core-img/user.svg");
}
else{
    $admin_viewuser_page->setContent("user_image",$user->getUrlImage());
}

// Setto la select per definire i ruoli utente
$user_roles = ["UTENTE" => "user", 
               "AMMINISTRATORE" => "admin"];

foreach($user_roles as $key => $value){
    $admin_viewuser_page->setContent("user_role_key", $key);
    $admin_viewuser_page->setContent("user_role_value", $value);
   
    // Seleziona automaticamente il ruolo corrente dell'utente
    if($key == $user->getRole()){
        $admin_viewuser_page->setContent("user_role_selected", "selected");
    } else {
        $admin_viewuser_page->setContent("user_role_selected", "");
    }
}


?>