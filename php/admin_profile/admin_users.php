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
$admin_users_page = new Template("skin/admin_profile/admin_users.html");

//DAO
$factory = new DataLayer(new DB_Connection);
$userDAO = $factory->getUserDAO();

// Controllo se è stato inserito una stringa come filtro
// Se NON è stato passato nessun filtro
if(!isset($_REQUEST["filter_string"])){
    $users = $userDAO->getAllUsers();
}
// Se è stato passato un filtro
else{
    $strings = explode(' ', $_REQUEST['filter_string']);
    $users = $userDAO->getAllUsersByGenericStrings($strings);
}


foreach($users as $user){

    if($user->getId() != $_SESSION["id"]){
        $admin_users_page->setContent("user_id",$user->getId());
        $admin_users_page->setContent("user_name",$user->toString());
        $admin_users_page->setContent("user_email",$user->getEmail());
        $admin_users_page->setContent("user_role",$user->getRole());
        $admin_users_page->setContent("user_registration_date",$user->getRegistrationDate());
    
        $admin_users_page->setContent("user_value", $user->getId());
    }
}

?>