<?php 
session_start();

// Templating
require_once("include/template2.inc.php");

// Database
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");

require "php/login/register.php";



$register_page->close();

?>