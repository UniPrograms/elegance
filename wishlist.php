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
require "php/profile/wishlist.php";



$homepage = new Template("skin/index.html");

$homepage->setContent("header",$header_page->get());
$homepage->setContent("footer", $footer_page->get());
$homepage->setContent("body",$wishlist_page->get());


$homepage->close();

?>