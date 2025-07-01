<?php 

// Templating
require_once("include/template2.inc.php");

// Database
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");

// Page
$register = new Template("skin/login/register.html");

$register->close();

?>