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

// Template
$change_password_page = new Template("skin/profile/change_password.html");