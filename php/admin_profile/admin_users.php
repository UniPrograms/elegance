<?php
// DATABASE
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");
require_once("include/utility/QueryStringBuilder.php");



if(!isset($_SESSION["auth"])){
    // Si rimanda ad una nuova pagina di errore
}

// Template
$admin_users_page = new Template("skin/admin_profile/admin_users.html");

//DAO
$factory = new DataLayer(new DB_Connection);
$userDAO = $factory->getUserDAO();

$users = $userDAO->getUserByRole("UTENTE");

foreach($users as $user){

    $admin_users_page->setContent("user_id",$user->getId());
    $admin_users_page->setContent("user_name",$user->toString());
    $admin_users_page->setContent("user_email",$user->getEmail());
    $admin_users_page->setContent("user_registration_date",$user->getRegistrationDate());


    $admin_users_page->setContent("user_value", $user->getId());

}

?>