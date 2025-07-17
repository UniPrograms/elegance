<?php 
session_start();

// Templating
require_once("include/template2.inc.php");

// Database
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");

// Page
require "php/admin_profile/admin_sidebar.php";
require "php/admin_profile/admin_orders.php";



$homepage = new Template("skin/admin_profile/admin_index.html");

// Titolo della pagina
$homepage->setContent("title_page", "orders");

$homepage->setContent("sidebar",$admin_sidebar_page->get());
$homepage->setContent("center", $admin_orders_page->get());


$homepage->close();

?>