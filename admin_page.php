<?php 
session_start();


// Templating
require_once("include/template2.inc.php");

// Database
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");

// Page
require "php/home/header.php";
require "php/home/footer.php";
require "php/profile/admin_page.php";



$homepage = new Template("skin/index.html");

$homepage->setContent("header",$header->get());
$homepage->setContent("footer", $footer->get());
$homepage->setContent("body",$admin_page->get());


$homepage->close();

?>