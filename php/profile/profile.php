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
$profile_page = $_SESSION["is_admin"] ? new Template("skin/admin_profile/admin_profile.html") : new Template("skin/profile/profile.html");




?>