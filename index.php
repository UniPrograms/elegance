<?php 
session_start();

// Templating
require_once("include/template2.inc.php");

// Database
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");

// Page
require "php/home/header.php";
require "php/home/cart_popup.php";
require "php/home/footer.php";
require "php/home/body.php";



$homepage = new Template("skin/index.html");

$homepage->setContent("header",$header->get());
$homepage->setContent("cart_popup",$cart_popup->get());
$homepage->setContent("footer", $footer->get());
$homepage->setContent("body",$body->get());


$homepage->close();

?>